<?php

/**
 * Description of OS
 *
 * @author Daniel
 */
//zend
include_once "s_p/model/Saom_spModel.php";
include_once 's_p/model/DBAgendaInstal_sp.php';

include_once 's_p/controller/Instalacao_sp.php';
include_once 's_p/model/DBTipoEquipamento_sp.php';
include_once 's_p/model/DBEquipamento_sp.php';
include_once 's_p/model/DBUsuario_sp.php';
include_once 'helpers.class.php';


class AgendaInstal_sp extends Controller
{
	protected $tplDir = 's_p/tampletes/agenda_instal';

	function __construct()
	{

		parent::__construct();
		$this->DB = new DBAgendaInstal_sp();
		$this->DBOS = new DBOS_SP();
		$this->Instalacao_sp = new Instalacao_sp();
		$this->DBTipoEquipamento = new DBTipoEquipamento_sp();
		$this->DBEquipamentosp = new DBEquipamento_sp();
		$this->DBUsuario = new DBUsuario_sp();
		$this->Helper = new Helpers();

	}

	public function create()
	{


		if (empty($this->dadosP['form']))
		{

			if ( ! empty($this->dadosP['param'])){


				$tipo_equipamentos = $this->TipoEquipamentos_sp->listaEquipamentosODU();

				$this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());

				$equipamentos = $this->Equipamento_sp->fetchAll();

				$listaautocomplete = array();//
				foreach( $equipamentos->toArray() as $equipamento_unico )
					$listaautocomplete[] = $equipamento_unico['sno'];//
				$listaautocomplete = implode(',',$listaautocomplete);

				$this->smarty->assign('tipoEquipamento',$tipo_equipamentos);
				$this->smarty->assign('listaautocomplete',$listaautocomplete);
				$this->smarty->assign('param',$this->dadosP['param']);
				$this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
				$this->smarty->display("{$this->tplDir}/create.tpl");

			}
		}
		else
		{


			$this->getSaom_spAtual();

			$this->verificaPresencaDeData();

			$this->verificaExistenciaAgendamentoReferenteAoAtual();

			$this->verificaDataAgendamento();

			//this->verificaExistenciaNumeroSerieOdu();
				
			//$this->verificaMac();
			
			$this->trataParaTeste();

			$return = $this->DB->create($this->dadosP['form']);
// 			print_b($return,true);
			
			if( isset($return['erros']) )
			//if( isset($this->DB->query($sql)) )
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
				//envia email de notificação
				$sendMail = $this->DB->getSendMail();
				//print_b($sendMail,true);
				if(array_key_exists('create', $sendMail))
				{
					$this->DB->setPrkValue($return);
					//print_b($this->DB->view(),true);
					$this->DB->setEmailMsg($this->DB->view());
					$sendMail = $this->DB->getSendMail();
					
					$arrReturn['msg']    = $sendMail;
					die_json($arrReturn);
					
					sendMailAgendamento( $sendMail['create']['assunto'] , $sendMail['create']['msg'] );
				}
			}
			die_json($arrReturn);
		}
	}

	function cancelConfirmAgendSp()
	{
		$this->DB->setPrkValue($this->dadosP['id']);
		if($this->DB->cancelConfirmAgendSp()){

			$arrReturn['status']  = 'ok';
			$arrReturn['msg']     = 'Cancelamento efetuado com sucesso!';
		}
		else{

			$arrReturn['status']  = 'erro';
			$arrReturn['msg']     = 'Erro ao efetuar o cancelamento!';
		}
		die_json($arrReturn);
	}

	public function liste()
	{
		$this->smarty->display("{$this->tplDir}/list.tpl");
	}

	public function listeFonte()
	{
		// Get posted data
		if (isset($_POST['page']))
			$page = $_POST['page'];
		
		if (isset($_POST['sortname']))
			$sortname = $_POST['sortname'];
		
		if (isset($_POST['sortorder']))
			$sortorder = $_POST['sortorder'];
		
		if (isset($_POST['qtype']))
			$qtype = $_POST['qtype'];
		
		if (isset($_POST['query']))
			$query = $_POST['query'];
		
		if (isset($_POST['rp']))
			$rp = $_POST['rp'];
		
		// Setup sort and search SQL using posted data
		$sortSql = "order by $sortname $sortorder";
		$searchSql = ($qtype != '' && $query != '') ? "where $qtype LIKE '%$query%'" : '';

		//RETIRA DA LISTA INSTALACOES DE OUTRAS EMPRESAS (quando não é vodanet atualmente)
		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			if($searchSql!='')
			$searchSql .= " AND empresa_filtro = {$_SESSION['login']['empresas_idempresas']}";
			else
			$searchSql .= " WHERE empresa_filtro = {$_SESSION['login']['empresas_idempresas']}";
		}
			
		//FILTRA PELO SAOM
		$saom = ($_SESSION['SAOM'] == 'SP')?'2':'1';//ajusta pada o id do saom
		if($saom != 2){
			if($searchSql!='')
			$searchSql .= " AND saom = '{$saom}'";
			else
			$searchSql .= " WHERE saom = '{$saom}'";
		}

		//echo json_encode($searchSql); exit;
			
		// Get total count of records
		$sql = "
			select count(*) as total
			from listagendamentossp
			{$searchSql}
		";
		$result = $this->DB->queryDados($sql);
		$total = $result[0]['total'];

		// Setup paging SQL
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";

		// Return JSON data
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();

		$sql = "
			select *
			from listagendamentossp
			{$searchSql}
			{$sortSql}
			{$limitSql}
		";
		$results = $this->DB->queryDados($sql);

		foreach( $results AS $row )
		{
			$data['rows'][] = array(
				'id' => $row['idagenda_instal'],
				'cell' => array(
					$row['os_numos'],
					utf8_decode(utf8_encode($row['os_cidade'])),
					$row['data'],
					utf8_decode(utf8_encode($row['contato'])),
					$row['tel'],
					utf8_decode(utf8_encode($row['confirm'])),
					utf8_decode(utf8_encode($row['empresa']))
					)
			);
		}
		//print_b($data,true);

		echo json_encode($data);
	}

	public function listeFonteFiltro()
	{
		// Get posted data
		if (isset($_POST['page']))
			$page = $_POST['page'];
		
		if (isset($_POST['sortname']))
			$sortname = $_POST['sortname'];
		
		if (isset($_POST['sortorder']))
			$sortorder = $_POST['sortorder'];
		
		if (isset($_POST['qtype']))
			$qtype = $_POST['qtype'];
		
		if (isset($_POST['query']))
			$query = $_POST['query'];
		
		if (isset($_POST['rp']))
			$rp = $_POST['rp'];

		// Setup sort and search SQL using posted data
		$sortSql = "order by $sortname $sortorder";
		$searchSql = ($query != '') ? "where $query" : '';

		//RETIRA DA LISTA INSTALACOES DE OUTRAS EMPRESAS (quando não é vodanet atualmente)
		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			if($searchSql!='')
			$searchSql .= " AND empresa_filtro = {$_SESSION['login']['empresas_idempresas']}";
			else
			$searchSql .= " WHERE empresa_filtro = {$_SESSION['login']['empresas_idempresas']}";
		}
			
		//FILTRA PELO SAOM
		$saom = ($_SESSION['SAOM'] == 'SP')?2:1;//ajusta pada o id do saom^
		if($saom != 2){
			if($searchSql!='')
			$searchSql .= " AND saom = '{$saom}'";
			else
			$searchSql .= " WHERE saom = '{$saom}'";
		}
			
		//exit($searchSql);

		// Get total count of records
		$sql = "
			select count(*) as total
			from listagendamentossp
			{$searchSql}
		";
		$result = $this->DB->queryDados($sql);
		$total = $result[0]['total'];
		//echo json_encode($sql); exit;

		// Setup paging SQL
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";

		// Return JSON data
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();

		$sql = "
			select *
			from listagendamentossp
			{$searchSql}
			{$sortSql}
			{$limitSql}
		";
		$results = $this->DB->queryDados($sql);

		foreach( $results AS $row )
		{
			$data['rows'][] = array(
				'id' => $row['idagenda_instal'],
				'cell' => array(
					$row['os_numos'],
					utf8_decode(utf8_encode($row['os_cidade'])),
					$row['data'],
					utf8_decode(utf8_encode($row['contato'])),
					$row['tel'],
					utf8_decode(utf8_encode($row['confirm'])),
					utf8_decode(utf8_encode($row['empresa']))
					)
			);
		}
		//print_b($data,true);

		echo json_encode($data);
	}

	public function view()
	{
		if ( ! empty($this->dadosP['param']))
		{
			$this->DB->setPrkValue($this->dadosP['param']);
			$dados = $this->DB->view();
			//print_b($dados,true);

			//TODO: resolver isso no relacionamento
			if($dados['odu']!='')
			{
				$this->DBTipoEquipamento->setPrkValue($dados['odu']);
				$dados['rel']['tipo_equipamentos_sp'] = $this->DBTipoEquipamento->view();
			}
			if($dados['usuario_confirm']!='')
			{
				//TODO: fazer oop rápido
				$sql = "SELECT u.nome FROM usuarios u WHERE u.idusuarios = '{$dados['usuario_confirm']}'";
				$usuario = $this->DB->queryDados($sql);
				$dados['rel']['usuario_confirm'] = $usuario[0];
			}

			//print_b($dados,true);
			
			$dados['data_temp'] = $this->muda_formato_data( $dados['data_temp'] );

			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/view.tpl");
		}
	}

	public function edit()
	{

		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{

			$this->DB->setPrkValue($this->dadosP['param']);
			$dados = $this->DB->view();
			//TODO: resolver isso no relacionamento
			if($dados['odu']!='')
			{
				$this->DBTipoEquipamento->setPrkValue($dados['odu']);
				$dados['rel']['tipo_equipamentos_sp'] = $this->DBTipoEquipamento->view();

			}
			//TODO: resolver esse problema nos relacionamentos
			$tipoEquipamento = $this->DBTipoEquipamento->liste();


//			$arrReturn['msg']     = $tipoEquipamento;
//			die_json($arrReturn);

			//BUSCA LISTA DE AUTOCOMPLETE - NSODU EQUIPAMENTOS
			//LISTA DE EQUIPAMENTOS
			$this->DBEquipamentosp->setSelect(' mac ');

//            $listaEquipamentos = $this->DBEquipamentosp->liste();

			//LISTA DO AUTOCOMPLETE
//			$listaautocomplete = array();
//			for($i=0;$i<count($listaEquipamentos);$i++)
//			{
//				if($listaEquipamentos[$i]['mac']!='')
//				{
//					$listaautocomplete[] = $listaEquipamentos[$i]['mac'];
//				}
//			}
//			$listaautocomplete = implode(',',$listaautocomplete);

			$equipamentos = $this->Equipamento_sp->fetchAll();

			$listaautocomplete = array();//
			foreach( $equipamentos->toArray() as $equipamento_unico )
				$listaautocomplete[] = $equipamento_unico['sno'];//
			$listaautocomplete = implode(',',$listaautocomplete);
//

			$this->smarty->assign('listaautocomplete',$listaautocomplete);

			$this->smarty->assign('tipoEquipamento',$tipoEquipamento);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/edit.tpl");
		}
		elseif ( ! empty($this->dadosP['form']))
		{
			//carrega objeto agendamento
			$agendamento = $this->DB->carrega($this->dadosP['form']['idagenda_instal_sp']);

			//carrega objeto os
			$os = $this->DBOS->carrega($agendamento['os_sp_idos']);
			//print_b($os,true);

			//pra edição de agendamento (não confirmação)
			if( !isset($this->dadosP['form']['nomeForm']) )
			{
				//VERIFICA PRESENCA DE DATA
				if(
				(
				!isset($this->dadosP['form']['para_teste']) ||
				$this->dadosP['form']['para_teste'] == '') &&
				(
				$this->dadosP['form']['data'] == '' ||
				$this->dadosP['form']['data'] == '0000-00-00'
				)
				)
				{
					$arrReturn['status']  = 'erro';
					$arrReturn['msg']     = 'É necessário informar uma data quando não é teste!';
					die_json($arrReturn);
				}

				//SE É TESTE O MAC É OBRIGATÓRIO
				if(
				isset($this->dadosP['form']['para_teste']) &&
				$this->dadosP['form']['para_teste'] == 'on'
				)
				{
					if($this->dadosP['form']['mac'] == '')
					{
						$arrReturn['status']  = 'erro';
						$arrReturn['msg']     = 'Em caso de teste o número MAC é obrigatório.';
						die_json($arrReturn);
					}
				}
					
				//GRAVA USUARIO QUE CONFIRMA AGENDAMENTO
				if($this->dadosP['form']['confirm']==1)
				{
					if( !$this->DB->setaUsuarioQueConfirmou($this->dadosP['form']['idagenda_instal_sp'],$_SESSION['login']['idusuarios']) )
					{
						$arrReturn['status'] = 'erro';
						$arrReturn['msg']    = 'Erro ao gravar Usuário que confirmou agendamento, tente novamente mais tarde.';
						reportarErro('Erro em Confirmação de agendamento.','Houve um erro ao tentar gravar usuário que confrirmou agendamento.<br/>AgendaInstal_sp/Edit');
						die_json($arrReturn);
					}
				}

			}// fim de edição de agendamento

			//tratamento para 'para_teste'
			if( !isset($this->dadosP['form']['para_teste']) || empty($this->dadosP['form']['para_teste']) )
			{
				unset($this->dadosP['form']['para_teste']);
			}
			else //QUANDO É TESTE NÃO DEVE TER DATA
			{
				$this->dadosP['form']['data'] = NULL;
			}

			$return  = $this->DB->edit($this->dadosP['form']);

			if(count($return['erros']))
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			else
			{
				
				// ###########################################
				
					//pra edição de agendamento (não confirmação)
					if( !isset($this->dadosP['form']['nomeForm']) )
					{
						//enviar email sobre modificação de data
						if(
						isset($this->dadosP['form']['data']) &&
						!empty($this->dadosP['form']['data']) &&
						( !isset($this->dadosP['form']['para_teste']) || empty($this->dadosP['form']['para_teste']) )
						)
						{
							//QUANDO TEM DATA É RETIRADO O TESTE
							//unset($this->dadosP['form']['para_teste']);
		
							$dataNova = $this->Helper->data_br_us($this->dadosP['form']['data']);
							if( $dataNova != $agendamento['data'] )
							{
								$assunto = "Modificação da Data do Agendamento da OS {$os['numOS']}";
		
								$to = array(
				    						"agenda.prodemge@vodanet-telecom.com"
				    						);
		
				    						$msg = "Houve uma modificação da Data do Agendamento da OS {$os['numOS']}, a data antiga era {$agendamento['data']} e a data nova é {$dataNova}.
												<br/><br/>
												Atenciosamente,<br/>
												<br/>
												Vodanet Telecomunicações Ltda.<br/>
												http://www.vodanet-telecom.com<br/>
												<img src='http://www.vodanet-telecom.com/SAOM_PRODEMGE/imagens/logo_vodanet.jpg' />";
				    						
				    						//$msg = "Termo de aceite da Instalação {$instalacao['nome']} enviado.";
				    						//TODO: existem ocasiões onde o email não é enviado --"

										/*	
				    						if(!$this->Helper->sendMail($assunto,$to,$msg,''))
				    						{
				    							$arrReturn['status'] = 'erro';
				    							$arrReturn['msg']    = 'Erro ao enviar email para informar Modificação da Data do Agendamento.';
				    							die_json($arrReturn);
				    						}
										*/

							}
						}
		
						//enviar email sobre modificação do mac
						//print_b($this->dadosP['form']['mac'].' - '.$agendamento['mac']);
						if(isset($this->dadosP['form']['mac']))
						{
							if( $this->dadosP['form']['mac'] != $agendamento['mac'] )
							{
								$assunto = "Modificação do MAC do Agendamento da OS {$os['numOS']}";
								$to = array(
				    						//"noc.sp@vodanet-telecom.com",
				    						"agenda.prodemge@vodanet-telecom.com",
				    						"hernan@vodanet-telecom.com"
				    						);
				    						$msg = "Houve uma modificação do MAC do Agendamento da OS {$os['numOS']}, o mac antigo era {$agendamento['mac']} e o mac novo é {$this->dadosP['form']['mac']}.
										<br/><br/>
										Atenciosamente,<br/>
										<br/>
										Vodanet Telecomunicações Ltda.<br/>
										http://www.vodanet-telecom.com<br/>
										<img src='http://www.vodanet-telecom.com/SAOM_PRODEMGE/public/imagens/logo_vodanet.jpg' />";
				    						//$msg = "Termo de aceite da Instalação {$instalacao['nome']} enviado.";

										
										/*
				    						if(!$this->Helper->sendMail($assunto,$to,$msg,''))
				    						{
				    							$arrReturn['status'] = 'erro';
				    							$arrReturn['msg']    = 'Erro ao enviar email para informar modificação do MAC.';
				    							die_json($arrReturn);
				    						}
										*/

							}
						}
						//print_b($this->dadosP['form'],true);
					}
				
				// ###########################################
				
				
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Edição realizada com sucesso!';

				$this->DB->setPrkValue($this->dadosP['form']['idagenda_instal_sp']);
				//print_b($this->DB->view(),true);
				$infoMail = $this->DB->view();
				$usuarioBusca = $this->DBUsuario->liste("idusuarios = '{$infoMail['usuario_confirm']}'");
				$infoMail['usuario_confirm'] = $usuarioBusca[0]['nome'];
					
				//EMAIL DE RETORNO
				if($this->dadosP['form']['confirm']==1)
				{
					$this->DB->setEmailMsgEdit($infoMail);
					$sendMail = $this->DB->getSendMailEdit();
					//sendMailAgendamento($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
				}
				if($this->dadosP['form']['emailExtra']==1)
				{
					$this->DB->setEmailMsgEdit2($infoMail);
					$sendMail = $this->DB->getSendMailEdit();
					//sendMailAgendamento($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
				}
				//TODO: mandar email quando o agendamento tem data modificada
				//TODO: mandar email quando mudar mac
				//EMAIL DE RETORNO - FIM
			}
			die_json($arrReturn);
		}
	}

	public function listaHome()
	{
		$dataAtual = date('Y-m-d');
		$sql = "
    		SELECT 
    			o.numOS AS os,
    			a.idagenda_instal_sp AS idagenda_instal_sp,
    			a.data AS data
    		FROM agenda_instal_sp a
    		LEFT JOIN os_sp o ON o.idos = a.os_sp_idos
    		WHERE a.data LIKE '%{$dataAtual}%';
    	";
			
		$lista = $this->DB->queryDados($sql);
		$total = count($lista);

		echo "<ul>";
		echo "<li>Total: {$total}</li>";
		for($i = 0 ; $i < count($lista) ; $i++)
		{?>
<li><a href="#"
	onclick="javascript:
    					getAjaxForm('AgendaInstal_sp/view','conteudo',{param:<?=$lista[$i]['idagenda_instal_sp']?>,ajax:1})
    				">OS <?=$lista[$i]['os']?> </a>
</li>
		<?php
		}
		echo "</ul>";
	}


	public function verificaPresencaDeData()
	{
		if(
		(
		!isset( $this->dadosP['form']['para_teste'] ) ||
		$this->dadosP['form']['para_teste'] == ''
		) &&
		( $this->dadosP['form']['data'] == '' )
		)
		{
			$arrReturn['status']  = 'erro';
			$arrReturn['msg']     = 'É necessário informar uma data quando não é teste!';
			die_json($arrReturn);
		}
	}


	public function verificaExistenciaAgendamentoReferenteAoAtual()
	{
		$sql = "
    		SELECT idagenda_instal_sp
    		FROM agenda_instal_sp
    		WHERE os_sp_idos = '{$this->dadosP['form']['os_sp_idos']}'
    	";
		$buscaDePreExistenciaDeAgendamento = $this->DB->queryDados($sql);
		if( count($buscaDePreExistenciaDeAgendamento) > 0 )
		{
			$arrReturn['status']  = 'erro';
			$arrReturn['msg']     = 'Já existe Agendamento para essa OS!';
			die_json($arrReturn);
		}
	}


	public function verificaDataAgendamento()
	{
		$dataFormatada = $this->Helper->data_br_us($this->dadosP['form']['data']);
		if(
		$dataFormatada < date('Y-m-d') &&
		(
		!isset($this->dadosP['form']['para_teste']) ||
		$this->dadosP['form']['para_teste']==''
		)
		)
		{
			$arrReturn['status']  = 'erro';
			$arrReturn['msg']     = 'Data de agendamento não pode ser anterior ao dia atual.';
			die_json($arrReturn);
		}
	}


	public function verificaExistenciaNumeroSerieOdu()
	{
		$sql = "
			SELECT a.idagenda_instal_sp
			FROM agenda_instal_sp a
			WHERE a.nsodu = '{$this->dadosP['form']['nsodu']}' 
		";
		$verificacaoNsodu = $this->DB->queryDados($sql);
		if(count($verificacaoNsodu)>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = "Não pode ser cadastrado outro agendamento com Número de Série ODU já utilizado.";
			die_json($arrReturn);
		}
	}


	public function verificaMac()
	{
		$sql = "SELECT IF(
			                (SELECT count(*) FROM agenda_instal_sp WHERE mac = '{$this->dadosP['form']['mac']}')>0,
			                (SELECT IF(
			                            (SELECT os_status_idos_status FROM os_sp WHERE idos =
			                                (SELECT os_sp_idos FROM agenda_instal_sp WHERE mac = '{$this->dadosP['form']['mac']}')
			                            )=2,
			                            'disponivel',
			                            'ocupado')
			                          ),
			                'disponivel'
			            ) AS resultado;";
		$macBuscado = $this->DB->queryDados($sql);
		if($macBuscado[0]['resultado']=='ocupado')
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = "Número MAC de equipamento em uso.";
			die_json($arrReturn);
		}
	}
	
	public function trataParaTeste()
	{
		if( 
			!isset($this->dadosP['form']['para_teste']) || 
			empty($this->dadosP['form']['para_teste']) 
		)
			unset($this->dadosP['form']['para_teste']);
	}
	
	// codigo feito para corrigir problema da hostgator com funcoes smarty //TODO: acompanhar suporte de problema
	private function muda_formato_data( $data )
	{
		$data2 = explode( ' ' , $data );
		$data3 = explode('-',$data2[0]);
		return $data3[2].'-'.$data3[1].'-'.$data3[0].' '.$data2[1];


	}

	public function resgataODUdeNSODUAgenda()
	{

		if($this->dadosP['nsodu'] != ''){

			$odu = $this->Equipamento_sp->buscaODUdeNSODU( $this->dadosP['nsodu'] );
			$odutipo = $odu[0]['tipo_equipamentos_sp_idtipo_equipamentos_sp'];

			if($odu[0]['status'] == "1"){
				echo  $odutipo;
			}else if($odu[0]['status'] == "2"){
				echo 1;
			}else if($odutipo == null){
				echo 0;exit;
			}
		}else{
			echo '';
		}
	}


}

?>

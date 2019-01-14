<?php
include_once 's_p/model/DBInstalacao_sp.php';
include_once 's_p/model/DBOS_SP.php';
include_once 's_p/model/DBUsuario_sp.php';
include_once "s_p/model/DBEmpresas_sp.php";
include_once 's_p/model/DBEquipamento_sp.php';
include_once 's_p/model/DBTipoEquipamento_sp.php';
include_once 's_p/model/DBAgendaInstal_sp.php';
include_once 'helpers.class.php';

include_once "s_p/controller/Equipamento_sp.php";
include_once "s_p/controller/Log_sp.php";

require_once "s_p/controller/Comissionamento_sp.php";



class Instalacao_sp extends Controller
{
	protected $tplDir = 's_p/tampletes/instalacao';
	protected $instalacao;
	protected $os;
	protected $resultInicioComiss;
	protected $cumprimento;

	//instancias zend
	//protected $Instalacao;
	//protected $OS;
	protected $Equipamento;

	function __construct()
	{
		parent::__construct();

		$this->DB = new DBInstalacao_sp();
		$this->DBOS = new DBOS_SP();
		$this->DBUsuario = new DBUsuario_sp();
		$this->DBEmpresas = new DBEmpresas_sp();
		$this->DBEquipamento = new DBEquipamento_sp();
		$this->DBTipoEquipamento = new DBTipoEquipamento_sp();
		$this->DBInstalacao = new DBInstalacao_sp();
		$this->DBAgendaInstal = new DBAgendaInstal_sp();

		$this->Log_sp = new Log_sp();
	}

	/*
     * Método criado para gerar dados da Instalação/VSAT automaticamente para o formulário
     */
	function getDadosInstalSp()
	{
		$this->DBOS->setPrkValue($this->dadosP['id']);
		$arr = $this->DBOS->view();

		$emp = $arr['rel']['empresas']['prefixo'];
		$nome = strtoupper($emp).'-';

		$nomeVsat = normaliza($arr['cidade']);
//        $arrReturn['iplan'] = $arr['iplan'];
		$arrReturn['mascaraLan'] = $arr['mascaraLan'];
		$arrReturn['mac'] = $arr['rel']['agenda_instal_sp']['mac'];
		$arrReturn['nome'] = $nome;
		$arrReturn['agenda_instal'] = $arr['rel']['agenda_instal_sp'];

		//cuida de pre existencia
		$array = array(
			'campo'=>'nome',
			'valor'=>$arrReturn['nome']
		);

		$this->setDadosV($array);

		$verificacao = $this->verificaPreExistenciaDado();

		if($verificacao==true)
		{
			$contador = 2;
			for($i=0;$i<2;$i++)
			{
				$novoNome = $arrReturn['nome'].'-'.$contador;
				//echo $novoNome;exit(' :fim');
				$array = array(
					'campo'=>'nome',
					'valor'=>$novoNome
				);
				$this->setDadosV($array);
				//VERIFICA EXISTENCIA
				$verificacao = $this->verificaPreExistenciaDado();
				if(!$verificacao)
				{
					$arrReturn['nome'] = $novoNome;
					break;
				}
				else
				{
					$contador++;
				}
				$i=0;
			}
		}
		//print_b($arrReturn,true);
		die_json($arrReturn);exit;
	}
	/*
     * Método para gerar nome da vsat antes da vsat criada (cópia do 'getDadosInstal')
     */
	public function verNomeVsat()
	{
		//TODO: fazer uma copia do metodo anterior para gerar o nome da vsat automaticamente
	}


	public function create()
	{
		if (empty($this->dadosP['form']))
		{
			if ( ! empty($this->dadosP['param']))
				$this->smarty->assign('param',$this->dadosP['param']);
			$this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
			$this->smarty->display("{$this->tplDir}/new.tpl");
		}
		else
		{

			//OS
			$os = $this->DBOS->carrega($this->dadosP['form']['os_sp_idos']);
//        		print_r($this->dadosP['form']['os_sp_idos']);exit;
			//print_b($os,true);
			//INSTALACAO
			//TODO: carregar instalacao

			//busca saom

			$saom = new Saom_spModel( $this->adapter->getAdapterZend() );
			$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
			$this->dadosP['form']['saom'] = $saom_row->id_saom;

			// evita 2 instalacoes para mesma os
			$this->verificaExistenciaInstalacaoReferenteOsAtual();


			if( $this->dadosP['form']['os_ipdvb'] != "" || $this->dadosP['form']['os_iplan'] != "") {
				$this->atualizaIpdvbDeOS();
				$this->atualizaIpLanOsspServico();


			} else
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = "Ipdvb e Iplan sao obrigatórios.";
				die_json($arrReturn);
			}

			$formPerguntasComissionamento = $this->separaFormPerguntasComissionamento();


			if($formPerguntasComissionamento['test_sl2000'] == ""){
				$arrReturn['msg']    = "Sat Link deve ser testado!";
				die_json($arrReturn);

			}


			$formOS = $this->separaFormOS();
			$this->atualizaOS( $formOS );

			$idInstalacao = $this->DBInstalacao->create($this->dadosP['form']);

			if($idInstalacao)
			{
				$formPerguntasComissionamento = $this->adicionaIdInstalacaoCriadaAoFormPerguntasComissionamento( $formPerguntasComissionamento , $idInstalacao );

				$this->PerguntasComissionamento_sp->create( $formPerguntasComissionamento );

				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Cadastro efetuado com sucessooooo!';

				$this->emailDeNotificacaoParaNoc();
			}
			else
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			die_json($arrReturn);
		}
	}

	private function separaFormPerguntasComissionamento()
	{
		$formPerguntas = array();

		$formPerguntas['test_sl2000'] = ( isset($this->dadosP['form']['test_sl2000']) )?1:0;

		if( isset($this->dadosP['form']['test_sl2000']) )
			unset($this->dadosP['form']['test_sl2000']);

		return $formPerguntas;
	}

	private function adicionaIdInstalacaoCriadaAoFormPerguntasComissionamento( $form , $idInstalacao )
	{
		$form['id_instalacoes'] = $idInstalacao;
		return $form;
	}

	private function separaFormOS()
	{
		$formOS = array();

		$formOS['idos'] = $this->dadosP['form']['os_sp_idos'];

		$formOS['ipdvb'] = ( isset($this->dadosP['form']['os_ipdvb']) )?$this->dadosP['form']['os_ipdvb']:0;
		if( isset($this->dadosP['form']['os_ipdvb']) ) unset($this->dadosP['form']['os_ipdvb']);

		return $formOS;
	}

	private function atualizaOS( $formOS )
	{
		$where = " idos = '{$formOS['idos']}' ";
		unset($formOS['idos']);

		$this->OSSP->update( $formOS , $where );
	}

	public function liste()
	{
		$this->smarty->display("{$this->tplDir}/list.tpl");
	}

	public function listeFonte()
	{
		// Get posted data
		if (isset($_POST['page']))
		{
			$page = $_POST['page'];
		}
		if (isset($_POST['sortname']))
		{
			$sortname = $_POST['sortname'];
		}
		if (isset($_POST['sortorder']))
		{
			$sortorder = $_POST['sortorder'];
		}
		if (isset($_POST['qtype']))
		{
			$qtype = $_POST['qtype'];
		}
		if (isset($_POST['query']))
		{
			$query = $_POST['query'];
		}
		if (isset($_POST['rp']))
		{
			$rp = $_POST['rp'];
		}

		// Setup sort and search SQL using posted data
		$sortSql = "order by $sortname $sortorder";
		$searchSql = ($qtype != '' && $query != '') ? "where $qtype LIKE '%$query%'" : '';

		//RETIRA DA LISTA INSTALACOES DE OUTRAS EMPRESAS (quando não é vodanet atualmente)
		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			if($searchSql!='')
				$searchSql .= " AND empresa = {$_SESSION['login']['empresas_idempresas']}";
			else
				$searchSql .= " where empresa = {$_SESSION['login']['empresas_idempresas']}";
		}

		//FILTRA PELO SAOM
		$saom = ($_SESSION['SAOM'] == 'SP')?'2':'1';//ajusta pada o id do saom
		if($saom != 2){
			if($searchSql!='')
				$searchSql .= " AND saom = '{$saom}'";
			else
				$searchSql .= " WHERE saom = '{$saom}'";
		}

		// Get total count of records
		$sql = "select count(*) as total
					from listinstalacoessp
					{$searchSql}";
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
			from listinstalacoessp
			{$searchSql}
			{$sortSql}
			{$limitSql}
		";
		//echo json_encode($sql);exit;
		$results = $this->DB->queryDados($sql);

		foreach( $results AS $row )
		{
			$data['rows'][] = array(
				'id' => $row['idinstalacoes'],
				'cell' => array(
					$row['numos'],
					utf8_decode(utf8_encode($row['nome'])),
					$row['mac'],
					$row['cod_anatel'],
					utf8_decode(utf8_encode($row['status'])),
					utf8_decode(utf8_encode($row['comiss'])),
					$row['aceite_prodemge']
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
		{
			$page = $_POST['page'];
		}
		if (isset($_POST['sortname']))
		{
			$sortname = $_POST['sortname'];
		}
		if (isset($_POST['sortorder']))
		{
			$sortorder = $_POST['sortorder'];
		}
		if (isset($_POST['qtype']))
		{
			$qtype = $_POST['qtype'];
		}
		if (isset($_POST['query']))
		{
			$query = $_POST['query'];
		}
		if (isset($_POST['rp']))
		{
			$rp = $_POST['rp'];
		}

		// Setup sort and search SQL using posted data
		$sortSql = "order by $sortname $sortorder";
		$searchSql = ($query != '') ? "where $query" : '';

		//RETIRA DA LISTA INSTALACOES DE OUTRAS EMPRESAS (quando não é vodanet atualmente)
		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			if($searchSql!='')
				$searchSql .= " AND empresa = {$_SESSION['login']['empresas_idempresas']}";
			else
				$searchSql .= " WHERE empresa = {$_SESSION['login']['empresas_idempresas']}";
		}

		//FILTRA PELO SAOM
		$saom = ($_SESSION['SAOM'] == 'SP')?'2':'1';//ajusta pada o id do saom
		if($saom != 2){
			if($searchSql!='')
				$searchSql .= " AND saom = '{$saom}'";
			else
				$searchSql .= " WHERE saom = '{$saom}'";
		}

		// Get total count of records
		$sql = "select count(*) as total
					from listinstalacoessp
					{$searchSql}";
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

		$sql = "select *
				from listinstalacoessp
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		//echo json_encode($sql);exit;
		$results = $this->DB->queryDados($sql);

		foreach( $results AS $row )
		{
			$data['rows'][] = array(
				'id' => $row['idinstalacoes'],
				'cell' => array(
					$row['numos'],
					utf8_decode(utf8_encode($row['nome'])),
					$row['mac'],
					$row['cod_anatel'],
					utf8_decode(utf8_encode($row['status'])),
					$row['comiss'],
					$row['aceite_prodemge']
				)
			);
		}
		//print_b($data,true);

		echo json_encode($data);
	}

	/*
     * Método gerado para gerar Instalação/VSAT automaticamente com a confirmação do agendamento
     */
	function geraInstalacaoDeOS($idOS)
	{
		$this->DBOS->setPrkValue($idOS);
		$arr = $this->DBOS->view();

		$form = array(
			'nome'=> 'VIVO-PER-'.strtoupper($arr['identificador']),
			'mac'=>$arr['rel']['agenda_instal_sp']['mac'],
			'iplan'=>$arr['iplan'],
			'mascaraLan'=>$arr['mascaraLan'],
			'agenda_instal'=>$arr['rel']['agenda_instal_sp']
		);

		if($this->DB->create($form))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	// ### COMISSIONAMENTOS
	public function getDadosComiss()
	{
		$os = new DBOS_SP();
		$os->setPrkValue($this->dadosP['id']);
		$arr = $os->view();
		die_json($arr);
	}

	public function comiss_edit()
	{
		//TODO: resgata informações e disponibiliza em formulário no comiss_edit.tpl
		//para edição.
		$this->DB->setPrkValue($this->dadosP['param']);
		$dados = $this->DB->view();

		//TODO: arrumar isso no relacionamento
		if($dados['create_user_comiss']!='')
		{
			$this->DBUsuario->setPrkValue($dados['create_user_comiss']);
			$dados['rel']['create_user_comiss'] = $this->DBUsuario->view();
		}
		if($dados['last_user_comiss']!='')
		{
			$this->DBUsuario->setPrkValue($dados['last_user_comiss']);
			$dados['rel']['last_user_comiss'] = $this->DBUsuario->view();
		}
		//print_b($dados,true);

		//TODO: arrumar esse relacionamento
		$tipoEquipamentos = $this->DBTipoEquipamento->liste(" nome LIKE '%4033%' OR nome LIKE '%4035%' ");
		//print_b($tipoEquipamentos,true);

		//BUSCA LISTA DE AUTOCOMPLETE - NSODU EQUIPAMENTOS
		//LISTA DE INSTALACOES
		$this->DBEquipamento->setSelect('idequipamentos, sno');
		$listaEquipamentos = $this->DBEquipamento->liste();
		$this->smarty->assign('listaEquipamentos',$listaEquipamentos);

		//LISTA DO AUTOCOMPLETE
		$listaautocomplete = array();
		for($i=0;$i<count($listaEquipamentos);$i++)
		{
			$listaautocomplete[] = $listaEquipamentos[$i]['sno'];
		}
		$listaautocomplete = implode(',',$listaautocomplete);
		//print_b($listaautocomplete,true);
		$this->smarty->assign('listaautocomplete',$listaautocomplete);

		$agora = date('Y-m-d H:i:s');

		//TRATAMENTO DO 'comiss'
		if($dados['comiss']==1)
		{
			if($dados['test_e_termo_aceite']==1)
			{
				$dados['comiss'] = 'Finalizado';
			}
			else
			{
				$dados['comiss'] = 'Em Andamento';
			}
		}
		else
		{
			$dados['comiss'] = 'Não';
		}
		//--
		//print_b($dados,true);

		$this->smarty->assign('tipoEquipamentos',$tipoEquipamentos);
		$this->smarty->assign('agora',$agora);
		$this->smarty->assign('session',$_SESSION);
		$this->smarty->assign('obj',$dados);
		$this->smarty->display("{$this->tplDir}/comiss_edit.tpl");
	}
	// ### COMISSIONAMENTOS - fim

	public function countPendShapper()
	{
		$total['result'] = $this->DB->countPendShapper();
		die_json($total);
	}

	public function countPendWNMS()
	{
		$total['result'] = $this->DB->countPendWNMS();
		die_json($total);
	}

	public function countInc()
	{
		$total['result'] = $this->DB->countInc();
		die_json($total);
	}

	public function countComiss()
	{
		$total['result'] = $this->DB->countComiss();
		die_json($total);
	}

	public function termo($param)
	{
		/**
		 * biblioteca mpdf: http://mpdf1.com/manual/
		 *
		 * TODO: fazer o caso de teste da geração do termo de aceite
		 */
		include('class_aux/PDF.php');
		$pdf = new PDF();

		$this->DB->setPrkValue($param);
		$termoAtual = $this->DB->view();

		//solicitante
		$solicitante = $termoAtual['rel']['os_sp']['orgao'];
		//data
		$data = $this->DB->bdToData($termoAtual['rel']['os_sp']['dataSolicitacao']);
		//NOC/Operadora
		$nocOperadora = $termoAtual['rel']['os_sp']['operadora'];
		//Operadora/Cliente
		$operadoraCliente = $termoAtual['rel']['os_sp']['nomeSolicitante']; /*revisar*/
		//GRE/PROEMGE
		$greProemge = $termoAtual['rel']['os_sp']['operadora'];/*sem dado disponível*/
		//Responsável/Cliente
		$responsavelCliente = $termoAtual['rel']['os_sp']['contato'];
		//Consórcio
		$consorcio = 'STM/Vodanet';
		//VSAT ID
		$vsatId = $termoAtual['nome'];
		//Portal Kbps
		$portalKbps = $termoAtual['rel']['os_sp']['velDownload'];
		//Plataforma
		$plataforma = 'VSAT';
		//Imagens
		$img1 = $termoAtual['img_down_up'];
		$img2 = $termoAtual['img_ping'];
		$img3 = $termoAtual['img_intranet'];
		$vetorConteudo = array(
			'solicitante'=>$solicitante,//solicitante
			'data'=>$data,//data
			'nocOperadora'=>$nocOperadora,//NOC/Operadora
			'operadoraCliente'=>$operadoraCliente,//Operadora/Cliente
			'greProemge'=>$greProemge,//GRE/PROEMGE
			'responsavelCliente'=>$responsavelCliente,//Responsavel/Cliente
			'consorcio'=>$consorcio,//Consorcio - solicitante?
			'vsatId'=>$vsatId,//VSAT ID
			'portalKbps'=>$portalKbps,//Portal Kbps
			'plataforma'=>$plataforma,//Plataforma
			'img1'=>$img1,//Imagem 1
			'img2'=>$img2,//Imagem 2
			'img3'=>$img3//Imagem 3
		);
		$this->smarty->assign('obj',$vetorConteudo);

		$html = $this->smarty->fetch("{$this->tplDir}/termo_aceite.tpl");
		$pdf->setHtml($html);
		$pdf->output();

	}

	//function que sobrescreve a padrao
	public function edit()
	{
		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))//FORMULARIO
		{
			$this->Instalacao_sp->setidinstalacoes_sp( $this->dadosP['param'] );
			$this->Instalacao_sp->getInstalacao();
			$dados = $this->Instalacao_sp->getinstalacaoArray();

			$dados = $this->mesclaPerguntasComissionamentoComDadosInstalacao( $dados );
			$dados = $this->mesclaDadosOsComDadosInstalacao( $dados );

			//BUSCA lista tipo_equipamentos
			$tipoEquipamentos = $this->DBTipoEquipamento->liste();
			//print_b($tipoEquipamentos,true);

			$this->smarty->assign('tipoEquipamentos',$tipoEquipamentos);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/edit.tpl");
		}
		elseif ( ! empty($this->dadosP['form']))//SUBMIT
		{

			$where = 'os_sp_idos ='. $this->dadosP['form']['os_sp_idos'];
			$nsoduAgenda = $this->DBAgendaInstal->liste($where );

//			if($this->dadosP['form']['nsodu'] != $nsoduAgenda[0]['odu']){
//				$arrReturn['msg']    = "O Campo Numero de Serie do ODU Nao corresponde com do Agendamento";
//				die_json($arrReturn);
//
//			}


			// perguntas comissionamentos
			$formPerguntasComissionamento = $this->separaFormParaInstalacoesEPerguntas();

			// separa dados instalacao
			$idinstalacao = $this->dadosP['form']['idinstalacoes_sp'];
			unset($this->dadosP['form']['idinstalacoes_sp']);

			// resgata array instalacao
			$this->Instalacao_sp->setidinstalacoes_sp( $idinstalacao );
			$this->Instalacao_sp->getInstalacao();
			$instalacao = $this->Instalacao_sp->getinstalacaoArray();

			//VERIFICACAO PARA ENVIO DE EMAIL
			if($instalacao['create_user_comiss']=='')
			{
				$avisaInicio = 1;
			}

			//TODO: fazer um método para preparar statement do que tem por ser modificado,
			//		e com isso fazer uma atualização com somente uma requisição no banco.

			//Tratamento de 'justificativa_mod_data_aceite'
			if( isset($this->dadosP['form']['justificativa_mod_data_aceite']) )
			{
				$textoJustificativaNovo = $instalacao['justificativa_mod_data_aceite'];
				$textoJustificativaNovo .= "<br/><br/>".nl2br($this->dadosP['form']['justificativa_mod_data_aceite']);
				$textoJustificativaNovo .= "<br/>".$_SESSION['login']['nome']." - ".date('d/m/Y H:i:s');

				$this->dadosP['form']['justificativa_mod_data_aceite'] = $textoJustificativaNovo;
			}



			//TODO: arrumar isso
			//ATUALIZA NA TABELA OS
			if( $this->dadosP['form']['os_iplan'] != "" )
			{
				$sql = "UPDATE os_sp SET iplan = '{$this->dadosP['form']['os_iplan']}'
	        				WHERE idos = '{$this->dadosP['form']['os_sp_idos']}'";
//            $arrReturn['msg']= 'teste';
//            die_json($arrReturn);
				if(!$this->DB->query($sql))
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg']    = "Erro ao autalizar iplan.";
					die_json($arrReturn);
				}
			}
//            $arrReturn['msg']= 'teste1';
//            die_json($arrReturn);
			unset( $this->dadosP['form']['os_iplan'] );

			if( isset($this->dadosP['form']['os_ipdvb']) )
			{
				if( $this->dadosP['form']['os_ipdvb'] != "" )
				{
					$sql = "UPDATE os_sp SET ipdvb = '{$this->dadosP['form']['os_ipdvb']}'
	        				WHERE idos = '{$this->dadosP['form']['os_sp_idos']}'";
					if(!$this->DB->query($sql))
					{
						$arrReturn['status'] = 'erro';
						$arrReturn['msg']    = "Erro ao autalizar ipdvb.";
						die_json($arrReturn);
					}
				}
				else
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg']    = "Ipdvb é um campo obrigatório.";
					die_json($arrReturn);
				}
			}
			unset( $this->dadosP['form']['os_ipdvb'] );

			$this->DBInstalacao->setPrkValue($idinstalacao);
			//EDITA INSTALACAO {INSTALACAO}
			if( !$this->DBInstalacao->edit( $this->dadosP['form'] , " idinstalacoes_sp = '{$idinstalacao}' " ) ) //com erros

			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = "Dados da instalação não atualizados, eles já podem estar atualizados.";
				die_json($arrReturn);
			}



			$respostaAtualizacaoPerguntas = $this->PerguntasComissionamento_sp->atualizaPerguntasPelaInstalacao( $formPerguntasComissionamento );
			if( isset($dados_modificados['status']) && $respostaAtualizacaoPerguntas == false )
				die_json($dados_modificados);

			//EMAILS
			//EMAIL DE RETORNO (para a confirmação da instalação)
			if(isset($this->dadosP['form']['confirm']) && $this->dadosP['form']['confirm']==1)
			{
				$sendMail = $this->DB->getSendMailEdit();
				if(array_key_exists('edit', $sendMail))
				{
					$this->DB->setPrkValue($return);
					$this->DB->setEmailMsgEdit($this->DB->view());
					$sendMail = $this->DB->getSendMailEdit();
					sendMail($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
				}
			}
			//EMAIL DE RETORNO - FIM

			//EMAIL DE RETORNO (para confirmacao aceite da PROEMGE)
			if( isset($this->dadosP['form']['data_aceite']) && $this->dadosP['form']['data_aceite']!='' )
			{
				//email enviado para usuarios 27 (Cesar) e 13 (Alex)
				//TODO: arrumar isso
				$sql = "SELECT email FROM usuarios WHERE idusuarios = '27'";
				$email1 = $this->DB->queryDados($sql);
				$sql = "SELECT email FROM usuarios WHERE idusuarios = '13'";
				$email2 = $this->DB->queryDados($sql);
				$emailsTo = array(
					$email1[0]['email']//,
					//$email2[0]['email']
				);

				//dados para emails
				if( $instalacao['data_aceite']=='' || $instalacao['data_aceite']=='NULL' )
				{
					$assunto = "SAOM - Data de Aceite Cadastrada - {$instalacao['nome']}";
					$justificativa = "";
				}
				else
				{
					$assunto = "SAOM - Data de Aceite Modificada - {$instalacao['nome']}";
					$justificativa = "Justificativas:<br/>".$this->dadosP['form']['justificativa_mod_data_aceite'];
				}
				$msg = "Acaba de ser aplicada a data de aceite {$this->dadosP['form']['data_aceite']}
			            			para a Instalação {$instalacao['nome']}.
			            			<br/><br/>
			            			".$justificativa."
			            			<br/><br/>
			            			Vodanet Telecomunicações Ltda.<br/>
									http://www.vodanet-telecom.com<br/>
									<img src='http://vodanet-telecom.com/public/imagens/logo_vodanet.jpg' />";

				$this->Helpers->sendMail($assunto,$emailsTo,$msg,'');
			}
			//EMAIL DE RETORNO - FIM
			//EMAILS - fim

			$arrReturn['status']  = 'ok';
			$arrReturn['msg']     = 'Edição realizada com sucesso!';
			die_json($arrReturn);
		}
	}

	private function mesclaDadosOsComDadosInstalacao( $dados )
	{

		$this->OSSP->setidos( new Integer($dados['os_sp_idos']) );

		$this->OSSP->getOS();


		$arrayOS = array();
		foreach( $this->OSSP->getosArray() as $chave => $atributo )
			$arrayOS[ 'os_'.$chave ] = $atributo;

		$dados = array_merge( $dados , $arrayOS );


		return $dados;
	}

	protected function mesclaPerguntasComissionamentoComDadosInstalacao( $dados )
	{

		$this->PerguntasComissionamento_sp->getPerguntasComissionamentoPelaInstalacao( $dados['idinstalacoes_sp'] );
		$listaPeguntas = $this->PerguntasComissionamento_sp->getperguntasArray();
//         $arrReturn['msg']     = $listaPeguntas;
//         die_json($arrReturn);

		foreach ( $listaPeguntas[0] as $chave => $campo )
			$dados[ $chave ] = $campo;

		return $dados;
	}

	protected function separaFormParaInstalacoesEPerguntas()
	{
		$formPerguntas = array();

		$formPerguntas['id_instalacoes'] = $this->dadosP['form']['idinstalacoes_sp'];

		$formPerguntas['test_sl2000'] = ( isset($this->dadosP['form']['test_sl2000']) )?$this->dadosP['form']['test_sl2000']:0;
		if( isset($this->dadosP['form']['test_sl2000']) )
			unset($this->dadosP['form']['test_sl2000']);

		$formPerguntas['autocomiss'] = ( isset($this->dadosP['form']['autocomiss']) )?$this->dadosP['form']['autocomiss']:0;
		if( isset($this->dadosP['form']['autocomiss']) )
			unset($this->dadosP['form']['autocomiss']);

		$formPerguntas['test_software'] = ( isset($this->dadosP['form']['test_software']) )?$this->dadosP['form']['test_software']:0;
		if( isset($this->dadosP['form']['test_software']) )
			unset($this->dadosP['form']['test_software']);

		$formPerguntas['test_antena'] = ( isset($this->dadosP['form']['test_antena']) )?$this->dadosP['form']['test_antena']:0;
		if( isset($this->dadosP['form']['test_antena']) )
			unset($this->dadosP['form']['test_antena']);

		$formPerguntas['test_buc'] = ( isset($this->dadosP['form']['test_buc']) )?$this->dadosP['form']['test_buc']:0;
		if( isset($this->dadosP['form']['test_buc']) )
			unset($this->dadosP['form']['test_buc']);

		$formPerguntas['test_tx'] = ( isset($this->dadosP['form']['test_tx']) )?$this->dadosP['form']['test_tx']:0;
		if( isset($this->dadosP['form']['test_tx']) )
			unset($this->dadosP['form']['test_tx']);

		$formPerguntas['test_calibrate'] = ( isset($this->dadosP['form']['test_calibrate']) )?$this->dadosP['form']['test_calibrate']:0;
		if( isset($this->dadosP['form']['test_calibrate']) )
			unset($this->dadosP['form']['test_calibrate']);

		$formPerguntas['test_cabo'] = ( isset($this->dadosP['form']['test_cabo']) )?$this->dadosP['form']['test_cabo']:0;
		if( isset($this->dadosP['form']['test_cabo']) )
			unset($this->dadosP['form']['test_cabo']);

		$formPerguntas['test_clima'] = ( isset($this->dadosP['form']['test_clima']) )?$this->dadosP['form']['test_clima']:0;
		if( isset($this->dadosP['form']['test_clima']) )
			unset($this->dadosP['form']['test_clima']);

//	    $formPerguntas['test_prtg'] = ( isset($this->dadosP['form']['test_prtg']) )?$this->dadosP['form']['test_prtg']:0;
//	    if( isset($this->dadosP['form']['test_prtg']) )
//	        unset($this->dadosP['form']['test_prtg']);

		$formPerguntas['test_info_rx_tx'] = ( isset($this->dadosP['form']['test_info_rx_tx']) )?$this->dadosP['form']['test_info_rx_tx']:0;
		if( isset($this->dadosP['form']['test_info_rx_tx']) )
			unset($this->dadosP['form']['test_info_rx_tx']);

		$formPerguntas['test_f_termo_aceite'] = ( isset($this->dadosP['form']['test_f_termo_aceite']) )?$this->dadosP['form']['test_f_termo_aceite']:0;
		if( isset($this->dadosP['form']['test_f_termo_aceite']) )
			unset($this->dadosP['form']['test_f_termo_aceite']);

//	    $formPerguntas['test_notificacao_inicio'] = ( isset($this->dadosP['form']['test_notificacao_inicio']) )?$this->dadosP['form']['test_notificacao_inicio']:0;
//	    if( isset($this->dadosP['form']['test_notificacao_inicio']) )
//	        unset($this->dadosP['form']['test_notificacao_inicio']);

		// --

		$formPerguntas['conectores_crimpados'] = ( isset($this->dadosP['form']['conectores_crimpados']) )?$this->dadosP['form']['conectores_crimpados']:0;
		if( isset($this->dadosP['form']['conectores_crimpados']) )
			unset($this->dadosP['form']['conectores_crimpados']);

		$formPerguntas['conectores_odu_isolados'] = ( isset($this->dadosP['form']['conectores_odu_isolados']) )?$this->dadosP['form']['conectores_odu_isolados']:0;
		if( isset($this->dadosP['form']['conectores_odu_isolados']) )
			unset($this->dadosP['form']['conectores_odu_isolados']);

		$formPerguntas['antena_travada'] = ( isset($this->dadosP['form']['antena_travada']) )?$this->dadosP['form']['antena_travada']:0;
		if( isset($this->dadosP['form']['antena_travada']) )
			unset($this->dadosP['form']['antena_travada']);

		$formPerguntas['confirmacao_endereco_instalacao'] = ( isset($this->dadosP['form']['confirmacao_endereco_instalacao']) )?$this->dadosP['form']['confirmacao_endereco_instalacao']:0;
		if( isset($this->dadosP['form']['confirmacao_endereco_instalacao']) )
			unset($this->dadosP['form']['confirmacao_endereco_instalacao']);

		return $formPerguntas;
	}


	/*
     * EDITA A DATA DE COMISSIONAMENTO
     */
	public function edit_data_comiss()
	{
		$where = " idinstalacoes_sp = '{$this->dadosP['param']}' ";
		$dados = $this->Instalacao_sp->fetchRow( $where )->toArray();

//		echo die_json($dados);

		if($dados['data_aceite']!='')
			$dados['data_aceite'] = $this->Helpers->data_us_br($dados['data_aceite']);

		else
			$dados['data_aceite'] = 'vazio';

		//TODO: bloquear aplicação de data de aceite sem termo de aceite
		if( $dados['termo_aceite'] == '' )
			exit("<div class='alert alert-error'>Para aplicar Data e Aceite é necessário que Comissionamento tenha Termo de Aceite.</div>");

		$this->smarty->assign('obj',$dados);
		$this->smarty->display("{$this->tplDir}/edit_data_comiss.tpl");
	}

	public function edit_data_aceite()
	{
		//TODO: registrar log
//     	$where = " idinstalacoes_sp = '{$this->dadosP['form']['idinstalacoes_sp']}' ";
		$this->DBInstalacao->setPrkValue($this->dadosP['form']['idinstalacoes_sp']);

//		echo die_json($this->dadosP['form']);

		unset($this->dadosP['form']['os_sp_idos']);
		unset($this->dadosP['form']['data_aceite_original']);
		unset($this->dadosP['form']['idinstalacoes_sp']);

//     	$this->dadosP['form']['data_aceite'] = $this->Helpers->data_br_us($this->dadosP['form']['data_aceite']);

		if( $this->DBInstalacao->edit( $this->dadosP['form']) )
		{
			$arrReturn['status'] = 'ok';
			$arrReturn['msg']    = "Data modificada com sucesso.";
			die_json($arrReturn);
		}
		else
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = "Erro ao autalizar iplan.";
			die_json($arrReturn);
		}
	}

	public function buscaNomeVsat($idos)
	{
		$this->DBOS->setPrkValue($idos);//id da os
		$arr = $this->DBOS->view();
		$nomeVsat = normaliza($arr['cidade']);
		$arrReturn['nome'] = strtoupper(substr($nomeVsat,0,2).substr($nomeVsat,-2)).'-'.strtoupper($arr['identificador']);

		die_json($arrReturn['nome']);exit;
	}

	public function gravaDataFim()
	{
		$idinstalacoes = $_POST['idinstalacoes_sp'];
		$data_final = date('Y-m-d H:i:s');
		$sql = "
    		UPDATE instalacoes_sp
    		SET data_final_comiss =
    			IF(
    				(data_final_comiss IS NULL OR data_final_comiss = '0000-00-00 00:00:00'),
    				'{$data_final}',
    				data_final_comiss
    			  )
    		WHERE idinstalacoes_sp = '{$idinstalacoes}'
    	";
		$this->DB->query($sql);
	}

	public function view_instalacao()
	{
		$this->DB->setPrkValue($this->dadosP['param']);
		$dados = $this->DB->view();

//echo die_json($dados['rel']['os_sp']);

		//BUSCA lista tipo_equipamentos
		$tipoEquipamentos = $this->DBTipoEquipamento->liste();
		//print_b($tipoEquipamentos,true);

		$this->smarty->assign('tipoEquipamentos',$tipoEquipamentos);
		$this->smarty->assign('obj',$dados);
		$this->smarty->display("{$this->tplDir}/view_instalacao.tpl");
	}


	// ---------------------------------------------------------
	// ----------------- TRATAMENTO DE OS ----------------------
	// ---------------------------------------------------------

	public function verificaExistenciaInstalacaoReferenteOsAtual(){
		$sql = "SELECT idinstalacoes_sp FROM instalacoes_sp WHERE os_sp_idos = '{$this->dadosP['form']['os_sp_idos']}' ";
		$buscaDePreExistenciaDeInstalacao = $this->DB->queryDados($sql);
		if( count($buscaDePreExistenciaDeInstalacao) > 0 )
		{
			$arrReturn['status']  = 'erro';
			$arrReturn['msg']     = 'Já existe Vsat dessa OS!';
			die_json($arrReturn);
		}
	}

	// ---------------------------------------------------------
	// ----------------- ATUALIZA IPDVB OS ---------------------
	// ---------------------------------------------------------

	public function atualizaIpdvbDeOS()
	{
		$sql = "
   			UPDATE os_sp SET iplan = '{$this->dadosP['form']['os_iplan']}', ipdvb = '{$this->dadosP['form']['os_ipdvb']}'
        			WHERE idos = '{$this->dadosP['form']['os_sp_idos']}'";

		if(!$this->DB->query($sql))
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = "Erro ao autalizar ipdvb.";
			die_json($arrReturn);
		}
	}
	public function atualizaIpLanOsspServico()
	{

		$sql = "SELECT id, os_sp_idos FROM os_sp_servicos WHERE os_sp_idos = '{$this->dadosP['form']['os_sp_idos']}' ORDER BY id ASC ";
		$os_sp_servicos =  $this->DB->queryDados($sql);

		$sql = "
   			UPDATE os_sp_servicos SET iplan = '{$this->dadosP['form']['os_iplan']}'
        			WHERE id = '{$os_sp_servicos[0]['id']}'";

		if(!$this->DB->query($sql))
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = "Erro ao autalizar iplan da Os Serviços.";
			die_json($arrReturn);
		}
	}

	// ---------------------------------------------------------
	// ----------------- EMAILS --------------------------------
	// ---------------------------------------------------------

	public function emailDeNotificacaoParaNoc()
	{
		$sendMail = $this->DB->getSendMail();
		//die_r($sendMail);
		if(array_key_exists('create', $sendMail))
		{
			$this->DB->setPrkValue($return);
			$this->DB->setEmailMsg($this->DB->view());
			$sendMail = $this->DB->getSendMail();

			sendMail($sendMail['create']['assunto'], $sendMail['create']['msg']);
		}
	}



	// ---------------------------------------------------------------------
	// ------ MEDIDA PARA REENVIAR EMAIL DE INICIO DE COMISSIONAMENTO ------
	// ---------------------------------------------------------------------

	public function reenviarEmailInicioAtivacao()
	{
		$where = " idinstalacoes_sp = '{$this->dadosP['instalacao']}' ";
		$instalacao = $this->Instalacao_sp->fetchRow( $where );
		$this->instalacao = $instalacao->toArray();

		$where = " idos = '{$instalacao->os_sp_idos}' ";
		$os = $this->OSSP->fetchRow( $where );
		$this->os = $os->toArray();

		$this->emailInicioComissionamento();

		$resposta = explode('|',$this->resultInicioComiss);

		echo $resposta[0];exit;
	}


	// --------------------------------------------------------------------
	// ------- ENVIO DE EMAIL CONFIRMACAO INSTALACAO ----------------------
	// --------------------------------------------------------------------

	public function envia_email_confirmando_instalacao()
	{
		$sendMail = $this->DB->getSendMailEdit();
		if( array_key_exists( 'edit' , $sendMail ) )
		{
			$this->DB->setPrkValue($return);
			$this->DB->setEmailMsgEdit($this->DB->view());
			$sendMail = $this->DB->getSendMailEdit();
			sendMail($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
		}
	}



	// --------------------------------------------------------------------
	// ------- UPLOAD DE Termo de Aceite ----------------------------------
	// --------------------------------------------------------------------

	public function uploadTermo()
	{
		//print_b($this->dadosF,true);

		if( $this->uploadImg( $this->dadosP['id'] , $this->dadosF , 'public/imagens/instalacoes_sp/' ) )
		{
			//$this->envia_email_confirmando_instalacao();

			die('<div class="tdGreen">Arquivo anexado com sucesso.</div>');
		}
		else
			die('<div class="tdRed">Erro ao anexar arquivo.</div>');
	}

	public function uploadImg( $idinstalacoes , $form , $pasta )
	{


		if( !empty($form['termo_aceite']) )
		{
			$move = move_uploaded_file( $form['termo_aceite']['tmp_name'] , $pasta.$form['termo_aceite']['name'] );

			if ( $move )
				$data = array(
					'termo_aceite' => $pasta.$form['termo_aceite']['name']
				);
		}

		$where = " idinstalacoes_sp = '{$idinstalacoes}' ";

		$termo = $this->Instalacao_sp->update( $data , $where );


		return $termo;
	}
}

?>

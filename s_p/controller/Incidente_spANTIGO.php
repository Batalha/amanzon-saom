<?php

/**
 * Description of Incidente
 *
 * @author Daniel
 *
 *
 * -- INCIDENTES --
 *
 * Status:
 * 	1.Aberto
 * 	2.Em atendimento
 * 	3.Finalizado
 * 
 * Origem Incidente:
 * P.Proddemge
 * S.Saom
 * N.Nagios
 */

//zend

include_once realpath(dirname(__FILE__) . '/../model/') . '/Saom_spModel.php';

include_once realpath(dirname(__FILE__) . '/../model/') . '/DBIncidente_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBInstalacao_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBEmpresas_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBIncidenteArquivado_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBAtendVsat_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBUsuario_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBSolicitacao_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBModel_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBStatus_atend_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBCronometro_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBCronometro_interrupcao_sp.php';
include_once realpath(dirname(__FILE__)) . '/Cronometro_sp.php';
include_once 'helpers/Utilitarios.php';
include_once 'helpers.class.php';
//echo die_json('teste');

interface IncidenteInterface
{
	public function view();
	
	public function edit();
	
	public function update();
}

/*
 * Pendencias:
 * TODO: aplicar pausa ao incidente
 */
class Incidente_sp extends Controller implements IncidenteInterface 
{

	protected $tplDir = 's_p/tampletes/incidente';

	protected $idincidentes;

	//itens relacioados a pausa de incidente
	protected $pausaAtiva = 'nao';
	
	// atributos
//	protected $idprodemge;
	protected $descricao;
	protected $data;
	protected $prioridade;
	protected $instalacoes_idinstalacoes;
	protected $atend_vsat_idatend_vsat;
	protected $tecnicoNoc;
	protected $saom;
	protected $linha_zend;
	
	protected $tempoTranscorrido;

	function __construct()
	{
		parent::__construct();
		$this->DB = new DBIncidente_sp();
		$this->DBCronometro = new DBCronometro_sp();
		$this->CronometroController = new Cronometro_sp();
		$this->DBUsuarios = new DBUsuario_sp();
		$this->DBAtend_vsat = new DBAtendVsat_sp();
		$this->DBInstalacao = new DBInstalacao_sp();
		$this->DBEmpresas = new DBEmpresas_sp();
		$this->sistema = new Sistema();
		$this->DBSolicitacao = new DBSoliciatacao_sp();
//
		$this->smarty->assign('login',$_SESSION['login']);

	}
	
	
	public function create()
	{
		if (empty($this->dadosP['form'])) //formulario
		{
			//LISTA DE TECNICOS
			$this->DBUsuarios->setOrderBy('nome');
			$this->DBUsuarios->setDefaultOrder('ASC');
			$listaUsuarios = $this->DBUsuarios->liste('incidentes = 1');

			$solicitacao = $this->DBSolicitacao->liste();

			//LISTA DE INSTALACOES
			$this->DBInstalacao->setSelect('idinstalacoes_sp, nome');
			$listaInstalacoes = $this->DBInstalacao->liste();

			$empresas = $this->DBEmpresas->listaEmpresas();
			foreach( $empresas AS $chave => $empresa )
			{
				if( $_SESSION['login']['empresas_idempresas'] == $empresa['idempresas']){
					$clientes = $empresa['empresa'];
					$idempresa = $empresa['idempresas'];

				}
			}

			//LISTA DO AUTOCOMPLETE
			$listaautocomplete = array();
			for($i=0;$i<count($listaInstalacoes);$i++)
			$listaautocomplete[] = $listaInstalacoes[$i]['nome'];
			$listaautocomplete = implode(',',$listaautocomplete);
            $totalIncidente = $this->DB->contaIncidentesTotal()+1;

			$data = explode('-',date('d-m-Y'));
			$data = $data[0]."/".$data[1]."/".$data[2];

//			echo die_json($data);




//            $sql = "SELECT COUNT(*) AS total
//    			FROM incidentes_sp inci";

//			$xml = $this->sistema->local();
			//trata identificador default
//			$id_prodemge = (LOCAL == 'SAOM_SP')?'SP'.date('YmdHis').$_SESSION['login']['idusuarios']:'';

			$this->smarty->assign('param',$this->dadosP['param']);
			$this->smarty->assign('submenu',$this->dadosP['submenu']);
			$this->smarty->assign('empresa',$_SESSION['login']['empresas_idempresas']);
			$this->smarty->assign('local',LOCAL);
			$this->smarty->assign('totalIncidentes',$totalIncidente);
			$this->smarty->assign('cliente',$clientes);
			$this->smarty->assign('dataAtual',$data);
			$this->smarty->assign('idempresa',$idempresa);
			$this->smarty->assign('listaUsuarios',$listaUsuarios);
			$this->smarty->assign('solicitacao',$solicitacao);
			$this->smarty->assign('listaInstalacoes',$listaInstalacoes);
			$this->smarty->assign('listaautocomplete',$listaautocomplete);
			$this->smarty->display("{$this->tplDir}/create.tpl");
            unset($totalIncidente);
		}
		else //envio do formulario
		{
			//print_b($this->dadosP['form'],true);



			$sql = "
				SELECT idinstalacoes_sp
				FROM instalacoes_sp
				WHERE nome = '{$this->dadosP['form']['nome_instalacao']}';
			";
			$idinstalacao = $this->DB->queryDados($sql);
			if(!$idinstalacao )
			{
				$arrReturn['msg'] = 'Erro! Vsat Nao esta na lista.';
				die_json($arrReturn);
			}

			//busca saom
			$saom = new Saom_spModel( $this->adapter->getAdapterZend() );
			$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
			$this->dadosP['form']['saom'] = $saom_row->id_saom;

//            $novadescricao = nl2br($this->dadosP['form']['descricao']);
            $novadescricao = str_replace('/\n/',' ', $this->dadosP['form']['descricao']);
//            $descricao = str_replace('/\n/',' ',$novadescricao);

			//cria atendimento
			$DBAtend = new DBAtendVsat_sp();
			$form = array();
			$form['data'] = date("Y-m-d H:i:s");
			$form['mensagem'] =  'Atendimento iniciado por '.$_SESSION['login']['nome']." as ".date("H:i")." de ".date("d/m/Y");

			$form['atendimento'] =  "<div class='atendmensagem'>".
										"<table border='1' width='100%'>".
											"<tr id='tr1'>".
												"<td id='td1' align='center' valign='top'>".
													"<div id='atenddados'>".
														"<b>".$_SESSION['login']['nome']."</b></br>".
														"<p>".$_SESSION['login']['funcao']."</p></br></br>".
													"</div>".
												"</td>".
												"<td valign='top' style='height: auto;'>".
													"<div id='arquivos1'></div>".
													"<div id='dadosmensagem'>".$novadescricao."\n</div>".
												"</td>".
											"</tr>".
											"<tr>".
												"<td id='td1' height='30px'></td><td></td>".
											"</tr>".
											"<div id='publicado'>&nbsp;&nbsp;Publicado em: " . date('d/m/Y H:i:s')."</div>".
										"</table>".
									"</div></br>";


            $form['status_atend_idstatus_atend'] = 1;
			$form['instalacoes_sp_idinstalacoes_sp'] = $idinstalacao[0]['idinstalacoes_sp'];
			$form['tipo_atendimento_idtipo_atendimento'] = 1;//default
			$form['saom'] = $saom_row->id_saom;

			$form['usuarios_idusuarios'] = $this->dadosP['form']['tecnicoNoc'];
			$form['solicitacao_sp_idsolicitacao'] = $this->dadosP['form']['solicitacao_idsolicitacao'];


			//registra atendimento
			if( $_SESSION['SAOM'] != 'PRODEMGE' )
			{
				//$criaAtend = $DBAtend->create($form);
				$criaAtend = $this->Atendimento_sp->insert( $form ); // TODO: tarefa da model
				//echo "teste: ".$criaAtend;exit;
				if( $criaAtend == false )
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg'] = 'Erro ao registrar atendimento.';
					die_json($arrReturn);
				}
				else
				{
					$sql = "
	            			INSERT INTO cronometro_sp (idreferencia, inicio_tarefa, tabelareferencia)
	            			VALUES ('{$criaAtend}', '".date('Y-m-d H:i:s')."','atend_vsat_sp')
	            		";
					if(!$this->DB->query($sql))
					{
						$arrReturn['status'] = 'erro';
						$arrReturn['msg']    = 'Erro: cronometro para atendimento nÃ£o gerado.';
						die_json($arrReturn);
					}
				}

				$this->dadosP['form']['atend_vsat_idatend_vsat'] = $DBAtend->getLastId();
			}

			//---------Nova Açao Id da Prodemge ---------------------

			if($this->dadosP['form']['nome_instalacao']!='')
			{
				$sql = "
	            		SELECT idinstalacoes_sp
	            		FROM instalacoes_sp
	            		WHERE nome = '{$this->dadosP['form']['nome_instalacao']}'
	            	";
				$idinstalacao = $this->DB->queryDados($sql);

				$this->dadosP['form']['instalacoes_idinstalacoes'] = $idinstalacao[0]['idinstalacoes_sp'];
			}



			if($_SESSION['login']['empresas_idempresas'] == 10){
				$data = explode('-',date('d-m-Y'));
				$data = $data[0]."/".$data[1]."/".$data[2];
				$this->dadosP['form']['data'] = $data;
			}

			$this->dadosP['form']['data_modificacao'] = date('Y-m-d H:i:s');
			$this->dadosP['form']['data'] = $this->Helpers->data_br_us( $this->dadosP['form']['data'] );

//			$arrReturn['msg']    = ;
//			die_json($arrReturn);
			unset($this->dadosP['form']['nome_instalacao']);

			if( !$return = $this->Incidentes_sp->insert($this->dadosP['form']) )
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = "Houve um erro ao inserir Incidente.";
			}
			else
			{
				$sql = "
            		UPDATE atend_vsat_sp
            		SET incidentes_sp_idincidentes = '{$return}'
            		WHERE idatend_vsat = '{$criaAtend}'
            	";
				if(!$this->DBPadrao->query($sql))
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg']    = 'Erro ao atualizar incidente em atendimento.';
					die_json($arrReturn);
				}

				// registra incidente novo em infoincidentes
				$this->CacheIncidentesModel_sp->insereNovoIncidente();
				//atualiza idincidentes em atendimento criado

				// insere associacao com instalacao
				$sql = "
					INSERT INTO associacao_instalacao_incidente_sp ( idinstalacoes_sp , idincidentes )
					VALUES ( '{$this->dadosP['form']['instalacoes_idinstalacoes']}' , '{$return}')
				";
                $this->DBPadrao->query($sql);
				$idassociacao = $this->DBPadrao->getLastId();

				// insere telefonemas
				$telefonemas = $this->insereTelefonemas( $idassociacao );

				//Envio de Email para NOC
				$this->Instalacao_sp->setidinstalacoes_sp( $this->dadosP['form']['instalacoes_idinstalacoes'] );
				$this->Instalacao_sp->getInstalacao();
					//$instalacaoDados = $instalacao->view();
				$instalacaoDados = $this->Instalacao_sp->getinstalacaoArray();
				$descricao = nl2br($this->dadosP['form']['descricao']);

				$listaUsuarios = $this->DBUsuarios->liste('incidentes = 1');

				foreach($listaUsuarios  as $listaUsuario){
					if ($listaUsuario['idusuarios'] == $this->dadosP['form']['tecnicoNoc']){
						$tecnico = $listaUsuario['nome'];
					}
				}
				$listaSlicitacoes = $this->DBSolicitacao->liste();

				foreach($listaSlicitacoes as $listaSlicitacao){
					if ($listaSlicitacao['idsolicitacao'] == $this->dadosP['form']['solicitacao_idsolicitacao']){
						$solicitacao = $listaSlicitacao['nomeSolicitacao'];
					}
				}
				if($this->dadosP['form']['solicitacao_idsolicitacao']){
					$assunto = 'Solicitação de ' .$solicitacao. '- Instalacão: '.$instalacaoDados['nome'];
					$assunto2 = 'Abertura para '. $solicitacao;
					$incidente = "Solicitacao de ".$solicitacao;
					$confirmacao = "Confirmação de Abertura para ".$solicitacao." da ";
				}else{
					$assunto = 'Cadastro de Incidente - Instalacão: '.$instalacaoDados['nome'];
					$assunto2 = 'Abertura de Incidente';
					$incidente = "Incidente criado";
					$confirmacao = "Confirmaçao de abertura de Incidente para";
				}

				if($_SESSION['login']['nome'] == 'Telefonica') {

					$to = array(
							"noc.sp@emc-corp.net",
							"celio.batalha@emcconnected.com"
					);

					$to2 = array(
							"silmara.silva@telefonica.com",
							"vanuza.almeida@egs.com.br",
							"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 30) {

					$to = array(
							"noc.sp@emc-corp.net",
							"celio.batalha@emcconnected.com",
							"alex.castillo@emcconnected.com"
					);

					$to2 = array(
							"ezequiel@bentleywalker.net.br",
							"patricia@bentleywalker.net.br",
							"atendimento@bentleywalker.net.br",
							"celio.batalha@emcconnected.com"
					);
				}else

				
				if($_SESSION['login']['nome'] == 'Jose Caetano'){
					$to = array(
							"noc.sp@emc-corp.net",
							"celio.batalha@emcconnected.com"
					);

					$to2 = array(
							"sso@tre-rr.jus.br",
							"celio.batalha@emcconnected.com"
					);
				}else


				if($_SESSION['login']['empresas_idempresas'] == 10){
					$to = array(
							"noc.sp@emc-corp.net",
							"celio.batalha@emcconnected.com"
					);

					$to2 = array(
							"marciodisktel@hotmail.com",
							"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 8){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"claudio@briskcom.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 13){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"haroldoap@hotmail.com",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 29){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"suporte@linktele.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 9){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"edson@celusat.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 18){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"delfim@ariasat.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 31){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"rcruz@maxsat.net.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 14){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"jefferson@imais.net",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 15){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"infortread.am@gmail.com",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 28){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"carlostoledo@netsatbr.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 36){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"soporte@networkingsat.com",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 37){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);

					$to2 = array(
						"egaspar@tre-pa.gov.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 33){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"evangelista@ittnet.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 34){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"tic@jevin.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 16){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"wilson@nsat.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 39){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"laurocoari@gmail.com",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 40){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"ti@credisis.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 41){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"max.costa@credip.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 42){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"marcio.sousa@qgsiderurgia.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 44){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"max.junior@tre-ap.jus.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 45){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"rommel.coutinho@tre-ma.jus.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 26){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"gsouza@internetsat.com.br",
						"celio.batalha@emcconnected.com"
					);
				}else

				if($_SESSION['login']['empresas_idempresas'] == 20){
					$to = array(
						"noc.sp@emc-corp.net",
						"celio.batalha@emcconnected.com"
					);
					$to2 = array(
						"valdir@vrtelecom.net",
						"celio.batalha@emcconnected.com"
					);
				}
				else{
					$to = [
						"celio.batalha@emcconnected.com"
					];
					$to2 = [
//						"noc.sp@emc-corp.net",
//						"alex.castillo@emcconnected.com"
						"celio.batalha@emcconnected.com"
					];

				}

				$msg = 	$incidente . " para Instalação " . $instalacaoDados['nome'] . '<br/>' .
						"Data de criação : " . date('Y-m-d H:i:s') . '<br/>' .
						"Usuário : " . $_SESSION['login']['nome'] . '<br/>' .
						"Tecnico NOC Responsavel : " . $tecnico . '<br/>' .
						"Prioridade : " . $this->dadosP['form']['prioridade'] . '<br/>' .
						"</br>".
						"Descrição : " . $descricao . '<br/>' .
						"</br>".
						"<img src='http://saom.vodanet-telecom.com/public/imagens/emc.png' height='50' width='350'/>";

				$msg2 = $confirmacao." Instalação " . $instalacaoDados['nome'] . '<br/>' .
						"Data da Abertura : " . date('Y-m-d H:i:s') . '<br/>' .
						"Criado Por : " . $_SESSION['login']['nome'] . '<br/>' .
						"Tecnico NOC Responsavel : " . $tecnico . '<br/>' .
						"Prioridade : " . $this->dadosP['form']['prioridade'] . '<br/>' .
						"</br>".
						"Descrição : " . $descricao . '<br/>' .
						"</br>".
						"Acesse o Incidente: <a href='http://saom.vodanet-telecom.com/SP#listaincidentes_sp'> aqui</a>".
						"</br>".
						"<p style='font-family:arial'>Em breve estaremos Respondendo o seu Atendimento!<p>".'</br>'.
						"</br>".
						"<img src='http://saom.vodanet-telecom.com/public/imagens/emc.png' height='50' width='350'/>";


				//Envio de Email para NOC - fim
				if(!sendMailIncidente($assunto, $to, $msg)){
					$arrReturn['status']  = 'erro';
					$arrReturn['msg']     = 'Erro ao enviar Email!';
					die_json($arrReturn);
				}
				if(!sendMailAberturaIncidente($assunto2, $to2, $msg2)){
					$arrReturn['status']  = 'erro';
					$arrReturn['msg']     = 'Erro ao enviar Email de Confirmaçao!';
					die_json($arrReturn);
				}
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
				$arrReturn['idinserido'] = $return;
			}
			die_json($arrReturn);
		}
	}
	
	
	public function cadastrarNumeroProdemge($idProdemge){
		$sql = "
			SELECT idprodemge
			FROM prodemge_sp
			WHERE numero_prodemge = '{$idProdemge}'
			";
		if ($this->DB->queryDados($sql)) {
			return false;
		}else{
			$sql = "INSERT INTO prodemge_sp(numero_prodemge)
			value('{$idProdemge}')";

			if($this->DBPadrao->query($sql))
				return true;
		}
	}
	
	public function cadastrarNumeroVsat($numVsat){
		$sql = "
		SELECT idinstalacoes_sp
		FROM instalacoes_sp
		WHERE nome = '{$numVsat}';";
		
		if($this->DB->queryDados($sql) ){
			return true;
		}else{
			return false;
		}
	}

	public function  excluirNumeroProdemge($idprodemge){
		
// 		$sql = "SELECT idprodemge 
// 				FROM associacao_instalacao_incidente
// 				WHERE idinstalacoes_sp = '{$idinstalacao}'	AND idincidentes = '{$idincidente}'";
		
// 		$idprodemge = $this->DB->queryDados($sql);
		
// 		$sql1 = "DELETE FROM prodemge WHERE idprodemge = '{$idprodemge[0]['idprodemge']}' ";
		$sql1 = "DELETE FROM prodemge_sp WHERE idprodemge = '{$idprodemge}' ";
		if ($this->DBPadrao->query($sql1)) {
			return true;
		}else{
			return false;

		}
	}
	
	
	/*
	 * metodo utilizado em:
	 * 1.Incidente.php (controller)
	 * 2.PreIncidentes.php (controller)
	 */
	public function insereTelefonemas( $idassociacao )
	{
		$objeto_tempo = new DateTime();
		
		$data_criacao_object1 = $objeto_tempo->format('Y-m-d H:i:s');
		$objeto_tempo->add( new DateInterval('PT10M') );
		$data_prazo_object1 = $objeto_tempo->format('Y-m-d H:i:s');
		
		$data_criacao_object2 = $objeto_tempo->format('Y-m-d H:i:s');
		$objeto_tempo->add( new DateInterval('PT10M') );
		$data_prazo_object2 = $objeto_tempo->format('Y-m-d H:i:s');
		
		$data_criacao_object3 = $objeto_tempo->format('Y-m-d H:i:s');
		$objeto_tempo->add( new DateInterval('PT10M') );
		$data_prazo_object3 = $objeto_tempo->format('Y-m-d H:i:s');
		
		// TODO: atualizar para model
		$sql = "
			INSERT INTO telefonemas_para_incidentes_sp 
				( data_criacao , prazo , order_telefonema , idassociacao_instalacao_incidente )
			VALUES
				( '{$data_criacao_object1}' , '{$data_prazo_object1}' , 1 , '{$idassociacao}' ),
				( '{$data_criacao_object2}' , '{$data_prazo_object2}' , 2 , '{$idassociacao}' ),
				( '{$data_criacao_object3}' , '{$data_prazo_object3}' , 3 , '{$idassociacao}' )
		";
		if( $this->DBPadrao->query($sql) ) return true;
		else return false;
	}

	public function liste()
	{
		if( isset($this->dadosP['so_conteudo']) && $this->dadosP['so_conteudo'] ) {
            $this->smarty->display("{$this->tplDir}/list_so_conteudo.tpl");
        }else {

            $this->smarty->display("{$this->tplDir}/list.tpl");
        }
	}

	public function listeFonte( )
	{

		// Get posted data
        $page = 1;
	    if (isset($_POST['page'])) {
	        $page = $_POST['page'];
	    }

	    $sortname = '';
	    if (isset($_POST['sortname'])) {
	        $sortname = $_POST['sortname'];
	    }

	    $sortorder = '';
	    if (isset($_POST['sortorder'])) {
	        $sortorder = $_POST['sortorder'];
	    }

	    $qtype = '';
	    if (isset($_POST['qtype'])) {
			$qtype = $_POST['qtype'];
	    }

	    $query = '';
	    if (isset($_POST['query'])) {
	        $query = $_POST['query'];
	    }

	    $rp = 20;
	    if (isset($_POST['rp'])) {
	        $rp = $_POST['rp'];
	    }
		
		// trabalha a requisicao no db
		$dados = $this->recebeQueryPadrao( $query );

		$pageStart = ($page==1)?0:$rp*($page-1);
		$limitSql = "limit $pageStart, $rp";

//		var_dump($dados);
		$listaBuscada = $this->buscaListaFonteDados( $dados , $page , $rp , $sortname , $sortorder , $limitSql );



		$listaBuscadaNumeroResultados = $this->buscaListaFonteDados( $dados , '' , '' , $sortname , $sortorder , '' );

		$empresaId = $_SESSION['login']['empresas_idempresas'];
		$busca = "(empresas_idempresas = '$empresaId')";
		$osspId =  $this->OSSP->fetchAll($busca);

		$osspId = $osspId->toArray();


		if($_SESSION['login']['perfis_idperfis']==10) {
			foreach ($listaBuscada AS $row) {
				foreach ($osspId as $osspIds) {
					$surch = "(os_sp_idos =" . $osspIds['idos'] . ")";
					if ($install = $this->Instalacao_sp->fetchRow($surch)) {
						if ($install['idinstalacoes_sp'] == $row['idinstalacoes']) {
							$row['associacao'] = $row['idassociacao'];
							if (strlen($row['descricao']) > 100)
								$row['descricao'] = substr(strip_tags($row['descricao']), 0, 100) . '...';

							$data['rows'][] = array(
								'id' => $row['idincidentes'],
								'cell' => array(
									$row['idincidentes'],
									$row['nome_instalacao'],
									$row['solicitacao'],
									$row['data'],
									$row['prioridade'],
									$row['descricao'],
									($row['status'] == 'Finalizado') ? $row['data_final'] : '-',
									//					$row['ultimoAtendimento'],
									//					$row['numero_prodemge'],
									$row['status'],
									$row['nomeTecnico'],
									//					$row['telefonemas_info'],
									$row['associacao']
								)
							);

						}
					}
				}
			}
		}else{
			foreach($listaBuscada AS $row){
				$row['associacao'] = $row['idassociacao'];
				if (strlen($row['descricao']) > 100)
					$row['descricao'] = substr(strip_tags($row['descricao']), 0, 100) . '...';

				$data['rows'][] = array(
					'id' => $row['idincidentes'],
					'cell' => array(
						$row['idincidentes'],
						$row['nome_instalacao'],
						$row['solicitacao'],
						$row['data'],
						$row['prioridade'],
						$row['descricao'],
						($row['status'] == 'Finalizado') ? $row['data_final'] : '-',
						//					$row['ultimoAtendimento'],
						//					$row['numero_prodemge'],
						$row['status'],
						$row['nomeTecnico'],
						//					$row['telefonemas_info'],
						$row['associacao']
					)
				);
			}
		}

		$data['page'] = $page;
		$data['total'] = $listaBuscadaNumeroResultados[0]['total'];

		$dataJson = json_encode($data);

		$escritaCache = $this->CacheIncidentesModel_sp->escreveCache( $dataJson , $page );
		
		echo $dataJson;
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

//		echo json_encode($query);exit;
		$dados = $this->recebeQueryPadrao( $query );

		$listaBuscada = $this->buscaListaFonteDados( $dados , $page , $rp , $sortname , $sortorder , " LIMIT 0 , 20 " );

//		echo die_json($listaBuscada);
		
		$listaBuscadaNumeroResultados = $this->buscaListaFonteDados( $dados , '' , '' , $sortname , $sortorder , '' );
		
		//echo json_encode($listaBuscada[0]['listaAssociacoesIncidentes'][0]['idincidentes']);exit;
		
		foreach( $listaBuscada AS $row )
		{
//			var_dump($row['id']);
			//echo json_encode($row['cronometro']);exit;
			$row['associacao'] = $row['idassociacao'];
			if( strlen($row['descricao']) > 100 )
				$row['descricao'] = substr( strip_tags( $row['descricao'] ) , 0 , 100 ).'...';
			
			$data['rows'][] = array(
				'id' => $row['idincidentes'],
				'cell' => array(
					$row['idincidentes'],
					$row['nome_instalacao'],
					$row['solicitacao'],
					$row['data'],
					$row['prioridade'],
					$row['descricao'],
					($row['status']=='Finalizado')?$row['data_final']:'-',
//					$row['ultimoAtendimento'],
//					$row['numero_prodemge'],
					$row['status'],
					$row['nomeTecnico'],
					$row['telefonemas_info'],
					$row['associacao']
				)
			);
		}
		//print_b($data,true);
		
		$data['page'] = $page;
		$data['total'] = $listaBuscadaNumeroResultados[0]['total']; 

		echo json_encode($data);
	}
	
	// TODO: fazer metodos padrao nas models proprias
	private function buscaListaFonteDados($dados, $numeroPagina, $numeroPorPagina, $sortname, $sortorder, $limit_condition) {

		// busca instalacoes com incidente
		$sql = 'SELECT COUNT(*) AS total 
    			FROM incidentes_sp inci 
                INNER JOIN associacao_instalacao_incidente_sp a ON (
                	a.idincidentes = inci.idincidentes
                )
                INNER JOIN instalacoes_sp i ON (
                	a.idincidentes = inci.idincidentes AND
                	a.idinstalacoes_sp = i.idinstalacoes_sp
                )

                    INNER JOIN atend_vsat_sp av ON (
						av.incidentes_sp_idincidentes 	= inci.idincidentes
                    )
                    INNER JOIN status_atend st ON (
						av.incidentes_sp_idincidentes 	= inci.idincidentes AND
						av.status_atend_idstatus_atend 	= st.idstatus_atend
                    )

                INNER JOIN usuarios u ON (
                    inci.tecnicoNoc = u.idusuarios
                )

                LEFT JOIN solicitacao_sp s ON (
                    inci.solicitacao_idsolicitacao = s.idsolicitacao
                )

		        WHERE 1 = 1 ' . PHP_EOL;


		if(!empty($limit_condition)) {
			$sql = 'SELECT 
                    	inci.idincidentes as idincidentes,
                    	i.idinstalacoes_sp as idinstalacoes,
                    	i.nome as nome_instalacao,
                    	a.idassociacao_instalacao_incidente as idassociacao,
                    	inci.tecnicoNoc as tecnicoNoc,
                    	inci.data as data,
                    	inci.prioridade as prioridade,
                    	inci.descricao as descricao,
						st.idstatus_atend as idstatus,
						st.status as status,
						u.idusuarios as idusuarios,
						u.nome as nomeTecnico,
						s.nomeSolicitacao as solicitacao

                    FROM incidentes_sp inci
                    INNER JOIN associacao_instalacao_incidente_sp a ON (
                    	a.idincidentes = inci.idincidentes
                    )
                    INNER JOIN instalacoes_sp i ON (
                    	a.idincidentes = inci.idincidentes AND
                    	a.idinstalacoes_sp = i.idinstalacoes_sp
                    )

                    INNER JOIN atend_vsat_sp av ON (
						av.incidentes_sp_idincidentes 	= inci.idincidentes
                    )
                    INNER JOIN status_atend st ON (
						av.incidentes_sp_idincidentes 	= inci.idincidentes AND
						av.status_atend_idstatus_atend 	= st.idstatus_atend
                    )

                    INNER JOIN usuarios u ON (
						inci.tecnicoNoc = u.idusuarios
                    )

                    LEFT JOIN solicitacao_sp s ON (
						inci.solicitacao_idsolicitacao = s.idsolicitacao
                    )

			        WHERE 1 = 1 ' . PHP_EOL;
		}


		// ----- buscas
		//echo json_encode($dados);exit;

		// saom
		if ($_SESSION['SAOM'] == 'PRODEMGE') {
		    $sql .= ' AND saom = 1 ' . PHP_EOL; //ajusta pada o id do saom
		}
		
		if (isset( $dados['nome_instalacao'])) {
		    $sql .= " AND i.nome LIKE '%{$dados['nome_instalacao']}%'" . PHP_EOL;
		}
		
		if (isset($dados['idincidentes'])) {
		    $sql .= " AND inci.idincidentes LIKE '%{$dados['idincidentes']}%'" . PHP_EOL;
		}
		
		if (isset($dados['prioridade'])) {
		    $sql .= " AND inci.prioridade LIKE '%{$dados['prioridade']}%'" . PHP_EOL;
		}
		
		if (isset($dados['descricao'])) {
		    $sql .= " AND inci.descricao LIKE '%{$dados['descricao']}%'" . PHP_EOL;
		}
		if (isset($dados['status'])) {
		    $sql .= " AND st.status LIKE '%{$dados['status']}%'" . PHP_EOL;
		}
		if (isset($dados['nomeTecnico'])) {
		    $sql .= " AND u.nome LIKE '%{$dados['nomeTecnico']}%'" . PHP_EOL;
		}
		if (isset($dados['solicitacao'])) {
			$sql .= " AND s.nomeSolicitacao LIKE '%{$dados['solicitacao']}%'" . PHP_EOL;
		}
		// ---- busca data
		if (isset($dados['data'])) {
		    $sql .= " AND data LIKE '%{$dados['data']}%'" . PHP_EOL;
		}



		// ordenaÃ§Ã£o
		if (!empty($sortname) && !empty($sortorder)) {
		    $sortOptions = array(
			'idincidentes'    => 'inci.idincidentes',
			'idinstalacoes'   => 'i.idinstalacoes_sp',
			'nome_instalacao' => 'i.nome',
			'idassociacao'    => 'a.idassociacao_instalacao_incidente',
			'data'            => 'inci.data',
			'prioridade'      => 'inci.prioridade',
			'descricao'       => 'inci.descricao',
//			'numero_prodemge' => 'p.numero_prodemge',
			'status'		  => 'st.status',
			'nomeTecnico'      => 'u.nome',
			'solicitacao'      => 's.nomeSolicitacao',
		    );
		    $sql .= ' ORDER BY ' . $sortOptions[$sortname] . ' ' . $sortorder . PHP_EOL;
		}

//		echo die_json($sql);
		// paginacao
		$limit = $limit_condition;
		if(!empty($numeroPagina) && !empty($numeroPorPagina)) {
		    $numeroPagina--;
		    $sql .= ' LIMIT ' . ($numeroPagina * $numeroPorPagina) . ' , ' . $numeroPorPagina . PHP_EOL;
		}
		//die($sql);
		
		$buscaAtendimento = '';
		if (isset($dados['ultimoAtendimento'])) {
		    $buscaAtendimento = $dados['ultimoAtendimento'] . PHP_EOL;
		}

		$listaIncidentes = $this->Incidentes_sp->executaSql( $sql );



		if (empty($limit_condition)) {
			return $listaIncidentes;
		}
		// busca incidentes das instalacoes encontradas
		foreach ( $listaIncidentes as $chave => $incidente )
		{
			$idIncidente = new Integer( $incidente['idincidentes'] );
//			echo die_json($idIncidente);

			// busca ultimo atendimento

				$atendimento = $this->Atendimento_sp->getUltimoAtendimentoDeIncidente( $idIncidente );


				if( $buscaAtendimento != '' )
				{
					if( strstr( $atendimento[0]['atendimento'] , $buscaAtendimento ) )
						$listaIncidentes[ $chave ]['ultimoAtendimento'] = $atendimento['atendimento'];
					else
					{
						unset($listaIncidentes[ $chave ]);continue;
					}
				}
				else
					$listaIncidentes[ $chave ]['ultimoAtendimento'] = $atendimento['atendimento'];

			// busca cronometro do ultimo atendimento
				if( isset($atendimento['cronometro_sp']['final_tarefa']) )
				{
					if(
						$atendimento['cronometro_sp']['final_tarefa'] == '' ||
						$atendimento['cronometro_sp']['final_tarefa'] == '0000-00-00 00:00:00' ||
						$atendimento['cronometro_sp']['final_tarefa'] == NULL
					)
						$listaIncidentes[ $chave ]['data_final'] = '-';
					else
						$listaIncidentes[ $chave ]['data_final'] = $atendimento['cronometro_sp']['final_tarefa'];
				}
				else
					$listaIncidentes[ $chave ]['data_final'] = '';

			// busca status incidente
				$this->Incidentes_sp->aplicaStatusIncidente( $this->Atendimento_sp );
				$listaIncidentes[ $chave ]['status'] = $this->Incidentes_sp->getstatusIncidente();


			// busca usuario tecnicoNoc
				$idusuarios = new Integer( $incidente['tecnicoNoc'] );
				$this->Usuarios_sp->setidusuarios( $idusuarios );
				$this->Usuarios_sp->getUsuario();
				if( $this->Usuarios_sp->getnome() != '' )
					$listaIncidentes[ $chave ]['nomeTecnico'] = $this->Usuarios_sp->getnome();
				else
					$listaIncidentes[ $chave ]['nomeTecnico'] = '';

			$listaIncidentes[ $chave ]['telefonemas_info'] = $this->buscaTelefonemas( $incidente['idassociacao'] );

		}
		//echo json_encode($listaIncidentes);exit;
		return $listaIncidentes;
	}
	
	private function recebeQueryPadrao( $query = '' )
	{
		if( $query != '' )
		{
			$partes = explode( 'AND' , $query );
			
			$array = array();
			foreach( $partes as $chave => $parte )
			{
				$novoArray = explode( 'LIKE' , $parte );
				$novoArray[0] = str_replace( '%' , '' , $novoArray[0] );
				$novoArray[0] = str_replace( '\'' , '' , $novoArray[0] );
				$novoArray[1] = str_replace( '%' , '' , $novoArray[1] );
				$novoArray[1] = str_replace( '\'' , '' , $novoArray[1] );
				$array[ trim($novoArray[0]) ] = trim($novoArray[1]);
			}
//			echo json_encode($array);exit;
		}
		else
			$array = array();
		
		return $array;
	}
	
	private function buscaTelefonemas( $idassociacao )
	{
		$this->TelefonemasParaIncidentes_sp->zeraObjeto();
		
		// telefonema 1
			//echo json_encode($idIncidente->numero());exit;
			$this->TelefonemasParaIncidentes_sp->setidassociacao_instalacao_incidente( $idassociacao );
			$this->TelefonemasParaIncidentes_sp->setorder_telefonema( 1 );
			$this->TelefonemasParaIncidentes_sp->getTelefonemasParaIncidentesPeloIncidenteEOrdem();
			//print_b($this->TelefonemasParaIncidentes);
			//echo json_encode($this->TelefonemasParaIncidentes_sp->gettelefonemasParaIncidentesArray());exit;
			
			$telefonemas = "telefonema1:".$this->TelefonemasParaIncidentes_sp->getdata_criacao().'|'.$this->TelefonemasParaIncidentes_sp->getdata_finalizacao().'|'.$this->TelefonemasParaIncidentes_sp->getprazo().';';
			
		// telefonema 2
			//echo json_encode($idassociacao);exit;
			$this->TelefonemasParaIncidentes_sp->setidassociacao_instalacao_incidente( $idassociacao );
			$this->TelefonemasParaIncidentes_sp->setorder_telefonema( 2 );
			$this->TelefonemasParaIncidentes_sp->getTelefonemasParaIncidentesPeloIncidenteEOrdem();
			//echo json_encode($this->TelefonemasParaIncidentes_sp->gettelefonemasParaIncidentesArray());exit;
			
			$telefonemas .= 'telefonema2:'.$this->TelefonemasParaIncidentes_sp->getdata_criacao().'|'.$this->TelefonemasParaIncidentes_sp->getdata_finalizacao().'|'.$this->TelefonemasParaIncidentes_sp->getprazo().';';
			
		// telefonema 3
			//echo json_encode($idassociacao);exit;
			$this->TelefonemasParaIncidentes_sp->setidassociacao_instalacao_incidente( $idassociacao );
			$this->TelefonemasParaIncidentes_sp->setorder_telefonema( 3 );
			$this->TelefonemasParaIncidentes_sp->getTelefonemasParaIncidentesPeloIncidenteEOrdem();
			//echo json_encode($this->TelefonemasParaIncidentes_sp->gettelefonemasParaIncidentesArray());exit;
			
			$telefonemas .= 'telefonema3:'.$this->TelefonemasParaIncidentes_sp->getdata_criacao().'|'.$this->TelefonemasParaIncidentes_sp->getdata_finalizacao().'|'.$this->TelefonemasParaIncidentes_sp->getprazo();
				
		//echo json_encode($telefonemas);exit;
		return $telefonemas;
	}
	
	
	// mÃ©todo mini facade
	public function incidenteFacade( $idincidente )
	{
		$idincidente = new Integer( $idincidente );

		$this->getObjetosView( $idincidente );// resgate incidente, usuario e cronometro

		$this->resolveStatus();// aplica status dos atendimentos nos atendimentos do incidente e  no prÃ³prio incidente


		$cronometro = $this->getDatasCronometroIncidente( $idincidente );
		
		$this->resolveTempoTranscorrido( $cronometro );// aplica ao incidente o tempo transcorrido
		
		$cronometro = $this->trataDateFromatCronometro( $cronometro );
		
		//tratamento sem lugar
		$incidente = $this->Incidentes_sp->getincidenteArray();
		$incidente['data'] =  $this->Helpers->data_us_br($incidente['data']);
		
		$this->incidenteFacade = array(
			'tecnicoResponsavel' => $this->Usuarios_sp->getUsuarioArray(),
			'cronometro' => $cronometro,
			'status' => $this->Incidentes_sp->getstatusIncidente(),
			'tempoTranscorrido' => $this->tempoTranscorrido,
			'obj' => $incidente
		);
	}
	
	public function view()
	{
		if ( empty($this->dadosP['param']) )
			exit('Id do incidente nÃ£o encontrado.');


		$this->incidenteFacade( $this->dadosP['param'] );

		$idincidentes = new Integer( $this->incidenteFacade['obj']['idincidentes'] );
		$ultimoAtendimento = $this->Atendimento_sp->getUltimoAtendimentoDeIncidente( $idincidentes );

		$ultimoAtendimento['atendimento'] = nl2br($ultimoAtendimento['atendimento']);
        $ultimoAtendimento['perfil_atend'] = $_SESSION['login']['perfis_idperfis'];

//        print_b($ultimoAtendimento);

		$this->smarty->assign( 'atendimento' , $ultimoAtendimento );
		$this->smarty->assign( 'tecnicoResponsavel' , $this->incidenteFacade['tecnicoResponsavel'] );
		$this->smarty->assign( 'cronometro' , $this->incidenteFacade['cronometro'] );
		$this->smarty->assign( 'status' , $this->incidenteFacade['status'] );
		$this->smarty->assign( 'tempoTranscorrido' , $this->incidenteFacade['tempoTranscorrido'] );
		$this->smarty->assign( 'obj' , $this->incidenteFacade['obj'] );
		$this->smarty->display("{$this->tplDir}/view.tpl");
	}
	
	private function trataDateFromatCronometro( Array $cronometro )
	{
		if( $cronometro['inicio_tarefa'] != '' )
		{
			$cronometro['inicio_tarefa'] = $this->Helpers->data_us_br_com_hora($cronometro['inicio_tarefa']);
		}
		if( $cronometro['final_tarefa'] != '' )
		{
			$cronometro['final_tarefa'] = $this->Helpers->data_us_br_com_hora($cronometro['final_tarefa']);
		}
		return $cronometro;
	}
	
	// mÃ©todo feito para php 5.3 adiante
	private function resolveTempoTranscorrido( $cronometro )
	{
		$dataInicial = ( 
			!empty($cronometro['inicio_tarefa']) && 
			$cronometro['inicio_tarefa'] != '0000-00-00 00:00:00' 
		)? new  DateTime( $cronometro['inicio_tarefa'] ) : '' ;
		$dataFinal = ( 
			!empty($cronometro['final_tarefa']) && 
			$cronometro['final_tarefa'] != '0000-00-00 00:00:00' 
		)? new DateTime($cronometro['final_tarefa']) : new DateTime() ;
		//print_b($dataInicial,true);
			
		if( $dataInicial != '' )
			$intervalo = $dataInicial->diff($dataFinal);
		else
			$intervalo = "";
		//sprint_b($intervalo,true);
		
		if( $intervalo  != '' ){
			$tempoIntervaloDia = $intervalo->format('%d');
			$tempoIntervalo = $intervalo->format('%H:%i:%s');
		}else{
			$tempoIntervalo = 'Sem cronÃ´metro';
		}
		$this->tempoTranscorrido = $tempoIntervaloDia.'d '. $tempoIntervalo;
	}
	
	private function getDatasCronometroIncidente( Integer $idincidente )
	{
		$ultimoAtendimento = $this->Atendimento_sp->getUltimoAtendimentoDeIncidente( $idincidente );
		$this->Cronometro_sp->setidreferencia( $ultimoAtendimento['idatend_vsat'] );
		$this->Cronometro_sp->settabelareferencia( 'atend_vsat_sp' );
		$cronometroDeUltimoAtendimento = $this->Cronometro_sp->getCronometrosDeAtendimento();
		//print_b($cronometroDeUltimoAtendimento,true);
		
		$primeiroAtendimento = $this->Atendimento_sp->getPrimeiroAtendimentoDeIncidente( $idincidente );
		$this->Cronometro_sp->setidreferencia( $primeiroAtendimento['idatend_vsat'] );
		$this->Cronometro_sp->settabelareferencia( 'atend_vsat_sp' );
		$cronometroDePrimeiroAtendimento = $this->Cronometro_sp->getCronometrosDeAtendimento();
		//print_b($cronometroDePrimeiroAtendimento,true);
		
		//$cronometroAtendimento
		$dataFinalCronometro = ( $cronometroDeUltimoAtendimento['final_tarefa'] != '' )? $cronometroDeUltimoAtendimento['final_tarefa'] : '' ;
		$dataInicioCronometro = ( $cronometroDePrimeiroAtendimento['inicio_tarefa'] != '' )? $cronometroDePrimeiroAtendimento['inicio_tarefa'] : '' ;
		return array(
			'final_tarefa' => $dataFinalCronometro,
			'inicio_tarefa' => $dataInicioCronometro
		);
	}
	
	private function getObjetosView( Integer $idIncidente )
	{
		$this->Incidentes_sp->setidincidentes( $idIncidente );
		$this->Incidentes_sp->getIncidente();
		
		$idusuario = new Integer( $this->Incidentes_sp->gettecnicoNoc() );
		$this->Usuarios_sp->setIdusuarios( $idusuario );
		$this->Usuarios_sp->getUsuario();
		$this->Cronometro_sp->setidreferencia( $idIncidente->numero() );
		$this->Cronometro_sp->settabelareferencia( 'incidentes_sp' );
		$this->Cronometro_sp->getCronometroPelaReferencia();

	}

	private function resolveStatus()
	{
		$idincidente = new Integer( $this->Incidentes_sp->getidincidentes() );
		$this->Atendimento_sp->getAtendimentosDeIncidente( $idincidente );
		$this->Atendimento_sp->getStatusAtendimentos();
		$this->Incidentes_sp->aplicaStatusIncidente( $this->Atendimento_sp );

	}

	public function edit()
	{
		if ( empty($this->dadosP['param']) )
			exit('Id do incidente nÃ£o encontrado.');
		
		$this->incidenteFacade( $this->dadosP['param'] );

		$this->Usuarios_sp->getListaUsuariosIncidente();

//        echo die_json($this->incidenteFacade['obj']);

//        echo die_json($_SESSION['login']['perfis_idperfis']);

		$this->smarty->assign( 'data_fim' , $this->incidenteFacade['cronometro']['final_tarefa'] );
        $this->smarty->assign('empresa',$_SESSION['login']['empresas_idempresas']);
        $this->smarty->assign( 'listaUsuarios' , $this->Usuarios_sp->getlistaUsuarios() );
		$this->smarty->assign( 'perfil_incidente' , $_SESSION['login']['perfis_idperfis']);
		$this->smarty->assign( 'obj' , $this->incidenteFacade['obj'] );
		$this->smarty->display( "{$this->tplDir}/edit.tpl" );
	}

	public function update()
	{
		if ( ! empty($this->dadosP['form']) )
		{
			$form = $this->dadosP['form'];

			$idincidente = new Integer($form['idincidentes']);

//            $idincidente = $idincidente->numero();


			$this->updateIncidentes( $idincidente , $form );

			if( isset($form['data_fim']) && $form['data_fim'] != '' )
				$this->updateCronometro( $idincidente , $form );

			$resposta = $this->respostaUpdate( $this->Incidentes_sp->edit() , $this->Cronometro_sp->edit() );

			exit($resposta);
		}
		else
			exit("Nenhum formulÃ¡rio presente.");
	}

	private function updateIncidentes(Integer $idincidente , Array $form )
	{

		$this->Incidentes_sp->setidincidentes( $idincidente );
		$this->Incidentes_sp->setdata( $this->Helpers->data_br_us( $form['data'] ) );
//		$this->Incidentes_sp->setidprodemge( $form['idprodemge'] );
		$this->Incidentes_sp->setdescricao( $form['descricao'] );
		$this->Incidentes_sp->setprioridade( $form['prioridade'] );
		$this->Incidentes_sp->settecnicoNoc( $form['tecnicoNoc'] );
		$this->Incidentes_sp->setsaom( $form['saom'] );
	}
	
	private function updateCronometro( Integer $idincidente , Array $form )
	{
		$this->Atendimento_sp->getAtendimentosDeIncidente( $idincidente );
		$this->Cronometro_sp->getUltimoCronometroAtendimento( $this->Atendimento );
		$cronometrosAtendimentos = $this->Cronometro_sp->getCronometrosAtendimentos();
		foreach( $cronometrosAtendimentos as $chave => $cronometroAtendimento ){
			$idcronometro = new Integer( $cronometroAtendimento['ultimo']['idcronometro'] );break;
		}
		$this->Cronometro_sp->setidcronometro( $idcronometro );
		$this->Cronometro_sp->getCronometro();
		$this->Cronometro_sp->setfinal_tarefa( $this->Helpers->data_br_us_com_hora($form['data_fim']) );
	}
	
	private function respostaUpdate( $respostaIncidente , $respostaCronoemtroDeAtendimento )
	{
		if( $respostaIncidente == 'ok' || $respostaCronoemtroDeAtendimento == 'ok' )
			$this->CacheIncidentesModel_sp->atualizaData();
		
		if( $respostaIncidente == 'ok' && $respostaCronoemtroDeAtendimento == 'ok' )
			return "Incidente editado com sucesso.";
		else if( $respostaIncidente == 'ok' && $respostaCronoemtroDeAtendimento == 'erro' )
			return "Incidente editado porÃ©m nÃ£o houve modificaÃ§Ã£o na Data Final.";
		else if( $respostaIncidente == 'erro' && $respostaCronoemtroDeAtendimento == 'ok' )
			return "Apenas a Data Final foi editada.";
		else
			return "NÃ£o houve modificaÃ§Ã£o em Incidente.";
	}
	
	public function formularioComListaDeInstalacoes()
	{
		$listaInstalacoes = $this->Instalacao_sp->fetchAll()->toArray();


		$listaString = "";
		foreach ( $listaInstalacoes as $instalacao )
		{
			$listaString .= $instalacao['nome'].",";
		}
		$listaString = substr( $listaString , 0 , -1 );

		$this->smarty->assign( 'idIncidente' , $this->dadosP['idIncidente'] );
		
		$this->smarty->assign( 'listaautocomplete' , $listaString );
		
		$this->smarty->display( "{$this->tplDir}/formularioInstalacoesParaIncidente.tpl" );
	}
	
	public function adicionaInstalacaoEmIncidente()
	{
		$dados = $this->dadosP;

		if (/*$dados['numProdemge'] && */$dados['nomeInstalacao']) {

		    if($this->cadastrarNumeroVsat($dados['nomeInstalacao']) == false){
				echo 6;exit;
		   }
//            else if ($this->cadastrarNumeroProdemge($dados['numProdemge'])== false){
//		   		echo 4; exit;
//
//		   }
            else{
				$this->Instalacao_sp->getInstalacaoPeloNome( $dados['nomeInstalacao'] );
//				$this->Prodemge_sp->getProdemgePeloNome($dados['numProdemge']);


				$idincidentesInteger = new Integer( $dados['idIncidente'] );
				$this->Incidentes_sp->setidincidentes( $idincidentesInteger );

				$this->Incidentes_sp->getIncidente();

				if( $this->AssociacaoInstalacaoIncidente_sp->getAssociacaoPelaInstalacaoEPeloIncidente( $this->Instalacao_sp , $this->Incidentes_sp /*, $this->Prodemge_sp*/ ) )
				{
					echo 1;exit;
				}



				$this->AssociacaoInstalacaoIncidente_sp->setidinstalacoes_sp( $this->Instalacao_sp->getidinstalacoes_sp() );
				$this->AssociacaoInstalacaoIncidente_sp->setidincidentes( $dados['idIncidente'] );
//				$this->AssociacaoInstalacaoIncidente_sp->setidprodemge( $this->Prodemge_sp->getidprodemge() );

				if( $idAssociacao = $this->AssociacaoInstalacaoIncidente_sp->create() )
				{
					$this->insereTelefonemas( $idAssociacao );
					echo 2;
				}else 
					echo 3;
		   }
		}else{
			echo 5;
		}
		
	}

	/* TODO: retirar ---
	public function uploadImg()
	{
		$this->DB->setPrkValue($this->dadosP['id']);
		if($this->DB->uploadImg($this->dadosF))
		{
			echo '<font id="recadoEnvioImg" style="color:green">Imagem anexada com sucesso.</font>';
		}
		else
		{
			echo '<font id="recadoEnvioImg" style="color:red;">Erro ao anexar imagem.</font>';
		}
	}
	*/

	/**
	 * RELATÃ“RIO EM CSV
	 * ->teste unitÃƒÂ¡rio aplicado em relatorioContent() em instalacoes, AQUI AINDA NAO
	 *
	 * campos:
	 * 	1.n incidente ()
	 * 	2.vsat ()
	 * 	3.data ()
	 * 	4.prioridade ()
	 * 	5.descricao ()
	 * 	6.atendimento ()
	 * 	7.id prodemge ()
	 * 	8.status ()
	 * 	9.tecnico responsavel ()
	 */
	public function relatorio()
	{
		//trecho de relatorioContent();
		$this->relatorioContent();
		//print_b($this->arr,true);

		//convertendo codificacao em windows (UTF-8 para ISO-8599-1)
		$campos = "Nº INCIDENTE;VSAT;DATA;PRIORIDADE;DESCRICAO;ATENDIMENTOS;ID PRODEMGE;STATUS;TECNICO RESPONSAVEL; RESPONSAVEL; MOTIVO";
		$this->smarty->assign('campos',utf8_decode($campos));
		$valores = $this->arr;
			
		$helpers = new Helpers();
// 		$valores = $helpers->varreArray($valores, 'utf8_decode');
			
		$this->smarty->assign('arr',$valores);
			
		
		$text = $this->smarty->fetch("{$this->tplDir}/relatorio_1.tpl");

		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=file.csv");
		header('Content-Type: application/csv;charset=ISO-8859-1');
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $text;
	}

	//tratamento do conteudo do csv (separado para o teste unitario)
	private function relatorioContent()
	{

		//BUSCA atendimentos de incidente $this->arr[$i]['vsatNome']
		//TODO: arrumar isso
		$sql = "SELECT DISTINCT inci.idincidentes, inst.nome as nomeVsat, inci.data, inci.prioridade, inci.descricao, /*pro.numero_prodemge as idprodemge,*/
				      u.nome as tecnicoNome, ma.motivo, ra.responsavel, sa.status
				FROM associacao_instalacao_incidente_sp 		  aii
				LEFT JOIN incidentes_sp 						  inci  ON (inci.idincidentes 			= aii.idincidentes)
				LEFT JOIN atend_vsat_sp 						  av    ON (av.incidentes_sp_idincidentes  = inci.idincidentes)
				LEFT JOIN usuarios 						  	  u 	ON (inci.tecnicoNoc 			= u.idusuarios)
				LEFT JOIN instalacoes_sp	 					  inst	ON (aii.idinstalacoes_sp 			= inst.idinstalacoes_sp)
/*/				LEFT JOIN prodemge_sp		 					  pro	ON (aii.idprodemge	 			= pro.idprodemge)*/
				LEFT JOIN status_atend						  sa	ON (av.status_atend_idstatus_atend 	= sa.idstatus_atend)
				LEFT JOIN atendimento_motivo_responsavel_sp 	  amr	ON (av.idatend_vsat 			= amr.idatendimento)
				LEFT JOIN motivo_atendimento_sp			  ma	ON (amr.idmotivo 				= ma.idmotivo_atendimento)
				LEFT JOIN responsavel_atendimento_sp 			  ra	ON (amr.idresponsavel 			=	ra.idresponsavel_atendimento)
				ORDER BY inci.idincidentes DESC
				";
		$this->arr = $this->Incidentes_sp->executaSql($sql);
			
		for($i=0;$i<count($this->arr);$i++){
			//BUSCA atendimentos de incidente
			//TODO: arrumar isso			
			$sql = "SELECT atendimento FROM atend_vsat_sp WHERE incidentes_sp_idincidentes = '{$this->arr[$i]['idincidentes']}' ";
			$lista_atend_vsat = $this->DB->queryDados($sql);
			$listaAtendimentos = '';
			for($i2=0;$i2<count($lista_atend_vsat);$i2++)
			{
				$atendVez = $i2+1;
				$listaAtendimentos .= "| ATENDIMENTO {$atendVez}: {$lista_atend_vsat[$i2]['atendimento']} |";
			}
			
			//OS TITULOS DO RELATORIO ESTA NO templates\incidentes\relatorio_1.ptl
			
			$this->arr[$i]['atendimentos'] = $listaAtendimentos;
			
			//arrumando atendimentos para evitar erro em csv
			$atendimentos = str_replace("\r\n","",trim($this->arr[$i]['atendimentos']));
			$atendimentos = str_replace("\n","",trim($atendimentos));
			$atendimentos = str_replace("<br/>","",trim($atendimentos));
			$atendimentos = str_replace("<br>","",trim($atendimentos));
			$this->arr[$i]['atendimentos'] = $atendimentos;

			//arrumando descricao para evitar erro em csv
			$descricao = str_replace("\r\n","",trim($this->arr[$i]['descricao']));
			$descricao = str_replace("\n","",trim($descricao));
			$descricao = str_replace("<br/>","",trim($descricao));
			$descricao = str_replace("<br>","",trim($descricao));
			$this->arr[$i]['descricao'] = $descricao;

			$this->arr[$i]['vsatNome'] = $this->arr[$i]['nomeVsat'];
			
			$this->arr[$i]['statusAtendimento'] = $this->arr[$i]['status'];

			$this->arr[$i]['nomeTecnico'] = $this->arr[$i]['tecnicoNome'];

			$this->arr[$i]['responsavel'] = $this->arr[$i]['responsavel'];
			
			$this->arr[$i]['motivo'] = $this->arr[$i]['motivo'];
		}

	}
	
	
	public function RetiraAssociacaoComInstalacao()
	{
		$dados = $this->dadosP;
		

		
		$this->Instalacao_sp->getInstalacaoPeloNome( $dados['nomeInstalacao'] );
//		$retorno = $this->excluirNumeroProdemge($dados['idProd']);
		
		
//		if ($retorno) {
			$this->AssociacaoInstalacaoIncidente_sp->setidinstalacoes_sp( $this->Instalacao_sp->getidinstalacoes_sp() );
			$this->AssociacaoInstalacaoIncidente_sp->setidincidentes( $dados['idincidentes'] );
//			$this->AssociacaoInstalacaoIncidente_sp->setidprodemge( $dados['idProd'] );
			if( $this->AssociacaoInstalacaoIncidente_sp->apagarAssociacao() )
				echo "Instalação retirada com sucesso.";
			else
				echo "Erro ao retirar Instalação.";
//		}

//        else{
//			echo "Erro ao retirar o Numero da Prodemge";
//		}
		
	}


	//funcao para transformar em lista para apresentacao
	public function transformaLista( $lista1 )
	{
		$lista2 = '<ul>';
		//print_b($lista1,true);
		for($i=0;$i<count($lista1);$i++)
		{
			$lista2 .= '<li><a href="#" onclick="javascript:getAjaxForm(\'Incidente_sp/view\',\'conteudo\',{param:'.$lista1[$i]['id'].',ajax:1})">'.$lista1[$i]['vsat'].'</a></li>';
		}
		$lista2 .= '</ul>';
		//print_b($lista2,true);
		return $lista2;
	}


	//metodo que busca idprodemge para verificar e evitar duplicidade
	public function verificaCamposIncidente()
	{
		//verifica se o campo esta vazio
		
		if($_POST['datas']== '')
		{
 			echo "vazioDt"; exit;
		}
		else if($_POST['instal']== '')
		{
 			echo "vazioInstalacao"; exit;
		}
		else if($_POST['tecnicoNoc']== '')
		{
 			echo "vazioTecnico"; exit;
		}
		//verifica se sÃƒÂ£o 6 dÃƒÂ­gitos

		$this->DB->setSelect('idincidentes');

	}

	//PAGINA INICIAL

	public function ContaIncidentesAbertos()
	{
		$total['result'] = $this->DB->ContaIncidentesAbertos();
		die_json($total);
	}

	public function ContaIncidentesEmAtendimentos()
	{
		$total['result'] = $this->DB->ContaIncidentesEmAtendimentos();
		die_json($total);
	}

	public function ContaIncidentesFinalizados()
	{
		$total['result'] = $this->DB->ContaIncidentesFinalizados();
		die_json($total);
	}

}

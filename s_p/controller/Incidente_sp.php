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
include_once realpath(dirname(__FILE__) . '/../model/') . '/Emails_spModel.php';

include_once realpath(dirname(__FILE__) . '/../model/') . '/DBOS_SP.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBIncidente_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBInstalacao_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBEmpresas_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBIncidenteArquivado_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBAtendVsat_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBUsuario_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBSolicitacao_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBTipoIncidente_sp.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBTesteDemo_sp.php';
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
	protected $time = false;

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
		$this->DBTipoInc = new DBTipoIncidente_sp();
		$this->DBTesteDemo = new DBTesteDemo_sp();
		$this->DBOS_antigo = new DBOS_SP();
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

			$this->DBTipoInc->setDefaultOrder('ASC');
			$this->DBTesteDemo->setDefaultOrder('ASC');
			$this->DBSolicitacao->setDefaultOrder('ASC');
			$this->DBSolicitacao->setOrderBy('descricao');

			$solicitacao = $this->DBSolicitacao->liste();
			$tipoIncidente = $this->DBTipoInc->liste();
			$testeDemo = $this->DBTesteDemo->liste();

			//LISTA DE INSTALACOES
			$this->DBInstalacao->setSelect('idinstalacoes_sp, nome');
			$listaInstalacoes = $this->DBInstalacao->liste();

			$empresas = $this->DBEmpresas->listaEmpresas();
			foreach( $empresas AS $chave => $empresa )
			{
				if( $_SESSION['login']['empresas_idempresas'] == $empresa['idempresas']){
					$clientes = $empresa['prefixo'];
					$idempresa = $empresa['idempresas'];

				}
			}

			$clientes = strtoupper($clientes);

			//LISTA DO AUTOCOMPLETE
			$listaautocomplete = array();
			for($i=0;$i<count($listaInstalacoes);$i++){
				if(substr($listaInstalacoes[$i]['nome'],0,3) == substr($clientes,0,3)){
					$listaautocomplete[] = $listaInstalacoes[$i]['nome'];

				}elseif($_SESSION['login']['empresas_idempresas'] == 1){
					$listaautocomplete[] = $listaInstalacoes[$i]['nome'];
				}

			}

			$listaautocomplete = implode(',',$listaautocomplete);
			$totalIncidente = $this->DB->contaIncidentesTotal()+1;

			$data = explode('-',date('d-m-Y'));
			$data = $data[0]."/".$data[1]."/".$data[2];

			$this->smarty->assign('param',$this->dadosP['param']);
			$this->smarty->assign('submenu',$this->dadosP['submenu']);
			$this->smarty->assign('perfil',$_SESSION['login']['perfis_idperfis']);
			$this->smarty->assign('local',LOCAL);
			$this->smarty->assign('totalIncidentes',$totalIncidente);
			$this->smarty->assign('cliente',$clientes);
			$this->smarty->assign('dataAtual',$data);
			$this->smarty->assign('idempresa',$idempresa);
			$this->smarty->assign('listaUsuarios',$listaUsuarios);
			$this->smarty->assign('solicitacao',$solicitacao);
			$this->smarty->assign('tipoIncidente',$tipoIncidente);
			$this->smarty->assign('testeDemo',$testeDemo);
			$this->smarty->assign('listaInstalacoes',$listaInstalacoes);
			$this->smarty->assign('listaautocomplete',$listaautocomplete);
			$this->smarty->display("{$this->tplDir}/new.tpl");
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
				$arrReturn['msg'] = 'Erro! Vsat Nao Encontrado.';
				die_json($arrReturn);
			}
			if($this->dadosP['form']['data'] == '' || $this->dadosP['form']['solicitacao_idsolicitacao'] == ''){
				$arrReturn['msg'] = 'Por Favor! Preencha todos Campos.';
				die_json($arrReturn);
			}
			if($this->dadosP['form']['solicitacao_idsolicitacao'] == 7 && $this->dadosP['form']['tipo_incidente_idtipo'] == ''){
				$arrReturn['msg'] = 'Selicione o Tipo de Incidente.';
				die_json($arrReturn);
			}

			if($this->dadosP['form']['solicitacao_idsolicitacao'] == 8 && $this->dadosP['form']['teste_demo_idteste'] == ''){
				$arrReturn['msg'] = 'Selicione o Teste Demo.';
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
			$atend_resp = array();
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
				"<div id='envioEmail'></div>".
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

			$form['privado'] = $form['atendimento'];

			$form['status_atend_idstatus_atend'] = 1;
			$form['instalacoes_sp_idinstalacoes_sp'] = $idinstalacao[0]['idinstalacoes_sp'];
			$form['tipo_atendimento_idtipo_atendimento'] = 1;//default
			$form['saom'] = $saom_row->id_saom;

			$form['usuarios_idusuarios'] = $this->dadosP['form']['tecnicoNoc'];
			$form['solicitacao_sp_idsolicitacao'] = $this->dadosP['form']['solicitacao_idsolicitacao'];
			$form['tipo_incidente_sp_idtipo'] = $this->dadosP['form']['tipo_incidente_idtipo'];
			$form['teste_demo_sp_idteste'] = $this->dadosP['form']['teste_demo_idteste'];


			$atend_resp['nome_usuario'] = $_SESSION['login']['nome'];
			$atend_resp['data_time'] = date('Y-m-d H:i:s');
			$atend_resp['mensagem'] = $novadescricao;


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
					if($_SESSION['login']['perfis_idperfis']!=10){
						$ordem = "noc";
					}else{
						$ordem = "cliente";
					}
					$sql = "
	            			INSERT INTO cronometro_sp (idreferencia, inicio_tarefa, data_inicio, ordem, tabelareferencia)
	            			VALUES ('{$criaAtend}', '".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','{$ordem}','atend_vsat_sp')
	            		";
					if(!$this->DB->query($sql))
					{
						$arrReturn['status'] = 'erro';
						$arrReturn['msg']    = 'Erro: cronometro para atendimento nÃ£o gerado.';
						die_json($arrReturn);
					}
				}

				$this->dadosP['form']['atend_vsat_idatend_vsat'] = $DBAtend->getLastId();

				$sql = "INSERT INTO atend_resposta_sp (idatend_vsat, nome_usuario, data_time, mensagem, tempo)
                                    VALUES (
                                     $criaAtend,
                                    '{$atend_resp['nome_usuario']}',
                                    '".date('Y-m-d H:i:s')."',
                                    '{$atend_resp['mensagem']}',
                                    1
                                    )
                                    ";


				$this->DBPadrao->query($sql);
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

			$numeroIncidente = $this->dadosP['form']['numeroIncidente'];
			unset(
				$this->dadosP['form']['nome_instalacao'],
				$this->dadosP['form']['numeroIncidente']
			);

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
				//$telefonemas = $this->insereTelefonemas( $idassociacao );

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

				$email = new Emails_spModel($this->adapter->getAdapterZend());
				$listaEmails = $email->fetchAll()->toArray();


				$assunto = 'Abertura de Ticket Nº: '.$numeroIncidente.' - Instalacão: '.$instalacaoDados['nome'];
				$assunto2 = 'Abertura para '. $solicitacao;
				$incidente = "Solicitacao de ".$solicitacao;
				$confirmacao = "Confirmação de Abertura para ".$solicitacao." da ";

				foreach ($listaEmails as $emails){
					if($_SESSION['login']['empresas_idempresas'] == $emails['empresas_idempresas']){
						$lista[] = $emails['to2'];
					}
				}
				$to = ['noc.sp@globaleagle.com'];
				$to2 = $lista;
//				$to = ['celio.batalha@globaleagle.com'];
//				$to2 = ['celio.batalha@globaleagle.com'];


				$msg = 	$incidente . " para Instalação " . $instalacaoDados['nome'] . '<br/>' .
					"Data de criação : " . date('Y-m-d H:i:s') . '<br/>' .
					"Usuário : " . $_SESSION['login']['nome'] . '<br/>' .
					"Tecnico NOC Responsavel : " . $tecnico . '<br/>' .
					"Prioridade : " . $this->dadosP['form']['prioridade'] . '<br/>' .
					"</br>".
					"Descrição : " . $descricao . '<br/>' .
					"</br>".
					"<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='350'/>";

				$msg2 = $confirmacao." Instalação " . $instalacaoDados['nome'] . '<br/>' .
					"Data da Abertura : " . date('Y-m-d H:i:s') . '<br/>' .
					"Criado Por : " . $_SESSION['login']['nome'] . '<br/>' .
					"Tecnico NOC Responsavel : " . $tecnico . '<br/>' .
					"Prioridade : " . $this->dadosP['form']['prioridade'] . '<br/>' .
					"</br>".
					"Descrição : " . $descricao . '<br/>' .
					"</br>".
					"Acesse o Incidente: <a href='https://saom.globaleagle.com.br/SP#listaincidentes_sp'> aqui</a>".
					"</br>".
					"<p style='font-family:arial'>Em breve estaremos Respondendo o seu Atendimento!<p>".'</br>'.
					"</br>".
					"<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='350'/>";


				//Envio de Email para NOC - fim

				/*
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
				*/
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

			$idincidente = (@$_SESSION['idincidentes']!="")?@$_SESSION['idincidentes']:"";
			$nome_insatlacao = (@$_SESSION['nome_instalacao']!="")?@$_SESSION['nome_instalacao']:"";
			$solicitacao = (@$_SESSION['solicitacao']!="")?@$_SESSION['solicitacao']:"";
			$prioridade = (@$_SESSION['prioridade']!="")?@$_SESSION['prioridade']:"";
			$descricao = (@$_SESSION['descricao']!="")?@$_SESSION['descricao']:"";
			$status = (@$_SESSION['status']!="")?@$_SESSION['status']:"";
			$nomeTecnico = ($_SESSION['nomeTecnico']!="")?@$_SESSION['nomeTecnico']:"";

			$this->smarty->assign('idincidentes',$idincidente);
			$this->smarty->assign('nome_insatlacao',$nome_insatlacao);
			$this->smarty->assign('solicitacao',$solicitacao);
			$this->smarty->assign('prioridade',$prioridade);
			$this->smarty->assign('descricao',$descricao);
			$this->smarty->assign('status',$status);
			$this->smarty->assign('nomeTecnico',$nomeTecnico);

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

		if($query == ''){
				$idincidentes 	= @$_SESSION['idincidentes'];
				$nome_instalacao= @$_SESSION['nome_instalacao'];
				$solicitacao 	= @$_SESSION['solicitacao'];
				$prioridade		= @$_SESSION['prioridade'];
				$status			= @$_SESSION['status'];
				$nomeTecnico	= @$_SESSION['nomeTecnico'];
			if($_SESSION['login']['perfis_idperfis'] == '10'){
//				if($_SESSION['login']['empresa']=='Telefonica'){
//					$login = 'VIVO';
//				}elseif($_SESSION['login']['empresa']=='OI-Operacoes'){
//					$login = 'HUB-OI-';
//				}else{
//				}
				$login = $_SESSION['login']['empresa'];
				$query = "
						  idincidentes LIKE '%$idincidentes%' AND
						  nome_instalacao LIKE '%$login%' AND
						  solicitacao LIKE '%$solicitacao%' AND
						  prioridade LIKE '%$prioridade%' AND
						  status LIKE '%$status%' AND
						  nomeTecnico LIKE '%$nomeTecnico%'
						  ";

			}else{
				$query = "
						  idincidentes LIKE '%$idincidentes%' AND
						  nome_instalacao LIKE '%$nome_instalacao%' AND
						  solicitacao LIKE '%$solicitacao%' AND
						  prioridade LIKE '%$prioridade%' AND
						  status LIKE '%$status%' AND
						  nomeTecnico LIKE '%$nomeTecnico%'
						  ";

			}
		}

		// trabalha a requisicao no db

		$dados = $this->recebeQueryPadrao( $query );
		$pageStart = ($page==1)?0:$rp*($page-1);
		$limitSql = "limit $pageStart, $rp";
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
		}else if($_SESSION['login']['perfis_idperfis']==8){

			$idusuario = $_SESSION['login']['idusuarios'];
			$buscaIdusuario = "(usuario_idusuario = '$idusuario')";
			$idempresa = $this->Empresa_sp->fetchAll($buscaIdusuario);
			$idempresa = $idempresa->toArray();


			foreach($idempresa as $idempresas){
				$buscaOssp .= "empresas_idempresas = " . $idempresas['idempresas'] . " or ";
			}
			$buscaOssp = substr($buscaOssp, 0, -3);
			$osspIdsp =  $this->OSSP->fetchAll($buscaOssp);
			$osspId =  $osspIdsp->toArray();
				
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
//		$data['total'] = $listaBuscadaNumeroResultados[0]['total'];
		$data['total'] = ($listaBuscadaNumeroResultados[0]['total'])?$listaBuscadaNumeroResultados[0]['total']:1;

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


		if ($query != '') {
			$input = [
				"0" => "idincidentes",
				"1" => "nome_instalacao",
				"2" => "solicitacao",
				"3" => "data",
				"4" => "prioridade",
				"5" => "descricao",
				"6" => "status",
				"7" => "nomeTecnico",
			];

			$inputPost = explode("AND", $_POST['query']);
			for ($j = 0; $j <= count($input); $j++) {
				for ($i = 0; $i < count($inputPost); $i++) {
					$campoPost = current(str_word_count($inputPost[$i], 2));
					$campoPost = ($campoPost != "nome") ? $campoPost : $campoPost . "_instalacao";
					if ($campoPost == $input[$j]) {
						$nome[$i] = explode("%", $inputPost[$i]);
						$_SESSION[$campoPost] = $nome[$i]['1'];
					}
				}
			}

			$idincidentes = $_SESSION['idincidentes'];
			$nome_instalacao = $_SESSION['nome_instalacao'];
			$solicitacao = $_SESSION['solicitacao'];
			$prioridade = $_SESSION['prioridade'];
			$status = $_SESSION['status'];
			$nomeTecnico = $_SESSION['nomeTecnico'];
			if ($_SESSION['login']['perfis_idperfis'] == '10') {
//				if ($_SESSION['login']['empresa'] == 'Telefonica') {
//					$login = 'VIVO';
//				} elseif ($_SESSION['login']['empresa'] == 'OI-Operacoes') {
//					$login = 'HUB-OI-';
//				} else {
//				}
					$login = $_SESSION['login']['empresa'];
				$query = "
						  idincidentes LIKE '%$idincidentes%' AND
						  nome_instalacao LIKE '%$login%' AND
						  solicitacao LIKE '%$solicitacao%' AND
						  prioridade LIKE '%$prioridade%' AND
						  status LIKE '%$status%' AND
						  nomeTecnico LIKE '%$nomeTecnico%'
						  ";
			} else {

				$query = "
						  idincidentes LIKE '%$idincidentes%' AND
						  nome_instalacao LIKE '%$nome_instalacao%' AND
						  solicitacao LIKE '%$solicitacao%' AND
						  prioridade LIKE '%$prioridade%' AND
						  status LIKE '%$status%' AND
						  nomeTecnico LIKE '%$nomeTecnico%'
						  ";
			}

		}

		$dados = $this->recebeQueryPadrao($query);

		$listaBuscada = $this->buscaListaFonteDados($dados, $page, $rp, $sortname, $sortorder, " LIMIT 0 , 20 ");

		$listaBuscadaNumeroResultados = $this->buscaListaFonteDados($dados, '', '', $sortname, $sortorder, '');


		$empresaId = $_SESSION['login']['empresas_idempresas'];
		$busca = "(empresas_idempresas = '$empresaId')";
		$osspId = $this->OSSP->fetchAll($busca);
		$osspId = $osspId->toArray();
		if ($_SESSION['login']['perfis_idperfis'] == 10) {
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
									$row['status'],
									$row['nomeTecnico'],
									$row['telefonemas_info'],
									$row['associacao']
								)
							);
						}
					}
				}
			}
		}else if($_SESSION['login']['perfis_idperfis'] == 8){

			$idusuario = $_SESSION['login']['idusuarios'];
			$buscaIdusuario = "(usuario_idusuario = '$idusuario')";
			$idempresa = $this->Empresa_sp->fetchAll($buscaIdusuario);
			$idempresa = $idempresa->toArray();


			foreach($idempresa as $idempresas){
				$buscaOssp .= "empresas_idempresas = " . $idempresas['idempresas'] . " or ";
			}
			$buscaOssp = substr($buscaOssp, 0, -3);
			$osspIdsp =  $this->OSSP->fetchAll($buscaOssp);
			$osspId =  $osspIdsp->toArray();

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
									$row['status'],
									$row['nomeTecnico'],
									$row['telefonemas_info'],
									$row['associacao']
								)
							);
						}
					}
				}
			}

		}else{
			foreach ($listaBuscada AS $row) {
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
						$row['status'],
						$row['nomeTecnico'],
						$row['telefonemas_info'],
						$row['associacao']
					)
				);
			}
		}

		$data['page'] = $page;
		$data['total'] = $listaBuscadaNumeroResultados[0]['total'];

		echo json_encode($data);
	}

	// TODO: fazer metodos padrao nas models proprias
	private function buscaListaFonteDados($dados, $numeroPagina, $numeroPorPagina, $sortname, $sortorder, $limit_condition) {

		// busca instalacoes com incidente
		$sql = "SELECT COUNT(*) AS total 
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
	        WHERE 1 = 1 " . PHP_EOL;


		if(!empty($limit_condition)) {
			$sql = "SELECT 
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

			        WHERE 1 = 1 " . PHP_EOL;
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
			if( isset($atendimento['cronometro']['final_tarefa']) )
			{
				if(
					$atendimento['cronometro']['final_tarefa'] == '' ||
					$atendimento['cronometro']['final_tarefa'] == '0000-00-00 00:00:00' ||
					$atendimento['cronometro']['final_tarefa'] == NULL
				) {
					$listaIncidentes[$chave]['data_final'] = '-';
				}else {
					$listaIncidentes[$chave]['data_final'] = $atendimento['cronometro']['final_tarefa'];
				}
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
			if( $this->Usuarios_sp->getnome() != '' ) {
				$listaIncidentes[$chave]['nomeTecnico'] = $this->Usuarios_sp->getnome();
			}else {
				$listaIncidentes[$chave]['nomeTecnico'] = '';
			}
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

		$cronometro = $this->trataDateFromatCronometro( $cronometro ); //inicio e final tarefa


		//tratamento sem lugar
		$incidente = $this->Incidentes_sp->getincidenteArray();

//		echo die_json($incidente);

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
//		echo die_json('teste');
		if ( empty($this->dadosP['param']) )
			exit('Id do incidente nÃ£o encontrado.');


		$this->incidenteFacade( $this->dadosP['param'] );

		$idincidentes = new Integer( $this->incidenteFacade['obj']['idincidentes'] );
		$ultimoAtendimento = $this->Atendimento_sp->getUltimoAtendimentoDeIncidente($idincidentes);

		$ultimoAtendimento['atendimento'] = nl2br($ultimoAtendimento['atendimento']);
		$ultimoAtendimento['privado'] = nl2br($ultimoAtendimento['privado']);
		$ultimoAtendimento['perfil_atend'] = $_SESSION['login']['perfis_idperfis'];


		$solicitacoes = $this->DBSolicitacao->liste();
		foreach($solicitacoes as $sol){
			if($sol['idsolicitacao'] == $this->incidenteFacade['obj']['solicitacao_idsolicitacao']){
				$solicitacao = $sol['nomeSolicitacao'];
			}
		}
		$this->incidenteFacade['obj']['solicitacao'] = $solicitacao;
		$this->DBCronometro->setIdreferencia($this->dadosP['idatend']);
		$this->DBCronometro->setTabelareferencia('atend_vsat_sp');

		$cronometro = $this->DBCronometro->buscaCronometro();

		$listaUsuarios = $this->DBUsuarios->liste('incidentes = 1');

		$dados_atual = $this->DBOS_antigo->lista_os_sp_servicos($this->incidenteFacade['obj']['instalacoes_sp'][0]['os_sp_idos']);
		$num_os_sp = $dados_atual[0]['num_os_sp'];

//		echo die_json($ultimoAtendimento);

//		echo die_json($ultimoAtendimento['usuario']['nome']);
//        print_b($ultimoAtendimento);

		$this->smarty->assign( 'listaUsuarios' , $listaUsuarios );
		$this->smarty->assign( 'atendimento' , $ultimoAtendimento );
		$this->smarty->assign( 'idatend' , $this->dadosP['idatend'] );
		$this->smarty->assign( 'tecnicoResponsavel' , $this->incidenteFacade['tecnicoResponsavel'] );
		$this->smarty->assign( 'cronometro' , $this->incidenteFacade['cronometro'] );
		$this->smarty->assign( 'controle' , $cronometro);
		$this->smarty->assign( 'status' , $this->incidenteFacade['status'] );
		$this->smarty->assign( 'tempoTranscorrido' , $this->incidenteFacade['tempoTranscorrido'] );
//		$this->smarty->assign( 'tempoTranscorrido' , $this->tempoTranscorrido);
		$this->smarty->assign( 'obj' , $this->incidenteFacade['obj'] );
		$this->smarty->assign( 'num_os_sp' ,$num_os_sp);
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

	public function trocaResponsavel(){

		$user = $this->dadosP['form']['usuarios_idusuarios'];
		$sala = ($this->dadosP['form']['sala']? $this->dadosP['form']['sala'] : '2');
		$linhasIncidentes['incidentes_sp_idincidentes'] = $this->dadosP['form']['idincidente'];

		if($this->dadosP['form']['tecnico_ticket']){
			$this->alterarTecnicoResponsavel($linhasIncidentes, $user);
		}
		
		$sql = "
    		UPDATE atend_vsat_sp
    		SET usuarios_idusuarios = '$user', sala = $sala
    		WHERE idatend_vsat = '{$this->dadosP['form']['idatendVsat']}';
    	";
		$result = $this->DB->query($sql);
		if( !$result )
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Erro ao atualizar a troca.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
//     	}

		die_json(array(
			"msg" => "<div class='alert alert-success' style='float:left;'>Responsavel atualizado com sucesso.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
			"status" => "ok"
		));
	}

	public function alterarTecnicoResponsavel($linhasIncidentes, $idusuario){

		$inteiro = new Integer($idusuario);
		$usuario = $inteiro->numero();

		$idincidentes = $linhasIncidentes['incidentes_sp_idincidentes'];
		$sql = "
            		UPDATE incidentes_sp
            		SET tecnicoNoc = $usuario
            		WHERE idincidentes = $idincidentes
            	";
		$this->DBPadrao->query($sql);
	}

	// mÃ©todo feito para php 5.3 adiante
	private function resolveTempoTranscorrido( $cronometro )
	{
		$dataInicial = (!empty($cronometro['inicio_tarefa']) &&	$cronometro['inicio_tarefa'] != '0000-00-00 00:00:00'
		)? new  DateTime( $cronometro['inicio_tarefa'] ) : '' ;

		$dataFinal = (!empty($cronometro['final_tarefa']) && $cronometro['final_tarefa'] != '0000-00-00 00:00:00'
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
			$tempoIntervalo = 'Sem cronometro';
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
//		print_b($cronometroDePrimeiroAtendimento,true);


		//$cronometroAtendimento
		$dataFinalCronometro = ( $cronometroDeUltimoAtendimento['final_tarefa'] != '' )? $cronometroDeUltimoAtendimento['final_tarefa'] : '' ;
		$dataInicioCronometro = ( $cronometroDePrimeiroAtendimento['inicio_tarefa'] != '' )? $cronometroDePrimeiroAtendimento['inicio_tarefa'] : '' ;
		$dataInicio 		  = ( $cronometroDePrimeiroAtendimento['data_inicio'] != '' )? $cronometroDePrimeiroAtendimento['data_inicio'] : '' ;
		$ordem 		  = ( $cronometroDePrimeiroAtendimento['ordem'] != '' )? $cronometroDePrimeiroAtendimento['ordem'] : '' ;
		$data_pausa 		  = ( $cronometroDePrimeiroAtendimento['data_pausa'] != '' )? $cronometroDePrimeiroAtendimento['data_pausa'] : '' ;
		return array(
			'final_tarefa' => $dataFinalCronometro,
			'inicio_tarefa' => $dataInicioCronometro,
			'data_inicio' => $dataInicio,
			'ordem'			=> $ordem,
			'data_pausa'		=> $data_pausa,

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
		$solicitacao = $this->DBSolicitacao->liste();
		$tipoIncidente = $this->DBTipoInc->liste();
		$testeDemo = $this->DBTesteDemo->liste();

		$this->Usuarios_sp->getListaUsuariosIncidente();

		$this->smarty->assign( 'data_fim' , $this->incidenteFacade['cronometro']['final_tarefa'] );
		$this->smarty->assign('empresa',$_SESSION['login']['empresas_idempresas']);
		$this->smarty->assign( 'listaUsuarios' , $this->Usuarios_sp->getlistaUsuarios() );
		$this->smarty->assign( 'solicitacao' , $solicitacao);
		$this->smarty->assign( 'tipoIncidente' , $tipoIncidente);
		$this->smarty->assign( 'testeDemo' , $testeDemo);
		$this->smarty->assign( 'perfil_incidente' , $_SESSION['login']['perfis_idperfis']);
		$this->smarty->assign( 'obj' , $this->incidenteFacade['obj'] );
		$this->smarty->display( "{$this->tplDir}/edit.tpl" );
	}

	public function update()
	{

		if ( ! empty($this->dadosP['form']) )
		{

			$idincidente = new Integer($this->dadosP['form']['idincidentes']);

			$this->updateIncidentes( $idincidente , $this->dadosP['form'] );
	
			if( isset($form['data_fim']) && $form['data_fim'] != '' )
				$this->updateCronometro( $idincidente , $this->dadosP['form'] );


			$where = 'incidentes_sp_idincidentes='.$this->dadosP['form']['idincidentes'];
			$idatend_vsat = $this->DBAtend_vsat->liste($where);

			$idteste_demo = $this->dadosP['form']['teste_demo_idteste'];			

			$this->Atendimento_sp->setidatend_vsat($idatend_vsat[0]['idatend_vsat']);
			$this->Atendimento_sp->setdata($idatend_vsat[0]['data']);
			$this->Atendimento_sp->setmensagem($idatend_vsat[0]['mensagem']);
			$this->Atendimento_sp->setatendimento($idatend_vsat[0]['atendimento']);
			$this->Atendimento_sp->setstatus_atend_idstatus_atend($idatend_vsat[0]['status_atend_idstatus_atend']);
			$this->Atendimento_sp->setinstalacoes_sp_idinstalacoes_sp($idatend_vsat[0]['instalacoes_sp_idinstalacoes_sp']);
			$this->Atendimento_sp->setsolicitacao_sp_idsolicitacao($this->dadosP['form']['solicitacao_idsolicitacao']);
			$this->Atendimento_sp->settipo_incidente_sp_idtipo($this->dadosP['form']['tipo_incidente_idtipo']);
			$this->Atendimento_sp->setteste_demo_sp_idteste($idteste_demo);
			$this->Atendimento_sp->setusuarios_idusuarios($idatend_vsat[0]['usuarios_idusuarios']);
			$this->Atendimento_sp->setincidentes_sp_idincidentes($idatend_vsat[0]['incidentes_sp_idincidentes']);
			$this->Atendimento_sp->settipo_atendimento_idtipo_atendimento($idatend_vsat[0]['tipo_atendimento_idtipo_atendimento']);
			$this->Atendimento_sp->setsaom($idatend_vsat[0]['saom']);

			//$ar['msg'] = 'teste2'; die_json($ar);

			$criaAtend = $this->Atendimento_sp->edit(); // TODO: tarefa da model

			//echo "teste: ".$criaAtend;exit;
			if( $criaAtend == false )
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Erro ao registrar atendimento.';
				die_json($arrReturn);
			}

			$resposta = $this->respostaUpdate( $this->Incidentes_sp->edit() , $this->Cronometro_sp->edit() );

			exit($resposta);
		}
		else
			exit("Nenhum formulÃ¡rio presente.");
	}


	public function pausar(){

		$dataAtual = date('Y-m-d H:i:s');
		$tempotrans = explode(" ",$this->dadosP['form']['tempotrans']);
		$t = explode(":",$tempotrans[1]);
		$tempo = ((strlen($t[0])==2)?$t[0]:"0".$t[0]).":".((strlen($t[1])==2)?$t[1]:"0".$t[1]).":".((strlen($t[2])==2)?$t[2]:"0".$t[2]);
		$tempotrans = $tempotrans[0].' '.$tempo;

		$sql = "
		UPDATE cronometro_sp
		SET data_pausa = '{$dataAtual}', interrupcoes = '{$tempotrans}'
		WHERE idreferencia = '{$this->dadosP['form']['idatend']}';";

		if(	$this->DB->query($sql))
		{
			$arrReturn['status'] = 'ok';
			$arrReturn['msg'] = 'Atendimento despausado com sucesso.';
		}
		else
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Erro ao criar pausa.';
		}
		die_json($arrReturn);
	}

	public function despausar(){

		$tmpFinal = date('H:i:s');
		$tempotrans = explode(" ",$this->dadosP['form']['tempotrans']);
//		$tempoAtual = explode(" ",$this->dadosP['form']['tempoAtual']);

		$tmpFinal = explode(":", $tmpFinal);
		$ss_fn = ($tmpFinal[0] * 3600) + ($tmpFinal[1] * 60) + ($tmpFinal[2]);

		$tmpInicial = explode(":", $tempotrans[1]);
		$ss_in = ($tmpInicial[0] * 3600) + ($tmpInicial[1] * 60) + ($tmpInicial[2]);

		$ss_rs = $ss_fn - $ss_in;
		$ss_rs = str_replace("-","",$ss_rs);
		// Agora formata novamente a data ...

		if($ss_fn < $ss_in){
			$this->time = true;
		}else{
			$this->time = false;
		}

		$nn_rs = 0;
		$hr_rs = 0;
		while($ss_rs > 59){
			$ss_rs = $ss_rs - 60;
			$nn_rs = $nn_rs + 1;
			if($nn_rs>=60){
				$nn_rs = 0;
				$hr_rs = $hr_rs + 1;
			}
		}

		$hr_rs = ((!$hr_rs)?"00":$hr_rs);
		$nn_rs = ((!$nn_rs)?"00":$nn_rs);
		$ss_rs = ((!$ss_rs)?"00":$ss_rs);
//			$a['msg']= ($nn_rs);
//			die_json($a);

		if($this->time == true){
			$hr_rs = 24-$hr_rs;
			if($tmpInicial[1] > $tmpFinal[1]){
				$t = substr($tempotrans[0],0,-1);
				$nn_rs = 60 - $nn_rs;
				$hr_rs  = $hr_rs - 1;
				$dateDia = $t[0] + 1;
				$m = date("m");
				$d = date("d")-$dateDia;
			}else{
				$t = substr($tempotrans[0],0,-1);
				$hr_rs  = $hr_rs - 1;
				$dateDia = $t[0] + 1;
				$m = date("m");
				$d = date("d")-$dateDia;

			}
		}else{
			$t = substr($tempotrans[0],0,-1);
			$dateDia = $t;
			if((date("d")>$dateDia)!=true){
				$d = 30 - ($dateDia - date("d"));
 				$m = date("m") - 1;


			}else{
				$m = date("m");
				$d = date("d")-$dateDia;
			}
		}

		$data = ((strlen($hr_rs)==2)?$hr_rs:"0".$hr_rs).":".
				((strlen($nn_rs)==2)?$nn_rs:"0".$nn_rs).":".
				((strlen($ss_rs)==2)?$ss_rs:"0".$ss_rs);

		$m = ((strlen($m)==2)?$m:"0".$m);

		$inicio =  date('Y-'.$m.'-'.$d).' '.$data;
		$sql = "
		UPDATE cronometro_sp
		SET inicio_tarefa = '$inicio', interrupcoes = NULL, data_pausa = NULL
		WHERE idreferencia = '{$this->dadosP['form']['idatend']}';";

		if(	$this->DB->query($sql))
		{
			$arrReturn['status'] = 'ok';
			$arrReturn['msg'] = 'Atendimento despausado com sucesso.';
		}
		else
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Erro ao criar pausa.';
		}
		die_json($arrReturn);

		unset($ss_rs, $hr_rs, $nn_rs);
	}




	private function updateIncidentes(Integer $idincidente , Array $form )
	{

		$this->Incidentes_sp->setidincidentes( $idincidente );
		$this->Incidentes_sp->setdata( $this->Helpers->data_br_us( $form['data'] ) );
//		$this->Incidentes_sp->setidprodemge( $form['idprodemge'] );
		$this->Incidentes_sp->setdescricao( $form['descricao'] );
		$this->Incidentes_sp->setsolicitacao_idsolicitacao( $form['solicitacao_idsolicitacao'] );
		$this->Incidentes_sp->settipo_incidente_idtipo( $form['tipo_incidente_idtipo'] );
		$this->Incidentes_sp->setteste_demo_idteste($form['teste_demo_idteste'] );
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
			return "Incidente editado porem não houve modificação na Data Final.";
		else if( $respostaIncidente == 'erro' && $respostaCronoemtroDeAtendimento == 'ok' )
			return "Apenas a Data Final foi editada.";
		else
			return "Não houve modificação em Incidente.";
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

	}public function periodo(){

			$this->smarty->display("{$this->tplDir}/data.tpl");
	}


	public function relatorio()
	{

		if ($_POST['data_inicio'] && $_POST['data_fim']){
			$dataI = $this->Helpers->data_br_us($_POST['data_inicio'] );
			$dataF = $this->Helpers->data_br_us($_POST['data_fim']);
//			if($_SESSION['login']['empresas_idempresas'] == 66){
//				$where = "WHERE inci.`data` BETWEEN '$dataI' AND '$dataF' AND ' os.empresas_idempresas ='{$_SESSION['login']['empresas_idempresas']}'";
//			}else{
//			}
				$where = "WHERE inci.`data` BETWEEN '$dataI' AND '$dataF'";
		}else{
//			if($_SESSION['login']['empresas_idempresas'] == 66){
//				$where ="WHERE os.empresas_idempresas ='{$_SESSION['login']['empresas_idempresas']}'";
//			}else{
//
//			}
			$where ="";
		}

		$this->relatorioContent($where);


		$campos = "Nº Ticket;Abertura;Data Modificacao;Vsat;Empresa;Tipo Ticket;Tipo Incidente;Teste Demo;Descricao;Ultimo Responder;Motivo;Status;Satisfacao";
//		$campos = "Nº Ticket;Abertura;Vsat;Cliente;Tipo Ticket;Tipo Incidente;Descricao;Ultimo Responder;Motivo;Status";
		$this->smarty->assign('campos',utf8_decode($campos));
		$valores = $this->arr;

		$this->smarty->assign('arr',$valores);

		$text = $this->smarty->fetch("{$this->tplDir}/relatorio_1.tpl");

		$arquivo = 'relatorio_Ticket_'.date('d-m-Y').'.csv';

		header("Content-Description: PHP Generated Data");
		header("Content-type: application/x-msexcel");
		header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		echo $text;
	}

	//tratamento do conteudo do csv (separado para o teste unitario)

//	private function relatorioContent($where)
//	{
//
//		//TODO: arrumar isso
//		$sql = "SELECT DISTINCT inci.idincidentes, inci.`data`, ins.nome, emp.empresa, sol.nomeSolicitacao, tis.nomeTipo,
//				inci.descricao, av.atendimento, cro.ordem, ma.motivo ,st.status
//
//				FROM associacao_instalacao_incidente_sp  aii
//
//				LEFT JOIN incidentes_sp 						inci  	ON (inci.idincidentes = aii.idincidentes)
//				LEFT JOIN atend_vsat_sp 						av    	ON (av.incidentes_sp_idincidentes  = inci.idincidentes)
//				LEFT JOIN instalacoes_sp						ins   	ON (aii.idinstalacoes_sp = ins.idinstalacoes_sp)
//				LEFT JOIN solicitacao_sp						sol		ON (inci.solicitacao_idsolicitacao = sol.idsolicitacao)
//				LEFT JOIN tipo_incidente_sp						tis		ON (inci.tipo_incidente_idtipo = tis.idtipo)
//				LEFT JOIN teste_demo_sp							tds		ON (inci.teste_demo_idteste = tds.idteste)
//				LEFT JOIN atendimento_motivo_responsavel_sp		amr		ON (av.idatend_vsat 			= amr.idatendimento)
//				LEFT JOIN motivo_atendimento_sp			  		ma		ON (amr.idmotivo 				= ma.idmotivo_atendimento)
//				LEFT JOIN cronometro_sp							cro   	ON (av.idatend_vsat = cro.idreferencia)
//				LEFT JOIN status_atend 							st    	ON (av.status_atend_idstatus_atend = st.idstatus_atend)
//				LEFT JOIN os_sp 								os		ON (ins.os_sp_idos = os.idos)
//				LEFT JOIN empresas								emp		ON (os.empresas_idempresas = emp.idempresas)
//
//				$where
//
//				ORDER BY inci.idincidentes DESC
//
//		";
////		stf.avaliacao,
////				LEFT JOIN satisfacao							stf		ON (av.idatend_vsat = stf.idatend)
//
//		$this->arr = $this->Incidentes_sp->executaSql($sql);
//
//
//			$dadosCarac = array();
//		for($i=0;$i<count($this->arr);$i++){
//
//			$pattern = $this->arr[$i]['atendimento'];
//			$pattern = strip_tags($pattern);
//			$pattern = preg_replace("@\n@"," ",$pattern);
//			$pattern = str_replace("&nbsp;"," ",$pattern);
//			$pattern = str_replace(" ","",$pattern);
//			$conta = strlen($pattern);
//
//
//			$x = 0;
//			$caracteres = "";
//			while($x < $conta) {
//				$letra = $pattern[$x];
//
////			echo die_json(preg_match("([A-Z])", $letra));
//				if(preg_match("([A-Z])", $letra) && ($x != 0)) {
//					$caracteres .= " ".$letra;
//				} else {
//					$caracteres .= $letra."";
//				}
//
//				$x++;
//			}
//			echo die_json($caracteres);
//
//
////			$primeiro = strpos($pattern, 'Publicado em:');
////			$totalCrac = $totalCrac - ($primeiro + 13);
////			$pattern = substr($pattern, ($primeiro + 13), $totalCrac);
//
//
//
//
//			$descricao = str_replace("\r\n","",trim($this->arr[$i]['descricao']));
//			$descricao = str_replace("\n","",trim($descricao));
//			$descricao = str_replace("<br/>","",trim($descricao));
//			$descricao = str_replace("<br>","",trim($descricao));
//			$this->arr[$i]['descricao'] = $descricao;
//
//		}
//
//	}

	private function relatorioContent($where)
	{

		//TODO: arrumar isso
		$sql = "SELECT DISTINCT inci.idincidentes, inci.`data`, inci.data_modificacao, ins.nome, emp.empresa, sol.nomeSolicitacao, tis.nomeTipo, tds.nomeTeste,
				inci.descricao ,cro.ordem, ma.motivo ,st.status, stf.avaliacao

				FROM associacao_instalacao_incidente_sp  aii

				LEFT JOIN incidentes_sp 						inci  	ON (inci.idincidentes = aii.idincidentes)
				LEFT JOIN atend_vsat_sp 						av    	ON (av.incidentes_sp_idincidentes  = inci.idincidentes)
				LEFT JOIN instalacoes_sp						ins   	ON (aii.idinstalacoes_sp = ins.idinstalacoes_sp)
				LEFT JOIN solicitacao_sp						sol		ON (inci.solicitacao_idsolicitacao = sol.idsolicitacao)
				LEFT JOIN tipo_incidente_sp						tis		ON (inci.tipo_incidente_idtipo = tis.idtipo)
				LEFT JOIN teste_demo_sp							tds		ON (inci.teste_demo_idteste = tds.idteste)
				LEFT JOIN atendimento_motivo_responsavel_sp		amr		ON (av.idatend_vsat 			= amr.idatendimento)
				LEFT JOIN motivo_atendimento_sp			  		ma		ON (amr.idmotivo 				= ma.idmotivo_atendimento)
				LEFT JOIN cronometro_sp							cro   	ON (av.idatend_vsat = cro.idreferencia)
				LEFT JOIN status_atend 							st    	ON (av.status_atend_idstatus_atend = st.idstatus_atend)
				LEFT JOIN os_sp 								os		ON (ins.os_sp_idos = os.idos)
				LEFT JOIN empresas								emp		ON (os.empresas_idempresas = emp.idempresas)
				LEFT JOIN satisfacao							stf		ON (av.idatend_vsat = stf.idsatisfacao)
				$where

				ORDER BY inci.idincidentes DESC

		";

		$this->arr = $this->Incidentes_sp->executaSql($sql);

		for($i=0;$i<count($this->arr);$i++){
			$descricao = str_replace("\r\n","",trim($this->arr[$i]['descricao']));
			$descricao = str_replace("\n","",trim($descricao));
			$descricao = str_replace("<br/>","",trim($descricao));
			$descricao = str_replace("<br>","",trim($descricao));
			$this->arr[$i]['descricao'] = $descricao;

		}

	}


	public function RetiraAssociacaoComInstalacao()
	{
		$dados = $this->dadosP;
		$this->Instalacao_sp->getInstalacaoPeloNome( $dados['nomeInstalacao'] );
		$this->AssociacaoInstalacaoIncidente_sp->setidinstalacoes_sp( $this->Instalacao_sp->getidinstalacoes_sp() );
		$this->AssociacaoInstalacaoIncidente_sp->setidincidentes( $dados['idincidentes'] );
		if( $this->AssociacaoInstalacaoIncidente_sp->apagarAssociacao() )
			echo "Instalação retirada com sucesso.";
		else
			echo "Erro ao retirar Instalação.";
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
		else if($_POST['solicitacao']== '')
		{
			echo "vazioSolicitacao"; exit;
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

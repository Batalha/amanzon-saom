<?php

//zend
include_once 's_p/model/Saom_spModel.php';
require_once 's_p/model/Clientes_spModel.php';

//converte degrees minutes seconds to decimal
include_once ("libs/ConvertDegreesToGoogleMaps.php");//tirar a primeira barra quando for subir para o servidor
include_once 's_p/model/DBOS_SP.php';
include_once "s_p/model/DBEmpresas_sp.php";
include_once "s_p/model/DBUsuario_sp.php";
include_once "s_p/model/DBSatelites_sp.php";
include_once "s_p/model/DBEscricaoFornecimento_sp.php";
include_once 'helpers.class.php';



class OSSP extends Controller
{


	protected $tplDir = 's_p/tampletes/OSSP';
	protected $arr;

	//
	protected $page = 1;
	protected $sortname = 'os_dataSolicitacao';
	protected $sortorder = 'DESC';
	protected $qtype;
	protected $query;
	protected $campo;
	protected $rp = 20;

	public function __construct()
	{
		parent::__construct();

		$this->DBOS_antigo = new DBOS_SP();
		$this->DBEmpresas = new DBEmpresas_sp();
		$this->DBUsuarios = new DBUsuario_sp();
		$this->DBSatelites = new DBSatelites_sp();
		$this->DBEscricaoFornecimento = new DBEscricaoFornecimento_sp();
		$this->helpers = new Helpers();
	}

	public function create()
	{

		if (!empty($this->dadosP['param'])) {
			$this->smarty->assign('param', $this->dadosP['param']);
		}

		$satelites = $this->DBSatelites->listaSatelites();
		$escricoes = $this->DBEscricaoFornecimento->listaEscricaoFornecimento();
		$empresas = $this->DBEmpresas->listaEmpresas();
		if ($_SESSION['login']['empresas_idempresas'] == 2)
			foreach ($empresas AS $chave => $empresa) {
				if ($empresa['idempresas'] != 2)
					unset($empresas[$chave]);
			}

		$this->smarty->assign('satelites', $satelites);
		$this->smarty->assign('escricoes', $escricoes);
		$this->smarty->assign('empresas', $empresas);
		$this->smarty->display("{$this->tplDir}/new.tpl");

	}
	public function telefonica(){
		$form = $this->dadosP['form'];

		$this->dadosP['form']['iduser_cadastro'] = $form['tel_iduser_cadastro'];
		$this->dadosP['form']['clientes_idcliente'] = $form['tel_clientes_idcliente'];
		$this->dadosP['form']['empreiteira_idempresas'] = $form['tel_empreiteira_idempresas'];
		$this->dadosP['form']['numOS'] = $form['tel_numOS'];
		$this->dadosP['form']['identificador'] = $form['tel_identificador'];
		$this->dadosP['form']['contato'] = $form['tel_contato'];
		$this->dadosP['form']['telContato'] = $form['tel_telContato'];
		$this->dadosP['form']['outroTelContato'] = $form['tel_outroTelContato'];
		$this->dadosP['form']['cep'] = $form['tel_cep'];
		$this->dadosP['form']['pais'] = $form['tel_pais'];
		$this->dadosP['form']['enderecoInstal'] = $form['tel_enderecoInstal'];
		$this->dadosP['form']['cidade'] = $form['tel_cidade'];
		$this->dadosP['form']['estado'] = $form['tel_estado'];
		$this->dadosP['form']['mirDownload'] = $form['tel_mirDownload'];
		$this->dadosP['form']['cirDownload'] = $form['tel_cirDownload'];
		$this->dadosP['form']['iplan1'] = $form['tel_iplan1'];
		$this->dadosP['form']['iplanMask1'] = $form['tel_iplanMask1'];
		$this->dadosP['form']['mirUpload'] = $form['tel_mirUpload'];
		$this->dadosP['form']['cirUpload'] = $form['tel_cirUpload'];
		$this->dadosP['form']['iplan2'] = $form['tel_iplan2'];
		$this->dadosP['form']['iplanMask2'] = $form['tel_iplanMask2'];
		$this->dadosP['form']['empresas_idempresas'] = $form['tel_empresas_idempresas'];


		if(!$this->dadosP['form']['numOS'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Numero da OS náo pode esta vazio';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['identificador'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Identificador náo pode esta vazio';
			die_json($arrReturn);
		}
		//busca saom
		$saom = new Saom_spModel( $this->adapter->getAdapterZend() );
		$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
		$this->dadosP['form']['saom'] = $saom_row->id_saom;

		//VERIFICA 'NUMERO DA OS' E 'IDENTIFICADOR' PARA NAO GERAR REPETIDOS
		$sql = "SELECT count(*) as total FROM os_sp WHERE numOS LIKE '{$this->dadosP['form']['numOS']}'";
		$buscaNumOs = $this->DBOS_antigo->queryDados($sql);

		if($buscaNumOs[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Número da OS já existe.';
			die_json($arrReturn);
		}

		$sql = "SELECT count(*) as total FROM os_sp WHERE identificador LIKE '{$this->dadosP['form']['identificador']}'";
		$buscaIdentificador = $this->DBOS_antigo->queryDados($sql);
		if($buscaIdentificador[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Identificador já existe.';
			die_json($arrReturn);
		}

		if(!($this->dadosP['form']['contato'] || $this->dadosP['form']['telContato']|| $this->dadosP['form']['enderecoInstal']))
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Por Favor preencha todos os campos!';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['empresas_idempresas'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Por Favor Seleciona um Cliente';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['empresas_idempresas'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Cliente Nao Cadastrado';
			die_json($arrReturn);
		}

		$return  = $this->DBOS_antigo->create($this->dadosP['form']);

		if($return){
			$this->dadosP['form']['idos'] = "$return";
			$this->dadosP['form']['qtlinha'] = '0';
			$this->new_atual_os();

		}

//		if(count($return['erros']))
//		{
//			$arrReturn['status'] = 'erro';
//			$arrReturn['msg']    = implode("<hr>", $return['erros']);
//		}
//		else
//		{
//		}
		$arrReturn['status']  = 'ok';
		$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
		die_json($arrReturn);


	}

	public function createAtiOs(){
		$form = $this->dadosP['form'];

		$this->dadosP['form']['iduser_cadastro'] = $form['ati_iduser_cadastro'];
		$this->dadosP['form']['clientes_idcliente'] = $form['ati_clientes_idcliente'];
		$this->dadosP['form']['empreiteira_idempresas'] = $form['ati_empreiteira_idempresas'];
		$this->dadosP['form']['numOS'] = $form['ati_numOS'];
		$this->dadosP['form']['identificador'] = $form['ati_identificador'];
		$this->dadosP['form']['orgao'] = $form['ati_orgao'];
		$this->dadosP['form']['acesso'] = $form['ati_acesso'];
		$this->dadosP['form']['unidade'] = $form['ati_unidade'];
		$this->dadosP['form']['contato'] = $form['ati_contato'];
		$this->dadosP['form']['inep'] = $form['ati_inep'];
		$this->dadosP['form']['telContato'] = $form['ati_telContato'];
		$this->dadosP['form']['outroTelContato'] = $form['ati_outroTelContato'];
		$this->dadosP['form']['outroTelContato2'] = $form['ati_outroTelContato2'];
		$this->dadosP['form']['email'] = $form['ati_email'];
		$this->dadosP['form']['cep'] = $form['ati_cep'];
		$this->dadosP['form']['pais'] = $form['ati_pais'];
		$this->dadosP['form']['enderecoInstal'] = $form['ati_enderecoInstal'];
		$this->dadosP['form']['cidade'] = $form['ati_cidade'];
		$this->dadosP['form']['estado'] = $form['ati_estado'];
		$this->dadosP['form']['area_instal'] = $form['ati_area_instal'];
		$this->dadosP['form']['tipo_equip'] = $form['ati_tipo_equip'];
		$this->dadosP['form']['lat_g'] = $form['ati_lat_g'];
		$this->dadosP['form']['lat_m'] = $form['ati_lat_m'];
		$this->dadosP['form']['lat_s'] = $form['ati_lat_s'];
		$this->dadosP['form']['long_g'] = $form['ati_long_g'];
		$this->dadosP['form']['long_m'] = $form['ati_long_m'];
		$this->dadosP['form']['long_s'] = $form['ati_long_s'];
		$this->dadosP['form']['mirDownload'] = $form['ati_mirDownload'];
		$this->dadosP['form']['cirDownload'] = $form['ati_cirDownload'];
		$this->dadosP['form']['mirUpload'] = $form['ati_mirUpload'];
		$this->dadosP['form']['cirUpload'] = $form['ati_cirUpload'];
		$this->dadosP['form']['end_rede'] = $form['ati_end_rede'];
		$this->dadosP['form']['end_lan'] = $form['ati_end_lan'];
		$this->dadosP['form']['wan_fw'] = $form['ati_wan_fw'];
		$this->dadosP['form']['ip_lan_fw'] = $form['ati_ip_lan_fw'];
		$this->dadosP['form']['router'] = $form['ati_router'];
		$this->dadosP['form']['empresas_idempresas'] = $form['ati_empresas_idempresas'];
		$this->dadosP['form']['observacoes'] = $form['ati_observacoes'];
		$this->dadosP['form']['dataSolicitacao'] = $form['ati_dataSolicitacao'];
		$this->dadosP['form']['prazoInstal'] = $form['ati_prazoInstal'];


		if(!$this->dadosP['form']['numOS'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Numero da OS náo pode esta vazio';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['identificador'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Identificador náo pode esta vazio';
			die_json($arrReturn);
		}
		//busca saom
		$saom = new Saom_spModel( $this->adapter->getAdapterZend() );
		$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
		$this->dadosP['form']['saom'] = $saom_row->id_saom;

		//VERIFICA 'NUMERO DA OS' E 'IDENTIFICADOR' PARA NAO GERAR REPETIDOS
		$sql = "SELECT count(*) as total FROM os_sp WHERE numOS LIKE '{$this->dadosP['form']['numOS']}'";
		$buscaNumOs = $this->DBOS_antigo->queryDados($sql);
		if($buscaNumOs[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Número da OS já existe.';
			die_json($arrReturn);
		}

		$sql = "SELECT count(*) as total FROM os_sp WHERE wan_fw LIKE '{$this->dadosP['form']['wan_fw']}'";
		$buscaWanFw = $this->DBOS_antigo->queryDados($sql);
		if($buscaWanFw[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Wan Fw já existe.';
			die_json($arrReturn);
		}

		$sql = "SELECT count(*) as total FROM os_sp WHERE ip_lan_fw LIKE '{$this->dadosP['form']['ip_lan_fw']}'";
		$buscaWanFw = $this->DBOS_antigo->queryDados($sql);
		if($buscaWanFw[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'IP Lan Fw já existe.';
			die_json($arrReturn);
		}

		$sql = "SELECT count(*) as total FROM os_sp WHERE router LIKE '{$this->dadosP['form']['router']}'";
		$buscaWanFw = $this->DBOS_antigo->queryDados($sql);
		if($buscaWanFw[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Router já existe.';
			die_json($arrReturn);
		}

		$sql = "SELECT count(*) as total FROM os_sp WHERE identificador LIKE '{$this->dadosP['form']['identificador']}'";
		$buscaIdentificador = $this->DBOS_antigo->queryDados($sql);
		if($buscaIdentificador[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Identificador já existe.';
			die_json($arrReturn);
		}

		if(!($this->dadosP['form']['contato'] || $this->dadosP['form']['telContato']|| $this->dadosP['form']['enderecoInstal']))
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Por Favor preencha todos os campos!';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['empresas_idempresas'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Por Favor Seleciona um Cliente';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['empresas_idempresas'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Cliente Nao Cadastrado';
			die_json($arrReturn);
		}

		$return  = $this->DBOS_antigo->create($this->dadosP['form']);

		if($return){
			$this->dadosP['form']['idos'] = "$return";
			$this->dadosP['form']['qtlinha'] = '0';
			$this->new_atual_os();
		}

//		if(count($return['erros']))
//		{
//			$arrReturn['status'] = 'erro';
//			$arrReturn['msg']    = implode("<hr>", $return['erros']);
//		}
//		else
//		{
//		}
		$arrReturn['status']  = 'ok';
		$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';

		die_json($arrReturn);


	}

	public function createOutrosCanais(){

		$saom = new Saom_spModel( $this->adapter->getAdapterZend() );
		$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
		$this->dadosP['form']['saom'] = $saom_row->id_saom;

		//VERIFICA 'NUMERO DA OS' E 'IDENTIFICADOR' PARA NAO GERAR REPETIDOS
		$sql = "SELECT count(*) as total FROM os_sp WHERE numOS LIKE '{$this->dadosP['form']['numOS']}'";
		$buscaNumOs = $this->DBOS_antigo->queryDados($sql);


		if($this->dadosP['form']['speednet'] == 'nao'){
			$this->dadosP['form']['speedTipo'] = "";	
		}

		if($this->dadosP['form']['outrospeed']){
			$this->dadosP['form']['speedTipo'] = $this->dadosP['form']['outrospeed'];
		}
		

		if($this->dadosP['form']['speedTipo'] == 'outros'){
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Selecione um SpeedNet';
			die_json($arrReturn);
		}

		
		if($buscaNumOs[0]['total']>0)
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Número da OS já existe.';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['empresas_idempresas'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Por Favor Seleciona um Cliente';
			die_json($arrReturn);
		}

		if(!$this->dadosP['form']['empresas_idempresas'])
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Cliente Nao Cadastrado';
			die_json($arrReturn);
		}

		if($this->dadosP['form']['qtlinha'] == ""){
			$this->dadosP['form']['qtlinha'] = '0';
		}

		$return  = $this->DBOS_antigo->create($this->dadosP['form']);

		if($return){

			$this->dadosP['form']['idos'] = "$return";
			$this->dadosP['form']['iplan'] = '';
			$this->new_atual_os();
		}

		$arrReturn['status']  = 'ok';
		$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';

//		$a['msg'] = $return;
//		die_json($a);

		die_json($arrReturn);
	}



	public function edit()
	{
		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{
			$this->DBOS_antigo->setPrkValue($this->dadosP['param']);
			$dados = $this->DBOS_antigo->view();
//			print_b($dados,true);

//			$municipios = $this->DBMunicipio->liste();
			$empresas = $this->DBEmpresas->listaEmpresas();
			if( $_SESSION['login']['empresas_idempresas'] == 2 )
				foreach( $empresas AS $chave => $empresa )
				{
					if( $empresa['idempresas'] != 2 )
						unset( $empresas[$chave] );
				}

			$this->smarty->assign('empresas',$empresas);
//			$this->smarty->assign('arrMun',$municipios);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/edit.tpl");
		}
		elseif ( ! empty($this->dadosP['form']) )
		{
			$return  = $this->DBOS_antigo->edit($this->dadosP['form']);

			if(count($return['erros']))
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Edição realizada com sucesso!';
			}
			die_json($arrReturn);
		}
	}

	public function editAti()
	{
		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{

			$this->DBOS_antigo->setPrkValue($this->dadosP['param']);
			$dados = $this->DBOS_antigo->view();
//			print_b($dados,true);

//			$municipios = $this->DBMunicipio->liste();
			$empresas = $this->DBEmpresas->listaEmpresas();
			if( $_SESSION['login']['empresas_idempresas'] == 2 )
				foreach( $empresas AS $chave => $empresa )
				{
					if( $empresa['idempresas'] != 2 )
						unset( $empresas[$chave] );
				}

			$this->smarty->assign('empresas',$empresas);
//			$this->smarty->assign('arrMun',$municipios);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/editAti.tpl");
		}
		elseif ( ! empty($this->dadosP['form']) )
		{
			$this->DBOS_antigo->setPrkValue($this->dadosP['form']['idos']);
			$dados = $this->DBOS_antigo->view();

			if($dados['router'] != $this->dadosP['form']['router'])
			{
				$sql = "SELECT count(*) as total FROM os_sp WHERE router LIKE '{$this->dadosP['form']['router']}'";
				$buscaWanFw = $this->DBOS_antigo->queryDados($sql);
				if($buscaWanFw[0]['total']>0){
					$arrReturn['status'] = 'erro';
					$arrReturn['msg'] = 'Router já existe.';
					die_json($arrReturn);

				}
			}

			if($dados['wan_fw'] != $this->dadosP['form']['wan_fw'])
			{
				$sql = "SELECT count(*) as total FROM os_sp WHERE wan_fw LIKE '{$this->dadosP['form']['wan_fw']}'";
				$buscaWanFw = $this->DBOS_antigo->queryDados($sql);
				if($buscaWanFw[0]['total']>0)
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg'] = 'Wan Fw já existe.';
					die_json($arrReturn);
				}

			}

			if($dados['ip_lan_fw'] != $this->dadosP['form']['ip_lan_fw'])
			{
				$sql = "SELECT count(*) as total FROM os_sp WHERE ip_lan_fw LIKE '{$this->dadosP['form']['ip_lan_fw']}'";
				$buscaWanFw = $this->DBOS_antigo->queryDados($sql);
				if($buscaWanFw[0]['total']>0)
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg'] = 'IP Lan Fw já existe.';
					die_json($arrReturn);
				}
			}



			$return  = $this->DBOS_antigo->edit($this->dadosP['form']);

			if(count($return['erros']))
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Edição realizada com sucesso!';
			}
			die_json($arrReturn);
		}
	}


	public function edit_outros_canais()
	{
		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{

			$this->DBOS_antigo->setPrkValue($this->dadosP['param']);
			$dados = $this->DBOS_antigo->view();
//			print_b($dados,true);

//			$municipios = $this->DBMunicipio->liste();
			$satelites = $this->DBSatelites->listaSatelites();
			$escricoes = $this->DBEscricaoFornecimento->listaEscricaoFornecimento();
			$empresas = $this->DBEmpresas->listaEmpresas();
			if( $_SESSION['login']['empresas_idempresas'] == 2 )
				foreach( $empresas AS $chave => $empresa )
				{
					if( $empresa['idempresas'] != 2 )
						unset( $empresas[$chave] );
				}

			$this->smarty->assign('empresas',$empresas);
			$this->smarty->assign('satelites', $satelites);
			$this->smarty->assign('escricoes', $escricoes);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/edit_outros_canais.tpl");
		}
		elseif ( ! empty($this->dadosP['form']) )
		{

			if($this->dadosP['form']['speednet']=='nao'){
				$this->dadosP['form']['speedTipo'] = '';
			}

			if($this->dadosP['form']['outrospeed']){
				if($this->dadosP['form']['speedTipo'] == 'outros'){
					$this->dadosP['form']['speedTipo'] = $this->dadosP['form']['outrospeed'];
				}
			}

			if($this->dadosP['form']['speedTipo'] == 'outros'){
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Selecione um SpeedNet';
				die_json($arrReturn);
			}

			$return  = $this->DBOS_antigo->edit($this->dadosP['form']);

			if(count($return['erros']))
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Edição realizada com sucesso!';
			}
			die_json($arrReturn);
		}
	}


	public function lista_atualizacao_os(){

		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{
			$dados = $this->DBOS_antigo->lista_os_sp_servicos($this->dadosP['param']);
			$separar = explode(".", $dados[0]['num_os_sp']);
			$separar[1] = ($separar[1]=='')?'1':$separar[1]+1;
			$numOs = $separar[0].'.'.$separar[1];

			$this->smarty->assign('obj',$dados);
			$this->smarty->assign('numossp',$numOs);
			$this->smarty->assign('idos',$this->dadosP['param']);
			$this->smarty->display("{$this->tplDir}/updownos.tpl");
		}

	}

	public function new_atual_os(){

		$sql = "SELECT * FROM instalacoes_sp WHERE os_sp_idos = {$this->dadosP['form']['idos']}";
		
		
		$dadosInstall = $this->DBOS_antigo->queryDados($sql);

		$dadosOs = $this->DBOS_antigo->carrega($this->dadosP['form']['idos']);

		$ultimo_dado = $this->DBOS_antigo->lista_os_sp_servicos($this->dadosP['form']['idos']);

		$dados = $this->dadosP['form'];
		$dados['observacoes'] = ($dados['observacoes']=="")? $ultimo_dado[0]['observacoes']:$dados['observacoes'];
		$dados['cirDownload'] = ($dados['cirDownload']=="")? $ultimo_dado[0]['cirDownload']:$dados['cirDownload'];
		$dados['cirUpload'] = ($dados['cirUpload']=="")? $ultimo_dado[0]['cirUpload']:$dados['cirUpload'];
		$dados['mirDownload'] = ($dados['mirDownload']=="")? $ultimo_dado[0]['mirDownload']:$dados['mirDownload'];
		$dados['cirUpload'] = ($dados['cirUpload']=="")? $ultimo_dado[0]['cirUpload']:$dados['cirUpload'];
		$dados['voip'] = ($dados['voip']=="")? $ultimo_dado[0]['voip']:$dados['voip'];
		$dados['qtlinha'] = ($dados['qtlinha']=="")? $ultimo_dado[0]['qtlinha']:$dados['qtlinha'];
		$dados['iplan'] = ($dados['iplan']=="")? $ultimo_dado[0]['iplan']:$dados['iplan'];
		$dados['speednet'] = ($dados['speednet']=="")? $ultimo_dado[0]['speednet']:$dados['speednet'];
		$dados['speedTipo'] = ($dados['speedTipo']=="")? $ultimo_dado[0]['speedTipo']:$dados['speedTipo'];


		$data = date('Y-m-d H:i:s');

		$sql = "INSERT INTO os_sp_servicos (
    					os_sp_idos, num_os_sp, status_atual, data, observacoes,
    					cirDownload, cirUpload, mirDownload, mirUpload, voip,
    					qtlinha, iplan, speednet, speedTipo
    					)
    		VALUES (
    				'{$dados['idos']}','{$dados['numOS']}','{$dados['status_atual']}','$data',
    				'{$dados['observacoes']}','{$dados['cirDownload']}','{$dados['cirUpload']}',
    				'{$dados['mirDownload']}','{$dados['cirUpload']}','{$dados['voip']}',
    				'{$dados['qtlinha']}','{$dados['iplan']}','{$dados['speednet']}','{$dados['speedTipo']}'
    			);
    	";


		//$ar['msg'] = $sql; die_json($ar);

		$result = $this->DBOS_antigo->query($sql);

		if( !$result ) {
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Erro ao atualizar a OS.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
		}

		if($dados['status_atual']){

			$str = ucfirst($dados['status_atual']);
			//ENVIO DE EMAILS
			
			/*	
			if($dadosOs['empresas_idempresas'] != 23){
				$assunto = $str ." da OS";
				$to = array(
					"cesar.dantas@globaleagle.com",
					"celio.batalha@globaleagle.com"
				);
				$msg = "<br/>
						{$str} da O.S Numero: {$dadosOs['numOS']}<br/>
						<b>Cliente:</b> {$dadosOs['contato']} <br/>
						<b>Estação:</b> {$dadosInstall[0]['nome']}<br/>
						<b>Data:</b> $data.
						<br/><br/>
						Atenciosamente,<br/>
						<br/>
						Tecnico Responsavel: {$_SESSION['login']['nome']}<br/>
						Vodanet Telecomunicações Ltda.<br/>
						http://www.vodanet-telecom.com<br/>
						<img src='http://saom.vodanet-telecom.com/public/imagens/logo_vodanet.jpg' />";



				if( !sendAtivacaoUpdate( $assunto , $to , $msg ) )
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg'] = 'Erro ao enviar email para informar finalização de comissionamento.';
					die_json($arrReturn);
				}
//
			}
			*/
			die_json(array(
				"msg" => "<div class='alert alert-success' style='float:left;'>OS atualizado com sucesso.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "ok"
			));
		}

	}


	public function countAgendPend()
	{
		$total['result'] = $this->DBOS_antigo->countAgendPend();
		die_json($total);
	}

	public function countAgend()
	{
		$total['result'] = $this->DBOS_antigo->countAgend();
		die_json($total);
	}

	public function countAgendConfirm()
	{
		$total['result'] = $this->DBOS_antigo->countAgendConfirm();
		die_json($total);
	}

	public function countOSVenc()
	{
		$total['result'] = $this->DBOS_antigo->countOSVenc();
		die_json($total);
	}

	public function countOSConc()
	{
		$total['result'] = $this->DBOS_antigo->countOSConc();
		die_json($total);
	}

	public function countOSAberto()
	{
		$total['result'] = $this->DBOS_antigo->countOSAberto();
		die_json($total);
	}

	function getCarregaDadosEmpresa(){


		if($this->dadosP['data'] != ''){
			$sql = "SELECT * FROM empresas WHERE idempresas =".$this->dadosP['data']."
                           ORDER BY idempresas DESC LIMIT 1 ";
			$buscaCliente = $this->DBOS_antigo->queryDados($sql);

//        $arrReturn['msg'] = $buscaCliente[0]['idcliente'];
//        die_json($arrReturn);

			$sql = "SELECT observacoes FROM os_sp WHERE empresas_idempresas =".$this->dadosP['data']."
                           ORDER BY idos DESC LIMIT 1 ";
			$buscaNumOs = $this->DBOS_antigo->queryDados($sql);

			$arrReturn['clientes_idcliente'] = $buscaCliente[0]['idcliente'];
			$arrReturn['emailFaturamento'] = $buscaCliente[0]['emailFaturamento'];
			$arrReturn['cepFaturamento'] = $buscaCliente[0]['cepFaturamento'];
			$arrReturn['estadoFaturamento'] = $buscaCliente[0]['estadoFaturamento'];
			$arrReturn['cidadeFaturamento'] = $buscaCliente[0]['cidadeFaturamento'];
			$arrReturn['paisFaturamento'] = $buscaCliente[0]['paisFaturamento'];
			$arrReturn['enderecoFaturamento'] = $buscaCliente[0]['enderecoFaturamento'];
			$arrReturn['cnpjFaturamento'] = $buscaCliente[0]['cnpjFaturamento'];
//            $arrReturn['observacoes'] = $buscaNumOs[0]['observacoes'];
			die_json($arrReturn);
		}else{
			die_json($this->dadosP['data']);
		}

//        $arrReturn['emailFaturmento']
	}

	public function getPrazoInstal()
	{
		if($this->dadosP['cidade'] == '')
		{
			$data = explode("/",$this->dadosP['data']);
			$data = $data[1]."/".$data[0]."/".$data[2];

			$val = strtotime($data);
			$arrReturn['data_result'] =  date("d/m/Y",strtotime("+45 days",$val));
			$arrReturn['msg']         = 'Prazo de Instalação é 45 dias a partir da data de solicitação';
		}

		die_json($arrReturn);
	}

	/**
	 * RELATÓRIO EM CSV
	 * ->teste unitário aplicado em relatorioContent()
	 */
	public function relatorio()
	{
		//trecho de relatorioContent();
		$this->relatorioContent();

		$this->smarty->assign('campos',"LOCALIDADE;CIRCUITO;DATA PEDIDO;LOTE;VELOCIDADE;RAZÃO SOCIAL;PREVISÃO LINK;JUSTIFICATIVA/OBS;CIRUITOS ACEITOS;DATA DO ACEITE;ENDEREÇO");
		$this->smarty->assign('arr',$this->arr);
		//print_b($this->arr,true);

		$text = $this->smarty->fetch("{$this->tplDir}/relatorio.tpl");

		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=file.csv");
		header('Content-Type: application/csv;charset=UTF-8');
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $text;
	}

	//tratamento do conteudo do csv (separado para o teste unitario)
	//TODO: gerando erro o metodo "liste_rel" que está no DB
	public function relatorioContent()
	{
		//$this->DBOS_antigo->setPag(array());
		$this->DBOS_antigo->zeraPag();
		//print_b($this->DBOS_antigo->getPag(),true);
		$this->arr = $this->DBOS_antigo->liste_rel();
		//print_b($this->arr,true);

		for($i=0;$i<count($this->arr);$i++)
		{
			if(isset($this->arr[$i]['rel']['agenda_instal_sp']['observacoes']))
			{
				$observacoes = $this->arr[$i]['rel']['agenda_instal_sp']['observacoes'];
				$observacoes = str_replace("\r\n","",trim($observacoes));
				$this->arr[$i]['rel']['agenda_instal_sp']['observacoes'] = $observacoes;
				unset($observacoes);
			}
		}
	}

	public function getArr()
	{
		return $this->arr;
	}
	//relatorio em csv - fim


	//lista com terceiro parametro
	public function listaComTerceiroParametro($parametros)
	{
		$params = explode("-",$parametros);
		//print_b($params,true);
		$this->liste($params[0],$params[1],$params[2]);
	}

	//listagem personalizada de OS para ordenação por confirmação em primeiro instante
	public function liste($order='aceite',$pag=1,$selecao='seleto')
	{

		if($_SESSION['campoNameOs'] == 'identificador')$identificador = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'os_numOS')$os_numOS = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'instalacoes_vsat')$instalacoes_vsat = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'pais')$pais = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'cidade')$cidade = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'estado')$estado = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'os_prazoInstal')$os_prazoInstal = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'os_dataSolicitacao')$os_dataSolicitacao = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'os_empresas_idempresas')$os_empresas_idempresas = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'os_empreiteira_idempresas')$os_empreiteira_idempresas = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'agendamento')$agendamento = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'comiss')$comiss = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'vsatCriada')$vsatCriada = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'aceiteProdemge')$aceiteProdemge = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'paralisado')$paralisado = $_SESSION['dataCampoOs'];
		if($_SESSION['campoNameOs'] == 'termo_responsabilidade')$termo_responsabilidade = $_SESSION['dataCampoOs'];

		$this->smarty->assign('identificador',$identificador);
		$this->smarty->assign('os_numOS',$os_numOS);
		$this->smarty->assign('instalacoes_vsat',$instalacoes_vsat);
		$this->smarty->assign('pais',$pais);
		$this->smarty->assign('cidade',$cidade);
		$this->smarty->assign('estado',$estado);
		$this->smarty->assign('os_prazoInstal',$os_prazoInstal);
		$this->smarty->assign('os_dataSolicitacao',$os_dataSolicitacao);
		$this->smarty->assign('os_empresas_idempresas',$os_empresas_idempresas);
		$this->smarty->assign('os_empreiteira_idempresas',$os_empreiteira_idempresas);
		$this->smarty->assign('agendamento',$agendamento);
		$this->smarty->assign('comiss',$comiss);
		$this->smarty->assign('vsatCriada',$vsatCriada);
		$this->smarty->assign('aceiteProdemge',$aceiteProdemge);
		$this->smarty->assign('paralisado',$paralisado);
		$this->smarty->assign('termo_responsabilidade',$termo_responsabilidade);

		$this->smarty->display("{$this->tplDir}/list_organic.tpl");
	}

	public function listeFonte()
	{

		// Get posted data
		if (isset($_POST['page']))
			$this->page = $_POST['page'];

		if (isset($_POST['sortname']))
			$this->sortname = $_POST['sortname'];

		if (isset($_POST['sortorder']))
			$this->sortorder = $_POST['sortorder'];

		if (isset($_POST['qtype']))
			$this->qtype = $_POST['qtype'];

		if (isset($_POST['query']))
			$this->query = $_POST['query'];

		if (isset($_POST['rp']))
			$this->rp = $_POST['rp'];


		$this->query = $_SESSION['dataCampoOs'];
		$this->qtype = $_SESSION['campoNameOs'];

		// Setup sort and search SQL using posted data
		$sortSql = "order by {$this->sortname} {$this->sortorder}";
		$searchSql = ($this->qtype != '' && $this->query != '') ? "where $this->qtype LIKE '%$this->query%'" : '';


		$empresas = $this->DBEmpresas->listaEmpresas();
//			$arrReturn['msg'] =$empresas;
//			die_json($arrReturn);

		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			foreach( $empresas AS $chave => $empresa )
			{
				if($empresa['idempresas'] == $_SESSION['login']['empresas_idempresas']){
					$tipo = $empresa['tipo'];
				}
			}
			if($searchSql!=''){
				if($tipo != 'EMPT' ){
					$searchSql .= " AND empresa = {$_SESSION['login']['empresas_idempresas']}";
				}else{
					$searchSql .= " AND empreiteira = {$_SESSION['login']['empresas_idempresas']}";
				}
			}else{
				if($tipo != 'EMPT'){
					$searchSql .= " WHERE empresa = {$_SESSION['login']['empresas_idempresas']}";
				}else{
					$searchSql .= " WHERE empreiteira = {$_SESSION['login']['empresas_idempresas']}";
				}
			}

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
		$sql = "
			select count(*) as total
			from listossp
			{$searchSql}
		";

		$result = $this->DBPadrao->queryDados($sql);
		$total = $result[0]['total'];

		// Setup paging SQL
		$this->pageStart = ($this->page-1)*$this->rp;
		$limitSql = "limit $this->pageStart, $this->rp";

		// Return JSON data
		$data = array();
		$data['page'] = $this->page;
		$data['total'] = $total;
		$data['rows'] = array();

		$sql = "select *
			from listossp
			{$searchSql}
			{$sortSql}
			{$limitSql};
		";

		$results = $this->DBPadrao->queryDados($sql);

		foreach( $results AS $row )
		{


			if(($row['empresa'] != 1) && ($_SESSION['login']['perfis_idperfis'] == '10'))
				$empreiteira = 'EMC';
			else
				$empreiteira = $row['os_empreiteira_idempresas'];

			$comiss = ($row['comiss'] != 'Não' && $row['comiss'] != 'Em Andamento')?substr($row['comiss'],0,10):utf8_decode(utf8_encode($row['comiss']));
			// acrescenta termo de responsabilidade //TODO: construir um método model pra isso
			$tresponsabilidade = $this->buscaTermoDeResponsabilidade( $row['instalacoes_idinstalacoes'] );
// 			$edicao = $this->buscaAlteraComissionamento( $row['instalacoes_idinstalacoes'] );

//            echo die_json($tresponsabilidade);
//
			$data['rows'][] = array(
				'id' => $row['os_idos'],
				'cell' => array(
					$row['identificador'],
					$row['os_numOS'],
					$row['instalacoes_vsat'],
					utf8_decode(utf8_encode($row['pais'])),
					utf8_decode(utf8_encode($row['cidade'])),
					utf8_decode(utf8_encode($row['estado'])),
					$row['os_prazoInstal'],
					$row['os_dataSolicitacao'],
					$row['os_empresas_idempresas'],
//					$row['os_empreiteira_idempresas'],
					$empreiteira,
					utf8_decode(utf8_encode($row['agendamento'])),
					$comiss,
// 					$edicao,
					utf8_decode(utf8_encode($row['vsatCriada'])),
//					 	utf8_decode(utf8_encode($row['codAnatel'])),
					utf8_decode(utf8_encode($row['aceiteProdemge'])),
					utf8_decode(utf8_encode($row['paralisado'])),
					utf8_decode(utf8_encode($tresponsabilidade))
				)
			);

		}

		//----Esta Mandando la no listossp.js
//        print_b($data,true);
		echo json_encode($data);

	}


	public function listeFonteFiltro()
	{

		// Get posted data
		if (isset($_POST['page']))
			$this->page = $_POST['page'];

		if (isset($_POST['sortname']))
			$this->sortname = $_POST['sortname'];

		if (isset($_POST['sortorder']))
			$this->sortorder = $_POST['sortorder'];

		if (isset($_POST['qtype']))
			$this->qtype = $_POST['qtype'];

		if (isset($_POST['query']))
			$this->query = $_POST['query'];

		if (isset($_POST['rp']))
			$this->rp = $_POST['rp'];

		if($this->query != '') {
			$nome = explode("%", $_POST['query']);

			$campo = explode(" ", $nome[0]);
			$_SESSION['dataCampoOs'] = $nome[1];
			$_SESSION['campoNameOs'] = $campo[0];
			$dadosInput = $_SESSION['dataCampoOs'];
			$campoInput = $_SESSION['campoNameOs'];

			if ($_SESSION['login']['perfis_idperfis'] == '10') {
				$login = $_SESSION['login']['empresa'];
//				$login = ($_SESSION['login']['nome']=='Telefonica')? 'VIVO': $_SESSION['login']['nome'];
				$query = "instalacoes_vsat LIKE '%$login%' AND $campoInput LIKE '%$dadosInput%'";
			}else{
				$query = "$campoInput LIKE '%$dadosInput%'";
			}
		}else{

			if($_SESSION['login']['perfis_idperfis'] == '10'){
				$login = $_SESSION['login']['empresa'];
				$query = "instalacoes_vsat LIKE '%$login%'";
			}
		}

		// Setup sort and search SQL using posted data
		$sortSql = "order by $this->sortname $this->sortorder";
		$searchSql = ($query != '') ? "where $query" : '';
// 		$searchSql = ($query != '') ? "where $query" : '';
//				$arrReturn['msg']     =$query ;
//				die_json($arrReturn);

		$empresas = $this->DBEmpresas->listaEmpresas();

		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			foreach( $empresas AS $chave => $empresa )
			{
				if($empresa['idempresas'] == $_SESSION['login']['empresas_idempresas']){
					$tipo = $empresa['tipo'];
				}
			}
			if($searchSql!=''){
				if($tipo != 'EMPT' ){
					$searchSql .= " AND empresa = {$_SESSION['login']['empresas_idempresas']}";
				}else{
					$searchSql .= " AND empreiteira = {$_SESSION['login']['empresas_idempresas']}";
				}
			}else{
				if($tipo != 'EMPT'){
					$searchSql .= " WHERE empresa = {$_SESSION['login']['empresas_idempresas']}";
				}else{
					$searchSql .= " WHERE empreiteira = {$_SESSION['login']['empresas_idempresas']}";
				}
			}
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
		$sql = "
			select count(*) as total
			from listossp
			{$searchSql}
		";
		$result = $this->DBOS_antigo->queryDados($sql);
		$total = $result[0]['total'];
		//echo json_encode($sql); exit;

		// Setup paging SQL
		$this->pageStart = ($this->page-1)*$this->rp;
		$limitSql = "limit $this->pageStart, $this->rp";

		// Return JSON data
		$data = array();
		$data['page'] = $this->page;
		$data['total'] = $total;
		$data['rows'] = array();

		$sql = "
			select *
			from listossp
			{$searchSql}
			{$sortSql}
			{$limitSql}
		";
		//echo json_encode($sql);exit;
		$results = $this->DBOS_antigo->queryDados($sql);

		foreach( $results AS $row )
		{
			if(($row['empresa'] != 1) && ($_SESSION['login']['perfis_idperfis'] == '10'))
				$empreiteira = 'EMC';
			else
				$empreiteira = $row['os_empreiteira_idempresas'];

			$comiss = ($row['comiss'] != 'Não' && $row['comiss'] != 'Em Andamento')?substr($row['comiss'],0,10):utf8_decode(utf8_encode($row['comiss']));

			// acrescenta termo de responsabilidade //TODO: construir um método model pra isso
			$tresponsabilidade = $this->buscaTermoDeResponsabilidade( $row['instalacoes_idinstalacoes'] );



			$data['rows'][] = array(
				'id' => $row['os_idos'],
				'cell' => array(
					$row['identificador'],
					$row['os_numOS'],
					$row['instalacoes_vsat'],
					utf8_decode(utf8_encode($row['pais'])),
					utf8_decode(utf8_encode($row['cidade'])),
					utf8_decode(utf8_encode($row['estado'])),
					$row['os_prazoInstal'],
					$row['os_dataSolicitacao'],
					$row['os_empresas_idempresas'],
//                    $row['os_empreiteira_idempresas'],
					$empreiteira,
					$row['agendamento'],
					$comiss,
					utf8_decode(utf8_encode($row['vsatCriada'])),
					// utf8_decode(utf8_encode($row['codAnatel'])),
					utf8_decode(utf8_encode($row['aceiteProdemge'])),
					utf8_decode(utf8_encode($row['paralisado'])),
					utf8_decode(utf8_encode($tresponsabilidade))
				)
			);
		}
//		print_b($data,true);

		echo json_encode($data);
	}
	/**
	 * Busca Termo de Responsabilidade
	 */
	private function buscaTermoDeResponsabilidade( $idinstalacoes )
	{
		$termo_responsabilidade = $this->TermoResponsabilidade_sp->fetchRow( " id_instalacoes = '$idinstalacoes' " );


		if( $termo_responsabilidade instanceof Zend_Db_Table_Row ){
			if( (int)$termo_responsabilidade->status == 1){
				$tresponsabilidade = 'Aceito';
			}else if( (int)$termo_responsabilidade->status == 2){
				$tresponsabilidade = 'Rejeitado';
			}
		}else{
			$tresponsabilidade = 'Não';
		}

		return $tresponsabilidade;
	}

	public function view($obj_selecionado)
	{
		if( isset($_GET['param']) )
			$this->dadosP['param'] = $_GET['param'];

		if ( ! empty($this->dadosP['param']))
		{
			$this->DBOS_antigo->setPrkValue($this->dadosP['param']);

			$dados = $this->DBOS_antigo->view();

//			 print_r($dados);

			if (!isset($dados['rel']['instalacoes_sp']['idinstalacoes_sp'])) {
				$dados['rel']['instalacoes_sp']['idinstalacoes_sp'] = null;
				$dados['rel']['instalacoes_sp']['data_aceite']   = null;
			}


			//PAUSAS
			$sql = "
            		SELECT
            			p.idpausas,
            			p.pausa_inicio,
            			p.pausa_fim
            		FROM pausas p
            		WHERE
            			p.tabela = 'OSSP' AND
            			p.chaveextrangeira = '{$this->dadosP['param']}'
            	";
			$listaPausas = $this->DBOS_antigo->queryDados($sql);
			$pausado = 0;
			for($i=0;$i<count($listaPausas);$i++)
			{
				if(empty($listaPausas[$i]['pausa_fim']))//PAUSADO
				{
					$pausado = 1;
					$pausaid = $listaPausas[$i]['idpausas'];

					$this->smarty->assign('pausaid',$pausaid);
					$this->smarty->assign('dataPausado',$this->helpers->data_us_br($listaPausas[$i]['pausa_inicio']));

					$i = count($listaPausas);
				}
			}
			$this->smarty->assign('pausado',$pausado);

			if(isset($dados['rel']['instalacoes_sp']['data_aceite']) && $dados['rel']['instalacoes_sp']['data_aceite']!='')
			{
				$dados['rel']['instalacoes_sp']['data_aceite'] = $this->helpers->data_us_br($dados['rel']['instalacoes_sp']['data_aceite']);
			}


			//PERMISSAO
			$usuario_permissao = 0;
			if( $_SESSION['login']['perfis_idperfis'] != 2 && $_SESSION['login']['perfis_idperfis'] != 3 )
			{
				if (isset($dados['rel']['instalacoes_sp']['data_aceite']) && $dados['rel']['instalacoes_sp']['data_aceite'] == '')
					$usuario_permissao = 1;
				else
					if($_SESSION['login']['perfis_idperfis'] == 5 || $_SESSION['login']['perfis_idperfis'] == 4)
						$usuario_permissao = 1;
			}

			//print_b($dados,true);
			//TODO: buscar o nome da vsat para apresentar aqui
			if( !isset($nomeVsat) )
				$nomeVsat = '';

			$sql = "
				SELECT * FROM  pausas WHERE tabela = 'OSSP' AND chaveextrangeira = '{$this->dadosP['param']}'
				AND ( pausa_fim IS NULL OR pausa_fim = '0000-00-00')
			";
			$pausada = $this->DBOS_antigo->queryDados($sql);

			$pausada = count($pausada);

			$licenca_anatel = null;
			if (isset($dados['rel']['instalacoes_sp']['idinstalacoes_sp'])) {
				$licenca_anatel = $this->busca_licenca_anatel( $dados['rel']['instalacoes_sp']['idinstalacoes_sp'] );
			}
			$this->smarty->assign('licenca_anatel', $licenca_anatel);

			//FIXME: arrumar (tá, mas arrumar oq?)
			$this->smarty->assign('pausada',$pausada);
			// Termo Responsabilidade
			$this->organizaTermoResponsabilidade( $dados['rel']['instalacoes_sp']['idinstalacoes_sp'] );


			// Relatório Fotográfico
			$this->organizaRelatorioFotografico( $dados['rel']['instalacoes_sp']['idinstalacoes_sp'] );
//        echo die_json('teste');

			// Google Maps

			if( isset($dados['rel']['instalacoes_sp']) ){

				$this->buildMapsFromGoogleMaps( $dados['rel']['instalacoes_sp'] );
			}



// 			print_r($this->tplDir);
			$empresas = $this->DBEmpresas->listaEmpresas();

			if(isset($dados['empreiteira_idempresas'])){
				foreach( $empresas AS $chave => $empresa )
				{
					if($empresa['idempresas'] == $dados['empreiteira_idempresas']){
						$dados['rel']['empreiteiras'] = $empresa['empresa'];
					}
				}
			}


			$dadosEmrpesas = new Empresas_spModel($this->adapter->getAdapterZend() );

			$obj_atual = $this->DBOS_antigo->lista_os_sp_servicos($this->dadosP['param']);

			$where = 'idempresas='.$dados['empresas_idempresas'];
			$lista_empresas = $dadosEmrpesas->fetchAll($where);

			$lista = $this->DBUsuarios->liste('incidentes = 1');

//			echo die_json($obj_selecionado[0]);

			$this->smarty->assign('nomeVsat',$nomeVsat);
			$this->smarty->assign('login',$_SESSION['login']);
			$this->smarty->assign('usuario_permissao',$usuario_permissao);
			$this->smarty->assign('listaUsuarios',$lista);
			$this->smarty->assign('cliente',$lista_empresas[0]);

			$this->smarty->assign('obj_selecionado',$obj_selecionado[0]);
			$this->smarty->assign('obj_atual',$obj_atual[0]);

			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/view.tpl");
		}
	}

	public function view_os_atual(){
		if( isset($_GET['param']) )
			$this->dadosP['param'] = $_GET['param'];

		$dados_atual = $this->DBOS_antigo->view_os_atual($this->dadosP['param']);
		$this->dadosP['param'] = $dados_atual[0]['os_sp_idos'];

		$this->view($dados_atual);
	}


	public function trocaResponsavel(){

		$user = $this->dadosP['form']['resp_user_comiss'];

		$agora = date('Y-m-d H:i:s');

		$sql = "
    		UPDATE instalacoes_sp
    		SET resp_user_comiss = '$user', resp_comiss_time = '$agora'
    		WHERE os_sp_idos = '{$this->dadosP['form']['idOS_reserva']}';
    	";
//		echo die_json($sql);
		$result = $this->DBOS_antigo->query($sql);
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

	/**
	 * Constrói mapa do Google Maps com graus minutos e segundos passados
	 * da latitude e longitude da instalação
	 *
	 * @param $instalacao {array}
	 */
	private function buildMapsFromGoogleMaps( Array $instalacao )
	{
//        echo die_json($instalacao);
		if( $this->validaCoordenadasLocalizacao( $instalacao ) ){

			$ConvertDegreesToGoogleMaps = new ConvertDegreesToGoogleMaps();

			// converte graus minutos segundos em decimais
			$decimais = $ConvertDegreesToGoogleMaps->ConvertDegreesToDecimal(
				$instalacao['latitude_graus'],
				$instalacao['latitude_minutos'],
				$instalacao['latitude_segundos'],
				$instalacao['longitude_graus'],
				$instalacao['longitude_minutos'],
				$instalacao['longitude_segundos']
			);

			// resolve direcao das coordenadas
			$decimais['coordinates'] = $this->converteCoordenadasPordirecao( $instalacao , $decimais['coordinates'] );


			$this->smarty->assign('GoogleMapCoordinates',$decimais['coordinates']);
		}
		else
			$this->smarty->assign('GoogleMapCoordinates',false);
	}
	/**
	 * Converte para negativo e positivo segundo a direção S N W E
	 */
	private function converteCoordenadasPordirecao( $instalacao , $decimais )
	{
		if( $instalacao['latitude_direcao'] == 'S' )
			$decimais[ 'latitude' ] = $decimais[ 'latitude' ] * -1;
		if( $instalacao['longitude_direcao'] == 'W' )
			$decimais[ 'longitude' ] = $decimais[ 'longitude' ] * -1;

		return $decimais;
	}
	/**
	 * Valida coordenadas da instalacao
	 *
	 *  @param $instalacao {array}
	 */
	private function validaCoordenadasLocalizacao( Array $instalacao )
	{
		// valida existência de conteúdo nos campos
		if(
			!empty($instalacao['latitude_graus']) &&
			!empty($instalacao['latitude_minutos']) &&
			!empty($instalacao['latitude_segundos']) &&
			!empty($instalacao['longitude_graus']) &&
			!empty($instalacao['longitude_minutos']) &&
			!empty($instalacao['longitude_segundos'])
		){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Resgata informações do Termo de Responsabilidade
	 *
	 * @param $instalacao
	 */
	private function organizaTermoResponsabilidade( $instalacao )
	{
		if (!$instalacao) {
			$this->smarty->assign( 'termo_responsabilidade' , false);
		}

		$this->TermoResponsabilidade_sp->getTermoDeInstalacao( new Integer($instalacao) );
		$this->smarty->assign( 'termo_responsabilidade' , $this->TermoResponsabilidade_sp->termo );
//        echo die_json('teste1');

	}

	/**
	 * Resgata informações do Relatorio Fotografico
	 *
	 * @param $instalacao
	 */
	private function organizaRelatorioFotografico( $instalacao )
	{
		$this->RelatorioFotografico_sp->getRelatorioDeInstalacao( new Integer($instalacao) );

		$this->smarty->assign( 'relatorio_fotografico' , $this->RelatorioFotografico_sp->relatorio );
	}

	private function busca_licenca_anatel( $idinstalacao )
	{
		$this->LicencaAnatel_sp->setinstalacoes_idinstalacoes( $idinstalacao );
		$this->LicencaAnatel_sp->buscaLicencaPelaInstalacao();
		if( count($this->LicencaAnatel_sp->getlicencaAnatelArray()) > 0 )
			return "<a target='_blank' href='{$this->LicencaAnatel_sp->getendereco()}'><i class='icon-file'></i><font style='color:#000;'>{$this->LicencaAnatel_sp->getnome()}</font></a>";
		else return '';
	}


	public function pausa()
	{
		//TODO: dividir em models - fazer OO

		//VERIFICA PRE EXISTENCIA DE PAUSA (SE JÁ ESTÁ PAUSADO)
		$sql = "SELECT p.idpausas FROM pausas p WHERE p.chaveextrangeira = '{$this->dadosP['form']['idOS_reserva']}' AND p.tabela = 'OSSP' AND ISNULL(p.pausa_fim) ";
		$dados = $this->DBOS_antigo->queryDados($sql);

		if( count($dados) > 0 )//JA EXISTE
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'OS já está pausada.';
			die_json($arrReturn);
		}
		else//NAO EXISTE PAUSA REGISTRADA AINDA
		{
			//instância de OS
			$os = $this->DBOS_antigo->carrega($this->dadosP['form']['idOS_reserva']);

			$dataAtual = $this->dadosP['form']['campoDataPausa'];
			$dataAtual = $this->helpers->data_br_us($dataAtual);

			/* Desabilitado devido ha uma solicitação do Hernan em 09/04/2013 
			//VERIFICA PRAZO INSTAL
			if($os['prazoInstal'] < $dataAtual)
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Não é permitido pausar após o Prazo de Instalação.';
				die_json($arrReturn);
			}
			*/

			if($dataAtual=='')
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Campo de Data não pode ficar em branco.';
				die_json($arrReturn);
			}
			$sql = "INSERT INTO pausas (tabela, pausa_inicio, chaveextrangeira)
    				VALUES ('OSSP', '{$dataAtual}', '{$this->dadosP['form']['idOS_reserva']}' )";
			if($this->DBOS_antigo->query($sql))
			{
				$arrReturn['status'] = 'ok';
				$arrReturn['msg'] = 'OS pausada com sucesso.';
			}
			else
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Erro ao criar pausa.';
			}
			die_json($arrReturn);
		}
	}


	public function despausa()
	{
		//TODO: dividir em models - fazer OO

		$dataAtual = $this->dadosP['form']['campoDataPausa'];
		$dataAtual = $this->helpers->data_br_us($dataAtual);
		$sql = "
    		UPDATE pausas 
    		SET pausa_fim = '{$dataAtual}' 
    		WHERE idpausas = '{$this->dadosP['form']['pausa']}'; 
    	";




		if($this->DBOS_antigo->query($sql))
		{
			//muda prazoInstal da OS #retorno 'tempo' em dias
			$sql = "
	    			SELECT 
	    				p.chaveextrangeira AS ossp,
	    				p.pausa_inicio AS pausa_inicio, 
	    				p.pausa_fim AS pausa_fim,
	    				(SELECT DATEDIFF(p.pausa_fim,p.pausa_inicio)) AS tempo
	    			FROM pausas p
	    			WHERE p.idpausas = '{$this->dadosP['form']['pausa']}';
	    		";

			$pausa = $this->DBOS_antigo->queryDados($sql);

			$sql = "
	    			UPDATE os_sp o
	    			SET o.prazoInstal = DATE_ADD(o.prazoInstal,INTERVAL {$pausa[0]['tempo']} DAY)
	    			WHERE idos = {$pausa[0]['ossp']};
	    		";
			if(!$this->DBOS_antigo->query($sql))
			{
				//email para webmaster
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$msg = "
						Erro ao modificar prazoInstal.<br/>
						Pausa: {$this->dadosP['form']['pausa']}<br/>
						OS: {$pausa[0]['ossp']}
					";
				mail('lotharthesavior@gmail.com', 'Erro SAOM', $msg,$headers);

				//recado para usuario
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Despausado, porém ocorreu um erro ao atualizar o Prazo de Instalação, o Webmaster já foi informado do erro.';
				exit;
			}

			$arrReturn['status'] = 'ok';
			$arrReturn['msg'] = 'OS despausada com sucesso.';
		}
		else
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg'] = 'Erro ao despausar.';
		}
		die_json($arrReturn);
	}

	public function caixaPausa()
	{
		$this->smarty->display("{$this->tplDir}/caixa_pausa.tpl");
	}

	public function caixaDespausa()
	{
		$this->smarty->display("{$this->tplDir}/caixa_despausa.tpl");
	}

	public function cancela()
	{
		//TODO: melhorar isso
		$idos = $this->dadosP['param'];
		//a pedido do Alex será acrescido um "c" ao final do campo 'identificador'
		$sql = "UPDATE os_sp SET os_status_idos_status = '2', identificador = CONCAT(identificador,'c') WHERE idos = '{$idos}'";
		if($this->DBOS_antigo->query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function relatorioAcompanhamento()
	{








		$sql = "SELECT
					o.identificador AS ID,
					o.numOS AS OS,

					o.orgao As orgao,
					o.unidade As Unidade,
					o.acesso As Acesso,
					o.inep As Inep,

					o.dataSolicitacao AS 'Data de Solicitação',
					o.prazoInstal AS Prazo,
					(SELECT IF(
						i.data_aceite IS NOT NULL AND i.data_aceite != '0000-00-00',
						'Aceito',
						(SELECT IF(
								(SELECT COUNT(*) FROM pausas WHERE tabela = 'OSSP' AND chaveextrangeira = o.idos AND pausa_fim IS NULL) > 0,
								'Paralisado',
								(SELECT IF(
											(SELECT COUNT(*) FROM agenda_instal_sp WHERE os_sp_idos = o.idos) > 0,
											'Agendado',
											'A agendar'
										  )
								)
							  )
						)
					)) 
					AS Status,
					(SELECT e.empresa FROM empresas e WHERE e.idempresas = o.empresas_idempresas) AS Empreiteira,

					o.cidade AS localidade,
					o.estado AS estado,
					i.nome AS designacao,
					a.data AS 'Data do Agendamento',
					o.contato AS Nome,
					o.enderecoInstal AS Endereco,
					o.cep AS Cep,
					o.outroTelContato AS Telefone,
					o.outroTelContato2 AS Telefone2,
					o.telContato AS Celular,
					o.email AS Email,
					o.area_instal AS 'Area de Instalacao',
					o.tipo_equip AS 'Tipo Equipamento',
					o.end_rede AS 'End Rede',
					o.end_lan AS 'End LAN',
					o.wan_fw AS 'WAN FW',
					o.ip_lan_fw AS 'IP LAN FW',
					o.router AS 'Router',
					i.mac_comiss AS 'Número Mac',
					i.teccampo AS Técnico,
					i.data_aceite AS 'Data de Aceite',
					o.observacoes AS Observações,
					o.ipdvb,
					o.iplan,
					(SELECT IF(
								i.cabo_rj45 = 0,
								'Não',
								'Sim'
							)
					),
					(SELECT IF(
								i.cabo_rj45 = 0,
								i.cabo_rj45_justificativa_nao,
								i.cabo_rj45_justificativa_sim
							)	
					),
					i.latitude_graus AS latitude_graus,
					i.latitude_minutos AS latitude_minutos,
					i.latitude_segundos AS latitude_segundos,
					i.longitude_graus AS longitude_graus,
					i.longitude_minutos AS longitude_minutos,
					i.longitude_segundos AS longitude_segundos
				FROM os_sp o
				LEFT JOIN instalacoes_sp i ON i.os_sp_idos = o.idos
				LEFT JOIN agenda_instal_sp a ON a.os_sp_idos = o.idos";

		//					m.municipio AS localidade,
//				LEFT JOIN municipios_sp m ON idmunicipios_sp = o.municipios_sp_idcidade

		$lista = $this->DBOS_antigo->queryDados($sql);
//        echo die_json($lista);
		$titulos = array(
			'ID',
			'OS',
			html_entity_decode('Orgão'),
			'Unidade',
			'Acesso',
			'Inep',
			html_entity_decode('Data de Solicitação'),
			'Prazo',
			'Status',
			'Empreiteira',
			'Localidade',
			'Estado',
			html_entity_decode('Designação'),
			'Agendamento',
			'Nome',
			html_entity_decode('Endereço'),
			'Cep',
			'Telefone',
			'Telefone2',
			'Celular',
			'Email',
			html_entity_decode('Area de Instalação'),
			html_entity_decode('Tipo Equipamento'),
			html_entity_decode('End. Rede'),
			html_entity_decode('End. LAN'),
			html_entity_decode('WAN FW'),
			html_entity_decode('IP LAN FW'),
			html_entity_decode('Router'),
			html_entity_decode('Numero MAC'),
			html_entity_decode('Tecnico'),
			'Data de Aceite',
			html_entity_decode('Observaçoes'),
			'Ip Lan',
			'Ip Dvb',
			'Cabo Rj45',
			html_entity_decode('Observaçoes Cabo Rj45'),
			'Latitude Graus',
			'Latitude Minutos',
			'Latitude Segundos',
			'Longitude Graus',
			'Longitude Minutos',
			'Longitude Segundos'
		);

		$nome_arquivo = 'relatorios/relatorio_acompanhamento_'.date('d').'_'.date('m').'_'.date('Y').'_-_'.date('H').'_'.date('i').'_'.date('s').'_-_'.normaliza(str_replace(' ','_',trim($_SESSION['login']['nome']))).'.csv';

		$arquivo = fopen($nome_arquivo,'w');

		fputcsv($arquivo, $titulos, ';');

		for($i=0;$i<count($lista);$i++)
		{
			$arrayNovo = array();
			foreach($lista[$i] as $item)
			{
				$arrayNovo[] = html_entity_decode($item);
			}
			fputcsv($arquivo, $arrayNovo, ';');
		}

		fclose($arquivo);

		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"');
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($nome_arquivo));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');

		// Envia o arquivo para o cliente
		readfile($nome_arquivo);
	}

	/*
	 * Método para edição do sat_vsat_code
	 */
	public function eutelsatcode_list()
	{
		$sql = "
    		SELECT *
    		FROM listeutelsatcode_sp;
    	";
		$lista = $this->DBOS_antigo->queryDados($sql);

		$this->smarty->assign('lista_contagem',count($lista));
		$this->smarty->assign('lista',$lista);
		$this->smarty->display("{$this->tplDir}/eutelsatcode_list.tpl");
	}
	public function eutelsatcode_list_busca($sequencia)
	{
		$form = json_decode($_POST['form']);

		$where = "";
		for($i=0;$i<count($form);$i++)
		{
			if( $form[$i]->value != '' && $form[$i]->value != 'vz' )
			{
				$where .= " ".$form[$i]->name." LIKE '%".$form[$i]->value."%' AND";
			}
			else if( $form[$i]->value == 'vz' )
			{
				$where .= " ( ".$form[$i]->name." IS NULL OR ".$form[$i]->name." = '' ) AND";
			}
		}
		$where = substr($where, 0, -3);

		if( $where == '' ){ $where = '1'; }

		$sql = "
	    		SELECT *
	    		FROM listeutelsatcode_sp
	    		WHERE {$where};
	    	";
		$lista = $this->DBOS_antigo->queryDados($sql);

		for( $i=0 ; $i < count($form) ; $i++ ){ $form[$i] = get_object_vars($form[$i]); }
		$this->smarty->assign('form',$form);

		$this->smarty->assign('lista_contagem',count($lista));
		$this->smarty->assign('lista',$lista);
		$this->smarty->display("{$this->tplDir}/eutelsatcode_list.tpl");
	}
	public function salva_eutelsat_code()
	{
		$sql = $_POST['query'];//exit($sql);
		$sqls = explode(';',$sql);
		unset($sqls[count($sqls)-1]);
		foreach($sqls AS $sql1)
		{
			if(!$this->DBOS_antigo->query($sql1))
			{
				exit(false);
			}
		}
		exit(true);
	}

	/*
	 * Método que verifica o ipdvb e o iplan
	 */
	public function verificaIplanIpdvb($idos)
	{
		$sql = "
    		SELECT
    			o.ipdvb AS ipdvb,
    			o.iplan AS iplan
    		FROM
    			os_sp o
    		WHERE
    			o.idos = '{$idos}';
    	";

		$os = $this->DBOS_antigo->queryDados($sql);
		if( $os[0]['ipdvb'] == '' || $os[0]['iplan'] == '' )
			echo true;

		else
			echo false;
	}

	public function edicao_critica()
	{
		//print_b($this->dadosP['form'],true);

		$sql = "
    		UPDATE
    			os_sp o 
    		SET
    			o.iplan = '{$this->dadosP['form']['iplan']}',
    			o.ipdvb = '{$this->dadosP['form']['ipdvb']}'
    		WHERE
    			o.idos = '{$this->dadosP['form']['idos']}';
    	";

		if($this->DBOS_antigo->query($sql))
		{
			$arrReturn['status']  = 'ok';
			$arrReturn['msg']     = 'Edição realizada com sucesso!';
		}
		else
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = "Erro ao modificar informações da OS.";
		}
		die_json($arrReturn);
	}


	// -----------------------------------------------------
	// ----------------- RELATORIO CSV ---------------------
	// -----------------------------------------------------

	public function relatorioAnatel()
	{
		$this->smarty->display("{$this->tplDir}/form_relatorio_anatel.tpl");
	}

	public function enviaRelatorioAnatel()
	{
		//print_b($this->dadosF['arquivo_csv'],true);

		if( ! empty($this->dadosF['arquivo_csv']))
		{
			$move = move_uploaded_file($this->dadosF['arquivo_csv']['tmp_name'], 'upload/relatorioAnatel/'.$this->dadosF['arquivo_csv']['name']);
			if ($move)
			{
				$arquivo = 'upload/relatorioAnatel/'.$this->dadosF['arquivo_csv']['name'];
			}
			else
			{
				$arquivo = 'Não movido.';
			}
		}

		return $this->geraNovoCsvRelatorioAnatel($arquivo);
	}

	private function geraNovoCsvRelatorioAnatel($arquivo)
	{
		//print_b($arquivo,true);
		$novaCsv = array();
		$novaCsv2 = array();

		$titulos = array(
			'Nome',
			'Latitude Graus',
			'Latitude Minutos',
			'Latitude Segundos',
			'Longitude Graus',
			'Longitude Minutos',
			'Longitude Segundos',
			'Marca Antena',
			'CEP',
			'Endereco',
			'Numero',
			'Bairro',
			'Cidade',
			'ODU',
			'BUC',
			'Marca Antena',
			'Empresa'
		);

		//pega informações
		$row = 1;
		$handle = fopen ($arquivo,"r");
		while ( ($data = fgetcsv($handle, 1000, ";")) !== FALSE )
		{
			if($row > 1)
			{
				//monta array com dados para novo csv
				$linha = explode(';',$data[0]);
				$nomeVsat = $linha[0];
				$sql = "
					SELECT
						i.nome, 
						i.latitude_graus,
						i.latitude_minutos,
						i.latitude_segundos,
						i.longitude_graus,
						i.longitude_minutos,
						i.longitude_segundos,
						i.antena_comiss,
						o.cep,
						o.enderecoInstal,
						o.cidade,
						te.nome AS odu,
						i.buc,
						i.antena_comiss,
						e.empresa
					FROM instalacoes_sp i
					LEFT JOIN os_sp o ON o.idos = i.os_sp_idos
					LEFT JOIN tipo_equipamentos_sp te ON te.idtipo_equipamentos_sp = i.odu
					LEFT JOIN tipo_equipamentos_sp te2 ON te2.idtipo_equipamentos_sp = i.odu
					LEFT JOIN empresas e ON e.idempresas = o.empresas_idempresas
					WHERE i.nome = '{$nomeVsat}';
				";
				$dados = $this->DBOS_antigo->queryDados($sql);
				if( count($dados) > 0 )
				{
					array_push($novaCsv, $dados);
				}
				else
				{
					echo "Vsat {$nomeVsat} não encontrada!<br/>";
				}
			}
			$row++;
		}
		fclose ($handle);
		//print_b($novaCsv,true);

		//arrumando endereço (dividindo em 3 campos diferentes
		array_push($novaCsv2,$titulos);
		foreach( $novaCsv as $linha )
		{
			$endereco_partido = explode(',',$linha[0]['enderecoInstal']);
			$endereco = (isset($endereco_partido[0]))?$endereco_partido[0]:'';

			$endereco_partido2 = explode('-',$endereco_partido[1]);
			$numero = (isset($endereco_partido2[0]))?$endereco_partido2[0]:'';
			$bairro = (isset($endereco_partido2[1]))?$endereco_partido2[1]:'';

			array_push($novaCsv2,array(
				$linha[0]['nome'],
				$linha[0]['latitude_graus'],
				$linha[0]['latitude_minutos'],
				$linha[0]['latitude_segundos'],
				$linha[0]['longitude_graus'],
				$linha[0]['longitude_minutos'],
				$linha[0]['longitude_segundos'],
				$linha[0]['antena_comiss'],
				$linha[0]['cep'],
				$endereco,
				$numero,
				$bairro,
				$linha[0]['cidade'],
				$linha[0]['odu'],
				$linha[0]['buc'],
				$linha[0]['antena'],
				$linha[0]['empresa']
			));
		}
		//print_b($novaCsv2,true);

		//pega informações
		$row = 1;
		$dataHoje = date('dmY');
		$arquivoNovo = "upload/relatorioAnatel/relatorio_{$dataHoje}.csv";
		$handle = fopen ($arquivoNovo,"w");
		foreach ($novaCsv2 as $linha)
		{
			fputcsv($handle,$linha,';');
		}
		fclose ($handle);

		echo "<a target='_blank' href='{$arquivoNovo}'> >>>Download<<< </a>";
	}

}

?>

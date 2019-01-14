<?php

include_once realpath(dirname(__FILE__) . '/../model/') . '/DBCanalVenda.php';
include_once 's_p/model/DBContratoOS.php';
include_once 's_p/model/DBPedidoOS.php';
include_once "s_p/model/DBEmpresas.php";

class OsPedidoContrato extends Controller
{

	protected $tplDir = 's_p/tampletes/ospedidocontrato';
	protected $arr;

	//
	protected $page = 1;
	protected $sortname = 'contrato_criado';
	protected $sortorder = 'DESC';
	protected $qtype;
	protected $query;
	protected $rp = 20;

	public function __construct()
	{
		parent::__construct();
		$this->DBCanalVenda = new DBCanalVenda();
		$this->DBContratoOs = new DBContratoOS();
		$this->DBPedidoOs = new DBPedidoOS();
		$this->DBUsuarios = new DBUsuario();
		$this->DBEmpresas = new DBEmpresas();

	}

	public function create()
	{


		if (empty($this->dadosP['form']))
		{
			


// 			$listaCanalVendas = $this->DBCanalVenda->liste();
			if ( ! empty($this->dadosP['param']))
			{
				$this->smarty->assign('param',$this->dadosP['param']);
			}
			
// 			$pedidoOs  = $this->DBPedidoOs->liste();
			$this->DBPedidoOs->setPrkValue($this->dadosP['param']);
			$dados = $this->DBPedidoOs->view();
			$empresas = $dados['rel']['empresas']['empresa'];
			
			$usuarios = $this->DBUsuarios->liste();
			foreach ($usuarios as $cha=>$usuario){
				if ($usuario['idusuarios'] == $dados['iduser_cadastro']){
					$usuarios = $usuario['nome'];
				}
			}

			$this->smarty->assign('perfil',$_SESSION['login']['perfis_idperfis']);
			$this->smarty->assign('empresa',$empresas);
			$this->smarty->assign('usuario',$usuarios);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/new.tpl");
		}
		else
		{
				
			//VERIFICA 'NUMERO DA OS' E 'IDENTIFICADOR' PARA NAO GERAR REPETIDOS
			$sql = "SELECT count(*) as total FROM os_pedido_contrato WHERE num_os LIKE '{$this->dadosP['form']['num_os']}'";
			$buscaNumOs = $this->DBContratoOs->queryDados($sql);
// 			print_b($buscaNumOs,true);
			if($buscaNumOs[0]['total']>0)
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Número da OS já existe.';
				die_json($arrReturn);
			}
			
			$sql = "SELECT count(*) as total FROM os_pedido_contrato WHERE num_contrato LIKE '{$this->dadosP['form']['num_contrato']}'";
			$buscaNumContrato = $this->DBContratoOs->queryDados($sql);
			if($buscaNumContrato[0]['total']>0)
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg'] = 'Número do Contrato já exite';
				die_json($arrReturn);
			}
// 			// fim

			$form_data = date("Y-m-d H:i:s");
			$this->dadosP['form']['data_contrato'] = $form_data;
// 			$arrReturn['msg'] = $form_data;
// 			die_json($arrReturn);
				
			$return  = $this->DBContratoOs->create($this->dadosP['form']);
			
			if(count($return['erros']))
			{

				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = implode("<hr>", $return['erros']);
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
			}
			die_json($arrReturn);
		}
			
	}

	//listagem personalizada de OS para ordenação por confirmação em primeiro instante
	public function liste($order='aceite',$pag=1,$selecao='seleto')
	{
		$this->smarty->display("{$this->tplDir}/list_organicPedidoOs.tpl");
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

		// Setup sort and search SQL using posted data
		$sortSql = "order by {$this->sortname} {$this->sortorder}";
		$searchSql = ($this->qtype != '' && $this->query != '') ? "where $this->qtype LIKE '%$this->query%'" : '';

		//RETIRA DA LISTA INSTALACOES DE OUTRAS EMPRESAS (quando não é vodanet atualmente)
		if($_SESSION['login']['empresas_idempresas']!=1)
		{
			if($searchSql!='')
			$searchSql .= " AND empresa = {$_SESSION['login']['empresas_idempresas']}";
			else
			$searchSql .= " WHERE empresa = {$_SESSION['login']['empresas_idempresas']}";
		}

		// Get total count of records
		$sql = "
			select count(*) as total
			from listpedidoos_sp
			{$searchSql}
		";
			
// 		echo json_encode($sql);exit();
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
			from listpedidoos_sp
			{$searchSql}
			{$sortSql}
			{$limitSql};
		";
		$results = $this->DBPadrao->queryDados($sql);
// 		echo json_encode($results);exit;
		


		foreach( $results AS $row )
		{

			$data['rows'][] = array(
				'id' => $row['idpedido'],
				'cell' => array(
					$row['idpedido'],
					$row['solicita'],
					$row['canal_venda_idcanal_venda'],
					$row['fator_comp'],
					$row['pedidoos_empresas_idempresas'],
					$row['pedido_criado'],
					$row['confirmado'],
				)
			);
		}
	
		//----Esta Mandando la no listos.js
// 				print_b($data,true);
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

		// Setup sort and search SQL using posted data
		$sortSql = "order by $this->sortname $this->sortorder";
		$searchSql = ($this->query != '') ? "where $this->query" : '';
			
		// Get total count of records
		$sql = "
			select count(*) as total
			from listpedidoos_sp
			{$searchSql}
		";
		$result = $this->DBPedidoOs->queryDados($sql);
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
			from listpedidoos_sp
			{$searchSql}
			{$sortSql}
			{$limitSql}
		";
		//echo json_encode($sql);exit;
		$results = $this->DBPedidoOs->queryDados($sql);
	
		foreach( $results AS $row )
		{

			$data['rows'][] = array(
				'id' => $row['idpedido'],
				'cell' => array(
// 					$row['idpedido_os'],
					$row['solicita'],
					$row['canal_venda_idcanal_venda'],
					$row['fator_comp'],
					$row['pedidoos_empresas_idempresas'],
					$row['pedido_criado'],
				)
			);
		}
// 		print_b($data,true);

		echo json_encode($data);
	}

	public function view()
	{
		if( isset($_GET['param']) )
		$this->dadosP['param'] = $_GET['param'];
// 		$arrReturn['msg'] = $this->dadosP['param'];
// 		die_json($arrReturn);

		if ( ! empty($this->dadosP['param']))
		{

			$this->DBPedidoOs->setPrkValue($this->dadosP['param']);
			$dados = $this->DBPedidoOs->view();


			$usuarios = $this->DBUsuarios->liste();
			foreach ($usuarios as $cha=>$usuario){
				if ($usuario['idusuarios'] == $dados['iduser_cadastro']){
					$usuarios = $usuario['nome'];
				}
			}
				
			$empresas = $dados['rel']['empresas']['empresa'];
			

			$this->smarty->assign('login',$_SESSION['login']);
			$this->smarty->assign('empresa',$empresas);
			$this->smarty->assign('usuario',$usuarios);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/view.tpl");
		}
	}

}

?>

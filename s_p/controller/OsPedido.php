
<?php

include_once 's_p/model/DBCanalVenda.php';
include_once 's_p/model/DBPedidoOS.php';
include_once "s_p/model/DBEmpresas.php";


class OsPedido extends Controller
{

	protected $tplDir = 's_p/tampletes/ospedido';
	protected $arr;

	//
	protected $page = 1;
	protected $sortname = 'pedido_criado';
	protected $sortorder = 'DESC';
	protected $qtype;
	protected $query;
	protected $rp = 20;

	public function __construct()
	{
		parent::__construct();
		$this->DBCanalVenda = new DBCanalVenda();
		$this->DBPedidoOs = new DBPedidoOS();
		$this->DBUsuarios = new DBUsuario();
		$this->DBEmpresas = new DBEmpresas();

	}

	public function create()
	{
		if (empty($this->dadosP['form']))
		{
			$listaCanalVendas = $this->DBCanalVenda->liste();

			if ( ! empty($this->dadosP['param']))
			{
				$this->smarty->assign('param',$this->dadosP['param']);
			}

			$this->smarty->assign('perfil',$_SESSION['login']['perfis_idperfis']);
			$this->smarty->assign('listaCanalVendas',$listaCanalVendas);
			$this->smarty->display("{$this->tplDir}/new.tpl");
		}
		else
		{

			$form_data = date("Y-m-d H:i:s");
			$this->dadosP['form']['criado'] = $form_data;
				
			$return  = $this->DBPedidoOs->create($this->dadosP['form']);
			
			
			
			
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

	/**
	 * RELATÓRIO EM xls
	 * ->teste unitário aplicado em relatorioContent()
	 */
	public function contrato()
	{


		if (isset($_GET['param']))
			$this->dadosP['param'] = $_GET['param'];



		$this->DBPedidoOs->setPrkValue($this->dadosP['param']);
		$dados = $this->DBPedidoOs->view();

		$usuarios = $this->DBUsuarios->liste();
		foreach ($usuarios as $cha=>$usuario){
			if ($usuario['idusuarios'] == $dados['iduser_cadastro']){
				$usuarios = $usuario['nome'];
			}
		}

		$empresas = $dados['rel']['empresas']['empresa'];

// 		$this->relatorioContent();
		$buffe = ob_start();

		$array = array();

		$array[]= "Janeiro";
		$array[]= "Fevereiro";
		$array[]= "Março";
		$array[]= "Abril";
		$array[]= "Maio";
		$array[]= "Junho";
		$array[]= "Julho";
		$array[]= "Agosto";
		$array[]= "Setembro";
		$array[]= "Outubro";
		$array[]= "Novembro";
		$array[]= "Dezembro";

		for ($i=0; $i<=12; $i++){
			$mes = $array[date('m')-1];
		}


		$data = Date('d') .' de '. $mes .' de '. date('Y');


// 		$this->smarty->assign('campos',"LOCALIDADE;CIRCUITO;DATA PEDIDO;LOTE;VELOCIDADE;RAZÃO SOCIAL;PREVISÃO LINK;JUSTIFICATIVA/OBS;CIRUITOS ACEITOS;DATA DO ACEITE;ENDEREÇO");
		$this->smarty->assign('empresa',$empresas);
		$this->smarty->assign('usuario',$usuarios);
		$this->smarty->assign('dateFormate', $data);
		$this->smarty->assign('buf',$buffe);
		$this->smarty->assign('obj',$dados);
		$text = $this->smarty->fetch("{$this->tplDir}/contrato.tpl");

// 		header("Content-type: application/xls");
// 		header("Content-Disposition: attachment; filename=contrato_OS_Nº_".$dados['rel']['os_pedido_contrato']['num_os'].".xls");
// 		header('Content-Type: application/xls;charset=UTF-8');
// 		header("Pragma: no-cache");
// 		header("Expires: 0");


/*
		$codigoHTML=utf8_decode($text);
		$this->Dompdf->load_html($codigoHTML);
		$this->Dompdf->set_paper("legal", "landscape");
// 		ini_set("memory_limit","256M");
		$this->Dompdf->render();
		$this->Dompdf->stream("contrato_OS_Nº_".$dados['rel']['os_pedido_contrato']['num_os']."pdf");

*/
		$codigoHTML=utf8_decode($text);
		$this->Dompdf->loadHtml($codigoHTML);
		$this->Dompdf->setPaper("legal", "landscape");
		$this->Dompdf->render();
		$this->Dompdf->stream("contrato_OS_Nº_".$dados['rel']['os_pedido_contrato']['num_os']);

	}

	//tratamento do conteudo do xls (separado para o teste unitario)
	//TODO: gerando erro o metodo "liste_rel" que está no DB
	public function relatorioContent()
	{

		//$this->DBOS_antigo->setPag(array());
		$this->DBPedidoOs->zeraPag();
		//print_b($this->DBOS_antigo->getPag(),true);
		$this->arr = $this->DBPedidoOs->liste_rel();
		//print_b($this->arr,true);

		for($i=0;$i<count($this->arr);$i++)
		{
			if(isset($this->arr[$i]['rel']['agenda_instal']['observacoes']))
			{
				$observacoes = $this->arr[$i]['rel']['agenda_instal']['observacoes'];
				$observacoes = str_replace("\r\n","",trim($observacoes));
				$this->arr[$i]['rel']['agenda_instal']['observacoes'] = $observacoes;
				unset($observacoes);
			}
		}
	}

	//listagem personalizada de OS para ordenação por confirmação em primeiro instante
	public function liste($order='aceite',$pag=1,$selecao='seleto')
	{
		$this->smarty->display("{$this->tplDir}/list_organicPedidoOs.tpl");

	}

	public function listeFonte()
	{

//        $arrReturn['msg'] = 'teste';
//        die_json($arrReturn);
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
// 			$comiss = ($row['comiss'] != 'Não' && $row['comiss'] != 'Em Andamento')?substr($row['comiss'],0,10):utf8_decode(utf8_encode($row['comiss']));
			// acrescenta termo de responsabilidade //TODO: construir um método model pra isso
// 			$tresponsabilidade = $this->buscaTermoDeResponsabilidade( $row['instalacoes_idinstalacoes'] );
// 			$edicao = $this->buscaAlteraComissionamento( $row['instalacoes_idinstalacoes'] );

			$data['rows'][] = array(
				'id' => $row['idpedido'],
				'cell' => array(
					$row['idpedido'],
					$row['solicita'],
					$row['canal_venda_idcanal_venda'],
					$row['fator_comp'],
					$row['pedidoos_empresas_idempresas'],
					$row['pedido_criado'],
					$row['envio_contrato'],
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
// 		$searchSql = ($query != '') ? "where $query" : '';

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
// 			$comiss = ($row['comiss'] != 'Não' && $row['comiss'] != 'Em Andamento')?substr($row['comiss'],0,10):utf8_decode(utf8_encode($row['comiss']));

			// acrescenta termo de responsabilidade //TODO: construir um método model pra isso
// 			$tresponsabilidade = $this->buscaTermoDeResponsabilidade( $row['instalacoes_idinstalacoes'] );


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
		if( isset($_GET['param']) ){
			$this->dadosP['param'] = $_GET['param'];
			
		}

// 		$arrReturn['msg'] = $this->tplDir;
// 		die_json($arrReturn);
		if ( ! empty($this->dadosP['param']))
		{

			$this->DBPedidoOs->setPrkValue($this->dadosP['param']);
			$dados = $this->DBPedidoOs->view();
				
			//FIXME: arrumar (tá, mas arrumar oq?)
// 			$this->smarty->assign('pausada',$pausada);
			
// 			Termo Responsabilidade
			$this->organizaContrato( $dados['idpedido_os'] );

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
	
	/**
	 * Resgata informações do Termo de Responsabilidade
	 * 
	 * @param $instalacao
	 */
	private function organizaContrato( $pedido_os )
	{
	    if (!$pedido_os) {
	        $this->smarty->assign( 'contrato_sp' , false);
	    }
	    $this->ContratoSP->getContratoSP( new Integer($pedido_os) );
    	$this->smarty->assign( 'contrato_sp' , $this->ContratoSP->termo );
	    	
	}

}

?>

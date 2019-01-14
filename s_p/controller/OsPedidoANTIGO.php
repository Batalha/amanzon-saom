<?php

// include('./test_file.php');

//zend
//include_once "model/SaomModel.php";
//include_once "Zend/Translate/Adapter.php";
// include_once ('libs/MPDF56/mpdf.php');


//converte degrees minutes seconds to decimal
// include_once "libs/ConvertDegreesToGoogleMaps.php";
//include_once realpath(dirname(__FILE__) . '/../model/') . '/DBCanalVenda.php';
include_once 's_p/model/DBCanalVenda.php';
include_once 's_p/model/DBPedidoOS.php';
// include_once 'model/DBOS_SP.php';
// include_once 'model/DBMunicipio.php';
include_once "s_p/model/DBEmpresas.php";
// include_once 'helpers.class.php';

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
// 		$this->DBMunicipio = new DBMunicipio();
		$this->DBEmpresas = new DBEmpresas();

// 		$this->helpers = new Helpers();
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
// 			$empresas = $this->DBEmpresas->listaEmpresas();
// 			if( $_SESSION['login']['empresas_idempresas'] == 2 )
// 				foreach( $empresas AS $chave => $empresa )
// 				{
// 					if( $empresa['idempresas'] != 2 )
// 						unset( $empresas[$chave] );
// 				}

// 			$this->DBMunicipio->setOrderBy( 'municipio' );
// 			$listaMunicipios = $this->DBMunicipio->liste();
// 			for($i=0;$i<count($listaMunicipios);$i++)
// 			{
// 				$listaMunicipios[$i]['municipio'] = utf8_decode($listaMunicipios[$i]['municipio']);
// 			}

			$this->smarty->assign('perfil',$_SESSION['login']['perfis_idperfis']);
			$this->smarty->assign('listaCanalVendas',$listaCanalVendas);
			$this->smarty->display("{$this->tplDir}/create.tpl");
		}
		else
		{
			
			
// 			//busca saom
// 			$saom = new SaomModel( $this->adapter->getAdapterZend() );
// 			$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
// 			$this->dadosP['form']['saom'] = $saom_row->id_saom;
				
// 			//VERIFICA 'NUMERO DA OS' E 'IDENTIFICADOR' PARA NAO GERAR REPETIDOS
// 			$sql = "SELECT count(*) as total FROM os_sp WHERE numOS LIKE '{$this->dadosP['form']['numOS']}'";
// 			$buscaNumOs = $this->DBOS_antigo->queryDados($sql);
// 			//print_b($buscaNumOs,true);
// 			if($buscaNumOs[0]['total']>0)
// 			{
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg'] = 'Número da OS já existe.';
// 				die_json($arrReturn);
// 			}
			
// 			$sql = "SELECT count(*) as total FROM os_sp WHERE identificador LIKE '{$this->dadosP['form']['identificador']}'";
// 			$buscaIdentificador = $this->DBOS_antigo->queryDados($sql);
// 			if($buscaIdentificador[0]['total']>0)
// 			{
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg'] = $this->dadosP['form']['solicitacao'];
// 				die_json($arrReturn);
// 			}
// 			// fim

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

// 	public function edit()
// 	{
// 		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
// 		{
// 			$this->DBOS_antigo->setPrkValue($this->dadosP['param']);
// 			$dados = $this->DBOS_antigo->view();
// 			//print_b($dados,true);

// 			$municipios = $this->DBMunicipio->liste();
// 			$empresas = $this->DBEmpresas->listaEmpresas();
// 			if( $_SESSION['login']['empresas_idempresas'] == 2 )
// 				foreach( $empresas AS $chave => $empresa )
// 				{
// 					if( $empresa['idempresas'] != 2 )
// 						unset( $empresas[$chave] );
// 				}

// 			$this->smarty->assign('empresas',$empresas);
// 			$this->smarty->assign('arrMun',$municipios);
// 			$this->smarty->assign('obj',$dados);
// 			$this->smarty->display("{$this->tplDir}/edit.tpl");
// 		}
// 		elseif ( ! empty($this->dadosP['form']) )
// 		{
// 			$return  = $this->DBOS_antigo->edit($this->dadosP['form']);

// 			if(count($return['erros']))
// 			{
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg']    = implode("<hr>", $return['erros']);
// 			}
// 			else
// 			{
// 				$arrReturn['status']  = 'ok';
// 				$arrReturn['msg']     = 'Edição realizada com sucesso!';
// 			}
// 			die_json($arrReturn);
// 		}
// 	}

// 	public function countAgendPend()
// 	{
// 		$total['result'] = $this->DBOS_antigo->countAgendPend();
// 		die_json($total);
// 	}

// 	public function countAgend()
// 	{
// 		$total['result'] = $this->DBOS_antigo->countAgend();
// 		die_json($total);
// 	}

// 	public function countAgendConfirm()
// 	{
// 		$total['result'] = $this->DBOS_antigo->countAgendConfirm();
// 		die_json($total);
// 	}

// 	public function countOSVenc()
// 	{
// 		$total['result'] = $this->DBOS_antigo->countOSVenc();
// 		die_json($total);
// 	}

// 	public function countOSConc()
// 	{
// 		$total['result'] = $this->DBOS_antigo->countOSConc();
// 		die_json($total);
// 	}

// 	public function countOSAberto()
// 	{
// 		$total['result'] = $this->DBOS_antigo->countOSAberto();
// 		die_json($total);
// 	}

// 	public function getPrazoInstal()
// 	{
// 		if($this->dadosP['cidade'] == 'Belo Horizonte')
// 		{
// 			$data = explode("/",$this->dadosP['data']);
// 			$data = $data[1]."/".$data[0]."/".$data[2];

// 			$val                      = strtotime($data);
// 			$arrReturn['data_result'] =  date("d/m/Y",strtotime("+30 days",$val));
// 			$arrReturn['msg']         = '30 dias a partir da data de solicitação';
// 		}
// 		else
// 		{
// 			$data = explode("/",$this->dadosP['data']);
// 			$data = $data[1]."/".$data[0]."/".$data[2];

// 			$val = strtotime($data);
// 			$arrReturn['data_result'] =  date("d/m/Y",strtotime("+45 days",$val));
// 			$arrReturn['msg']         = '45 dias a partir da data de solicitação';
// 		}

// 		die_json($arrReturn);
// 	}

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
		//print_b($this->arr,true);
// 		$this->smarty->fetch("{$this->tplDir}/contrato.tpl");
		$text = $this->smarty->fetch("{$this->tplDir}/contrato.tpl");
// 		echo $text;


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
//		echo die_json($text);
		$this->Dompdf->stream("contrato_OS_Nº_".$dados['rel']['os_pedido_contrato']['num_os']."pdf");

*/
		$codigoHTML=utf8_decode($text);
		$this->Dompdf->loadHtml($codigoHTML);
		$this->Dompdf->setPaper("legal", "landscape");
//		$this->Dompdf->setOptions('defaultFont', 'Courier');
// 		ini_set("memory_limit","256M");
		$this->Dompdf->render();
//		echo die_json($text);
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

// 	public function getArr()
// 	{
// 		return $this->arr;
// 	}
// 	//relatorio em csv - fim


// 	//lista com terceiro parametro
// 	public function listaComTerceiroParametro($parametros)
// 	{
// 		$params = explode("-",$parametros);
// 		//print_b($params,true);
// 		$this->liste($params[0],$params[1],$params[2]);
// 	}

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

		//FILTRA PELO SAOM
// 		$saom = ($_SESSION['SAOM'] == 'SP')?'2':'1';//ajusta pada o id do saom
// 		if($saom != 2){
// 			if($searchSql!='')
// 				$searchSql .= " AND saom = '{$saom}'";
// 			else
// 				$searchSql .= " WHERE saom = '{$saom}'";
// 		}

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
// 					utf8_decode(utf8_encode($row['municipios_municipio'])),
// 					utf8_decode(utf8_encode($row['municipios_macroregiao'])),
// 					$row['os_prazoInstal'],
// 					utf8_decode(utf8_encode($row['agendamento'])),
// 					$comiss,
// 					$edicao,
// 					utf8_decode(utf8_encode($row['vsatCriada'])),
					// utf8_decode(utf8_encode($row['codAnatel'])),
// 					utf8_decode(utf8_encode($row['aceiteProdemge'])),
// 					utf8_decode(utf8_encode($row['paralisado'])),
// 					utf8_decode(utf8_encode($tresponsabilidade))
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

		//RETIRA DA LISTA INSTALACOES DE OUTRAS EMPRESAS (quando não é vodanet atualmente)
// 		if($_SESSION['login']['empresas_idempresas']!=1)
// 		{
// 			if($searchSql!='')
// 			$searchSql .= " AND empresa = {$_SESSION['login']['empresas_idempresas']}";
// 			else
// 			$searchSql .= " WHERE empresa = {$_SESSION['login']['empresas_idempresas']}";
// 		}

		//FILTRA PELO SAOM
// 		$saom = ($_SESSION['SAOM'] == 'SP')?'2':'1';//ajusta pada o id do saom
// 		if($saom != 1){
// 			if($searchSql!='')
// 			$searchSql .= " AND saom = '{$saom}'";
// 			else
// 			$searchSql .= " WHERE saom = '{$saom}'";
// 		}
			
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
// 					utf8_decode(utf8_encode($row['municipios_municipio'])),
// 					utf8_decode(utf8_encode($row['municipios_macroregiao'])),
// 					$row['os_prazoInstal'],
// 					$row['os_empresas_idempresas'],
// 					$row['agendamento'],
// 					$comiss,
// 					utf8_decode(utf8_encode($row['vsatCriada'])),
// 					// utf8_decode(utf8_encode($row['codAnatel'])),
// 					utf8_decode(utf8_encode($row['aceiteProdemge'])),
// 					utf8_decode(utf8_encode($row['paralisado'])),
// 					utf8_decode(utf8_encode($tresponsabilidade))
				)
			);
		}
// 		print_b($data,true);

		echo json_encode($data);
	}
	/**
	 * Busca Termo de Responsabilidade
	 */
// 	private function buscaTermoDeResponsabilidade( $idinstalacoes )
// 	{
// 		$termo_responsabilidade = $this->TermoResponsabilidade->fetchRow( " id_instalacoes = '$idinstalacoes' " );
		
			
// 			if( $termo_responsabilidade instanceof Zend_Db_Table_Row ){
// 				if( (int)$termo_responsabilidade->status == 1){
// 					$tresponsabilidade = 'Aceito';
// 				}else if( (int)$termo_responsabilidade->status == 2){
// 					$tresponsabilidade = 'Rejeitado';
// 				}
// 			}else{
// 				$tresponsabilidade = 'Não';
// 			}

// 		return $tresponsabilidade;
// 	}
	
// 	public function buscaAlteraComissionamento( $idinstalacoes){
		
// 		$sql = "
// 				SELECT *
// 				FROM log 
// 				WHERE idreferencia = '$idinstalacoes' 
// 				ORDER BY idlog DESC";
		
// 		$alterado_comiss = $this->DBOS_antigo->queryDados($sql);
// 			$rowSet = $alterado_comiss;
// 			if ($rowSet[0]['idreferencia']) {
// 				if ($rowSet[0]['log_acao_idlog_acao'] == 2) {
// 					$alterado = $rowSet[0]['observacoes'];
// 					$alterado = '
// 							<div id="wrape"></div>
// 							<a href="#" id="tooltip" title="teste"><img src =" /imagens/obs.GIF"></a>';
// 				}else {
// 					$alterado ='';
// 				}
// 			}else{
// 				$alterado = 'nao';
// 			}

// 	return $alterado;
// 	}

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
// 					$arrReturn['msg'] = $dados['idpedido_os'];
// 					die_json($arrReturn);
			
// 			if (!isset($dados['idpedido_os'])) {
// 			    $dados['rel']['os_pedido_contrato']['idcontrato'] = null;
// 			    $dados['rel']['os_pedido_contrato']['idcontrato']   = null;
// 			}
			
			// print_b($dados,true);

			//PAUSAS
// 			$sql = "
//             		SELECT 
//             			p.idpausas, 
//             			p.pausa_inicio, 
//             			p.pausa_fim 
//             		FROM pausas p 
//             		WHERE 
//             			p.tabela = 'OS_SP' AND 
//             			p.chaveextrangeira = '{$this->dadosP['param']}' 
//             	";
// 			$listaPausas = $this->DBOS_antigo->queryDados($sql);
// 			$pausado = 0;
// 			for($i=0;$i<count($listaPausas);$i++)
// 			{
// 				if(empty($listaPausas[$i]['pausa_fim']))//PAUSADO
// 				{
// 					$pausado = 1;
// 					$pausaid = $listaPausas[$i]['idpausas'];

// 					$this->smarty->assign('pausaid',$pausaid);
// 					$this->smarty->assign('dataPausado',$this->helpers->data_us_br($listaPausas[$i]['pausa_inicio']));

// 					$i = count($listaPausas);
// 				}
// 			}
// 			$this->smarty->assign('pausado',$pausado);

// 			if(isset($dados['rel']['instalacoes']['data_aceite']) && $dados['rel']['instalacoes']['data_aceite']!='')
// 			{
// 				$dados['rel']['instalacoes']['data_aceite'] = $this->helpers->data_us_br($dados['rel']['instalacoes']['data_aceite']);
// 			}

			//PERMISSAO
// 			$usuario_permissao = 0;
// 			if( $_SESSION['login']['perfis_idperfis'] != 2 && $_SESSION['login']['perfis_idperfis'] != 3 )
// 			{
// 				if (isset($dados['rel']['instalacoes']['data_aceite']) && $dados['rel']['instalacoes']['data_aceite'] == '')
// 					$usuario_permissao = 1;
// 				else
// 					if($_SESSION['login']['perfis_idperfis'] == 5 || $_SESSION['login']['perfis_idperfis'] == 4)
// 						$usuario_permissao = 1;
// 			}

			//print_b($dados,true);
			//TODO: buscar o nome da vsat para apresentar aqui
// 			if( !isset($nomeVsat) )
// 				$nomeVsat = '';

// 			$sql = "
// 				SELECT * FROM  pausas WHERE tabela = 'OS_SP' AND chaveextrangeira = '{$this->dadosP['param']}' 
// 				AND ( pausa_fim IS NULL OR pausa_fim = '0000-00-00') 
// 			";
// 			$pausada = $this->DBOS_antigo->queryDados($sql);
			
// 			$pausada = count($pausada);
			
// 			$licenca_anatel = null;
// 			if (isset($dados['rel']['instalacoes']['idinstalacoes'])) {
// 			    $licenca_anatel = $this->busca_licenca_anatel( $dados['rel']['instalacoes']['idinstalacoes'] );
// 			}
// 			$this->smarty->assign('licenca_anatel', $licenca_anatel);
				
			//FIXME: arrumar (tá, mas arrumar oq?)
// 			$this->smarty->assign('pausada',$pausada);
			
// 			Termo Responsabilidade
			$this->organizaContrato( $dados['idpedido_os'] );
			
			// Relatório Fotográfico
// 			$this->organizaRelatorioFotografico( $dados['rel']['instalacoes']['idinstalacoes'] );

			// Google Maps
// 			if( isset($dados['rel']['instalacoes']) )
// 				$this->buildMapsFromGoogleMaps( $dados['rel']['instalacoes'] );
			
// 			print_r($this->tplDir);

						
			$usuarios = $this->DBUsuarios->liste();
			foreach ($usuarios as $cha=>$usuario){
				if ($usuario['idusuarios'] == $dados['iduser_cadastro']){
					$usuarios = $usuario['nome'];
				}
			}
				
			$empresas = $dados['rel']['empresas']['empresa'];
			
// 			$arrReturn['msg'] = $fatorC;
// 			die_json($arrReturn);

// 			$empresas = $this->DBEmpresas->listaEmpresas();
// 			foreach ( $empresas as $cha=>$empresa){
// 				if ($_SESSION['login']['empresas_idempresas'] == $empresa['idempresas']){
// 					$empresas = $empresa['empresa'];
// 				}
// 			}
			
// 			$this->smarty->assign('nomeVsat',$nomeVsat);
			$this->smarty->assign('login',$_SESSION['login']);
			$this->smarty->assign('empresa',$empresas);
			$this->smarty->assign('usuario',$usuarios);
// 			$this->smarty->assign('usuario_permissao',$usuario_permissao);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/view.tpl");
		}
	}

	/**
	 * Constrói mapa do Google Maps com graus minutos e segundos passados
	 * da latitude e longitude da instalação
	 *
	 * @param $instalacao {array}
	 */
// 	private function buildMapsFromGoogleMaps( Array $instalacao )
// 	{
// 		if( $this->validaCoordenadasLocalizacao( $instalacao ) ){
// 			$ConvertDegreesToGoogleMaps = new ConvertDegreesToGoogleMaps();

// 			// converte graus minutos segundos em decimais
// 			$decimais = $ConvertDegreesToGoogleMaps->ConvertDegreesToDecimal(
// 				$instalacao['latitude_graus'],
// 				$instalacao['latitude_minutos'],
// 				$instalacao['latitude_segundos'],
// 				$instalacao['longitude_graus'],
// 				$instalacao['longitude_minutos'],
// 				$instalacao['longitude_segundos']
// 			);

// 			// resolve direcao das coordenadas
// 			$decimais['coordinates'] = $this->converteCoordenadasPordirecao( $instalacao , $decimais['coordinates'] );
			
// 			$this->smarty->assign('GoogleMapCoordinates',$decimais['coordinates']);
// 		}
// 		else
// 			$this->smarty->assign('GoogleMapCoordinates',false);
// 	}
// 	/**
// 	 * Converte para negativo e positivo segundo a direção S N W E
// 	 */
// 	private function converteCoordenadasPordirecao( $instalacao , $decimais )
// 	{
// 		if( $instalacao['latitude_direcao'] == 'S' )
// 			$decimais[ 'latitude' ] = $decimais[ 'latitude' ] * -1;
// 		if( $instalacao['longitude_direcao'] == 'W' )
// 			$decimais[ 'longitude' ] = $decimais[ 'longitude' ] * -1;

// 		return $decimais;
// 	}
// 	/**
// 	 * Valida coordenadas da instalacao
// 	 * 
// 	 *  @param $instalacao {array}
// 	 */
// 	private function validaCoordenadasLocalizacao( Array $instalacao )
// 	{
// 		// valida existência de conteúdo nos campos
// 		if(
// 			!empty($instalacao['latitude_graus']) &&
// 			!empty($instalacao['latitude_minutos']) &&
// 			!empty($instalacao['latitude_segundos']) &&
// 			!empty($instalacao['longitude_graus']) &&
// 			!empty($instalacao['longitude_minutos']) &&
// 			!empty($instalacao['longitude_segundos'])
// 		){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}
	
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
	
	/**
	 * Resgata informações do Relatorio Fotografico
	 * 
	 * @param $instalacao
	 */
// 	private function organizaRelatorioFotografico( $instalacao )
// 	{
// 		$this->RelatorioFotografico->getRelatorioDeInstalacao( new Integer($instalacao) );

// 		$this->smarty->assign( 'relatorio_fotografico' , $this->RelatorioFotografico->relatorio );
// 	}
	
// 	private function busca_licenca_anatel( $idinstalacao )
// 	{
// 		$this->LicencaAnatel->setinstalacoes_idinstalacoes( $idinstalacao );
// 		$this->LicencaAnatel->buscaLicencaPelaInstalacao();
// 		if( count($this->LicencaAnatel->getlicencaAnatelArray()) > 0 )
// 			return "<a target='_blank' href='{$this->LicencaAnatel->getendereco()}'><i class='icon-file'></i><font style='color:#000;'>{$this->LicencaAnatel->getnome()}</font></a>";
//         else return '';
// 	}


// 	public function pausa()
// 	{
// 		//TODO: dividir em models - fazer OO
			
// 		//VERIFICA PRE EXISTENCIA DE PAUSA (SE JÁ ESTÁ PAUSADO)
// 		$sql = "SELECT p.idpausas FROM pausas p WHERE p.chaveextrangeira = '{$this->dadosP['form']['idOS_reserva']}' AND p.tabela = 'OS_SP' AND ISNULL(p.pausa_fim) ";
// 		$dados = $this->DBOS_antigo->queryDados($sql);

// 		if( count($dados) > 0 )//JA EXISTE
// 		{
// 			$arrReturn['status'] = 'erro';
// 			$arrReturn['msg'] = 'OS já está pausada.';
// 			die_json($arrReturn);
// 		}
// 		else//NAO EXISTE PAUSA REGISTRADA AINDA
// 		{
// 			//instância de OS
// 			$os = $this->DBOS_antigo->carrega($this->dadosP['form']['idOS_reserva']);

// 			$dataAtual = $this->dadosP['form']['campoDataPausa'];
// 			$dataAtual = $this->helpers->data_br_us($dataAtual);

// 			/* Desabilitado devido ha uma solicitação do Hernan em 09/04/2013 
// 			//VERIFICA PRAZO INSTAL
// 			if($os['prazoInstal'] < $dataAtual)
// 			{
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg'] = 'Não é permitido pausar após o Prazo de Instalação.';
// 				die_json($arrReturn);
// 			}
// 			*/

// 			if($dataAtual=='')
// 			{
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg'] = 'Campo de Data não pode ficar em branco.';
// 				die_json($arrReturn);
// 			}
// 			$sql = "INSERT INTO pausas (tabela, pausa_inicio, chaveextrangeira)
//     				VALUES ('OS_SP', '{$dataAtual}', '{$this->dadosP['form']['idOS_reserva']}' )";
// 			if($this->DBOS_antigo->query($sql))
// 			{
// 				$arrReturn['status'] = 'ok';
// 				$arrReturn['msg'] = 'OS pausada com sucesso.';
// 			}
// 			else
// 			{
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg'] = 'Erro ao criar pausa.';
// 			}
// 			die_json($arrReturn);
// 		}
// 	}


// 	public function despausa()
// 	{
// 		//TODO: dividir em models - fazer OO
			
// 		$dataAtual = $this->dadosP['form']['campoDataPausa'];
// 		$dataAtual = $this->helpers->data_br_us($dataAtual);
// 		$sql = "
//     		UPDATE pausas 
//     		SET pausa_fim = '{$dataAtual}' 
//     		WHERE idpausas = '{$this->dadosP['form']['pausa']}'; 
//     	";
// 		if($this->DBOS_antigo->query($sql))
// 		{
// 			//muda prazoInstal da OS #retorno 'tempo' em dias
// 			$sql = "
// 	    			SELECT 
// 	    				p.chaveextrangeira AS os,
// 	    				p.pausa_inicio AS pausa_inicio, 
// 	    				p.pausa_fim AS pausa_fim,
// 	    				(SELECT DATEDIFF(p.pausa_fim,p.pausa_inicio)) AS tempo
// 	    			FROM pausas p
// 	    			WHERE p.idpausas = '{$this->dadosP['form']['pausa']}';
// 	    		";
// 			$pausa = $this->DBOS_antigo->queryDados($sql);
// 			$sql = "
// 	    			UPDATE os_sp o
// 	    			SET o.prazoInstal = DATE_ADD(o.prazoInstal,INTERVAL {$pausa[0]['tempo']} DAY)
// 	    			WHERE idos = {$pausa[0]['os']};
// 	    		";
// 			if(!$this->DBOS_antigo->query($sql))
// 			{
// 				//email para webmaster
// 				$headers  = 'MIME-Version: 1.0' . "\r\n";
// 				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// 				$msg = "
// 						Erro ao modificar prazoInstal.<br/>
// 						Pausa: {$this->dadosP['form']['pausa']}<br/>
// 						OS: {$pausa[0]['os']}
// 					";
// 				mail('lotharthesavior@gmail.com', 'Erro SAOM', $msg,$headers);

// 				//recado para usuario
// 				$arrReturn['status'] = 'erro';
// 				$arrReturn['msg'] = 'Despausado, porém ocorreu um erro ao atualizar o Prazo de Instalação, o Webmaster já foi informado do erro.';
// 				exit;
// 			}

// 			$arrReturn['status'] = 'ok';
// 			$arrReturn['msg'] = 'OS despausada com sucesso.';
// 		}
// 		else
// 		{
// 			$arrReturn['status'] = 'erro';
// 			$arrReturn['msg'] = 'Erro ao despausar.';
// 		}
// 		die_json($arrReturn);
// 	}

// 	public function caixaPausa()
// 	{
// 		$this->smarty->display("{$this->tplDir}/caixa_pausa.tpl");
// 	}

// 	public function caixaDespausa()
// 	{
// 		$this->smarty->display("{$this->tplDir}/caixa_despausa.tpl");
// 	}

// 	public function cancela()
// 	{
// 		//TODO: melhorar isso
// 		$idos = $this->dadosP['param'];
// 		//a pedido do Alex será acrescido um "c" ao final do campo 'identificador'
// 		$sql = "UPDATE os_sp SET os_status_idos_status = '2', identificador = CONCAT(identificador,'c') WHERE idos = '{$idos}'";
// 		if($this->DBOS_antigo->query($sql))
// 		{
// 			return true;
// 		}
// 		else
// 		{
// 			return false;
// 		}
// 	}

// 	public function relatorioAcompanhamento()
// 	{
// 		$sql = "SELECT
// 					o.identificador AS ID,
// 					o.numOS AS OS,
// 					o.dataSolicitacao AS 'Data de Solicitação', 
// 					o.prazoInstal AS Prazo,
// 					(SELECT IF(
// 						i.data_aceite IS NOT NULL AND i.data_aceite != '0000-00-00',
// 						'Aceito',
// 						(SELECT IF(
// 								(SELECT COUNT(*) FROM pausas WHERE tabela = 'OS_SP' AND chaveextrangeira = o.idos AND pausa_fim IS NULL) > 0,
// 								'Paralisado',
// 								(SELECT IF(
// 											(SELECT COUNT(*) FROM agenda_instal WHERE os_idos = o.idos) > 0,
// 											'Agendado',
// 											'A agendar'
// 										  )
// 								)
// 							  )
// 						)
// 					)) 
// 					AS Status,
// 					(SELECT e.empresa FROM empresas e WHERE e.idempresas = o.empresas_idempresas) AS Empreiteira,
// 					m.municipio AS localidade,
// 					i.nome AS designação,
// 					a.data AS 'Data do Agendamento',
// 					o.contato AS Contato,
// 					o.enderecoInstal AS Endereco,
// 					o.cep AS Cep,
// 					o.telContato AS Telefone,
// 					i.mac_comiss AS 'Número Mac',
// 					i.teccampo AS Técnico,
// 					i.data_aceite AS 'Data de Aceite',
// 					o.observacoes AS Observações,
// 					o.ipdvb,
// 					o.iplan,
// 					(SELECT IF(
// 								i.cabo_rj45 = 0,
// 								'Não',
// 								'Sim'
// 							)
// 					),
// 					(SELECT IF(
// 								i.cabo_rj45 = 0,
// 								i.cabo_rj45_justificativa_nao,
// 								i.cabo_rj45_justificativa_sim
// 							)	
// 					),
// 					i.latitude_graus AS latitude_graus,
// 					i.latitude_minutos AS latitude_minutos,
// 					i.latitude_segundos AS latitude_segundos,
// 					i.longitude_graus AS longitude_graus,
// 					i.longitude_minutos AS longitude_minutos,
// 					i.longitude_segundos AS longitude_segundos
// 				FROM os_sp o
// 				LEFT JOIN municipios m ON idmunicipios = o.municipios_idcidade
// 				LEFT JOIN instalacoes i ON i.os_idos = o.idos
// 				LEFT JOIN agenda_instal a ON a.os_idos = o.idos";
// 		$lista = $this->DBOS_antigo->queryDados($sql);
// 		$titulos = array(
//     					'ID',
//     					'OS_SP',
// 						utf8_decode('Data de Solicitação'),
//     					'Prazo',
//     					'Status',
//     					'Empreiteira',
//     					'Localidade',
// 						utf8_decode('Designação'),
//     					'Agendamento',
//     					'Contato',
// 						utf8_decode('Endereço'),
// 						'Cep',
//     					'Telefone',
// 						utf8_decode('Número MAC'),
// 						utf8_decode('Técnico'),
//     					'Data de Aceite',
// 						utf8_decode('Observaçoes'),
// 						'Ip Lan',
// 						'Ip Dvb',
// 						'Cabo Rj45',
// 						utf8_decode('Observaçoes Cabo Rj45'),
// 						'Latitude Graus',
// 						'Latitude Minutos',
// 						'Latitude Segundos',
// 						'Longitude Graus',
// 						'Longitude Minutos',
// 						'Longitude Segundos'
// 		);

// 		$nome_arquivo = 'relatorios/relatorio_acompanhamento_'.date('d').'_'.date('m').'_'.date('Y').'_-_'.date('H').'_'.date('i').'_'.date('s').'_-_'.normaliza(str_replace(' ','_',trim($_SESSION['login']['nome']))).'.csv';
// 		$arquivo = fopen($nome_arquivo,'w');
			
// 		fputcsv($arquivo, $titulos, ';');
			
// 		for($i=0;$i<count($lista);$i++)
// 		{
// 			$arrayNovo = array();
// 			foreach($lista[$i] as $item)
// 			{
// 				$arrayNovo[] = utf8_decode($item);
// 			}
// 			fputcsv($arquivo, $arrayNovo, ';');
// 		}
			
// 		fclose($arquivo);
			
// 		header('Content-Description: File Transfer');
// 		header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"');
// 		header('Content-Type: application/octet-stream');
// 		header('Content-Transfer-Encoding: binary');
// 		header('Content-Length: ' . filesize($nome_arquivo));
// 		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// 		header('Pragma: public');
// 		header('Expires: 0');
			
// 		// Envia o arquivo para o cliente
// 		readfile($nome_arquivo);
// 	}

// 	/*
// 	 * Método para edição do sat_vsat_code
// 	 */
// 	public function eutelsatcode_list()
// 	{
// 		$sql = "
//     		SELECT *
//     		FROM listeutelsatcode;
//     	";
// 		$lista = $this->DBOS_antigo->queryDados($sql);
			
// 		$this->smarty->assign('lista_contagem',count($lista));
// 		$this->smarty->assign('lista',$lista);
// 		$this->smarty->display("{$this->tplDir}/eutelsatcode_list.tpl");
// 	}
// 	public function eutelsatcode_list_busca($sequencia)
// 	{
// 		$form = json_decode($_POST['form']);

// 		$where = "";
// 		for($i=0;$i<count($form);$i++)
// 		{
// 			if( $form[$i]->value != '' && $form[$i]->value != 'vz' )
// 			{
// 				$where .= " ".$form[$i]->name." LIKE '%".$form[$i]->value."%' AND";
// 			}
// 			else if( $form[$i]->value == 'vz' )
// 			{
// 				$where .= " ( ".$form[$i]->name." IS NULL OR ".$form[$i]->name." = '' ) AND";
// 			}
// 		}
// 		$where = substr($where, 0, -3);

// 		if( $where == '' ){ $where = '1'; }

// 		$sql = "
// 	    		SELECT *
// 	    		FROM listeutelsatcode
// 	    		WHERE {$where};
// 	    	";
// 		$lista = $this->DBOS_antigo->queryDados($sql);

// 		for( $i=0 ; $i < count($form) ; $i++ ){ $form[$i] = get_object_vars($form[$i]); }
// 		$this->smarty->assign('form',$form);

// 		$this->smarty->assign('lista_contagem',count($lista));
// 		$this->smarty->assign('lista',$lista);
// 		$this->smarty->display("{$this->tplDir}/eutelsatcode_list.tpl");
// 	}
// 	public function salva_eutelsat_code()
// 	{
// 		$sql = $_POST['query'];//exit($sql);
// 		$sqls = explode(';',$sql);
// 		unset($sqls[count($sqls)-1]);
// 		foreach($sqls AS $sql1)
// 		{
// 			if(!$this->DBOS_antigo->query($sql1))
// 			{
// 				exit(false);
// 			}
// 		}
// 		exit(true);
// 	}

// 	/*
// 	 * Método que verifica o ipdvb e o iplan
// 	 */
// 	public function verificaIplanIpdvb($idos)
// 	{
// 		$sql = "
//     		SELECT
//     			o.ipdvb AS ipdvb,
//     			o.iplan AS iplan
//     		FROM
//     			os_sp o
//     		WHERE
//     			o.idos = '{$idos}';
//     	";
			
// 		$os = $this->DBOS_antigo->queryDados($sql);
// 		if( $os[0]['ipdvb'] == '' || $os[0]['iplan'] == '' )
// 			echo true;
		
// 		else
// 			echo false;
// 	}

// 	public function edicao_critica()
// 	{
// 		//print_b($this->dadosP['form'],true);
			
// 		$sql = "
//     		UPDATE
//     			os_sp o 
//     		SET
//     			o.iplan = '{$this->dadosP['form']['iplan']}',
//     			o.ipdvb = '{$this->dadosP['form']['ipdvb']}'
//     		WHERE
//     			o.idos = '{$this->dadosP['form']['idos']}';
//     	";
			
// 		if($this->DBOS_antigo->query($sql))
// 		{
// 			$arrReturn['status']  = 'ok';
// 			$arrReturn['msg']     = 'Edição realizada com sucesso!';
// 		}
// 		else
// 		{
// 			$arrReturn['status'] = 'erro';
// 			$arrReturn['msg']    = "Erro ao modificar informações da OS.";
// 		}
// 		die_json($arrReturn);
// 	}


// 	// -----------------------------------------------------
// 	// ----------------- RELATORIO CSV ---------------------
// 	// -----------------------------------------------------

// 	public function relatorioAnatel()
// 	{
// 		$this->smarty->display("{$this->tplDir}/form_relatorio_anatel.tpl");
// 	}

// 	public function enviaRelatorioAnatel()
// 	{
// 		//print_b($this->dadosF['arquivo_csv'],true);

// 		if( ! empty($this->dadosF['arquivo_csv']))
// 		{
// 			$move = move_uploaded_file($this->dadosF['arquivo_csv']['tmp_name'], 'upload/relatorioAnatel/'.$this->dadosF['arquivo_csv']['name']);
// 			if ($move)
// 			{
// 				$arquivo = 'upload/relatorioAnatel/'.$this->dadosF['arquivo_csv']['name'];
// 			}
// 			else
// 			{
// 				$arquivo = 'Não movido.';
// 			}
// 		}
		
// 		return $this->geraNovoCsvRelatorioAnatel($arquivo);
// 	}

// 	private function geraNovoCsvRelatorioAnatel($arquivo)
// 	{
// 		//print_b($arquivo,true);
// 		$novaCsv = array();
// 		$novaCsv2 = array();

// 		$titulos = array(
// 			'Nome',
// 			'Latitude Graus',
// 			'Latitude Minutos',
// 			'Latitude Segundos',
// 			'Longitude Graus',
// 			'Longitude Minutos',
// 			'Longitude Segundos',
// 			'Marca Antena',
// 			'CEP',
// 			'Endereco',
// 			'Numero',
// 			'Bairro',
// 			'Cidade',
// 			'ODU',
// 			'BUC',
// 			'Marca Antena',
// 			'Empresa'
// 		);
		
// 		//pega informações
// 		$row = 1;
// 		$handle = fopen ($arquivo,"r");
// 		while ( ($data = fgetcsv($handle, 1000, ";")) !== FALSE )
// 		{
// 			if($row > 1)
// 			{
// 				//monta array com dados para novo csv
// 				$linha = explode(';',$data[0]);
// 				$nomeVsat = $linha[0];
// 				$sql = "
// 					SELECT
// 						i.nome, 
// 						i.latitude_graus,
// 						i.latitude_minutos,
// 						i.latitude_segundos,
// 						i.longitude_graus,
// 						i.longitude_minutos,
// 						i.longitude_segundos,
// 						i.antena_comiss,
// 						o.cep,
// 						o.enderecoInstal,
// 						o.cidade,
// 						te.nome AS odu,
// 						i.buc,
// 						i.antena_comiss,
// 						e.empresa
// 					FROM instalacoes i
// 					LEFT JOIN os_sp o ON o.idos = i.os_idos
// 					LEFT JOIN tipo_equipamentos te ON te.idtipo_equipamentos = i.odu
// 					LEFT JOIN tipo_equipamentos te2 ON te2.idtipo_equipamentos = i.odu
// 					LEFT JOIN empresas e ON e.idempresas = o.empresas_idempresas
// 					WHERE i.nome = '{$nomeVsat}';
// 				";
// 				$dados = $this->DBOS_antigo->queryDados($sql);
// 				if( count($dados) > 0 )
// 				{
// 					array_push($novaCsv, $dados);
// 				}
// 				else
// 				{
// 					echo "Vsat {$nomeVsat} não encontrada!<br/>";
// 				}
// 			}
// 			$row++;
// 		}
// 		fclose ($handle);
// 		//print_b($novaCsv,true);

// 		//arrumando endereço (dividindo em 3 campos diferentes
// 		array_push($novaCsv2,$titulos);
// 		foreach( $novaCsv as $linha )
// 		{
// 			$endereco_partido = explode(',',$linha[0]['enderecoInstal']);
// 			$endereco = (isset($endereco_partido[0]))?$endereco_partido[0]:'';
			
// 			$endereco_partido2 = explode('-',$endereco_partido[1]);
// 			$numero = (isset($endereco_partido2[0]))?$endereco_partido2[0]:'';
// 			$bairro = (isset($endereco_partido2[1]))?$endereco_partido2[1]:'';
				
// 			array_push($novaCsv2,array(
// 				$linha[0]['nome'],
// 				$linha[0]['latitude_graus'],
// 				$linha[0]['latitude_minutos'],
// 				$linha[0]['latitude_segundos'],
// 				$linha[0]['longitude_graus'],
// 				$linha[0]['longitude_minutos'],
// 				$linha[0]['longitude_segundos'],
// 				$linha[0]['antena_comiss'],
// 				$linha[0]['cep'],
// 				$endereco,
// 				$numero,
// 				$bairro,
// 				$linha[0]['cidade'],
// 				$linha[0]['odu'],
// 				$linha[0]['buc'],
// 				$linha[0]['antena'],
// 				$linha[0]['empresa']
// 			));
// 		}
// 		//print_b($novaCsv2,true);

// 		//pega informações
// 		$row = 1;
// 		$dataHoje = date('dmY');
// 		$arquivoNovo = "upload/relatorioAnatel/relatorio_{$dataHoje}.csv";
// 		$handle = fopen ($arquivoNovo,"w");
// 		foreach ($novaCsv2 as $linha)
// 		{
// 			fputcsv($handle,$linha,';');
// 		}
// 		fclose ($handle);

// 		echo "<a target='_blank' href='{$arquivoNovo}'> >>>Download<<< </a>";
// 	}

}

?>

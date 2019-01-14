<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OS
 *
 * @author Sávio lotharthesavior@gmail.com
 */

//zend
require_once 'helpers/AdapterZend.php';
require_once 'model/EquipamentosModel.php';
require_once 'model/EquipamentosAntenasModel.php';
require_once 'model/EquipamentosLocaisModel.php';
require_once 'model/LocaisEquipamentosModel.php';
require_once 'model/TipoEquipamentosModel.php';
require_once 'model/MunicipiosModel.php';
require_once 'model/InstalacoesModel.php';
require_once 'model/EquipamentosAntenasLocaisModel.php';

include_once 'model/DBEquipamento.php';
include_once 'model/DBTipoEquipamento.php';
include 'libs/phpexcel/PHPExcel/IOFactory.php';

require_once 'helpers/Controller.php';


class Equipamento extends Controller
{    
	protected $listaTipoEquipamentos;
    protected $listaMunicipios;
    protected $listaInstalacoes;
    protected $listaLocaisEquipamentos;
    protected $local;
    protected $status;
    protected $id;
    protected $idEquipamentosLocais;
    protected $equipamento;
    protected $formatosPermitidosPlanilha = array(
    	'csv' , 'xls' , 'xlsx'
    );
    protected $formatoPlanilha;
    protected $planilha;
    protected $dadosPlanilha = array();
    protected $linhaPlanilha;
    protected $planilhaAberta;
    protected $tipoLocal;
    protected $tipoEquipamento;
    protected $snoEquipamento;
    protected $macEquipamento;
    protected $nomeLocal;
    
    //zend --
    // vars --
	
    protected $tplDir = 'equipamento';
    
    function __construct() 
    {
        parent::__construct();
        $this->DB = new DBEquipamento();
    }
    
    public function create()
    {
       
       if (empty($this->dadosP['form'])) 
       {
            $this->carregaListasFormulario();
            
            $this->smarty->assign('listaTipoEquipamentos',$this->listaTipoEquipamentos->toArray());
            $this->smarty->assign('listaMunicipios',$this->listaMunicipios->toArray());
            $this->smarty->assign('listaInstalacoes',$this->listaInstalacoes->toArray());
            $this->smarty->assign('listaLocaisEquipamentos',$this->listaLocaisEquipamentos->toArray());
            $this->smarty->display("{$this->tplDir}/new.tpl");
       }
       else 
       {
            $this->trataLocal();
            
            $equipamentos = new EquipamentosModel( $this->adapter->getAdapterZend() );
            $this->id = $equipamentos->insert( $this->dadosP['form'] );
            
            //TODO: aguardando funcionalidade devida
            //$this->gravaLocal();
            
            if( $this->id != 0 )
            	$arrReturn = array('status' => 'ok','msg' => 'Cadastro efetuado com sucesso!');
            else
                $arrReturn = array('status' => 'erro','msg' => 'Erro ao cadastrar Equipamento.');
            
            die_json($arrReturn);
       }
    }
    
    public function createMulti()
    {
    	ini_set('max_execution_time', 1000);
    	
    	if (empty($this->dadosF['planilha']))
       		$this->smarty->display("{$this->tplDir}/createMulti.tpl");
       	
       	else
       	{
       		$this->form = $this->dadosF['planilha'];
       		
       		$this->validaFormatoPlanilha();
       		
       		$move = move_uploaded_file(
       			$this->form['tmp_name'], 
       			normaliza(str_replace(' ', '_', 'upload/equipamento/'.$this->form['name'])) 
       		);
			if ($move)
			{
				$this->planilha = 'upload/equipamento/'.$this->form['name'];
				
           		$this->filtroParaFormato();
           		
           		$this->gravaBD();
			}
			else
			{
				$erro = "
	    			<div class='alert alert-error'>
					  <button class='close' data-dismiss='alert'>×</button>
					  <strong>Erro!</strong> Erro no associar equipamento {$this->snoEquipamento} ao local {$this->nomeLocal}!
					</div>
	    		";
	    		echo $erro;
				exit;
       		}
       	}
    }
    
    public function view()
    {
    	$this->id = $this->dadosP['param'];
    	
    	$equipamento = new EquipamentosModel( $this->adapter->getAdapterZend() );
		$equipamento_linha = $equipamento->fetchRow("idequipamentos = '{$this->id}'");
// 		echo "<pre>";
// 		print_r($equipamento_linha);
// 		echo "</pre>";
// 		die;

// 		print_b($equipamento_linha,false);
		$this->equipamento = $equipamento_linha->toArray();
		

		
		$this->carregaDependencias();
		
		$this->smarty->assign('obj',$this->equipamento);
        $this->smarty->display("{$this->tplDir}/view.tpl");
    }
    
    public function edit() 
    {    
        if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']) ) 
       	{
       		$this->id = $this->dadosP['param'];
            
            $this->carregaEquipamento();
            
            $this->carregaDependencias();
            
            $this->carregaListasFormulario();
            
            $this->smarty->assign('lista_tipo_equipamento',$this->listaTipoEquipamentos);
            $this->smarty->assign('listaMunicipios',$this->listaMunicipios->toArray());
            $this->smarty->assign('listaInstalacoes',$this->listaInstalacoes->toArray());
            $this->smarty->assign('listaLocaisEquipamentos',$this->listaLocaisEquipamentos->toArray());
            $this->smarty->assign('obj',$this->equipamento);
            $this->smarty->display("{$this->tplDir}/edit.tpl");
        }
        elseif ( ! empty($this->dadosP['form']) )
        {

        	$this->trataDadosParaEdicao();
        	
        	$equipamento = new EquipamentosModel( $this->adapter->getAdapterZend() );

        	$retorno = $equipamento->update( $this->dadosP['form'] , "idequipamentos = '{$this->id}'" );


        	//TODO: dependendo de medidas adequadas
        	//$this->atualizaDependencias();
        	
        	$arrReturn = array('status' => 'ok','msg' => 'Edição realizada com sucesso!');
            
            die_json($arrReturn);
        }
    }
    
    public function apaga()
    {
    	$this->id = $_POST['idequipamentos'];
    	
    	$equipamentos = new EquipamentosModel( $this->adapter->getAdapterZend() );
    	
    	$equipamentos->delete("idequipamentos = {$this->id}");
    	
    	return "ok";
    }
    
    public function findByNS(){
        
        $this->DB->setSno($this->dadosP['sno']);
        $total['result'] = $this->DB->findByNS();
        
        die_json($total);
    }
    
    public function liste()
    {
    	$this->smarty->display("{$this->tplDir}/list.tpl");
//        echo die_json('teste');
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


		// Get total count of records
			$sql = "select count(*) as total
					from listequipamentos
					{$searchSql}";

			$result = $this->DB->queryDados($sql);
//		echo $result;exit;
			$total = $result[0]['total'];

		// Setup paging SQL
			$pageStart = ($page-1)*$rp;
			$limitSql = "limit $pageStart, $rp";
		
		// Return JSON data
			$data = array();
			$data['page'] = $page;
			$data['total'] = $total;
			$data['rows'] = array();
		
		$sql = "SELECT *
				FROM listequipamentos
				{$searchSql}
				{$sortSql}
				{$limitSql}";



		$results = $this->DB->queryDados($sql);
		
		foreach( $results AS $row ) 
		{
			$data['rows'][] = array(
				'id' => $row['idequipamentos'],
				'cell' => array(
								utf8_decode(utf8_encode($row['nome_tipo_equipamentos'])),
								$row['sno'],
								$row['mac'],
								$row['status'], 
								$row['local'],
								$row['vsat'],
								$row['observacoes']
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
			
		// Get total count of records
			$sql = "select count(*) as total
					from listequipamentos
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
				from listequipamentos
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		$results = $this->DB->queryDados($sql);
		
		foreach( $results AS $row ) 
		{
			$data['rows'][] = array(
				'id' => $row['idequipamentos'],
				'cell' => array(
								utf8_decode(utf8_encode($row['nome_tipo_equipamentos'])),
								$row['sno'],
								$row['mac'],
								utf8_decode(utf8_encode($row['status'])), 
								utf8_decode(utf8_encode($row['local'])),
								utf8_decode(utf8_encode($row['vsat'])),
								utf8_decode(utf8_encode($row['observacoes']))
								)
			);
		}
		//print_b($data,true);
		
		echo json_encode($data);
	}
	
	public function antenas()
	{
		$totalAntenas = $this->resgataTotalAntenas(); // Total
		
		$totalPatriot = $this->resgataTotalAntenas( 4 ); // Patriot
		
		$totalSkyware = $this->resgataTotalAntenas( 5 ); // Skyware
		
		$totalAntenasOcupadas = $this->resgateAntenasOcupadas(); // Ocupadas
		
		$totalAntenasDisponiveis = $totalAntenas - $totalAntenasOcupadas; // Disponíveis
		
		$this->smarty->assign('totalAntenas',$totalAntenas);
		$this->smarty->assign('totalPatriot',$totalPatriot);
		$this->smarty->assign('totalSkyware',$totalSkyware);
		$this->smarty->assign('totalAntenasOcupadas',$totalAntenasOcupadas);
		$this->smarty->assign('totalAntenasdisponiveis',$totalAntenasdisponiveis);
		$this->smarty->display("{$this->tplDir}/listAntenas.tpl");
	}
    
    public function mostraObservacoesNaLista()
    {
    	$idequipamentos = $_REQUEST['idequipamentos'];
    	
    	$this->DB->setSelect(' observacoes ');
    	$dados = $this->DB->liste(" idequipamentos = '{$idequipamentos}' ");
    	//print_b($dados,true);
    	$resposta = "<p>Observações: {$dados[0]['observacoes']}</p>";
    	echo $resposta;
    }
    
    //TODO: vai para model
    public function atualizaUsoEquipamentos($novoODU,$status)
    {
    	$sql = "
    		UPDATE equipamentos e 
    		SET e.status = {$status} 
    		WHERE e.sno = '{$novoODU}'
    	";
    	return $this->DB->query($sql);
    }
    
    //TODO: vai para model
    public function verificaStatusEquipamentoInvocado($nsoduNovo)
    {
    	$sql = "SELECT e.status FROM equipamentos e WHERE e.sno = '{$nsoduNovo}' ";
    	$statusAtualEquipamento = $this->DB->queryDados($sql);
    	return $statusAtualEquipamento[0]['status'];
    }
    
    //TODO: vai para model
    public function liberaEquipamento($equipamento)
    {
    	$sql = "
    		UPDATE equipamentos e 
    		SET 
    			e.status = 1
    		WHERE e.sno = '{$equipamento}' 
    	";
    	return $this->DB->query($sql);
    }
    
    //TODO: metodo vai para model
    public function buscaNSVsatPorMac()
    {
    	$mac = $_POST['mac'];
    	
    	$sql = "
    		SELECT sno 
    		FROM equipamentos 
    		WHERE mac = '{$mac}' 
    	";
    	$dados = $this->DB->queryDados($sql);
    	echo (isset($dados[0]))?$dados[0]['sno']:'';
    }
    
    
    
    // ----------------------------------------------------------------------
    // -------------------------- FORMULÁRIOS -------------------------------
    // ----------------------------------------------------------------------
    
    public function carregaListasFormulario()
    {
    	$tipoEquipamentos = new TipoEquipamentosModel( $this->adapter->getAdapterZend() );
    	$this->listaTipoEquipamentos = $tipoEquipamentos->fetchAll();

    	//locais ---
    	
    	$municipios = new MunicipiosModel( $this->adapter->getAdapterZend() );
    	$this->listaMunicipios = $municipios->fetchAll('1','municipio ASC');

    	$instalacoes = new InstalacoesModel( $this->adapter->getAdapterZend() );
    	//TODO: metodo vai para model
    	$where = "
            	(
            		SELECT COUNT(*) 
            		FROM equipamentos_locais 
            		WHERE 
            			idlocais_equipamentos = instalacoes.idinstalacoes AND
            			tabela_localidade = 'locais_equipametos' 
            	) = 0
            ";//apenas desocupadas
    	$this->listaInstalacoes = $instalacoes->fetchAll($where,'nome ASC');

    	$locaisEquipamentos = new LocaisEquipamentosModel( $this->adapter->getAdapterZend() );
    	$this->listaLocaisEquipamentos = $locaisEquipamentos->fetchAll();
    }
    
    public function carregaEquipamento()
    {
    	$equipamento = new EquipamentosModel( $this->adapter->getAdapterZend() );
    	$linha = $equipamento->fetchRow("idequipamentos = '{$this->id}'");
    	$this->equipamento = $linha->toArray();
    }
    
    public function carregaDependencias()
    {
    	//local --
    	
    	$equipamentoDependencias = new EquipamentosLocaisModel( $this->adapter->getAdapterZend() );
	   	$associacoes = $equipamentoDependencias->fetchRow("idequipamentos = '{$this->id}'");
	   	if( $associacoes )
	   	{

	   		switch($associacoes->tabela_localidade)
	   		{
	   			case 'municipios':
	   				$sql = "SELECT o.municipios_idcidade
	   				FROM os o, instalacoes i
	   				WHERE o.idos = i.os_idos and i.idinstalacoes = $associacoes->idlocais_equipamentos";
	   				
	   				$dadosTable = $this->DB->queryDados($sql);
	   				$idLocal = $dadosTable[0]['municipios_idcidade'];
	   				
	   				$municipio = new MunicipiosModel( $this->adapter->getAdapterZend() );
	   				$local = $municipio->fetchRow("idmunicipios = '{$idLocal}'");
	   				break;
	   			case 'instalacoes':
	   				$instalacoes = new InstalacoesModel( $this->adapter->getAdapterZend() );
	   				$local = $instalacoes->fetchRow("idinstalacoes = '{$associacoes->idlocais_equipamentos}'");
	   				break;
	   			case 'locais_equipamentos':
	   				$locais_equipamentos = new LocaisEquipamentosModel( $this->adapter->getAdapterZend() );
	   				$local = $locais_equipamentos->fetchRow("idlocais_equipamentos = '{$associacoes->idlocais_equipamentos}'");
	   				break;
	   		}
	   		$this->equipamento['local'] = $local->toArray();

	   	}
	   	else
	   		$this->equipamento['local'] = '';
	   	
	   	
	   	//tipo_equipamento --
	   	
	   	$tipo_equipamento = new TipoEquipamentosModel( $this->adapter->getAdapterZend() );
	   	$tipo_equipamento_linha = $tipo_equipamento->fetchRow("idtipo_equipamentos = '{$this->equipamento['tipo_equipamentos_idtipo_equipamentos']}'");
	   	$linha = $tipo_equipamento_linha->toArray();
	   	if( isset($linha['nome']) )
	   		$this->equipamento['nome_tipo_equipamento'] = $linha['nome'];
	   	
	   	else
	   		$this->equipamento['nome_tipo_equipamento'] = '';
    }
    
    
    
    // -----------------------------------------------------------------------------
    // -------------------- TRATA LOCALIDADE ---------------------------------------
    // -----------------------------------------------------------------------------
    
    public function trataLocal()
    {


    	$this->local = $this->dadosP['form']['local'];
    	$this->status = $this->dadosP['form']['status'];

        unset($this->dadosP['form']['local']);
        $this->gravaLocal();
    }
    
    public function gravaLocal()
    {

    	$separador = explode('.',$this->local);
    	$localTabela = $separador[0];
    	$localId = $separador[1];
    	
    	if ($localTabela == 'instalacoes'){
	    	$sql = "SELECT idinstalacoes FROM instalacoes
	    			WHERE idinstalacoes = $localId
	    			";
	    	
	    	$dadosTable = $this->DB->queryDados($sql);
	    	$localId = $dadosTable[0]['idinstalacoes'];
    	}else if ($localTabela == 'municipios' ){
	    	$sql = "SELECT i.idinstalacoes, i.nome
	    			FROM instalacoes i, os o
	    			WHERE o.idos = i.os_idos and o.municipios_idcidade = $localId
	    			";
	    	
	    	$dadosTable = $this->DB->queryDados($sql);
	    	$localId = $dadosTable[0]['idinstalacoes'];
    	}

    	$dados = array(
    		'idequipamentos' => $this->id,
    		'idlocais_equipamentos' => $localId,
    		'tabela_localidade' => $localTabela
    	);
    	
   	
    	$equipamentosLocais = new EquipamentosLocaisModel( $this->adapter->getAdapterZend() );

    	if (!$this->verificaStatus()){ //
	    	if ($localId > 0){
				if (!$equipamentosLocais->update( $dados, "idequipamentos = '{$this->id}'" )){
					$sql = "SELECT idequipamentos FROM equipamentos_locais
							WHERE idequipamentos = '{$this->id}'";
			
					if (!$this->DB->queryDados($sql)){
						$equipamentosLocais->insert( $dados);
			    	}
				}
	    	}else {
	    		$arrReturn['msg']    = 'VSAT Inexistente com esse municipio ou Campo Vazio!';
	    		die_json($arrReturn);    		
	    	}
    	}
    }
    
    
    public function verificaStatus(){
    	$equipamentosLocais = new EquipamentosLocaisModel( $this->adapter->getAdapterZend() );
    			//Disponivel		Com defeito				Cliente || $this->status == 3 || $this->status == 4
    	if ($this->status == 1 || $this->status == 3){
    		$equipamentosLocais->delete("idequipamentos = '{$this->id}'");
	    	return true;    	
    	}
    }
    
    public function gravaLocalCreateMulti( $idEquipamento )
    {
    	//TODO: vai para model
    	$sql = "
    		INSERT INTO equipamentos_locais ( idequipamentos , idlocais_equipamentos , tabela_localidade )
    		VALUES ( '{$idEquipamento}' , '{$this->local}' , '{$this->tipoLocal}' );
    	";
    	if( !$this->DB->query($sql) )
    	{
	    	$this->DB->rollback();
    		$erro = "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  <strong>Erro!</strong> Erro no associar equipamento {$this->snoEquipamento} ao local {$this->nomeLocal}!
				</div>
    		";
    		echo $erro;
    		exit;
    	}
    }
    
    
    
    // -----------------------------------------------------------------------------
    // -------------------- TRATA DADOS PARA EDICAO --------------------------------
    // -----------------------------------------------------------------------------
    
    public function trataDadosParaEdicao()
    {
    	$this->id = $this->dadosP['form']['idequipamentos'];
    	unset($this->dadosP['form']['idequipamentos']);
    	
    	$this->trataLocal();
    }
    
    
    
    // -----------------------------------------------------------------------------
    // -------------------- ATUALIZA DEPENDENCIAS ----------------------------------
    // -----------------------------------------------------------------------------
    
    public function atualizaDependencias()
    {
    	$equipamentosLocais = new EquipamentosLocaisModel( $this->adapter->getAdapterZend() );
    	
    	$local = explode('.',$this->local);
    	
    	$equipamentoLocal = $equipamentosLocais->fetchRow("idequipamentos = '{$this->id}'");
    	
    	$dados = array(
		    "idequipamentos" => $equipamentoLocal->idequipamentos,
		    "idlocais_equipamentos" => $local[1],
		    "data_movimentacao" => $equipamentoLocal->data_movimentacao,
		    "tabela_localidade" => $local[0]
    	);
    	
    	$equipamentosLocais->update($dados, "idequipamentos_locais = '{$equipamentoLocal->idequipamentos_locais}'");
    }
    
    
    
    // ----------------------------------------------------------------------------
    // -------------------------- ENVIO DE PLANILHA -------------------------------
    // ----------------------------------------------------------------------------
    
    public function validaFormatoPlanilha()
    {
    	$arquivoPartes = explode('.',$this->form['name']);
    	
    	if( !in_array($arquivoPartes[1], $this->formatosPermitidosPlanilha) )
    		exit("Formato de arquivo não permitido.");
    		
    	$this->formatoPlanilha = $arquivoPartes[1];
    }
    
    public function filtroParaFormato()
    {
    	switch( $this->formatoPlanilha )
    	{
    		case 'csv':
    			$this->procedimentoCSV();
    			break;
    			
    		case 'xls':
    			$this->procedimentoXLS();
    			break;
    			
    		case 'xlsx':
    			$this->procedimentoXLSX();
    			break;
    	}
    }
    
    public function procedimentoCSV() // ------------------ CSV
    {
    	$this->planilhaAberta = fopen ($this->planilha,"r");
		
		$this->GuardaDadosDeCadaLinhaEmArrayCSV();
    }
    
    public function procedimentoXLS() // ------------------ XLS
    {
    	$objPHPExcel = PHPExcel_IOFactory::load( $this->planilha );
    	
    	$this->dadosPlanilha = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
    	
    	$this->validaCamposPlanihaXLS();
    }
    
    public function procedimentoXLSX() // ------------------ XLSX 
    {
    	//TODO: finalizar o metodo para xlsx
    	// alternativa: http://phpexcel.codeplex.com/
    	
    	//$this->planilhaAberta = fopen ($this->planilha,"r");
    	
    	exit( 'Em construção.' );
    }
    
    //para multiCreate
    //TODO: isso vai pra model
    public function gravaBD()
    {
    	$this->DB->autocommit( false );
    	
    	unset($this->dadosPlanilha[0]);
    	
    	//echo count($this->dadosPlanilha).'<br/>';
    	//print_b($this->dadosPlanilha,true);
    	$contador = 0;
    	
    	foreach( $this->dadosPlanilha AS $dado )
    	{
    		$this->snoEquipamento = $dado[1];
    		$this->macEquipamento = $dado[2];
    		$this->nomeLocal = $dado[3];
    		$this->resolveTipoEquipamento( $dado[0] );
    		
    		if( $this->validaPreExistenciaEquipamento() )
    			$this->validaDadosEquipamento();
    		
	    	//grava equipamento
	    	$sql = "
			   	INSERT INTO equipamentos
			   	( sno , mac , tipo_equipamentos_idtipo_equipamentos , observacoes )
			   	VALUES
			   	( '{$dado[1]}' , '{$dado[2]}' , '{$this->tipoEquipamento}' , '{$dado[6]}' );
			";
	    	
	    	if( !$this->DB->query($sql) )
	    	{
	    		$this->DB->rollback();
	    		switch ($this->tipoEquipamento)
	    		{
	    			case 1:
	    			case 2:
	    			case 3:
			   			$erro = "
			   				<div class='alert alert-error'>
							  <button class='close' data-dismiss='alert'>×</button>
							  <strong>Erro!</strong> Erro no cadastro do equipamento de sno {$dado[1]}!
							</div>
			   			";
			   			break;
	    			default:
	    				$erro = "
			   				<div class='alert alert-error'>
							  <button class='close' data-dismiss='alert'>×</button>
							  <strong>Erro!</strong> Erro no cadastro do equipamento {$dado[0]}!
							</div>
			   			";
	    				break;
	    		}
	    		echo $erro;
	    		exit;
	    	}
	    	
	    	$idInserido = $this->DB->getLastId();
    		
	    	//grava local
	    	$this->resolveTipoLocal( $dado[4] );
	    	$this->resolveLocal();
	    	$this->gravaLocalCreateMulti( $idInserido );
	    	
	    	$contador++;
    	}    	
    	$erro = "
   			<div class='alert alert-success'>
			  <button class='close' data-dismiss='alert'>×</button>
			  <strong>Sucesso!</strong> Sucesso no cadastro de {$contador} equipamentos!
			</div>
   		";
    	echo $erro;
    } 
    
    // -----------------------------------
    // ------------ CSV ------------------
    // -----------------------------------
    
    public function GuardaDadosDeCadaLinhaEmArrayCSV()
    {
    	$this->validaCamposPlanihaCSV();
    	
    	while( ($this->linhaPlanilha = fgetcsv($this->planilhaAberta, 10000, ";")) !== false )
			array_push($this->dadosPlanilha, $this->linhaPlanilha);
    }
    
    /*
     * validação:
     * [0] tipo
     * [1] sno
     * [2] mac
     * [3] local
     * [4] tipo_local ( municipio OU vsat OU local_equipamento )
     * [5] vsat
     * [6] obs
     */
    public function validaCamposPlanihaCSV()
    {
    	$this->linhaPlanilha = fgetcsv($this->planilhaAberta, 10000, ";");
    	
    	if( $this->linhaPlanilha[0] != 'tipo' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 1 (tipo).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[1] != 'sno' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 2 (sno).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[2] != 'mac' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 3 (mac).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[3] != 'local' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 4 (local).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[4] != 'tipo_local' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 5 (tipo_local).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[6] != 'obs' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 7 (obs).
				</div>
    		";
    		exit;
    	}
    		
    	array_push($this->dadosPlanilha, $this->linhaPlanilha);
    }
    
    // -----------------------------------
    // ------------ XLS ------------------
    // -----------------------------------
    
    public function validaCamposPlanihaXLS()
    {
    	if( $this->linhaPlanilha[0][0] != 'tipo' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 1 (tipo).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[0][1] != 'sno' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 2 (sno).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[0][2] != 'mac' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 3 (mac).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[0][3] != 'local' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 4 (local).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[0][4] != 'tipo_local' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 5 (tipo_local).
				</div>
    		";
    		exit;
    	}
    	if( $this->linhaPlanilha[0][6] != 'obs' )
    	{
    		echo "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  Erro no formato da coluna 7 (obs).
				</div>
    		";
    		exit;
    	}
    		
    	array_push($this->dadosPlanilha, $this->linhaPlanilha);
    }
    
    
    // EXTRA --
    
    public function resolveTipoLocal($dado)
    {
    	switch( $dado )
    	{
    		case 'municipio':
	    		$this->tipoLocal = 'municipios';
	    		break;
	    	case 'vsat':
	    		$this->tipoLocal = 'instalacoes';
	    		break;
	    	case 'local_equipamento':
	    		$this->tipoLocal = 'locais_equipamentos';
	    		break;
    	} 
    }
    
    public function resolveTipoEquipamento( $tipoEquipamento )
    {
    	switch( $tipoEquipamento )
    	{
    		case "SL 2000":
    			$this->tipoEquipamento = 1;
    			break;
    		case "SL 4033":
    			$this->tipoEquipamento = 2;
    			break;
    		case "SL 4035":
    			$this->tipoEquipamento = 3;
    			break;
    		case "Antena Patriot":
    			$this->tipoEquipamento = 4;
    			break;
    		case "Antena Skyware":
    			$this->tipoEquipamento = 5;
    			break;
    	}
    	
    	if( $this->tipoEquipamento == '' )
    	{
    		$this->DB->rollback();
    		$erro = "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  <strong>Erro!</strong> Tipo do Equipamento de sno {$this->snoEquipamento} não encontrado! Procedimento interrompido.
				</div>
    		";
    		echo $erro;
    		exit;
    	}
    }
    
    public function resolveLocal()
    {
    	//TODO: procedimentos para model
    	switch( $this->tipoLocal )
    	{
    		case 'municipios':
		    	$sql = " 
		    		SELECT idmunicipios AS id 
		    		FROM municipios 
		    		WHERE municipio LIKE '%{$this->nomeLocal}%'; 
		    	";
		    	break;
    		case 'instalacoes':
    			$sql = " 
    				SELECT idinstalacoes AS id
    				FROM instalacoes 
    				WHERE nome LIKE '%{$this->nomeLocal}%';
    			";
    			break;
    		case 'locais_equipamentos':
    			$sql = " 
    				SELECT idlocais_equipamentos AS id 
    				FROM locais_equipamentos 
    				WHERE nome LIKE '%{$this->nomeLocal}%'; 
    			";
    			break;
    	}
    	
    	$localTrazido = $this->DB->queryDados($sql);
    	if( count($localTrazido) > 0 )
    		$this->local = $localTrazido[0]['id'];
		else
		{
			$this->DB->rollback();
    		$erro = "
    			<div class='alert alert-error'>
				  <button class='close' data-dismiss='alert'>×</button>
				  <strong>Erro!</strong> Local {$this->nomeLocal} não encontrado! Procedimento interrompido.
				</div>
    		";
    		echo $erro;
    		exit;
		}
    }
    
    public function validaDadosEquipamento()
    {
    	switch ( $this->tipoEquipamento )
    	{
    		case 1: // sl 2000
    			if( $this->snoEquipamento == '' )
    			{
    				$this->DB->rollback();
		    		$erro = "
		    			<div class='alert alert-error'>
						  <button class='close' data-dismiss='alert'>×</button>
						  <strong>Erro!</strong> Equipamento sl 2000 sem SNO! Procedimento interrompido.
						</div>
		    		";
		    		echo $erro;
		    		exit;
    			}
    			if( $this->macEquipamento == '' )
    			{
    				$this->DB->rollback();
		    		$erro = "
		    			<div class='alert alert-error'>
						  <button class='close' data-dismiss='alert'>×</button>
						  <strong>Erro!</strong> Equipamento sl 2000 sem MAC! Procedimento interrompido.
						</div>
		    		";
		    		echo $erro;
		    		exit;
    			}
    			break;
    			
    		case 2: // sl 4033
    			if( $this->snoEquipamento == '' )
    			{
    				$this->DB->rollback();
		    		$erro = "
		    			<div class='alert alert-error'>
						  <button class='close' data-dismiss='alert'>×</button>
						  <strong>Erro!</strong> Equipamento sl 4033 sem SNO! Procedimento interrompido.
						</div>
		    		";
		    		echo $erro;
		    		exit;
    			}
    			break;
    			
    		case 3: // sl 4035
    			if( $this->snoEquipamento == '' )
    			{
    				$this->DB->rollback();
		    		$erro = "
		    			<div class='alert alert-error'>
						  <button class='close' data-dismiss='alert'>×</button>
						  <strong>Erro!</strong> Equipamento sl 4035 sem SNO! Procedimento interrompido.
						</div>
		    		";
		    		echo $erro;
		    		exit;
    			}
    			break;
    	}
    }
    
    public function validaPreExistenciaEquipamento()
    {
    	switch ( $this->tipoEquipamento )
    	{
    		case 1: // sl 2000
    		case 2: // sl 4033
    		case 3: // sl 4035
    			//TODO: procedimento para model
    			$sql = "
    				SELECT COUNT(*) as total
    				FROM equipamentos
    				WHERE sno = '{$this->snoEquipamento}';
    			";
    			$contagem = $this->DB->queryDados($sql);
    			if( $contagem[0]['total'] > 0 )
    				return false;
    			else
    				return true;
    			break;
    		default:
    			return false;
    			break;
    	}
    }
    
    
    
    // ---------------------------------------------------------------------------
    // ----------- GESTÃO DE ANTENAS ---------------------------------------------
    // ---------------------------------------------------------------------------
    
    public function resgataTotalAntenas( $tipo_equipamento_antenas = '' )
    {
    	$where = ( $tipo_equipamento_antenas == '' )?NULL:" tipo_equipamentos_antenas = '{$tipo_equipamento_antenas}' ";
    	
    	$equipamentos_antenas = new EquipamentosAntenasModel( $this->adapter->getAdapterZend() );
    	
    	$resultado = $equipamentos_antenas->fetchAll( $where );
    	
    	return count( $resultado->toArray() );
    }
    
    public function resgateAntenasDisponíveis()
    {
    	
    	
    	
    }
    
    public function resgateAntenasOcupadas( $tipo_equipamento_antenas = '' )
    {
    	$where = ( $tipo_equipamento_antenas == '' )?NULL:" idequipamentos_antenas_tipo = '{$tipo_equipamento_antenas}' ";
    	
    	$equipamentos_antenas_locais = new EquipamentosAntenasLocaisModel( $this->adapter->getAdapterZend() );
    	
    	$resultado = $equipamentos_antenas_locais->fetchAll( $where );
    	
    	return count( $resultado->toArray() );
    } 
    
}

?>
<?php

/**
 * Description of OS
 *
 * @author Daniel - | 16/12/2011
 * @author Sávio 16/12/2011 | -
 */

//zend
include_once "model/SaomModel.php";

include_once 'model/DBAtendVsat.php';
include_once 'controller/Cronometro.php';

include_once 'model/DBUsuario.php';
include_once 'model/DBInstalacao.php';
include_once 'model/DBIncidente.php';
include_once 'model/DBCronometro.php';
include_once 'model/DBTipo_atendimento.php';
include_once 'helpers.class.php';

include_once "controller/Log.php";

class AtendVsat extends Controller
{
    protected $tplDir = 'atendvsat';
    
    protected $atendimentoId;
    protected $incidenteId;
    protected $cronometroAtendimento;
    
    
    function __construct() 
    {
    	parent::__construct();
    	$this->DB = new DBAtendVsat();
    	$this->DBIncidente = new DBIncidente();
    	$this->DBCronometro = new DBCronometro();
    	$this->CronometroController = new Cronometro();
    	$this->DBTipo_atendimento = new DBTipo_atendimento();
    	$this->DBUsuario = new DBUsuario();
    	
    	$this->Helpers = new Helpers();
    	$this->Log = new Log();
    }  
    
    // TODO: poutz!
    //SETS
    	public function setAtendimentoId($atendimentoIdNovo)
    	{
    		$this->atendimentoId = $atendimentoIdNovo;
    	}
    	public function setIncidenteId($incidenteIdNovo)
    	{
    		$this->incidenteId = $incidenteIdNovo;
    	}
    //SETS - fim
    
    //GETS
    	public function getAtendimentoId()
    	{
    		return $this->atendimentoId;
    	}
    	public function getIncidenteId()
    	{
    		return $this->incidenteId;
    	}
    //GETS - fim
    
    	
	public function create()
    {
		if ( !empty($this->dadosP['param']) )
       	{
       		//busca incidente
           		$idincidente = new Integer( $this->dadosP['param'] );
           		$this->Incidentes->setidincidentes( $idincidente );

//            var_dump($this->Incidentes_sp->getinstalacoes_idinstalacoes());
           	//busca tipo_atendimento
           		$lista_tipo_atendimento = $this->TipoAtendimento->getListaTipoAtendimento();
       		     
            $this->smarty->assign('param',$this->dadosP['param']);
            $this->smarty->assign('tipo_atendimento',$lista_tipo_atendimento);
            $this->smarty->assign('instalacoes_idinstalacoes',$this->Incidentes->getinstalacoes_idinstalacoes());
            $this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
            $this->smarty->display("{$this->tplDir}/create.tpl");
       	}
    }
    
    public function insert()
    {
    	if( $this->dadosP['form'] ){
       		//print_b($this->dadosP['form'],true);
       		
       		//busca saom
       		$this->Saom->getsaomPeloNome( $_SESSION['SAOM'] );
       		$this->dadosP['form']['saom'] = $this->Saom->getid_saom();
       		
       		//TRATAMENTO PARA ASSINATURA DE MODIFICAÇÃO ATUAL DO ATENDIMENTO
	        	$status_atendimento = new Integer( $this->dadosP['form']['status_atend_idstatus_atend'] );
       			$novoStatus = $this->StatusAtendimento->getStatusAtendimento( $status_atendimento );
       			
	        	$atendimentoNovo = ( $this->dadosP['form']['atendimento'] != '' )? $this->dadosP['form']['atendimento'] : '(vazio)' ;
	        	$atendimento_anterior = ( isset($this->dadosP['form']['atendimento_anterior']) )? $this->dadosP['form']['atendimento_anterior'] : '' ;
	        	$agora = date('d/m/Y H:i:s');
	        	$this->dadosP['form']['atendimento'] = "{$atendimento_anterior}
	        	
	        	{$atendimentoNovo}
	        	
	        	<b>{$_SESSION['login']['nome']}, {$agora}</b> - ".$novoStatus;
	        //TRATAMENTO PARA ASSINATURA DE MODIFICAÇÃO ATUAL DO ATENDIMENTO - fim

	        $this->Atendimento->montaObjetoDoForm( $this->dadosP['form'] );
	        $return = $this->Atendimento->create();
            
            if( !$return )
                exit("<div class='alert alert-error'>Houve um erro ao inserir atendimento.</div>");
                
            else 
            {
            	//registra log
	            	$registroDeLog = $this->Log->registraLog(
											'atend_vsat', 
											$return, 
											1, 
											'Criação de atendimento.'
											);
					if(!$registroDeLog)
						exit("<div class='alert alert-error'>Erro no registro do log.</div>");
            	
            	//zera a data final de incidente
            		if(!$this->DBCronometro->zeraDataFinalIncidente($this->dadosP['form']['incidentes_idincidentes'],'incidentes'))
            			exit("<div class='alert alert-error'>Erro: incidente não zerado.</div>");
            			
            	//cria cronometro atendimento
            		$sql = "INSERT INTO cronometro (idreferencia, inicio_tarefa, tabelareferencia) 
            				VALUES ('{$return}', '".date('Y-m-d H:i:s')."','atend_vsat')";
            		if(!$this->DBPadrao->query($sql))
            			exit("<div class='alert alert-error'>Erro: cronometro para atendimento não gerado.</div>");
            		
            	exit("<div class='alert alert-success'>Cadastro efetuado com sucesso!</div>");
            }
       	}
    }
    
	
    public function edit() 
    {
    	if( !empty($this->dadosP['param'] ) ) 
        {
        	$autorizacao = 1;
        	
        	$this->Atendimento->setidatend_vsat( $this->dadosP['param'] );
        	$this->Atendimento->getAtendimentoObject();
        	//print_b($this->Atendimento,true);
            
        	//BUSCA tipo_atendimento
        		$lista_tipo_atendimento = $this->TipoAtendimento->getListaTipoAtendimento();
       			
       		//BUSCA ATENDENTES POSSIVEIS (campo)
       			$this->Usuarios->getListaUsuariosIncidente();
       			$lista_atendentes = $this->Usuarios->getListaUsuarios();
       			//print_b($lista_atendentes,true);
       			for($i=0;$i<count($lista_atendentes);$i++)
       			{
       				$lista_atendentes[$i]['nome'] = $this->Helpers->limitaTexto(trim($lista_atendentes[$i]['nome']),24);
       			}
       			
       		//VERIFICA PERMISSAO DO USUARIO ATUAL
       			$autorizacao = $this->verificaPermissaoUsuarioAtual( $this->Atendimento );
//			echo die_json($_SESSION['login']['perfis_idperfis']);

       		//BUSCA LISTA DE MOTIVOS
       			$this->MotivoAtendimento->resgataListaMotivos();
       			$this->smarty->assign('motivos', $this->MotivoAtendimento->getlistaMotivos() );
       		//BUSCA LISTA DE RESPONSAVEL
				$this->ResponsavelAtendimento->resgataListaResponsavelAtendimento();
				$this->smarty->assign('responsaveis', $this->ResponsavelAtendimento->getlistaResponsavelAtendimento());
       		
       		
       		$this->buscaAssociacoesMotivosDeAtendimento( $this->dadosP['param'] );
       		
       		$this->smarty->assign('autorizacao',$autorizacao);
       		$this->smarty->assign('lista_atendentes',$lista_atendentes);
       		$this->smarty->assign('idperfil', $_SESSION['login']['perfis_idperfis']);
       		$this->smarty->assign('tipo_atendimento',$lista_tipo_atendimento);
            $this->smarty->assign('obj',$this->Atendimento->getatendimentoArray());
            $this->smarty->display("{$this->tplDir}/edit.tpl");
        }
    }
    
    private function buscaAssociacoesMotivosDeAtendimento( $idatendimento )
    {
    	$this->AssociacaoAtendimentoMotivo->buscaMotivosDeAtendimentoOrganizadoPeloTipoDoMotivo( $idatendimento );
       	$this->smarty->assign('motivosJaPresentes', $this->AssociacaoAtendimentoMotivo->getmotivosDeAtendimento() );
    }
    
	private function verificaPermissaoUsuarioAtual( AtendVsatBO $atendimento )
    {
    	// BUSCA USUARIO DE ATENDIMENTO
    		$atendimentoBuscado = $atendimento->getusuarios_idusuarios();
//		echo die_json($atendimentoBuscado);
    	
    	if( 
    		( $atendimentoBuscado != $_SESSION['login']['idusuarios'] ) &&
    		( $_SESSION['login']['perfis_idperfis'] != 4 && $_SESSION['login']['perfis_idperfis'] != 5 )
    	  )
    		return false;
    	else
    		return true;
    }
    
    public function update()
    {

    	if ( ! empty($this->dadosP['form']) )
        {
        	
        	
        	//verifica resposta agilis
        	if( $this->dadosP['form']['resposta_agilis']=='' && $this->dadosP['form']['status_atend_idstatus_atend']==3 )
        		exit('<div class="alert alert-error">Resposta Agilis deve estar preenchido para finalizar Atendimento.</div>');
        		
        	//atendimento
        	$this->Atendimento->setidatend_vsat( $this->dadosP['form']['idatend_vsat'] );
        	$this->Atendimento->getAtendimentoObject();
        	
        	//incidente
        	$idincidentes = new Integer( $this->Atendimento->getincidentes_idincidentes() );
        	$this->Incidentes->setidincidentes( $idincidentes );
        	$this->Incidentes->getIncidente();

			$this->Incidentes->settecnicoNoc($_SESSION['login']['idusuarios']);
			$this->Incidentes->edit();
        	
        	//atualiza cronometro
        	//TODO: bagunça
//         	$dataNova = null;
        		
		    if( $this->dadosP['form']['status_atend_idstatus_atend'] == 3 ){//finalizado
		    	$dataNova = date('Y-m-d H:i:s');

			    $sql = "
			    	UPDATE cronometro SET final_tarefa = '{$dataNova}'
			    	WHERE 
			    		idreferencia = '{$this->dadosP['form']['idatend_vsat']}' AND 
			    		tabelareferencia = 'atend_vsat'
			    ";
			    if( !$this->DBPadrao->query($sql) )
			    	exit('<div class="alert alert-error">Erro ao modificar data final de atendimento.</div>');
		    }
	        
	        //TRATAMENTO PARA ASSINATURA DE MODIFICAÇÃO ATUAL DO ATENDIMENTO
	        //TODO: bagunça
        	$idStatusAtendimento = new Integer( $this->dadosP['form']['status_atend_idstatus_atend'] );
        	$status = $this->StatusAtendimento->getStatusAtendimento( $idStatusAtendimento );
        	
        	$atendimentoNovo = ( $this->dadosP['form']['atendimento'] != '' )?$this->dadosP['form']['atendimento']:'(vazio)';
        	
        	$atendimento = $this->dadosP['form']['atendimento_anterior'].'	'.$atendimentoNovo.'
        		<b>'.$_SESSION['login']['nome'].', '.date('d/m/Y H:i:s').'</b> - '.$status;
        	$this->Atendimento->setatendimento( $atendimento );

	        //atualiza dados restantes
	        $this->Atendimento->setstatus_atend_idstatus_atend( $this->dadosP['form']['status_atend_idstatus_atend'] );
			$this->Atendimento->setusuarios_idusuarios($_SESSION['login']['idusuarios']);
	        $this->Atendimento->settipo_atendimento_idtipo_atendimento( $this->dadosP['form']['tipo_atendimento_idtipo_atendimento'] );
	        $this->Atendimento->setresposta_agilis( $this->dadosP['form']['resposta_agilis'] );
	        
		    $return = $this->Atendimento->edit();
	        
	        if( $return == 'erro' ) 
                exit('<div class="alert alert-error">Houve um erro ao editar atendimento.</div>');
            
            else 
            {
	            //registra log
            	$registroDeLog = $this->Log->registraLog(
														'atend_vsat', 
														$this->dadosP['form']['idatend_vsat'], 
														2, 
														'Edicao de atendimento'
														);
				if(!$registroDeLog)
					exit('Erro no registro do log.');

	            if( $this->dadosP['form']['novoResponsavel'] != '' )
		        {
		        	$novoResponsavel = new Integer( $this->dadosP['form']['novoResponsavel'] );
	        		$teste = $this->repassaAtendimento( $novoResponsavel );

	        		if ($teste) {
	        			exit('<div class="alert alert-success">Esta OK!</div>');
	        		}
		        }
        		
	        	exit('<div class="alert alert-success">Edição realizada com sucesso!</div>');
            }
        }
    }
    
	private function repassaAtendimento( Integer $novoResponsavel )
    {
    	$atendimento_pai = $this->Atendimento->getatendimento_pai();
    	if( !empty($atendimento_pai) )
    		$this->criaAtendimentoRepassado( $novoResponsavel );
    	else

    		$this->atualizaResponsavelPorAtendimento( $novoResponsavel );
    		
    	$this->Usuarios->setidusuarios( $novoResponsavel );
    	$this->Usuarios->getUsuario();
    	
    	$idincidentes = new Integer( $this->Atendimento->getincidentes_idincidentes() );
    	$this->Incidentes->setidincidentes( $idincidentes );
    	$this->Incidentes->getIncidente();
    	
	    //ENVIA EMAIL PARA USUARIO CONVOCADO
	/*	
 	    $this->enviaEmailDeRepasseDeAtendimento(
 	    	$this->Usuarios ,
 	    	$this->Incidentes ,
 	    	$this->Atendimento
 	    );
	*/
    }
    
    private function enviaEmailDeRepasseDeAtendimento( 
    	UsuariosBO $responsavel ,
    	IncidentesBO $incidente ,
    	AtendVsatBO $atendimento
    )
    {
    	$assunto = "Atendimento Repassado: ".$responsavel->getnome();
        $msg = "Foi repassado o seguinte atendimento do incidente {$incidente->getidincidentes()}:<br/>";
        $atendimento_texto = nl2br($atendimento->getatendimento());
        $msg .= "{$atendimento_texto} para {$responsavel->getnome()} <br/><br/>";
        $msg .= "SAOM - Sistema de Apoio à Operação e Manutenção";
        sendMailEspecifico($assunto, $msg, $responsavel->getemail());
    }
    
    private function criaAtendimentoRepassado( Integer $novoResponsavel )
    {
    	$this->Atendimento->setdata( date('Y-m-d H:i:s') );
    	$this->Atendimento->setstatus_atend_idstatus_atend( 1 );
    	$this->Atendimento->setusuarios_idusuarios( $novoResponsavel->numero() );
    	$this->Atendimento->setincidentes_idincidentes( $this->Atendimento->getincidentes_idincidentes() );
    	$this->Atendimento->setatendimento_pai( $this->Atendimento->getidatend_vsat() );
    	$this->Atendimento->setresposta_agilis( '' );
    	$this->Atendimento->setatendimento( '' );
    	
    	$respostaAtendimento = $this->Atendimento->create();
    	
    	if( !$resposta )
    		exit('Erro ao criar o atendimento para a ação de repassar.');
    	else
    	{
    		$this->Cronometro->setidreferencia( $respostaAtendimento );
    		$this->Cronometro->setinicio_tarefa( date('Y-m-d H:i:s') );
    		$this->Cronometro->settabelareferencia( 'atend_vsat' );
    		$respostaCronometro = $this->Cronometro->create();
    		
    		if( !$respostaCronometro )
        		exit('Erro ao cadastrar Cronômetro para Atendimento Repassado.');
    	}
    }
    
    private function atualizaResponsavelPorAtendimento( Integer $novoResponsavel )
    {

    	$this->Atendimento->setusuarios_idusuarios( $novoResponsavel->numero() );
    	$respostaAtendimento = $this->Atendimento->edit();
    	if( !$respostaAtendimento )
    		exit('Erro mudar a responsabilidade do atendimento.');
    }
    
	public function view() 
    {
    	if ( ! empty($this->dadosP['param'])) 
        {
        	$this->DB->setPrkValue($this->dadosP['param']);
            $dados = $this->DB->view();
            //print_b($dados,true);
            
            //USUARIO
            	$this->smarty->assign('idusuarios',$_SESSION['login']['idusuarios']);
            
            $dados['atendimento'] = nl2br($dados['atendimento']);
            
            $this->buscaAssociacoesMotivosDeAtendimento( $this->dadosP['param'] );
            
            $this->smarty->assign('obj',$dados);
            $this->smarty->display("{$this->tplDir}/view.tpl");
        }
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
			
			$rp = 20;
			if (isset($_POST['rp']))
			    $rp = $_POST['rp'];
		
		// Setup sort and search SQL using posted data
			$sortSql = "order by $sortname $sortorder";
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype LIKE '%$query%'" : '';
			
	
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
					from listatendimentos
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
		
		$sql = "select *
				from listatendimentos
				{$searchSql}
				{$sortSql}
				{$limitSql}";

		$results = $this->DB->queryDados($sql);
//		echo die_json($results);

		foreach( $results AS $row ) 
		{
			$data['rows'][] = array(
				'id' => $row['idatend_vsat'],
				'cell' => array(
					$row['idatend_vsat'],
					$row['idincidentes'],
					utf8_decode(utf8_encode($row['localidade'])),
					utf8_decode(utf8_encode($row['nome_vsat'])), 
					utf8_decode(utf8_encode($row['hub'])),
					utf8_decode(utf8_encode($row['usuario'])),
					utf8_decode(utf8_encode($row['status'])),
					$row['inicio'],
					$row['fim'],
					$row['tempo_passado']
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
					from listatendimentos
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
		
		$sql = "select *
				from listatendimentos
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		$results = $this->DB->queryDados($sql);
		
		foreach( $results AS $row ) 
		{
			$data['rows'][] = array(
				'id' => $row['idatend_vsat'],
				'cell' => array(
					$row['idatend_vsat'],
					$row['idincidentes'],
					utf8_decode(utf8_encode($row['localidade'])),
					utf8_decode(utf8_encode($row['nome_vsat'])), 
					utf8_decode(utf8_encode($row['hub'])),
					utf8_decode(utf8_encode($row['usuario'])),
					utf8_decode(utf8_encode($row['status'])),
					$row['inicio'],
					$row['fim'],
					$row['tempo_passado']
					)
			);
		}
		//print_b($data,true);
		
		echo json_encode($data);
    }

    public function listeAtendsIncidente()
    {
    	if( $this->dadosP['param'] )
    	{	
    		$idincidentes = new Integer( $this->dadosP['param'] );
			$this->Atendimento->getAtendimentosDeIncidente( $idincidentes );
			$this->Atendimento->carregaRelacionamentos();
			//print_b($this->Atendimento->getListaAtendimentosComDependenciasArray(),true);
			$atendimentos = $this->Atendimento->getListaAtendimentosComDependenciasArray();
			//print_b($atendimentos,true);
			foreach ( $atendimentos as $chave => $atendimento )
			{
				$atendimentos[$chave]['atendimento'] = substr( $atendimento['atendimento'] , 0 , 100 );
				$atendimentos[$chave]['resposta_agilis'] = substr( $atendimento['resposta_agilis'] , 0 , 100 );
			}
			
			$this->smarty->assign( 'atendimentos' , $atendimentos );
			
			$this->smarty->assign('incidente',$this->dadosP['param']);
			$this->smarty->assign('login',$_SESSION['login']);
    		$this->smarty->display("{$this->tplDir}/listeAtendsIncidente.tpl");
    	}
    	/*
    	//lista de atendimentos
	    	$dados = $this->DB->liste( 'incidentes_idincidentes = "'.$this->dadosP['param'].'"' );
	    	foreach( $dados as $chave => $atendimento )
	    		$dados[$chave]['atendimento'] = $this->Helpers->limitaTexto($atendimento['atendimento'], 200);
	    	$this->smarty->assign('atendimentos',$dados);
    		//print_b($dados,true);
    		
	    //verifica existencia de atendimentos abertos
	    	for($i=0;$i<count($dados);$i++)
	    		if($dados[$i]['rel']['status_atend']['idstatus_atend']!=3)
	    			$this->smarty->assign('aberto',1);
	    
	    //declara incidente
	    	$this->smarty->assign('incidente',$this->dadosP['param']);
	    	
	   	//print_b($_SESSION,true);
	    $this->smarty->assign('login',$_SESSION['login']);
    	$this->smarty->display("{$this->tplDir}/listeAtendsIncidente.tpl");
    	*/
    }
    
    public function insereMotivoParaAtendimentoFechado()
    {
		if($this->dadosP['form']['idatendimento']['idmotivo'] == '' || $this->dadosP['form']['idresponsavel'] == ''){
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Selecione todos os campos!</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
		}


		if( $this->AssociacaoAtendimentoMotivo->verificaExistenciaAssociacaoPeloTipoMotivo( $this->dadosP['form']['idatendimento'] ) )
			$atualizacaoMotivo = $this->AssociacaoAtendimentoMotivo->atualizaAssociacoesDeAtendimentoPeloTipo( $this->dadosP['form']['idmotivo'], $this->dadosP['form']['idresponsavel'], $this->dadosP['form']['idatendimento'] );
		else
			$atualizacaoMotivo = $this->AssociacaoAtendimentoMotivo->criaAssociacaoDeAtendimentoComMotivo($this->dadosP['form']['idresponsavel'], $this->dadosP['form']['idmotivo'] , $this->dadosP['form']['idatendimento'] );

		if( !$atualizacaoMotivo )
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Erro ao atualizar motivo.</div><img src='imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
//     	}
    	
    	die_json(array(
    		"msg" => "<div class='alert alert-success' style='float:left;'>Motivo atualizado com sucesso.</div><img src='imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
    		"status" => "ok"
    	));
    }

}

?>

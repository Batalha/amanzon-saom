<?php

require_once "s_p/controller/Incidente_sp.php";
require_once "controller/Usuario.php";

class PreIncidentes_sp extends Controller
{
	protected $tplDir = 's_p/tampletes/pre_incidente';
	
	protected $id_prodemge;
	
	public function __construct() 
    {
    	parent::__construct();
    }
    
    public function setId_prodemge( $id_prodemge )
    {
    	$this->id_prodemge =  $id_prodemge;
    }
    
    public function getId_prodemge()
    {
    	return $this->id_prodemge;
    }
    
	public function liste()
    {
    	$this->smarty->assign('login',$_SESSION['login']);
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
		
		// Setup sort and search SQL using posted data
			$sortSql = "order by $sortname $sortorder";
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype LIKE '%$query%'" : '';
			
		// Get total count of records
			$sql = "select count(*) as total
					from pre_incidentes_sp
					{$searchSql}";
			$result = $this->DBPadrao->queryDados($sql);
			$total = $result[0]['total'];
		
		// Setup paging SQL
			$pageStart = /*($page-1);*/($page==1)?0:$rp;
			$limitSql = "limit $pageStart, $rp";
		
		// Return JSON data
			$data = array();
			$data['page'] = $page;
			$data['total'] = $total;
			$data['rows'] = array();
		
		$sql = "
			select *
			from pre_incidentes_sp
			{$searchSql}
			{$sortSql}
			{$limitSql}
		";
		//echo json_encode($sql);exit;
		$results = $this->DBPadrao->queryDados($sql);
		
		// BUSCA NOME RESPONSAVEIS
			foreach ( $results as $chave => $row )
			{
				if( $row['responsavel'] != '' && $row['responsavel'] != NULL )
				{
					$where = " idusuarios = '{$row['responsavel']}' ";
					$usuarios = $this->Usuarios_sp->fetchAll( $where );
					if( $usuarios instanceof Zend_Db_Table_Rowset )
					{
						$usuarios = $usuarios->toArray();
						$results[ $chave ]['nome_responsavel'] = $usuarios[0]['nome'];
					}
					else
						$results[ $chave ]['nome_responsavel'] = '';
				}
				else
					$results[ $chave ]['nome_responsavel'] = '';
			}
		//echo json_encode($results);exit;
		
		foreach( $results AS $row ) 
		{
			$row['prazo_limite'] = substr( $row['prazo_limite'] , 0 , 10 );
			
			$data['rows'][] = array(
				'id' => $row['id_pre_incidentes'],
				'cell' => array(
					$row['id_pre_incidentes'],
					$row['id_prodemge'],
					$row['id_cliente'], 
					$row['prazo_limite'],
					$row['data_email'], 
					utf8_decode(utf8_encode($row['designacao'])),
					'',
					utf8_decode(utf8_encode($row['nome_responsavel']))
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
			
		// Get total count of records
			$sql = "select count(*) as total
					from pre_incidentes_sp
					{$searchSql}";
			$result = $this->DBPadrao->queryDados($sql);
			$total = $result[0]['total'];
			//echo json_encode($sql); exit;
		
		// Setup paging SQL
			$pageStart = ($page==1)?0:$rp;
			$limitSql = "limit $pageStart, $rp";
		
		// Return JSON data
			$data = array();
			$data['page'] = $page;
			$data['total'] = $total;
			$data['rows'] = array();
		
		$sql = "select *
				from pre_incidentes_sp
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		//echo json_encode($sql);exit;
		$results = $this->DBPadrao->queryDados($sql);
		
		// BUSCA NOME RESPONSAVEIS
			foreach ( $results as $chave => $row )
			{
				if( $row['responsavel'] != '' && $row['responsavel'] != NULL )
				{
					$where = " idusuarios = '{$row['responsavel']}' ";
					$usuarios = $this->Usuarios_sp->fetchAll( $where );
					if( $usuarios instanceof Zend_Db_Table_Rowset )
					{
						$usuarios = $usuarios->toArray();
						$results[ $chave ]['nome_responsavel'] = $usuarios[0]['nome'];
					}
					else
						$results[ $chave ]['nome_responsavel'] = '';
				}
				else
					$results[ $chave ]['nome_responsavel'] = '';
			}
			
		
		foreach( $results AS $row ) 
		{
			$row['prazo_limite'] = substr( $row['prazo_limite'] , 0 , 10 );
			
			$data['rows'][] = array(
				'id' => $row['id_pre_incidentes'],
				'cell' => array(
					$row['id_pre_incidentes'],
					$row['id_prodemge'],
					$row['id_cliente'], 
					$row['prazo_limite'],
					$row['data_email'],
					utf8_decode(utf8_encode($row['designacao'])),
					'',
					utf8_decode(utf8_encode($row['nome_responsavel']))
				)
			);
		}
		//print_b($data,true);
		
		echo json_encode($data);
	}
	
	public function listaResponsaveis()
	{
		$dados = $this->dadosP;
		
		$where = " incidentes = 1 ";
		$lista = $this->Usuarios_sp->fetchAll( $where );
		
		$where  = " id_pre_incidentes = '{$dados['idPreIncidente']}' ";
		$preIncidente = $this->PreIncidentes_sp->fetchAll( $where );
		if( $preIncidente instanceof Zend_Db_Table_Rowset )
			$preIncidente = $preIncidente->toArray();
		else
			exit("<span class='alert alert-error'>Erro ao encontrar Pré-Incidente<span>.");
		
		$this->smarty->assign( 'preIncidente' , $preIncidente[0] );
		$this->smarty->assign( 'listaUsuarios' , $lista );
		$this->smarty->display("{$this->tplDir}/listaResponsavelForm.tpl");
	}
	
	public function atualizaResponsavel()
	{
		$dados = $this->dadosP;
		//print_b($dados,true);
		
		if( !$this->verificaDesignacaoDePreIncidente( $dados['idPreIncidente'] ) )
		{
			echo "<span class='alert'>Pré Incidente sem designação.</span>";exit;
		}
		
		if( $this->verificaResponsavelAtual( $dados['idPreIncidente']  , $dados['responsavel'] ) )
		{
			echo "<span class='alert'>Responsável já é o atual.</span>";exit;
		}
		
		$data = array(
			'responsavel' => $dados['responsavel']
		);
		$where  = " id_pre_incidentes = '{$dados['idPreIncidente']}' ";
		
		if( $this->PreIncidentes_sp->update( $data , $where ) )
		{
			if( !$this->criaIncidenteESeuAtendimento( $dados ) )
			{
				echo "<span class='alert alert-success'>Erro ao inserir Incidente.</span>";exit;
			}
			
			echo "<span class='alert alert-success'>Responsável modificado com sucesso.</span>";exit;
		}
		else
			echo "<span class='alert alert-error'>Erro ao modificar responsável.</span>";
			
		exit;
	}
	
	private function verificaDesignacaoDePreIncidente( $idPreIncidente )
	{
		$where = " id_pre_incidentes = '{$idPreIncidente}' ";
		$busca = $this->PreIncidentes_sp->fetchAll( $where );
		if( count($busca) > 0 )
		{
			$linhas = $busca->toArray();
			if( $linhas[0]['designacao'] == NULL )
				return false;
			else
				return true;
		}
		else
		{
			echo "<span class='alert alert-error'>Pré Incidente não encontrado.</span>";exit;
		}
	}
	
	private function verificaResponsavelAtual( $idPreIncidente , $responsavel )
	{
		$where = "
			 id_pre_incidentes = '{$idPreIncidente}' AND 
			 responsavel = '{$responsavel}'
		";
		$busca = $this->PreIncidentes_sp->fetchAll( $where );
		if( count($busca) > 0 )
			return true;
		else
			return false;
	}
	
	public function view()
	{
		$dados = $this->dadosP;
		
		$where = " id_pre_incidentes = '{$dados['param']}' ";
		$preIncidente = $this->PreIncidentes_sp->fetchAll( $where );
		//print_b($preIncidente,true);
		if( $preIncidente instanceof Zend_Db_Table_Rowset )
			$preIncidente = $preIncidente->toArray();
		
		foreach( $preIncidente as $chave => $incidenteItem )
		{
			$where = " idusuarios = '{$incidenteItem['responsavel']}' ";
			$item = $this->Usuarios_sp->fetchAll( $where );
			if( $item instanceof Zend_Db_Table_Rowset )
			{
				$item = $item->toArray();
				$preIncidente[ $chave ]['nome_responsavel'] = $item[0]['nome'];
			}
			else
				$preIncidente[ $chave ]['nome_responsavel'] = '';
		}
		
		$btn_edit = "
			<a class='btn btn-warning' onclick='javascript:getAjaxForm(\"PreIncidentes/edit\",\"conteudo\",{param:".$preIncidente[0]["id_pre_incidentes"].",ajax:1})'>
				<i class='icon-pencil'></i>&nbsp;Editar
			</a>";
		
		$this->smarty->assign( 'btn_edit' , $btn_edit );
		$this->smarty->assign( 'incidente' , $preIncidente[0] );
		$this->smarty->display("{$this->tplDir}/view.tpl");
	}
	
	public function edit()
	{
		$dados = $this->dadosP;
		
		$where = " id_pre_incidentes = '{$dados['param']}' ";
		$preIncidente = $this->PreIncidentes_sp->fetchAll( $where );
		if( $preIncidente instanceof Zend_Db_Table_Rowset )
			$preIncidente = $preIncidente->toArray();
		
		foreach( $preIncidente as $chave => $incidenteItem )
		{
			$where = " idusuarios = '{$incidenteItem['responsavel']}' ";
			$item = $this->Usuarios_sp->fetchAll( $where );
			if( $item instanceof Zend_Db_Table_Rowset )
			{
				$item = $item->toArray();
				$preIncidente[ $chave ]['nome_responsavel'] = $item[0]['nome'];
			}
			else
				$preIncidente[ $chave ]['nome_responsavel'] = '';
		}
		
		$where = " incidentes = 1 ";
		$listaUsuarios = $this->Usuarios_sp->fetchAll( $where );
		
		$this->smarty->assign( 'listaUsuarios' , $listaUsuarios );
		$this->smarty->assign( 'incidente' , $preIncidente[0] );
		$this->smarty->display("{$this->tplDir}/edit.tpl");
	}
	
	public function update()
	{
		$form = $this->dadosP['form'];
		$dados = $this->dadosP['form'];
		
		$idPreIncidente = $form['id_pre_incidentes'];
		unset($form['id_pre_incidentes']);
		
		$where = " id_pre_incidentes = '{$idPreIncidente}' ";
		$data = $form;
		//print_b($data,true);
		//print_b($where,true);
		
		if( $this->PreIncidentes_sp->update( $data , $where ) )
		{
			if( !$this->criaIncidenteESeuAtendimento( $dados ) )
				exit("<span class='alert'>Edição realizada com sucesso, porém houve erro ao inserir Incidente (que ainda não existe).</span>");
			else
				exit("<span class='alert alert-success'>Edição realizada com sucesso!</span>");
		}
		else
			exit("<span class='alert alert-error'>Houve um erro ao atualizar  Pré Incidente!</span>");
	}
	
	private function verificaPreExistenciaIdProdemgeEmIncidentes( Zend_Db_Table_Row $preIncidente )
	{
		//TODO: validar $id_prodemge para integer 
		
		$where = " idprodemge = '{$preIncidente->id_prodemge}' AND origem_incidente = 'P' ";
		$incidentes = $this->Incidentes_sp->fetchAll( $where );
		if( count($incidentes) > 0 )
			return true;
		else
			return false;
	}
	
	private function criaIncidenteESeuAtendimento( Array $dados )
	{
		//TODO: construir um meio de validar esse parametro, obs.: transofrmar ele em um objeto
		if( isset($dados['idPreIncidente']) )
			$where = " id_pre_incidentes = '{$dados['idPreIncidente']}' ";
		else	
			$where = " id_pre_incidentes = '{$dados['id_pre_incidentes']}' ";
		$preIncidente = $this->PreIncidentes_sp->fetchRow( $where );
		
		if( !$this->verificaPreExistenciaIdProdemgeEmIncidentes( $preIncidente ) )
		{
			if( !$this->Instalacao_sp->getInstalacaoPeloNome( trim( $preIncidente->designacao ) ) )
				return false;
			
			$idIncidente = $this->criaIncidente( $preIncidente );
			if( !$idIncidente ) return false;
			
			//cria associacao de instalação  e incidente
			$resgateInstalacao = $this->Instalacao_sp->getInstalacaoPeloNome( $preIncidente->designacao );
			if( $resgateInstalacao ){
				$idAssociacaoInstalacaoIncidente = $this->criaAssociacaoInstalacaoIncidente( $idIncidente , $this->Instalacao_sp->getidinstalacoes() );
				
				//cria telefonemas
				$incidenteController = new Incidente_sp();
				$incidenteController->insereTelefonemas( $idAssociacaoInstalacaoIncidente );
			}
			
			$this->Incidentes_sp->setidincidentes( new Integer( $idIncidente ) );
			$this->Usuarios_sp->setidusuarios( new Integer( $dados['responsavel'] ) );
			//TODO: houve um erro ao gravar a instalacao no atendimento, (obs.: gravou no incidente)
			$idAtendimento = $this->criaAtendimentoParaIncidente( $this->Incidentes , $this->Usuarios );
			if( !$idAtendimento ) return false;
			else{
				$idCronometroDeAtendimento = $this->Cronometro->criaCronometroParaAtendimento( $idAtendimento );
				if( !$idCronometroDeAtendimento ) return false;
			}
		}else{
			//TODO: acrescenta textos ao final
			$this->Incidentes_sp->setidprodemge( $preIncidente->id_prodemge );
			if( $this->Incidentes_sp->getUltimoIncidentePeloIdProdemge() )
			{
				$texto = $this->Incidentes_sp->getdescricao();
				$texto .= "\n---------------------------------\n";
				$dataAgora = date('d/m/Y H:i:s');
				$texto .= "{$dataAgora}\n";
				$texto .= "Solicitação:\n";
				$texto .= $preIncidente->solicitacao."\n\n";
				$texto .= "Discussão:\n";
				$texto .= $preIncidente->discussao."\n";
				
				$this->Incidentes_sp->setdescricao( $texto );
				if( $this->Incidentes_sp->edit() != 'ok' ) return false;
			}
		}
		
		return true;
	}
	
	private function criaAssociacaoInstalacaoIncidente( $idIncidente , $designacao )
	{
		$this->AssociacaoInstalacaoIncidente_sp->setidincidentes( $idIncidente );
		$this->AssociacaoInstalacaoIncidente_sp->setidinstalacoes( $designacao );
		return $this->AssociacaoInstalacaoIncidente_sp->create();
	}
	
	private function criaIncidente( Zend_Db_Table_Row $preIncidente , $prioridade = 'Média' , $saom = 1 )
	{
		//print_b($preIncidente,true);
		$agora = date('Y-m-d H:i:s');
		
		$descricao = '<strong>Solicitação</strong>:<br/>'.$preIncidente->solicitacao.'<br/>'.'<strong>Discussão</strong>:<br/>'.$preIncidente->discussao;
		
		$data  = array(
			'idprodemge' => $preIncidente->id_prodemge,
			'data' => $agora,
			'saom' => $saom,
			'prioridade' => $prioridade,
			'tecnicoNoc' => $preIncidente->responsavel,
			'descricao' => $descricao
		);
		
		if( $id = $this->Incidentes_sp->insert( $data ) )
			return $id;
		else
			return false;
	}
	
	private function getIdInstalacao( $designacao )
	{
		//TODO: validar string $designacao
		
		$idinstalacao = "";
		$designacao = trim($designacao);
		
		$where = " nome = '{$designacao}' ";
		$instalacao = $this->Instalacao_sp->fetchRow( $where );
		
		if( $instalacao instanceof Zend_Db_Table_Row )
			$idinstalacao = $instalacao->idinstalacoes_sp;
			
		return $idinstalacao;
	}
	
	private function criaAtendimentoParaIncidente( Incidentes_spBO $incidente , Usuarios_spBO $responsavel )
	{
		$agora = date('Y-m-d H:i:s');
		
		//TODO: acrescentar dados como parametros
		$data = array(
			'usuarios_idusuarios' => $responsavel->getidusuarios(),
			'data' => $agora,
			'incidentes_idincidentes' => $incidente->getidincidentes(),
			'saom' => 1, //PRODEMGE
			'status_atend_idstatus_atend' => 1
		);
		
		if( $id  = $this->Atendimento_sp->insert( $data ) )
			return $id;
		else
			return false;
	}
}
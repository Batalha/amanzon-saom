<?php

require_once "s_p/controller/Incidente_sp.php";
require_once "s_p/controller/Usuario_sp.php";

class PreIncidentesNagios_sp extends Controller
{
	protected $tplDir = 's_p/tampletes/pre_incidente_nagios';
	
	protected $id_prodemge;//id_nagios
	
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
					from pre_incidentes_nagios_sp
					{$searchSql}";
			$result = $this->DBPadrao->queryDados($sql);
			$total = $result[0]['total'];
		
		// Setup paging SQL
			$pageStart = ($page==1)?0:$rp*($page-1);
			$limitSql = "limit $pageStart, $rp";
		
		// Return JSON data
			$data = array();
			$data['page'] = $page;
			$data['total'] = $total;
			$data['rows'] = array();
		
		$sql = "
			select *
			from pre_incidentes_nagios_sp
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
				'id' => $row['id_pre_incidentes_nagios'],
				'cell' => array(
					$row['id_pre_incidentes_nagios'],
					$row['endereco'],
					utf8_decode(utf8_encode($row['vsat'])),
					$row['data_evento'], 
					utf8_decode(utf8_encode($row['nome_responsavel']))
				)
			);
		}
		//print_b($data,true);
		
		echo json_encode($data);
	}
	
	public function listeFonteFiltro()
	{
		//$_POST = $_GET;// para testes
		
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
			}//else $rp = 20;
		
		// Setup sort and search SQL using posted data
			$sortSql = "order by $sortname $sortorder";
			$searchSql = ($query != '') ? "where $query" : '';
			
		// Get total count of records
			$sql = "select count(*) as total
					from pre_incidentes_nagios_sp
					{$searchSql}";
			//exit($sql);
			$result = $this->DBPadrao->queryDados($sql);
			$total = $result[0]['total'];
			//echo json_encode($sql); exit;
		
		// Setup paging SQL
			$pageStart = ($page==1)?0:$rp*($page-1);
			$limitSql = "limit $pageStart, $rp";
		
		// Return JSON data
			$data = array();
			$data['page'] = $page;
			$data['total'] = $total;
			$data['rows'] = array();
		
		$sql = "select *
				from pre_incidentes_nagios_sp
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		//exit($sql);
		//echo json_encode($sql);exit;
		$results = $this->DBPadrao->queryDados($sql);
		//exit('teste');
		
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
				'id' => $row['id_pre_incidentes_nagios'],
				'cell' => array(
					$row['id_pre_incidentes_nagios'],
					$row['endereco'],
					utf8_decode(utf8_encode($row['vsat'])),
					$row['data_evento'], 
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
		
		$where  = " id_pre_incidentes_nagios = '{$dados['idPreIncidenteNagios']}' ";
		$preIncidenteNagios = $this->PreIncidentesNagios->fetchAll( $where );
		if( $preIncidenteNagios instanceof Zend_Db_Table_Rowset )
			$preIncidenteNagios = $preIncidenteNagios->toArray();
		else
			exit("<span class='alert alert-error'>Erro ao encontrar Pré-Incidente<span>.");
		
		$this->smarty->assign( 'preIncidente' , $preIncidenteNagios[0] );
		$this->smarty->assign( 'listaUsuarios' , $lista );
		$this->smarty->display("{$this->tplDir}/listaResponsavelForm.tpl");
	}
	
	public function atualizaResponsavel()
	{
		$dados = $this->dadosP;
		//print_b($dados,true);
		
		if( !$this->verificaDesignacaoDePreIncidente( $dados['idPreIncidenteNagios'] ) )
		{
			echo "<span class='alert'>Pré Incidente Nagios sem designação.</span>";exit;
		}
		
		if( $this->verificaResponsavelAtual( $dados['idPreIncidenteNagios']  , $dados['responsavel'] ) )
		{
			echo "<span class='alert'>Responsável já é o atual.</span>";exit;
		}
		
		$data = array(
			'responsavel' => $dados['responsavel']
		);
		$where  = " id_pre_incidentes_nagios = '{$dados['idPreIncidenteNagios']}' ";
		
		if( $this->PreIncidentesNagios->update( $data , $where ) )
		{
			//$this->criaIncidenteESeuAtendimento( $dados );
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
		$where = " id_pre_incidentes_nagios = '{$idPreIncidente}' ";
		$busca = $this->PreIncidentesNagios->fetchAll( $where );
		if( count($busca) > 0 )
		{
			$linhas = $busca->toArray();
			if( $linhas[0]['vsat'] == NULL )
				return false;
			else
				return true;
		}
		else
		{
			echo "<span class='alert alert-error'>Pré Incidente Nagios não encontrado.</span>";exit;
		}
	}
	
	private function verificaResponsavelAtual( $idPreIncidente , $responsavel )
	{
		$where = "
			 id_pre_incidentes_nagios = '{$idPreIncidente}' AND 
			 responsavel = '{$responsavel}'
		";
		$busca = $this->PreIncidentesNagios->fetchAll( $where );
		if( count($busca) > 0 )
			return true;
		else
			return false;
	}
	
	public function view()
	{
		$dados = $this->dadosP;
		
		$where = " id_pre_incidentes_nagios = '{$dados['param']}' ";
		$preIncidente = $this->PreIncidentesNagios->fetchAll( $where );
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
			<a class='btn btn-warning' onclick='javascript:getAjaxForm(\"PreIncidentesNagios/edit\",\"conteudo\",{param:".$preIncidente[0]["id_pre_incidentes_nagios"].",ajax:1})'>
				<i class='icon-pencil'></i>&nbsp;Editar
			</a>";
		
		$this->smarty->assign( 'btn_edit' , $btn_edit );
		$this->smarty->assign( 'incidente' , $preIncidente[0] );
		$this->smarty->display("{$this->tplDir}/view.tpl");
	}
	
	public function edit()
	{
		$dados = $this->dadosP;
		
		$where = " id_pre_incidentes_nagios = '{$dados['param']}' ";
		$preIncidente = $this->PreIncidentesNagios->fetchAll( $where );
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
		
		$idPreIncidente = $form['id_pre_incidentes_nagios'];
		unset($form['id_pre_incidentes_nagios']);
		
		$where = " id_pre_incidentes_nagios = '{$idPreIncidente}' ";
		$data = $form;
		
		if( $this->PreIncidentesNagios->update( $data , $where ) )
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
		
		$where = " idprodemge = '{$preIncidente->id_pre_incidentes_nagios}' AND origem_incidente = 'N' ";
		$incidentes = $this->Incidentes_sp->fetchAll( $where );
		if( count($incidentes) > 0 )
			return true;
		else
			return false;
	}
	
	private function criaIncidenteESeuAtendimento( Array $dados )
	{
		//TODO: construir um meio de validar esse parametro, obs.: transofrmar ele em um objeto
		if( isset($dados['idPreIncidenteNagios']) )
			$where = " id_pre_incidentes_nagios = '{$dados['idPreIncidenteNagios']}' ";
		else	
			$where = " id_pre_incidentes_nagios = '{$dados['id_pre_incidentes_nagios']}' ";
		$preIncidenteNagios = $this->PreIncidentesNagios->fetchRow( $where );
		
		if( !$this->verificaPreExistenciaIdProdemgeEmIncidentes( $preIncidenteNagios ) )
		{
			if( !$this->Instalacao_sp->getInstalacaoPeloNome( $preIncidenteNagios->vsat ) )
				return false;
			
			$this->criaIncidente( $preIncidenteNagios );
			$idIncidente = $this->criaIncidente( $preIncidenteNagios );
			if( !$idIncidente ) return false;
			
			//cria associacao de instalação  e incidente
			$resgateInstalacao = $this->Instalacao_sp->getInstalacaoPeloNome( $preIncidenteNagios->vsat );
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
			$this->Incidentes_sp->setidprodemge( $preIncidenteNagios->id_prodemge );
			if( $this->Incidentes_sp->getUltimoIncidentePeloIdProdemge() )
			{
				$texto = $this->Incidentes_sp->getdescricao();
				$texto .= "\n---------------------------------\n";
				$dataAgora = date('d/m/Y H:i:s');
				$dataPreIncidente = $this->Helpers->data_us_br_com_hora( $preIncidenteNagios->data_evento );
				$texto .= "{$dataPreIncidente}\n";
				$texto .= "Solicitação:\n";
				$texto .= $preIncidenteNagios->solicitacao."\n\n";
				$texto .= "Discussão:\n";
				$texto .= $preIncidenteNagios->discussao."\n";
				
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
		$agora = date('Y-m-d H:i:s');
		
		$descricao = '<strong>Informações</strong>:<br/>'.$preIncidente->informacoes;
		$designacao = '<strong>Designação:</strong> '.$preIncidente->vsat;
		$ip = '<strong>Endereço IP:</strong> '.$preIncidente->endereco;
		$descricao = "{$informacoes}<br/>{$designacao}<br/>{$ip}";
		
		$data = array(
			'idprodemge' => $preIncidente->id_pre_incidentes_nagios,
			'data' => $preIncidente->data_evento,//$agora,
			'saom' => $saom,
			'prioridade' => $prioridade,
			'tecnicoNoc' => $preIncidente->responsavel,
			'descricao' => $descricao
		);
		//print_b($data,true);
		
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
	
	private function criaAtendimentoParaIncidente( IncidentesBO $incidente , UsuariosBO $responsavel )
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
	
	public function listaHistoricoDesignacao()
	{
		$dados = $this->dadosP;
		
		$listaIncidentesDeDesignacao = $this->Incidentes_sp->buscaIncidentesFechadosDeDesignacao( $dados['designacao'] );
		if( $listaIncidentesDeDesignacao == false )
			$this->smarty->assign( 'msg' , "Não existem incidentes fechados para essa designação." );
		else
		{
			$listaIncidentesDeDesignacao = $this->Atendimento_sp->iteraListaIncidentesBuscandoAtendimentos( $listaIncidentesDeDesignacao );
			if( $listaIncidentesDeDesignacao == false )
				$this->smarty->assign( 'msg' , "Não existem atendimentos para os incidentes dessa designação." );
			else
			{
				$listaIncidentesDeDesignacao = $this->AssociacaoAtendimentoMotivo_sp->buscaMotivosDeAtendimentos( $listaIncidentesDeDesignacao );
				$this->smarty->assign( 'listaIncidentes' , $listaIncidentesDeDesignacao );
			}
		}
		
		//print_b($listaIncidentesDeDesignacao,true);
		$this->smarty->display("{$this->tplDir}/listaHistoricoDesignacao.tpl");
	}
}
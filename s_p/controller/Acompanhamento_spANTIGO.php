<?php

require_once 's_p/model/DBAcompanhamento_sp.php';
require_once 's_p/model/DBModel_sp.php';


class Acompanhamento_sp extends Controller
{
	protected $tplDir = 's_p/tampletes/acompanhamento';

	//
	protected $page;
	protected $sortname;
	protected $sortorder;
	protected $qtype;
	protected $query;
	protected $rp;

	//
	protected $array_atendimentos = array();
	protected $array_comissionamentos = array(); 
	protected $array_acompanhamento_noc = array();
	protected $contador_array_comissionamentos;//TODO: paginacao adiada a pedido do Alex

	function __construct()
	{
		parent::__construct();

		$this->DB = new DBAcompanhamento_sp();

		$this->smarty->assign('login',$_SESSION['login']);

	}


	/*
	 * listagem incial irá depender do perfil do usuário conectado
	 *
	 * 1.para supervisores(5), admin(4), noc(1):
	 * 	.acompanhamentoNoc
	 *
	 * 2.para com(2)
	 * 	.acompanhamentoCom
	 *
	 * 3.para campo(3)
	 * 	.acompanhamentoCampo
	 */
	public function liste()
	{

//        echo die_json($_SESSION['login']['perfis_idperfis']);

		switch ($_SESSION['login']['perfis_idperfis']) {
			// NOC, ADMIN, SUPERVISOR, CLIENTE
            case 5:
			case 4:
				$this->acompanhamentoNoc();
				break;
			case 10:
                $this->acompanhamentoNoc();
                break;
			case 1:
				// NOC
				$this->acompanhamentoNoc();
				break;
			case 2:
				// COM
				$this->acompanhamentoCom();
				break;
			case 3:
				// CAMPO
				$this->acompanhamentoCampo();
				break;
		}
	}



	//COM
	public function acompanhamentoCom()
	{
		$this->smarty->display("{$this->tplDir}/listchamadosfull.tpl");
	}
	 
	public function acompanhamentoComConteudo()
	{
		$contagemAtual = 0;

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
		
		// -------------------------------------- RESGATE DE INCIDENTES
			
		//$this->busca_incidentes();

        // -------------------------------------- RESGATE DE ATENDIMENTOS
        $this->buscaAtendimentos();

//         print_b($this->buscaAtendimentos());

		// ------------------------------------- RESGATE DE INCIDENTES

		$this->busca_comissionamentos();

		// ------------------------------------- TRATA DADOS RESGATADOS

		$passados = array( 'idIncidentes' => array() , 'idInstalacoes' => array() , 'tipos' => array() );

		$this->array_acompanhamento_noc = array_merge( $this->array_atendimentos , $this->array_comissionamentos );
		foreach ( $this->array_acompanhamento_noc as $chave => $acompanhamento )
		{
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['idtecnico'] );
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['idtecnico'] );
//			$this->array_acompanhamento_noc[ $chave ]['cell']['hub'] = '';
			$this->array_acompanhamento_noc[ $chave ]['cell']['status'] = ( $this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] != '' )?'Finalizado':'Em Andamento';
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['saom'] );

			$dataInicio = new DateTime($acompanhamento['cell']['data_inicio']);
			$dataFim    = new DateTime('now');

			$sql = "
				SELECT TIMEDIFF(
					'{$dataFim->format( 'Y-m-d H:i:s' )}',
            	    '{$dataInicio->format( 'Y-m-d H:i:s' )}'
            	) as intervalo
			";
			$intervalo = $this->DBPadrao->queryDados( $sql );
			$intervalo = $intervalo[0]['intervalo'];

			// ---------------- FILTRA PERFIS DA SESSAO
			$dia_acompanhamento_com = explode( ' ' , $this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] );
			$hoje = date('Y-m-d');
			if(
				(
					in_array( $acompanhamento['cell']['incidente'] , $passados['idIncidentes'] ) &&
					in_array( $acompanhamento['cell']['idinstalacoes'] , $passados['idInstalacoes'] )&&
					in_array( $acompanhamento['cell']['tipo'] , $passados['tipos'] )
				) ||
				(
					$this->array_acompanhamento_noc[ $chave ]['cell']['status'] == 'Finalizado' &&
					$dia_acompanhamento_com[0] != $hoje
				) ||
				$acompanhamento['cell']['idperfil_usuario'] != 2 // retira usuarios 'não com'
			){

        echo die_json($this->array_acompanhamento_noc[ $chave ]);

				unset( $this->array_acompanhamento_noc[ $chave ] );
			}else{
				array_push( $passados['idIncidentes'] , $acompanhamento['cell']['incidente'] );
				array_push( $passados['idInstalacoes'] , $acompanhamento['cell']['idinstalacoes'] );
				array_push( $passados['tipos'] , $acompanhamento['cell']['tipo'] );
				
				$this->array_acompanhamento_noc[ $chave ]['cell']['tempo_vencimento'] = $intervalo;
			}
		}
		//array_unique( $this->array_acompanhamento_noc );
// 		print_r($this->array_acompanhamento_noc);
		
		$arrayDados['total'] = count($this->array_acompanhamento_noc);
		$arrayDados['page'] = $this->page;
		$arrayDados['rows'] = $this->array_acompanhamento_noc;

		echo json_encode($arrayDados);exit;
	}
	
	//NOC
	public function acompanhamentoNoc()
	{

		$this->smarty->display("{$this->tplDir}/listchamadosfull.tpl");
	}
	
        public function acompanhamentoNocConteudo()
	{

		$contagemAtual = 0;
	
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
	
		// -------------------------------------- RESGATE DE INCIDENTES
			
//		$this->busca_incidentes();


		// -------------------------------------- RESGATE DE ATENDIMENTOS

		$this->buscaAtendimentos();


		// ------------------------------------- RESGATE DE INCIDENTES

		$this->busca_comissionamentos();

		// ------------------------------------- TRATA DADOS RESGATADOS

		$passados = array( 'idIncidentes' => array() , 'idInstalacoes' => array() , 'tipos' => array() );

		$this->array_acompanhamento_noc = array_merge( $this->array_atendimentos , $this->array_comissionamentos );
//        echo die_json($this->array_acompanhamento_noc );



		foreach ( $this->array_acompanhamento_noc as $chave => $acompanhamento )
		{
//			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['idtecnico'] );
//			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['idtecnico'] );
////			$this->array_acompanhamento_noc[ $chave ]['cell']['hub'] = '';

			if($this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] != ''){
				$this->array_acompanhamento_noc[ $chave ]['cell']['status']  = 'Finalizado';
			}else
				if($this->array_acompanhamento_noc[ $chave ]['cell']['pausa'] != ''){
					$this->array_acompanhamento_noc[ $chave ]['cell']['status']  = 'Pausado';
			}else{
					$this->array_acompanhamento_noc[ $chave ]['cell']['status'] = 'Em Andamento';
				}

//			$this->array_acompanhamento_noc[ $chave ]['cell']['status'] = ( $this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] != '' )?'Finalizado':'Em Andamentos';
//
//
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['saom'] );
//
			$dataInicio = new DateTime( $acompanhamento['cell']['data_inicio'] );
			$dataFim = new DateTime('now');
//
//			// TODO: aguardando php 5.3
//			// $intervalo = $dataFim->diff( $agora );
//			// TODO: solucao para php 5.2
			$sql = "
                SELECT TIMEDIFF('{$dataFim->format( 'Y-m-d H:i:s' )}','{$dataInicio->format( 'Y-m-d H:i:s' )}') as intervalo";
                $intervalo = $this->DBPadrao->queryDados( $sql );
                $intervalo = $intervalo[0]['intervalo'];
//
//			// ---------------- FILTRA PERFIS DA SESSAO
			$dia_acompanhamento_noc = explode( ' ' , $this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] );
			$hoje = date('Y-m-d');
			if((
                in_array( $acompanhamento['cell']['incidente'] , $passados['idIncidentes'] )        &&
                in_array( $acompanhamento['cell']['idinstalacoes'] , $passados['idInstalacoes'] )   &&
                in_array( $acompanhamento['cell']['tipo'] , $passados['tipos'] ))                   ||

                ($this->array_acompanhamento_noc[ $chave ]['cell']['status'] == 'Finalizado' && $dia_acompanhamento_noc[0] != $hoje) ||
                $acompanhamento['cell']['idperfil_usuario'] != 1 )// retira usuarios que 'não tem perfil NOC'


            {

                $this->array_acompanhamento_noc[ $chave ]['cell']['tempo_vencimento'] = $intervalo;
			}else{
                array_push( $passados['idIncidentes'] , $acompanhamento['cell']['incidente'] );
                array_push( $passados['idInstalacoes'] , $acompanhamento['cell']['idinstalacoes'] );
                array_push( $passados['tipos'] , $acompanhamento['cell']['tipo'] );
//
                $this->array_acompanhamento_noc[ $chave ]['cell']['tempo_vencimento'] = $intervalo;
			}
		}

        $arrayDados['total'] = count( $this->array_acompanhamento_noc );
		$arrayDados['page'] = $this->page;
		$arrayDados['rows'] = $this->array_acompanhamento_noc;


			echo json_encode($arrayDados);exit;
	}
	 
	//CAMPO
	public function acompanhamentoCampo()
	{
		$this->smarty->display("{$this->tplDir}/listchamadosfull.tpl");
	}
	 
	public function acompanhamentoCampoConteudo()
	{
		$contagemAtual = 0;

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
		
		// -------------------------------------- RESGATE DE INCIDENTES

		//$this->busca_incidentes();

        // -------------------------------------- RESGATE DE ATENDIMENTOS
        $this->buscaAtendimentos();
		
		// ------------------------------------- RESGATE DE INCIDENTES
		
		$this->busca_comissionamentos();
		
		// ------------------------------------- TRATA DADOS RESGATADOS
		
		$passados = array( 'idIncidentes' => array() , 'idInstalacoes' => array() , 'tipos' => array() );
		
		$this->array_acompanhamento_noc = array_merge( $this->array_atendimentos , $this->array_comissionamentos );
		foreach ( $this->array_acompanhamento_noc as $chave => $acompanhamento )
		{
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['idtecnico'] );
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['idtecnico'] );
//			$this->array_acompanhamento_noc[ $chave ]['cell']['hub'] = '';
			$this->array_acompanhamento_noc[ $chave ]['cell']['status'] = ( $this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] != '' )?'Finalizado':'Em Andamento';
			unset( $this->array_acompanhamento_noc[ $chave ]['cell']['saom'] );
				
			$dataInicio = new DateTime($acompanhamento['cell']['data_inicio']);
			$dataFim = new DateTime('now');
			
			// TODO: aguardando php 5.3
			// $intervalo = $dataFim->diff( $agora );
			// TODO: solucao para php 5.2
			$sql = "
				SELECT TIMEDIFF(
					'{$dataFim->format( 'Y-m-d H:i:s' )}',
            	    '{$dataInicio->format( 'Y-m-d H:i:s' )}'
            	) as intervalo
			";
			$intervalo = $this->DBPadrao->queryDados( $sql );
			$intervalo = $intervalo[0]['intervalo'];	
			
			// ---------------- FILTRA PERFIS DA SESSAO
			$dia_acompanhamento_campo = explode( ' ' , $this->array_acompanhamento_noc[ $chave ]['cell']['data_fim'] );
			$hoje = date('Y-m-d');
			if( 
				(
					in_array( $acompanhamento['cell']['incidente'] , $passados['idIncidentes'] ) &&
					in_array( $acompanhamento['cell']['idinstalacoes'] , $passados['idInstalacoes'] )&&
					in_array( $acompanhamento['cell']['tipo'] , $passados['tipos'] )
				) ||
				(
					$this->array_acompanhamento_noc[ $chave ]['cell']['status'] == 'Finalizado' &&
					$dia_acompanhamento_campo[0] != $hoje
				) ||
				$acompanhamento['cell']['idperfil_usuario'] != 3 // retira usuarios 'não campo'
			){
				unset( $this->array_acompanhamento_noc[ $chave ] );
			}else{
				array_push( $passados['idIncidentes'] , $acompanhamento['cell']['incidente'] );
				array_push( $passados['idInstalacoes'] , $acompanhamento['cell']['idinstalacoes'] );
				array_push( $passados['tipos'] , $acompanhamento['cell']['tipo'] );
				
				$this->array_acompanhamento_noc[ $chave ]['cell']['tempo_vencimento'] = $intervalo;
			}
				
			// ---------------- FILTRA PELO USUARIO CONECTADO
// 			if( $_SESSION['login']['perfis_idperfis'] == 3 )
// 				if( $acompanhamento['cell']['idtecnico'] != $_SESSION['login']['idusuarios'] )
// 					unset( $this->array_acompanhamento_noc[ $chave ] );
		}
		//array_unique( $this->array_acompanhamento_noc );
		//print_b($this->array_acompanhamento_noc,true);
		
		$arrayDados['total'] = count($this->array_acompanhamento_noc);
		$arrayDados['page'] = $this->page;
		$arrayDados['rows'] = $this->array_acompanhamento_noc;
		
		echo json_encode($arrayDados);exit;
	}
	 
	//VIEW
	public function view_chamados()
	{
		
	}

	//ARRAY DE VIEW
	public function constroiArrayDeView(
	$tabela,
	$arrayTabela,
	$idTabela,
	$perfil,
	$page,
	$sortname,
	$sortorder,
	$qtype,
	$query,
	$rp,
	$queryCondicaoExtra,
	$limit=''
	)
	{
		$this->rp = $rp;
		// Setup sort and search SQL using posted data
		if(!(isset($_POST['rp'])))
		{
			$this->rp = 20;
		}
		if(!(isset($_POST['page'])))
		{
			$page = 1;
		}
		if(!(isset($_POST['page'])))
		{
			$page = 1;
		}

		//--
		if($sortname!='')
		{
			$sortSql = "order by $sortname $sortorder";
		}
		else
		{
			$sortSql = "";
		}

		if($qtype != '' && $query != '')
		{
			$searchSql = "where $qtype LIKE '%$query%' ";
			if($perfil!='')
			{
				$searchSql .= "AND idperfil_usuario = {$perfil}";
			}
		}
		else
		{
			if($perfil!='')
			{
				$searchSql = "where idperfil_usuario = {$perfil}";
			}
		}
		//--
		//if($tabela=='listcomiss'){echo json_encode($queryCondicaoExtra);exit;}
		// Get total count of records
		$sql = "select count(*) as total
						from {$tabela}
						{$searchSql}
						{$queryCondicaoExtra}";
						$result = $this->DB->queryDados($sql);
						$total = $result[0]['total'];
							
						// Setup paging SQL
						$pageStart = ($page-1)*$this->rp;
						if($limit=='')
						{
							$limitSql = "limit {$pageStart}, {$this->rp}";
						}
						else
						{
							$limitSql = " limit {$limit}";
						}
							
						// Return JSON data
						$data = array();
						$data['page'] = $page;
						$data['total'] = $total;
						$data['rows'] = array();
							
						$sql = "select *
					from {$tabela}
					{$searchSql}
					{$queryCondicaoExtra}
					{$sortSql}
					{$limitSql}";

					$results = $this->DB->queryDados($sql);
						
					//if($tabela=='listcomiss'){echo json_encode($arrayTabela);exit;}
						
					foreach( $results AS $row )
					{
						for($i=0;$i<count($arrayTabela);$i++)
						{
							$arrayCampostabela['row'][] = $row[$arrayTabela[$i]];
						}
						//print_b($arrayCampostabela,true);

						$data['rows'][] = array(
					'id' => $row[$idTabela],
					'cell' => array()
						);

						for($i=0;$i<count($arrayTabela);$i++)
						{
							$data['rows'][count($data['rows'])-1]['cell'][$arrayTabela[$i]] = $arrayCampostabela['row'][$i];
						}

						unset($arrayCampostabela);
					}
					//if($tabela=='listcomiss'){echo json_encode('teste');exit;}
					return $data;
	}

	public function transfereArraysParaCamposCorretos(
	$tipo,
	$arrayOriginal,
	$arrayNova,
	$arrayDados,
	$page
	)
	{
		$contador = 0;
		$arrayDados = array('page'=>$arrayOriginal['page'],'total'=>'','rows'=>array());
			
		for($i=0;$i<count($arrayOriginal['rows']);$i++)
		{
			//manuais
			$arrayOriginal['rows'][$i]['cell']['tipo'] = $tipo;
//			$arrayOriginal['rows'][$i]['cell']['hub'] = 'Prodemge';
				
			for($i2=0;$i2<count($arrayNova);$i2++)
			{
				if(isset($arrayOriginal['rows'][$i]['cell'][$arrayNova[$i2]]))
				{
					$cell[$i2] = $arrayOriginal['rows'][$i]['cell'][$arrayNova[$i2]];
					//$cell[$arrayNova[$i2]] = $arrayOriginal['rows'][$i]['cell'][$arrayNova[$i2]];
				}
				else
				{
					$cell[$i2] = '-';
				}
			}
			//if($tabela=='listcomiss'){echo json_encode($arrayNova);exit;}

			$row['id'] = $arrayOriginal['rows'][$i]['id'];
			$row['cell'] = $cell;
			array_push($arrayDados['rows'],$row);
			$contador++;
		}
			
		$arrayDados['total'] = $contador;
		//echo json_encode($arrayDados);exit;
			
		return $arrayDados;
	}

	public function verificaAtualizacaoDisponivel()
	{
		$ultimaRequisicao = $_POST['ultimaRequisicao'];
		$sql = "SELECT COUNT(*) AS total
					FROM log 
					WHERE 
						data > TIMESTAMP('{$ultimaRequisicao}') AND
						(tabelareferencia = 'atend_vsat_sp' OR tabelareferencia = 'instalacoes_sp')";
		//exit($sql);
		$dados = $this->DB->queryDados($sql);
			
		echo $dados[0]['total'];exit;
	}

	
	
	// -------------------------------------------------------------------------------
	// ------------------ BUSCA INCIDENTES E COMISSIONAMENTOS ------------------------
	// -------------------------------------------------------------------------------

    private function buscaAtendimentos() {


        $atendimentosAbertos = $this->Atendimento_sp->getAtendimentosAcompanhamento();

		$empresaId = $_SESSION['login']['empresas_idempresas'];
		$busca = "(empresas_idempresas = '$empresaId')";
		$osspId =  $this->OSSP->fetchAll($busca);

		$osspId = $osspId->toArray();


		if($_SESSION['login']['perfis_idperfis']==10){

			foreach ($atendimentosAbertos as $atendimento) {
				foreach($osspId as $chave=>$osspIds){
					$surch = "(os_sp_idos =". $osspIds['idos'].")";
					if($install = $this->Instalacao_sp->fetchRow($surch)){
						if($install['idinstalacoes_sp'] == $atendimento['instalacoes_sp_idinstalacoes_sp']){
							// usuario
							$atendimento['usuario']        = null;
							$atendimento['perfil_usuario'] = null;

							if ($atendimento['usuarios_idusuarios']) {
								$usuario = $this->Usuarios_sp
												->find($atendimento['usuarios_idusuarios'])
												->toArray();
								$atendimento['usuario']        = $usuario[0]['nome'];
								$atendimento['perfil_usuario'] = $usuario[0]['perfis_idperfis'];

							}

							$atendimento['vsat']         = null;
							$atendimento['idinstalacao'] = null;
							$instalacao = $this->Instalacao_sp
											   ->select()
											   ->setIntegrityCheck(false)
											   ->from(array('i' => 'instalacoes_sp'), 'i.*')
											   ->joinInner(
													array('aii' => 'associacao_instalacao_incidente_sp'),
													'aii.idinstalacoes_sp = i.idinstalacoes_sp',
													array('qtd' => 'COUNT(*)'),
													null
											   )
											   ->joinInner(
													array('inc' => 'incidentes_sp'),
													'inc.idincidentes = aii.idincidentes'
											  )
											   ->where('inc.idincidentes = ?', $atendimento['incidentes_sp_idincidentes'])
											   ->query()
											   ->fetch();

							$atendimento['vsat']         = $instalacao['nome'];
							$atendimento['idinstalacao'] = $instalacao['idinstalacoes_sp'];

				//			var_dump($atendimento['idinstalacao']);

							$atendimento = array(
								'id'   => $atendimento['idatend_vsat'],
								'cell' => array(
									'idatendimento'    => $atendimento['idatend_vsat'],
									'data_inicio'      => $atendimento['inicio_tarefa'],
									'incidente'        => $atendimento['incidentes_sp_idincidentes'],
									'vsat'             => $atendimento['vsat'],
									'tecnico'          => $atendimento['usuario'],
									'data_fim'         => $atendimento['final_tarefa'],
									'idperfil_usuario' => $atendimento['perfil_usuario'],
									'idinstalacoes'    => $atendimento['idinstalacao'],
									'tipo'             => 'Atendimento',
								)
							);

							array_push($this->array_atendimentos, $atendimento);
						}
					}
				}
			}
		}else{
			foreach ($atendimentosAbertos as $atendimento) {
				$atendimento['usuario']        = null;
				$atendimento['perfil_usuario'] = null;

				if ($atendimento['usuarios_idusuarios']) {
					$usuario = $this->Usuarios_sp
						->find($atendimento['usuarios_idusuarios'])
						->toArray();
					$atendimento['usuario']        = $usuario[0]['nome'];
					$atendimento['perfil_usuario'] = $usuario[0]['perfis_idperfis'];

				}

				$atendimento['vsat']         = null;
				$atendimento['idinstalacao'] = null;
				$instalacao = $this->Instalacao_sp
					->select()
					->setIntegrityCheck(false)
					->from(array('i' => 'instalacoes_sp'), 'i.*')
					->joinInner(
						array('aii' => 'associacao_instalacao_incidente_sp'),
						'aii.idinstalacoes_sp = i.idinstalacoes_sp',
						array('qtd' => 'COUNT(*)'),
						null
					)
					->joinInner(
						array('inc' => 'incidentes_sp'),
						'inc.idincidentes = aii.idincidentes'
					)
					->where('inc.idincidentes = ?', $atendimento['incidentes_sp_idincidentes'])
					->query()
					->fetch();

				$atendimento['vsat']         = $instalacao['nome'];
				$atendimento['idinstalacao'] = $instalacao['idinstalacoes_sp'];

				//			var_dump($atendimento['idinstalacao']);

				$atendimento = array(
					'id'   => $atendimento['idatend_vsat'],
					'cell' => array(
						'idatendimento'    => $atendimento['idatend_vsat'],
						'data_inicio'      => $atendimento['inicio_tarefa'],
						'incidente'        => $atendimento['incidentes_sp_idincidentes'],
						'vsat'             => $atendimento['vsat'],
						'tecnico'          => $atendimento['usuario'],
						'data_fim'         => $atendimento['final_tarefa'],
						'idperfil_usuario' => $atendimento['perfil_usuario'],
						'idinstalacoes'    => $atendimento['idinstalacao'],
						'tipo'             => 'Atendimento',
					)
				);

				array_push($this->array_atendimentos, $atendimento);
			}
		}
    }

	public function busca_incidentes()
	{
		$hoje = date('Y-m-d');
		
		//busca cronometros por finalizar
		$where = "
			tabelareferencia = 'atend_vsat_sp' AND
			(
				final_tarefa IS NULL OR
				final_tarefa = '0000-00-00 00:00:00' OR
				final_tarefa = '' OR
				final_tarefa LIKE '{$hoje}%'
			)
		";
		$cronometros_incidentes = $this->Cronometro_sp->fetchAll( $where );
//        var_dump($cronometros_incidentes);
		if( $cronometros_incidentes instanceof Zend_Db_Table_Rowset )
		{
			$cronometros_incidentes = $cronometros_incidentes->toArray();
			//busca atendimento pendente
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					idatend_vsat = '{$cronometro['idreferencia']}'
				";
				$atendimento = $this->Atendimento_sp->fetchAll( $where );
				if( $atendimento instanceof Zend_Db_Table_Rowset)
				{
					$array = $atendimento->toArray();
                    $cronometros_incidentes[ $chave ]['atend_vsat'] = null;
                    if ($array) {
                        $cronometros_incidentes[ $chave ]['atend_vsat'] = $array[0];
                    }
				}
				else
					unset( $cronometros_incidentes[ $chave ] );
			}
				
			//busca dados do incidente
			foreach ( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					idincidentes = '{$cronometro['atend_vsat']['incidentes_sp_idincidentes']}'
				";
				$incidente = $this->Incidentes_sp->fetchAll( $where );
				if( $incidente instanceof Zend_Db_Table_Rowset)
				{
					$array = $incidente->toArray();
                    $cronometros_incidentes[ $chave ]['incidente'] = null;
                    if ($array) {
                        $cronometros_incidentes[ $chave ]['incidente'] = $array[0];
                    }
				}
				else
					unset( $cronometros_incidentes[ $chave ] );
			}
				
			//busca dados da instalacao
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					idinstalacoes = '{$cronometro['incidente']['instalacoes_idinstalacoes']}'
				";
				$instalacao = $this->Instalacao_sp->fetchAll( $where );
				if( $instalacao instanceof Zend_Db_Table_Rowset)
				{
					$array = $instalacao->toArray();
                    $cronometros_incidentes[ $chave ]['instalacao'] = null;
                    if ($array) {
                        $cronometros_incidentes[ $chave ]['instalacao'] = $array[0];
                    }
				}
				else
					unset( $cronometros_incidentes[ $chave ] );
			}
				
			//busca dados do usuario
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					idusuarios = '{$cronometro['atend_vsat_sp']['usuarios_idusuarios']}'
				";
				$usuarios = $this->Usuarios_sp->fetchAll( $where );


				if( $usuarios instanceof Zend_Db_Table_Rowset)
				{
					$array = $usuarios->toArray();
                    $cronometros_incidentes[$chave]['usuario'] = null;
                    if ($array) {
                        $cronometros_incidentes[$chave]['usuario'] = $array[0];
                    }
				}
				else
					unset( $cronometros_incidentes[$chave] );
			}
				
			//busca pefil do usuario
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					idperfis = '{$cronometro['usuario']['perfis_idperfis']}'
				";
				$perfil = $this->Perfil_sp->fetchAll( $where );
				if( $perfil instanceof Zend_Db_Table_Rowset)
				{
					$array = $perfil->toArray();
                    $cronometros_incidentes[$chave]['perfil_usuario'] = null;
                    if ($array){
                        $cronometros_incidentes[$chave]['perfil_usuario'] = $array[0];
                    }
                }
				else
				unset( $cronometros_incidentes[$chave] );
			}
				
			//busca empresa do usuario
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					idempresas = '{$cronometro['usuario']['empresas_idempresas']}'
				";
				$empresa = $this->Empresa_sp->fetchAll( $where );
				if( $empresa instanceof Zend_Db_Table_Rowset)
				{
					$array = $empresa->toArray();
                    $cronometros_incidentes[$chave]['empresa_usuario'] = null;
                    if ($array) {
                        $cronometros_incidentes[$chave]['empresa_usuario'] = $array[0];
                    }
				}
				else
				unset( $cronometros_incidentes[$chave] );
			}
				
			//busca empresa do usuario
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				$where = "
					id_saom = '{$cronometro['atend_vsat']['saom']}'
				";
				$saom = $this->Saom_sp->fetchAll( $where );
				if( $saom instanceof Zend_Db_Table_Rowset)
				{
					$array = $saom->toArray();
                    $cronometros_incidentes[$chave]['saom'] = null;
                    if ($array) {
                        $cronometros_incidentes[$chave]['saom'] = $array[0];
                    }
				}
				else
				unset( $cronometros_incidentes[$chave] );
			}
				
			//constroi array do atendimento a ser assimilado no acompanhamento
			foreach( $cronometros_incidentes as $chave => $cronometro )
			{
				//print_b($cronometro,true);
				//calcula diferenca de datas
				$data_inicio = new DateTime( $cronometro['inicio_tarefa'] );
				if( !empty($cronometro['final_tarefa']) )
					$data_fim = new DateTime( $cronometro['final_tarefa'] );
				else
					$data_fim = new DateTime( "now" );
					
				//$intervalo = $data_fim->diff( $data_inicio );
				//$horas = ( $intervalo->days * 24 ) + $intervalo->h;
				//$intervalo_em_horas = (string)$horas.':'.(string)$intervalo->i.':'.(string)$intervalo->s;
				
				//echo $intervalo_em_horas;exit;
					
				//$array_atendimentos
				array_push( $this->array_atendimentos , array(
					'id' => $cronometro['incidente']['idincidentes'],
					'cell' => array(
						'idatendimento' => $cronometro['atend_vsat']['idatend_vsat'],
						'atendimento' => $cronometro['atend_vsat']['data'],
						'incidente' => $cronometro['incidente']['idincidentes'],
						'resposta_agilis' => ($cronometro['atend_vsat']['resposta_agilis']!='')?1:0,
						'vsat' => $cronometro['instalacao']['nome'],
						'tecnico' => $cronometro['usuario']['nome'],
						'idtecnico' => $cronometro['usuario']['idusuarios'],
						'perfil_usuario' => $cronometro['perfil_usuario']['perfil'],
						'idperfil_usuario' => $cronometro['perfil_usuario']['idperfis'],
						'empresa' => $cronometro['empresa_usuario']['empresa'],
						'fim_cronometro' => $cronometro['instalacao']['data_aceite'],
						'saom' => $cronometro['saom']['id_saom'],
						'tempo_vencimento' => '',//$intervalo_em_horas,
						'data_inicio' => $cronometro['inicio_tarefa'],
						'data_fim' => $cronometro['final_tarefa'],
						'tipo' => 'Incidente',
						'idinstalacoes' => $cronometro['instalacao']['idinstalacoes']
					)
				) );
			}
		}
		else
		$this->array_atendimentos = array();
	}

//---------------------------------------DADOS COMISSIONAMENTOS----------------------------------------------------------

	public function busca_comissionamentos()
	{
		$hoje = date('Y-m-d');
		$where = "
			(
				data_final_comiss IS NULL OR
				data_final_comiss = '0000-00-00 00:00:00' OR
				data_final_comiss = '' OR
				data_final_comiss LIKE '{$hoje}%'
			) AND
			(
				SELECT COUNT(*)
				FROM pausas
				WHERE
					tabela = 'os_sp' AND
					chaveextrangeira = instalacoes_sp.os_sp_idos AND
					(
						pausa_fim IS NULL OR
						pausa_fim = '0000-00-00 00:00:00'
					) 
			) = 0
		";
		$instalacoes = $this->Instalacao_sp->fetchAll( $where );


		$empresaId = $_SESSION['login']['empresas_idempresas'];
		$busca = "(empresas_idempresas = '$empresaId')";
		$osspId =  $this->OSSP->fetchAll($busca);


		if( $instalacoes instanceof Zend_Db_Table_Rowset)
		{
			$instalacoes = $instalacoes->toArray();


			foreach( $instalacoes as $chave => $instalacao )
			{
				$where = "idusuarios = '{$instalacao['create_user_comiss']}'";
				$usuario = $this->Usuarios_sp->fetchAll( $where );
				if( $usuario instanceof Zend_Db_Table_Rowset){
					$array = $usuario->toArray();
					$instalacoes[ $chave ]['usuario'] = null;
					if ($array) {
						$instalacoes[ $chave ]['usuario'] = $array[0];
					}
				}else
					$instalacoes[ $chave ]['usuario'] = array();
			}

			//busca perfil usuarios
			foreach( $instalacoes as $chave => $instalacao )
			{
//					foreach($osspId as $chave => $osspIds) {
//						if ($osspIds['idos'] == $instalacao['os_sp_idos']) {
				if( isset($instalacao['usuario']['perfis_idperfis'])){
					$where = "idperfis = '{$instalacao['usuario']['perfis_idperfis']}'";
					$perfil = $this->Perfil_sp->fetchAll( $where );
					if( $perfil instanceof Zend_Db_Table_Rowset){
						$array = $perfil->toArray();
						$instalacoes[ $chave ]['perfil_usuario'] = null;
						if ($array) {
							$instalacoes[ $chave ]['perfil_usuario'] = $array[0];

						}
					}else
						$instalacoes[ $chave ]['perfil_usuario'] = array();
				}
//						}
//					}

			}

			//busca perfil usuarios
			foreach( $instalacoes as $chave => $instalacao )
			{
				if( isset($instalacao['usuario']['empresas_idempresas'])){
					$where = "idempresas = '{$instalacao['usuario']['empresas_idempresas']}'";
					$empresa = $this->Empresa_sp->fetchAll( $where );
					if( $empresa instanceof Zend_Db_Table_Rowset )
					{
						$array = $empresa->toArray();
						$instalacoes[ $chave ]['empresa_usuario'] = null;
						if ($array) {
							$instalacoes[ $chave ]['empresa_usuario'] = $array[0];
						}
					}
					else
						$instalacoes[ $chave ]['empresa_usuario'] = array();
				}
			}


			//constroi array de comissionamentos
			if($_SESSION['login']['perfis_idperfis']==10){
				$osspId = $osspId->toArray();
				foreach( $instalacoes as $chave => $instalacao )
				{
					foreach($osspId as $chave => $osspIds) {
						if ($osspIds['idos'] == $instalacao['os_sp_idos']) {
							//calcula diferenca de datas
							$data_inicio = new DateTime( $instalacao['create_user_comiss_time'] );
							if( $instalacao['data_final_comiss'] != '' )
								$data_fim = new DateTime( $instalacao['data_final_comiss'] );
							else
								$data_fim = new DateTime( "now" );

							// filtros
							if($instalacao['dataComiss'] == '' || $instalacao['dataComiss'] == '0000-00-00 00:00:00' ||
								$instalacao['dataComiss'] == NULL ||empty($instalacao['dataComiss'])){
								if(	$instalacao['create_user_comiss_time'] == '' ||	$instalacao['create_user_comiss_time'] == '0000-00-00 00:00:00' ||
									$instalacao['create_user_comiss_time'] == NULL || empty($instalacao['create_user_comiss_time'])){
									unset( $instalacoes[ $chave ] );
									continue;
								}else
									$data_inicio = $instalacao['create_user_comiss_time'];
							}

//							var_dump($instalacao);
							array_push($this->array_comissionamentos, array(
								'id' => $instalacao['os_sp_idos'],
								'cell' => array(
									'idatendimento' => '',
									'atendimento' => '',
									'incidente' => '',
									'resposta_agilis' => '',
									'vsat' => $instalacao['nome'],
									'tecnico' => ( isset($instalacao['usuario']['nome']) )?$instalacao['usuario']['nome']:'',
									'idtecnico' => ( isset($instalacao['usuario']['idusuarios']) )?$instalacao['usuario']['idusuarios']:'',
									'perfil_usuario' => ( isset($instalacao['perfil_usuario']['perfil']) )?$instalacao['perfil_usuario']['perfil']:'',
									'idperfil_usuario' => ( isset($instalacao['perfil_usuario']['idperfis']) )?$instalacao['perfil_usuario']['idperfis']:'',
									'empresa' => ( isset($instalacao['empresa_usuario']['empresa']) )?$instalacao['empresa_usuario']['empresa']:'',
									'fim_cronometro' => $instalacao['data_aceite'],
									'saom' => $instalacao['saom'],
									'tempo_vencimento' => '',//$intervalo_em_horas,
									'data_inicio' => $instalacao['create_user_comiss_time'],
									'data_fim' => $instalacao['data_final_comiss'],
									'pausa' => $instalacao['data_pausa'],
									'tipo' => 'Comissionamento_sp',
									'idinstalacoes' => $instalacao['idinstalacoes_sp']
								)
							));

						}
					}
				}
			}else{
				foreach( $instalacoes as $chave => $instalacao ) {
					//calcula diferenca de datas
					$data_inicio = new DateTime($instalacao['create_user_comiss_time']);
					if ($instalacao['data_final_comiss'] != '')
						$data_fim = new DateTime($instalacao['data_final_comiss']);
					else
						$data_fim = new DateTime("now");

					// filtros
					if ($instalacao['dataComiss'] == '' || $instalacao['dataComiss'] == '0000-00-00 00:00:00' ||
						$instalacao['dataComiss'] == NULL || empty($instalacao['dataComiss'])
					) {
						if ($instalacao['create_user_comiss_time'] == '' || $instalacao['create_user_comiss_time'] == '0000-00-00 00:00:00' ||
							$instalacao['create_user_comiss_time'] == NULL || empty($instalacao['create_user_comiss_time'])
						) {
							unset($instalacoes[$chave]);
							continue;
						} else
							$data_inicio = $instalacao['create_user_comiss_time'];
					}

					array_push($this->array_comissionamentos, array(
						'id' => $instalacao['os_sp_idos'],
						'cell' => array(
							'idatendimento' => '',
							'atendimento' => '',
							'incidente' => '',
							'resposta_agilis' => '',
							'vsat' => $instalacao['nome'],
							'tecnico' => (isset($instalacao['usuario']['nome'])) ? $instalacao['usuario']['nome'] : '',
							'idtecnico' => (isset($instalacao['usuario']['idusuarios'])) ? $instalacao['usuario']['idusuarios'] : '',
							'perfil_usuario' => (isset($instalacao['perfil_usuario']['perfil'])) ? $instalacao['perfil_usuario']['perfil'] : '',
							'idperfil_usuario' => (isset($instalacao['perfil_usuario']['idperfis'])) ? $instalacao['perfil_usuario']['idperfis'] : '',
							'empresa' => (isset($instalacao['empresa_usuario']['empresa'])) ? $instalacao['empresa_usuario']['empresa'] : '',
							'fim_cronometro' => $instalacao['data_aceite'],
							'saom' => $instalacao['saom'],
							'tempo_vencimento' => '',//$intervalo_em_horas,
							'data_inicio' => $instalacao['create_user_comiss_time'],
							'data_fim' => $instalacao['data_final_comiss'],
							'pausa' => $instalacao['data_pausa'],
							'tipo' => 'Comissionamento_sp',
							'idinstalacoes' => $instalacao['idinstalacoes_sp']
						)
					));
				}
			}
		}
		else
			$this->array_comissionamentos = array();
	}


	public function aplica_horas_formato_normal( $intervalo_em_horas )
	{
		$seg = $intervalo_em_horas;
		//echo $seg;exit;
		
		$minutos = $seg/60;
		$minutos = explode('.',$minutos);
		$minutos = $minutos[0];
		//echo $minutos;exit;
		
		$horas = $minutos/60;
		$horas = explode('.',$horas);
		$horas = $horas[0];
		//echo $horas;exit;
		
		//echo $seg.' - '.( $minutos * 60 );exit;
		
		$seg_resto = $seg - ( $minutos * 60 );
		$min_resto = $minutos - ( $horas * 60 );
		
		return $horas.':'.$min_resto.':'.$seg_resto;
	}

}

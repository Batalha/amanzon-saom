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

include_once realpath(dirname(__FILE__) . '/../model/') . '/SaomModel.php';

include_once realpath(dirname(__FILE__) . '/../model/') . '/DBIncidente.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBInstalacao.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBIncidenteArquivado.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBAtendVsat.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBUsuario.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBModel.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBStatus_atend.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBCronometro.php';
include_once realpath(dirname(__FILE__) . '/../model/') . '/DBCronometro_interrupcao.php';
include_once realpath(dirname(__FILE__)) . '/Cronometro.php';
include_once realpath(dirname(__FILE__) . '/../helpers/') . '/Utilitarios.php';

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
class Incidente extends Controller implements IncidenteInterface 
{

	protected $tplDir = 'incidente';

	protected $idincidentes;

	//itens relacioados a pausa de incidente
	protected $pausaAtiva = 'nao';
	
	// atributos
	protected $idprodemge;
	protected $descricao;
	protected $data;
	protected $prioridade;
	protected $instalacoes_idinstalacoes;
	protected $atend_vsat_idatend_vsat;
	protected $tecnicoNoc;
	protected $saom;
	protected $linha_zend;
	
	protected $tempoTranscorrido;

	function __construct()
	{
		parent::__construct();
		$this->DB = new DBIncidente();
		$this->DBCronometro = new DBCronometro();
		$this->CronometroController = new Cronometro();
		$this->DBUsuarios = new DBUsuario();
		$this->DBAtend_vsat = new DBAtendVsat();
		$this->DBInstalacao = new DBInstalacao();
		$this->sistema = new Sistema();

		$this->smarty->assign('login',$_SESSION['login']);
	}
	
	
	public function create()
	{
		if (empty($this->dadosP['form'])) //formulario
		{
			//LISTA DE TECNICOS
			$this->DBUsuarios->setOrderBy('nome');
			$this->DBUsuarios->setDefaultOrder('ASC');
			$listaUsuarios = $this->DBUsuarios->liste('incidentes = 1 and ativacao = 1');

//			echo die_json($listaUsuarios);

			//LISTA DE INSTALACOES
			$this->DBInstalacao->setSelect('idinstalacoes, nome');
			$listaInstalacoes = $this->DBInstalacao->liste();

			//LISTA DO AUTOCOMPLETE
			$listaautocomplete = array();
			for($i=0;$i<count($listaInstalacoes);$i++)
			$listaautocomplete[] = $listaInstalacoes[$i]['nome'];
			$listaautocomplete = implode(',',$listaautocomplete);

			$xml = $this->sistema->local();

			//trata identificador default
			$id_prodemge = (LOCAL == 'SAOM_SP')?'SP'.date('YmdHis').$_SESSION['login']['idusuarios']:'';

			if( ! empty($this->dadosP['param']))
			$this->smarty->assign('param',$this->dadosP['param']);
			$this->smarty->assign('xml',$xml);
			$this->smarty->assign('local',LOCAL);
			$this->smarty->assign('id_prodemge',$id_prodemge);
			$this->smarty->assign('listaUsuarios',$listaUsuarios);
			$this->smarty->assign('idperfil',$_SESSION['login']['perfis_idperfis']);
			$this->smarty->assign('listaInstalacoes',$listaInstalacoes);
			$this->smarty->assign('listaautocomplete',$listaautocomplete);
			$this->smarty->display("{$this->tplDir}/create.tpl");
		}
		else //envio do formulario
		{
			//print_b($this->dadosP['form'],true);

			$sql = "
				SELECT idinstalacoes 
				FROM instalacoes 
				WHERE nome = '{$this->dadosP['form']['nome_instalacao']}';
			";
			$idinstalacao = $this->DB->queryDados($sql);
			if(!$idinstalacao )
			{
				$arrReturn['msg'] = 'Erro! Vsat Nao esta na lista.';
				die_json($arrReturn);
			}

			//busca saom
			$saom = new SaomModel( $this->adapter->getAdapterZend() );
			$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
			$this->dadosP['form']['saom'] = $saom_row->id_saom;
			
			//cria atendimento
			$DBAtend = new DBAtendVsat();
			$form = array();
			$form['data'] = date("Y-m-d H:i:s");
			$form['atendimento'] =  'Atendimento iniciado por '.$_SESSION['login']['nome']." as ".date("H:i")." de ".date("d/m/Y");
			$form['status_atend_idstatus_atend'] = 1;
			$form['instalacoes_idinstalacoes'] = $idinstalacao[0]['idinstalacoes'];
			$form['tipo_atendimento_idtipo_atendimento'] = 1;//default
			$form['saom'] = $saom_row->id_saom;
			
			$form['usuarios_idusuarios'] = $this->dadosP['form']['tecnicoNoc'];
			
			//registra atendimento
			if( $_SESSION['SAOM'] != 'SP' )
			{
				//$criaAtend = $DBAtend->create($form);
				$criaAtend = $this->Atendimento->insert( $form ); // TODO: tarefa da model
				//echo "teste: ".$criaAtend;exit;
				if( $criaAtend == false )
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg'] = 'Erro ao registrar atendimento.';
					die_json($arrReturn);
				}
				else
				{
					$sql = "
	            			INSERT INTO cronometro (idreferencia, inicio_tarefa, tabelareferencia) 
	            			VALUES ('{$criaAtend}', '".date('Y-m-d H:i:s')."','atend_vsat')
	            		";
					if(!$this->DB->query($sql))
					{
						$arrReturn['status'] = 'erro';
						$arrReturn['msg']    = 'Erro: cronometro para atendimento nÃ£o gerado.';
						die_json($arrReturn);
					}
				}

				$this->dadosP['form']['atend_vsat_idatend_vsat'] = $DBAtend->getLastId();
			}
			
			//---------Nova Açao Id da Prodemge ---------------------
				
			$numProdemge = $this->dadosP['form']['idprodemge'];
			
			
			if ($numProdemge) {
			
				$numeroProdemge = $this->cadastrarNumeroProdemge($numProdemge);
				
				if ($numeroProdemge) {
						
					$sql = "
					SELECT idprodemge
					FROM prodemge
					WHERE numero_prodemge = '{$this->dadosP['form']['idprodemge']}'
					";
					$idprodemge = $this->DB->queryDados($sql);
					$this->dadosP['form']['idprodemge'] = $idprodemge[0]['idprodemge'];
			
				}else{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg']    = 'Esse ID Prodemge ja existe.';
					die_json($arrReturn);
									
				}
			}
			//---------Nova Açao Id da Prodemge ---------------------

			if($this->dadosP['form']['nome_instalacao']!='')
			{
				$sql = "
	            		SELECT idinstalacoes
	            		FROM instalacoes 
	            		WHERE nome = '{$this->dadosP['form']['nome_instalacao']}'
	            	";
				$idinstalacao = $this->DB->queryDados($sql);

				$this->dadosP['form']['instalacoes_idinstalacoes'] = $idinstalacao[0]['idinstalacoes'];
			}
			
			$this->dadosP['form']['data_modificacao'] = date('Y-m-d H:i:s');
			$this->dadosP['form']['data'] = $this->Helpers->data_br_us( $this->dadosP['form']['data'] );
			unset($this->dadosP['form']['nome_instalacao']);
			if( !$return = $this->Incidentes->insert($this->dadosP['form']) )
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = "Houve um erro ao inserir Incidente.";
			}
			else
			{
				//atualiza idincidentes em atendimento criado
				$sql = "
            		UPDATE atend_vsat 
            		SET incidentes_idincidentes = '{$return}' 
            		WHERE idatend_vsat = '{$criaAtend}'
            	";
				if(!$this->DBPadrao->query($sql))
				{
					$arrReturn['status'] = 'erro';
					$arrReturn['msg']    = 'Erro ao atualizar incidente em atendimento.';
					die_json($arrReturn);
				}
				
				// registra incidente novo em infoincidentes
				$this->CacheIncidentesModel->insereNovoIncidente();
				
				// insere associacao com instalacao
				$sql = "
					INSERT INTO associacao_instalacao_incidente ( idinstalacoes , idincidentes, idprodemge )
					VALUES ( '{$this->dadosP['form']['instalacoes_idinstalacoes']}' , '{$return}', {$this->dadosP['form']['idprodemge']} )
				";
				$this->DBPadrao->query($sql);
				$idassociacao = $this->DBPadrao->getLastId();
				
				// insere telefonemas
				$telefonemas = $this->insereTelefonemas( $idassociacao );
					
				//Envio de Email para NOC
				//carrega nome da instalacao
					//$instalacao = new DBInstalacao();
					//$instalacao->setPrkValue($this->dadosP['form']['instalacoes_idinstalacoes']);
				$this->Instalacao->setidinstalacoes( $this->dadosP['form']['instalacoes_idinstalacoes'] );
				$this->Instalacao->getInstalacao();
				
				
// 				$this->Prodemge->getProdemge();

				
					//$instalacaoDados = $instalacao->view();
				$instalacaoDados = $this->Instalacao->getinstalacaoArray();
				$descricao = nl2br($this->dadosP['form']['descricao']);
				$assunto = 'Cadastro de Incidente - InstalaÃ§Ã£o:'.$instalacaoDados['nome'];
					
				$msg = 'Incidente criado para Instalação '.$instalacaoDados['nome'].'<br/>';
				$msg .= 'Data de criação: '.date("Y-m-d H:i:s").'<br/>';
				$msg .= 'UsuÃ¡rio: '.$_SESSION['login']['nome'].'<br/>';
				$msg .= 'Técnico NOC responsÃ¡vel: '.$this->dadosP['form']['tecnicoNoc'].'<br/>';
				$msg .= 'Descrição: '.$descricao.'<br/>';
				$msg .= 'Prioridade: '.$this->dadosP['form']['prioridade'].'<br/>';
					
				$emailNoc = sendMailIncidente($assunto,$msg);
				//Envio de Email para NOC - fim

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
			FROM prodemge
			WHERE numero_prodemge = '{$idProdemge}'
			";
		if ($this->DB->queryDados($sql)) {
			return false;
		}else{
			$sql = "INSERT INTO prodemge(numero_prodemge)
			value('{$idProdemge}')";
		
			if($this->DBPadrao->query($sql))	
				return true;
		}
	}
	
	public function cadastrarNumeroVsat($numVsat){
		$sql = "
		SELECT idinstalacoes
		FROM instalacoes
		WHERE nome = '{$numVsat}';";

		if($this->DB->queryDados($sql) ){
			return true;
		}else{
			return false;
		}
	}

	public function  excluirNumeroProdemge($idprodemge){
		
// 		$sql = "SELECT idprodemge 
// 				FROM associacao_instalacao_incidente
// 				WHERE idinstalacoes = '{$idinstalacao}'	AND idincidentes = '{$idincidente}'";
		
// 		$idprodemge = $this->DB->queryDados($sql);
		
// 		$sql1 = "DELETE FROM prodemge WHERE idprodemge = '{$idprodemge[0]['idprodemge']}' ";
		$sql1 = "DELETE FROM prodemge WHERE idprodemge = '{$idprodemge}' ";
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
			INSERT INTO telefonemas_para_incidentes 
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
		if( isset($this->dadosP['so_conteudo']) && $this->dadosP['so_conteudo'] )
			$this->smarty->display("{$this->tplDir}/list_so_conteudo.tpl");
		else
			$this->smarty->display("{$this->tplDir}/list.tpl");

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
		
		// trabalha a requisicao no db
		$dados = $this->recebeQueryPadrao( $query );
		
		$pageStart = ($page==1)?0:$rp*($page-1);
		$limitSql = "limit $pageStart, $rp";

		//$listaBuscada = $this->buscaListaFonteDados( $dados , $page , $rp , $sortname , $sortorder , " LIMIT 0 , 20 " );
		/*
		if( 
			$this->CacheIncidentesModel->verificaCache( $page ) // verifica existencia do arquivo cache
			&& $this->CacheIncidentesModel->verificaExistenciaCacheData( $page) // verifica existencia da data do cache
			&& $this->CacheIncidentesModel->resgataDataCache( $page ) > $this->Incidentes->buscaMaiorDataAlteracao( $limitSql ) // verifica ultima data de modificacao e compara com a data do cache
			&& !$this->CacheIncidentesModel->verificaExistenciaDeIncidentesCriados( $page ) // verifica existencia de incidentes novos
			&& ( !isset( $_GET['teste'] ) ) // para acesso externo de testes
		) {
			$dataJson = $this->CacheIncidentesModel->restagaCache( $page );
			echo $dataJson;
			return;
		}
		 */
		$listaBuscada = $this->buscaListaFonteDados( $dados , $page , $rp , $sortname , $sortorder , $limitSql );

		$listaBuscadaNumeroResultados = $this->buscaListaFonteDados( $dados , '' , '' , $sortname , $sortorder , '' );

		foreach( $listaBuscada AS $row )
		{
			//echo json_encode($row);exit;
			$row['associacao'] = $row['idassociacao'];
			if( strlen($row['descricao']) > 100 )
				$row['descricao'] = substr( strip_tags( $row['descricao'] ) , 0 , 100 ) . '...';
				
			$data['rows'][] = array(
				'id' => $row['idincidentes'],
				'cell' => array(
					$row['idincidentes'],
					$row['nome_instalacao'],
					$row['data'],
					$row['prioridade'],
					$row['descricao'],
					($row['status']=='Finalizado')?$row['data_final']:'-',
					$row['ultimoAtendimento'],
					$row['numero_prodemge'],
					$row['status'],
					$row['nomeTecnico'],
					$row['telefonemas_info'],
					$row['associacao']
				)
			);
		}
		$data['page'] = $page;
		$data['total'] = $listaBuscadaNumeroResultados[0]['total'];

		$dataJson = json_encode($data);

		$escritaCache = $this->CacheIncidentesModel->escreveCache( $dataJson , $page );

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

		//echo json_encode($query);exit;
		$dados = $this->recebeQueryPadrao( $query );
		
		$listaBuscada = $this->buscaListaFonteDados( $dados , $page , $rp , $sortname , $sortorder , " LIMIT 0 , 20 " );
		
		$listaBuscadaNumeroResultados = $this->buscaListaFonteDados( $dados , '' , '' , $sortname , $sortorder , '' );
		
		//echo json_encode($listaBuscada[0]['listaAssociacoesIncidentes'][0]['idincidentes']);exit;
		
		foreach( $listaBuscada AS $row )
		{
			//echo json_encode($row['cronometro']);exit;
			$row['associacao'] = $row['idassociacao'];
			if( strlen($row['descricao']) > 100 )
				$row['descricao'] = substr( strip_tags( $row['descricao'] ) , 0 , 100 ).'...';
			
			$data['rows'][] = array(
				'id' => $row['idincidentes'],
				'cell' => array(
					$row['idincidentes'],
					$row['nome_instalacao'],
					$row['data'],
					$row['prioridade'],
					$row['descricao'],
					($row['status']=='Finalizado')?$row['data_final']:'-',
					$row['ultimoAtendimento'],
					$row['numero_prodemge'],
					$row['status'],
					$row['nomeTecnico'],
					$row['telefonemas_info'],
					$row['associacao']
				)
			);
		}
//		print_b($data,true);
//		echo die_json($data);
		
		$data['page'] = $page;
		$data['total'] = $listaBuscadaNumeroResultados[0]['total']; 

		echo json_encode($data);
	}
	
	// TODO: fazer metodos padrao nas models proprias
	private function buscaListaFonteDados($dados, $numeroPagina, $numeroPorPagina, $sortname, $sortorder, $limit_condition) {
		// busca instalacoes com incidente
		$sql = 'SELECT COUNT(*) AS total 
    			FROM incidentes inci 
                INNER JOIN associacao_instalacao_incidente a ON (
                	a.idincidentes = inci.idincidentes
                )
                INNER JOIN instalacoes i ON (
                	a.idincidentes = inci.idincidentes AND
                	a.idinstalacoes = i.idinstalacoes
                )
				INNER JOIN prodemge p ON (
					a.idincidentes 	= inci.idincidentes AND
                  	a.idprodemge 	= p.idprodemge
                )
                    INNER JOIN atend_vsat av ON (
						av.incidentes_idincidentes 	= inci.idincidentes
                    )
                    INNER JOIN status_atend st ON (
						av.incidentes_idincidentes 	= inci.idincidentes AND
						av.status_atend_idstatus_atend 	= st.idstatus_atend
                    )
				    INNER JOIN usuarios u ON (
						inci.tecnicoNoc = u.idusuarios
                    )
		        WHERE 1 = 1 ' . PHP_EOL;



		if(!empty($limit_condition)) {
			$sql = 'SELECT 
                    	inci.idincidentes as idincidentes,
                    	i.idinstalacoes as idinstalacoes,
                    	i.nome as nome_instalacao,
                    	a.idassociacao_instalacao_incidente as idassociacao,
                    	inci.tecnicoNoc as tecnicoNoc,
                    	inci.data as data,
                    	inci.prioridade as prioridade,
                    	inci.descricao as descricao,
                    	p.idprodemge as idprodemge,
                    	p.numero_prodemge as numero_prodemge,
						st.idstatus_atend as idstatus,
						st.status as status,
						u.idusuarios as idusuarios,
						u.nome as nomeTecnico
					
                    FROM incidentes inci
                    INNER JOIN associacao_instalacao_incidente a ON (
                    	a.idincidentes = inci.idincidentes
                    )
                    INNER JOIN instalacoes i ON (
                    	a.idincidentes = inci.idincidentes AND
                    	a.idinstalacoes = i.idinstalacoes
                    )
                    INNER JOIN prodemge p ON (
						a.idincidentes 	= inci.idincidentes AND
                    	a.idprodemge 	= p.idprodemge
                    )
                    INNER JOIN atend_vsat av ON (
						av.incidentes_idincidentes 	= inci.idincidentes
                    )
                  	INNER JOIN status_atend st ON (
						av.incidentes_idincidentes 	= inci.idincidentes AND
						av.status_atend_idstatus_atend 	= st.idstatus_atend
                    )
                    INNER JOIN usuarios u ON (
						inci.tecnicoNoc = u.idusuarios
                    )
			        WHERE 1 = 1 ' . PHP_EOL;
		}
//		var_dump(die_json($sql));
		
		// ----- buscas

		
		// saom
		if ($_SESSION['SAOM'] == 'SP') {
		    $sql .= ' AND saom = 2 ' . PHP_EOL; //ajusta pada o id do saom
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
		
		if (isset($dados['numero_prodemge'])) {
		    $sql .= " AND p.numero_prodemge LIKE '%{$dados['numero_prodemge']}%'" . PHP_EOL;
		}
		if (isset($dados['status'])) {
		    $sql .= " AND st.status LIKE '%{$dados['status']}%'" . PHP_EOL;
		}
		if (isset($dados['nomeTecnico'])) {
		    $sql .= " AND u.nome LIKE '%{$dados['nomeTecnico']}%'" . PHP_EOL;
		}
			
		// ---- busca data
		if (isset($dados['data'])) {
		    $sql .= " AND data LIKE '%{$dados['data']}%'" . PHP_EOL;
		}
		
		// ordenaÃ§Ã£o
		if (!empty($sortname) && !empty($sortorder)) {
		    $sortOptions = array(
			'idincidentes'    => 'inci.idincidentes',
			'idinstalacoes'   => 'i.idinstalacoes',
			'nome_instalacao' => 'i.nome',
			'idassociacao'    => 'a.idassociacao_instalacao_incidente',
			'data'            => 'inci.data',
			'prioridade'      => 'inci.prioridade',
			'descricao'       => 'inci.descricao',
			'numero_prodemge' => 'p.numero_prodemge',
			'status'		  => 'st.status',
			'nomeTecnico'      => 'u.nome',
		    );
		    $sql .= ' ORDER BY ' . $sortOptions[$sortname] . ' ' . $sortorder . PHP_EOL;
		}
		
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
		
// 		$buscaStatus = '';
// 		if (isset($dados['status'])) {
// 		    $buscaStatus = $dados['status'] . PHP_EOL;
// 		}
		
// 		$buscaNomeTecnico = '';
// 		if (isset($dados['nomeTecnico'])) {
// 		    $buscaNomeTecnico = $dados['nomeTecnico'] . PHP_EOL;
// 		}
//		echo '<pre>';
//		print_r($dados);
//		echo '</pre>';

		$listaIncidentes = $this->Incidentes->executaSql( $sql );
		//$listaIncidentes = $this->DBPadrao->queryDados( $sql );


		if (empty($limit_condition)) {
			return $listaIncidentes;
		}

		// busca incidentes das instalacoes encontradas
		foreach ( $listaIncidentes as $chave => $incidente )
		{
			$idIncidente = new Integer( $incidente['idincidentes'] );
//			echo die_json($idIncidente);

			// busca ultimo atendimento
				$atendimento = $this->Atendimento->getUltimoAtendimentoDeIncidente( $idIncidente );



				if( $buscaAtendimento != '' ) {
					if (strstr($atendimento[0]['atendimento'], $buscaAtendimento)){
						$listaIncidentes[$chave]['ultimoAtendimento'] = $atendimento['atendimento'];
					}else{
						unset($listaIncidentes[ $chave ]);continue;
					}
				}else{

					$listaIncidentes[ $chave ]['ultimoAtendimento'] = $atendimento['atendimento'];
				}

				//echo json_encode($atendimento['cronometro']['final_tarefa']);exit;
			
			// busca cronometro do ultimo atendimento
				if( isset($atendimento['cronometro']['final_tarefa']) )
				{
					if(
						$atendimento['cronometro']['final_tarefa'] == '' ||
						$atendimento['cronometro']['final_tarefa'] == '0000-00-00 00:00:00' ||
						$atendimento['cronometro']['final_tarefa'] == NULL
					)
						$listaIncidentes[ $chave ]['data_final'] = '-';
					else
						$listaIncidentes[ $chave ]['data_final'] = $atendimento['cronometro']['final_tarefa'];
				}
				else
					$listaIncidentes[ $chave ]['data_final'] = '';
			
			// busca status incidente
				//print_b($this->Atendimento,true);
				$this->Incidentes->aplicaStatusIncidente( $this->Atendimento );
				//echo json_encode($this->Incidentes->getstatusIncidente());exit;
				$listaIncidentes[ $chave ]['status'] = $this->Incidentes->getstatusIncidente();
// 				if( $buscaStatus != '' )
// 				{
// 					if( !strstr( $this->Incidentes->getstatusIncidente() , $buscaStatus ) )
// 					{
// 						unset($listaIncidentes[ $chave ]);continue;
// 					}
// 				}
				
			// 
				
			// busca usuario tecnicoNoc
				$idusuarios = new Integer( $incidente['tecnicoNoc'] );
				$this->Usuarios->setidusuarios( $idusuarios );
				$this->Usuarios->getUsuario();
				if( $this->Usuarios->getnome() != '' )
					$listaIncidentes[ $chave ]['nomeTecnico'] = $this->Usuarios->getnome();
				else
					$listaIncidentes[ $chave ]['nomeTecnico'] = '';
// 				if( $buscaNomeTecnico != '' )
// 				{
// 					if( !strstr( $listaIncidentes[ $chave ]['nomeTecnico'] , $buscaNomeTecnico ) )
// 					{
// 						unset($listaIncidentes[ $chave ]);continue;
// 					}
// 				}
				
			//if($incidente['idincidentes']==1930){exit('teste');}
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
			//echo json_encode($array);exit;
		}
		else
			$array = array();
		
		return $array;
	}
	
	private function buscaTelefonemas( $idassociacao )
	{
		$this->TelefonemasParaIncidentes->zeraObjeto();
		
		// telefonema 1
			//echo json_encode($idIncidente->numero());exit;
			$this->TelefonemasParaIncidentes->setidassociacao_instalacao_incidente( $idassociacao );
			$this->TelefonemasParaIncidentes->setorder_telefonema( 1 );
			$this->TelefonemasParaIncidentes->getTelefonemasParaIncidentesPeloIncidenteEOrdem();
			//print_b($this->TelefonemasParaIncidentes);
			//echo json_encode($this->TelefonemasParaIncidentes->gettelefonemasParaIncidentesArray());exit;
			
			$telefonemas = "telefonema1:".$this->TelefonemasParaIncidentes->getdata_criacao().'|'.$this->TelefonemasParaIncidentes->getdata_finalizacao().'|'.$this->TelefonemasParaIncidentes->getprazo().';';
			
		// telefonema 2
			//echo json_encode($idassociacao);exit;
			$this->TelefonemasParaIncidentes->setidassociacao_instalacao_incidente( $idassociacao );
			$this->TelefonemasParaIncidentes->setorder_telefonema( 2 );
			$this->TelefonemasParaIncidentes->getTelefonemasParaIncidentesPeloIncidenteEOrdem();
			//echo json_encode($this->TelefonemasParaIncidentes->gettelefonemasParaIncidentesArray());exit;
			
			$telefonemas .= 'telefonema2:'.$this->TelefonemasParaIncidentes->getdata_criacao().'|'.$this->TelefonemasParaIncidentes->getdata_finalizacao().'|'.$this->TelefonemasParaIncidentes->getprazo().';';
			
		// telefonema 3
			//echo json_encode($idassociacao);exit;
			$this->TelefonemasParaIncidentes->setidassociacao_instalacao_incidente( $idassociacao );
			$this->TelefonemasParaIncidentes->setorder_telefonema( 3 );
			$this->TelefonemasParaIncidentes->getTelefonemasParaIncidentesPeloIncidenteEOrdem();
			//echo json_encode($this->TelefonemasParaIncidentes->gettelefonemasParaIncidentesArray());exit;
			
			$telefonemas .= 'telefonema3:'.$this->TelefonemasParaIncidentes->getdata_criacao().'|'.$this->TelefonemasParaIncidentes->getdata_finalizacao().'|'.$this->TelefonemasParaIncidentes->getprazo();
				
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
		
		$cronometro = $this->trataDateFromatCronometro( $cronometro );
		
		//tratamento sem lugar
		$incidente = $this->Incidentes->getincidenteArray();
		$incidente['data'] =  $this->Helpers->data_us_br($incidente['data']);
		
		$this->incidenteFacade = array(
			'tecnicoResponsavel' => $this->Usuarios->getUsuarioArray(),
			'cronometro' => $cronometro,
			'status' => $this->Incidentes->getstatusIncidente(),
			'tempoTranscorrido' => $this->tempoTranscorrido,
			'obj' => $incidente
		);
	}
	
	public function view()
	{
		if ( empty($this->dadosP['param']) )
			exit('Id do incidente nÃ£o encontrado.');
		
		$this->incidenteFacade( $this->dadosP['param'] );
		//print_b( $this->incidenteFacade['obj']['idincidentes'] , true );
		
		$idincidentes = new Integer( $this->incidenteFacade['obj']['idincidentes'] );
		$ultimoAtendimento = $this->Atendimento->getUltimoAtendimentoDeIncidente( $idincidentes );
		
		$ultimoAtendimento['atendimento'] = nl2br($ultimoAtendimento['atendimento']);
		
		$this->smarty->assign( 'atendimento' , $ultimoAtendimento );
		$this->smarty->assign( 'tecnicoResponsavel' , $this->incidenteFacade['tecnicoResponsavel'] );
		$this->smarty->assign( 'cronometro' , $this->incidenteFacade['cronometro'] );
		$this->smarty->assign( 'status' , $this->incidenteFacade['status'] );
		$this->smarty->assign( 'tempoTranscorrido' , $this->incidenteFacade['tempoTranscorrido'] );
		$this->smarty->assign( 'obj' , $this->incidenteFacade['obj'] );
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
	
	// mÃ©todo feito para php 5.3 adiante
	private function resolveTempoTranscorrido( $cronometro )
	{
		$dataInicial = ( 
			!empty($cronometro['inicio_tarefa']) && 
			$cronometro['inicio_tarefa'] != '0000-00-00 00:00:00' 
		)? new  DateTime( $cronometro['inicio_tarefa'] ) : '' ;
		$dataFinal = ( 
			!empty($cronometro['final_tarefa']) && 
			$cronometro['final_tarefa'] != '0000-00-00 00:00:00' 
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
			$tempoIntervalo = 'Sem cronÃ´metro';
		}
		$this->tempoTranscorrido = $tempoIntervaloDia.'d '. $tempoIntervalo;
	}
	
	private function getDatasCronometroIncidente( Integer $idincidente )
	{
		$ultimoAtendimento = $this->Atendimento->getUltimoAtendimentoDeIncidente( $idincidente );
		$this->Cronometro->setidreferencia( $ultimoAtendimento['idatend_vsat'] );
		$this->Cronometro->settabelareferencia( 'atend_vsat' );
		$cronometroDeUltimoAtendimento = $this->Cronometro->getCronometrosDeAtendimento();
		//print_b($cronometroDeUltimoAtendimento,true);
		
		$primeiroAtendimento = $this->Atendimento->getPrimeiroAtendimentoDeIncidente( $idincidente );
		$this->Cronometro->setidreferencia( $primeiroAtendimento['idatend_vsat'] );
		$this->Cronometro->settabelareferencia( 'atend_vsat' );
		$cronometroDePrimeiroAtendimento = $this->Cronometro->getCronometrosDeAtendimento();
		//print_b($cronometroDePrimeiroAtendimento,true);
		
		//$cronometroAtendimento
		$dataFinalCronometro = ( $cronometroDeUltimoAtendimento['final_tarefa'] != '' )? $cronometroDeUltimoAtendimento['final_tarefa'] : '' ;
		$dataInicioCronometro = ( $cronometroDePrimeiroAtendimento['inicio_tarefa'] != '' )? $cronometroDePrimeiroAtendimento['inicio_tarefa'] : '' ;
		return array(
			'final_tarefa' => $dataFinalCronometro,
			'inicio_tarefa' => $dataInicioCronometro
		);
	}
	
	private function getObjetosView( Integer $idIncidente )
	{
		$this->Incidentes->setidincidentes( $idIncidente );
		$this->Incidentes->getIncidente();
		
		$idusuario = new Integer( $this->Incidentes->gettecnicoNoc() );
		$this->Usuarios->setIdusuarios( $idusuario );
		$this->Usuarios->getUsuario();
		
		$this->Cronometro->setidreferencia( $idIncidente->numero() );
		$this->Cronometro->settabelareferencia( 'incidentes' );
		$this->Cronometro->getCronometroPelaReferencia();
	}

	private function resolveStatus()
	{
		$idincidente = new Integer( $this->Incidentes->getidincidentes() );
		$this->Atendimento->getAtendimentosDeIncidente( $idincidente );
		$this->Atendimento->getStatusAtendimentos();
		$this->Incidentes->aplicaStatusIncidente( $this->Atendimento );
	}

	public function edit()
	{
		if ( empty($this->dadosP['param']) )
			exit('Id do incidente nÃ£o encontrado.');
		
		$this->incidenteFacade( $this->dadosP['param'] );
		
		$this->Usuarios->getListaUsuariosIncidente();
		$this->incidenteFacade['obj']['prioridade'] = utf8_decode($this->incidenteFacade['obj']['prioridade']);
		$this->smarty->assign( 'data_fim' , $this->incidenteFacade['cronometro']['final_tarefa'] );
		$this->smarty->assign( 'listaUsuarios' , $this->Usuarios->getlistaUsuarios() );
		$this->smarty->assign( 'obj' , $this->incidenteFacade['obj'] );
		$this->smarty->display( "{$this->tplDir}/edit.tpl" );
	}

	public function update()
	{
		if ( ! empty($this->dadosP['form']) )
		{
			$form = $this->dadosP['form'];
			
			$idincidente = new Integer( $form['idincidentes'] );
			
			$this->updateIncidentes( $idincidente , $form );
			
			if( isset($form['data_fim']) && $form['data_fim'] != '' )
				$this->updateCronometro( $idincidente , $form );
			
			$resposta = $this->respostaUpdate( $this->Incidentes->edit() , $this->Cronometro->edit() );
			
			exit($resposta);
		}
		else
			exit("Nenhum formulÃ¡rio presente.");
	}
	
	private function updateIncidentes( Integer $idincidente , Array $form )
	{
		$this->Incidentes->setidincidentes( $idincidente );
		$this->Incidentes->setdata( $this->Helpers->data_br_us( $form['data'] ) );
		$this->Incidentes->setidprodemge( $form['idprodemge'] );
		$this->Incidentes->setdescricao( $form['descricao'] );
		$this->Incidentes->setprioridade( $form['prioridade'] );
		$this->Incidentes->settecnicoNoc( $form['tecnicoNoc'] );
		$this->Incidentes->setsaom( $form['saom'] );
	}
	
	private function updateCronometro( Integer $idincidente , Array $form )
	{
		$this->Atendimento->getAtendimentosDeIncidente( $idincidente );
		$this->Cronometro->getUltimoCronometroAtendimento( $this->Atendimento );
		$cronometrosAtendimentos = $this->Cronometro->getCronometrosAtendimentos();
		foreach( $cronometrosAtendimentos as $chave => $cronometroAtendimento ){
			$idcronometro = new Integer( $cronometroAtendimento['ultimo']['idcronometro'] );break;
		}
		$this->Cronometro->setidcronometro( $idcronometro );
		$this->Cronometro->getCronometro();
		$this->Cronometro->setfinal_tarefa( $this->Helpers->data_br_us_com_hora($form['data_fim']) );
	}
	
	private function respostaUpdate( $respostaIncidente , $respostaCronoemtroDeAtendimento )
	{
		if( $respostaIncidente == 'ok' || $respostaCronoemtroDeAtendimento == 'ok' )
			$this->CacheIncidentesModel->atualizaData();
		
		if( $respostaIncidente == 'ok' && $respostaCronoemtroDeAtendimento == 'ok' )
			return "Incidente editado com sucesso.";
		else if( $respostaIncidente == 'ok' && $respostaCronoemtroDeAtendimento == 'erro' )
			return "Incidente editado porÃ©m nÃ£o houve modificaÃ§Ã£o na Data Final.";
		else if( $respostaIncidente == 'erro' && $respostaCronoemtroDeAtendimento == 'ok' )
			return "Apenas a Data Final foi editada.";
		else
			return "NÃ£o houve modificaÃ§Ã£o em Incidente.";
	}
	
	public function formularioComListaDeInstalacoes()
	{
		$listaInstalacoes = $this->Instalacao->fetchAll()->toArray();
		
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

		if ($dados['numProdemge'] && $dados['nomeInstalacao']) {

			var_dump($dados['numProdemge']);

		    if($this->cadastrarNumeroVsat($dados['nomeInstalacao']) == false){
				echo 6;exit;
		   }else if ($this->cadastrarNumeroProdemge($dados['numProdemge'])== false){
		   		echo 4; exit;
		   				   	
		   }else{
				$this->Instalacao->getInstalacaoPeloNome( $dados['nomeInstalacao'] );
				$this->Prodemge->getProdemgePeloNome($dados['numProdemge']);
				
				
				$idincidentesInteger = new Integer( $dados['idIncidente'] );
				$this->Incidentes->setidincidentes( $idincidentesInteger );
				$this->Incidentes->getIncidente();
				
				if( $this->AssociacaoInstalacaoIncidente->getAssociacaoPelaInstalacaoEPeloIncidente( $this->Instalacao , $this->Incidentes, $this->Prodemge ) )
				{
					echo 1;exit;
				}
				
				$this->AssociacaoInstalacaoIncidente->setidinstalacoes( $this->Instalacao->getidinstalacoes() );
				$this->AssociacaoInstalacaoIncidente->setidincidentes( $dados['idIncidente'] );
				$this->AssociacaoInstalacaoIncidente->setidprodemge( $this->Prodemge->getidprodemge() );
				
				if( $idAssociacao = $this->AssociacaoInstalacaoIncidente->create() )
				{
					$this->insereTelefonemas( $idAssociacao );
					echo 2;
				}else 
					echo 3;
		   }
		}else{
			echo 5;
		}
		
	}

	/* TODO: retirar ---
	public function uploadImg()
	{
		$this->DB->setPrkValue($this->dadosP['id']);
		if($this->DB->uploadImg($this->dadosF))
		{
			echo '<font id="recadoEnvioImg" style="color:green">Imagem anexada com sucesso.</font>';
		}
		else
		{
			echo '<font id="recadoEnvioImg" style="color:red;">Erro ao anexar imagem.</font>';
		}
	}
	*/

	/**
	 * RELATÃ“RIO EM CSV
	 * ->teste unitÃƒÂ¡rio aplicado em relatorioContent() em instalacoes, AQUI AINDA NAO
	 *
	 * campos:
	 * 	1.n incidente ()
	 * 	2.vsat ()
	 * 	3.data ()
	 * 	4.prioridade ()
	 * 	5.descricao ()
	 * 	6.atendimento ()
	 * 	7.id prodemge ()
	 * 	8.status ()
	 * 	9.tecnico responsavel ()
	 */


	public function periodo(){

		$this->smarty->display("{$this->tplDir}/relatorioPeriodo.tpl");
	}

	public function relatorio()
	{

		if ($_POST['data_inicio'] && $_POST['data_fim']){
			$dataI = $this->Helpers->data_br_us($_POST['data_inicio'] );
			$dataF = $this->Helpers->data_br_us($_POST['data_fim']);
			$where = "WHERE inci.`data` BETWEEN '$dataI' AND '$dataF'";
		}else{
			$where ="";
		}

		$this->relatorioContent($where);

		//convertendo codificacao em windows (UTF-8 para ISO-8599-1)
		$campos = "Nº INCIDENTE;VSAT;DATA;PRIORIDADE;DESCRICAO;ATENDIMENTOS;ID PRODEMGE;STATUS;TECNICO RESPONSAVEL; RESPONSAVEL; MOTIVO";
		$this->smarty->assign('campos',utf8_decode($campos));
		$valores = $this->arr;
			
		$helpers = new Helpers();

		$this->smarty->assign('arr',$valores);
		
		$text = $this->smarty->fetch("{$this->tplDir}/relatorio_1.tpl");

		$arquivo = 'relatorio_Incidente_'.date('d-m-Y').'.csv';

		header("Content-Description: PHP Generated Data");
		header("Content-type: application/x-msexcel");
		header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");

//		header("Content-type: application/csv");
//		header("Content-Disposition: attachment; filename=file.csv");
//		header('Content-Type: application/csv;charset=ISO-8859-1');
//		header("Pragma: no-cache");
//		header("Expires: 0");

		echo $text;
	}

	//tratamento do conteudo do csv (separado para o teste unitario)
	private function relatorioContent($where)
	{

		//BUSCA atendimentos de incidente $this->arr[$i]['vsatNome']
		//TODO: arrumar isso
		$sql = "SELECT DISTINCT inci.idincidentes, inst.nome as nomeVsat, inci.data, inci.prioridade, inci.descricao, pro.numero_prodemge as idprodemge,
				      u.nome as tecnicoNome, ma.motivo, ra.responsavel, sa.status
				FROM associacao_instalacao_incidente 		  aii
				LEFT JOIN incidentes 						  inci  ON (inci.idincidentes 			= aii.idincidentes)
				LEFT JOIN atend_vsat 						  av    ON (av.incidentes_idincidentes  = inci.idincidentes)
				LEFT JOIN usuarios 						  	  u 	ON (av.usuarios_idusuarios 		= u.idusuarios)
				LEFT JOIN instalacoes	 					  inst	ON (aii.idinstalacoes 			= inst.idinstalacoes)
				LEFT JOIN prodemge		 					  pro	ON (aii.idprodemge	 			= pro.idprodemge)
				LEFT JOIN status_atend						  sa	ON (av.status_atend_idstatus_atend 	= sa.idstatus_atend)
				LEFT JOIN atendimento_motivo_responsavel 	  amr	ON (av.idatend_vsat 			= amr.idatendimento)
				LEFT JOIN motivo_atendimentoteste			  ma	ON (amr.idmotivo 				= ma.idmotivo_atendimento)
				LEFT JOIN responsavel_atendimento 			  ra	ON (amr.idresponsavel 			=	ra.idresponsavel_atendimento)

				$where

				ORDER BY inci.idincidentes DESC
				";
		$this->arr = $this->Incidentes->executaSql($sql);
			
		for($i=0;$i<count($this->arr);$i++){
			//BUSCA atendimentos de incidente
			//TODO: arrumar isso			
			$sql = "SELECT atendimento FROM atend_vsat WHERE incidentes_idincidentes = '{$this->arr[$i]['idincidentes']}' ";
			$lista_atend_vsat = $this->DB->queryDados($sql);
			$listaAtendimentos = '';
			for($i2=0;$i2<count($lista_atend_vsat);$i2++)
			{
				$atendVez = $i2+1;
				$listaAtendimentos .= "| ATENDIMENTO {$atendVez}: {$lista_atend_vsat[$i2]['atendimento']} |";
			}
			
			//OS TITULOS DO RELATORIO ESTA NO templates\incidentes\relatorio_1.ptl
			
			$this->arr[$i]['atendimentos'] = $listaAtendimentos;
			
			//arrumando atendimentos para evitar erro em csv
			$atendimentos = str_replace("\r\n","",trim($this->arr[$i]['atendimentos']));
			$atendimentos = str_replace("\n","",trim($atendimentos));
			$atendimentos = str_replace("<br/>","",trim($atendimentos));
			$atendimentos = str_replace("<br>","",trim($atendimentos));
			$this->arr[$i]['atendimentos'] = $atendimentos;

			//arrumando descricao para evitar erro em csv
			$descricao = str_replace("\r\n","",trim($this->arr[$i]['descricao']));
			$descricao = str_replace("\n","",trim($descricao));
			$descricao = str_replace("<br/>","",trim($descricao));
			$descricao = str_replace("<br>","",trim($descricao));
			$this->arr[$i]['descricao'] = $descricao;

			$this->arr[$i]['vsatNome'] = $this->arr[$i]['nomeVsat'];

			$this->arr[$i]['statusAtendimento'] = $this->arr[$i]['status'];

			$this->arr[$i]['nomeTecnico'] = $this->arr[$i]['tecnicoNome'];

			$this->arr[$i]['responsavel'] = $this->arr[$i]['responsavel'];
			
			$this->arr[$i]['motivo'] = $this->arr[$i]['motivo'];
		}

	}
	
	
	public function RetiraAssociacaoComInstalacao()
	{
		$dados = $this->dadosP;
		

// 		$arrReturn['msg']    = $dados['idProd'];
// 		die_json($arrReturn);		
		
		$this->Instalacao->getInstalacaoPeloNome( $dados['nomeInstalacao'] );
		$retorno = $this->excluirNumeroProdemge($dados['idProd']);
		
		
		if ($retorno) {
			$this->AssociacaoInstalacaoIncidente->setidinstalacoes( $this->Instalacao->getidinstalacoes() );
			$this->AssociacaoInstalacaoIncidente->setidincidentes( $dados['idincidentes'] );
			$this->AssociacaoInstalacaoIncidente->setidprodemge( $dados['idProd'] );
			if( $this->AssociacaoInstalacaoIncidente->apagarAssociacao() )
				echo "Instalação retirada com sucesso.";
			else
				echo "Erro ao retirar Instalação.";
		}else{
			echo "Erro ao retirar o Numero da Prodemge";
		}
		
	}


	//funcao para transformar em lista para apresentacao
	public function transformaLista( $lista1 )
	{
		$lista2 = '<ul>';
		//print_b($lista1,true);
		for($i=0;$i<count($lista1);$i++)
		{
			$lista2 .= '<li><a href="#" onclick="javascript:getAjaxForm(\'Incidente/view\',\'conteudo\',{param:'.$lista1[$i]['id'].',ajax:1})">'.$lista1[$i]['vsat'].'</a></li>';
		}
		$lista2 .= '</ul>';
		//print_b($lista2,true);
		return $lista2;
	}


	//metodo que busca idprodemge para verificar e evitar duplicidade
	public function verificaCamposIncidente()
	{
		//verifica se ÃƒÂ© nÃƒÂºmero
// 		if(!is_numeric($_POST['idProdemge']))
// 		{
// 			echo "naoNumerico";exit;
// 		}

		//verifica se o campo esta vazio
		
		if($_POST['datas']== '')
		{
 			echo "vazioDt"; exit;
		}
		else if($_POST['idProdemge']== '')
		{
 			echo "vazio"; exit;
		}

		else if($_POST['instal']== '')
		{
 			echo "vazioInstalacao"; exit;
		}
		else if($_POST['tecnicoNoc']== '')
		{
 			echo "vazioTecnico"; exit;
		}
		//verifica se sÃƒÂ£o 6 dÃƒÂ­gitos
// 		if(strlen($_POST['idProdemge'])!=6)
// 		{
// 			echo "seisDigitos";exit;
// 		}
		//verifica se sÃƒÂ£o 6 dÃƒÂ­gitos
// 		if(strlen($_POST['idProdemge'])!=6)
// 		{
// 			echo "seisDigitos";exit;
// 		}
			
		$this->DB->setSelect('idincidentes');
		$resposta = $this->DB->liste(' idprodemge = "'.$_POST['idProdemge'].'"');
			
		if(count($resposta))//encontrado prÃƒÂ©-existente
		{
			echo "encontrado";exit;

		}
		else//nÃ£o encontrada prÃƒÂ©-existÃƒÂªncia
		{
			echo "ok";exit;
		}
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

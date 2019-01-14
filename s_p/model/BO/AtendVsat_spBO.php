<?php

require_once "s_p/model/AtendVsat_spModel.php";

include_once 's_p/model/BO/StatusAtendimento_spBO.php';
include_once 's_p/model/BO/Cronometro_spBO.php';
include_once 's_p/model/BO/Instalacoes_spBO.php';
include_once 's_p/model/BO/Incidentes_spBO.php';
include_once 's_p/model/BO/TipoAtendimento_spBO.php';
include_once 's_p/model/BO/Usuarios_spBO.php';
include_once 's_p/model/BO/StatusAtendimento_spBO.php';

require_once ("helpers/AdapterZend.php");
include_once 'helpers.class.php';

class AtendVsat_spBO extends AtendVsat_spModel
{
	
	protected $listaAtendimentos;
	protected $listaAtendimentosSatus = array();
	protected $listaAtendimentosArrayComDependencias = array();
	
	// outras BO's
	protected $Cronometro;
	protected $statusAtendimentos;
	protected $Incidente;
	protected $TipoAtendimento;
	protected $Usuarios;
	protected $Instalacao;
	protected $Status;
	
	protected $AtendimentosComCronometros = array();
	protected $ultimoAtendimentoDeIncidente;
	protected $primeiroAtendimentoDeIncidente;
	
	public function __construct( $adapter )
	{
		$adapter = new AdapterZend();
		parent::__construct( $adapter->getAdapterZend() );

		$this->statusAtendimentos = new StatusAtendimento_spBO( $adapter->getAdapterZend() );
		$this->Cronometro = new Cronometro_spBO( $adapter->getAdapterZend() );
		$this->Instalacao = new Instalacoes_spBO( $adapter->getAdapterZend() );
		$this->Incidente = new Incidentes_spBO( $adapter->getAdapterZend() );
		$this->TipoAtendimento = new TipoAtendimento_spBO( $adapter->getAdapterZend() );
		$this->Usuarios = new Usuarios_spBO( $adapter->getAdapterZend() );
		$this->Status = new StatusAtendimento_spBO( $adapter->getAdapterZend() );



		$this->Helpers  = new Helpers();
	}
	
	public function getListaIdAtendimentoComCronometro()
	{
		return $this->AtendimentosComCronometros;
	}
	
	public function getListaAtendimentosComDependenciasArray()
	{
		return $this->listaAtendimentosArrayComDependencias;
	}

	public function getlistaAtendimentosSatus()
	{
		return $this->listaAtendimentosSatus;
	}
	
	public function getlistaAtendimentos()
	{
		return $this->listaAtendimentos;
	}
	
	public function getlistaAtendimentosArray()
	{
		return $this->listaAtendimentos->toArray();
	}
	
	public function getAtendimentosDeIncidente( Integer $idIncidente )
	{
		$where = " incidentes_sp_idincidentes = '{$idIncidente->numero()}' ";
		$order = "";
		$this->listaAtendimentos = $this->fetchAll( $where , $order );
	}
	
	public function getStatusAtendimentos()
	{
		$this->statusAtendimentos->listaStatusAtendimentos();
		
		$listaStatus = array();
		
		foreach( $this->statusAtendimentos->getlistaStatusAtendimentos() as $status )
		{
			//print_b($this->getlistaAtendimentos()->toArray(),true);
			
			foreach( $this->getlistaAtendimentos()->toArray() as $chave => $atendimento )
			{
				$listaStatus[ $status['status'] ] = array();
				if( $atendimento['status_atend_idstatus_atend'] == $status['idstatus_atend'] )
					array_push( $listaStatus[ $status['status'] ] , $atendimento );
			}
		}
		//print_b($listaStatus,true);
		
		$this->listaAtendimentosSatus = $listaStatus;
	}
	
	public function getCronometrosDeAtendimentos()
	{
		$listaAtendimentos = $this->getlistaAtendimentos()->toArray();
		
		foreach ( $listaAtendimentos as $chave => $atendimento )
		{
			$this->Cronometro->setidreferencia( $atendimento['idatend_vsat'] );
			$this->Cronometro->settabelareferencia( 'atend_vsat_sp' );
			$cronometro = $this->Cronometro->getCronometrosDeAtendimento();
			array_push( $this->AtendimentosComCronometros , array(
				'atendimento' => $atendimento['idatend_vsat'] ,
				'cronometro' => $cronometro
			) );
		}
		//print_b($this->AtendimentosComCronometros,true);
	}
	
	public function getDataInicioPrimeiroAtendimento()
	{
		foreach( $this->Cronometro->getCronometrosDeAtendimento() as $chave => $atendimento )
		{
			$primeiroAtendimento = $atendimento['primeiro'];
			break;
		}
		return ( isset($primeiroAtendimento['inicio_tarefa']) )?$primeiroAtendimento['inicio_tarefa']:'';
	}
	
	public function getDataFinalUltimoAtendimento()
	{
		foreach( $this->Cronometro->getCronometrosDeAtendimento() as $chave => $atendimento )
		{
			$ultimoAtendimento = $atendimento['ultimo'];
			break;
		}
		return ( isset($ultimoAtendimento['final_tarefa']) )?$ultimoAtendimento['final_tarefa']:'';
	}
	
	public function getUltimoAtendimento()
	{
		return $this->Cronometro->getCronometrosDeAtendimento();
		/*foreach( $this->Cronometro->getCronometrosDeAtendimento() as $chave => $atendimento )
		{
			$ultimoAtendimento = $atendimento['ultimo'];
			break;
		}
		return $this;*/
	}
	
	
	// relacionamentos

	public function carregaRelacionamentos()
	{
		$this->aplicaStatusNosAtendimentos(); // contrói array com dependecias
		$this->aplicaUsuariosNosAtendimentos();
		$this->aplicaIncidenteNosAtendimentos();
		$this->aplicaUsuariosNosAtendimentos();
		$this->aplicaTipoAtendimentoNosAtendimentos();
		$this->aplicaCronometroNosAtendimentos();
	}
	
	private function aplicaStatusNosAtendimentos()
	{
		foreach( $this->getlistaAtendimentosArray() as $chave => $atendimento )
		{
			$this->listaAtendimentosArrayComDependencias[$chave] = $atendimento;
			$idStatusAtendimento = new Integer( $atendimento['status_atend_idstatus_atend'] );
			$this->listaAtendimentosArrayComDependencias[$chave]['status'] = $this->statusAtendimentos->getStatusAtendimento( $idStatusAtendimento );
		}
	}
	
	private function aplicaUsuariosNosAtendimentos()
	{
		foreach( $this->getListaAtendimentosComDependenciasArray() as $chave => $atendimento )
		{
			$idUsuario = new Integer( $atendimento['usuarios_idusuarios'] );
			$this->Usuarios->setidusuarios( $idUsuario );
			$this->Usuarios->getUsuario();
			$this->listaAtendimentosArrayComDependencias[$chave]['usuario'] = $this->Usuarios->getUsuarioArray();
		}
	}
	
	private function aplicaTipoAtendimentoNosAtendimentos()
	{
		foreach( $this->getListaAtendimentosComDependenciasArray() as $chave => $atendimento )
		{
			$idTipoAtendimento = new Integer( $atendimento['tipo_atendimento_idtipo_atendimento'] );
			$this->TipoAtendimento->setidtipo_atendimento( $idTipoAtendimento );
			$this->TipoAtendimento->getTipoAtendimento();
			$this->listaAtendimentosArrayComDependencias[$chave]['TipoAtendimento'] = $this->TipoAtendimento->getTipoAtendimentoArray();
		}
	}
	
	private function aplicaIncidenteNosAtendimentos()
	{
		foreach( $this->getlistaAtendimentosArray() as $chave => $atendimento )
		{
			$idIncidente = new Integer( $atendimento['incidentes_sp_idincidentes'] );
			$this->Incidente->setidincidentes( $idIncidente );
			$this->Incidente->getIncidente();
			$this->listaAtendimentosArrayComDependencias[$chave]['incidente'] = $this->Incidente->getincidenteArray();
		}
	}
	
	private function aplicaCronometroNosAtendimentos()
	{
		foreach( $this->getListaAtendimentosComDependenciasArray() as $chave => $atendimento )
		{
			$this->Cronometro->setidreferencia( $atendimento['idatend_vsat'] );
			$this->Cronometro->settabelareferencia( 'atend_vsat_sp' );
			$this->listaAtendimentosArrayComDependencias[$chave]['cronometro'] = $this->Cronometro->getCronometrosDeAtendimento();
		}
	}
	
	// busca lista baseada na final_tarefa ASC
	public function getUltimoAtendimentoDeIncidente( Integer $idIncidente )
	{


		$ultimoAtendimentoSemDataFimNoCronometro = '';

		$where = " incidentes_sp_idincidentes = '{$idIncidente->numero()}' ";
		$order = " idatend_vsat DESC ";
		$atendimentos = $this->fetchAll( $this->select()->where($where)->order($order) );



		//print_b($atendimentos->toArray(),true);

		//resgata de tras pra frente o que nao tiver final_tarefa (ultimo pendente)
		foreach ( $atendimentos->toArray() as $chave => $atendimento )
		{

			$this->Cronometro->settabelareferencia( 'atend_vsat_sp' );
			$this->Cronometro->setidreferencia( $atendimento['idatend_vsat'] );

			$lista = $this->Cronometro->getCronometrosDeAtendimento();



			//echo $lista['final_tarefa'].'<br/>';
			if(
				isset($lista['final_tarefa']) && (
					$lista['final_tarefa'] == '' ||
					$lista['final_tarefa'] == '0000-00-00 00:00:00' ||
					$lista['final_tarefa'] == NULL ||
					empty($lista['final_tarefa'])
				)
			)
			{
				//print_b($lista,true);
				$ultimoAtendimentoSemDataFimNoCronometro = $lista['idreferencia'];


				break;
			}
		}
		// caso nenhum tenha sido resgatado, pegar o primeiro
		if( $ultimoAtendimentoSemDataFimNoCronometro == '' )
		{

			$atendimentosArray = $atendimentos->toArray();

			$ultimoAtendimentoSemDataFimNoCronometro  = $atendimentosArray[0]['idatend_vsat'];
		}

		$where = " idatend_vsat = '{$ultimoAtendimentoSemDataFimNoCronometro}' ";
		$listaAtendimentos = $this->fetchAll( $where );
		$this->listaAtendimentos = $listaAtendimentos;

		$this->carregaRelacionamentos();
//
		$this->ultimoAtendimentoDeIncidente = $this->listaAtendimentosArrayComDependencias[0];
		//print_b($this->ultimoAtendimentoDeIncidente,true);
		return $this->listaAtendimentosArrayComDependencias[0];
	}
	
	public function getPrimeiroAtendimentoDeIncidente( Integer $idIncidente )
	{
		$primeiroAtendimentoSemDataFimNoCronometro= '';
		
		$where = " incidentes_sp_idincidentes = '{$idIncidente->numero()}' ";
		$order = " idatend_vsat ASC ";
		$atendimentos = $this->fetchAll( $this->select()->where($where)->order($order) );
		//print_b($atendimentos,true);
		
		//resgata de tras pra frente o que nao tiver final_tarefa (ultimo pendente)
		if( count($atendimentos) > 0 )
		{
			foreach ( $atendimentos->toArray() as $chave => $atendimento )
			{
				$this->Cronometro->settabelareferencia( 'atend_vsat_sp' );
				$this->Cronometro->setidreferencia( $atendimento['idatend_vsat'] );
				$lista = $this->Cronometro->getCronometrosDeAtendimento();
				$primeiroAtendimentoSemDataFimNoCronometro = $lista['idreferencia'];
				break;
			}
			
			$where = " idatend_vsat = '{$primeiroAtendimentoSemDataFimNoCronometro}' ";
			$listaAtendimentos = $this->fetchAll( $where );
			$this->listaAtendimentos = $listaAtendimentos;
			$this->carregaRelacionamentos();
			
			$this->primeiroAtendimentoDeIncidente = $this->listaAtendimentosArrayComDependencias[0];
			
			return $this->listaAtendimentosArrayComDependencias[0];
		}
		else
		{
			$primeiroAtendimentoSemDataFimNoCronometro = '';
			
			return array();
		}
	}
	
	public function montaObjetoDoForm( $form )
	{
		$this->setdata( $form['data'] );

		$this->setmensagem( $form['mensagem'] );

		$this->setatendimento( $form['atendimento'] );

		$this->setstatus_atend_idstatus_atend( $form['status_atend_idstatus_atend'] );

		$this->setusuarios_idusuarios( $form['nomeResponsavel'] );
//		$this->setusuarios_idusuarios( $form['usuarios_idusuarios'] );

		$this->setincidentes_sp_idincidentes( $form['incidentes_sp_idincidentes'] );

        $this->setinstalacoes_sp_idinstalacoes_sp($form['instalacoes_sp_idinstalacoes_sp']);

		$this->setresposta_agilis( $form['resposta_agilis'] );

		$this->settipo_atendimento_idtipo_atendimento( $form['tipo_atendimento_idtipo_atendimento'] );


		if( isset($form['atendimento_pai']) )
			$this->setatendimento_pai( $form['atendimento_pai'] );
		else
			$this->setatendimento_pai( '' );
			
		$this->setsaom( $form['saom'] );
	}
	
	//metodo que serve a classe Home
	public function busca_atendimentos_pendentes_para_usuario( Integer $idusuario )
	{
		$arrayAtendimentosPendentesDeUsuario = array();
		
		$idusuarioNumero = $idusuario->numero();
		
		// busca 1 atendimento do usuario por incidente
		$select = " DISTINCT(incidentes_sp_idincidentes) ";
		$where = " usuarios_idusuarios = '{$idusuarioNumero}' AND status_atend_idstatus_atend != 3  ";
		$listaAtendimentosDeUsuario = $this->fetchAll( $this->select( $select )->where( $where ) );
		
		// para cada incidente busca atendimentos abertos
		if( count($listaAtendimentosDeUsuario) > 0 )
		{
			foreach( $listaAtendimentosDeUsuario->toArray() as $chave => $atendimento )
			{
				if( empty($atendimento['incidentes_sp_idincidentes']) )
					continue;
				
				$where = " 
					incidentes_sp_idincidentes = '{$atendimento['incidentes_sp_idincidentes']}' AND
					usuarios_idusuarios = '{$atendimento['usuarios_idusuarios']}' AND 
					status_atend_idstatus_atend != 3
				";
				$atendimentosDeIncidenteEDeUsuario = $this->fetchAll( $where );
				if( count($atendimentosDeIncidenteEDeUsuario) > 0 )
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ] = $atendimentosDeIncidenteEDeUsuario->toArray();
				
				//resume textos
				foreach ($arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ] as $chave => $atendimentoDeIncidente)
				{
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['resumo_atendimento'] = substr( $arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['atendimento'] , 0 , 100 ).'...';
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['resumo_resposta_agilis'] = substr( $arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['resposta_agilis'] , 0 , 100 ).'...';
					
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['atendimento'] = nl2br( $arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['atendimento'] );
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['resposta_agilis'] = nl2br( $arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['resposta_agilis'] );
					
					$idStatusAtendimento = new Integer( $arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['status_atend_idstatus_atend'] );
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['status'] = $this->statusAtendimentos->getStatusAtendimento( $idStatusAtendimento );
					
					$arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['data'] = $this->Helpers->data_us_br_com_hora( $arrayAtendimentosPendentesDeUsuario[ $atendimento['incidentes_sp_idincidentes'] ][ $chave ]['data'] );
				}
			}
		}
		
		return $arrayAtendimentosPendentesDeUsuario;
	}
	
	public function iteraListaIncidentesBuscandoAtendimentos( Array $listaIncidentes )
	{
		$db = $this->getAdapter();
		
		foreach ( $listaIncidentes as $chave => $incidente )
		{
			$sql = "
				SELECT idatend_vsat 
				FROM atend_vsat_sp
				WHERE incidentes_sp_idincidentes = '{$incidente['idincidentes']}'
			";
			$listaAtendimentos = $db->fetchAll($sql);
			if( count($listaAtendimentos) > 0 )
				$listaIncidentes[ $chave ]['atendimentos'] = $listaAtendimentos;
			else
				$listaIncidentes[ $chave ]['atendimentos'] = array();
		}
		
		return $listaIncidentes;
	}

    public function getAtendimentosAcompanhamento() {
        $data = date('Y-m-d');
        $atendimentos = $this->select()
                             ->setIntegrityCheck(false)
                             ->from(array('av' => 'atend_vsat_sp'), 'av.*')
                             ->joinInner(
                                 array('c' => 'cronometro_sp'),
                                 "(c.tabelareferencia = 'atend_vsat_sp' AND c.idreferencia = av.idatend_vsat)",
                                 'c.*'
                             )
                             ->where('av.incidentes_sp_idincidentes IS NOT NULL AND av.incidentes_sp_idincidentes > 0')
                             ->where("
                                c.final_tarefa IS NULL OR
                                c.final_tarefa = '0000-00-00 00:00:00' OR
                                c.final_tarefa = '' OR
                                c.final_tarefa LIKE '{$data}%'"
                             )
                             ->query()
                             ->fetchAll();

        return $atendimentos;
    }
	
}
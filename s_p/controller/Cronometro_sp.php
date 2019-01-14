<?php

/**
 * 
 * Classe CronÃ´metro
 * 
 * O objetivo Ã© registrar data de inicio de atividades e controlar 
 * isso atravÃ©s de uma "data inicial" e de uma "data final", registrando
 * interrupÃ§Ãµes que "pausas" que registrem um tempo no qual o cronometro
 * nÃ£o somarÃ¡ ao tempo total da execuÃ§Ã£o da tarefa 
 * 
 * @author Lothar
 *
 */

// include_once "/Controller.php";
include_once "s_p/model/DBCronometro_sp.php";
include_once "s_p/model/DBCronometro_interrupcao_sp.php";

class Cronometro_sp extends Controller
{
	
	protected $tplDir = 's_p/tampletes/cronometro';
	
	//para edicao da data final
	protected $statusAtendimento;
	protected $prk;
	
	//para 'resolveCronometro'
	protected $tabelaReferencia;
	protected $idReferencia;
	protected $smartyCronometro;
	protected $smartyInterrupcao;
	protected $smartyPausaAtiva;
	protected $pausaAtiva;
	
	//atributos
	protected $idcronometro;
	// protected $idreferencia; // já existe
	protected $inicio_tarefa;
	protected $interrupcoes;
	protected $tabelareferencia;
	protected $final_tarefa;
	protected $prazo;
	protected $linha_zend;
	
	function __construct() 
	{
    	parent::__construct();

    	$this->DB = new DBCronometro_sp();
    	$this->DBInterrupcao = new DBCronometro_interrupcao_sp();
    }
    
    public function setLinhaZend( Zend_Db_Table_Row $cronometro )
    {
    	$this->linha_zend = $cronometro;
    }
    public function setIdCronometro( $idcronometro )
    {
    	$this->idcronometro = $idcronometro;
    }
    public function setIdReferencia( $idreferencia )
    {
    	$this->idReferencia  = $idreferencia;
    }
    public function setInicioTarefa( $inicioTarefa )
    {
    	$this->inicio_tarefa = $inicioTarefa;
    }
	public function setInterrupcoes( $interrupcoes )
    {
    	$this->interrupcoes = $interrupcoes;
    }
	public function setTabelaReferencia( $tabelaReferencia )
    {
    	$this->tabelareferencia = $tabelaReferencia;
    }
	public function setFinalTarefa( $finalTarefa )
    {
    	$this->final_tarefa = $finalTarefa;
    }
	public function setPrazo( $prazo )
    {
    	$this->prazo = $prazo;
    }
    
    public function getLinhaZend()
    {
    	return $this->linha_zend;
    }
 	public function getIdCronometro()
    {
    	return $this->idcronometro;
    }
    public function getIdReferencia()
    {
    	return $this->idReferencia;
    }
    public function getInicioTarefa()
    {
    	return $this->inicio_tarefa;
    }
	public function getInterrupcoes()
    {
    	return $this->interrupcoes;
    }
	public function getTabelaReferencia()
    {
    	return $this->tabelareferencia;
    }
	public function getFinalTarefa()
    {
    	return $this->final_tarefa;
    }
	public function getPrazo()
    {
    	return $this->prazo;
    }
    
    
    public function buscaAtendimentoAbertoParaIncidente( Incidente_sp $incidente )
    {
    	$idIncidentes = $incidente->getIdincidentes();
    	
    	$where = " incidentes_sp_idincidentes = '{$idIncidentes}' ";
    	$atendimentos = $this->Atendimento_sp->fetchAll( $where );
    	if( count($atendimentos) < 1 )
    	 	return false;
    	
    	$atendimentos = $atendimentos->toArray(); 
		foreach ( $atendimentos as $chave => $atendimento )
		{
			$where = "
	    		idreferencia = '{$atendimento['idatend_vsat']}' AND
	    		(
		    		final_tarefa = NULL OR
		    		final_tarefa = '' OR
		    		final_tarefa = '0000-00-00 00:00:00' 
		    	)
	    	";
	    	$cronometrosAtendimentos = $this->Cronometro_sp->fetchAll( $where );
	    	if( count($cronometrosAtendimentos) < 1 )
	    		return false;
		}
		return true;
    }
    
    public function VerificaExistenciaCronometroIncidente( Incidente_sp $incidente )
    {
    	$idIncidentes = $incidente->getIdincidentes();
    	
    	$where  = " idreferencia = '{$idIncidentes}' ";
    	$cronometrosDeIncidente = $this->Cronometro_sp->fetchAll( $where );
    	
    	if( count($cronometrosDeIncidente) > 0 )
    		return true;
    	else
    		return $this->criaCronometroParaIncidente( $incidente );
    }
    
    private function criaCronometroParaIncidente( $incidente )
    {
    	$agora = date( 'Y-m-d H:i:s' );
    	$idIncidentes = $incidente->getIdincidentes();
    	
    	$data = array(
    		'inicio_tarefa' => $agora,
    		'idreferencia' => $idIncidentes,
    		'tabelareferencia' => "incidentes_sp"
    	);
    	if( $idcronometro = $this->Cronometro_sp->insert( $data ) )
    	{
    		$where = " idcronometro = '{$idcronometro}' ";
    		$cronometro = $this->Cronometro_sp->fetchRow( $where );
    		$this->setLinhaZend( $cronometro );
    		return $cronometro;
    	}
    	else
    		return false;
    }
    
	private function setaDadosCronometro( Zend_Db_Table_Row $cronometro )
    {
    	$this->setIdCronometro( $cronometro->idcronometro );
    	$this->setIdReferencia( $cronometro->idreferencia );
    	$this->setInicioTarefa( $cronometro->inicio_tarefa );
    	$this->setInterrupcoes( $cronometro->interrupcoes );
    	$this->setTabelaReferencia( $cronometro->tabelareferencia );
    	$this->setFinalTarefa( $cronometro->final_tarefa );
    	$this->setPrazo( $cronometro->prazo );
    	$this->setLinhaZend( $cronometro );
    	
    	return true;
    }
   	
    public function zeraDataFinalIncidente( Incidente_sp $incidente )
    {
    	$idIncidentes = $incidente->getIdincidentes();
    	
    	$where = " idreferencia = '{$idIncidentes}' AND tabelareferencia = 'incidentes_sp' ";
    	$data = array( 'final_tarefa' => NULL );
    	if( $this->Cronometro_sp->update( $data , $where ) )
    		return true;
    	else
    		return false;
    }
    
    //metodo que edita data final de acordo com a modificacao do status do atendimento
    public function editaDataFinal()
    {
    	if($this->getStatusAtendimento()==3)//finalizado
    	{
    		$dataNova = date('Y-m-d H:i:s');
    		$form = array('final_tarefa'=>$dataNova);
    	}
    	else//nao finalizado
    	{
    		$dataNova = '';
    		$form = array('final_tarefa'=>$dataNova);
    	}
    	
    	$this->DB->setPrkValue($this->prk);
    	if($this->DB->edit($form))
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
	
    
    public function resolveCronometro()
    {	
    	$this->DB->setTabelareferencia($this->tabelaReferencia);
    	$this->DB->setIdreferencia($this->idReferencia);
    	$this->DB->verificaExistencia();
        if(!$this->DB->getExistencia())//não existe
        {
        	$dadosUrgencia = array(
        						'tabelareferencia'=>$this->tabelaReferencia,
        						'idreferencia'=>$this->idReferencia,
        						'inicio_tarefa'=>date('Y-m-d H:i:s')
        						);
	        $idInserido = $this->DB->create($dadosUrgencia);
	        $this->DB->setIdcronometro($idInserido);
	        $this->DB->carrega();
	        $this->setSmartyCronometro($this->DB->getDadosCarregados());
	        $this->setSmartyInterrupcao('');
	        $this->setSmartyPausaAtiva('');
	        //nao precisa de pausas pq o cronometro nao existe ainda
        }
        else//existe
        {
        	$this->setSmartyCronometro($this->DB->getDadosCarregados());
        	//prepara lista de pausas
        		$this->DBInterrupcao->setCronometro_idcronometro($this->DB->getIdcronometro());
			    $this->DBInterrupcao->setDefaultOrder('ASC');
        		$listaInterrupcao = $this->DBInterrupcao->liste();
        		$this->setSmartyInterrupcao($listaInterrupcao);
			//verifica se tem pausa aberta
				for($i=0;$i<count($listaInterrupcao);$i++)
				{
					//para pausa aberta
			    	if($listaInterrupcao[$i]['hora_fim']=='')
			    	{
			   			$this->setPausaAtiva('sim');
			    	}
			    }
			$this->setSmartyPausaAtiva($this->pausaAtiva);
        }
    }
    
}
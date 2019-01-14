<?php

/**
 * 
 * Classe DBCronometro_interrupcao
 * 
 * Objetivo de lidar com o Banco da Tabela "cronometro_interrupcao", 
 * controlada pela controller 'Cronometro'
 * 
 * @author Lothar
 *
 */

include_once 's_p/model/DBModel_sp.php';

/*
 * Anotações:
 * 
 * 1.A pausa terá o seguinte formato:
 * 		{numero da pausa}|{descricao da pausa}|{mesmo numero, que significa fechamento da pausa}|-|
 * 2.Parâmetro de separação entre itens da pausa: "|"
 * 3.Parâmetro de separação entre pausas: "|-|"
 */

class DBCronometro_interrupcao_sp extends DBModel_sp
{
	
	//campos
	protected $idcronometro_interrupcao;
	protected $cronometro_idcronometro;
	protected $hora_comeco;
	protected $hora_fim;
	protected $motivo;
	
	//em array
	protected $dadosCarregados = array();
	
	//padrao
	protected $tabela = 'cronometro_interrupcao_sp';
    protected $rel    = array();
    protected $fgk    = array();
    protected $prk    = 'idcronometro_interrupcao';//primary key
    //protected $cmpData= array('inicio_tarefa','final_tarefa');
    protected $cmpReq = array('hora_comeco','motivo');
    
    protected $camposForm = array(
    							'idcronometro_interrupcao',
    							'cronometro_idcronometro',
    							'hora_comeco',
    							'hora_fim',
    							'motivo'
    							);
    							
    //extras
    protected $resultadoUpdate;
    							
    public function __construct()
    {
    	parent::__construct();
    }
    
    //SETS
    	public function setIdcronometro_interrupcao($idcronometro_interrupcao)
    	{
    		$this->idcronometro_interrupcao = $idcronometro_interrupcao;
    	}
    	public function setCronometro_idcronometro($cronometro_idcronometro)
    	{
    		$this->cronometro_idcronometro = $cronometro_idcronometro;
    	}
    	public function setResultadoUpdate($resultado)
    	{
    		$this->resultadoUpdate = $resultado;
    	}
    //SETS - fim
    
    //GETS
    	public function getDadosCarregados()
    	{
    		return $this->dadosCarregados;
    	}
    	public function getResultadoUpdate()
    	{
    		return $this->resultadoUpdate;
    	}
    	public function getCronometro_idcronometro()
    	{
    		return $this->cronometro_idcronometro;
    	}
    //GETS - fim
    
	public function carrega()
    {
    	$sql = "SELECT idcronometro_interrupcao, cronometro_idcronometro, hora_comeco, hora_fim, motivo FROM cronometro_interrupcao_sp WHERE idcronometro_interrupcao = {$this->idcronometro_interrupcao}";
    	$dados = $this->queryDados($sql);
    	if(count($dados))
    	{
    		//em campos
    		$this->idcronometro_interrupcao = $dados[0]['idcronometro_interrupcao'];
			$this->cronometro_idcronometro = $dados[0]['cronometro_idcronometro'];
			$this->hora_comeco = $dados[0]['hora_comeco'];
			$this->hora_fim = $dados[0]['hora_fim'];
			$this->motivo = $dados[0]['motivo'];
    		//em array
    		$this->dadosCarregados = $dados[0];
    		$this->dadosCarregados['resultado'] = 'ok';
    	}
    	else
    	{
    		//sem resultados
    		$this->dadosCarregados['resultado'] = 'no';
    	}
    }
    
    public function despausaCronometro()
    {
    	$sql = "UPDATE cronometro_interrupcao_sp SET hora_fim = '".date('Y-m-d H:i:s')."' WHERE idcronometro_interrupcao = ".$this->idcronometro_interrupcao." ";
    	if($this->query($sql))
    	{
    		$this->setResultadoUpdate(true);
    	}
    	else
    	{
    		$this->setResultadoUpdate(false);
    	}
    }
	
}
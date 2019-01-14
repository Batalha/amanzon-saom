<?php

/**
 * 
 * Classe DBCronometro
 * 
 * Objetivo de lidar com o Banco da Tabela "cronometro", 
 * controlada pela controller 'Cronometro'
 * 
 * @author Lothar
 *
 */

include_once 'DBModel.php';

/*
 * Anotações:
 * 
 * 1.A pausa terá o seguinte formato:
 * 		{numero da pausa}|{descricao da pausa}|{mesmo numero, que significa fechamento da pausa}|-|
 * 2.Parâmetro de separação entre itens da pausa: "|"
 * 3.Parâmetro de separação entre pausas: "|-|"
 */

class DBCronometro extends DBModel
{
	
	//campos
	protected $idcronometro;
	protected $idreferencia;
	protected $tabelareferencia;
	protected $inicio_tarefa;
	protected $final_tarefa;
	protected $prazo;
	
	//em array
	protected $dadosCarregados = array();
	
	//padrao
	protected $tabela = 'cronometro';
    protected $rel    = array();
    protected $fgk    = array();
    protected $prk    = 'idcronometro';//primary key
    //protected $cmpData= array('inicio_tarefa','final_tarefa');
    protected $cmpReq = array('idreferencia','tabelareferencia','inicio_tarefa','prazo');
    
    protected $camposForm = array(
    							'idcronometro',
    							'idreferencia',
    							'tabelareferencia',
    							'inicio_tarefa',
    							'final_tarefa',
    							'prazo'
    							);
    
	//extras
    protected $existencia;//boolean
    							
    public function __construct()
    {
    	parent::__construct();
    }
    
    //SETS
    	public function setIdcronometro($idcronometronovo)
    	{
    		$this->idcronometro = $idcronometronovo;
    	}
    	public function setIdreferencia($novoidreferencia)
    	{
    		$this->idreferencia = $novoidreferencia;
    	}
    	public function setTabelareferencia($novatabelareferencia)
    	{
    		$this->tabelareferencia = $novatabelareferencia;
    	}
    	public function setExistencia($novoexistencia)
    	{
    		$this->existencia = $novoexistencia;
    	}
    //SETS - fim
    
    //GETS
    	public function getIdcronometro()
    	{
    		return $this->idcronometro;
    	}
    	public function getIdreferencia()
    	{
    		return $this->idreferencia;
    	}
    	public function getTabelareferencia()
    	{
    		return $this->tabelareferencia;
    	}
    	public function getExistencia()
    	{
    		return $this->existencia;
    	}
    	public function getDadosUrgencia()
    	{
    		return $this->dadosUrgencia;
    	}
    	public function getDadosCarregados()
    	{
    		return $this->dadosCarregados;
    	}
    //GETS - fim
    
    public function carrega()
    {
    	$sql = "SELECT idcronometro, idreferencia, inicio_tarefa, tabelareferencia, final_tarefa, prazo FROM cronometro WHERE idcronometro = {$this->idcronometro}";
    	$dados = $this->queryDados($sql);
    	if(count($dados))
    	{
    		//em campos
    		$this->idcronometro = $dados[0]['idcronometro'];
    		$this->idreferencia = $dados[0]['idreferencia'];
    		$this->inicio_tarefa = $dados[0]['inicio_tarefa'];
    		$this->tabelareferencia = $dados[0]['tabelareferencia'];
    		$this->final_tarefa = $dados[0]['final_tarefa'];
    		$this->prazo = $dados[0]['prazo'];
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
    
    //busca por referencia
    public function buscaCronometroPorReferencias()
    {
    	$sql = "SELECT * FROM cronometro WHERE tabelareferencia = '{$this->tabelareferencia}' AND idreferencia = '{$this->idreferencia}' ";
    	$dados = $this->queryDados($sql);
    	if(count($dados))
    	{
    		$this->setIdcronometro($dados[0]['idcronometro']);
    		$this->carrega();
    	}
    	else
    	{
    		$this->dadosCarregados['resultado'] = 'no';
    	}
    }
    
    public function verificaExistencia()
    {
    	$sql = "SELECT idcronometro FROM cronometro WHERE idreferencia = {$this->getIdreferencia()} AND tabelareferencia = '{$this->getTabelareferencia()}'";
    	$dados = $this->queryDados($sql);
    	if(count($dados))
    	{
    		$this->setIdcronometro($dados[0]['idcronometro']);
    		$this->carrega();
    		$this->setExistencia(true);
    	}
    	else
    	{
    		$this->setExistencia(false);
    	}
    }
    
	public function zeraDataFinalIncidente($idincidente,$tabela)
    {
    	$sql = "UPDATE cronometro SET final_tarefa = '' WHERE tabelareferencia = '{$tabela}' AND idreferencia = '{$idincidente}' ";
    	return $this->query($sql);
    }
	
}
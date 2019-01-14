<?php

/*
 * Class DB
 * 
 * @author: Sávio Resende lotharthesavior@gmail.com
 * 
 * Classe para simplificar métodos.
 */

include_once 'helpers/DBCon.php';

class DB extends DBCon
{
	
	public function  __construct() 
    {
        parent::__construct();

    }
    
	public function carrega()
    {
    	$sql = "
    		SELECT * 
    		FROM 
    			'{$this->tabela}' 
    		WHERE 
    			idatend_vsat = {$this->idatend_vsat}
    	";
    	$dados = $this->queryDados($sql);
    	if(count($dados))
    	{
    		//em campos
    		for($i=0;$i<count($this->camposForm);$i++)
    		{
    			$this->$$this->camposForm[$i] = $dados[0][$this->camposForm[$i]];
    		}
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
	
}
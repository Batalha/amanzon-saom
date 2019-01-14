<?php

include_once "s_p/model/DBModel_sp.php";

class DBSatelites_sp extends DBModel_sp
{
	protected $idsetelite;
    protected $nome_satelite;
    protected $descricao_satelite;
    
    protected $tabela = 'satelite';
    protected $prk = 'idsatelite';
    
    protected $where;
    
    protected $camposForm = array(
        						'nome_satelite',
                                'descricao_satelite'
    							);
    
    protected $cmpReq   = array(
    						'nome_satelite',
                            'descricao_satelite'
    						);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function listaSatelites()
	{
		$this->where = 'idsatelite, nome_satelite, descricao_satelite';
		
		$sql = "SELECT {$this->where} FROM {$this->tabela}";
		return $this->queryDados($sql);
	}
	
}
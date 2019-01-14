<?php

include_once "DBModel.php";

class DBEmpresas extends DBModel
{
	protected $idempresas;
    protected $empresa;
    protected $local;
    
    protected $tabela = 'empresas';
    protected $prk = 'idempresas';
    
    protected $where;
    
    protected $camposForm = array(
        						'empresa',
        						'local'
    							);
    
    protected $cmpReq   = array(
    						'empresa',
    						'local'
    						);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function listaEmpresas()
	{
		$this->where = 'idempresas, empresa, local';

		$sql = "SELECT {$this->where} FROM {$this->tabela}";
		return $this->queryDados($sql);
	}
	
}
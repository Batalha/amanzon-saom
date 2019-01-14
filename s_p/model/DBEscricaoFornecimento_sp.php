<?php

include_once "s_p/model/DBModel_sp.php";

class DBEscricaoFornecimento_sp extends DBModel_sp
{
	protected $idempresas;
    protected $empresa;
    protected $local;
    
    protected $tabela = 'escricao_fornecimento';
    protected $prk = 'idescricao_fornecimento';
    
    protected $where;
    
    protected $camposForm = array(
        						'nome_escricao_forn',
                                'descricao_forn'
    							);
    
    protected $cmpReq   = array(
    						'nome_escricao_forn',
                            'descricao_forn'
    						);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function listaEscricaoFornecimento()
	{
		$this->where = 'idescricao_fornecimento, nome_escricao_forn, descricao_forn';
		
		$sql = "SELECT {$this->where} FROM {$this->tabela}";
		return $this->queryDados($sql);
	}
	
}
<?php

include_once "DBModel.php";

class DBPausas extends DBModel
{
	protected $idpausas;
    protected $tabela;
    protected $pausa_inicio;
    protected $pausa_fim;
    
    protected $tabela = 'pausas';
    protected $prk = 'idpausas';
    
    protected $where;
    
    protected $camposForm = array(
        						'tabela',
        						'pausa_inicio',
        						'pausa_fim'
    							);
    
    protected $cmpReq   = array(
    						'tabela',
    						'pausa_inicio'
    						);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	
}
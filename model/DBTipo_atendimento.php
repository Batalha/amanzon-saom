<?php

/**
 * Description of DBOS
 *
 * @author Daniel
 */

include_once 'DBModel.php';

class DBTipo_atendimento extends DBModel 
{
    protected $idtipo_atendimento;
    protected $tipo_atendimento;
    
    protected $tabela = 'tipo_atendimento';
    protected $prk    = 'idtipo_atendimento';
    protected $rel    = array('atend_vsat');
    protected $fgk    = array();
    
    protected $camposForm = array(
        						'tipo_atendimento'
    							);
    							
	protected $dadosCarregados; 
	
	//SETS
		
	//SETS - fim
	
	//GETS
		
	//GETS - fim
      
    public function  __construct() 
    {
        parent::__construct();    
    }
    
	
    
}

?>

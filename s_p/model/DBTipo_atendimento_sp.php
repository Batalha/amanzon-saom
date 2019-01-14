<?php

/**
 * Description of DBOS
 *
 * @author Daniel
 */

include_once 's_p/model/DBModel_sp.php';

class DBTipo_atendimento_sp extends DBModel_sp 
{
    protected $idtipo_atendimento;
    protected $tipo_atendimento;
    
    protected $tabela = 'tipo_atendimento_sp';
    protected $prk    = 'idtipo_atendimento';
    protected $rel    = array('atend_vsat_sp');
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

<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBMunicipio extends DBModel 
{
    protected $municipio;
    protected $macroregiao;
        
    protected $tabela = 'municipios';
    protected $prk    = 'idmunicipios';
    protected $defaultOrder = "ASC"; 
    
    protected $camposForm = array(
        						'municipio',
        						'macroregiao'
    							);
      
    public function  __construct()
    {
        parent::__construct();            
    }    
}

?>

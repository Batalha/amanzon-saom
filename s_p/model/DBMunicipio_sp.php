<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBMunicipio_sp extends DBModel_sp 
{
    protected $municipio;
    protected $macroregiao;
        
    protected $tabela = 'municipios_sp';
    protected $prk    = 'idmunicipios_sp';
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

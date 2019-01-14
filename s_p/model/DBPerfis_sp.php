<?php
/**
 * Classe de banco de dados de usuários
 *
 * @author Daniel
 */
include_once 's_p/model/DBModel_sp.php';

class DBPerfis_sp extends DBModel_sp 
{
    
    protected $idperfis;
    protected $perfil;
    protected $descricao;
    
    protected $tabela   = 'perfis';
    protected $prk      = 'idperfis'; 
    protected $rel      = array();
    protected $fgk      = array();
    
    protected $camposForm = array(
        						'perfil',
        						'descricao'
    							);
    
    protected $cmpReq   = array(
    						'perfil',
    						'descricao'
    						);
    						
   	protected $cmpCheckBox = array();
    
    public function  __construct() 
    {
        parent::__construct();    
    }
    
}

?>

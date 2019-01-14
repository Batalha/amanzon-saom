<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBPlano extends DBModel {
    
    protected $idplano;
    protected $plano;
    protected $descricao;
    
    protected $tabela = 'planos';
    protected $prk    = 'idplanos';
        
    protected $camposForm = array(
        
        'plano','descricao'
    );
      
    public function  __construct() {
        
        parent::__construct();    
        
    }    
}

?>

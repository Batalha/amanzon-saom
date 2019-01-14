<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBTesteDemo_sp extends DBModel_sp {

    protected $idteste;
    protected $nomeTeste;

    protected $tabela = 'teste_demo_sp';
    protected $prk    = 'idteste';

    public function  __construct() {
        
        parent::__construct();    
        
    }    
}

?>

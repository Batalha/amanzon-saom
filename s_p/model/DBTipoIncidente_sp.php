<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBTipoIncidente_sp extends DBModel_sp {

    protected $idtipo;
    protected $nomeTipo;

    protected $tabela = 'tipo_incidente_sp';
    protected $prk    = 'idtipo';

    public function  __construct() {
        
        parent::__construct();    
        
    }    
}

?>

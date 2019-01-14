<?php

/**
 * Description of OS
 *
 * @author Daniel
 */
include_once 's_p/model/DBRealocacao_sp.php';

class Realocacao_sp extends Controller {
    
    protected $tplDir = 'realocacao';
    
    function __construct() {
        
        parent::__construct();
        $this->DB = new DBRealocacao_sp();
    }
    
}

?>

<?php

/**
 * Description of OS
 *
 * @author Daniel
 */
include_once 'model/DBRealocacao.php';

class Realocacao extends Controller {
    
    protected $tplDir = 'realocacao';
    
    function __construct() {
        
        parent::__construct();
        $this->DB = new DBRealocacao();
    }
    
}

?>

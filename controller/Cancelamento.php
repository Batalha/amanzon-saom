<?php

/**
 * Description of OS
 *
 * @author Daniel
 */
include_once 'model/DBCancelamento.php';

class Cancelamento extends Controller {
    
    protected $tplDir = 'cancelamento';
    
    function __construct() {
        
        parent::__construct();
        $this->DB = new DBCancelamento();
    }
    
}

?>

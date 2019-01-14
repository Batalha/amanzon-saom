<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OS
 *
 * @author Daniel
 */
include_once 'model/DBPlano.php';

class Plano extends Controller {
    
    protected $tplDir = 'plano';
    
    function __construct() {
        
        parent::__construct();
        $this->DB = new DBPlano();
    }  
}

?>
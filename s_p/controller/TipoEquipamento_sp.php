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
include_once 's_p/model/DBTipoEquipamento_sp.php';

class TipoEquipamento_sp extends Controller {
    
    protected $tplDir = 'tipo_equipamento';
    
    function __construct() {
        
        parent::__construct();
        $this->DB = new DBTipoEquipamento_sp();
    }  
}

?>
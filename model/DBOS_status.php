<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBOS_status
 *
 * @author Sávio
 */
include_once 'DBOS_status.php';

class DBStatus_atend extends DBModel 
{
    protected $idos_status;
    protected $status;
    protected $descricao;
    
    protected $tabela = 'os_status';
    protected $prk = 'idos_status';
    
    protected $camposForm = array(
        						'status',
        						'descricao'
    							);
      
    public function  __construct() 
    {
        parent::__construct();    
    }
}

?>

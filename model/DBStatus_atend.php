<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBOS
 *
 * @author Sávio
 */
include_once 'DBModel.php';

class DBStatus_atend extends DBModel 
{
    protected $idstatus_atend;
    protected $status;
    protected $descricao;
    
    protected $tabela = 'status_atend';
    protected $prk = 'idstatus_atend';
    
    protected $camposForm = array(
        						'atendimento',
        						'status_atend_idstatus_atend',
        						'instalacoes_idinstalacoes',
        						'usuarios_idusuarios'
    							);
      
    public function  __construct() 
    {
        parent::__construct();    
    }
}

?>

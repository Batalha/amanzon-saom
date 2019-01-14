<?php


/**
 * Description of DBOS
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBCancelamento extends DBModel {
    
    protected $idcancelamentos;
    protected $motivo;
    protected $data;
    protected $instalacoes_idinstalacoes;
    protected $atend_vsat_idatend_vsat;
    

    protected $tabela = 'cancelamentos';
    protected $rel    = array('instalacoes');
    protected $fgk    = array('instalacoes_idinstalacoes');
    protected $prk    = 'idcancelamentos';
    
        
    protected $camposForm = array(
        
        'motivo','instalacoes_idinstalacoes'
    );
      
    public function  __construct() {
        
        parent::__construct();    
    }    
}

?>

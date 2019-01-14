<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBMudaPlano extends DBModel {
    
    protected $idmuda_plano;
    protected $idplano_anterior;
    protected $observacao;
    protected $planos_idplanos;
    protected $atend_vsat_idatend_vsat;
    protected $instalacoes_idinstalacoes;
    
    protected $tabela = 'muda_plano';
    protected $prk    = 'idmuda_plano';
    
    protected $rel    = array('planos','instalacoes');
    
    protected $fgk    = array('planos_idplanos','instalacoes_idinstalacoes');
    
    protected $depends= array('planos_idplano_anterior');
    
    protected $camposForm = array(
        
        'planos_idplano_anterior','observacao','planos_idplanos','instalacoes_idinstalacoes'
    );
      
    public function  __construct() {
        
        parent::__construct();            
    }    
}

?>

<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBMudaPlano_sp extends DBModel_sp {
    
    protected $idmuda_plano;
    protected $idplano_anterior;
    protected $observacao;
    protected $planos_idplanos;
    protected $atend_vsat_idatend_vsat;
    protected $instalacoes_idinstalacoes;
    
    protected $tabela = 'muda_plano';
    protected $prk    = 'idmuda_plano';
    
    protected $rel    = array('planos','instalacoes_sp');
    
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

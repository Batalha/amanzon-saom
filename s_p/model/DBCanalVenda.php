<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBCanalVenda extends DBModel_sp {
    
    protected $idcanal_venda;
    protected $plano;
    protected $servico;
    protected $fc15;
    protected $fc110;
    protected $fc120;
    protected $adesao;
    
    protected $tabela = 'canal_venda';
    protected $prk    = 'idcanal_venda';
        
    protected $camposForm = array(
    							'plano',
    							'servico',
    							'fc15',
    							'fc110',
    							'fc120',
    							'adesao',
    							);
      
    public function  __construct() {
        
        parent::__construct();    
        
    }    
}

?>

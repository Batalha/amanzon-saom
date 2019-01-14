<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBSoliciatacao_sp extends DBModel_sp {

    protected $idsolicitacao;
    protected $status;
    protected $descricao;

    protected $tabela = 'solicitacao_sp';
    protected $prk    = 'idsolicitacao';

    public function  __construct() {
        
        parent::__construct();    
        
    }    
}

?>

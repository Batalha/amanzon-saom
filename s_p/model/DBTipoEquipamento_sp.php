<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBTipoEquipamento_sp extends DBModel_sp {
    
    protected $idtipo_equipamento;
    protected $nome;
    protected $descricao;
    
    protected $tabela = 'tipo_equipamentos_sp';
    protected $prk    = 'idtipo_equipamentos_sp';
        
    protected $camposForm = array(
    							'nome',
    							'descricao'
    							);
      
    public function  __construct() {
        
        parent::__construct();
        
    }    
}

?>

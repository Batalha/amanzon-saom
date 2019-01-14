<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBTipoEquipamento extends DBModel {
    
    protected $idtipo_equipamento;
    protected $nome;
    protected $descricao;
    
    protected $tabela = 'tipo_equipamentos';
    protected $prk    = 'idtipo_equipamentos';
        
    protected $camposForm = array(
    							'nome',
    							'descricao'
    							);
      
    public function  __construct() {
        
        parent::__construct();    
        
    }    
}

?>

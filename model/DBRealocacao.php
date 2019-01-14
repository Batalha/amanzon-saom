<?php


/**
 * Description of DBOS
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBRealocacao extends DBModel {
    
    protected $idrealocacao;
    protected $latitude;
    protected $longitude;
    protected $UF;
    protected $municipio;
    protected $cod_area;
    protected $cep;
    protected $endereco;
    protected $cidade;
    

    protected $tabela = 'realocacao';
    protected $rel    = array('instalacoes');
    protected $fgk    = array('instalacoes_idinstalacoes');
    protected $prk    = 'idrealocacao';
    
        
    protected $camposForm = array(
        
        'latitude','longitude','cep','cod_area','cidade','bairro','endereco','instalacoes_idinstalacoes'
    );
      
    public function  __construct() {
        
        parent::__construct();    
    }    
}

?>

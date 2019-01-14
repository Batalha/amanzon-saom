<?php
/**
 * Created by PhpStorm.
 * User: celio
 * Date: 02/04/2015
 * Time: 10:05
 */

include_once 's_p/model/DBModel_sp.php';

class DBEstados extends DBModel_sp {

    protected $sigla;
    protected $nome;

    protected $tabela = 'estados';
    protected $prk    = 'idestados';
    protected $defaultOrder = "ASC";

    protected $camposForm = array(
        'sigla',
        'nome'
    );

    public function  __construct()
    {
        parent::__construct();
    }

}
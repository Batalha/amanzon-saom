<?php

/**
 * Created by PhpStorm.
 * User: celio
 * Date: 02/06/2017
 * Time: 09:52
 */
include_once 'helpers/AdapterZend.php';
include_once 'helpers/Controller.php';

class Interno_sp extends Controller
{

    protected $tplDir = 's_p/tampletes/interno';


    public function __construct()
    {
        parent::__construct();
    }

    public function create(){



        $this->smarty->display("{$this->tplDir}/new.tpl");

    }

}
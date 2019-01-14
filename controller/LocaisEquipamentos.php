<?php


include_once "Controller.php";
require_once "model/LocaisEquipamentosModel.php";


class LocaisEquipamentos extends Controller
{
	
	protected $tplDir = 'locais_equipamentos';
	
	function __construct() 
	{
        parent::__construct();
        $this->DB = new LocaisEquipamentosModel( $this->adapter->getAdapterZend() );
    }
    
	public function liste()
	{
		$equipamentosModel = new LocaisEquipamentosModel( $this->adapter->getAdapterZend() );
		$lista_equipamentos_model = $equipamentosModel->lista();
		//print_b( $lista_equipamentos_model , true );
		
		$this->smarty->assign('arr',$lista_equipamentos_model);
		$this->smarty->display("{$this->tplDir}/list.tpl");
	}
	
}
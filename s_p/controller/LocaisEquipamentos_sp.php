<?php


include_once "helpers/Controller.php";
require_once "s_p/model/LocaisEquipamentos_spModel.php";


class LocaisEquipamentos_sp extends Controller
{
	
	protected $tplDir = 's_p/tampletes/locais_equipamentos';
	
	function __construct() 
	{
        parent::__construct();
        $this->DB = new LocaisEquipamentos_spModel( $this->adapter->getAdapterZend() );
    }
    
	public function liste()
	{
		$equipamentosModel = new LocaisEquipamentos_spModel( $this->adapter->getAdapterZend() );
		$lista_equipamentos_model = $equipamentosModel->lista();
		//print_b( $lista_equipamentos_model , true );
//        echo die_json('teste');

		$this->smarty->assign('arr',$lista_equipamentos_model);
		$this->smarty->display("{$this->tplDir}/list.tpl");
	}
	
}
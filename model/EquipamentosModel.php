<?php

require_once 'model/ZendModel.php';

class EquipamentosModel extends ZendModel
{

	protected $_name = 'equipamentos';
	protected $_primary = 'idequipamentos';
	
	protected $_dependentTables = array('EquipamentosLocaisModel');
	
	public function listaLocalidades()
	{
		
	}
	
}
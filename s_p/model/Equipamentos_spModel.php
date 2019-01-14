<?php

require_once 's_p/model/Zend_spModel.php';

class Equipamentos_spModel extends Zend_spModel
{

	protected $_name = 'equipamentos_sp';
	protected $_primary = 'idequipamentos_sp';
	
	protected $_dependentTables = array('EquipamentosLocais_spModel');

	public function listaLocalidades()
	{

	}
	
}
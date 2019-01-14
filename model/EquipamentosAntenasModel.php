<?php

require_once 'model/ZendModel.php';

class EquipamentosAntenasModel extends ZendModel
{

	protected $_name = 'equipamentos_antenas';
	protected $_primary = 'idequipamentos_antenas';
	
	protected $_dependentTables = array('EquipamentosAntenasLocaisModel');
	
}
<?php

require_once 's_p/model/Zend_spModel.php';

class EquipamentosAntenas_spModel extends Zend_spModel
{

	protected $_name = 'equipamentos_antenas_sp';
	protected $_primary = 'idequipamentos_antenas';
	
	protected $_dependentTables = array('EquipamentosAntenasLocais_spModel');
	
}
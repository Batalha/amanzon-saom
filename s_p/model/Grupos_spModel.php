<?php

class Grupos_spModel extends Zend_spModel
{
	
	protected $_name = 'grupos_sp';
	protected $_primary = 'id_grupos';
	
	protected $_dependentTables = array('GruposUsuarios_spModel');
	
}
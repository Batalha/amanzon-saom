<?php

class GruposModel extends ZendModel
{
	
	protected $_name = 'grupos';
	protected $_primary = 'id_grupos';
	
	protected $_dependentTables = array('GruposUsuariosModel');
	
}
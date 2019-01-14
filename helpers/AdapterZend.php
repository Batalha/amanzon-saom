<?php
require_once 'helpers/DbConfig.php';

class AdapterZend
{
	protected $db_zend;
	
	public function getAdapterZend()
	{
	    return new Zend_Db_Adapter_Pdo_Mysql((array) new DbConfig());
	}
}

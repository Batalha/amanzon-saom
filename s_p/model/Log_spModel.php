<?php

require_once 's_p/model/Zend_spModel.php';

class Log_spModel extends Zend_spModel
{
	protected $_name = 'log';
	protected $_primary = 'idlog';
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
}
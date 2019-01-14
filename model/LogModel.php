<?php

require_once 'model/ZendModel.php';

class LogModel extends ZendModel
{
	protected $_name = 'log';
	protected $_primary = 'idlog';
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
}
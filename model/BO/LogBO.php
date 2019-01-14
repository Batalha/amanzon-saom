<?php

require_once 'model/LogModel.php';

class LogBO extends LogModel
{
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
}
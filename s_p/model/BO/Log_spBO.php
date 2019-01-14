<?php

require_once 's_p/model/Log_spModel.php';

class Log_spBO extends Log_spModel
{
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
}
<?php

class Integer
{
	protected $valor;
	
	public function __construct( $numero )
	{

	    $valor = filter_var( $numero , FILTER_VALIDATE_INT ); 
	    $valor = (int) $valor; 
	    if( $valor > 0 )
	    	$this->valor = $valor;
		else
			$this->valor = 'erro';//return false;
	}
	
	public function numero()
	{
		return $this->valor;
	}
}
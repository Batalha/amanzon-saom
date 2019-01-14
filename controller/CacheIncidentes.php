<?php

require_once 'controller/Cache.php';

class CacheIncidentes extends Cache
{
	protected $totalLinhas;
	
	public function setTotalLinhas( $total )
	{
		$this->totalLinhas = $total;
	}
	
	public function getTotalLinhas()
	{
		return $this->totalLinhas;
	}
	
	public function gravaCacheTotalLinhas()
	{
		
	}
	
	public function verificaCacheTotalLinhas()
	{
		
	}
}
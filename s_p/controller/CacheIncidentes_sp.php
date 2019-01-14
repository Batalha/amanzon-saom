<?php

require_once 's_p/controller/Cache_sp.php';

class CacheIncidentes_sp extends Cache_sp
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
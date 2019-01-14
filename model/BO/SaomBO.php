<?php

include_once "model/SaomModel.php";

class SaomBO extends SaomModel
{
	
	public function getsaomPeloNome( $nomeSaom )
	{
		$where = " nome = '{$nomeSaom}' ";
		//exit($where);
		$saom = $this->fetchRow( $this->select()->where( $where ) );
		
		if( $saom != null )
		{
			$this->saomArray = $saom->toArray();
			foreach ( $this->saomArray as $chave => $atributo )
			{
				$this->{"set".$chave}( $atributo );
			}
		}
	}
	
}
<?php

include_once "s_p/model/Saom_spModel.php";

class Saom_spBO extends Saom_spModel
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
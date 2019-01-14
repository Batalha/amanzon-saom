<?php

require_once "model/TipoEquipamentosModel.php";

class TipoEquipamentosBO extends TipoEquipamentosModel
{
	
	/*
	 * tipos de equipamentos permitidos: 2 (sl4033), 3 (sl4035)
	 */
	public function listaEquipamentosODU()
	{
		$where = " idtipo_equipamentos = '2' OR idtipo_equipamentos = '3' ";
		return $this->fetchAll( $where );
	}
	
}
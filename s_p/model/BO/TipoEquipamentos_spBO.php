<?php

require_once "s_p/model/TipoEquipamentos_spModel.php";

class TipoEquipamentos_spBO extends TipoEquipamentos_spModel
{
	
	/*
	 * tipos de equipamentos permitidos: 2 (sl4033), 3 (sl4035)
	 */
	public function listaEquipamentosODU()
	{
		$where = "
				idtipo_equipamentos_sp = '2' OR
				idtipo_equipamentos_sp = '3' OR
				idtipo_equipamentos_sp = '6' OR
				idtipo_equipamentos_sp = '7'";

		return $this->fetchAll($where );
	}
	
}
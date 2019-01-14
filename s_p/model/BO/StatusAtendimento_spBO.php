<?php


include_once "s_p/model/StatusAtendimento_spModel.php";

class StatusAtendimento_spBO extends StatusAtendimento_spModel
{
	protected $listaStatusAtendimentos;
	
	public function getlistaStatusAtendimentos()
	{
		return $this->listaStatusAtendimentos;
	}
	
	public function listaStatusAtendimentos()
	{
		$where = "1";
		$resultado = $this->fetchAll( $where );
//
		$this->listaStatusAtendimentos = $resultado->toArray();
	}
	
}
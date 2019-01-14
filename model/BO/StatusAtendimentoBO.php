<?php


include_once "model/StatusAtendimentoModel.php";

class StatusAtendimentoBO extends StatusAtendimentoModel
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
		$this->listaStatusAtendimentos = $resultado->toArray();
	}
	
}
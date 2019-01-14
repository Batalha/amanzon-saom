<?php

require_once "model/MotivoAtendimentoTipoModel.php";

class MotivoAtendimentoTipoBO extends MotivoAtendimentoTipoModel 
{
	protected $listaMotivoAtendimentoTipo = array();
	
	public function getlistaMotivoAtendimentoTipo()
	{
		return $this->listaMotivoAtendimentoTipo;
	}
	
	public function resgataListaMotivoAtendimentoTipo()
	{
		$lista = $this->fetchAll();
		if( count($lista) > 0 )
		{
			$this->listaMotivoAtendimentoTipo = $lista->toArray();
		}else $this->listaMotivoAtendimentoTipo = array();
	}
	
}
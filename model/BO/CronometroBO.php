<?php

require_once "model/CronometroModel.php";

class CronometroBO extends CronometroModel
{
	protected $CronometrosAtendimentos = array();
	
	
	// para atendimentos
	
	public function getCronometrosDeAtendimento()
	{
		$where = " idreferencia = '{$this->idreferencia}' AND tabelareferencia = '{$this->tabelareferencia}' ";
		$lista = $this->fetchAll( $where );
		if( count($lista) > 0 )
			return $lista->current()->toArray();
		else
			return array();
	}
	
	public function criaCronometroParaAtendimento( $idAtendimento )
	{
		$data = array(
			'idreferencia' => $idAtendimento,
			'inicio_tarefa' => date('Y-m-d H:i:s'),
			'tabelareferencia' => 'atend_vsat'
		);
		return $this->insert( $data );
	}
}
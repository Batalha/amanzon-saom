<?php

require_once "s_p/model/Cronometro_spModel.php";

class Cronometro_spBO extends Cronometro_spModel
{
	protected $CronometrosAtendimentos = array();
	
	
	// para atendimentos
	
	public function getCronometrosDeAtendimento()
	{
		$where = " idreferencia = '{$this->idreferencia}' AND tabelareferencia = '{$this->tabelareferencia}' ";
		$lista = $this->fetchAll( $where );

//		$arr['msg'] = $lista;
//		die_json($arr);
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
			'tabelareferencia' => 'atend_vsat_sp'
		);
		return $this->insert( $data );
	}
}
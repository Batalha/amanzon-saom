<?php

require_once "s_p/model/MotivoAtendimento_spModel.php";

require_once "s_p/model/BO/ResponsavelAtendimento_spBO.php";
require_once 'helpers/AdapterZend.php';

class MotivoAtendimento_spBO extends MotivoAtendimento_spModel
{
	protected $listaMotivos =  array();
	
	public function getlistaMotivos()
	{
		return $this->listaMotivos;
	}
	
	public function resgataListaMotivos()
	{
// 		$adapter = new AdapterZend();
// 		$MotivoAtendimentoTipo = new ResponsavelAtendimentoBO( $adapter->getAdapterZend() );

// 		$MotivoAtendimentoTipo->resgataListaMotivoAtendimentoTipo();
// 		$listaTipos = $MotivoAtendimentoTipo->getlistaMotivoAtendimentoTipo();
		
		
		
// 		foreach ( $listaTipos as $chave => $motivo )
// 		{
// 			$where = " tipo_motivo = '{$motivo['idmotivo_atendimento_tipo']}' ";
			$listaMotivosDeTipo = $this->fetchAll( );
			$lista = $listaMotivosDeTipo->toArray();
// 		}
		

		if( count($lista) > 0 ) 
			
			$this->listaMotivos = $lista;
		else 
			$this->listaMotivos = array();
	}
	

// 	public function resgataListaMotivos()
// 	{
// 		$adapter = new AdapterZend();
// 		$MotivoAtendimentoTipo = new ResponsavelAtendimentoBO( $adapter->getAdapterZend() );

// 		$MotivoAtendimentoTipo->resgataListaMotivoAtendimentoTipo();
// 		$listaTipos = $MotivoAtendimentoTipo->getlistaMotivoAtendimentoTipo();
		
		
		
// 		foreach ( $listaTipos as $chave => $motivo )
// 		{
// 			$where = " tipo_motivo = '{$motivo['idmotivo_atendimento_tipo']}' ";
// 			$listaMotivosDeTipo = $this->fetchAll($where );
// 			$lista[ $motivo['tipo'] ] = $listaMotivosDeTipo->toArray();
// 		}

// 		if( count($lista) > 0 ) 
// 			$this->listaMotivos = $lista;
// 		else $this->listaMotivos = array();

// 	}
}
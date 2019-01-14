<?php

require_once "model/ResponsavelAtendimentoModel.php";

class ResponsavelAtendimentoBO extends ResponsavelAtendimentoModel 
// {
// 	protected $listaResponsavelAtendimento = array();
	
// 	public function getlistaResponsavelAtendimento()
// 	{
// 		return $this->listaResponsavelAtendimento;
// 	}
	
// 	public function resgataListaMotivoAtendimentoTipo()
// 	{
// 		$lista = $this->fetchAll();
// 		if( count($lista) > 0 )
// 		{
// 			$this->listaResponsavelAtendimento = $lista->toArray();
// 		}else $this->listaResponsavelAtendimento = array();
// 	}
	
// }


{
	protected $listaResponsavelAtendimento = array();

	public function getlistaResponsavelAtendimento()
	{
		return $this->listaResponsavelAtendimento;
	}

	public function resgataListaResponsavelAtendimento()
	{
		$lista = $this->fetchAll();
		if( count($lista) > 0 )
			{
				$this->listaResponsavelAtendimento = $lista->toArray();
			}else $this->listaResponsavelAtendimento = array();
		}

	}
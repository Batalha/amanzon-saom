<?php

class TipoAtendimento_spModel extends Zend_spModel
{
	protected $_name = 'tipo_atendimento';
	protected $_primary = 'idtipo_atendimento';
	
	//atributos
	protected $idtipo_atendimento;
	protected $tipo_atendimento;
	
	protected $TipoAtendimentoArray;
	
	public function getTipoAtendimentoArray()
	{
		return $this->TipoAtendimentoArray;
	}
	
	public function setidtipo_atendimento( Integer $idtipo_atendimento )
	{
		$this->idtipo_atendimento = $idtipo_atendimento;
	}
	
	public function settipo_atendimento( $tipo_atendimento )
	{
		$this->tipo_atendimento = $tipo_atendimento;
	}
	
	public function getidtipo_atendimento()
	{
		return $this->idtipo_atendimento;
	}
	
	public function gettipo_atendimento()
	{
		return $this->tipo_atendimento;
	}
	
	public function getTipoAtendimento()
	{
		if( empty($this->idtipo_atendimento) )
			return "Id do Tipo de Atendimento não declarado.";
		
		$where = " idtipo_atendimento = '{$this->idtipo_atendimento->numero()}' ";
		$tipo_atendimento = $this->fetchAll( $this->select()->where( $where ) );

		if( count($tipo_atendimento) > 0 )
		{
			$linha = $tipo_atendimento->toArray();
			$this->TipoAtendimentoArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idtipo_atendimento' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	public function getListaTipoAtendimento( $where = "1" )
	{
		$lista = $this->fetchAll( $where );
		if( count($lista) > 0 )
			return $lista->toArray();
		else
			return array();
	}
}
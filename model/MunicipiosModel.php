<?php

class MunicipiosModel extends ZendModel
{

	protected $_name = 'municipios';
	protected $_primary = 'idmunicipios';
	
	protected $_dependentTables = array('EquipamentosLocaisModel');
	
	// atributos
	protected $idmunicipios;
	protected $municipio;
	protected $macroregiao;
	
	protected $campos = array(
		'idmunicipios',
		'municipio',
		'macroregiao'
	);
	
	protected $municipiosArray = array();
	
	public function getmunicipiosarray()
	{
		return $this->municipiosArray;
	}
	
	public function getidmunicipios()
	{
		return $this->idmunicipios;
	}
	public function getmunicipio()
	{
		return $this->municipio;
	}
	public function getmacroregiao()
	{
		return $this->macroregiao;
	}
	
	public function setidmunicipios( Integer $idmunicipios )
	{
		$this->idmunicipios = $idmunicipios->numero();
	}
	public function setmunicipio( $municipio )
	{
		$this->municipio = $municipio;
	}
	public function setmacroregiao( $macroregiao )
	{
		$this->macroregiao = $macroregiao;
	}
	
	
	public function getMunicipioObject()
	{
		if( empty($this->idmunicipios) )
			return "Id do Município não declarado.";

		$where = " idmunicipios = '{$this->idmunicipios}' ";
		$municipios = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($municipios) > 0 )
		{
			$linha = $municipios->toArray();
			$this->municipiosArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idmunicipios' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}

}
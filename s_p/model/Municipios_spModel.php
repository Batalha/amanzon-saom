<?php

class Municipios_spModel extends Zend_spModel
{

	protected $_name = 'municipios_sp';
	protected $_primary = 'idmunicipios_sp';
	
	protected $_dependentTables = array('EquipamentosLocais_spModel');
	
	// atributos
	protected $idmunicipios_sp;
	protected $municipio;
	protected $macroregiao;
	
	protected $campos = array(
		'idmunicipios_sp',
		'municipio',
		'macroregiao'
	);

	protected $municipiosArray = array();
	
	public function getmunicipiosarray()
	{
		return $this->municipiosArray;
	}
	
	public function getidmunicipios_sp()
	{
		return $this->idmunicipios_sp;
	}
	public function getmunicipio()
	{
		return $this->municipio;
	}
	public function getmacroregiao()
	{
		return $this->macroregiao;
	}
	
	public function setidmunicipios_sp( Integer $idmunicipios_sp )
	{
		$this->idmunicipios_sp = $idmunicipios_sp->numero();
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
		if( empty($this->idmunicipios_sp) )
			return "Id do Município não declarado.";

		$where = " idmunicipios_sp = '{$this->idmunicipios_sp}' ";
		$municipios = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($municipios) > 0 )
		{
			$linha = $municipios->toArray();
			$this->municipiosArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idmunicipios_sp' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}

}
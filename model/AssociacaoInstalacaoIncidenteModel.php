<?php

require_once "model/ZendModel.php";

class AssociacaoInstalacaoIncidenteModel extends ZendModel
{
	
	protected $_name = 'associacao_instalacao_incidente';
	protected $_primary = 'idassociacao_instalacao_incidente';
	
	protected $_referenceMap = array(
        'Instalacao' => array(
            'columns'           => 'idinstalacoes',
            'refTableClass'     => 'InstalacoesBO',
            'refColumns'        => 'idinstalacoes'
        ),
        'Incidente' => array(
            'columns'           => 'idincidentes',
            'refTableClass'     => 'IncidentesBO',
            'refColumns'        => 'idincidentes'
        ),
        'Prodemge' => array(
            'columns'           => 'idprodemge',
            'refTableClass'     => 'ProdemgeBO',
            'refColumns'        => 'idprodemge'
        )
	);
	
	//atributos
	
	protected $idassociacao_instalacao_incidente;
	protected $idinstalacoes;
	protected $idincidentes;
	protected $idprodemge;
	
	protected $campos = array(
		'idinstalacoes',
		'idincidentes',
		'idprodemge'
	);
	
	public function setidassociacao_instalacao_incidente( $idassociacao_instalacao_incidente )
	{
		$this->idassociacao_instalacao_incidente = $idassociacao_instalacao_incidente;
	}
	public function setidinstalacoes( $idinstalacoes )
	{
		$this->idinstalacoes  = $idinstalacoes;
	}
	public function setidincidentes( $idincidentes )
	{
		$this->idincidentes  = $idincidentes;
	}
	public function setidprodemge( $idprodemge )
	{
		$this->idprodemge  = $idprodemge;
	}
	
	public function getidassociacao_instalacao_incidente()
	{
		return $this->idassociacao_instalacao_incidente;
	}
	public function getidinstalacoes()
	{
		return $this->idinstalacoes;
	}
	public function getidincidentes()
	{
		return $this->idincidentes;
	}
	public function getidprodemge()
	{
		return $this->idprodemge;
	}
	
	
	public function create()
	{
		foreach( $this->campos as $campo )
		{
			$data[ $campo ] = $this->{'get'.$campo}();
		}
		$idAssociacao = $this->insert( $data );
		if( $idAssociacao )
			return $idAssociacao;
		else
			return false;
	}
	
	
}
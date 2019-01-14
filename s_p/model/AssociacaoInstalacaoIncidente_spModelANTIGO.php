<?php

require_once "s_p/model/Zend_spModel.php";

class AssociacaoInstalacaoIncidente_spModel extends Zend_spModel
{
	
	protected $_name = 'associacao_instalacao_incidente_sp';
	protected $_primary = 'idassociacao_instalacao_incidente';
	
	protected $_referenceMap = array(
        'Instalacao' => array(
            'columns'           => 'idinstalacoes_sp',
            'refTableClass'     => 'Instalacoes_spBO',
            'refColumns'        => 'idinstalacoes_sp'
        ),
        'Incidente' => array(
            'columns'           => 'idincidentes',
            'refTableClass'     => 'Incidentes_spBO',
            'refColumns'        => 'idincidentes_sp'
        ),
        'Prodemge' => array(
            'columns'           => 'idprodemge',
            'refTableClass'     => 'Prodemge_spBO',
            'refColumns'        => 'idprodemge'
        )
	);
	
	//atributos
	
	protected $idassociacao_instalacao_incidente;
	protected $idinstalacoes_sp;
	protected $idincidentes;
	protected $idprodemge;
	
	protected $campos = array(
		'idinstalacoes_sp',
		'idincidentes',
		'idprodemge'
	);
	
	public function setidassociacao_instalacao_incidente( $idassociacao_instalacao_incidente )
	{
		$this->idassociacao_instalacao_incidente = $idassociacao_instalacao_incidente;
	}
	public function setidinstalacoes_sp( $idinstalacoes_sp )
	{
		$this->idinstalacoes_sp  = $idinstalacoes_sp;
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
	public function getidinstalacoes_sp()
	{
		return $this->idinstalacoes_sp;
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
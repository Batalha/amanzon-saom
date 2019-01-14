<?php

require_once 'model/ZendModel.php';
require_once 'model/AdapterZend.php';

class MotivoAtendimentoTipoModel extends ZendModel
{

	protected $_name = 'motivo_atendimento_tipo';
	protected $_primary = 'idmotivo_atendimento_tipo';
	
	// dados
	
	protected $idmotivo_atendimento_tipo;
	protected $tipo;
	
	protected $campos = array(
		'tipo'
	);
	
	
	public function __construct( $adapter )
	{
		$adapter = new AdapterZend();
		parent::__construct( $adapter->getAdapterZend() );
	}
	
	
	public function setidmotivo_atendimento_tipo( $idmotivo_atendimento_tipo )
	{
		$this->idmotivo_atendimento_tipo = $idmotivo_atendimento_tipo;
	}
	public function settipo( $tipo )
	{
		$this->tipo = $tipo;
	}
	
	public function getidmotivo_atendimento_tipo()
	{
		return $this->idmotivo_atendimento_tipo;
	}
	public function gettipo()
	{
		return $this->tipo;
	}

}
<?php

require_once 'model/ZendModel.php';
require_once 'helpers/AdapterZend.php';

class ResponsavelAtendimentoModel extends ZendModel
{

// 	protected $_name = 'motivo_atendimento_tipo';
// 	protected $_primary = 'idmotivo_atendimento_tipo';
// 	protected $idmotivo_atendimento_tipo;
// 	protected $tipo;
	
// 	protected $campos = array(
// 		'tipo'

// 	);

// 	public function setidmotivo_atendimento_tipo( $idmotivo_atendimento_tipo )
// 	{
// 		$this->idmotivo_atendimento_tipo = $idmotivo_atendimento_tipo;
// 	}
// 	public function settipo( $tipo )
// 	{
// 		$this->tipo = $tipo;
// 	}
	
// 	public function getidmotivo_atendimento_tipo()
// 	{
// 		return $this->idmotivo_atendimento_tipo;
// 	}
// 	public function gettipo()
// 	{
// 		return $this->tipo;
// 	}

	
	
	protected $_name = 'responsavel_atendimento';
	protected $_primary = 'idresponsavel_atendimento';
	protected $idresponsavel_atendimento;
	protected $responsavel;
	
	protected $responsavel_atendimentoArray = array();
	
	protected $campos = array(
		'responsavel'
	);
	
	
	
	public function __construct( $adapter )
	{
		$adapter = new AdapterZend();
		parent::__construct( $adapter->getAdapterZend() );
	}
	
	public function setidresponsavel_atendimento( $idresponsavel_atendimento )
	{
		$this->idresponsavel_atendimento = $idresponsavel_atendimento;
	}
	public function setresponsavel( $responsavel )
	{
		$this->responsavel = $responsavel;
	}
	
	public function getidresponsavel_atendimento()
	{
		return $this->idresponsavel_atendimento;
	}
	public function getresponsavel()
	{
		return $this->responsavel;
	}	
	

}
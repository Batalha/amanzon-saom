<?php

require_once 'model/ZendModel.php';
require_once 'helpers/AdapterZend.php';

class MotivoAtendimentoModel extends ZendModel
{

// 	protected $_name = 'motivo_atendimento';
// 	protected $_primary = 'idmotivo_atendimento';
	
// 	// dados
	
// 	protected $idmotivo_atendimento;
// 	protected $tipo_motivo;
// 	protected $motivo;
	
// 	protected $motivo_atendimentoArray = array();
	
// 	protected $campos = array(
// 		'tipo_motivo',
// 		'motivo'
// 	);
	protected $_name = 'motivo_atendimentoteste';
	protected $_primary = 'idmotivo_atendimento';
	
	// dados
	
	protected $idmotivo_atendimento;
	protected $motivo;
	
	protected $motivo_atendimentoArray = array();
	
	protected $campos = array(
		'motivo'
	);
	
	
	public function __construct( $adapter )
	{
		$adapter = new AdapterZend();
		parent::__construct( $adapter->getAdapterZend() );
	}
	
	
	public function setidmotivo_atendimento( $idmotivo_atendimento )
	{
		$this->idmotivo_atendimento = $idmotivo_atendimento;
	}

	public function setmotivo( $motivo )
	{
		$this->motivo = $motivo;
	}
	
	public function getidmotivo_atendimento()
	{
		return $this->idmotivo_atendimento;
	}

	public function getmotivo()
	{
		return $this->motivo;
	}
	
	
	
// 	public function setidmotivo_atendimento( $idmotivo_atendimento )
// 	{
// 		$this->idmotivo_atendimento = $idmotivo_atendimento;
// 	}
// 	public function settipo_motivo( $tipo_motivo )
// 	{
// 		$this->tipo_motivo = $tipo_motivo;
// 	}
// 	public function setmotivo( $motivo )
// 	{
// 		$this->motivo = $motivo;
// 	}
	
// 	public function getidmotivo_atendimento()
// 	{
// 		return $this->idmotivo_atendimento;
// 	}
// 	public function gettipo_motivo()
// 	{
// 		return $this->tipo_motivo;
// 	}
// 	public function getmotivo()
// 	{
// 		return $this->motivo;
// 	}
	
	
// 	public function getmotivo_atendimentoArray()
// 	{
// 		return $this->motivo_atendimentoArray;
// 	}
	
// 	public function getMotivoAtendimentoObject()
// 	{
// 		if( empty($this->idmotivo_atendimento) )
// 			return "Id do motivo do atendimento não declarado.";
			
// 		$where = " idmotivo_atendimento = '{$this->idmotivo_atendimento}' ";
// 		$motivo_atendimento = $this->fetchAll( $where );

// 		if( count($motivo_atendimento) > 0 )
// 		{
// 			$linha = $motivo_atendimento->toArray();
// 			$this->motivo_atendimentoArray = $linha[0];
// 			foreach ( $linha[0] as $chave => $atributo )
// 			{
// 				if( $chave != 'idmotivo_atendimento' )
// 					$this->{"set".$chave}( $atributo );
// 			}
// 		}
// 	}

}
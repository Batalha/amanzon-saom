<?php

require_once "model/ZendModel.php";

require_once "helpers/DB.php";

class AssociacaoAtendimentoMotivoModel extends ZendModel
{
		
	protected $_name = 'atendimento_motivo_responsavel';
	protected $_primary = 'idatendimento_motivo_responsavel';
	
	protected $_referenceMap = array(
        'Instalacao' => array(
            'columns'           => 'idatendimento',
            'refTableClass'     => 'AtendVsatBO',
            'refColumns'        => 'idatend_vsat'
        ),
        'Motivo' => array(
            'columns'           => 'idmotivo',
            'refTableClass'     => 'MotivoAtendimentoBO',
            'refColumns'        => 'idmotivo_atendimento'
        ),
        'Responsavel' => array(
            'columns'           => 'idresponsavel',
            'refTableClass'     => 'ResponsavelAtendimentoBO',
            'refColumns'        => 'idresponsavel_atendimento'
        )
	);
	
	//atributos
	
	protected $idatendimento_motivo_responsavel;
	protected $idatendimento;
	protected $idmotivo;
	protected $idresponsavel;
	
	protected $campos = array(
		'idatendimento',
		'idmotivo',
		'idresponsavel'
	);
	
// 	protected $_name = 'associacao_atendimento_motivo';
// 	protected $_primary = 'idassociacao_atendimento_motivo';
// 	protected $_referenceMap = array(
//         'Instalacao' => array(
//             'columns'           => 'idatendimento',
//             'refTableClass'     => 'AtendVsatBO',
//             'refColumns'        => 'idatend_vsat'
//         ),
//         'Motivo' => array(
//             'columns'           => 'idmotivo',
//             'refTableClass'     => 'MotivoAtendimentoBO',
//             'refColumns'        => 'idmotivo_atendimento'
//         )
// 	);
// 	protected $idassociacao_atendimento_motivo;
// 	protected $idatendimento;
// 	protected $idmotivo;
	
// 	protected $campos = array(
// 		'idatendimento',
// 		'idmotivo'
// 	);

	
	protected $DBPadrao;
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
		
		$this->DBPadrao = new DB();
	}
	
	
	public function setidatendimento_motivo_responsavel( $idatendimento_motivo_responsavel )
	{
		$this->idatendimento_motivo_responsavel = $idatendimento_motivo_responsavel;
	}
	public function setidatendimento( $idatendimento )
	{
		$this->idatendimento  = $idatendimento;
	}
	public function setidmotivo( $idmotivo )
	{
		$this->idmotivo  = $idmotivo;
	}
	public function setidresponsavel($idresponsavel)
	{
		$this->idresponsavel = $idresponsavel;
	}
	
	public function getidatendimento_motivo_responsavel()
	{
		return $this->idatendimento_motivo_responsavel;
	}
	public function getidatendimento()
	{
		return $this->idatendimento;
	}
	public function getidmotivo()
	{
		return $this->idmotivo;
	}
	public function getidresponsavel()
	{
		return $this->idresponsavel;
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
	
// 	public function setidassociacao_atendimento_motivo( $idassociacao_atendimento_motivo )
// 	{
// 		$this->idassociacao_atendimento_motivo = $idassociacao_atendimento_motivo;
// 	}
// 	public function setidatendimento( $idatendimento )
// 	{
// 		$this->idatendimento  = $idatendimento;
// 	}
// 	public function setidmotivo( $idmotivo )
// 	{
// 		$this->idmotivo  = $idmotivo;
// 	}
	
// 	public function getidassociacao_atendimento_motivo()
// 	{
// 		return $this->idassociacao_atendimento_motivo;
// 	}
// 	public function getidatendimento()
// 	{
// 		return $this->idatendimento;
// 	}
// 	public function getidmotivo()
// 	{
// 		return $this->idmotivo;
// 	}
	
	
// 	public function create()
// 	{
// 		foreach( $this->campos as $campo )
// 		{

// 			$data[ $campo ] = $this->{'get'.$campo}();
// 		}
// 		$idAssociacao = $this->insert( $data );
// 		if( $idAssociacao )
// 			return $idAssociacao;
// 		else
// 			return false;
// 	}
	
	
}
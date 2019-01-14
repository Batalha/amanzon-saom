<?php

require_once 'model/ZendModel.php';
require_once 'helpers/AdapterZend.php';

class AtendVsatModel extends ZendModel
{

	protected $_name = 'atend_vsat';
	protected $_primary = 'idatend_vsat';
	protected $_rowClass = 'AtendVsatModel';
	
	// dados
	
	protected $idatend_vsat;
	protected $data;
	protected $atendimento;
	protected $status_atend_idstatus_atend;
	protected $usuarios_idusuarios;
	protected $incidentes_idincidentes;
	protected $resposta_agilis;
	protected $tipo_atendimento_idtipo_atendimento;
	protected $atendimento_pai;
	protected $saom;
	protected $idmotivo_atendimento;
	
	protected $atendimentoArray = array();
	
	protected $campos = array(
		'data',
		'atendimento',
		'status_atend_idstatus_atend',
		'usuarios_idusuarios',
		'incidentes_idincidentes',
		'resposta_agilis',
		'tipo_atendimento_idtipo_atendimento',
		'atendimento_pai',
		'saom'
	);
	
	
	public function __construct( $adapter )
	{
		$adapter = new AdapterZend();
		parent::__construct( $adapter->getAdapterZend() );
	}
	
	
	public function setidatend_vsat( $idatend_vsat )
	{
		$this->idatend_vsat = $idatend_vsat;
	}
	public function setdata( $data )
	{
		$this->data = $data;
	}
	public function setatendimento( $atendimento )
	{
		$this->atendimento = $atendimento;
	}
	public function setstatus_atend_idstatus_atend( $status_atend_idstatus_atend )
	{
		$this->status_atend_idstatus_atend  = $status_atend_idstatus_atend;
	}
	public function setusuarios_idusuarios( $usuarios_idusuarios )
	{
		$this->usuarios_idusuarios = $usuarios_idusuarios;
	}
	public function setincidentes_idincidentes( $incidentes_idincidentes )
	{
		$this->incidentes_idincidentes = $incidentes_idincidentes;
	}
	public function setresposta_agilis( $resposta_agilis )
	{
		$this->resposta_agilis = $resposta_agilis;
	}
	public function settipo_atendimento_idtipo_atendimento( $tipo_atendimento_idtipo_atendimento )
	{
		$this->tipo_atendimento_idtipo_atendimento = $tipo_atendimento_idtipo_atendimento;
	}
	public function setatendimento_pai( $atendimento_pai )
	{
		$this->atendimento_pai =  $atendimento_pai;
	}
	public function setsaom( $saom )
	{
		$this->saom = $saom;
	}
	
	public function getidatend_vsat()
	{
		return $this->idatend_vsat;
	}
	public function getdata()
	{
		return $this->data;
	}
	public function getatendimento()
	{
		return $this->atendimento;
	}
	public function getstatus_atend_idstatus_atend()
	{
		return $this->status_atend_idstatus_atend;
	}
	public function getusuarios_idusuarios()
	{
		return $this->usuarios_idusuarios;
	}
	public function getincidentes_idincidentes()
	{
		return $this->incidentes_idincidentes;
	}
	public function getresposta_agilis()
	{
		return $this->resposta_agilis;
	}
	public function gettipo_atendimento_idtipo_atendimento()
	{
		return $this->tipo_atendimento_idtipo_atendimento;
	}
	public function getatendimento_pai()
	{
		return $this->atendimento_pai;
	}
	public function getsaom()
	{
		return $this->saom;
	}
	
	public function getatendimentoArray()
	{
		return $this->atendimentoArray;
	}
	
	public function getAtendimentoObject()
	{
		if( empty($this->idatend_vsat) )
			return "Id do atendimento não declarado.";
			
		$where = " idatend_vsat = '{$this->idatend_vsat}' ";
		$atendimentos = $this->fetchAll( $where );
		if( count($atendimentos) > 0 )
		{
			$linha = $atendimentos->toArray();
			$this->atendimentoArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idatend_vsat' 
					&& $chave != 'instalacoes_idinstalacoes'
					&& $chave != 'idmotivo_atendimento' )//TODO: solucao temporária até  excluir o campo instalacoes_idinstalacoes
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	public function edit()
	{
		$where = " idatend_vsat = '{$this->getidatend_vsat()}' ";
		foreach ( $this->campos as $chave => $campo ) {
			$data[ $campo ] = $this->{'get'.$campo}();	
		}
		if( $this->update( $data , $where ) )
			return 'ok';
		else
			return 'erro';
	}
	
	public function create()
	{
		$arrayData = array();
		foreach( $this->campos as $chave => $campo )
		{
			$arrayData[$campo] = $this->{"get".$campo}();
		}
		return $this->insert( $arrayData );
	}

}
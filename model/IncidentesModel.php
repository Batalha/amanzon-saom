<?php

require_once 'model/ZendModel.php';
require_once 'helpers/AdapterZend.php';

require_once 'model/InstalacoesModel.php';
require_once 'model/AssociacaoInstalacaoIncidenteModel.php';

include_once "helpers/Utilitarios.php";

class IncidentesModel extends ZendModel
{

	protected $_name = 'incidentes';
	protected $_primary = 'idincidentes';
	//protected $_rowClass = 'IncidentesModel';
	
	// atributos
	protected $idincidentes;
	protected $idprodemge;
	protected $descricao;
	protected $data;
	protected $prioridade;
	protected $instalacoes_idinstalacoes;
	protected $atend_vsat_idatend_vsat;
	protected $tecnicoNoc;
	protected $saom;
	protected $data_modificacao;
	// atributos de relacionamentos
	protected $instalacoes;
	protected $prodemge;
	
	protected $incidenteArray = array();
	
	protected $campos = array(
		'idprodemge',
		'descricao',
		'data',
		'prioridade',
		'instalacoes_idinstalacoes',
		'atend_vsat_idatend_vsat',
		'tecnicoNoc',
		'saom',
		'data_modificacao'
	);
	
	public function __construct( $adapter )
	{
		$adapter = new AdapterZend();
		parent::__construct( $adapter->getAdapterZend() );
	}
	
	public function setidincidentes( Integer $idincidentes )
	{
		$this->idincidentes = $idincidentes->numero();
	}
	public function setidprodemge ( $idprodemge )
	{
		$this->idprodemge = $idprodemge;
	}
	public function setdescricao ( $descricao )
	{
		$this->descricao = $descricao;
	}
	public function setdata ( $data )
	{
		$this->data = $data;
	}
	public function setprioridade ( $prioridade )
	{
		$this->prioridade = $prioridade;
	}
	public function setinstalacoes_idinstalacoes ( $instalacoes_idinstalacoes )
	{
		$this->instalacoes_idinstalacoes = $instalacoes_idinstalacoes;
	}
	public function setatend_vsat_idatend_vsat ( $atend_vsat_idatend_vsat )
	{
		$this->atend_vsat_idatend_vsat = $atend_vsat_idatend_vsat;
	}
	public function settecnicoNoc ( $tecnicoNoc )
	{
		$this->tecnicoNoc = $tecnicoNoc;
	}
	public function setsaom ( $saom )
	{
		$this->saom = $saom;
	}
	
	
	public function setinstalacoes( $instalacoes )
	{
		$this->instalacoes = $instalacoes;
	}
	
	
	public function setprodemge( $prodemge )
	{
		$this->prodemge = $prodemge;
	}
	
	
	public function setorigem_incidente( $origem_incidente )
	{
		$this->origem_incidente = $origem_incidente;
	}
	public function setdata_modificacao( $data_modificacao )
	{
		$this->data_modificacao = $data_modificacao;
	}
	
	public function getidincidentes ()
	{
		return $this->idincidentes;
	}
	public function getidprodemge ()
	{
		return $this->idprodemge;
	}
	public function getdescricao ()
	{
		return $this->descricao;
	}
	public function getdata ()
	{
		return $this->data;
	}
	public function getprioridade ()
	{
		return $this->prioridade;
	}
	public function getinstalacoes_idinstalacoes ()
	{
		return $this->instalacoes_idinstalacoes;
	}
	public function getatend_vsat_idatend_vsat ()
	{
		return $this->atend_vsat_idatend_vsat;
	}
	public function gettecnicoNoc ()
	{
		return $this->tecnicoNoc;
	}
	public function getsaom ()
	{
		return $this->saom;
	}
	public function getincidenteArray()
	{
		return $this->incidenteArray;
	}
	public function getinstalacoes()
	{
		return $this->instalacoes;
	}

	
	public function getprodemge()
	{
		return $this->prodemge;
	}
	
	
	public function getorigem_incidente()
	{
		return $this->origem_incidente;
	}
	public function getdata_modificacao()
	{
		return $this->data_modificacao;
	}
	
	
	public function getIncidente()
	{
		if( empty($this->idincidentes) )
			return "Id do incidente não declarado.";
		
		$where = " idincidentes = '{$this->idincidentes}' ";
		//exit($where);
//		echo die_json($where);exit;
		$incidente = $this->fetchRow( $this->select()->where( $where ) );

//		echo die_json($incidente);
//		print_r($incidente);
		if( $incidente != null )
		{
			$this->incidenteArray = $incidente->toArray();
			foreach ( $this->incidenteArray as $chave => $atributo )
			{
				if( $chave != 'idincidentes' )
					$this->{"set".$chave}( $atributo );
			}
		}
		
		$this->instalacoes = $incidente->findInstalacoesBOViaAssociacaoInstalacaoIncidenteModel();
		$this->prodemge = $incidente->findProdemgeBOViaAssociacaoInstalacaoIncidenteModel();
		$this->incidenteArray['instalacoes'] = $this->instalacoes->toArray();
		$this->incidenteArray['prodemge'] = $this->prodemge->toArray();

//		echo die_json('teste');
	}
	
	public function edit()
	{
		$where = " idincidentes = '{$this->getidincidentes()}' ";
		foreach ( $this->campos as $chave => $campo ) {
			$data[ $campo ] = $this->{'get'.$campo}();	
		}
		
		if( $this->update( $data , $where ) )
			return 'ok';
		else
			return 'erro';
	}

}
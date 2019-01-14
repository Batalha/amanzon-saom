<?php

require_once 's_p/model/Zend_spModel.php';
require_once 'helpers/AdapterZend.php';

require_once 's_p/model/Instalacoes_spModel.php';
require_once 's_p/model/AssociacaoInstalacaoIncidente_spModel.php';

include_once "helpers/Utilitarios.php";

class Incidentes_spModel extends Zend_spModel
{

	protected $_name = 'incidentes_sp';
	protected $_primary = 'idincidentes';
	//protected $_rowClass = 'IncidentesModel';
	
	// atributos
	protected $idincidentes;
//	protected $idprodemge;
	protected $descricao;
	protected $data;
	protected $prioridade;
	protected $instalacoes_idinstalacoes;
	protected $solicitacao_idsolicitacao;
	protected $tipo_incidente_idtipo;
	protected $teste_demo_idteste;
	protected $atend_vsat_idatend_vsat;
	protected $tecnicoNoc;
	protected $saom;
	protected $data_modificacao;
	// atributos de relacionamentos
	protected $instalacoes;
	protected $prodemge;
	
	protected $incidenteArray = array();
	
	protected $campos = array(
//		'idprodemge',
		'descricao',
		'data',
		'prioridade',
		'instalacoes_idinstalacoes',
		'solicitacao_idsolicitacao',
		'tipo_incidente_idtipo',
		'teste_demo_idteste',
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
//	public function setidprodemge ( $idprodemge )
//	{
//		$this->idprodemge = $idprodemge;
//	}
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


	public function setsolicitacao_idsolicitacao($solicitacao_idsolicitacao){
		$this->solicitacao_idsolicitacao = $solicitacao_idsolicitacao;
	}

	public function settipo_incidente_idtipo($tipo_incidente_idtipo){
		$this->tipo_incidente_idtipo = $tipo_incidente_idtipo;
	}

	public function setteste_demo_idteste($teste_demo_idteste){
		$this->teste_demo_idteste = $teste_demo_idteste;
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
	
//
//	public function setprodemge( $prodemge )
//	{
//		$this->prodemge = $prodemge;
//	}
	
	
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
//	public function getidprodemge ()
//	{
//		return $this->idprodemge;
//	}
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

	public function getsolicitacao_idsolicitacao(){
		return $this->solicitacao_idsolicitacao;
	}

	public function gettipo_incidente_idtipo(){
		return $this->tipo_incidente_idtipo;
	}

	public function getteste_demo_idteste(){
		return $this->teste_demo_idteste;
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

	
//	public function getprodemge()
//	{
//		return $this->prodemge;
//	}
	
	
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
		$incidente = $this->fetchRow( $this->select()->where( $where ) );
		
		if( $incidente != null )
		{
			$this->incidenteArray = $incidente->toArray();
			foreach ( $this->incidenteArray as $chave => $atributo )
			{
				if( $chave != 'idincidentes' )
					$this->{"set".$chave}( $atributo );

			}
		}
		
		$this->instalacoes = $incidente->findInstalacoes_spBOViaAssociacaoInstalacaoIncidente_spModel();
//		$this->prodemge = $incidente->findProdemge_spBOViaAssociacaoInstalacaoIncidente_spModel();
		$this->incidenteArray['instalacoes_sp'] = $this->instalacoes->toArray();
//		$this->incidenteArray['prodemge_sp'] = $this->prodemge->toArray();

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

    public function getidInstalacao(){
        $where = " idincidentes = '{$this->getidincidentes()}' ";
        foreach ( $this->campos as $chave => $campo ) {
            $data[ $campo ] = $this->{'get'.$campo}();
        }

        if( $dados = $this->fetchAll($where ) )
            return $dados;
        else
            return 'erro';


//        $sql = "SELECT instalacoes_idinstalacoes FROM incidente_sp WHERE idincidente = '{$this->getidincidentes()}'";
//        return $this->queryDados($sql);
    }

}
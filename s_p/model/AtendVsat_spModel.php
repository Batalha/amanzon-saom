<?php

require_once 's_p/model/Zend_spModel.php';
require_once ("helpers/AdapterZend.php");

class AtendVsat_spModel extends Zend_spModel
{

	protected $_name = 'atend_vsat_sp';
	protected $_primary = 'idatend_vsat';
	protected $_rowClass = 'AtendVsat_spModel';
	
	// dados
	
	protected $idatend_vsat;
	protected $data;
    protected $mensagem;
	protected $atendimento;
	protected $privado;
	protected $status_atend_idstatus_atend;
	protected $usuarios_idusuarios;
	protected $incidentes_idincidentes;
	protected $instalacoes_idinstalacoes;
	protected $solicitacao_sp_idsolicitacao;
	protected $tipo_incidente_sp_idtipo;
	protected $teste_demo_sp_idteste;
	protected $resposta_agilis;
	protected $tipo_atendimento_idtipo_atendimento;
	protected $atendimento_pai;
	protected $saom;
	protected $sala;
	protected $idmotivo_atendimento;
	
	protected $atendimentoArray = array();
	
	protected $campos = array(
		'data',
        'mensagem',
		'atendimento',
		'privado',
		'status_atend_idstatus_atend',
		'usuarios_idusuarios',
		'incidentes_sp_idincidentes',
		'instalacoes_sp_idinstalacoes_sp',
		'solicitacao_sp_idsolicitacao',
		'tipo_incidente_sp_idtipo',
		'teste_demo_sp_idteste',
		'resposta_agilis',
		'tipo_atendimento_idtipo_atendimento',
		'atendimento_pai',
		'saom',
		'sala'
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
	public function setmensagem( $mensagem )
	{
		$this->mensagem = $mensagem;
	}

    public function setatendimento( $atendimento )
	{
		$this->atendimento = $atendimento;
	}

	public function setprivado( $privado )
	{
		$this->privado = $privado;
	}
	public function setstatus_atend_idstatus_atend( $status_atend_idstatus_atend )
	{
		$this->status_atend_idstatus_atend  = $status_atend_idstatus_atend;
	}
	public function setusuarios_idusuarios( $usuarios_idusuarios )
	{
		$this->usuarios_idusuarios = $usuarios_idusuarios;
	}
	public function setincidentes_sp_idincidentes( $incidentes_idincidentes )
	{
		$this->incidentes_idincidentes = $incidentes_idincidentes;
	}
    public function setinstalacoes_sp_idinstalacoes_sp( $instalacoes_idinstalacoes )
	{
		$this->instalacoes_idinstalacoes = $instalacoes_idinstalacoes;
	}

	public function setsolicitacao_sp_idsolicitacao( $solicitacao_sp_idsolicitacao )
	{
		$this->solicitacao_sp_idsolicitacao = $solicitacao_sp_idsolicitacao;
	}

	public function settipo_incidente_sp_idtipo( $tipo_incidente_sp_idtipo )
	{
		$this->tipo_incidente_sp_idtipo = $tipo_incidente_sp_idtipo;
	}

	public function setteste_demo_sp_idteste( $teste_demo_sp_idteste )
	{
		$this->teste_demo_sp_idteste = $teste_demo_sp_idteste;
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

	public function setsala( $sala )
	{
		$this->sala = $sala;
	}
	
	public function getidatend_vsat()
	{
		return $this->idatend_vsat;
	}
	public function getdata()
	{
		return $this->data;
	}
	public function getmensagem()
	{
		return $this->mensagem;
	}
    public function getatendimento()
	{
		return $this->atendimento;
	}

	public function getprivado()
	{
		return $this->privado;
	}
	public function getstatus_atend_idstatus_atend()
	{
		return $this->status_atend_idstatus_atend;
	}
	public function getusuarios_idusuarios()
	{
		return $this->usuarios_idusuarios;
	}
	public function getincidentes_sp_idincidentes()
	{
		return $this->incidentes_idincidentes;
	}
    public function getinstalacoes_sp_idinstalacoes_sp()
	{
		return $this->instalacoes_idinstalacoes;
	}


	public function getsolicitacao_sp_idsolicitacao()
	{
		return $this->solicitacao_sp_idsolicitacao;
	}

	public function gettipo_incidente_sp_idtipo()
	{
		return $this->tipo_incidente_sp_idtipo;
	}

	public function getteste_demo_sp_idteste()
	{
		return $this->teste_demo_sp_idteste;
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

	public function getsala( )
	{
		return $this->sala;
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
//		echo die_json('teste');
//        print_b($chave, true);
				if( $chave != 'idatend_vsat' /*&& $chave != 'instalacoes_sp_idinstalacoes_sp'*/ && $chave != 'idmotivo_atendimento' )//TODO: solucao temporária até  excluir o campo instalacoes_idinstalacoes
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

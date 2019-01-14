<?php

require_once 'model/ZendModel.php';

class OSModel extends ZendModel
{

	protected $_name = 'os';
	protected $_primary = 'idos';
	
	//atributos
	protected $idos;
	protected $numOS;
	protected $identificador;
	protected $operadora;
	protected $designacao;
	protected $orgao;
	protected $cnpj;
	protected $contato;
	protected $escola;
	protected $nomeSolicitante;
	protected $departamento;
	protected $telContato;
	protected $outroTelContato;
	protected $email;
	protected $enderecoInstal;
	protected $cidade;
	protected $municipios_idcidade;
	protected $bairro;
	protected $cep;
	protected $velDownload;
	protected $velUpload;
	protected $areaInstal;
	protected $lote;
	protected $latitude;
	protected $longitude;
	protected $iplan;
	protected $perfil;
	protected $mascaraLan;
	protected $contatoFaturamento;
	protected $enderecoFaturamento;
	protected $cidadeFaturamento;
	protected $municipios_idcidadeFaturamento;
	protected $cepFaturamento;
	protected $emailFaturamento;
	protected $dataSolicitacao;
	protected $prazoInstal;
	protected $observacoes;
	protected $iduser_cadastro;
	protected $empresas_idempresas;
	protected $os_status_idos_status;
	protected $ipdvb;
	protected $eutelsat_code;
	protected $saom;
	
	protected $campos = array(
		'idos',
		'numOS',
		'identificador',
		'operadora',
		'designacao',
		'orgao',
		'cnpj',
		'contato',
		'escola',
		'nomeSolicitante',
		'departamento',
		'telContato',
		'outroTelContato',
		'email',
		'enderecoInstal',
		'cidade',
		'municipios_idcidade',
		'bairro',
		'cep',
		'velDownload',
		'velUpload',
		'areaInstal',
		'lote',
		'latitude',
		'longitude',
		'iplan',
		'perfil',
		'mascaraLan',
		'contatoFaturamento',
		'enderecoFaturamento',
		'cidadeFaturamento',
		'municipios_idcidadeFaturamento',
		'cepFaturamento',
		'emailFaturamento',
		'dataSolicitacao',
		'prazoInstal',
		'observacoes',
		'iduser_cadastro',
		'empresas_idempresas',
		'os_status_idos_status',
		'ipdvb',
		'eutelsat_code',
		'saom'
	);
	
	protected $osArray = array();
	
	public function getosArray()
	{
		return $this->osArray;
	}
	
	public function getidos(  )
	{
		return $this->idos;
	}
	public function getnumOS(  )
	{
		return $this->numOS;
	}
	public function getidentificador(  )
	{
		return $this->identificador;
	}
	public function getoperadora(  )
	{
		return $this->operadora;
	}
	public function getdesignacao(  )
	{
		return $this->designacao;
	}
	public function getorgao(  )
	{
		return $this->orgao;
	}
	public function getcnpj(  )
	{
		return $this->cnpj;
	}
	public function getcontato(  )
	{
		return $this->contato;
	}

	public function getescola(  )
	{
		return $this->escola;
	}


	public function getnomeSolicitante(  )
	{
		return $this->nomeSolicitante;
	}
	public function getdepartamento(  )
	{
		return $this->departamento;
	}
	public function gettelContato(  )
	{
		return $this->telContato;
	}
	public function getoutroTelContato(  )
	{
		return $this->outroTelContato;
	}
	public function getemail(  )
	{
		return $this->email;
	}
	public function getenderecoInstal(  )
	{
		return $this->enderecoInstal;
	}
	public function getcidade(  )
	{
		return $this->cidade;
	}
	public function getmunicipios_idcidade(  )
	{
		return $this->municipios_idcidade;
	}
	public function getbairro(  )
	{
		return $this->bairro;
	}
	public function getcep(  )
	{
		return $this->cep;
	}
	public function getvelDownload(  )
	{
		return $this->velDownload;
	}
	public function getvelUpload(  )
	{
		return $this->velUpload;
	}
	public function getareaInstal(  )
	{
		return $this->areaInstal;
	}
	public function getlote(  )
	{
		return $this->lote;
	}
	public function getlatitude(  )
	{
		return $this->latitude;
	}
	public function getlongitude(  )
	{
		return $this->longitude;
	}
	public function getiplan(  )
	{
		return $this->iplan;
	}
	public function getperfil(  )
	{
		return $this->perfil;
	}
	public function getmascaraLan(  )
	{
		return $this->mascaraLan;
	}
	public function getcontatoFaturamento(  )
	{
		return $this->contatoFaturamento;
	}
	public function getenderecoFaturamento(  )
	{
		return $this->enderecoFaturamento;
	}
	public function getcidadeFaturamento(  )
	{
		return $this->cidadeFaturamento;
	}
	public function getmunicipios_idcidadeFaturamento(  )
	{
		return $this->municipios_idcidadeFaturamento;
	}
	public function getcepFaturamento(  )
	{
		return $this->cepFaturamento;
	}
	public function getemailFaturamento(  )
	{
		return $this->emailFaturamento;
	}
	public function getdataSolicitacao(  )
	{
		return $this->dataSolicitacao;
	}
	public function getprazoInstal(  )
	{
		return $this->prazoInstal;
	}
	public function getobservacoes(  )
	{
		return $this->observacoes;
	}
	public function getiduser_cadastro(  )
	{
		return $this->iduser_cadastro;
	}
	public function getempresas_idempresas(  )
	{
		return $this->empresas_idempresas;
	}
	public function getos_status_idos_status(  )
	{
		return $this->os_status_idos_status;
	}
	public function getipdvb(  )
	{
		return $this->ipdvb;
	}
	public function geteutelsat_code(  )
	{
		return $this->eutelsat_code;
	}
	public function getsaom(  )
	{
		return $this->saom;
	}
	
	
	public function setidos( Integer $idos )
	{
		$this->idos = $idos->numero();
	}
	public function setnumOS( $numOS )
	{
		$this->numOS = $numOS;
	}
	public function setidentificador( $identificador )
	{
		$this->identificador = $identificador;
	}
	public function setoperadora( $operadora )
	{
		$this->operadora = $operadora;
	}
	public function setdesignacao( $designacao )
	{
		$this->designacao = $designacao;
	}
	public function setorgao( $orgao )
	{
		$this->orgao = $orgao;
	}
	public function setcnpj( $cnpj )
	{
		$this->cnpj = $cnpj;
	}
	public function setcontato( $contato )
	{
		$this->contato = $contato;
	}

	public function setescola( $escola )
	{
		$this->escola = $escola;
	}
	public function setnomeSolicitante( $nomeSolicitante )
	{
		$this->nomeSolicitante = $nomeSolicitante;
	}
	public function setdepartamento( $departamento )
	{
		$this->departamento = $departamento;
	}
	public function settelContato( $telContato )
	{
		$this->telContato = $telContato;
	}
	public function setoutroTelContato( $outroTelContato )
	{
		$this->outroTelContato = $outroTelContato;
	}
	public function setemail( $email )
	{
		$this->email = $email;
	}
	public function setenderecoInstal( $enderecoInstal )
	{
		$this->enderecoInstal = $enderecoInstal;
	}
	public function setcidade( $cidade )
	{
		$this->cidade = $cidade;
	}
	public function setmunicipios_idcidade( $municipios_idcidade )
	{
		$this->municipios_idcidade = $municipios_idcidade;
	}
	public function setbairro( $bairro )
	{
		$this->bairro = $bairro;
	}
	public function setcep( $cep )
	{
		$this->cep = $cep;
	}
	public function setvelDownload( $velDownload )
	{
		$this->velDownload = $velDownload;
	}
	public function setvelUpload( $velUpload )
	{
		$this->velUpload = $velUpload;
	}
	public function setareaInstal( $areaInstal )
	{
		$this->areaInstal = $areaInstal;
	}
	public function setlote( $lote )
	{
		$this->lote = $lote;
	}
	public function setlatitude( $latitude )
	{
		$this->latitude = $latitude;
	}
	public function setlongitude( $longitude )
	{
		$this->longitude = $longitude;
	}
	public function setiplan( $iplan )
	{
		$this->iplan = $iplan;
	}
	public function setperfil( $perfil )
	{
		$this->perfil = $perfil;
	}
	public function setmascaraLan( $mascaraLan )
	{
		$this->mascaraLan = $mascaraLan;
	}
	public function setcontatoFaturamento( $contatoFaturamento )
	{
		$this->contatoFaturamento = $contatoFaturamento;
	}
	public function setenderecoFaturamento( $enderecoFaturamento )
	{
		$this->enderecoFaturamento = $enderecoFaturamento;
	}
	public function setcidadeFaturamento( $cidadeFaturamento )
	{
		$this->cidadeFaturamento = $cidadeFaturamento;
	}
	public function setmunicipios_idcidadeFaturamento( $municipios_idcidadeFaturamento )
	{
		$this->municipios_idcidadeFaturamento = $municipios_idcidadeFaturamento;
	}
	public function setcepFaturamento( $cepFaturamento )
	{
		$this->cepFaturamento = $cepFaturamento;
	}
	public function setemailFaturamento( $emailFaturamento )
	{
		$this->emailFaturamento = $emailFaturamento;
	}
	public function setdataSolicitacao( $dataSolicitacao )
	{
		$this->dataSolicitacao = $dataSolicitacao;
	}
	public function setprazoInstal( $prazoInstal )
	{
		$this->prazoInstal = $prazoInstal;
	}
	public function setobservacoes( $observacoes )
	{
		$this->observacoes = $observacoes;
	}
	public function setiduser_cadastro( $iduser_cadastro )
	{
		$this->iduser_cadastro = $iduser_cadastro;
	}
	public function setempresas_idempresas( $empresas_idempresas )
	{
		$this->empresas_idempresas = $empresas_idempresas;
	}
	public function setos_status_idos_status( $os_status_idos_status )
	{
		$this->os_status_idos_status = $os_status_idos_status;
	}
	public function setipdvb( $ipdvb )
	{
		$this->ipdvb = $ipdvb;
	}
	public function seteutelsat_code( $eutelsat_code )
	{
		$this->eutelsat_code = $eutelsat_code;
	}
	public function setsaom( $saom )
	{
		$this->saom = $saom;
	}
	
	
	public function getOS()
	{
		if( empty($this->idos) )
			return "Id da OS não declarado.";

		$where = " idos = '{$this->idos}' ";
		$os = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($os) > 0 )
		{
			$linha = $os->toArray();
			$this->osArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idos' ){

					$this->{"set".$chave}( $atributo );
                }
			}
		}

	}

}
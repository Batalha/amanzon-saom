<?php

require_once 's_p/model/Zend_spModel.php';

class OSSPModel extends Zend_spModel
{

	protected $_name = 'os_sp';
	protected $_primary = 'idos';

	//atributos
	protected $idos;
	protected $numOS;
	protected $identificador;

	protected $contato;
	protected $telContato;
	protected $outroTelContato;
	protected $enderecoInstal;
	protected $pais;
	protected $cidade;
	protected $estado;
	protected $cep;

	//OS ATI
	protected $orgao;
	protected $unidade;
	protected $acesso;
	protected $inep;
	protected $outroTelContato2;
	protected $email;
	protected $area_instal;
	protected $tipo_equip;
	protected $lat_g;
	protected $lat_m;
	protected $lat_s;
	protected $long_g;
	protected $long_m;
	protected $long_s;
	protected $end_rede;
	protected $end_lan;
	protected $wan_fw;
	protected $ip_lan_fw;
	protected $router;

	protected $cirDownload;
	protected $cirUpload;
	protected $mirDownload;
	protected $mirUpload;

	protected $satelite_idsatelite;
	protected $escricao_fornecimento_idescricao_fornecimento;

	protected $voip;
	protected $iplan;
	protected $qtlinha;
	protected $qtip;
	protected $speednet;
	protected $speedTipo;

	protected $iplan1;
	protected $iplanMask1;
	protected $iplan2;
	protected $iplanMask2;
	protected $perfil;
	protected $mascaraLan;

	protected $dataSolicitacao;
	protected $prazoInstal;
	protected $observacoes;
	protected $iduser_cadastro;
	protected $empresas_idempresas;
	protected $empreiteira_idempresas;
	protected $clientes_idcliente;
	protected $os_status_idos_status;
	protected $ipdvb;
	protected $eutelsat_code;
	protected $saom;

	protected $campos = array(
		'idos',
		'numOS',
		'identificador',
		'contato',
		'telContato',
		'outroTelContato',
		'enderecoInstal',
		'pais',
		'cidade',
		'estado',
		'cep',
		'satelite_idsatelite',
		'escricao_fornecimento_idescricao_fornecimento',
		'cirDownload',
		'cirUpload',
		'mirDownload',
		'mirUpload',
		'voip',
		'qtlinha',
		'qtip',
		'speednet',
		'speedTipo',
		'iplan',
		'iplan1',
		'iplanMask1',
		'iplan2',
		'iplanMask2',
		'perfil',
		'mascaraLan',
		'dataSolicitacao',
		'prazoInstal',
		'observacoes',
		'iduser_cadastro',
		'empresas_idempresas',
		'empreiteira_idempresas',
		'clientes_idcliente',
		'os_status_idos_status',
		'ipdvb',
		'eutelsat_code',
		'saom',

			//OS ATI
		'orgao',
		'unidade',
		'acesso',
		'inep',
		'outroTelContato2',
		'email',
		'area_instal',
		'tipo_equip',
		'lat_g',
		'lat_m',
		'lat_s',
		'long_g',
		'long_m',
		'long_s',
		'end_rede',
		'end_lan',
		'wan_fw',
		'ip_lan_fw',
		'router'

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
	public function getcontato(  )
	{
		return $this->contato;
	}
	public function gettelContato(  )
	{
		return $this->telContato;
	}
	public function getoutroTelContato(  )
	{
		return $this->outroTelContato;
	}
	public function getenderecoInstal(  )
	{
		return $this->enderecoInstal;
	}
	public function getpais(  )
	{
		return $this->pais;
	}
	public function getcidade(  )
	{
		return $this->cidade;
	}
	public function getestado(  )
	{
		return $this->estado;
	}
	public function getcep(  )
	{
		return $this->cep;
	}
	public function getsatelite_idsatelite(  )
	{
		return $this->satelite_idsatelite;
	}
	public function getescricao_fornecimento_idescricao_fornecimento(){
		return $this->escricao_fornecimento_idescricao_fornecimento;
	}
	public function getcirDownload(  )
	{
		return $this->cirDownload;
	}
	public function getcirUpload(  )
	{
		return $this->cirUpload;
	}
	public function getmirDownload(  )
	{
		return $this->mirDownload;
	}
	public function getmirUpload(  )
	{
		return $this->mirUpload;
	}
	public function getvoip(  )
	{
		return $this->voip;
	}
	public function getqtlinha(  )
	{
		return $this->qtlinha;
	}
	public function getqtip(  )
	{
		return $this->qtip;
	}
	public function getspeednet(  )
	{
		return $this->speednet;
	}
	public function getspeedTipo(  )
	{
		return $this->speedTipo;
	}
	public function getiplan(  )
	{
		return $this->iplan;
	}
	public function getiplan1(  )
	{
		return $this->iplan1;
	}
	public function getiplanMask1(  )
	{
		return $this->iplanMask1;
	}
	public function getiplan2(  )
	{
		return $this->iplan2;
	}
	public function getiplanMask2(  )
	{
		return $this->iplanMask2;
	}
	public function getperfil(  )
	{
		return $this->perfil;
	}
	public function getmascaraLan(  )
	{
		return $this->mascaraLan;
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
	public function getempreiteira_idempresas(  )
	{
		return $this->empreiteira_idempresas;
	}
	public function getclientes_idcliente(  )
	{
		return $this->clientes_idcliente;
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


	//OS ATI
	public function getorgao()
	{
		return $this->orgao;
	}
	public function getunidade()
	{
		return $this->unidade;
	}
	public function getacesso()
	{
		return $this->acesso;
	}
	public function getinep()
	{
		return $this->inep;
	}
	public function getoutroTelContato2()
	{
		return $this->telContato2;
	}

	public function getemail()
	{
		return $this->email;
	}

	public function getarea_instal()
	{
		return $this->area_instal;
	}

	public function gettipo_equip()
	{
		return $this->tipo_equip;
	}

	public function getlat_g()
	{
		return $this->lat_g;
	}
	public function getlat_m()
	{
		return $this->lat_m;
	}

	public function getlat_s()
	{
		return $this->lat_s;
	}
	public function getlong_g()
	{
		return $this->long_g;
	}

	public function getlong_m()
	{
		return $this->long_m;
	}
	public function getlong_s()
	{
		return $this->long_s;
	}
	public function getend_rede()
	{
		return $this->end_rede;
	}
	public function getend_lan()
	{
		return $this->end_lan;
	}
	public function getwan_fw()
	{
		return $this->wan_fw;
	}
	public function getip_lan_fw()
	{
		return $this->ip_lan_fw;
	}
	public function getrouter()
	{
		return $this->router;
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
	public function setcontato( $contato )
	{
		$this->contato = $contato;
	}
	public function settelContato( $telContato )
	{
		$this->telContato = $telContato;
	}
	public function setoutroTelContato( $outroTelContato )
	{
		$this->outroTelContato = $outroTelContato;
	}
	public function setenderecoInstal( $enderecoInstal )
	{
		$this->enderecoInstal = $enderecoInstal;
	}
	public function setpais( $pais )
	{
		$this->pais = $pais;
	}
	public function setcidade( $cidade )
	{
		$this->cidade = $cidade;
	}
	public function setestado( $estado )
	{
		$this->estado = $estado;
	}
	public function setcep( $cep )
	{
		$this->cep = $cep;
	}
	public function setsatelite_idsatelite( $satelite_idsatelite )
	{
		$this->satelite_idsatelite = $satelite_idsatelite;
	}
	public function setescricao_fornecimento_idescricao_fornecimento( $escricao_fornecimento_idescricao_fornecimento )
	{
		$this->escricao_fornecimento_idescricao_fornecimento = $escricao_fornecimento_idescricao_fornecimento;
	}
	public function setcirDownload( $cirDownload )
	{
		$this->cirDownload = $cirDownload;
	}
	public function setcirUpload( $cirUpload )
	{
		$this->cirUpload = $cirUpload;
	}
	public function setmirDownload( $mirDownload )
	{
		$this->mirDownload = $mirDownload;
	}
	public function setmirUpload( $mirUpload )
	{
		$this->mirUpload = $mirUpload;
	}
	public function setvoip($voip  )
	{
		$this->voip = $voip;
	}
	public function setqtlinha($qtlinha  )
	{
		$this->qtlinha = $qtlinha;
	}
	public function setqtip($qtip  )
	{
		$this->qtip = $qtip;
	}
	public function setspeednet($speednet  )
	{
		$this->speednet = $speednet;
	}
	public function setspeedTipo($speedTipo  )
	{
		$this->speedTipo = $speedTipo;
	}
	public function setiplan( $iplan )
	{
		$this->iplan = $iplan;
	}
	public function setiplan1( $iplan1 )
	{
		$this->iplan = $iplan1;
	}
	public function setiplanMask1( $iplanMask1 )
	{
		$this->iplanMask = $iplanMask1;
	}
	public function setiplan2( $iplan2 )
	{
		$this->iplan2 = $iplan2;
	}
	public function setiplanMask2( $iplanMask2 )
	{
		$this->iplanMask2 = $iplanMask2;
	}
	public function setperfil( $perfil )
	{
		$this->perfil = $perfil;
	}
	public function setmascaraLan( $mascaraLan )
	{
		$this->mascaraLan = $mascaraLan;
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
	public function setempreiteira_idempresas( $empreiteira_idempresas )
	{
		$this->empreiteira_idempresas = $empreiteira_idempresas;
	}
	public function setclientes_idcliente( $clientes_idcliente )
	{
		$this->clientes_idcliente = $clientes_idcliente;
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


	public function setorgao($orgao)
	{
		$this->orgao = $orgao;
	}
	public function setunidade($unidade)
	{
		$this->unidade = $unidade;
	}

	public function setacesso($acesso)
	{
		$this->acesso = $acesso;
	}

	public function setinep($inep)
	{
		$this->inep = $inep;
	}

	public function setoutroTelContato2($telContato2)
	{
		$this->telContato2 = $telContato2;
	}

	public function setemail($email)
	{
		$this->email = $email;
	}

	public function setarea_instal($area_instal)
	{
		$this->area_instal = $area_instal;
	}

	public function settipo_equip($tipo_equip)
	{
		$this->tipo_equip = $tipo_equip;
	}

	public function setlat_g($lat_g)
	{
		$this->lat_g = $lat_g;
	}

	public function setlat_m($lat_m)
	{
		$this->lat_m = $lat_m;
	}

	public function setlat_s($lat_s)
	{
		$this->lat_s = $lat_s;
	}

	public function setlong_g($long_g)
	{
		$this->long_g = $long_g;
	}

	public function setlong_m($long_m)
	{
		$this->long_m = $long_m;
	}

	public function setlong_s($long_s)
	{
		$this->long_s = $long_s;
	}

	public function setend_rede($end_rede)
	{
		$this->end_rede = $end_rede;
	}

	public function setend_lan($end_lan)
	{
		$this->end_lan = $end_lan;
	}

	public function setwan_fw($wan_fw)
	{
		$this->wan_fw = $wan_fw;
	}

	public function setip_lan_fw($ip_lan_fw)
	{
		$this->ip_lan_fw = $ip_lan_fw;
	}

	public function setrouter($router)
	{
		$this->router = $router;
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
				if($chave != 'idos') {
					$this->{"set".$chave}($atributo);
				}
			}

		}
	}

}
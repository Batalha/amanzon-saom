<?php

require_once 's_p/model/BO/OSSPBO.php';
require_once 's_p/model/BO/Municipios_spBO.php';
require_once 's_p/model/BO/Usuarios_spBO.php';
require_once 's_p/model/BO/TipoEquipamentos_spBO.php';
require_once 'helpers.class.php';

require_once 's_p/model/Zend_spModel.php';

class Instalacoes_spModel extends Zend_spModel
{

	protected $_name = 'instalacoes_sp';
	protected $_primary = 'idinstalacoes_sp';
	//protected $_dependentTables = array('EquipamentosLocaisModel');
	
	protected $OSBO;
	protected $MunicipiosBO;
	protected $UsuariosBO;
	protected $TipoEquipamentosBO;
	protected $Helpers;
	
	// atributos
	// TODO: atributos principais a serem verificados e servirem para objetivação 
	protected $idinstalacoes_sp;
	protected $planos_idplanos; // TODO: apagar
	protected $nome;
	protected $mac;
	protected $nsmodem; // TODO: apagar
	protected $odu; 
	protected $nsodu;
	protected $azimute;
	protected $elevacao; 
	protected $cod_area;
	protected $antena;
	protected $antena_tam;
	protected $antena_ns;
	protected $buc;
	protected $lnb;
	protected $tipo_IDU;
	protected $obs;
	protected $iplan; // TODO: apagar
	protected $mascaraLan; // TODO: apagar
	protected $comiss; // TODO: apagar
	protected $latitude; // TODO: apagar
	protected $longitude; // TODO: apagar
	protected $snr; // TODO: apagar
	protected $teccampo;
	protected $teccampo_tel;
	protected $dataComiss; // TODO: apagar

	protected $ope_eutelsat;
	protected $satelite;
	protected $bean;

	protected $latitude_comiss; // TODO: apagar
	protected $longitude_comiss; // TODO: apagar
	protected $azimute_comiss;
	protected $elevacao_comiss;
	protected $snr_comiss;
	protected $nsmodem_comiss;
	protected $mac_comiss;
	protected $nsodu_comiss;
	protected $antena_comiss;
	protected $antena_ns_comiss;
	protected $ope_eutelsat_noc; // TODO: apagar
	protected $latitude_comiss_noc; // TODO: apagar
	protected $longitude_comiss_noc; // TODO: apagar
	protected $azimute_comiss_noc; // TODO: apagar
	protected $elevacao_comiss_noc; // TODO: apagar
	protected $snr_comiss_noc; // TODO: apagar
	protected $nsmodem_comiss_noc; // TODO: apagar
	protected $mac_comiss_noc; // TODO: apagar
	protected $nsodu_comiss_noc; // TODO: apagar
	protected $antena_comiss_noc; //TODO: apagar
	protected $antena_ns_comiss_noc; // TODO: apagar
	protected $val_crosspol;
	protected $test_geo;
	protected $ebno_comiss;
	protected $eirp_comiss;
	protected $comp_cabo_comiss;
	protected $comp_tipo_cabo_comiss;
	protected $desc_clima_comiss;
	protected $val_crosspol_noc; // TODO: apagar
	protected $img_down_up;
	protected $img_ping;
	protected $img_intranet;
	protected $cod_anatel;
	protected $webnms;
	protected $packetshapper;
	protected $reglicenca;
	protected $opmanager;
	protected $data_aceite;
	protected $analista_prodemge;
	protected $data_ativacao;
	protected $os_sp_idos;
	protected $registro_concessionaria;
	protected $termo_aceite;
	protected $test_e_termo_aceite;
	protected $latitude_graus;
	protected $latitude_minutos;
	protected $latitude_segundos;
	protected $latitude_direcao;
	protected $longitude_graus;
	protected $longitude_minutos;
	protected $longitude_segundos;
	protected $longitude_direcao;
	protected $sat_vsat_code;
	protected $create_user_comiss;
	protected $last_user_comiss;
	protected $data_final_comiss;
	protected $ipdvb;
	protected $justificativa_mod_data_aceite;
	protected $cabo_rj45;
	protected $cabo_rj45_justificativa_sim;
	protected $cabo_rj45_justificativa_nao;
	protected $saom;
	protected $obs_instalacao;
	
	
	protected $campos = array(
		'idinstalacoes_sp',
		'nome',
		'mac',
		'odu', 
		'nsodu',
		'azimute',
		'elevacao', 
		'cod_area',
		'antena',
		'antena_tam',
		'antena_ns',
		'buc',
		'lnb',
		'tipo_IDU',
		'obs',
		'teccampo',
		'teccampo_tel',

		'ope_eutelsat',
		'satelite',
		'bean',

        'azimute_comiss',
		'elevacao_comiss',
		'snr_comiss',
		'nsmodem_comiss',
		'mac_comiss',
		'nsodu_comiss',
		'antena_comiss',
		'antena_ns_comiss',
		'val_crosspol',
		'test_geo',
		'ebno_comiss',
		'eirp_comiss',

		'comp_cabo_comiss',
		'comp_tipo_cabo_comiss',

		'desc_clima_comiss',
		'img_down_up',
		'img_ping',
		'img_intranet',
		'cod_anatel',
		'webnms',
		'packetshapper',
		'reglicenca',
		'opmanager',
		'data_aceite',
		'analista_prodemge',
		'data_ativacao',
		'os_sp_idos',
		'registro_concessionaria',
		'termo_aceite',
		'test_e_termo_aceite',
		'latitude_graus',
		'latitude_minutos',
		'latitude_segundos',
		'latitude_direcao',
		'longitude_graus',
		'longitude_minutos',
		'longitude_segundos',
		'longitude_direcao',
		'sat_vsat_code',
		'create_user_comiss',
		'last_user_comiss',
		'data_final_comiss',
		'ipdvb',
		'justificativa_mod_data_aceite',
		'cabo_rj45',
		'cabo_rj45_justificativa_sim',
		'cabo_rj45_justificativa_nao',
		'saom',
		'obs_instalacao'
	);
	
	
	protected $instalacaoArray;
	
	
	public function __construct( $adapter )
	{

		parent::__construct( $adapter );
		
		$this->OSBO = new OSSPBO( $adapter );
		$this->MunicipiosBO = new Municipios_spBO( $adapter );
		$this->UsuariosBO =  new Usuarios_spBO( $adapter );
		$this->TipoEquipamentosBO = new TipoEquipamentos_spBO( $adapter );
		$this->Helpers = new Helpers();
		
	}
	
	public function getidinstalacoes_sp()
	{
		return $this->idinstalacoes_sp;
	}
	
	public function getnome ()
    {
        return $this->nome;
    }

	public function getmac ()
    {
        return $this->mac;
    }

	public function getodu ()
    {
        return $this->odu;
    }

	public function getnsodu ()
    {
        return $this->nsodu;
    }

	public function getazimute ()
    {
        return $this->azimute;
    }

	public function getelevacao ()
    {
        return $this->elevacao;
    }

	public function getcod_area ()
    {
        return $this->cod_area;
    }

	public function getantena ()
    {
        return $this->antena;
    }

	public function getantena_tam ()
    {
        return $this->antena_tam;
    }

	public function getantena_ns ()
    {
        return $this->antena_ns;
    }

	public function getbuc ()
    {
        return $this->buc;
    }

	public function getlnb ()
    {
        return $this->lnb;
    }

	public function gettipo_IDU ()
    {
        return $this->tipo_IDU;
    }

	public function getobs ()
    {
        return $this->obs;
    }

	public function getteccampo ()
    {
        return $this->teccampo;
    }

	public function getteccampo_tel ()
    {
        return $this->teccampo_tel;
    }

	public function getope_eutelsat ()
    {
        return $this->ope_eutelsat;
    }


    public function getsatelite ()
    {
        return $this->satelite;
    }
    public function getbean ()
    {
        return $this->bean;
    }


    public function getazimute_comiss ()
    {
        return $this->azimute_comiss;
    }

	public function getelevacao_comiss ()
    {
        return $this->elevacao_comiss;
    }

	public function getsnr_comiss ()
    {
        return $this->snr_comiss;
    }

	public function getnsmodem_comiss ()
    {
        return $this->nsmodem_comiss;
    }

	public function getmac_comiss ()
    {
        return $this->mac_comiss;
    }

	public function getnsodu_comiss ()
    {
        return $this->nsodu_comiss;
    }

	public function getantena_comiss ()
    {
        return $this->antena_comiss;
    }

	public function getantena_ns_comiss ()
    {
        return $this->antena_ns_comiss;
    }

	public function getval_crosspol ()
    {
        return $this->val_crosspol;
    }

	public function gettest_geo ()
    {
        return $this->test_geo;
    }

	public function getebno_comiss ()
    {
        return $this->ebno_comiss;
    }

	public function geteirp_comiss ()
    {
        return $this->eirp_comiss;
    }

	public function getcomp_cabo_comiss ()
    {
        return $this->comp_cabo_comiss;
    }

    public function getcomp_tipo_cabo_comiss ()
    {
        return $this->comp_tipo_cabo_comiss;
    }

	public function getdesc_clima_comiss ()
    {
        return $this->desc_clima_comiss;
    }

	public function getimg_down_up ()
    {
        return $this->img_down_up;
    }

	public function getimg_ping ()
    {
        return $this->img_ping;
    }

	public function getimg_intranet ()
    {
        return $this->img_intranet;
    }

	public function getcod_anatel ()
    {
        return $this->cod_anatel;
    }

	public function getwebnms ()
    {
        return $this->webnms;
    }

	public function getpacketshapper ()
    {
        return $this->packetshapper;
    }

	public function getreglicenca ()
    {
        return $this->reglicenca;
    }

	public function getopmanager ()
    {
        return $this->opmanager;
    }

	public function getdata_aceite ()
    {
        return $this->data_aceite;
    }

	public function getanalista_prodemge ()
    {
        return $this->analista_prodemge;
    }

	public function getdata_ativacao ()
    {
        return $this->data_ativacao;
    }

	public function getos_sp_idos ()
    {
        return $this->os_sp_idos;
    }

	public function getregistro_concessionaria ()
    {
        return $this->registro_concessionaria;
    }

	public function gettermo_aceite ()
    {
        return $this->termo_aceite;
    }

	public function gettest_e_termo_aceite ()
    {
        return $this->test_e_termo_aceite;
    }

	public function getlatitude_graus ()
    {
        return $this->latitude_graus;
    }

	public function getlatitude_minutos ()
    {
        return $this->latitude_minutos;
    }

	public function getlatitude_segundos ()
    {
        return $this->latitude_segundos;
    }

	public function getlatitude_direcao ()
    {
        return $this->latitude_direcao;
    }

	public function getlongitude_graus ()
    {
        return $this->longitude_graus;
    }

	public function getlongitude_minutos ()
    {
        return $this->longitude_minutos;
    }

	public function getlongitude_segundos ()
    {
        return $this->longitude_segundos;
    }

	public function getlongitude_direcao ()
    {
        return $this->longitude_direcao;
    }

	public function getsat_vsat_code ()
    {
        return $this->sat_vsat_code;
    }

	public function getcreate_user_comiss ()
    {
        return $this->create_user_comiss;
    }

	public function getlast_user_comiss ()
    {
        return $this->last_user_comiss;
    }

	public function getdata_final_comiss ()
    {
        return $this->data_final_comiss;
    }

	public function getipdvb ()
    {
        return $this->ipdvb;
    }

	public function getjustificativa_mod_data_aceite ()
    {
        return $this->justificativa_mod_data_aceite;
    }

	public function getcabo_rj45 ()
    {
        return $this->cabo_rj45;
    }

	public function getcabo_rj45_justificativa_sim ()
    {
        return $this->cabo_rj45_justificativa_sim;
    }

	public function getcabo_rj45_justificativa_nao ()
    {
        return $this->cabo_rj45_justificativa_nao;
    }

	public function getsaom ()
    {
        return $this->saom;
    }

	public function getinstalacaoArray ()
    {
        return $this->instalacaoArray;
    }
    
    public function getobs_instalacao()
    {
    	return $this->obs_instalacao;
    }
    
    // --

	public function setidinstalacoes_sp ($idinstalacoes_sp)
    {
        $this->idinstalacoes_sp = $idinstalacoes_sp;
    }
    
	public function setnome ($nome)
    {
        $this->nome = $nome;
    }

	public function setmac ($mac)
    {
        $this->mac = $mac;
    }

	public function setodu ($odu)
    {
        $this->odu = $odu;
    }

	public function setnsodu ($nsodu)
    {
        $this->nsodu = $nsodu;
    }

	public function setazimute ($azimute)
    {
        $this->azimute = $azimute;
    }

	public function setelevacao ($elevacao)
    {
        $this->elevacao = $elevacao;
    }

	public function setcod_area ($cod_area)
    {
        $this->cod_area = $cod_area;
    }

	public function setantena ($antena)
    {
        $this->antena = $antena;
    }

	public function setantena_tam ($antena_tam)
    {
        $this->antena_tam = $antena_tam;
    }

	public function setantena_ns ($antena_ns)
    {
        $this->antena_ns = $antena_ns;
    }

	public function setbuc ($buc)
    {
        $this->buc = $buc;
    }

	public function setlnb ($lnb)
    {
        $this->lnb = $lnb;
    }

	public function settipo_IDU ($tipo_IDU)
    {
        $this->tipo_IDU = $tipo_IDU;
    }

	public function setobs ($obs)
    {
        $this->obs = $obs;
    }

	public function setteccampo ($teccampo)
    {
        $this->teccampo = $teccampo;
    }

	public function setteccampo_tel ($teccampo_tel)
    {
        $this->teccampo_tel = $teccampo_tel;
    }

	public function setope_eutelsat ($ope_eutelsat)
    {
        $this->ope_eutelsat = $ope_eutelsat;
    }


    public function setsatelite ($satelite)
    {
        $this->satelite = $satelite;
    }
    public function setbean ($bean)
    {
        $this->satelite = $bean;
    }

	public function setazimute_comiss ($azimute_comiss)
    {
        $this->azimute_comiss = $azimute_comiss;
    }

	public function setelevacao_comiss ($elevacao_comiss)
    {
        $this->elevacao_comiss = $elevacao_comiss;
    }

	public function setsnr_comiss ($snr_comiss)
    {
        $this->snr_comiss = $snr_comiss;
    }

	public function setnsmodem_comiss ($nsmodem_comiss)
    {
        $this->nsmodem_comiss = $nsmodem_comiss;
    }

	public function setmac_comiss ($mac_comiss)
    {
        $this->mac_comiss = $mac_comiss;
    }

	public function setnsodu_comiss ($nsodu_comiss)
    {
        $this->nsodu_comiss = $nsodu_comiss;
    }

	public function setantena_comiss ($antena_comiss)
    {
        $this->antena_comiss = $antena_comiss;
    }

	public function setantena_ns_comiss ($antena_ns_comiss)
    {
        $this->antena_ns_comiss = $antena_ns_comiss;
    }

	public function setval_crosspol ($val_crosspol)
    {
        $this->val_crosspol = $val_crosspol;
    }

	public function settest_geo ($test_geo)
    {
        $this->test_geo = $test_geo;
    }

	public function setebno_comiss ($ebno_comiss)
    {
        $this->ebno_comiss = $ebno_comiss;
    }

	public function seteirp_comiss ($eirp_comiss)
    {
        $this->eirp_comiss = $eirp_comiss;
    }

	public function setcomp_cabo_comiss ($comp_cabo_comiss)
    {
        $this->comp_cabo_comiss = $comp_cabo_comiss;
    }
    public function setcomp_tipo_cabo_comiss ($comp_tipo_cabo_comiss)
    {
        $this->comp_tipo_cabo_comiss = $comp_tipo_cabo_comiss;
    }

	public function setdesc_clima_comiss ($desc_clima_comiss)
    {
        $this->desc_clima_comiss = $desc_clima_comiss;
    }

	public function setimg_down_up ($img_down_up)
    {
        $this->img_down_up = $img_down_up;
    }

	public function setimg_ping ($img_ping)
    {
        $this->img_ping = $img_ping;
    }

	public function setimg_intranet ($img_intranet)
    {
        $this->img_intranet = $img_intranet;
    }

	public function setcod_anatel ($cod_anatel)
    {
        $this->cod_anatel = $cod_anatel;
    }

	public function setwebnms ($webnms)
    {
        $this->webnms = $webnms;
    }

	public function setpacketshapper ($packetshapper)
    {
        $this->packetshapper = $packetshapper;
    }

	public function setreglicenca ($reglicenca)
    {
        $this->reglicenca = $reglicenca;
    }

	public function setopmanager ($opmanager)
    {
        $this->opmanager = $opmanager;
    }

	public function setdata_aceite ($data_aceite)
    {
        $this->data_aceite = $data_aceite;
    }

	public function setanalista_prodemge ($analista_prodemge)
    {
        $this->analista_prodemge = $analista_prodemge;
    }

	public function setdata_ativacao ($data_ativacao)
    {
        $this->data_ativacao = $data_ativacao;
    }

	public function setos_sp_idos ($os_sp_idos)
    {
        $this->os_sp_idos = $os_sp_idos;
    }

	public function setregistro_concessionaria ($registro_concessionaria)
    {
        $this->registro_concessionaria = $registro_concessionaria;
    }

	public function settermo_aceite ($termo_aceite)
    {
        $this->termo_aceite = $termo_aceite;
    }

	public function settest_e_termo_aceite ($test_e_termo_aceite)
    {
        $this->test_e_termo_aceite = $test_e_termo_aceite;
    }

	public function setlatitude_graus ($latitude_graus)
    {
        $this->latitude_graus = $latitude_graus;
    }

	public function setlatitude_minutos ($latitude_minutos)
    {
        $this->latitude_minutos = $latitude_minutos;
    }

	public function setlatitude_segundos ($latitude_segundos)
    {
        $this->latitude_segundos = $latitude_segundos;
    }

	public function setlatitude_direcao ($latitude_direcao)
    {
        $this->latitude_direcao = $latitude_direcao;
    }

	public function setlongitude_graus ($longitude_graus)
    {
        $this->longitude_graus = $longitude_graus;
    }

	public function setlongitude_minutos ($longitude_minutos)
    {
        $this->longitude_minutos = $longitude_minutos;
    }

	public function setlongitude_segundos ($longitude_segundos)
    {
        $this->longitude_segundos = $longitude_segundos;
    }

	public function setlongitude_direcao ($longitude_direcao)
    {
        $this->longitude_direcao = $longitude_direcao;
    }

	public function setsat_vsat_code ($sat_vsat_code)
    {
        $this->sat_vsat_code = $sat_vsat_code;
    }

	public function setcreate_user_comiss ($create_user_comiss)
    {
        $this->create_user_comiss = $create_user_comiss;
    }

	public function setlast_user_comiss ($last_user_comiss)
    {
        $this->last_user_comiss = $last_user_comiss;
    }

	public function setdata_final_comiss ($data_final_comiss)
    {
        $this->data_final_comiss = $data_final_comiss;
    }

	public function setipdvb ($ipdvb)
    {
        $this->ipdvb = $ipdvb;
    }

	public function setjustificativa_mod_data_aceite ( $justificativa_mod_data_aceite)
    {
        $this->justificativa_mod_data_aceite = $justificativa_mod_data_aceite;
    }

	public function setcabo_rj45 ($cabo_rj45)
    {
        $this->cabo_rj45 = $cabo_rj45;
    }

	public function setcabo_rj45_justificativa_sim ($cabo_rj45_justificativa_sim)
    {
        $this->cabo_rj45_justificativa_sim = $cabo_rj45_justificativa_sim;
    }

	public function setcabo_rj45_justificativa_nao ($cabo_rj45_justificativa_nao)
    {
        $this->cabo_rj45_justificativa_nao = $cabo_rj45_justificativa_nao;
    }

	public function setsaom ($saom)
    {
        $this->saom = $saom;
    }
    
    public function setobs_instalacao( $obs_instalacao )
    {
    	$this->obs_instalacao = $obs_instalacao;
    }
    
    

	public function setinstalacaoArray ($instalacaoArray)
    {
        $this->instalacaoArray = $instalacaoArray;
    }

	public function getInstalacao()
	{
		if( empty($this->idinstalacoes_sp) )
			return "Id da Instalação não declarado.";

		$where = " idinstalacoes_sp = '{$this->idinstalacoes_sp}' ";
		$instalacoes = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($instalacoes) > 0 )
		{
			$linha = $instalacoes->toArray();
			$this->instalacaoArray = $linha[0];
			foreach ( $this->campos as $atributo )
			{
				if( $atributo != 'idinstalacoes_sp' )
					$this->{"set".$atributo}( $linha[0][$atributo] );
			}
		}
	}
	
}
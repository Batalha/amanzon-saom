<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBOS
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBInstalacao extends DBModel {
    
    protected $idinstalacoes;
    protected $idinstalacao;
    protected $planos_idplano;
    protected $mac;
    protected $azimute;
    protected $elevacao;
    protected $cod_area;
    protected $antena;
    protected $buc;
    protected $lnb;
    protected $tipo_IDU;
    protected $obs;
    protected $cod_anatel;
    protected $OS_id_os;
    protected $iplan;
    protected $num_ip;
    protected $ipdvb;
    protected $mascaraLan;
    protected $latitude_graus;
    protected $latitude_minutos;
    protected $latitude_segundos;
    protected $longitude_graus;
    protected $longitude_minutos;
    protected $longitude_segundos;
    protected $latitude_direcao;
    protected $longitude_direcao;
    protected $sat_vsat_code;
    protected $justificativa_mod_data_aceite;
    protected $cabo_rj45;
    protected $cabo_rj45_justificativa_sim;
    protected $cabo_rj45_justificativa_nao;
    
    protected $create_user_comiss;
    protected $last_user_comiss;
    protected $create_user_comiss_time;
    protected $last_user_comiss_time;
    
    
    //-----------estava salvando pelo zend_db_table-----

    
    //-----------estava salvando pelo zend_db_table-----

    protected $tabela = 'instalacoes';
    protected $cmpData= array(
    						'data_aceite',
    						'data_ativacao'
    						);
    
    protected $prk    = 'idinstalacoes';
    
    protected $rel    = array(
    						'os',
    						'planos'
    						);
    protected $fgk    = array(
    						'os_idos',
    						'planos_idplanos'
    						);
    
    protected $cmpReq = array(
    						'latitude_graus',
						    'latitude_minutos',
						    'latitude_segundos',
						    'longitude_graus',
						    'longitude_minutos',
						    'longitude_segundos',
						    'latitude_direcao',
						    'longitude_direcao',
						    'odu',
						    'nsodu_comiss',
						    'iplan'
    						);
        
    protected $camposForm = array(
						        'nome',
						        'mac',
						        'azimute',
						        'elevacao',
						        'cod_area',
						        'antena',
						        'buc',
						        'lnb',
						        'odu',
						        'nsodu',
						        'antena',
						        'antena_tam',
						        'antena_ns',
						        'tipo_IDU',
						        'obs',
						        'cod_anatel',
						        'os_idos',
						        'packetshapper',
						        'webnms',
						        'reglicenca',
						        'opmanager',
						        'planos_idplanos',
						        'iplan',
						        'num_ip',
    							'mascaraLan',
    							'ope_eutelsat',
    							'val_crosspol',
    							'img_down_up',
    							'img_ping',
    							'img_intranet',
    							'latitude',
    							'longitude',
    							'snr',
    							'comiss',
						        'ope_eutelsat_noc',
						        'val_crosspol_noc',
						        'latitude_comiss',
						        'latitude_comiss_noc',
						        'longitude_comiss',
						        'longitude_comiss_noc',
						        'azimute_comiss',
						        'azimute_comiss_noc',
						        'elevacao_comiss',
						        'elevacao_comiss_noc',
						        'snr_comiss',
						        'snr_comiss_noc',
						        'nsmodem_comiss',
						        'nsmodem_comiss_noc',
						        'mac_comiss',
						        'mac_comiss_noc',
						        'nsodu_comiss',
						        'nsodu_comiss_noc',
						        'antena_comiss',
						        'antena_ns_comiss',
						        'test_geo',
						        'ebno_comiss',
						        'ebno_comiss_noc',
						        'eirp_comiss',
						        'comp_cabo_comiss',
						        'tipo_cabo_comiss',
						        'desc_clima_comiss',
						        'data_aceite',
						        'teccampo',
						        'teccampo_tel',
						        'analista_prodemge',
						        'data_ativacao',
						        'registro_concessionaria',
						        'termo_aceite',
						        'test_e_termo_aceite',
						        'latitude_graus',
						        'latitude_minutos',
						        'latitude_segundos',
						        'longitude_graus',
						        'longitude_minutos',
						        'longitude_segundos',
						        'latitude_direcao',
						        'longitude_direcao',
						        'sat_vsat_code',
    							'create_user_comiss',
						        'last_user_comiss',
						        'create_user_comiss_time',
						        'last_user_comiss_time',
						        'data_final_comiss',
						        'justificativa_mod_data_aceite',
						        'cabo_rj45_justificativa_sim',
    							'cabo_rj45_justificativa_nao',
						        'cabo_rj45',
        
                                //-----------estava salvando pelo zend_db_table-----
 
                                //-----------estava salvando pelo zend_db_table-----
        
        
						        'saom'
    							);
    
    protected $cmpCheckBox = array(
        						'packetshapper',
        						'webnms',
        						'test_geo',
        						'reglicenca',
        						'opmanager',
        						'test_e_termo_aceite',/*Enviou o Termo de Aceite à Prodemge?*/
    							'cabo_rj45'
    							);
    
    protected $cmpImg = array(
        					'img_down_up',
        					'img_ping',
        					'img_intranet',
        					'termo_aceite'
    						);
    						
    //extras
    protected $dadosCarregados;

    
    //SETS
    	public function setIdinstalacoes($idinstalacoesnovo)
    	{
    		$this->idinstalacoes = $idinstalacoesnovo;
    	}
    //SETS - fim
    
    //GETS
    	public function getIdinstalacoes()
    	{
    		return $this->idinstalacoes;
    	}
    	public function getTabela()
    	{
    		return $this->tabela;
    	}
    //GETS - fim
    						
    
    public function  __construct()
    {

        parent::__construct();    
    }
    
    public function getName($name)
    {
       $name = strtoupper($name);
       
       $sql      = "SELECT COUNT(*) as total FROM instalacoes WHERE nome LIKE '".$name."'";
       $nameVsat = $name;
       
       $ifun     = $this->queryDados($sql);
       $ifun     = $ifun[0]['total'];
       
       $i=2;
       
       if($ifun){
           
         while($ifun ){
           
           $count[2] = "II";
           $count[3] = "III";
           $count[4] = "IV";
           $count[5] = "V";
           $count[6] = "VI";
           $count[7] = "VII";
           $count[8] = "VIII";
           $count[9] = "IX";
		   $count[10]= "X";
		   $count[11]= "XI";
		   $count[12]= "XII";
		   $count[13]= "XIII";
		   $count[14]= "XIV";
		   $count[15]= "XV";
		   $count[16]= "XVI";
		   $count[17]= "XVII";
		   $count[18]= "XVIII";
		   $count[19]= "XIX";
		   $count[20]= "XX";

           $nameVsat = $name."_".$count[$i];

           $sql = "SELECT COUNT(*) as total FROM instalacoes WHERE nome LIKE '".$nameVsat."'";
           $ifun = $this->queryDados($sql);
           $ifun = $ifun[0]['total'];
           $i++;

            }
        }
        
        return $nameVsat;
    }
    
    public function countPendShapper()
    {
    	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
        	$sql = "SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE ISNULL(i.packetshapper)";
        }
     	else
     	{
     		$sql = "SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE 
     			(SELECT o.empresas_idempresas FROM os o WHERE o.idos = i.idinstalacoes) = {$_SESSION['login']['empresas_idempresas']} AND 
     			ISNULL(i.packetshapper)";
     	}
        
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function countPendWNMS()
    {
    	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
        	$sql = "
        		SELECT COUNT(i.idinstalacoes) AS total 
        		FROM instalacoes i 
        		WHERE ISNULL(i.webnms)
        	";
        }
     	else
     	{
     		$sql = "
     			SELECT COUNT(i.idinstalacoes) AS total 
     			FROM instalacoes i 
     			WHERE
     				(
     					SELECT o.empresas_idempresas 
     					FROM os o 
     					WHERE o.idos = i.idinstalacoes
     				) = {$_SESSION['login']['empresas_idempresas']} 
     				AND ISNULL(i.packetshapper)
     		";
     	}
     	
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
	public function countInc()
	{
		if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
			$sql = "
				SELECT COUNT(i.idinstalacoes) AS total 
				FROM instalacoes i 
				WHERE (ISNULL(i.webnms) OR ISNULL(i.packetshapper))
			";
		}
     	else
     	{
     		$sql = "
     			SELECT COUNT(i.idinstalacoes) AS total 
     			FROM instalacoes i 
     			WHERE
     				(
     					SELECT o.empresas_idempresas 
     					FROM os o 
     					WHERE o.idos = i.idinstalacoes
     				) = {$_SESSION['login']['empresas_idempresas']} 
     				AND ISNULL(i.packetshapper);
     		";
     	}
     	
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }

    public function countComiss()
    {
    	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
    		$sql = "SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE ISNULL(i.comiss) ";
     	}
     	else
     	{
     		$sql = "
     			SELECT COUNT(i.idinstalacoes) AS total 
     			FROM instalacoes i 
     			WHERE
     				(
     					SELECT o.empresas_idempresas 
     					FROM os o 
     					WHERE o.idos = i.idinstalacoes
     				) = {$_SESSION['login']['empresas_idempresas']} AND ISNULL(i.comiss);
     		";
     	}
     	
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function resgataNomeTipoEquipamentoDeSNOdeEquipamento($nsodu)
    {
    	$sql = " SELECT te.idtipo_equipamentos, te.nome FROM tipo_equipamentos te WHERE idtipo_equipamentos = (SELECT e.tipo_equipamentos_idtipo_equipamentos FROM equipamentos e WHERE sno = '{$nsodu}') ";
		return $this->queryDados($sql);
    }
    
    public function carrega($idInstalacao)
    {
    	$sql = "SELECT * FROM {$this->tabela} WHERE {$this->prk} = '{$idInstalacao}' ";
    	$dados = $this->queryDados($sql);
    	return $dados[0];
    }
    
//     public function create($form)
//     {
    	 
    
//     	$str = 'INSERT INTO '.$this->tabela;
//     	$strCampos = array();
//     	$values = array();
//     	$erros['erros'] = array();
//     	//inserindo campos vindo do fomulário
    
//     	foreach ($this->camposForm as $campo)
//     	{
//     		//trata data para salvar no BD
    
//     		if( array_key_exists($campo, $form))
//     		{
    
//     			$form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
    
//     			//trata check box
//     			$form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
//     			//fim
    
    			 
//     			$this->$campo  = $form[$campo];
    			 
    			 
//     			//para campos requeridos
//     			if(in_array($campo, $this->cmpReq) && empty($this->$campo))
//     			{
//     				$erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
//     			}
    
//     			$values[]      = empty($this->$campo) ? 'NULL' :  "'{$this->$campo}'";
//     			$strCampos[] = $campo;
//     		}
//     		else
//     			{
//     			//trata, caso seja um checkbox
//     				if(in_array($campo, $this->cmpCheckBox))
//     				{
//     				$this->$campo = 0;
//     				$values[]      = empty($this->$campo) ? 'NULL' :  "'{$this->$campo}'";
//     				$strCampos[] = $campo;
//     				}
//     				}
//     				}
    
//     				//inserindo campos buscados em outras tabelas
//     				//         if($form['municipios_idcidade']!='' && isset($form['municipios_idcidade']))
//     					// 	    {
//     					// 	    	$strCampos[] = 'cidade';
//     					// 	    	$values[] = "(SELECT municipio FROM municipios WHERE idmunicipios = '{$form['municipios_idcidade']}')";
//     					// 	    }
//     					// 	    if($form['municipios_idcidadeFaturamento']!='' && isset($form['municipios_idcidadeFaturamento']))
//     					// 	    {
//     					// 	    	$strCampos[] = 'cidadeFaturamento';
//     					// 	    	$values[] = "(SELECT municipio FROM municipios WHERE idmunicipios = '{$form['municipios_idcidadeFaturamento']}')";
//     					// 	    }
    
//     					if(count($erros['erros']))
//     					{
//     					return $erros;
//     }
//     $strCampos = implode(",",$strCampos);
//     $values = implode(",",$values);
//     $sql    = "$str($strCampos)VALUES($values)";
    
//     	if($this->query($sql))
//     		return $this->getLastId();
//     		else
//     		return false;
//     }
    
}

?>

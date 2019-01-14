<?php

/**
 * Description of DBOS
 *
 * @author Daniel
 * @author Sávio - lotharthesavior@gmail.com
 */


	include_once 's_p/model/DBModel_sp.php';
    include_once "s_p/model/DBEmpresas_sp.php";
    include_once "s_p/model/DBSatelites_sp.php";


class DBOS_SP extends DBModel_sp {
    
    protected $idos;
    protected $identificador;
    protected $designacao;
    protected $orgao;
    protected $contato;
    protected $nomeSolicitante;
    protected $departamento;
    protected $telContato;
    protected $email;
    protected $enderecoInstal;
    protected $pais;
    protected $cidade;
    protected $estado;
    protected $bairro;
    protected $cep;
    protected $cirDownload;
	protected $cirUpload;
    protected $mirDownload;
    protected $mirUpload;
    protected $latitude;
    protected $longitude;

    protected $ipLan;
    protected $voip;
    protected $qtlinha;
    protected $qtip;
    protected $satelite_idsatelite;
    protected $escricao_fornecimento_idescricao_fornecimento;

    protected $ipLan1;
    protected $ipLanMask1;
    protected $ipLan2;
    protected $ipLanMask2;
    protected $ipdvb;
    protected $mascaraLan;
    protected $cnpjFaturamento;
    protected $contatoFaturamento;
    protected $paisFaturamento;
    protected $cidadeFaturamento;
    protected $estadoFaturamento;
    protected $enderecoFaturamento;
    protected $emailFaturamento;
    protected $dataSolicitacao;
    protected $prazoInstal;
    protected $observacoes;
    protected $empresas_idempresas;
    protected $empreiteira_idempresas;

    protected $tabela   = 'os_sp';
    protected $prk      = 'idos';

    protected $rel = array('instalacoes_sp','agenda_instal_sp','empresas'/*,'empresas'*/,'satelite','escricao_fornecimento');//'municipios_sp', ,'satelite','escricao_fornecimento'
    protected $fgk = array('idos','idos','empresas_idempresas'/*,'empreiteira_idempresas'*/,'satelite_idsatelite','escricao_fornecimento_idescricao_fornecimento');//,'idos' ,'satelite_idsatelite','escricao_fornecimento_idescricao_fornecimento'
    
    protected $cmpData  = array('dataSolicitacao','prazoInstal');
//    protected $depends  = array('municipios_sp_idcidade','municipios_sp_idcidadeFaturamento');
    
    protected $cmpReq   = array(
				            	'numOS',
				            	'identificador',
				            	'designacao',
				            	'orgao',
				            	'contato',
				            	'telContato',
				            	'email',
				            	'enderecoInstal',
				            	'pais',
				            	'cidade',
				            	'estado',
				            	'cep',

//                                'satelite_idsatelite',
//                                'escricao_fornecimento_idescricao_fornecimento',
				            	'cirDownload',
								'cirUpload',
								'mirDownload',
								'mirUpload',

				            	'areaInstal',
				            	'lote',
//				             	'iplan',
//				             	'iplan1',
    							'ipdvb',
//				             	'mascaraLan1',
                                'cnpjFaturamento',
				             	'paisFaturamento',
				             	'cidadeFaturamento',
				             	'estadoFaturamento',
				             	'enderecoFaturamento',
				             	'emailFaturamento',
				             	'dataSolicitacao',
				             	'prazoInstal',
				             	'empresas_idempresas',
				             	'empreiteira_idempresas'
        						);
              
    protected $camposForm = array(
            					'numOS',
            					'identificador',
            					'designacao',
            					'orgao',
            					'contato',
            					'nomeSolicitante',
            					'departamento',
            					'telContato',
            					'outroTelContato',
            					'email',
            					'enderecoInstal',
            					'pais',
            					'cidade',
            					'estado',
            					'bairro',
            					'cep',

             					'cirDownload',
								'cirUpload',
								'mirDownload',
								'mirUpload',

               					'latitude',
             					'longitude',

                                'voip',
                                'qtlinha',
                                'qtip',
                                'satelite_idsatelite',
                                'escricao_fornecimento_idescricao_fornecimento',

             					'iplan',
             					'iplan1',
             					'iplanMask1',
             					'iplan2',
             					'iplanMask2',
             					'ipdvb',
             					'mascaraLan',

                                'cnpjFaturamento',
             					'contatoFaturamento',
             					'enderecoFaturamento',
             					'perfil',
             					'paisFaturamento',
             					'cidadeFaturamento',
             					'estadoFaturamento',
             					'cepFaturamento',
             					'emailFaturamento',
             					'dataSolicitacao',
             					'prazoInstal',
             					'observacoes',
             					'iduser_cadastro',
             					'empresas_idempresas',
             					'empreiteira_idempresas',
             					'saom'
        						);
    
    protected $pag = array('atual'=>0,'end'=>15,'rowspage'=>15,'url'=>'OSSP/liste');
      
    public function  __construct() {
        
        parent::__construct();  
        
    }
    
    
    //SETS
		//metodo de sobrescrita da model
	    	public function setPag($pg)
	    	{
	    		$this->pag['atual'] = $pg;
	    	}
    	//metodo para zerar a paginacao
    		public function zeraPag()
    		{
    			unset($this->pag);
    		}
    //SETS - fim
    
    
    //GETS
    	//metodo de sobrescrita da model
    	public function getPag()
    	{
    		return $this->pag['atual'];
    	}
    //GETS - fim
   
    
    public function countAgendPend()
    {
    	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
    	{
        	$sql = "SELECT COUNT( * ) as total FROM os_sp WHERE NOT EXISTS 
                ( SELECT * FROM agenda_instal_sp WHERE agenda_instal_sp.os_sp_idos = idos )";
    	}
    	else//OUTRAS EMPRESAS
    	{
    		$sql = "SELECT COUNT( * ) as total FROM os_sp WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND NOT EXISTS
                ( SELECT * FROM agenda_instal_sp WHERE agenda_instal_sp.os_sp_idos = idos )";
    	}
        
        $dados = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function countAgend(){
        
    	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
    	{
        	$sql = "SELECT COUNT( idos ) as total FROM os_sp o WHERE EXISTS 
        			( SELECT a.idagenda_instal_sp, a.os_sp_idos, a.confirm FROM agenda_instal_sp a WHERE a.os_sp_idos = o.idos AND a.confirm IS NULL)";
    	}
    	else//OUTRAS EMPRESAS
    	{
    		$sql = "SELECT COUNT( idos ) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND EXISTS
        			( SELECT a.idagenda_instal_sp, a.os_sp_idos, a.confirm FROM agenda_instal_sp a WHERE a.os_sp_idos = o.idos AND a.confirm IS NULL)";
    	}
        
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function countAgendConfirm()
    {
     	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
        	$sql = "SELECT COUNT( o.idos ) as total FROM os_sp o WHERE EXISTS 
        			( SELECT a.idagenda_instal_sp FROM agenda_instal_sp a WHERE a.os_sp_idos = o.idos AND a.confirm = 1)";
     	}
     	else//OUTRAS EMPRESAS
     	{
     		$sql = "SELECT COUNT( o.idos ) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND EXISTS
        			( SELECT a.idagenda_instal_sp FROM agenda_instal_sp a WHERE a.os_sp_idos = o.idos AND a.confirm = 1)";
     	}
        
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
	}
    
    public function countOSVenc()
    {
     	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
        	$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE  
			        NOT EXISTS ( SELECT i.idinstalacoes_sp FROM instalacoes_sp i WHERE
			            i.os_sp_idos = o.idos AND i.comiss )
			        AND o.prazoInstal < CURDATE( )";
     	}
     	else//OUTRAS EMPRESAS
     	{
     		$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND
			        NOT EXISTS ( SELECT i.idinstalacoes_sp FROM instalacoes_sp i WHERE
			            i.os_sp_idos = o.idos AND i.comiss )
			        AND o.prazoInstal < CURDATE( )";
     	}
        
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function countOSConc()
    {
     	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
        	$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE  
				        EXISTS ( SELECT i.idinstalacoes_sp FROM instalacoes_sp i WHERE
				            i.os_sp_idos = o.idos AND i.comiss)";
     	}
     	else//OUTRAS EMPRESAS
     	{
     		$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND
				        EXISTS ( SELECT i.idinstalacoes_sp FROM instalacoes_sp i WHERE
				            i.os_sp_idos = o.idos AND i.comiss)";
     	}
        
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function countOSAberto()
    {
    	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     	{
        	$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE NOT EXISTS 
			        ( SELECT i.idinstalacoes_sp FROM instalacoes_sp i WHERE
			            i.os_sp_idos = o.idos AND i.comiss = 1
			        ) AND o.prazoInstal > CURDATE( )";
     	}
     	else//OUTRAS EMPRESAS
     	{
     		$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND NOT EXISTS
			        ( SELECT i.idinstalacoes_sp FROM instalacoes_sp i WHERE
			            i.os_sp_idos = o.idos AND i.comiss = 1
			        ) AND o.prazoInstal > CURDATE( )";
     	}
        
        $dados   = $this->queryDados($sql);
        
        return $dados[0]['total'];    
    }
    
    public function liste_rel($filtro = 1)
    {
    	//filtro de '$filtro'
			if($filtro == 1)
			{
				$filtro_sql = '';
			}
			else
			{
				$filtro_sql = 'WHERE '.$filtro;
			}
    	
       	$sql = "SELECT * FROM {$this->tabela} $filtro_sql ORDER BY {$this->prk} {$this->defaultOrder}";
       
       	$sqlC = "SELECT COUNT(*) as total FROM {$this->tabela} $filtro_sql ORDER BY {$this->prk} {$this->defaultOrder}";
      
       	$dadosC = $this->queryDados($sqlC);
       
       	$sql = count($this->pag) ? $sql." LIMIT ".$this->pag['ini'].",".$this->pag['end']: $sql;
       	//exit($sql);
       	$dados = $this->queryDados($sql);
       	//print_b($dados,true);
       	for( $i=0; $i<count($dados); $i++) 
       	{
        	$dados[$i] = $this->initObj($dados[$i]);
           
        	$dados[$i]['rel'] = $this->loadRel();
           
//        	$dados[$i]['nomeVsat'] = sub_espchar('SES-'.strtoupper(substr($dados[$i]['rel']['municipios_sp_idcidade']['municipio'],0,2).substr($dados[$i]['rel']['municipios_sp_idcidade']['municipio'],-2)).'-'.strtoupper($dados[$i]['identificador']));
            $dados[$i]['nomeVsat'] = sub_espchar('SES-'.strtoupper(substr($dados[$i]['cidade'],0,2).substr($dados[$i]['cidade'],-2)).'-'.strtoupper($dados[$i]['identificador']));

        }
       
       	if(count($this->pag))
       	{
       		$dados['pag'] = array('total'=>$dadosC[0]['total'],'ini'=>$this->pag['ini'],'lim'=>$this->pag['end'],'rowspage'=>$this->pag['rowspage']);
       	}
       
       	//die_r($dados);
       	return $dados;
    }
    
    //lista ordenando pelo aceite que é de instalação
    function liste_ordenacao()
    {
//    	$select = 'm.municipio AS municipios_municipio, m.macroregiao AS municipios_macroregiao, ';//de municipios
    	$select = 'o.idos AS os_idos, o.numOS AS os_numOS, o.dataSolicitacao AS os_dataSolicitacao, o.prazoInstal AS os_prazoInstal, (SELECT empresa FROM empresas WHERE idempresas = o.empresas_idempresas) AS os_empresas_idempresas, ';//de os
    	$select .= 'ag.mac AS agenda_instal_mac, ag.idagenda_instal_sp AS agenda_instal_idagenda_instal_sp, ag.confirm AS agenda_instal_confirm, ';//de agenda_instal
    	$select .= 'i.idinstalacoes_sp AS instalacoes_idinstalacoes, i.webnms AS instalacoes_webnms, i.packetshapper AS instalacoes_packetshapper, i.reglicenca AS instalacoes_reglicenca, i.opmanager AS instalacoes_opmanager, i.test_prtg AS instalacoes_prtg, i.comiss AS instalacoes_comiss, i.cod_anatel AS instalacoes_cod_anatel, i.data_aceite AS instalacoes_data_aceite, i.nome AS instalacoes_vsat';//de instalacoes
    	
    	$from = 'os_sp as o ';
    	$from .= 'LEFT JOIN instalacoes_sp as i ON i.os_sp_idos = o.idos ';
//    	$from .= 'LEFT JOIN municipios_sp as m ON o.municipios_sp_idcidade = m.idmunicipios_sp ';
    	$from .= 'LEFT JOIN agenda_instal_sp as ag ON ag.os_sp_idos = o.idos ';
    	
    	//ASC / DESC
    	if($this->getASCDESC()!='')
    	{
    		$ascdesc = $this->getASCDESC();
    	}
    	else 
    	{
    		$ascdesc = "DESC";
    	}
    	    	
    	//order pela tabela 'instalacoes', campo 'data_aceite'
    	if($this->getOrderBy()!='')
    	{
    		$order = 'ORDER BY '.$this->getOrderBy().' '.$ascdesc;
    	}
    	else
    	{
    		$order = 'ORDER BY i.data_aceite DESC';
    	}
    	
    	$sql = "SELECT {$select} FROM {$from} {$this->getWhere()} {$order}";
    	$dadosC = $this->queryDados($sql);
    	
   		//para paginacao
   			/*
	   		if($this->pag['atual']!=0)
	    	{
	    		$limit = " LIMIT ".(($this->pag['atual']-1)*$this->pag['rowspage']).",".$this->pag['rowspage'];
	    	}
	    	else
	    	{
	    		$limit = ' LIMIT 0, '.$this->pag['rowspage'].' ';
	    	}
	    	*/
    		$limit = '';
    	
    	$sql = "SELECT {$select} FROM {$from} {$this->getWhere()} {$order} {$limit}";
    	//exit($sql);
    	$dados = $this->queryDados($sql);
    	//print_b($dados,true);
    	for( $i=0; $i<count($dados); $i++) 
       	{
        	$dados[$i] = $this->initObj($dados[$i]);
       	}
       	
       	$dados['pag'] = array(
							'total'=>count($dadosC),
    						'atual'=>$this->pag['atual'],
    						'rowspage'=>$this->pag['rowspage'],
       						'sql'=>$sql
    						);
    	//print_b($dados,true);
       	
       	return $dados;
    }
    
    
    /**
     * CREATE
     * 
     */
	public function create($form)
    {


        $str = 'INSERT INTO '.$this->tabela;
        $strCampos = array();
        $values = array();
        $erros['erros'] = array();

        //inserindo campos vindo do fomulário
    	foreach ($this->camposForm as $campo)
        {
        	//trata data para salvar no BD
            if( array_key_exists($campo,$form))
        	{
            	$form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];

            	//trata check box
            		$form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
            	//fim

            	$this->$campo  = $form[$campo];

            	//para campos requeridos
	            	if(in_array($campo, $this->cmpReq) && empty($this->$campo))
	            	{
	                	$erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
	            	}

	            $values[]      = empty($this->$campo) ? 'NULL' :  "'{$this->$campo}'";
                $strCampos[] = $campo;
			}
         	else
         	{
                //trata, caso seja um checkbox
                if(in_array($campo, $this->cmpCheckBox))
                {
                    $this->$campo = 0;
                    $values[]      = empty($this->$campo) ? 'NULL' :  "'{$this->$campo}'";
                	$strCampos[] = $campo;
                }
            }
        }

        //inserindo campos buscados em outras tabelas
//        if($form['municipios_sp_idcidade']!='' && isset($form['municipios_sp_idcidade']))
//	    {
//	    	$strCampos[] = 'cidade';
//	    	$values[] = "(SELECT municipio FROM municipios_sp WHERE idmunicipios_sp = '{$form['municipios_sp_idcidade']}')";
//	    }
//	    if($form['municipios_sp_idcidadeFaturamento']!='' && isset($form['municipios_sp_idcidadeFaturamento']))
//	    {
//	    	$strCampos[] = 'cidadeFaturamento';
//	    	$values[] = "(SELECT municipio FROM municipios_sp WHERE idmunicipios_sp = '{$form['municipios_sp_idcidadeFaturamento']}')";
//	    }

        if(count($erros['erros']))
        {
        	return $erros;
        }
        $strCampos = implode(",",$strCampos);
        $values = implode(",",$values);
        $sql    = "$str($strCampos)VALUES($values)";



        if($this->query($sql)){
                return $this->getLastId();

        }
       	else{

        	return false;

        }
    }
    
    /**
     * EDIT
     * metodo que sobreescreve o metodo da model
     */
	public function edit($form)
	{
        //die_r($form);
        $str = 'UPDATE '.$this->tabela." SET ";
        $this->camposForm[] = $this->prk;
        $erros['erros'] = array();
        foreach ($this->camposForm as $campo) 
        {   
            if( array_key_exists($campo,$form)) 
            {
            	//trecho para o aceite de OS comissionada
            	if($campo == 'prazoInstal' && $form[$campo]!='')
            	{
            		//procedimentos para aviso por email do aceite
            	}
                
                if(in_array($campo, $this->cmpReq) &&  $form[$campo] == '')
                {
                     $erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
                }
                
                //trata data para salvar no BD
                $form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
                //--
                
                //trata check box
                $form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
                //--
                
                $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$form[$campo]."'";
             
                $values[]       = "$campo = {$this->$campo}";
            }
            else
            {    
                //trata, caso seja um checkbox
                if(in_array($campo, $this->cmpCheckBox)){
                    
                    $this->$campo = 0;
                    $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$this->$campo."'";
             
                    $values[]       = "$campo = {$this->$campo}";
                }            
            }
        }
        
        if(count($erros['erros'])) 
        {    
        	return $erros;
        }
        
        $where = " WHERE $this->prk = ".$this->getPrkValue();
        $values = implode(",",$values);
        $sql    = "$str $values $where";
        
        //TODO: descobrir pq dessa query e reslver com uma query só
//        	$sql2 = "
//        		UPDATE
//        			os_sp o
//        		SET
//        			o.cidade = (
//        				SELECT
//        					municipio
//        				FROM
//        					municipios_sp
//        				WHERE
//        					idmunicipios_sp = {$form['municipios_sp_idcidade']}
//        			)
//        		WHERE
//        			o.idos = '{$form['idos']}'
//        	";
//        	$this->query($sql2);
        
        return $this->query($sql);
    }
    //EDIT - fim
    
	public function carrega($idos)
    {
    	$sql = "SELECT * FROM {$this->tabela} WHERE {$this->prk} = '{$idos}' ";
    	$dados = $this->queryDados($sql);
    	return $dados[0];
    }
    
}

?>

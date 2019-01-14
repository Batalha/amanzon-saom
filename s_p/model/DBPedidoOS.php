<?php

/**
 * Description of DBOS
 *
 * @author Daniel
 * @author Sávio - lotharthesavior@gmail.com
 */
	include_once 'model/DBModel.php';
//     include_once "DBEmpresas.php";

class DBPedidoOS extends DBModel {
    
    protected $idpedido_os;
    protected $solicitacao;
    protected $canal_venda_idcanal_venda;
    protected $fator_comp;
    protected $cliente_final;
    protected $local;
    protected $iduser_cadastro;
    protected $empresas_idempresas;
    protected $criado;
    protected $lat_graus;
    protected $lat_minutos;
    protected $lat_segundos;
    protected $lat_direcao;
    protected $lon_graus;
    protected $lon_minutos;
    protected $lon_segundos;
    protected $lon_direcao;
 
   
    protected $tabela   = 'pedido_os';
    protected $prk      = 'idpedido_os';
    
    protected $rel = array(/*'instalacoes','agenda_instal','municipios',*/'os_pedido_contrato','canal_venda','empresas');
    protected $fgk = array(/*'idos','idos','idos',*/'pedido_os_idpedido_os','canal_venda_idcanal_venda','empresas_idempresas');
    
    protected $cmpData  = array('pedido_criado');
//     protected $depends  = array('municipios_sp_idcidade','municipios_sp_idcidadeFaturamento');
    
    protected $cmpReq   = array(
				            	'solicita',
				            	'canal_venda_idcanal_venda',
				            	'fator_comp',
				            	'cliente_final',
				            	'local',
				            	'iduser_cadastro',
    							'empresas_idempresas',
				            	'criado',
				            	'lat_graus',
				            	'lat_minutos',
				            	'lat_segundos',
				            	'lat_direcao',
				            	'lon_graus',
				            	'lon_menutos',
				            	'lon_segundos',
				            	'lon_direcao',
        						);
              
    protected $camposForm = array(
				            	'solicita',
				            	'canal_venda_idcanal_venda',
				            	'fator_comp',
				            	'cliente_final',
				            	'local',
				            	'iduser_cadastro',
				            	'empresas_idempresas',
				            	'criado',
				            	'lat_graus',
				            	'lat_minutos',
				            	'lat_segundos',
				            	'lat_direcao',
				            	'lon_graus',
				            	'lon_minutos',
				            	'lon_segundos',
				            	'lon_direcao',
        						);
    
    protected $pag = array('atual'=>0,'end'=>15,'rowspage'=>15,'url'=>'OsPedido/liste');
      
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
   
    
//     public function countAgendPend()
//     {
//     	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
//     	{
//         	$sql = "SELECT COUNT( * ) as total FROM os WHERE NOT EXISTS 
//                 ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos )";
//     	}
//     	else//OUTRAS EMPRESAS
//     	{
//     		$sql = "SELECT COUNT( * ) as total FROM os WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND NOT EXISTS 
//                 ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos )";
//     	}
        
//         $dados = $this->queryDados($sql);
        
//         return $dados[0]['total'];    
//     }
    
//     public function countAgend(){
        
//     	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
//     	{
//         	$sql = "SELECT COUNT( idos ) as total FROM os o WHERE EXISTS 
//         			( SELECT a.idagenda_instal, a.os_idos, a.confirm FROM agenda_instal a WHERE a.os_idos = o.idos AND a.confirm IS NULL)";
//     	}
//     	else//OUTRAS EMPRESAS
//     	{
//     		$sql = "SELECT COUNT( idos ) as total FROM os o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND EXISTS 
//         			( SELECT a.idagenda_instal, a.os_idos, a.confirm FROM agenda_instal a WHERE a.os_idos = o.idos AND a.confirm IS NULL)";
//     	}
        
//         $dados   = $this->queryDados($sql);
        
//         return $dados[0]['total'];    
//     }
    
//     public function countAgendConfirm()
//     {
//      	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
//      	{
//         	$sql = "SELECT COUNT( o.idos ) as total FROM os o WHERE EXISTS 
//         			( SELECT a.idagenda_instal FROM agenda_instal a WHERE a.os_idos = o.idos AND a.confirm = 1)";
//      	}
//      	else//OUTRAS EMPRESAS
//      	{
//      		$sql = "SELECT COUNT( o.idos ) as total FROM os o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND EXISTS 
//         			( SELECT a.idagenda_instal FROM agenda_instal a WHERE a.os_idos = o.idos AND a.confirm = 1)";
//      	}
        
//         $dados   = $this->queryDados($sql);
        
//         return $dados[0]['total'];    
// 	}
    
//     public function countOSVenc()
//     {
//      	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
//      	{
//         	$sql = "SELECT COUNT(o.idos) as total FROM os o WHERE  
// 			        NOT EXISTS ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
// 			            i.os_idos = o.idos AND i.comiss ) 
// 			        AND o.prazoInstal < CURDATE( )";
//      	}
//      	else//OUTRAS EMPRESAS
//      	{
//      		$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND
// 			        NOT EXISTS ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
// 			            i.os_idos = o.idos AND i.comiss ) 
// 			        AND o.prazoInstal < CURDATE( )";
//      	}
        
//         $dados   = $this->queryDados($sql);
        
//         return $dados[0]['total'];    
//     }
    
//     public function countOSConc()
//     {
//      	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
//      	{
//         	$sql = "SELECT COUNT(o.idos) as total FROM os o WHERE  
// 				        EXISTS ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
// 				            i.os_idos = o.idos AND i.comiss)";
//      	}
//      	else//OUTRAS EMPRESAS
//      	{
//      		$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND
// 				        EXISTS ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
// 				            i.os_idos = o.idos AND i.comiss)";
//      	}
        
//         $dados   = $this->queryDados($sql);
        
//         return $dados[0]['total'];    
//     }
    
//     public function countOSAberto()
//     {
//     	if($_SESSION['login']['empresas_idempresas']==1)//VODANET
//      	{
//         	$sql = "SELECT COUNT(o.idos) as total FROM os o WHERE NOT EXISTS 
// 			        ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
// 			            i.os_idos = o.idos AND i.comiss = 1
// 			        ) AND o.prazoInstal > CURDATE( )";
//      	}
//      	else//OUTRAS EMPRESAS
//      	{
//      		$sql = "SELECT COUNT(o.idos) as total FROM os_sp o WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND NOT EXISTS 
// 			        ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
// 			            i.os_idos = o.idos AND i.comiss = 1
// 			        ) AND o.prazoInstal > CURDATE( )";
//      	}
        
//         $dados   = $this->queryDados($sql);
        
//         return $dados[0]['total'];    
//     }
    
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
           
        	$dados[$i]['nomeVsat'] = sub_espchar('SES-'.strtoupper(substr($dados[$i]['rel']['municipios_sp_idcidade']['municipio'],0,2).substr($dados[$i]['rel']['municipios_sp_idcidade']['municipio'],-2)).'-'.strtoupper($dados[$i]['identificador']));
       	}
       
       	if(count($this->pag))
       	{
       		$dados['pag'] = array('total'=>$dadosC[0]['total'],'ini'=>$this->pag['ini'],'lim'=>$this->pag['end'],'rowspage'=>$this->pag['rowspage']);
       	}
       
       	//die_r($dados);
       	return $dados;
    }
    
    //lista ordenando pelo aceite que é de instalação
//     function liste_ordenacao()
//     {
//     	$select = 'm.municipio AS municipios_municipio, m.macroregiao AS municipios_macroregiao, ';//de municipios
//     	$select .= 'o.idos AS os_idos, o.numOS AS os_numOS, o.dataSolicitacao AS os_dataSolicitacao, o.prazoInstal AS os_prazoInstal, (SELECT empresa FROM empresas WHERE idempresas = o.empresas_idempresas) AS os_empresas_idempresas, ';//de os
//     	$select .= 'ag.mac AS agenda_instal_mac, ag.idagenda_instal AS agenda_instal_idagenda_instal, ag.confirm AS agenda_instal_confirm, ';//de agenda_instal
//     	$select .= 'i.idinstalacoes AS instalacoes_idinstalacoes, i.webnms AS instalacoes_webnms, i.packetshapper AS instalacoes_packetshapper, i.reglicenca AS instalacoes_reglicenca, i.opmanager AS instalacoes_opmanager, i.test_prtg AS instalacoes_prtg, i.comiss AS instalacoes_comiss, i.cod_anatel AS instalacoes_cod_anatel, i.data_aceite AS instalacoes_data_aceite, i.nome AS instalacoes_vsat';//de instalacoes
    	
//     	$from = 'os_sp as o ';
//     	$from .= 'LEFT JOIN instalacoes as i ON i.os_idos = o.idos ';
//     	$from .= 'LEFT JOIN municipios as m ON o.municipios_sp_idcidade = m.idmunicipios ';
//     	$from .= 'LEFT JOIN agenda_instal as ag ON ag.os_idos = o.idos ';
    	
//     	//ASC / DESC
//     	if($this->getASCDESC()!='')
//     	{
//     		$ascdesc = $this->getASCDESC();
//     	}
//     	else 
//     	{
//     		$ascdesc = "DESC";
//     	}
    	    	
//     	//order pela tabela 'instalacoes', campo 'data_aceite'
//     	if($this->getOrderBy()!='')
//     	{
//     		$order = 'ORDER BY '.$this->getOrderBy().' '.$ascdesc;
//     	}
//     	else
//     	{
//     		$order = 'ORDER BY i.data_aceite DESC';
//     	}
    	
//     	$sql = "SELECT {$select} FROM {$from} {$this->getWhere()} {$order}";
//     	$dadosC = $this->queryDados($sql);
    	
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
//     		$limit = '';
    	
//     	$sql = "SELECT {$select} FROM {$from} {$this->getWhere()} {$order} {$limit}";
//     	//exit($sql);
//     	$dados = $this->queryDados($sql);
//     	//print_b($dados,true);
//     	for( $i=0; $i<count($dados); $i++) 
//        	{
//         	$dados[$i] = $this->initObj($dados[$i]);
//        	}
       	
//        	$dados['pag'] = array(
// 							'total'=>count($dadosC),
//     						'atual'=>$this->pag['atual'],
//     						'rowspage'=>$this->pag['rowspage'],
//        						'sql'=>$sql
//     						);
//     	//print_b($dados,true);
       	
//        	return $dados;
//     }
    
    
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

            if( array_key_exists($campo, $form))
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
//         if($form['municipios_sp_idcidade']!='' && isset($form['municipios_sp_idcidade']))
// 	    {
// 	    	$strCampos[] = 'cidade';
// 	    	$values[] = "(SELECT municipio FROM municipios WHERE idmunicipios = '{$form['municipios_sp_idcidade']}')";
// 	    }
// 	    if($form['municipios_sp_idcidadeFaturamento']!='' && isset($form['municipios_sp_idcidadeFaturamento']))
// 	    {
// 	    	$strCampos[] = 'cidadeFaturamento';
// 	    	$values[] = "(SELECT municipio FROM municipios WHERE idmunicipios = '{$form['municipios_sp_idcidadeFaturamento']}')";
// 	    }
        
        if(count($erros['erros'])) 
        {   
        	return $erros;
        }
        $strCampos = implode(",",$strCampos);
        $values = implode(",",$values);
        $sql    = "$str($strCampos)VALUES($values)";
        
        if($this->query($sql))
       		return $this->getLastId();
       	else
        	return false;
    }
    
    /**
     * EDIT
     * metodo que sobreescreve o metodo da model
     */
// 	public function edit($form)
// 	{
//         //die_r($form);
//         $str = 'UPDATE '.$this->tabela." SET ";
//         $this->camposForm[] = $this->prk;
//         $erros['erros'] = array();
//         foreach ($this->camposForm as $campo) 
//         {   
//             if( array_key_exists($campo,$form)) 
//             {
//             	//trecho para o aceite de OS comissionada
//             	if($campo == 'prazoInstal' && $form[$campo]!='')
//             	{
//             		//procedimentos para aviso por email do aceite
//             	}
                
//                 if(in_array($campo, $this->cmpReq) &&  $form[$campo] == '')
//                 {
//                      $erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
//                 }
                
//                 //trata data para salvar no BD
//                 $form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
//                 //--
                
//                 //trata check box
//                 $form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
//                 //--
                
//                 $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$form[$campo]."'";
             
//                 $values[]       = "$campo = {$this->$campo}";
//             }
//             else
//             {    
//                 //trata, caso seja um checkbox
//                 if(in_array($campo, $this->cmpCheckBox)){
                    
//                     $this->$campo = 0;
//                     $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$this->$campo."'";
             
//                     $values[]       = "$campo = {$this->$campo}";
//                 }            
//             }
//         }
        
//         if(count($erros['erros'])) 
//         {    
//         	return $erros;
//         }
        
//         $where = " WHERE $this->prk = ".$this->getPrkValue();
//         $values = implode(",",$values);
//         $sql    = "$str $values $where";
        
//         //TODO: descobrir pq dessa query e reslver com uma query só
//         	$sql2 = "
//         		UPDATE 
//         			os_sp o 
//         		SET 
//         			o.cidade = (
//         				SELECT 
//         					municipio 
//         				FROM 
//         					municipios 
//         				WHERE 
//         					idmunicipios = {$form['municipios_sp_idcidade']}
//         			) 
//         		WHERE 
//         			o.idos = '{$form['idos']}'
//         	";
//         	$this->query($sql2);
        
//         return $this->query($sql);
//     }
    //EDIT - fim
    
	public function carrega($idos)
    {
    	$sql = "SELECT * FROM {$this->tabela} WHERE {$this->prk} = '{$idos}' ";
    	$dados = $this->queryDados($sql);
    	return $dados[0];
    }
    
}

?>

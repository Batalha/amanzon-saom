<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 's_p/model/DBModel_sp.php';

class DBIncidente_sp extends DBModel_sp
{
    protected $idincidentes;
    protected $descricao;
    protected $data;
    protected $prioridade;
    protected $instalacoes_idinstalacoes;
    protected $atend_vsat_idatend_vsat;
//    protected $idprodemge;
    protected $tecnicoNoc;

    protected $tabela = 'incidentes_sp';
    protected $rel    = array(
    						'instalacoes_sp'
    						);
    protected $fgk    = array(
    						'instalacoes_idinstalacoes'
    						);
    protected $prk    = 'idincidentes';
    protected $cmpData= array('data');
    protected $cmpReq = array('descricao','data','prioridade'/*,'idprodemge'*/,'tecnicoNoc','instalacoes_idinstalacoes');
    protected $cmpImg = array('upload1','upload2');
    
    //metodos construidos para menu extra 'tecnicos' de incidentes
    protected $nomeVsat = array();
        
    protected $camposForm = array(
						        'instalacoes_idinstalacoes',
						        'descricao',
						        'data',
						        'prioridade',
						        'atend_vsat_idatend_vsat',
//    							'idprodemge',
    							'tecnicoNoc',
    							'saom'
						    	);
      
    public function  __construct()
    {    
        parent::__construct();    
    } 
    
    //SETS
    	public function setIdIncidentes($novoIdIncidentes)
    	{
    		$this->idincidentes = $novoIdIncidentes;
    	}
    	public function setNomeVsat($nomeBsatNovo)
    	{
    		$this->nomeVsat = $nomeVsatNovo;
    	}
    	public function setTecnicoNoc($tecnico)
    	{
    		$this->tecnicoNoc = $tecnico;
    	}
//    	public function setIdProdemge($idProdemgeNovo)
//    	{
//    		$this->idProdemge = $idProdemgeNovo;
//    	}
    	public function setInstalacoes_idinstalacoes($instalacoes_idinstalacoes_novo)
    	{
    		$this->instalacoes_idinstalacoes = $instalacoes_idinstalacoes_novo;
    	}
	//SETS - fim
	
    //GET
		public function getIdIncidentes()
    	{
    		return $this->idincidentes;
    	}
    	
    	public function getNomeVsat()
    	{
    		return $this->nomeVsat;
    	}
    	
    	public function getTecnicoNoc()
    	{
    		return $this->tecnicoNoc;
    	}
    	
//    	public function getIdProdemge()
//    	{
//    		return $this->idProdemge;
//    	}
    	
    	public function getInstalacoes_idinstalacoes()
    	{
    		return $this->instalacoes_idinstalacoes;
    	}
    	
    	public function getCamposForm()
    	{
    		return $this->camposForm;
    	}
    //GET - fim
    
    public function liste($filtro = 1)
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
			
		$this->orderBy = $this->orderBy ? $this->orderBy : $this->prk;
		
		//selects especificos
			if($this->select!='')
			{
				$sql = "SELECT {$this->select} FROM {$this->tabela} {$filtro_sql} {$this->leftJoin} ORDER BY {$this->orderBy} {$this->defaultOrder}";
			}
			else
			{
				$sql = "SELECT * FROM {$this->tabela} {$filtro_sql} {$this->leftJoin} ORDER BY {$this->orderBy} {$this->defaultOrder}";
			}
    	
    	$sqlC = "SELECT COUNT(*) as total FROM {$this->tabela} {$filtro_sql} ORDER BY {$this->prk} {$this->defaultOrder}";
    	$dadosC = $this->queryDados($sqlC);     
    	$sql = count($this->pag) ? $sql." LIMIT ".$this->pag['ini'].",".$this->pag['end']: $sql;
    	$dados = $this->queryDados($sql);

		for( $i=0; $i<count($dados); $i++) 
       	{
        	$dados[$i] = $this->initObj($dados[$i]);
        	$dados[$i]['rel'] = $this->loadRel();
       	}
       	
       	if(count($this->pag))
       	{
			$dados['pag'] = array('total'=>$dadosC[0]['total'],'ini'=>$this->pag['ini'],'lim'=>$this->pag['end'],'rowspage'=>$this->pag['rowspage']);
       	}
       	
       	//die_r($dados);
       	return $dados;
    }
    
	//upload com pasta padrao de incidentes
    //TODO: APLICAR CASO DE USO BASEADO NO SUCESSO DE ENVIO DE UPLOAD
    public function uploadImg($form)
    {
    	$str = 'UPDATE '.$this->tabela." SET ";
        
    	//print_b($form,true);
    	
    	//trata imagens
      	foreach($form as $campo => $val) 
      	{
        	if(in_array($campo,$this->cmpImg))
        	{
				if( ! empty($form[$campo]))
				{
					$move = move_uploaded_file($form[$campo]['tmp_name'], 'public/imagens/incidentes/'.$form[$campo]['name']);
					if ($move)
					{
                    	$values = "$campo = 'public/imagens/incidentes/".$form[$campo]['name']."'";
					}
            	}   
        	}
      	}  
        //--
        
      	$where = " WHERE $this->prk = ".$this->getPrkValue();
      	$sql    = "$str $values $where";
      	return $this->query($sql);
    }
    
    
    //PAGINA INICIAL
		
    	public function ContaIncidentesAbertos()
		{
			if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     		{
				$sql = "SELECT COUNT(i.idincidentes) total FROM incidentes_sp i WHERE 
				        EXISTS (
				            SELECT idatend_vsat FROM atend_vsat_sp a WHERE 
				                a.incidentes_sp_idincidentes = i.idincidentes AND
				                a.status_atend_idstatus_atend = 1
				        );";
     		}
     		else 
     		{
     			$sql = "SELECT COUNT(i.idincidentes) total FROM incidentes_sp i WHERE 
				        (SELECT o.empresas_idempresas FROM os_sp o WHERE idos = (
				        	SELECT inst.os_sp_idos FROM instalacoes_sp inst WHERE inst.idinstalacoes_sp = i.instalacoes_idinstalacoes)
				        ) = {$_SESSION['login']['empresas_idempresas']} AND 
				        EXISTS (
				            SELECT idatend_vsat FROM atend_vsat_sp a WHERE 
				                a.incidentes_sp_idincidentes = i.idincidentes AND
				                a.status_atend_idstatus_atend = 1
				        );";
     		}
			$dados = $this->queryDados($sql);
			
			return $dados[0]['total'];
		}
		
		public function ContaIncidentesEmAtendimentos()
		{
			if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     		{
				$sql = "SELECT COUNT(i.idincidentes) total FROM incidentes_sp i WHERE 
				        EXISTS (
				            SELECT idatend_vsat FROM atend_vsat_sp a WHERE 
				                a.incidentes_sp_idincidentes = i.idincidentes AND
				                a.status_atend_idstatus_atend = 2
				        );";
     		}
     		else
     		{
     			$sql = "SELECT COUNT(i.idincidentes) total FROM incidentes_sp i WHERE 
     					(SELECT o.empresas_idempresas FROM os_sp o WHERE idos = (
				        	SELECT inst.os_sp_idos FROM instalacoes_sp inst WHERE inst.idinstalacoes_sp = i.instalacoes_idinstalacoes)
				        ) = {$_SESSION['login']['empresas_idempresas']} AND
				        EXISTS (
				            SELECT idatend_vsat FROM atend_vsat_sp a WHERE 
				                a.incidentes_sp_idincidentes = i.idincidentes AND
				                a.status_atend_idstatus_atend = 2
				        );";
     		}
			$dados = $this->queryDados($sql);
			
			return $dados[0]['total'];
		}
		
		public function ContaIncidentesFinalizados()
		{
			if($_SESSION['login']['empresas_idempresas']==1)//VODANET
     		{
				$sql = "SELECT COUNT(i.idincidentes) total FROM incidentes_sp i WHERE 
				        EXISTS (
				            SELECT idatend_vsat FROM atend_vsat_sp a WHERE 
				                a.incidentes_sp_idincidentes = i.idincidentes AND
				                a.status_atend_idstatus_atend = 3
				        );";
     		}
     		else
     		{
     			$sql = "SELECT COUNT(i.idincidentes) total FROM incidentes_sp i WHERE 
     					(SELECT o.empresas_idempresas FROM os_sp o WHERE idos = (
				        	SELECT inst.os_sp_idos FROM instalacoes_sp inst WHERE inst.idinstalacoes_sp = i.instalacoes_idinstalacoes)
				        ) = {$_SESSION['login']['empresas_idempresas']} AND
				        EXISTS (
				            SELECT idatend_vsat FROM atend_vsat_sp a WHERE 
				                a.incidentes_sp_idincidentes = i.idincidentes AND
				                a.status_atend_idstatus_atend = 3
				        );";
     		}
			$dados = $this->queryDados($sql);
			
			return $dados[0]['total'];
		}

    public function contaIncidentesTotal(){
        $sql = "SELECT idincidentes FROM incidentes_sp ORDER BY idincidentes DESC ";

        $dados = $this->queryDados($sql);



        return $dados[0]['idincidentes'];

    }
		
	//PAGINA INICIAL
    
}
?>

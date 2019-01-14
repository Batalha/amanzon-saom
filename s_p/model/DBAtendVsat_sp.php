<?php

/**
 * Description of DBOS
 *
 * @author Daniel
 */

include_once 's_p/model/DBModel_sp.php';

class DBAtendVsat_sp extends DBModel_sp 
{
    protected $idatend_vsat;
    protected $data;
    protected $atendimento;
    protected $status_atend_idstatus_atend;
    protected $instalacoes_sp_idinstalacoes_sp;
    protected $usuarios_idusuarios;
    protected $incidentes_sp_idincidentes;
    protected $resposta_agilis;
    protected $tipo_atendimento_idtipo_atendimento;
    protected $atendimento_pai;
    
    protected $tabela = 'atend_vsat_sp';
    protected $prk    = 'idatend_vsat';
    protected $rel    = array(
    						'status_atend',
    						'instalacoes_sp',
    						'usuarios',
    						'incidentes_sp'
    						);
    
    protected $fgk    = array(
    						'status_atend_idstatus_atend',
    						'instalacoes_sp_idinstalacoes_sp',
    						'usuarios_idusuarios',
    						'incidentes_sp_idincidentes'
    						);
    
    protected $cmpReq = array(
    						'atendimento',
    						'tipo_atendimento_idtipo_atendimento',
    						'status_atend_idstatus_atend'
    						);
    
    protected $camposForm = array(
        						'data',
    							'atendimento',
    							'status_atend_idstatus_atend',
        						'instalacoes_sp_idinstalacoes_sp',
        						'usuarios_idusuarios',
        						'incidentes_sp_idincidentes',
        						'resposta_agilis',
        						'tipo_atendimento_idtipo_atendimento',
    							'atendimento_pai',
    							'saom'
    							);
    							
	protected $dadosCarregados;

	protected $sendMail = array(
	    						'create'=>array(
	    										'assunto'=>'',
	    										'msg'=>''
	    										),
	    						'edit'=>array(
	    									'assunto'=>'',
	    									'msg'=>''
	    									)
	    						);
	
	//SETS
		public function setIdatend_vsat($idatend_vsat_novo)
		{
			$this->idatend_vsat = $idatend_vsat_novo;
		}
		public function setStatus_atend_idstatus_atend($status_novo)
		{
			$this->status_atend_idstatus_atend = $status_novo;
		}
	//SETS - fim
	
	//GETS
		public function getIdatend_vsat()
		{
			return $this->idatend_vsat;
		}
		public function getStatus_atend_idstatus_atend()
		{
			return $this->status_atend_idstatus_atend;
		}
	//GETS - fim
      
    public function  __construct() 
    {
        parent::__construct();    
    }
    
	//metodo generico de insert
    public function create($form)
    {
        $str = 'INSERT INTO '.$this->tabela;
        $strCampos = array();
        $values = array();
        $erros['erros'] = array();
        
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
        if(count($erros['erros'])) 
        {   
        	return $erros;
        }
        $strCampos = implode(",",$strCampos);
        $values = implode(",",$values);
        $sql    = "$str($strCampos)VALUES($values)";
        
        //exit($sql);
        
       	if( $this->query($sql) )
        	return $this->getLastId();
       	
       	else
        	return false;
       	
    }
    
	public function edit($form)
    {
        $str = 'UPDATE '.$this->tabela." SET ";
        $this->camposForm[] = $this->prk;
        $erros['erros'] = array();
        foreach ($this->camposForm as $campo) 
        {
            if( array_key_exists($campo,$form)) 
            {
                if(in_array($campo, $this->cmpReq) &&  $form[$campo] == '')
                {
                	$erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
                }
                
                //trata data para salvar no BD
                	$form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
                
                //trata check box
                	$form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
                
                $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$form[$campo]."'";
             
                $values[] = "$campo = {$this->$campo}";
            }
            else 
            {
                //trata, caso seja um checkbox
                if(in_array($campo, $this->cmpCheckBox))
                {    
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
        //exit($sql);
        
        return $this->query($sql);
    }
    
    
	public function carrega()
    {
    	$sql = "SELECT * FROM atend_vsat_sp WHERE idatend_vsat = {$this->idatend_vsat}";
    	$dados = $this->queryDados($sql);
    	if(count($dados))
    	{
    		//em campos
    		for($i=0;$i<count($this->camposForm);$i++)
    		{
    			$this->$$this->camposForm[$i] = $dados[0][$this->camposForm[$i]];
    		}
    		//em array
    		$this->dadosCarregados = $dados[0];
    		$this->dadosCarregados['resultado'] = 'ok';
    	}
    	else
    	{
    		//sem resultados
    		$this->dadosCarregados['resultado'] = 'no';
    	}
    }
    
}

?>

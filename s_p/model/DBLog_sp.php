<?php

/**
 * Description of DBOS
 *
 * @author Daniel
 */

include_once 's_p/model/DBModel_sp.php';

class DBLog_sp extends DBModel_sp
{
    protected $idlog;
    protected $data;
    protected $usuarios_idusuarios;
    protected $tabelareferencia;
    protected $idreferencia;
    protected $log_acao_idlog_acao;
    protected $observacoes;
    
    protected $tabela = 'log';
    protected $prk    = 'idlog';
    protected $rel    = array(
    						'usuarios',
    						'log_acao'
    						);
    
    protected $fgk    = array(
    						'usuarios_idusuarios',
    						'log_acao_idlog_acao'
    						);
    
    protected $cmpReq = array(
    						'data',
    						'usuarios_idusuarios',
    						'tabelareferencia',
    						'idreferencia',
    						'observacoes',
    						'log_acao_idlog_acao'
    						);
    
    protected $camposForm = array(
        						'data',
    							'usuarios_idusuarios',
        						'tabelareferencia',
        						'idreferencia',
        						'log_acao_idlog_acao',
    							'observacoes'
    							);

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
		public function setData($data)
		{
			$this->data = $data;
		}
		
    	public function setUsuarios_idusuarios($usuarios_idusuarios)
    	{
    		$this->usuarios_idusuarios = $usuarios_idusuarios;
    	}
    	
	    public function setTabelareferencia($tabelareferencia)
	    {
	    	$this->tabelareferencia = $tabelareferencia;
	    }
	    
	    public function setIdreferencia($idreferencia)
	    {
	    	$this->idreferencia = $idreferencia;
	    }
	    
	    public function setLog_acao_idlog_acao($log_acao_idlog_acao)
	    {
	    	$this->log_acao_idlog_acao = $log_acao_idlog_acao;
	    }
	    
	    public function setObservacoes($observacoes)
	    {
	    	$this->observacoes = $observacoes;
	    }
	//SETS - fim
	
	//GETS
		public function getData()
		{
			return $this->data;
		}
		
    	public function getUsuarios_idusuarios()
    	{
    		return $this->usuarios_idusuarios;
    	}
    	
	    public function getTabelareferencia()
	    {
	    	return $this->tabelareferencia;
	    }
	    
	    public function getIdreferencia()
	    {
	    	return $this->idreferencia;
	    }
	    
	    public function getLog_acao_idlog_acao()
	    {
	    	return $this->log_acao_idlog_acao;
	    }
	    
	    public function getObservacoes()
	    {
	    	return $this->observacoes;
	    }
	//GETS - fim
      
    public function  __construct() 
    {
        parent::__construct();    
    }
    
	public function insere()
	{
		$sql = "INSERT INTO log (
								data, 
								usuarios_idusuarios, 
								tabelareferencia, 
								idreferencia, 
								log_acao_idlog_acao, 
								observacoes
								) 
							VALUES 
								(
								'{$this->data}', 
								'{$this->usuarios_idusuarios}', 
								'{$this->tabelareferencia}', 
								'{$this->idreferencia}', 
								'{$this->log_acao_idlog_acao}', 
								'{$this->observacoes}'
								)";
		//exit($sql);
		$result = $this->query($sql);
		if($result)
		{
			return $this->getLastId();
		}
		else
		{
			return false;
		}
	}
    
}

?>

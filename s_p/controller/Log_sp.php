<?php

/**
 * Description of OS
 *
 * @author Daniel - | 16/12/2011
 * @author Sávio 16/12/2011 | -
 */

include_once 's_p/model/DBLog_sp.php';

class Log_sp extends Controller
{
	protected $Log;
    protected $tplDir = 's_p/tampletes/log';
    
    public function __construct() 
    {
    	parent::__construct();
    	
    	$this->DB = new DBLog_sp();
    }
    
    public function registraLog(
    						$tabelareferencia, 
    						$idreferencia, 
    						$log_acao_idlog_acao, 
    						$observacoes
    						)
    {
    	$this->DB->setUsuarios_idusuarios($_SESSION['login']['idusuarios']);
    	$this->DB->setData(date('Y-m-d H:i:s'));
    	$this->DB->setTabelareferencia($tabelareferencia);
    	$this->DB->setIdreferencia($idreferencia);
    	$this->DB->setLog_acao_idlog_acao($log_acao_idlog_acao);
    	$this->DB->setObservacoes($observacoes);
    	
    	$insercao = $this->DB->insere();
    	return $insercao;
    }
    
    
    // --------------------------------------------------------------------------------------
    // ----------------- REGISTRO DE LOG COMISSIONAMENTO ------------------------------------
    // --------------------------------------------------------------------------------------
    
    public function registroLogEdicaoComissionamento(
    										Array $form , 
    										Zend_Db_Table_Row $instalacao ,
    										$dados_modificados
    										)
    {
    	$observacoes = "Dados modificados:<br/>";

    	if( is_array($dados_modificados) )
	    	foreach ( $dados_modificados as $dado_modificado )
	    		foreach ( $dado_modificado as $chave => $valor  )
	    			$observacoes .= " {$chave} => {$valor} <br/> ";
	    else
	    	$observacoes .= "(nenhum)";
    	
    	$data = array(
	    	'data' => date('Y-m-d H:i:s'),
	    	'usuarios_idusuarios' => $_SESSION['login']['idusuarios'],
	    	'tabelareferencia' => 'instalacoes_sp',
	    	'idreferencia' => $instalacao->idinstalacoes_sp,
	    	'log_acao_idlog_acao' => 2,
	    	'observacoes' => $observacoes,
	    	'acao' => 'Edição do Comissionamento'
    	);
    	if( !$this->Log->insert($data) )
    	{
    		$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = 'Erro no registro do log.';
			die_json($arrReturn);
    	}
    	else
    		return true;	
    }
    
    
    
    // --------------------------------------------------------------------------------------
    // ----------------- REGISTRO DE ACESSOS ------------------------------------------------
    // --------------------------------------------------------------------------------------
    
    public function registro_acesso( $elemento )
    {
    	switch ( $elemento )
    	{
    		// --------------------------------- COMISSIONAMENTO
    		case 'comissionamento_edit':
    			$this->registra_acesso_comissionamento_edit( $_POST['idinstalacoes_sp'] );
    			break;
    		case 'comissionamento_view':
    			$this->registra_acesso_comissionamento_view( $_POST['idos'] );
    			break;
    			
    		// ------------------------------------------------ OS
    		case 'os_view':
    			$this->registra_acesso_os_view( $_POST['idos'] );
    			break;
    	}
    }
    
    // --------------------------------- COMISSIONAMENTO
    		
    public function registra_acesso_comissionamento_view( $idos )
    {
    	$instalacao = $this->Instalacao_sp->fetchRow(" os_sp_idos = '{$idos}' ");
    	
    	$agora = date('Y-m-d H:i:s');
    	
    	$observacoes = "
    		Acesso ao view_comiss (ver comissionamento) para a OS {$idos}
    		e Instalação {$instalacao->idinstalacoes_sp}.
    	";
    	
    	$data = array(
    		'data' => $agora,
    		'usuarios_idusuarios' => $_SESSION['login']['idusuarios'],
    		'tabelareferencia' => 'instalacoes_sp',
    		'idreferencia' => $instalacao->idinstalacoes_sp,
    		'log_acao_idlog_acao' => 3,
    		'observacoes' => trim($observacoes),
    		'acao' => 'Visualização de Comissionamento'
    	);
    	$resposta = $this->Log->insert($data);
    	
    	if( !$resposta )
    		exit('erro');
    	else
    		exit($resposta);
    }
    public function registra_acesso_comissionamento_edit( $idinstalacoes )
    {
    	$agora = date('Y-m-d H:i:s');
    	
    	$observacoes = "
    		Acesso ao edit_comiss (dição de comissionamento) para a Instalação {$idinstalacoes}.
    	";
    	
    	$data = array(
    		'data' => $agora,
    		'usuarios_idusuarios' => $_SESSION['login']['idusuarios'],
    		'tabelareferencia' => 'instalacoes_sp',
    		'idreferencia' => $idinstalacoes,
    		'log_acao_idlog_acao' => 3,
    		'observacoes' => trim($observacoes),
    		'acao' => 'Formulário para Edição de Comissionamento'
    	);
    	$resposta = $this->Log->insert($data);
    	
    	if( !$resposta )
    		exit('erro');
    	else
    		exit($resposta);
    }
    
    // ------------------------------------------------ OS
    
    public function registra_acesso_os_view( $idos )
    {
    	$agora = date('Y-m-d H:i:s');
    	
    	$observacoes = "
    		Acesso ao os_view (ver OS) para a OS {$idos}.
    	";
    	
    	$data = array(
    		'data' => $agora,
    		'usuarios_idusuarios' => $_SESSION['login']['idusuarios'],
    		'tabelareferencia' => 'os_sp',
    		'idreferencia' => $idos,
    		'log_acao_idlog_acao' => 3,
    		'observacoes' => trim($observacoes),
    		'acao' => 'Visualização de Comissionamento'
    	);
    	$resposta = $this->Log->insert($data);
    	
    	if( !$resposta )
    		exit('erro');
    	else
    		exit($resposta);
    }
}

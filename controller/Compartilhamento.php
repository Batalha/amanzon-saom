<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OS
 *
 * @author Daniel
 */

include_once 'model/DBCompartilhamento.php';
include_once "controller/Log.php";

class Compartilhamento extends Controller 
{
	
	protected $tplDir = 'compartilhamento';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->DB = new DBCompartilhamento();
        $this->Log = new Log();
    }
    
    public function liste()
    {	
    	$listaCompartilhamentos = $this->BuscaListaCompartilhamentos(
    		( isset($_POST['form']) )?$_POST['form']:'' 
    	);
    	
    	$this->smarty->assign('contagem',count($listaCompartilhamentos));
    	$this->smarty->assign('login',$_SESSION['login']);
    	$this->smarty->assign('lista',$listaCompartilhamentos);
    	$this->smarty->display("{$this->tplDir}/list.tpl");
    }
    
    public function listaNova()
    {
    	$where = " ativo = 1 ";
    		
    	$order = " data_envio DESC ";
    	$listaCompartilhamentos = $this->Compartilhamento->fetchAll( $where , $order );
    	
    	if( $listaCompartilhamentos instanceof Zend_Db_Table_Rowset )
    		$listaCompartilhamentos = $listaCompartilhamentos->toArray();
		
    	foreach( $listaCompartilhamentos as $chave => $compartilhamento )
    	{
    		$nome = explode('/',$compartilhamento['endereco']);
    		$nomeArquivo = $nome[1];
    		$listaCompartilhamentos[$chave]['nome'] = $nomeArquivo;
    	}
    	
    	$this->smarty->assign('contagem',count($listaCompartilhamentos));
    	$this->smarty->assign('login',$_SESSION['login']);
    	$this->smarty->assign('lista',$listaCompartilhamentos);
    	$this->smarty->display("{$this->tplDir}/listaNova.tpl");
    }
    
    public function apagaCompartilhamento()
    {
    	$arquivo = $this->DB->carrega($this->dadosP['param']);
    	
    	//apaga arquivo
    	//unlink($arquivo['endereco']);
    	
    	//TODO: arrumar isso
    	$sql = "
    		UPDATE compartilhamento
    		SET ativo = 0
    		WHERE idcompartilhamento = {$arquivo['idcompartilhamento']}
    	";
    	$this->DB->query($sql);
    }
    
	public function upload()
    {
    	$resultado = $this->DB->upload($this->dadosF);
    	
    	if( $resultado == true )
        	die('<div class="alert alert-success">Arquivo enviado com sucesso.</div>');
        	
        else
        	die('<div class="alert alert-error">'.$resultado.'</div>');
    }
    
    public function resgate($idcompartilhamento)
    {
    	//print_b($_SESSION,true);
    	if($_SESSION)
    	{
	    	//TODO: arrumar isso
	    	$sql = "
	    		SELECT arquivo_supervisor AS permissao 
	    		FROM usuarios 
	    		WHERE idusuarios = '{$_SESSION['login']['idusuarios']}'
	    	";
	    	$arquivo_supervisor = $this->DB->queryDados($sql);
	    	//print_b($arquivo_supervisor,true);
	    	
	    	if( $arquivo_supervisor[0]['permissao'] == 1 )
	    	{
	    		//carrega compartilhamento
	    		$compartilhamento = $this->DB->carrega($idcompartilhamento);
	    		
	    		$filename = $compartilhamento['endereco'];
	    		$ext1 = explode('.',$compartilhamento['endereco']);$ext = $ext[1];
	    		
	    		header("Pragma: ");
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header('Content-disposition: attachment; filename='.basename($filename));
				header("Content-Type: application/{$ext}");
				header("Content-Transfer-Encoding: binary");
				header('Content-Length: '. filesize($filename));
				readfile($filename);
				
	    	}
	    	else
	    		echo "Usuário sem permissão. Verifique com o administrador.";
    	}
    }
    
    // ----------------------------------------------------------------
    // --------------- 
    // ----------------------------------------------------------------
    
    public function BuscaListaCompartilhamentos( $post )
    {
    	$where = " ativo = 1 ";
    	
    	if( isset($_POST['form']) )
    	{
    		$dadosP = json_decode( $_POST['form'] );
    		foreach ( $dadosP as $chave => $campoForm )
    			if( !empty($campoForm->valor) )
    			{
    				$where .= " AND {$campoForm->campo} LIKE '%{$campoForm->valor}%' ";
    				$this->smarty->assign($campoForm->campo,$campoForm->valor);
    			}
    	}
    		
    	$order = " data_envio DESC ";
    	$listaCompartilhamentos = $this->Compartilhamento->fetchAll( $where , $order );
    	
    	if( $listaCompartilhamentos instanceof Zend_Db_Table_Rowset )
    		$listaCompartilhamentos = $listaCompartilhamentos->toArray();
    		
    	foreach( $listaCompartilhamentos as $chave => $compartilhamento )
    	{
    		$nome = explode('/',$compartilhamento['endereco']);
    		$nomeArquivo = $nome[1];
    		$listaCompartilhamentos[$chave]['nome'] = $nomeArquivo;
    	}
    	
    	return $listaCompartilhamentos;
    }
    
}

?>

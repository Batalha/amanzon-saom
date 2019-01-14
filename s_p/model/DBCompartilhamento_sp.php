<?php

/**
 * 
 * Classe DBCronometro
 * 
 * Objetivo de lidar com o Banco da Tabela "cronometro", 
 * controlada pela controller 'Cronometro'
 * 
 * @author Lothar
 *
 */

include_once 's_p/model/DBModel_sp.php';
include_once 'helpers.class.php';

/*
 * Anotações:
 * 
 * 1.A pausa terá o seguinte formato:
 * 		{numero da pausa}|{descricao da pausa}|{mesmo numero, que significa fechamento da pausa}|-|
 * 2.Parâmetro de separação entre itens da pausa: "|"
 * 3.Parâmetro de separação entre pausas: "|-|"
 */

class DBCompartilhamento_sp extends DBModel_sp
{
	
	//campos
	protected $idcompartilhamento;
	protected $endereco;
	protected $data_envio;
	protected $usuario_envio;
	
	//em array
	protected $dadosCarregados = array();
	
	//padrao
	protected $tabela = 'compartilhamento_sp';
    protected $rel    = array('usuarios');
    protected $fgk    = array('usuario_envio');
    protected $prk    = 'idcompartilhamento';//primary key
    protected $cmpData = array('data_envio');
    protected $cmpReq = array(
    						'endereco',
    						'data_envio',
    						'usuario_envio'
    						);
    protected $camposForm = array(
    							'endereco',
	    						'data_envio',
	    						'usuario_envio'
    							);
    							
    public function __construct()
    {
    	parent::__construct();
    }
    
	public function upload($form)
    {
    	$str = 'INSERT INTO '.$this->tabela." ( endereco , data_envio , usuario_envio , ativo ) VALUES ";
    	

        
    	if( ! empty($form['endereco']) )
		{
			$move = move_uploaded_file($form['endereco']['tmp_name'], normaliza(str_replace(' ', '_', 'upload/'.$form['endereco']['name'])) );
			if( $move )
           		$value = "( 'upload/".normaliza(str_replace(' ', '_', $form['endereco']['name']))."', '".date('Y-m-d H:i:s')."' , '{$_SESSION['login']['idusuarios']}', 1 )";
        }
        
        if( isset($value) )
        {
      		$sql = "$str $value";
//       		echo die_json($sql);
      		if( $this->query($sql) )
      		{
      			$idInserido = $this->getLastId();
      			

      			
	      		$assunto = "Acompanhamento Prodemge ".date('d-m-Y');
	        	$msg = "Senhores, segue o acompanhamento de hoje.<br/>
	        			Favor baixar no seguinte link:<br/>
	        			<a target='_blank' href='".BASE_PATH."/Compartilhamento/resgate/{$idInserido}'>{$form['endereco']['name']}</a>
	        			<br/><br/>
						Atenciosamente,<br/>
						<br/>
						Vodanet Telecomunicações Ltda.<br/>
						http://www.vodanet-telecom.com<br/>
						<img src='http://saom.vodanet-telecom.com/public/imagens/logo_vodanet.jpg' />";
	        	//TODO: arrumar isso
	        	$sql = "SELECT email, nome FROM usuarios WHERE arquivo_supervisor = 1";
	        	$usuariosHabilitados = $this->queryDados($sql);
	        	
	        	$Helper = new Helpers();
	        	//print_b($usuariosHabilitados,true);
	        	for( $i=0 ; $i < count($usuariosHabilitados) ; $i++ )
	        	{
	        		$arrayEmails[] = $usuariosHabilitados[$i]['email'];
	        	}
	        	//$arrayEmails = array('savio@vodanet-telecom.com');
	        	
	        	//print_b($arrayEmails,true);
        		if(
        			!$Helper->sendMail(
	        			$assunto,
	        			$arrayEmails,
	        			$msg
        			)
        		 )
        		{
        			exit("Erro ao enviar email.");
        		}
        	
      			return true;
      		}
      		else
      		{
      			return false;
      		}
        }
        else
        {
        	return false;
        }
    }
    
	public function carrega($id)
    {
    	$sql = "
    		SELECT * 
    		FROM {$this->tabela} 
    		WHERE 
    			{$this->prk} = '{$id}' AND 
    			ativo = 1;
    	";
    	$dados = $this->queryDados($sql);
    	return $dados[0];
    }
    
    //SETS
    	
    //SETS - fim
    
    //GETS
    	
    //GETS - fim
	
}

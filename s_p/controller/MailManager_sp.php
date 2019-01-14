<?php

/**
 * 
 * Classe criada inicialmente para tratar o recebimento de emails e geri-los de
 * forma automática na medida das condições necessárias. 
 * 
 * @author Sávio Resende - lotharthesavior@gmail.com
 *
 */

require_once "helpers/Controller.php";

class MailManager_sp extends Controller
{
	public $storage;
	public $arrayMsgs = array();
	
	public function __construct()
	{
		parent::__construct();
		
		require_once 'Zend/Mail.php';
		
		$this->storage = new Zend_Mail_Storage_Imap(
	    	array(
				'host' => 'pop.vodanet-telecom.com', 
			    'user' => 'com.bh@vodanet-telecom.com',//'user' => 'savio@vodanet-telecom.com', 
			    'password' => 'fAdfg54'//'password' => 'savio' 
			    //'ssl' => 'SSL', 
			    //'port' => 993
			)
	    );
	}
	
	protected function selecionaPasta( $pasta = 'inbox' )
	{
		$this->storage->selectFolder( $pasta );
	}
	
	protected function iteraEmails()
	{
		foreach($this->storage as $mail)
		{
			if ( $mail->hasFlag( Zend_Mail_Storage::FLAG_SEEN ) )
		    	continue;
		    
		    else
		    {
		    	$arrayIteracao = array();
		    	
		    	if( $mail->isMultipart() )
		    		$arrayIteracao['contentType'] = 'text/plain';
		    	else
		    		$arrayIteracao['contentType'] = 'text/html';
		    	
				$arrayIteracao['remetente'] = utf8_encode($mail->from);
				$arrayIteracao['assunto'] = utf8_encode($mail->subject);
				
				if( $mail->isMultipart() )
		        {
			        foreach (new RecursiveIteratorIterator($mail) as $part) 
			        {	
			        	try {
			                if (strtok($part->contentType, ';') == 'text/plain') {
			                    $foundPart = $part;
			                    break;
			                }
			            } catch (Zend_Mail_Exception $e) {
			                // 
			            }
			        }
			        $arrayIteracao['mensagem'] = str_replace("\n", "\n<br />", trim(utf8_encode(quoted_printable_decode(strip_tags($foundPart)))));
		        }
		        else
		        {
		        	if( base64_decode( $mail->getContent() , true ) )
		        		$arrayIteracao['mensagem'] = base64_decode($mail->getContent());
		        	else
		        		$arrayIteracao['mensagem'] = $mail->getContent();
		        }
		        
		        array_push( $this->arrayMsgs , $arrayIteracao );
		        
		        unset($arrayIteracao);
		    }
	    }
	    
	    return $this->arrayMsgs;
	}
}
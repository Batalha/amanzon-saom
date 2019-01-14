<?php
/**
 * Classe MailIncidenteNagios
 * 
 * classe voltada para tratar o email recebido pela 
 * prodemge para criacao de pré-incidente
 */

//TODO: os nomes dos métodos arrumados, fazer suas funcionalidades e testa-las
//TODO: 

require_once 'controller/MailManager.php';
require_once 'controller/PreIncidentes.php';
require_once 'model/PreIncidentesNagiosModel.php';

class MailIncidenteNagios extends MailManager
{
	
	public function __construct()
	{
		parent::__construct();
		
		require_once 'Zend/Mail.php';
		
		$this->storage = new Zend_Mail_Storage_Imap(
	    	array(
				'host' => 'pop.vodanet-telecom.com', 
			    'user' => 'nagios@vodanet-telecom.com',//'user' => 'savio@vodanet-telecom.com', 
			    'password' => 'nagios123'//'password' => 'savio' 
			    //'ssl' => 'SSL', 
			    //'port' => 993
			)
	    );
	}
	
	public function verificaEmails()
	{
		$this->selecionaPasta();
		
		$emails = $this->iteraEmails();
		
		// print_b( $emails ,true);
		
		// TODO: solucionar o tratamento das mensagens
		$listaPreIncidentes = array();
		foreach( $emails as $chave => $email )
		{
			if( $this->validaEmailIncidenteNagios( $email['assunto'] ) )
			{
				$notificationType = $this->limpaNotificationType( $email['mensagem'] );
				$host = $this->limpaHost( $email['mensagem'] );
				$state = $this->limpaState( $email['mensagem'] );
				$address = $this->limpaAddress( $email['mensagem'] );
				$info = $this->limpaInfo( $email['mensagem'] );
				$dateTime = $this->limpaData( $email['mensagem'] );
				
				$arrayIteracao = array(
					'notificationType' => $notificationType,
					'host' => $host,
					'state'  => $state,
					'address' => $address,
					'info' => $info,
					'dateTime' => $dateTime
				);
				array_push( $listaPreIncidentes , $arrayIteracao );
			}
		}
		//print_b($listaPreIncidentes,true);
		
		if( count($listaPreIncidentes) > 0 )
		{
			//verifica pre existencia de um incidente aberto para a designacao
			foreach ( $listaPreIncidentes as $chave => $preIncidente )
				if( 
					$this->Incidentes->buscaIncidenteAbertoParaDesignacao( $preIncidente['host'] ) ||
					$this->PreIncidentesNagios->buscaPreIncidentesSemResponsaveisParaDesignacao( $preIncidente['host'] )
				)
					unset( $listaPreIncidentes[ $chave ] );
					
			if( count($listaPreIncidentes) < 1 )
				continue;
			
			if( $this->inserePreIncidentesNagios( $listaPreIncidentes ) )
				$resposta = array(
					"resposta" => "<span id='informe_resultado'>Pré-Incidente inserido com sucesso.</span>",
					"status" => "ok"
				);
			else
				$resposta = array(
					"resposta" => "<span id='informe_resultado'>Erro ao inserir Pré-Incidente.</span>",
					"status" => "erro"
				);
		}
		else
			$resposta = array(
				"resposta" => "<span id='informe_resultado'>Sem Pré-Incidente a ser inserido.</span>",
				"status" => "erro"
			);
			
		exit($resposta['resposta']);
	}
	
	private function limpaNotificationType( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'Notification Type:' );
		$posicao2 = strpos( $mensagem , 'Host:' );
		$notificationType = substr( $mensagem , $posicao1  + 18 , ($posicao2 - ($posicao1 + 18)) );
		return trim($notificationType);
	}
	
	private function limpaHost( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'Host:' );
		$posicao2 = strpos( $mensagem , 'State:' );
		$host = substr( $mensagem , $posicao1 + 5 , ($posicao2 - ($posicao1 + 5)) );
		return trim($host);
	}
	
	private function limpaState( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'State:' );
		$posicao2 = strpos( $mensagem , 'Address:' );
		$state = substr( $mensagem , $posicao1 + 6 , ($posicao2 - ($posicao1 + 6)) );
		return trim($state);
	}
	
	private function limpaAddress( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'Address:' );
		$posicao2 = strpos( $mensagem , 'Info:' );
		$address = substr( $mensagem , $posicao1 + 8 , ($posicao2 - ($posicao1 + 8)) );
		return trim($address);
	}
	
	private function limpaInfo( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'Info:' );
		$posicao2 = strpos( $mensagem , 'Date/Time:' );
		$info = substr( $mensagem , $posicao1 + 5 , ($posicao2 - ($posicao1 + 5)) );
		return trim($info);
	}
	
	private function limpaData( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'Date/Time:' );
		$data = substr( $mensagem , $posicao1 + 10 );
		return trim($data);
	}
	
	private function validaEmailIncidenteNagios( $assunto )
	{
		if( strpos( $assunto , 'DOWN' ) === false )
			return false;
		else
			return true;
	}
	
	private function inserePreIncidentesNagios( Array $listaPreIncidentesNagios )
	{
		$retorno = true;
		foreach ( $listaPreIncidentesNagios as $chave => $preIncidenteNagios )
		{
			$preIncidenteNagiosObject = new PreIncidentesNagiosModel( $this->adapter->getAdapterZend() );
			$data = array(
				'vsat' => $preIncidenteNagios['host'],
				'endereco' => $preIncidenteNagios['address'],
				'informacoes' => $preIncidenteNagios['info'],
				'data_evento' => date('Y-m-d H:i:s')
			);
			
			if( $preIncidenteNagiosObject->insert( $data ) === false )
				$retorno = false;
		}
		return $retorno;
	}
	
	private function trataData( $data )
	{
		$data = new DateTime( $data );
	}
}
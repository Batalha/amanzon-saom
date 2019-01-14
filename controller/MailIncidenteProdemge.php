<?php

require_once 'controller/MailManager.php';
require_once 'controller/PreIncidentes.php';

class MailIncidenteProdemge extends MailManager
{
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function verificaEmails()
	{
		$this->selecionaPasta();
		$emails = $this->iteraEmails();
		//print_b( $emails ,true);
		
		$listaPreIncidentes = array();
		foreach( $emails as $chave => $email )
		{
			if( $this->validaEmailIncidenteProdemge( $email['assunto'] ) )
			{
				$idProdemge = $this->limpaIdProdemte( $email['assunto'] );
				$designacao = $this->limpaDesignacao( $email['mensagem'] );
				$cliente = $this->limpaCliente( $email['assunto'] );
				$prazoLimite = $this->limpaPrazoLimite( $email['mensagem'] );
				$solicitacao = $this->limpaSolicitacao( $email['mensagem'] );
				$discussao = $this->limpaDiscussao( $email['mensagem'] );
				$dataDataEmail = $this->limpaDataEmail( $solicitacao );
				$identificador = $this->limpaIdentificador( $solicitacao );
				
				$arrayIteracao = array(
					'idProdemge' => $idProdemge,
					'designacao' => $designacao,
					'cliente'  => $cliente,
					'prazoLimite' => $prazoLimite,
					'solicitacao' => $solicitacao,
					'discussao' => $discussao,
					'data_email' => $dataDataEmail,
					'identificador' => $identificador
				);
				array_push( $listaPreIncidentes , $arrayIteracao );
			}
		}
		
		if( count($listaPreIncidentes) > 0 )
		{
			if( $this->inserePreIncidentes( $listaPreIncidentes ) )
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
	
	private function limpaDiscussao( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'DISCUSSÃO' );
		$discussao = substr( $mensagem , ($posicao1+26) );
		$discussaoSeparada = explode( 'Ações do Atendimento' , $discussao );
			$discussaoSeparada[0] = str_replace('<br>', '\r\n', $discussaoSeparada[0]);
			$discussaoSeparada[0] = str_replace('<br/>', '\r\n', $discussaoSeparada[0]);
			$discussaoSeparada[0] = strip_tags($discussaoSeparada[0]);
			$discussao = str_replace('\r\n', '<br/>', $discussaoSeparada[0]);
		return $discussao;
	}
	
	private function limpaSolicitacao( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'SOLICITAÇÃO' );
		$solicitacao = substr( $mensagem , ($posicao1+18) );
		$solicitacaoSeparada = explode( 'DISCUSSÃO' , $solicitacao );
			$solicitacaoSeparada[0] = str_replace('<br>', '\r\n', $solicitacaoSeparada[0]);
			$solicitacaoSeparada[0] = str_replace('<br/>', '\r\n', $solicitacaoSeparada[0]);
			$solicitacaoSeparada[0] = strip_tags($solicitacaoSeparada[0]);
			$solicitacao  = str_replace('\r\n', '<br/>', $solicitacaoSeparada[0]);
		return $solicitacao;
	}
	
	private function limpaIdProdemte( $assunto )
	{
		$posicao1 = strpos( $assunto , '[' );
		$posicao2 = strpos( $assunto , ']' );
		$espaco = $posicao2 - $posicao1;
		$idProdemge = substr( $assunto , ($posicao1+1) , ($espaco-1) );
			
		$idProdemge = explode( '-' , $idProdemge );
		if( count($idProdemge) > 1 )
		{
			$idProdemge = $idProdemge[2];
		}
		else
			$idProdemge = str_replace( '-' , '' , $idProdemge );
		
		return $idProdemge;
	}
	
	private function limpaDesignacao( $mensagem )
	{
		/* obs.: posição incerta, alguns emails vem sem...
		$posicao1 = strpos( $mensagem , 'DESIGNACAO' );
		$designacao = substr( $mensagem , ($posicao1+29) , 13 );
		*/
		$posicao1 = strpos( $mensagem , 'DESIGNAÇÃO' );
		
		$contador = 12;
		while( 
			substr( $mensagem , ($posicao1+$contador) , 1 ) ==  ' ' || 
			substr( $mensagem , ($posicao1+$contador) , 1 ) ==  '	' 
		)
		{
			$designacao = substr( $mensagem , ($posicao1+$contador) , 14 );
			$contador++;
		}
		//exit($designacao);
		
		return $designacao;
	}
	
	private function limpaCliente( $assunto )
	{
		$posicao1 = strpos( $assunto , 'Cliente[' );
		$cliente = substr( $assunto , ($posicao1+8) , 7 );
		return $cliente;
	}
	
	private function limpaPrazoLimite( $mensagem )
	{
		$posicao1 = strpos( $mensagem , 'PRAZO LIMITE' );
		$prazoLimite = substr( $mensagem , ($posicao1+31) , 10 );
		return $prazoLimite;
	}
	
	private function limpaDataEmail( $solicitacao )
	{
		$posicao1 = strpos( $solicitacao , 'Em' );
		$DataEmail = substr( $solicitacao , ($posicao1+3) , 16 );
		$DataEmail = $this->Helpers->data_br_us_com_hora($DataEmail);
		return $DataEmail;
	}
	
	private function limpaIdentificador( $solicitacao )
	{
		$posicao1 = strpos( $solicitacao , 'IDENTIFICADOR' );
		$identificador = substr( $solicitacao , ($posicao1+14) , 18 );
		$identificador = explode(' ',trim($identificador));
		$identificador = $identificador[0];
		return $identificador;
	}
	
	private function validaEmailIncidenteProdemge( $assunto )
	{
		$assuntoCut = substr( $assunto , 0 , 22 );
		if( $assuntoCut == 'Repasse do atendimento' )
			return true;
		else
			return false;
	}
	
	private function inserePreIncidentes( Array $listaPreIncidentes )
	{
		foreach ( $listaPreIncidentes as $chave => $preIncidente )
		{
			$preIncidenteObject = new PreIncidentes();
			$preIncidenteObject->setId_prodemge( $preIncidente['idProdemge'] );
			if( $this->verificaPreExistenciaPreIncidente( $preIncidenteObject ) )
			{
				$retorno = true;continue;
			}
			
			$preIncidente['prazoLimite'] = $this->Helpers->data_br_us($preIncidente['prazoLimite']);
			
			$data = array(
				'id_prodemge' => $preIncidente['idProdemge'],
				'designacao' => $preIncidente['designacao'],
				'id_cliente' => $preIncidente['cliente'],
				'prazo_limite' => $preIncidente['prazoLimite'],
				'solicitacao' => $preIncidente['solicitacao'],
				'discussao' => $preIncidente['discussao'],
				'data_email' => $preIncidente['data_email'],
				'identificador' => $preIncidente['identificador']
			);
			if( $this->PreIncidentes->insert( $data ) ){
				$retorno = true;
			}else{
				$retorno = false;
			}
				
			unset($preIncidenteObject);
		}
		return $retorno;
	}
	
	private function verificaPreExistenciaPreIncidente( PreIncidentes $preIncidente )
	{
		$where  = " id_prodemge = '{$preIncidente->getId_prodemge()}' ";
		$preIncidentesEncontrados =  $this->PreIncidentes->fetchAll( $where );
		if( count($preIncidentesEncontrados) > 0 )
			return true;
		else
			return false;
	}
}
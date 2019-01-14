<?php

require_once "libs/PEAR/Mail/Mail.php";

class Helpers
{
	protected $msg;
	protected $assunto;
	
	protected $email = array();
	private $nomeRemetenteEmail;
	private $senhaCaixaEmail;
	
	/**
	 * ENVIA EMAIL
	 *
	 * metodos dependentes:
	 * 	1.setMsg()
	 * 	2.getMsg()
	 * 	3.setAssunto()
	 * 	4.getAssunto()
	 *
	 * Partes do sistema que dependem desse método:
	 *  1. [controller]Instalacao - [metodo]inicia_comiss
	 *  2. [model]DBCompartilhamento - [metodo]upload
	 */
	public function sendMail($assunto, $to, $msg, $anexo='vazio', $origem='saom@vodanet-telecom.com', $autor='SAOM') {
		//$arrReturn['status'] = 'ok';$arrReturn['msg'] = 'teste';die_json($arrReturn);
		
		$this->trataCaixaEmail( $origem );
		
		$from = "{$this->nomeRemetenteEmail} <{$origem}>";
		$para = '';
		
		switch(AMBIENTE)
		{
			case 'desenvolvimento':
			case 'homologacao':
				$para = "mwergles@vodanet-telecom.com";
				break;
			case 'producao':
				if (is_array($to)) {
					for ($i = 0; $i < count($to); $i++) {
						if ($to[$i]) {
							$para .= $to[$i].',';
						}
					}
					$para = substr($para, 0, -1);
				}else
					if ($to) {
						$para = $to;
					}
				break;
		}
		
		// como fiquei desconfiado do código acima, estou incluíndo isso:
		if (!$para) {
		    $para = 'mwergles@vodanet-telecom.com';
		}
		
		//$arrReturn['status'] = 'ok';$arrReturn['msg'] = $para;die_json($arrReturn);
        		
		$subject = $assunto;
		$body = $msg;

		$host = "mail.vodanet-telecom.com";

		$username = $origem;
		$password = $this->senhaCaixaEmail;
		
		$content_type = "text/html; charset=utf-8";
		$mime_ver = "1.0";
		$agora = date('D, d M Y H:i:s O');

		$headers = array (	
			'From' => $from,
		   	'To' => $para,
		   	'Subject' => $assunto,
			'Content-type' 	=> $content_type,
			'MIME-Version' 	=> $mime_ver,
			'Date' => $agora
		);
		
		$smtp_to = array (
			'To' => $para,
			'Bcc' => 'mwergles@vodanet-telecom.com'
		);
		
		$smtp = Mail::factory(
			'smtp',
			array (
				'host' => $host,
		    	'auth' => true,
		     	'username' => $username,
		     	'password' => $password
			)
		);

		$mail = $smtp->send($smtp_to, $headers, $body);

		if ( PEAR::isError($mail) ){
			//echo("<p>" . $mail->getMessage() . "</p>");
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$msg = "Erro no envio de email em helpers.class.php .  <br/>Emails 'to': {$para}<br/>Usuario e senha:{$origem} - {$this->senhaCaixaEmail}<br/>Erro: ".$mail->getMessage();
			mail( 'mwergles@vodanet-telecom.com' , 'Erro no SAOM - envio do email' , $msg , $headers );
			return false;
		}

		return true;
	}



	function sendMailComiss($assunto, $to, $msg)
	{

		require_once 'libs/phpmailer/class.phpmailer.php';
		require_once 'libs/phpmailer/class.smtp.php';

		$mail = new PHPMailer();
		$mail->setLanguage('pt');

		$from       = 'saom@emcconnected.com';
		$fromName   = '';

//-----Esta enviando com sucesso--------
//$host       = 'mail.vodanet-telecom.com';
//$username   = 'saom@vodanet-telecom.com';
//$password   = '1sat2savio';
//$port       = 587;
//$secure     = 'tls';


//------o $from tem que ser o mesmo do $username------
		$host       = 'smtp.office365.com';
		$username   = 'saom@emcconnected.com';
		$password   = 'Cogu3309';
		$port       = 587;
		$secure     = 'tls';

//        $host       = 'smtp.office365.com';
//        $username   = 'celio.batalha@emc-corp.net';
//        $password   = 'Ce14101979';
//        $port       = 587;
//        $secure     = 'tls';

//-----Esta enviando com sucesso--------
//        $host       = ' smtp.gmail.com';
//        $username   = 'saom.emc@gmail.com';
//        $password   = 'emc123#@!';
//        $port       = 587;
//        $secure     = 'tls';

		$mail->SMTPDebug = '0';
		$mail->isSMTP();
		$mail->Host         = $host;
		$mail->SMTPAuth     = true;
		$mail->Username     = $username;
		$mail->Password     = $password;
		$mail->Port         = $port;
		$mail->SMTPSecure   = $secure;

		$mail->From = $from;
		$mail->FromName = $fromName;
		$mail->addReplyTo($from, $fromName);

		for ($i = 0; $i < count($to); $i++) {
			$mail->addAddress($to[$i], '');
		}

		$mail->isHTML(true);
		$mail->CharSet = 'utf-8';
		$mail->WordWrap = '70';
		$mail->Subject  = $assunto;
		$mail->Body     = $msg;
		$mail->AltBody  = 'Enviando emails com PHPMailer';

		$send = $mail->send();

		if($send)
			return true;
		else
			return false;

		unset($assunt);
	}
	
	private function trataCaixaEmail( $caixa )
	{
		
		switch( $caixa )
		{
			case 'saom@vodanet-telecom.com':
				$this->nomeRemetenteEmail = 'SAOM';
				$this->senhaCaixaEmail = '1sat2savio';
				break;
			case 'noc.sp@vodanet-telecom.com':
				$this->nomeRemetenteEmail = 'SAOM Ativacao';
				$this->senhaCaixaEmail = '1saom2nocsp3';
				break;
			default:
				$this->nomeRemetenteEmail = 'SAOM';
				$this->senhaCaixaEmail = '1sat2savio';
				break;
		}
	}


	/**
	 * Função para procura várias palavras em uma string
	 */
	public function procpalavras ($frase, $palavras, $resultado = 0) {
		foreach ( $palavras as $key => $value ) {
			$pos = strpos($frase, $value);
			if ($pos !== false) {
				$resultado = 1; break;
			}
		}
		return $resultado;
	}
	/*
	 Exemplo 1 - Nenhuma palavra encontrada, retorna zero
	 $frase = "eu tenho uma galinha que se chamava merilu";
	 $palavras = array ("coelho","cavalo","formiga","cachorro","gato");
	 echo "Resultado: " . procpalavras($frase, $palavras) . "<br />";
	 */


	/*
	 * metodo PARA DATAS, CONVERSAO E DESCONVERSAO
	 */
	public function data_br_us($data)
	{
		$data2 = explode('/',$data);
		return $data2[2].'-'.$data2[1].'-'.$data2[0];
	}


	public function data_us_br($data)
	{
		$data2 = explode('-',$data);
		return $data2[2].'/'.$data2[1].'/'.$data2[0];
	}


	public function data_br_us_com_hora($data)
	{
		$data2 = explode(' ',$data);
		$data3 = explode('/',$data2[0]);//data
		return $data3[2].'-'.$data3[1].'-'.$data3[0].' '.$data2[1];
	}

	public function data_us_br_com_hora($data)
	{
		$data2 = explode(' ',$data);
		$data3 = explode('-',$data2[0]);
		return $data3[2].'/'.$data3[1].'/'.$data3[0].' '.$data2[1];
	}

	/*
	 * Fonte: http://testerphp.blogspot.com/2010/06/resume-texto-limita-caractete-sem.html
	 */
	public function limitaTexto($texto, $limite)
	{
		$texto = strip_tags($texto);
		$trecho = substr($texto, 0, $limite);
		if (strlen($trecho) < strlen($texto))
		{
			$trecho = substr($trecho, 0, strrpos($trecho, " ") + 1) . " ...";
		}
		return $trecho;
	}

	function print_b ($array, $exit=false)
	{
		echo '<pre>', print_r($array), '</pre>';
		if($exit){
			exit;
		}
	}

	/*
	 * @author lotharthesavior@gmail.com
	 */
	public function loadAll( $dir )
	{
		$aberto = opendir($dir);

		$i = 0;
		while ($arq = readdir($aberto))
		{
			if ($arq != "." and $arq != "..")
			{
				$arquivo[$i] = $arq;
				$i++;
			}
		}

		for( $i = 0 ; $i < count($arquivo) ; $i++ )
		include $dir.$arquivo[$i];
	}
	
	/*
	 * converte mes em numero para texto
	 */
	public function carregaMesString( $mes )
	{

		switch ( $mes )
		{
			case '01':
				return 'Janeiro';
				break;
			case '02':
				return 'Fevereiro';
				break;
			case '03':
				return 'Março';
				break;
			case '04':
				return 'Abril';
				break;
			case '05':
				return 'Maio';
				break;
			case '06':
				return 'Junho';
				break;
			case '07':
				return 'Julho';
				break;
			case '08':
				return 'Agosto';
				break;
			case '09':
				return 'Setembro';
				break;
			case '10':
				return 'Outubro';
				break;
			case '11':
				return 'Novembro';
				break;
			case '12':
				return 'Dezembro';
				break;
		}
	}
	
	public static function getCumprimento()
    {
    	$agora = date('H');
    	if($agora > 00 && $agora < 12)
    		return "Bom Dia";
    	
    	else if($agora >= 12 && $agora < 18)
    		return "Boa Tarde";
    	
    	else if($agora >= 18)
    		return "Boa Noite";
    }
    
    // (PHP 5 >= 5.2.0)
	public static function resgataPrimeiroEUltimoDiaMesAnterior()
	{
		$data = new DateTime();
		$dataMesAnterior = $data->sub( new DateInterval('P1M') );
		$primeiroDiaMesAnterior = date('Y-m-d',mktime(0, 0, 0, $dataMesAnterior->format('m'), '01', $dataMesAnterior->format('Y')));
		$data = new DateTime(date('Y-m-01'));
		$ultimoDiaMesAnterior = $data->sub( new DateInterval('P1D') )->format('Y-m-d');
		
		return array(
			$primeiroDiaMesAnterior,
			$ultimoDiaMesAnterior	
		);
	}
	
	public static function assinaturaSAOM()
	{
		return "
	    	SAOM<br/>
			Vodanet Telecomunicações Ltda.<br/>
			http://www.vodanet-telecom.com<br/>
			<img src='http://saom.vodanet-telecom.com/public/imagens/logo_vodanet.jpg'>
	    ";
	}
}

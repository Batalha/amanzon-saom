<?php

	/**
	 * @author Bruno Alucinado
	 * funcao que printa variaveis na tela com tag <pre>
	 */

	function print_b ($array, $exit=false)
	{
		echo '<pre>', print_r($array), '</pre>';
		if($exit){
			exit;
		}
	}

    //Contém algumas funções úteis a todo o sistema
    function die_json($value)
    {
        die(json_encode($value));
    }
    
    function sub_espchar($s) 
    {
 		$s = preg_replace("[^a-zA-Z0-9_]", "", strtr($s, "Ã¡Ã Ã£Ã¢Ã©ÃªÃ­Ã³Ã´ÃµÃºÃ¼Ã§Ã�Ã€ÃƒÃ‚Ã‰ÃŠÃ�Ã“Ã”Ã•ÃšÃœÃ‡ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
 		return $s;
    }
    
    function sendMail($assunto,$msg, $to = array())
    {
    	require_once "libs/PEAR/Mail/Mail.php";
    	
        $from = "SAOM <saom@vodanet-telecom.com>";
		$para = "";
		
		switch(AMBIENTE)
		{
            case 'desenvolvimento':
			case 'homologacao':
				$para = "celio.batalha@globaleagle.com";
// 				$para = "mwergles@vodanet-telecom.com";
				break;
			case 'producao':
				if( is_array($to) ){
					for( $i = 0 ; $i < count($to) ; $i++ )
						if( $to[$i] != '' )
							$para .= $to[$i].',';
							
					$para = substr($para, 0, -1);
				}else
					if( $to != '' )
						$para = $to;
				break;
		}
		
		if($assunto=='')//erro 27022012
			reportarErro('Erro SAOM','Email geral SAOM sendo enviado com assunto vazio');
			
		$mensagem = "E-mail gerado automaticamente em ".date('d-m-Y H:i:s').", por favor não responda.<br/>";
        $mensagem .= "Notificação: $msg<br/><br/>";
				
		$subject = $assunto;
		$body = $mensagem;

		$host = "smtp.gmail.com";
		$username = "saom@emc-corp.net";
		$password = "voda@6uaJXQNY2=xK#VE";
		
// 		$host = "mail.vodanet-telecom.com";
// 		$username = "saom@vodanet-telecom.com";
// 		$password = "1sat2savio";
		
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
			'Bcc' => 'cbatalha@emc-corp.net'
// 			'Bcc' => 'savio@vodanet-telecom.com'
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
			$msg = "Erro no envio de email em helpers.php - sendMail .  <br/>Emails 'to': {$para}<br/>Erro: ".$mail->getMessage();
			mail( 'cbatalha@emc-corp.net' , 'Erro no SAOM - envio do email' , $msg , $headers );
			return false;
		}else
			return true;
    }
    
    function sendMailIncidente($assunto, $to, $msg)
    {

        require_once 'libs/phpmailer/class.phpmailer.php';
        require_once 'libs/phpmailer/class.smtp.php';

        $mail = new PHPMailer();
        $mail->setLanguage('pt');


        $from       = 'saom@globaleagle.com';
        $fromName   = '';

//-----Esta enviando com sucesso--------
//		$host       = 'smtp.office365.com';
//		$username   = 'saom@globaleagle.com';
//		$password   = '';
//		$port       = 587;
//		$secure     = 'tls';

		//-----Esta enviando com sucesso--------
        $host       = 'smtp.gmail.com';
        $username   = 'saom.emc@gmail.com';
        $password   = 'emc123#@!';
        $port       = 587;
        $secure     = 'tls';

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

function sendMailAberturaIncidente($assunto, $to, $msg)
{

	require_once 'libs/phpmailer/class.phpmailer.php';
	require_once 'libs/phpmailer/class.smtp.php';

	$mail = new PHPMailer();
	$mail->setLanguage('pt');

	$from       = 'saom@globaleagle.com';
	$fromName   =  '';


//	$host       = 'smtp.office365.com';
//	$username   = 'saom@globaleagle.com';
//	$password   = '';
//	$port       = 587;
//	$secure     = 'tls';

	//-----Esta enviando com sucesso--------
	$host       = 'smtp.gmail.com';
	$username   = 'saom.emc@gmail.com';
	$password   = 'emc123#@!';
	$port       = 587;
	$secure     = 'tls';

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
}

function sendMailConfirmacaoIncidente($assunto, $to, $msg)
{

	require_once 'libs/phpmailer/class.phpmailer.php';
	require_once 'libs/phpmailer/class.smtp.php';

	$mail = new PHPMailer();
	$mail->setLanguage('pt');

	$from       = 'saom@globaleagle.com';
	$fromName   = '';

//------o $from tem que ser o mesmo do $username------
//	$host       = 'smtp.office365.com';
//	$username   = 'saom@globaleagle.com';
//	$password   = '';
//	$port       = 587;
//	$secure     = 'tls';

	//-----Esta enviando com sucesso--------
	$host       = 'smtp.gmail.com';
	$username   = 'saom.emc@gmail.com';
	$password   = 'emc123#@!';
	$port       = 587;
	$secure     = 'tls';

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
}


function sendAtivacaoUpdate($assunto, $to, $msg)
{

	require_once 'libs/phpmailer/class.phpmailer.php';
	require_once 'libs/phpmailer/class.smtp.php';

	$mail = new PHPMailer();
	$mail->setLanguage('pt');

	$from       = 'saom@globaleagle.com';
	$fromName   = '';

//------o $from tem que ser o mesmo do $username------
//	$host       = 'smtp.office365.com';
//	$username   = 'saom@globaleagle.com';
//	$password   = '';
//	$port       = 587;
//	$secure     = 'tls';

	//-----Esta enviando com sucesso--------
	$host       = 'smtp.gmail.com';
	$username   = 'saom.emc@gmail.com';
	$password   = 'emc123#@!';
	$port       = 587;
	$secure     = 'tls';

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
}

function sendMailComissionamento($assunto, $to, $msg)
{

	require_once 'libs/phpmailer/class.phpmailer.php';
	require_once 'libs/phpmailer/class.smtp.php';

	$mail = new PHPMailer();
	$mail->setLanguage('pt');

	$from       = 'saom@globaleagle.com';
	$fromName   = '';

//------o $from tem que ser o mesmo do $username------
//	$host       = 'smtp.office365.com';
//	$username   = 'saom@globaleagle.com';
//	$password   = '';
//	$port       = 587;
//	$secure     = 'tls';

	//-----Esta enviando com sucesso--------
	$host       = 'smtp.gmail.com';
	$username   = 'saom.emc@gmail.com';
	$password   = 'emc123#@!';
	$port       = 587;
	$secure     = 'tls';

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
}


    /*
     * Função que tira acentos
     * 
     * fonte: http://marcusmonteiro.com/desenvolvimento/php-retirar-acentos-de-strings.php
     */
    function normaliza($string)
    {
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
		$string = str_replace(" ","",$string); // retira espaco
		$string = strtolower($string); // passa tudo para minusculo
		return utf8_encode($string); //finaliza, gerando uma saída para a funcao
	}
?>

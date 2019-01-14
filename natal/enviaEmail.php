<?php
// destinatário
$to  = 'lotharthesavior@gmail.com';

// assunto
$subject = 'Feliz Natal';

// mensagem
$message = <<<EOF
<html>
<head>
 <title>Feliz Natal</title>
</head>
<body>
<div style="position:relative;margin:0 auto;">
	<img src="http://www.vodanet-telecom.com/SAOM_PRODEMGE/natal/natal2.jpg" />
</div>
</body>
</html>
EOF;

// HTML mail
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// cabeçalhos
$headers .= 'To: Sávio <lotharthesavior@gmail.com>' . "\r\n";
/*
$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
*/

// envia
mail($to, $subject, $message, $headers);
echo 'Fim';
?>
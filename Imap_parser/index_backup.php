<?php

// include Imap_parser class
include_once('lib/Imap_parser.php');

// create Imap_parser Object
$email = new Imap_parser();

// data
$data = array(
	// email account
	'email' => array(
		'hostname' => '{outlook.office365.com/pop/tls}INBOX',
		'username' => 'saom@globaleagle.com',
		'password' => 'Extra_4_Duty'
	),
//	'email' => array(
//		'hostname' => '{outlook.office365.com/imap/tls}INBOX',
//		'username' => 'celio.batalha@globaleagle.com',
//		'password' => 'C1410e1979'
//	),
	// inbox pagination
	'pagination' => array(
		'sort' => 'DESC', // or ASC
		'limit' => 5,
		'offset' => 0
	)
);

// get inbox. Array
$result = $email->inbox($data);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

//$file = fopen('store.txt','a');
//fwrite($file, $result['status']. "\r\n");
//fclose($file);
//echo json_encode($result['inbox'], JSON_PRETTY_PRINT);


$arrayIteracao = array();

for($i=0; $i < count($result); $i++){
	$remetente = str_replace("\n", "\n<br />", trim(html_entity_decode(quoted_printable_decode(strip_tags($result['inbox'][$i]['from'])))));
	if($remetente == "Service Desk Prodemge"){
		$arrayIteracao[$i]['assunto'] = $result['inbox'][$i]['subject'];
		$arrayIteracao[$i]['from'] = $result['inbox'][$i]['from'];
		$arrayIteracao[$i]['email'] = $result['inbox'][$i]['email'];
		$arrayIteracao[$i]['message'] = str_replace("\n", "\n<br />", trim(html_entity_decode(quoted_printable_decode(strip_tags($result['inbox'][$i]['message'])))));

	}
}
	print_r($arrayIteracao);




<?php

// include Imap_parser class

// create Imap_parser Object
include_once('./lib/Imap_parser.php');

class ImapManager
{
	public $email;
	public $data;


	public function __construct()
	{
		$this->email = new Imap_parser();

		// data
		$this->data = array(
			// email account
			'email' => array(
				'hostname' => '{outlook.office365.com/pop/tls}INBOX',
				'username' => 'saom@globaleagle.com',
				'password' => '6uaJXQNY2=xK#VE'
			),
			'pagination' => array(
				'sort' => 'DESC', // or ASC
				'limit' => 5,
				'offset' => 0
			)
		);

	}

	protected function iteraEmails()
	{
		
		// get inbox. Array
		$result = $this->email->inbox($this->data);

		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		//$file = fopen('store.txt','a');
		//fwrite($file, $result['status']. "\r\n");
		//fclose($file);
		//echo json_encode($result['inbox'], JSON_PRETTY_PRINT);

		$arrayIteracao = array();

		for ($i = 0; $i < count($result); $i++) {
			$remetente = str_replace("\n", "\n<br />", trim(html_entity_decode(quoted_printable_decode(strip_tags($result['inbox'][$i]['from'])))));
			if ($remetente == "Service Desk Prodemge") {
				$arrayIteracao[$i]['assunto'] = utf8_encode($result['inbox'][$i]['subject']);
				$arrayIteracao[$i]['from'] = $result['inbox'][$i]['from'];
				$arrayIteracao[$i]['email'] = $result['inbox'][$i]['email'];
				$arrayIteracao[$i]['message'] = str_replace("\n", "\n<br />", trim(html_entity_decode(quoted_printable_decode(strip_tags($result['inbox'][$i]['message'])))));

			}
		}

		return $arrayIteracao;

	}
}





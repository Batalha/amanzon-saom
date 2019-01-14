<?php

class Unificado extends Controller
{
	protected $tplDir = 'unificado';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function loginCentral()
	{

		$prodemge = BASE_PATH."/PRODEMGE";
		$mensagemLog = (isset($_SESSION['mensagemLog']))?$_SESSION['mensagemLog']:'';
		unset($_SESSION['mensagemLog']);
		
		$this->smarty->assign('mensagemLog',$mensagemLog);
		$this->smarty->assign('prodemge',$prodemge);
		$this->smarty->display("{$this->tplDir}/login_central.tpl");
	}
	
	public function listaSistemas()
	{
		$sp = BASE_PATH."/SP";
		$prodemge = BASE_PATH."/PRODEMGE";
		
		$this->smarty->assign('sp',$sp);
		$this->smarty->assign('prodemge',$prodemge);
		$this->smarty->display("{$this->tplDir}/lista_sistemas.tpl"); 
	}
}

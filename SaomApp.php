<?php

/*
 * Classe SaomApp
 * 
 * @author: Sávio Resende - lotharthesavior@gmail.com
 * 
 * Classe criada para iniciar uma aplicação SAOM sem previsar que ela seja iniciada
 * pelo acesso via browser, focada em fazer funcionar um método de dentro da aplicação
 * via Cron.
 */

require_once 'applicationSaomApp.php';

class SaomApp
{
	public $app;
	
	public function __construct( $uri )
	{
// 	    print_r($_SESSION['SAOM']);
        if (!defined('AMBIENTE')) {
            require_once 'configs.php';
        }

		require_once 'model/AdapterZend.php';
		require_once 'Zend/Loader/Autoloader.php';
		require_once 'Zend/Db.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
		
		$this->app = new Application( $uri );
	}
	
	public function executaComandoPrazos()
	{
		$informaPrazos = $this->app->loadController( 'InformaPrazos' );
	}
	
	public function executaComandoEmailIncidentesProdemgeParaComBh()
	{
		$verificaEmailsComBh = $this->app->loadController( 'MailIncidenteProdemge' );
	}
	
	public function executaComandoEmailIncidentesNagiosParaNagios()
	{
		$verificaEmailsNagios = $this->app->loadController( 'MailIncidenteNagios' );
	}
	
	public function executaComandoAtualizaCacheIncidentes( $page )
	{
		$_GET['teste'] = 1;
		$_POST['page'] = $page;
		$atualizaCacheIncidentes = $this->app->loadController( 'Incidente' );
	}
}
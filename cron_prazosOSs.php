<?php 
$root = realpath(dirname(__FILE__));
set_include_path(get_include_path() . PATH_SEPARATOR . $root);

/*
 * Programa para executar atividades Cron
 * 
 * @author Sávio Resende - lotharthesavior@gmail.com
 * 
 * O objetivo desse programa é executar ações no Cron do servidor.
 * 
 */

require 'SaomApp.php';

$acao = array( 
	'controller' => 'InformaPrazos' , 
	'method' => 'passa_buscas' , 
	'var' => 'prazosOS' 
);

$prazoOS = new SaomApp( $acao );
$prazoOS->executaComandoPrazos();
ini_set('display_errors', false);

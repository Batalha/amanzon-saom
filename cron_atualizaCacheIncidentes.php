<?php
error_reporting(E_ALL & ~E_STRICT);
$root = realpath(dirname(__FILE__));
set_include_path(get_include_path() . PATH_SEPARATOR . $root);

/*
 * Programa para executar atividades Cron
 * 
 * @author Sávio Resende - lotharthesavior@gmail.com
 * 
 * O objetivo desse programa é executar ações no Cron do servidor para atualizar Cache dos incidentes.
 * 
 * o Cache se baseia nas ultimas 3 paginas
 * 
 */

require 'SaomApp.php';

$acao = array( 
	'controller' => 'Incidente' , 
	'method' => 'listeFonte' ,
	'var' => '' 
);
$prazoInstalacoes = new SaomApp( $acao );
$prazoInstalacoes->executaComandoAtualizaCacheIncidentes(1);

$acao = array( 
	'controller' => 'Incidente' , 
	'method' => 'listeFonte' ,
	'var' => '' 
);
$prazoInstalacoes = new SaomApp( $acao );
$prazoInstalacoes->executaComandoAtualizaCacheIncidentes(2);

$acao = array( 
	'controller' => 'Incidente' , 
	'method' => 'listeFonte' ,
	'var' => '' 
);
$prazoInstalacoes = new SaomApp( $acao );
$prazoInstalacoes->executaComandoAtualizaCacheIncidentes(3);

<?php
//$root = realpath(dirname(__FILE__));
//set_include_path(get_include_path() . PATH_SEPARATOR . $root);
//
///*
// * Programa para executar atividades Cron
// *
// * @author Sávio Resende - lotharthesavior@gmail.com
// *
// * O objetivo desse programa é executar ações no Cron do servidor.
// *
// */

require_once 'MailIncidente.php';
//
$emailIncidentes = new MailIncidente();
//
$emailIncidentes->verificaEmails();

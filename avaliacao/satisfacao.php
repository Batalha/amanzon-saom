<?php
/**
 * Created by PhpStorm.
 * User: celio
 * Date: 01/09/2017
 * Time: 10:29
 */
require_once('../libs/Smarty.class.php');
require_once ('Conexao.php');
$DBCon = new Conexao();
$smarte = new Smarty();
$atend = $_POST['idatend'];
$coment = $_POST['comentarios'];


$sql = "UPDATE satisfacao SET
        pgt_1     = {$_POST['pgt_1']},
        pgt_2     = {$_POST['pgt_2']},
        pgt_3     = {$_POST['pgt_3']},
        pgt_4     = {$_POST['pgt_4']},
        pgt_5     = {$_POST['pgt_5']},
        pgt_6     = {$_POST['pgt_6']},
        pgt_7     = {$_POST['pgt_7']},
        pgt_8     = {$_POST['pgt_8']},
        pgt_9     = {$_POST['pgt_9']},
        comentario = '$coment',
        url = NULL WHERE idatend = $atend";

var_dump($sql);
$DBCon->conexao($sql);
$resultado = true;

$smarte->assign('obg', $resultado);
$smarte->display('atendimento/expirado.tpl');


<?php
/**
 * Created by PhpStorm.
 * User: celio
 * Date: 14/06/2018
 * Time: 11:21
 */

include ('nusoap/lib/nusoap.php');

$uri = "http://saom.com/webserver/server.php";

$cliente = new nusoap_client($uri);

$nome = $_POST['nome'];
$idade = $_POST['idade'];

$parametro = array();
$parametro['nome'] = $nome;
$parametro['idade'] = $idade;

$resultado = $cliente->call('cadastro', $parametro);

echo utf8_encode($resultado);

?>
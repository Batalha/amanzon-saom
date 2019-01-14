<?php
/**
 * Created by PhpStorm.
 * User: celio
 * Date: 14/06/2018
 * Time: 11:04
 */
date_default_timezone_set('America/Sao_Paulo');
include('./nusoap/lib/nusoap.php');
require_once('ConexaoSoap.php');


$server = new nusoap_server();

$server->configureWSDL('Servidor');
$server->wsdl->schema = 'urn:Servidor';


function cadastrarTicket($descricao, $prioridade, $nome_instalacao, $solicitacao_idsolicitacao, $tipo_incidente_idtipo)
{

    $DBSoap = new ConexaoSoap();
    $sql = "
        SELECT idinstalacoes_sp
        FROM instalacoes_sp
        WHERE nome = '{$nome_instalacao}';
    ";
    $idinstalacao = $DBSoap->conexao($sql);

    if(!$idinstalacao['idinstalacoes_sp']){
        return '<div style="margin: 25% 45%; width: 20%; font-size: 24px; color: #ff0000; font-weight: bold">Vsat nao Encontrada!</div>';
    }

    $criaAtend = cadastrarAtendimento($descricao, $idinstalacao, $solicitacao_idsolicitacao, $tipo_incidente_idtipo);

    $data = date('Y-m-d');
    $data_modificacao = date('Y-m-d H:i:s');
    $saom = 2;
    $tecnicoNoc = 67;

    $sql = "INSERT INTO
                incidentes_sp (
                        `data`, descricao, prioridade, instalacoes_idinstalacoes,
                        solicitacao_idsolicitacao, tipo_incidente_idtipo,
                        tecnicoNoc, saom, data_modificacao
                ) VALUES (
                        '{$data}','{$descricao}','{$prioridade}','{$idinstalacao['idinstalacoes_sp']}','{$solicitacao_idsolicitacao}',
                        '{$tipo_incidente_idtipo}','{$tecnicoNoc}','{$saom}','{$data_modificacao}'
                )

            ";


    $idincidente = $DBSoap->conexao($sql);

    $sql = "
            UPDATE atend_vsat_sp
            SET incidentes_sp_idincidentes = '{$idincidente}'
            WHERE idatend_vsat = '{$criaAtend}'
        ";
    $DBSoap->conexao($sql);

    $sql = "
        INSERT INTO associacao_instalacao_incidente_sp ( idinstalacoes_sp , idincidentes )
        VALUES ( '{$idinstalacao['idinstalacoes_sp']}' , '{$idincidente}')
    ";
    if ($DBSoap->conexao($sql)) {
        return '<div style="margin: 20% 40%; width: 20%;">
                    <label style="font-size: 24px; color: #006288; font-weight: bold">Numero do Ticket: </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="" style="font-size: 35px; font-weight: bold">' .$idincidente.'</label>
                </div>';
    }
    $DBSoap->close();

}

function cadastrarAtendimento($descricao, $idinstalacao, $solicitacao_idsolicitacao, $tipo_incidente_idtipo)
{
    $DBSoap = new ConexaoSoap();

    $form = array();
    $form['data'] = date("Y-m-d H:i:s");
    $form['mensagem'] = 'Atendimento iniciado por ' . 'Celio Filho' . " as " . date("H:i") . " de " . date("d/m/Y");


    $novadescricao = str_replace('/\n/', ' ', $descricao);

    $form['atendimento'] = '<div class="atendmensagem">' .
        '<table border="1" width="100%">' .
        '<tr id="tr1">' .
        '<td id="td1" align="center" valign="top">' .
        '<div id="atenddados">' .
        '<b>' . 'Celio Filho' . '</b></br>' .
        '<p>' . ' ' . '</p></br></br>' .
        '</div>' .
        '</td>' .
        '<td valign="top" style="height: auto;">' .
        '<div id="envioEmail"></div>' .
        '<div id="arquivos1"></div>' .
        '<div id="dadosmensagem">' . $novadescricao . '\n</div>' .
        '</td>' .
        '</tr>' .
        '<tr>' .
        '<td id="td1" height="30px"></td><td></td>' .
        '</tr>' .
        '<div id="publicado">&nbsp;&nbsp;Publicado em: ' . date('d/m/Y H:i:s') . '</div>' .
        '</table>' .
        '</div></br>';

    $form['privado'] = $form['atendimento'];
//
    $form['status_atend_idstatus_atend'] = 1;
    $form['instalacoes_sp_idinstalacoes_sp'] = $idinstalacao['idinstalacoes_sp'];
    $form['tipo_atendimento_idtipo_atendimento'] = 1;//default
    $form['saom'] = 2;

    $form['usuarios_idusuarios'] = 67;
    $form['solicitacao_sp_idsolicitacao'] = $solicitacao_idsolicitacao;
    $form['tipo_incidente_sp_idtipo'] = $tipo_incidente_idtipo;


    $sql = "INSERT INTO atend_vsat_sp(
                  `data`, atendimento, privado, status_atend_idstatus_atend,
                   instalacoes_sp_idinstalacoes_sp, solicitacao_sp_idsolicitacao,
                   tipo_incidente_sp_idtipo, usuarios_idusuarios,
                   tipo_atendimento_idtipo_atendimento,
                   saom, mensagem
                )
                VALUES(
                  '{$form['data']}','{$form['atendimento']}','{$form['privado']}','{$form['status_atend_idstatus_atend']}',
                  '{$form['instalacoes_sp_idinstalacoes_sp']}','{$form['solicitacao_sp_idsolicitacao']}',
                  '{$form['tipo_incidente_sp_idtipo']}','{$form['usuarios_idusuarios']}',
                  '{$form['tipo_atendimento_idtipo_atendimento']}','{$form['saom']}','{$form['mensagem']}'
                )";

    $criaAtend = $DBSoap->conexao($sql);

    $ordem = "cliente";
    $sql = "
        INSERT INTO cronometro_sp (idreferencia, inicio_tarefa, data_inicio, ordem, tabelareferencia)
        VALUES ('{$criaAtend}', '" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "','{$ordem}','atend_vsat_sp')
    ";
    $DBSoap->conexao($sql);

    return $criaAtend;

}

//

$server->register(

    'cadastrarTicket',
    array(
        'descricao' => 'xsd:string',
        'prioridade' => 'xsd:string',
        'nome_instalacao' => 'xsd:int',
        'solicitacao_idsolicitacao' => 'xsd:int',
        'tipo_incidente_idtipo' => 'xsd:int',
        'tecnicoNoc' => 'xsd:string',
    ),
    array('retorno' => 'xsd:string'),
    'urn:Servidor.cadastrarTicket',
    '',
    'rpc',
    'encoded',
    'Criacao de Ticket'
);


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA)


?>

<?php


date_default_timezone_set('America/Sao_Paulo');
    require_once('../libs/Smarty.class.php');
    require_once ('Conexao.php');


    $DBCon = new Conexao();
    $smarte = new Smarty();

    $idatend = $_GET['idatend'];
    $url = $_SERVER['REQUEST_URI'];

    $sql = "SELECT * FROM satisfacao WHERE idatend = $idatend";
    $dados = $DBCon->conexao($sql);

    $sql = "SELECT * FROM atend_vsat_sp WHERE idatend_vsat = $idatend";
    $dadosInc = $DBCon->conexao($sql);

    $sql = "SELECT idsolicitacao, nomeSolicitacao FROM solicitacao_sp WHERE idsolicitacao =".$dadosInc['solicitacao_sp_idsolicitacao'];
    $dadosSolicit = $DBCon->conexao($sql);

    if($dadosSolicit['idsolicitacao'] == 7){
        $sql = "SELECT nomeTipo FROM tipo_incidente_sp WHERE idtipo =".$dadosInc['tipo_incidente_sp_idtipo'];
        $dadosTipoInc = $DBCon->conexao($sql);
    }

    mysqli_close($con);

    $dia = explode('-',$dados['tempo']);
    $dia = $dia[2];
    $dia = ($dia == '30' || $dia == '31')?2:$dia+2;
    $diAtual = date(d)+0;


    $smarte->assign('idatend', $dados['idatend']);
    $smarte->assign('numberInc', $dadosInc['incidentes_sp_idincidentes']);
    $smarte->assign('nomeSolicitacao', $dadosSolicit['nomeSolicitacao']);
    $smarte->assign('nomeTipo', $dadosTipoInc['nomeTipo']);
    $smarte->assign('url', $dados['url']);
    $smarte->display('atendimento/new.tpl');
//    if($diAtual < $dia){
//    }else{
//        $smarte->display('atendimento/expirado.tpl');
//    }


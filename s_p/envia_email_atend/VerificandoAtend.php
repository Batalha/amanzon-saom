<?php
require_once('ConexaoAtend.php');
date_default_timezone_set('America/Sao_Paulo');

class VerificandoAtend
{

    public function atendimentoFeito()
    {

        $DBCon = new ConexaoAtend();

        $data_envio = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM cronometro_sp";
        $cronometros = $DBCon->queryDados($sql);

        foreach ($cronometros as $cha => $cron) {
            $dadosCron[$cha] = $cron;

            $sql = "SELECT instalacoes_sp_idinstalacoes_sp, incidentes_sp_idincidentes
                    FROM atend_vsat_sp
                    WHERE idatend_vsat = {$dadosCron[$cha]['idreferencia']}
                    ";
            $dadosCron[$cha]['dados_atend_vsat'] = $DBCon->queryDados($sql);


            $sql = "SELECT nome
                    FROM instalacoes_sp
                    WHERE idinstalacoes_sp = {$dadosCron[$cha]['dados_atend_vsat'][0]['instalacoes_sp_idinstalacoes_sp']}
                    ";


            $dadosCron[$cha]['dados_install'] = $DBCon->queryDados($sql);


            $sql = "SELECT idatend_resp, idatend_vsat, nome_usuario, data_time, mensagem, resposta, tempo
                    FROM atend_resposta_sp
                    WHERE idatend_vsat = {$dadosCron[$cha]['idreferencia']}
                    ";
            $dadosCron[$cha]['respostas'] = $DBCon->queryDados($sql);

            if (!$dadosCron[$cha]['final_tarefa']) {

                foreach ($dadosCron[$cha]['respostas'] as $ch => $resp) {
                    $dadosResp[$ch] = $resp;

                    // envio = 0 : o cliente XXX01 abriu o ticket sem respota a uma horas enviar email para o noc
                    // envio = 1 : o cliente XXX01 esta esperando respostas a mais de 2 horas envia email
                    //verifica se exite um envio na tabela
//                    if ($dadosResp[$ch]['envio'] == 0) {
                    if($dadosResp[$ch]['resposta'] == 'n'){
                        $sql = "SELECT idatend_envio FROM atend_vsat_envio_sp
                                    WHERE idatend_resposta = {$dadosResp[$ch]['idatend_resp']}";
                        $idatend_resp = $DBCon->queryRow($sql);


                        if (!$idatend_resp) {

                            $sql = "INSERT INTO atend_vsat_envio_sp (idatend_resposta, numero_ticket, nome_vsat, nome_usuario, descricao, data_abertura, data_envio, tempo)
                                        VALUES (
                                        '{$dadosResp[$ch]['idatend_resp']}',
                                        '{$dadosCron[$cha]['dados_atend_vsat'][0]['incidentes_sp_idincidentes']}',
                                        '{$dadosCron[$cha]['dados_install'][0]['nome']}',
                                        '{$dadosResp[$ch]['nome_usuario']}',
                                        '{$dadosResp[$ch]['mensagem']}',
                                        '{$dadosResp[$ch]['data_time']}',
                                        '$data_envio',
                                        '{$dadosResp[$ch]['tempo']}'
                                        )
                                        ";
                            $DBCon->queryDados($sql);

                        }

                    }
                }
            }
        }
        $sql = "SELECT * FROM atend_vsat_envio_sp";
        $atualizaDataEnvio = $DBCon->queryDados($sql);

        $time = explode(" ", $atualizaDataEnvio[0]['data_envio']);
        $resutado = date('H:i', strtotime('+60 minute', strtotime($time[1])));

        if ($resutado == date('H:i')) {

            $sql = "UPDATE atend_vsat_envio_sp SET data_envio = '$data_envio'";
            $DBCon->queryDados($sql);

            $to = ['noc.sp@globaleagle.com','celio.batalha@globaleagle.com'];
            $assunto = 'Cliente em espera';
            $tr = "";
            $tr1 = "";
            foreach($atualizaDataEnvio as $chave=>$envio){
                $dadosEnvio[$chave] = $envio;

                $data_inicial = $dadosEnvio[$chave]['data_abertura'];
                $data_final = $dadosEnvio[$chave]['data_envio'];

                $dataHora = date("d/m/Y H:i",strtotime($data_inicial));

                //Calcula o tempo de espera
                $date_time  = new DateTime($data_inicial);
                $diff       = $date_time->diff( new DateTime($data_final));
                $espera = $diff->format('%d dia(s), %H:%i');

                $esperaHora = $diff->format('%d %H:%i');

                if($esperaHora > '0 00:30' && $dadosEnvio[$chave]['tempo'] == 1){
                    $tr .= "<tr>".
                                "<td align='center'>".$dadosEnvio[$chave]['numero_ticket']."</td>".
                                "<td align='center'>".$dataHora."</td>".
                                "<td align='center'>".$dadosEnvio[$chave]['nome_vsat']."</td>".
                                "<td align='center'>".$dadosEnvio[$chave]['nome_usuario']."</td>".
                                "<td align='center'>".mb_strimwidth($dadosEnvio[$chave]['descricao'], 0, 60, "...")."</td>".
                                "<td align='center'>".$espera."</td>".
                            "</tr>";
                }elseif ($esperaHora > '0 03:30' && $dadosEnvio[$chave]['tempo'] == 2){
                    $tr1 .= "<tr>".
                                "<td align='center'>".$dadosEnvio[$chave]['numero_ticket']."</td>".
                                "<td align='center'>".$dataHora."</td>".
                                "<td align='center'>".$dadosEnvio[$chave]['nome_vsat']."</td>".
                                "<td align='center'>".$dadosEnvio[$chave]['nome_usuario']."</td>".
                                "<td align='center'>".mb_strimwidth($dadosEnvio[$chave]['descricao'], 0, 60, "...")."</td>".
                                "<td align='center'>".$espera."</td>".
                        "</tr>";
                }

            }
            $msg = "<b style='font-size: 18px'>Os seguintes atendimento estão mais de 30 minutos sem respostas</b> <br><br>
                    <table width='100%' border='1' cellpadding='1' cellspacing='0' style='font-size: 12px'>
                        <tr bgcolor='#a9a9a9'>
                            <th width='5%'>Ticket</th>
                            <th width='14%'>Data/Hora</th>
                            <th width='12%'>Cliente</th>
                            <th width='12%'>Usuario</th>
                            <th>Descricao</th>
                            <th width='12%'>Tempo de espera</th>
                        </tr>".
                        $tr.
                    "</table>".
                    "<br>" .
                    "<br>";

            $msg .= "<b style='font-size: 18px'>Os seguintes atendimento estão mais de 3:30 horas sem respostas</b> <br><br>
                <table width='100%' border='1' cellpadding='1' cellspacing='0' style='font-size: 12px'>
                    <tr bgcolor='#a9a9a9'>
                        <th width='5%'>Ticket</th>
                        <th width='12%'>Data/Hora</th>
                        <th width='15%'>Cliente</th>
                        <th width='12%'>Usuario</th>
                        <th>Descricao</th>
                        <th width='12%'>Tempo de espera</th>
                    </tr>".
                $tr1.
                "</table>".
                    "<br>" .
                    "<br>" .
                    "<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='300'/>";

            $this->atendimentoEmAtraso($assunto, $to, $msg);            

        }
    }


    public function atendimentoEmAtraso($assunto, $to, $msg)
    {


            require_once './../../libs/phpmailer/class.phpmailer.php';
            require_once './../../libs/phpmailer/class.smtp.php';

            $mail = new PHPMailer();
            $mail->setLanguage('pt');

            $from       = 'saom@globaleagle.com';
            $fromName   = '';

//------o $from tem que ser o mesmo do $username------
            //$host       = 'smtp.office365.com';
            //$username   = 'saom@globaleagle.com';
            //$password   = '6uaJXQNY2=xK#VE';
            //$port       = 587;
            //$secure     = 'tls';

            $host       = 'smtp.gmail.com';
            $username   = 'saom.emc@gmail.com';
            $password   = 'emc123#@!';
            $port       = 587;
            $secure     = 'tls';

//            $host       = 'smtp.gmail.com';
//            $username   = 'celio.batalha@gmail.com';
//            $password   = 'Ce14101979';
//            $port       = 587;
//            $secure     = 'tls';

            $mail->SMTPDebug = '0';
            $mail->isSMTP();
            $mail->Host         = $host;
            $mail->SMTPAuth     = true;
            $mail->Username     = $username;
            $mail->Password     = $password;
            $mail->Port         = $port;
            $mail->SMTPSecure   = $secure;

            $mail->From = $from;
            $mail->FromName = $fromName;
            $mail->addReplyTo($from, $fromName);

            for ($i = 0; $i < count($to); $i++) {
                $mail->addAddress($to[$i], '');
            }

            $mail->isHTML(true);
            $mail->CharSet = 'utf-8';
            $mail->WordWrap = '70';
            $mail->Subject  = $assunto;
            $mail->Body     = $msg;
            $mail->AltBody  = 'Enviando emails com PHPMailer';

            $send = $mail->send();

            if($send)
                return true;
            else
                return false;
    }

}

<?php

require_once 'ImapManager.php';
require_once('ConexaoImap.php');

class MailIncidente extends ImapManager
{

    public function __construct()
    {
        parent::__construct();
    }

    public function verificaEmails()
    {
        $emails = $this->iteraEmails();

        $listaPreIncidentes = array();
        foreach ($emails as $chave => $email) {
            if ($this->validaEmailIncidenteProdemge($email['assunto'])) {

                $idProdemge = $this->limpaIdProdemge($email['assunto']);
                $descricao = $this->limpaSolicitacao($email['message']);

                $DataEmail = $this->limpaDataEmail($email['message']);
                $prioridade = $this->limpaPrioridade($email['message']);
                $idinstalacoes = $this->limpaDesignacao($email['message']);
                $dataTime = $this->limpaDataTime($email['message']);
                $tecnicoResp = $this->limpaTecResp($email['message']);

                $arrayIteracao = array(
                    'idProdemge' => $idProdemge,
                    'descricao' => $descricao,
                    'data_email' => $DataEmail,
                    'idinstalacoes' => $idinstalacoes,
                    'prioridade' => $prioridade,
                    'dataTime' => $dataTime,
                    'tecResponsavel' => $tecnicoResp,
                );
                array_push($listaPreIncidentes, $arrayIteracao);
            }
        }

        if (count($listaPreIncidentes) > 0) {
            $this->inserePreIncidentes($listaPreIncidentes);
        }
//        print_r($listaPreIncidentes);exit();
    }

    //-------------------Formato para Incidente------------------

    private function limpaIdProdemge($assunto)
    {
        $idProdemge = explode(' ', $assunto);
        return $idProdemge[1];
    }

    private function limpaSolicitacao($mensagem)
    {
        $posicao1 = strpos($mensagem, 'DISPOSITIVO');
        $descricao = substr($mensagem, ($posicao1), 407);

        return $descricao;
    }

    private function limpaDataEmail($mensagem)
    {
        $posicao1 = strpos($mensagem, 'abertura');
        $DataEmail = substr($mensagem, ($posicao1 + 10), 10);
        $DataEmail = explode('/', $DataEmail);
        $DataEmail = $DataEmail[2] . '-' . $DataEmail[1] . '-' . $DataEmail[0];
        return $DataEmail;
    }


    private function limpaDesignacao($mensagem)
    {
        $DBCon = new ConexaoImap();
        $posicaoIp = strpos($mensagem, 'Address');
        $ip = substr($mensagem, ($posicaoIp + 9), 12);
        $ip = explode('.', $ip);
        $ip = $ip[0] . $ip[1] . $ip[2] . $ip[3];
        $ip = trim($ip);
        $sql = "SELECT * FROM instalacoes WHERE num_ip ='$ip'";
        $dados = $DBCon->conexao($sql);
//        print_r($dados);exit();
        $DBCon->close();
        $idinstalacoes = $dados['idinstalacoes'];
        return $idinstalacoes;
    }


    private function limpaPrioridade($mensagem)
    {
        $posicao1 = strpos($mensagem, 'Prioridade');
        $prioridade = substr($mensagem, ($posicao1 + 16), 6);
        return $prioridade;
    }


    private function limpaDataTime()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataTime = date('Y-m-d H:m:s');
        return $dataTime;
    }

    private function limpaTecResp($mensagem)
    {
        $posicao1 = strpos($mensagem, 'Responsável:');
        $prioridade1 = substr($mensagem, ($posicao1 + 14), 40);
        $posicao2 = strpos($prioridade1, ',');
        $prioridade2 = substr($prioridade1, ($posicao2), 1);

        if ($prioridade2 == ',') {
            $prioridade1 = explode(',', $prioridade1);
            return $prioridade1[0];

        } else {
            return $prioridade2;
        }
    }

    private function validaEmailIncidenteProdemge($assunto)
    {
        $assuntoCut = substr($assunto, 21, 22);
        if ($assuntoCut == 'Aguardando atendimento')
            return true;
        else
            return false;
    }
    private function inserePreIncidentes(Array $listaPreIncidentes)
    {

        foreach ($listaPreIncidentes as $chave => $preIncidente) {
            $dados = $this->verificaExistenciaIncidente($preIncidente['idProdemge'], $preIncidente['tecResponsavel']);
            if ($dados) {
                $atendVsat = $this->verificaInstalacaoNoAtendimento($preIncidente['idinstalacoes']);
                if($atendVsat){
                    if ($atendVsat['status_atend_idstatus_atend'] != 3) {
                        $DBCon = new ConexaoImap();
                        $sql = "
                        INSERT INTO associacao_instalacao_incidente ( idinstalacoes , idincidentes, idprodemge )
                        VALUES ( '{$preIncidente['idinstalacoes']}' , '{$atendVsat['incidentes_idincidentes']}', {$dados['idprodemge']} )
                        ";
                        $DBCon->conexao($sql);
                        $DBCon->close();

                    } else {

                        $DBCon = new ConexaoImap();
                        $idatend = $this->inciaAtendiemento($preIncidente['idinstalacoes']);
                        $data = array(
                            'id_prodemge' => $dados['idprodemge'],
                            'descricao' => $preIncidente['descricao'],
                            'data_email' => $preIncidente['data_email'],
                            'prioridade' => html_entity_decode($preIncidente['prioridade']),
                            'idinstalacoes' => $preIncidente['idinstalacoes'],
                            'tecnicoNoc' => 4,
                            'data_time' => $preIncidente['dataTime'],
                        );

                        $sql = "INSERT INTO incidentes(
                                    idprodemge, descricao,`data`, prioridade,
                                    instalacoes_idinstalacoes, tecnicoNoc, data_modificacao
                                )
                                VALUES(
                                    '{$data['id_prodemge']}','{$data['descricao']}','{$data['data_email']}','{$data['prioridade']}',
                                    '{$data['idinstalacoes']}', '{$data['tecnicoNoc']}' ,'{$data['data_time']}'
                                )";

                        $idincidente = $DBCon->conexao($sql);

                        $sql = "UPDATE atend_vsat SET incidentes_idincidentes = '{$idincidente}'
                                WHERE idatend_vsat = '{$idatend}'
                        ";
                        $DBCon->conexao($sql);
                        $sql = "
                            INSERT INTO associacao_instalacao_incidente ( idinstalacoes , idincidentes, idprodemge )
                            VALUES ( '{$data['idinstalacoes']}' , '{$idincidente}', {$data['id_prodemge']} )
                        ";
                        $DBCon->conexao($sql);
                        $DBCon->close();

                    }

                }else{
                    $DBCon = new ConexaoImap();
                    $sql = "
			        DELETE FROM prodemge WHERE numero_prodemge = '{$preIncidente['idProdemge']}'";
                    $DBCon->conexao($sql);
                }

            }
        }
    }

    public function verificaInstalacaoNoAtendimento($idInstalacao)
    {
        $DBCon = new ConexaoImap();
        if(!$idInstalacao) return false;

        $sql = "SELECT idatend_vsat, status_atend_idstatus_atend, incidentes_idincidentes
                FROM atend_vsat
                WHERE instalacoes_idinstalacoes = '{$idInstalacao}' ORDER BY idatend_vsat DESC LIMIT 1 ";

        $atend_vsat = $DBCon->conexao($sql);


        if ($atend_vsat) {
//            if ($atend_vsat['status_atend_idstatus_atend'] != 3) {
//                return $atend_vsat;
//            } else {
//                return false;
//            }
            return $atend_vsat;
        } else {
            return false;
        }

    }

    public function verificaExistenciaIncidente($numProdemge, $tecResp)
    {

        $DBCon = new ConexaoImap();

        $numeroProdemge = $this->cadastrarNumeroProdemge($numProdemge);
        if ($numeroProdemge) {

            $sql = "SELECT idprodemge FROM prodemge	WHERE numero_prodemge = '$numProdemge'";
            $idprodemge = $DBCon->conexao($sql);

            if (count($idprodemge) > 0)
                return $idprodemge;
            else
                return false;
        } else {
            $this->verificaTecnicoResponsavel($tecResp, $numProdemge);

            return false;
        }
    }


    public function cadastrarNumeroProdemge($idProdemge)
    {

        $DBCon = new ConexaoImap();
        $sql = "
			SELECT idprodemge FROM prodemge WHERE numero_prodemge = '{$idProdemge}'";
        $existe = $DBCon->conexao($sql);
        if ($existe) {

            return false;
        } else {
            $sql = "INSERT INTO prodemge(numero_prodemge)value('{$idProdemge}')";
            $DBCon->conexao($sql);

            return true;
        }
    }


    public function inciaAtendiemento($idinstalacao)
    {
        //cria atendimento
//		$DBAtend = new DBAtendVsat();
        $form = array();
        $form['data'] = date("Y-m-d H:i:s");
        $form['atendimento'] = 'Atendimento iniciado por Tecnico NOC BH' . " as " . date("H:i") . " de " . date("d/m/Y");
        $form['status_atend_idstatus_atend'] = 1;
        $form['instalacoes_idinstalacoes'] = $idinstalacao;
        $form['tipo_atendimento_idtipo_atendimento'] = 1;//default
        $form['saom'] = 1;

        $form['usuarios_idusuarios'] = 4;


        $DBCon = new ConexaoImap();
        $sql = "
            INSERT INTO atend_vsat(
              `data`, atendimento, status_atend_idstatus_atend,
               instalacoes_idinstalacoes, usuarios_idusuarios,
               tipo_atendimento_idtipo_atendimento, saom
            )
            VALUES(
              '{$form['data']}','{$form['atendimento']}','{$form['status_atend_idstatus_atend']}',
              '{$form['instalacoes_idinstalacoes']}','{$form['usuarios_idusuarios']}',
              '{$form['tipo_atendimento_idtipo_atendimento']}','{$form['saom']}'
            )";
        $idatend = $DBCon->conexao($sql);

        if ($idatend) {
            $sql = "
                INSERT INTO cronometro (idreferencia, inicio_tarefa, tabelareferencia)
                VALUES ('{$idatend}', '" . date('Y-m-d H:i:s') . "','atend_vsat')
            ";
            $DBCon->conexao($sql);
        }
        return $idatend;

    }

    public function verificaTecnicoResponsavel($tecRsp, $numProdemge)
    {
        if ($tecRsp == 'D') {
            return false;
        } else {
            $DBCon = new ConexaoImap();
            $sql = "SELECT idusuarios FROM usuarios	WHERE sobre_nome = '$tecRsp'";
            $idusuario = $DBCon->conexao($sql);

            $sql = "SELECT idprodemge FROM prodemge	WHERE numero_prodemge = '$numProdemge'";
            $idprodemge = $DBCon->conexao($sql);

            $sql = "UPDATE incidentes SET tecnicoNoc = '{$idusuario['idusuarios']}'
            		    WHERE idprodemge = '{$idprodemge['idprodemge']}'
            	";
            $DBCon->conexao($sql);

            $sql = "SELECT idincidentes FROM incidentes	WHERE idprodemge = '{$idprodemge['idprodemge']}'";
            $idincidente = $DBCon->conexao($sql);

            $sql = "UPDATE atend_vsat SET usuarios_idusuarios = '{$idusuario['idusuarios']}'
            		    WHERE incidentes_idincidentes = '{$idincidente['idincidentes']}'
            	";
            $DBCon->conexao($sql);

            $DBCon->close();

            return false;
        }
    }
}
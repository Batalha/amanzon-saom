<?
	session_start("login");
	$acesso = $HTTP_SESSION_VARS['usrAcesso'];
	$usrId = $HTTP_SESSION_VARS['usrId'];

	//Recebendo variáveis postadas.
	$servicoExecutado = $_POST['servico'];
	$materialUtilizado = $_POST['material'];
	$pendencias = $_POST['pendencias'];
	$dtInicio = $_POST['dtInicio'];
	$hrInicio = $_POST['hrInicio'];
	$data = unpack("A2dia/x1/A2mes/x1/A4ano", $dtInicio);
	$dtInicio = $data['ano']."-".$data['mes']."-".$data['dia'];
	$hrInicio = $hrInicio.":00";
	$dtFim = $_POST['dtFim'];
	$hrFim = $_POST['hrFim'];
	$data = unpack("A2dia/x1/A2mes/x1/A4ano", $dtFim);
	$dtFim = $data['ano']."-".$data['mes']."-".$data['dia'];
	$hrFim = $hrFim.":00";
	$origem = $_POST['origem'];
	$distanciaIda = $_POST['distIda'];
	$dtSaidaIda = $_POST['dtSaidaIda'];
	$hrSaidaIda = $_POST['hrSaidaIda'];
	$data = unpack("A2dia/x1/A2mes/x1/A4ano", $dtSaidaIda);
	$dtSaidaIda = $data['ano']."-".$data['mes']."-".$data['dia'];
	$hrSaidaIda = $hrSaidaIda.":00";
	$dtChegadaIda = $_POST['dtChegadaIda'];
	$hrChegadaIda = $_POST['hrChegadaIda'];
	$data = unpack("A2dia/x1/A2mes/x1/A4ano", $dtChegadaIda);
	$dtChegadaIda = $data['ano']."-".$data['mes']."-".$data['dia'];
	$hrChegadaIda = $hrChegadaIda.":00";
	$obsIda = $_POST['obsIda'];
	$destino = $_POST['destino'];
	$dtSaidaVolta = $_POST['dtSaidaVolta'];
	$hrSaidaVolta = $_POST['hrSaidaVolta'];
	$data = unpack("A2dia/x1/A2mes/x1/A4ano", $dtSaidaVolta);
	$dtSaidaVolta = $data['ano']."-".$data['mes']."-".$data['dia'];
	$hrSaidaVolta = $hrSaidaVolta.":00";
	
	$dtChegadaVolta = $_POST['dtChegadaVolta'];
	$hrChegadaVolta = $_POST['hrChegadaVolta'];
	$data = unpack("A2dia/x1/A2mes/x1/A4ano", $dtChegadaVolta);
	$dtChegadaVolta = $data['ano']."-".$data['mes']."-".$data['dia'];
	$hrChegadaVolta = $hrChegadaVolta.":00";
	
	$obsVolta = $_POST['obsVolta'];
	$distanciaVolta = $_POST['distVolta'];
	
	$idChamado = $_GET['id'];
	$idEstacao = $_GET['idE'];
	
	
	include ("conexao.php");
	
	$qr = "UPDATE `chamado` SET servicoExecutado = '$servicoExecutado', materialUtilizado = '$materialUtilizado', pendencias = '$pendencias', dtInicio = '$dtInicio', hrInicio = '$hrInicio', dtFim = '$dtFim', hrFim = '$hrFim', origem = '$origem', distanciaIda = '$distanciaIda', dtSaidaIda = '$dtSaidaIda', hrSaidaIda = '$hrSaidaIda', dtChegadaIda = '$dtChegadaIda', hrChegadaIda = '$hrChegadaIda', obsIda = '$obsIda', destino= '$destino', dtSaidaVolta = '$dtSaidaVolta', hrSaidaVolta = '$hrSaidaVolta', dtChegadaVolta = '$dtChegadaVolta', hrChegadaVolta = '$hrChegadaVolta', obsVolta = '$obsVolta', distanciaVolta = '$distanciaVolta', status = 'Encerrado',  WHERE `idChamado` = '$idChamado';";
    //faz a confirmação da gravação
	$gravar = mysql_query($qr) or die("Erro ao selecionar");

//Logar atividade
	$qrLog = "INSERT INTO log VALUES ('','".date("Y-m-d")."','".date("H:i:s")."','finalizacao', '".$usrId."', 'chamado', '".$idChamado."', 'Encerrou um chamado');"; 
	$gravarLog = mysql_query($qrLog) or die("Erro ao gravar log");
	
	if ($gravar == 1 ){ //caso tenha gravado
	
		$qrMail = "SELECT * FROM chamado a, estacao b, usuario c, contato d WHERE a.idChamado = '".$idChamado."' AND a.idEstacao = b.idEstacao AND a.idTecnico = c.idUsuario AND c.idContato = d.idContato"; 
		$consultar = mysql_query($qrMail) or die("Erro ao selecionar");
		$chamado = mysql_fetch_array($consultar);
		
		
		$qrSolicitante = "SELECT * FROM chamado a, usuario c, contato d WHERE a.idChamado = '".$idChamado."' AND a.idTecSolicitante = c.idUsuario AND c.idContato = d.idContato"; 
		$consultar = mysql_query($qrSolicitante) or die("Erro ao selecionar");
		$solicitante = mysql_fetch_array($consultar);
		
		
		$remetente = "saom@vodanet-telecom.com";
		$assunto = "S.A.O&M: Chamado encerrado - ".$chamado['CNL']." - ".$chamado['localidade'].". Estado: ".$chamado['UF'];
		//$mensagem = htmlspecialchars($mensagem); // Isso aqui é pra Desabilitar Tag's HTML (Muito Util)
		
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $remetente\r\n"; 
		$headers .= "Return-Path:daniel@vodanet-telecom.com\n"; // Return path for errors     
		
		$fonte = "<font size=\"-1\" face=\"Verdana, Arial, Helvetica, sans-serif\">";
		$msg  = "$fonte <b>Comunicado de encerramento de chamado</b><br>";
		$msg .= "<br>".$solicitante['nome'].", o chamado que você abriu foi encerrado. <br>Segue abaixo a descrição das atividades em campo. <br>Para informações adicionais acesse o sistema. <br>";
		$msg .= "<br>Estação: ".$chamado['CNL']." - ".$chamado['localidade']."<br>";
		$msg .= "Estado: ".$chamado['UF']."<br>";
		$msg .= "<br>Tipo de chamado: ".$chamado['tipo']."<br>";
		if ($chamado['tipo'] == 'Res. de BA') {
			$data_BA = unpack("A4ano/x1/A2mes/x1/A2dia", $chamado['dtVencimentoBA']);
			$msg .= "Número do BA: ".$chamado['nroBA']." <br> Vencimento: ".$data_BA['dia']."/".$data_BA['mes']."/".$data_BA['ano']." - ".$chamado['hrVencimentoBA']." <br>";
		}
		$msg .= "<br>Solicitante: ".$chamado['solicitante']." (".$chamado['telSolicitante'].") <br>";
		$msg .= "Motivo: ".$chamado['motivoVisita']." <br>";
		$msg .= "<br>Tecnico: ".$chamado['nome']." <br>";
		$msg .= "Serviço executado: ".$chamado['servicoExecutado']." <br>";
		$msg .= "Pendências: ".$chamado['pendencias']." <br>";
		

				
		$email_tec = $solicitante['email1'];

		$envia = mail("$email_tec", "$assunto", "$msg", "$headers");
		$envia = mail("apacheco@vodanet-telecom.com", "$assunto", "$msg", "$headers");
		$envia = mail("daniel@vodanet-telecom.com", "$assunto", "$msg", "$headers");
	
		header("location:as_built.php?id=$idEstacao");
		
	} else { //caso NÃO tenha gravado
		echo "Alteração NÃO realizada. Contate o administrador.";
		//header("location:chamado_ver.php");
	}	

	desconectar($db);
?>
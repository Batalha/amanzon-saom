<?php
	include "conexao.php"; 
	if(getenv("REQUEST_METHOD")=="POST"){
		$usuario = $_POST['txUsuario'];
		$senha	 = $_POST['txSenha'];
		$usuario = addslashes($usuario);
		$senha   = addslashes($senha);
		$stg = "SELECT * FROM usuario AS a, contato as b WHERE a.idContato = b.idContato AND a.usuario = '".$usuario."' AND a.senha = '".$senha."'";
		$sql = mysql_query($stg,$con);
		
		if($sql){
		session_start();
		$dados = mysql_fetch_array($sql);
		$_SESSION['usrNome'] = $dados['nome'];
		$_SESSION['usrUsuario'] = $dados['usuario'];
		$_SESSION['usrAcesso'] = $dados['acesso'];
		$_SESSION['usrId'] = $dados['idUsuario'];
		$_SESSION['usrSetor'] = $dados['setor'];
		$_SESSION['usrIdContato'] = $dados['idContato'];
		}
		//Loga atividade
		$qrLog = "INSERT INTO log VALUES ('','".date("Y-m-d")."','".date("H:i:s")."','login','".$dados['idUsuario']."','usuario','".$dados['idUsuario']."','Logou no sistema');";
		@$gravarLog = mysql_query($qrLog, $con) or die("Erro ao gravar log");
		if($dados['alterarSenha']=='S'){
			header("Location:conta_edt.php");
		}
		else{
			header("Location: index2.php");
		}
	}
	else {
		header("Location:index.php?e=2");
	}
	
	?>
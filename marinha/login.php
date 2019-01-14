<!--<script type="text/javascript" src="js/login.js"></script>-->
<!--<link href="css/stilo.css" rel="stylesheet" type="text/css" />-->

<script type="text/javascript" src="../public/js/login.js"></script>
<link href="../public/CSS/login.css" rel="stylesheet" type="text/css" />


	<!DOCTYPE html>
	<center>

		<div id="loginContener">
			<div id="loginInterno">
				<div id="loginLabel">Login e Senha</div>
				<form action="index.php" method="post">
					<div id="loginLogo"><img src="../public/imagens/geeemc.png" height="50" width="335" alt="EMC"></div>

					<input name="request" value="" type="hidden">
					<input name="loginErro" value="Login ou Senha Invalido!" type="hidden">

					<div class="input-div" id="input-usuario">
						<input id="name" name="name"  type="text" placeholder="Usuario">
					</div>
					<div class="input-div" id="input-senha">
						<input id="password" name="password"  type="password" placeholder="Password">
					</div>

					<div id="botoes">
						<div id="loginErro">
							<?php
							session_start();
							echo $_SESSION['erro'];
							session_destroy();
							?>

						</div>
						<input name="enter" id="botao" value="Sign in" type="submit">
					</div>
<!--					<div id="loginLogo"><img src="img/emc.png" height="60" width="145"></div>-->

				</form>

			</div>
		</div>

</center>


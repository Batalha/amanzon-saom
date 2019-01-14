<!DOCTYPE html>

<head>
    <title>Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="../public/js/login.js"></script>
	<link href="../public/CSS/login.css" rel="stylesheet" type="text/css" />
</head>


<body>
    <div>
        {if $mensagemLog!=''}
           <div class="loginErro"> <span>{$mensagemLog}!</span></div>
        {/if}
    </div>
	<div id="loginContener">
        <div id="loginInterno">
            <div id="loginLabel">Saom - Login</div>
            <form action="{$prodemge}/Usuario/login" method="post" name="login_central">

                <div id="loginLogo"><img src="../public/imagens/emc.png" height="" width="335" alt="EMC"></div>
                <div class="input-div" id="input-usuario">
                    <input id="login" name="login"  type="text" placeholder="Usuario">
                </div>
                <div class="input-div" id="input-senha">
                    <input id="senha" name="senha"  type="password" placeholder="Senha">
                </div>

                <div id="botoes">
                    <input type="submit" name="submit" id="botao" value="Entrar" />
                </div>


            </form>

        </div>
        <div id="marca">
            <hr/>
            Emerging Markets Communications. SAOM 2012.<br/>
            Webmaster/Database Admin: <a href="mailto:cbatalha@emc-corp.net">Célio Batalha</a>.
        </div>
    </div>

    <script> $('#login').focus(); </script>

</body>


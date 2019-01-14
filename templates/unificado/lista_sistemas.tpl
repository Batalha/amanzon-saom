<!DOCTYPE html>
<head>
    <title>Sistema de apoio</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
    <script src="../libs/jquery-ui-1.8.17/js/jquery-1.7.1.min.js"></script>
    
    <!-- bootstrap twitter -->
	<script type='text/javascript' src='../libs/bootstrap/js/bootstrap.js'></script>
	<link rel="stylesheet" type="text/css" href="../libs/bootstrap/css/bootstrap.css" />
    <link href="../public/CSS/login.css" rel="stylesheet" type="text/css" />
    <link href="../public/CSS/saom_clientesp.css" rel="stylesheet" type="text/css">
</head>
<body style="width: auto; margin: 0 auto;">
        <div id="loginContener" style="border: 1px solid; background-color: #E3E7EA;">
            <div id="sistemaInterno">
                <h4>Em qual SAOM deseja Entrar?</h4>
                <ul style="padding:20px;list-style:none;">
                    <li style="height:20px;">&nbsp;</li>
                    <li>
                        <a class="btn" href="{$sp}#home">
                            <i class="icon-screenshot"></i>
                            SAOM
                            São Paulo
                        </a>
                    </li>
                    <li style="height:20px;">&nbsp;</li>
                    <li>
                        <a class="btn" href="{$prodemge}">
                            <i class="icon-screenshot"></i>
                            SAOM
                            Prodemge
                        </a>
                    </li>
                </ul>
            </div>
            <div style="text-align:center; margin-bottom: 20px;">
                <a href="{$prodemge}/Usuario/logout">Sair</a>
            </div>
        </div>
{*{include file="footter.tpl" title=footer}*}
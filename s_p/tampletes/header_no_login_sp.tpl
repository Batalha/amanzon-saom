<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML/1.0 Transitional//EN">
<html>
<head>
    <title>Sistema de apoio a O&M</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="libs/ext/resources/css/ext-all.css">
    <link href="public/CSS/saom.css" rel="stylesheet" type="text/css">
    <link href="public/CSS/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="libs/jquery.min.js"></script>
    <script src="libs/jquery-ui.min.js"></script>

    <script type="text/javascript" src="libs/ext/ext-all.js"></script>
    <script type="text/javascript" src="public/js/funcGlobals.js"></script>

    <link href="public/CSS/jquery-ui.css" rel="stylesheet" type="text/css"/>

    <!-- bootstrap twitter -->
    <script type='text/javascript' src='libs/bootstrap/js/bootstrap.js'></script>
    <link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css" />

</head>
<body class="body">
<div id="todo">

    <div id="topo">

        <div id="topoArea">

            <div id="logoTopo">
                <span id="tituloSistema">S. A.  O&M</span><br/>
                <span id="subtituloSistema">SISTEMA DE APOIO A O&M</span>
            </div>

            <div id="centro_topo">

                <!-- {include "centro_topo.tpl"} -->

            </div>

            <div id="cxLogin">

                <div id="mensagemBoasVindas" style="margin-top:0px;">

                    <form action="Usuario/login" method="post">
                        <div id="caixaLogDiv">
                            <div id="camposLogDiv">
                                <div>
                                    <h4>Login</h4>
                                    <div style="clear:both">&nbsp;</div>
                                </div>
                                <div>
                                    <input type="text" name="login" id="login" size="10"
                                           placeholder="Usuário"
                                           style="width:150px;height:28px !important;"
                                            />
                                </div>
                                <div>
                                    <input type="password" name="senha" id="senha" size="10"
                                           placeholder="Senha"
                                           style="width:150px;height:28px !important;"
                                            />
                                </div>

                            </div>
                            <div id="submitLogDiv">

                                <div style="float:left;width:60px;">
                                    <input type="submit" name="enviar" id="enviar" value="Enviar"
                                           style="height:28px !important;";
                                    />
                                </div>
                                <div style="float:left"><label>{$mensagemLog}</label></div>

                            </div>
                        </div>
                    </form>

                </div>

            </div>

            <div style="float:left;width:50px;height:90px;">&nbsp;</div>

            <div style="height:0px;width:0px;clear:both;">&nbsp;</div>

        </div>

    </div>

    <div id="conteudo" >
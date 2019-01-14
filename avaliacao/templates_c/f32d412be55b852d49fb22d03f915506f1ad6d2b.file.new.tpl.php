<?php /* Smarty version Smarty 3.1.0, created on 2018-05-11 10:02:44
         compiled from "atendimento/new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:67285184959ad8ee148cfb8-53388913%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f32d412be55b852d49fb22d03f915506f1ad6d2b' => 
    array (
      0 => 'atendimento/new.tpl',
      1 => 1523635081,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67285184959ad8ee148cfb8-53388913',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_59ad8ee14d2d4',
  'variables' => 
  array (
    'idatend' => 0,
    'numberInc' => 0,
    'url' => 0,
    'nomeSolicitacao' => 0,
    'nomeTipo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ad8ee14d2d4')) {function content_59ad8ee14d2d4($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.scss">
</head>
<body>
    <form action="/avaliacao/satisfacao.php" method="post">
        <input type="hidden" name="idatend" value="<?php echo $_smarty_tpl->tpl_vars['idatend']->value;?>
">
        <div class="header">
            <img src="../../public/imagens/EMC_header.jpg">
            <div class="headerTitle">Classificações de pesquisa</div>
            <img src="../public/imagens/logo_gee.png" width="12%" alt="">
        </div>

        <div class="dataSelector">
            <div>
                <div class="ui-widget">
                    <b>Ticket #:&nbsp;</b><span><?php echo $_smarty_tpl->tpl_vars['numberInc']->value;?>
</span>
                </div>
            </div>
        </div>

        <div class="jumbotron">
            <div class="container"  <?php if (!$_smarty_tpl->tpl_vars['url']->value){?>id="stiloDisabled"<?php }else{ ?>id="stiloEnabled"<?php }?>>
                <div class="row-fluid clearfix">
                    <div class="span12">
                        <h4 style="margin-top:0px;font-weight: normal;">
                            Tipo de Ticket:&nbsp;
                            <span> <?php echo $_smarty_tpl->tpl_vars['nomeSolicitacao']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['nomeTipo']->value;?>
 </span>
                        </h4>
                    </div>
                </div>
                <?php if (!$_smarty_tpl->tpl_vars['url']->value){?>
                <br>
                <div class="row-fluid">
                    <div class="alert alert-warning text-center" role="alert">
                        Esta pesquisa já foi avaliada. Obrigado pelo seu feedback!
                    </div>
                </div>
                <?php }else{ ?>
                <div class="row-fluid" style="margin-top:15px;">
                    <div class="span12">
                        <span>Para as perguntas abaixo sobre satisfação do cliente, selecione a opção mais adequada para você.</span>
                    </div>
                </div>
                <div class="card border-primary"  style="background-color: #E9ECEF;">
                    <div class="card-body">
                        <div style="background-color: white">
                            <div class="mtnGridHeader">Questões</div>
                            <table class="table table-striped">
                                <tbody class="mtnBody">
                                <tr>
                                    <td width="45%">Meu problema VSAT foi resolvido na minha primeira interação com o NOC.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_1" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_1" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_1" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_1" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_1" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>

                                </tr>
                                <tr>
                                    <td>O técnico que cuidou do meu problema mostrou profissionalismo e know-how.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_2" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_2" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_2" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_2" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_2" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>O técnico interagiu de uma maneira educada.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_3" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_3" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_3" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_3" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_3" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>O tempo de espera até o meu problema ser confirmado foi curto, de acordo com os meus padrões.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_4" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_4" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_4" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_4" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_4" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Meu problema VSAT foi seguido de acordo com a resolução, conforme meus padrões.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_5" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_5" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_5" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_5" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_5" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fui informado do motivo da interrupção em tempo hábil.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_6" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_6" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_6" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_6" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_6" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estou satisfeito com a disponibilidade do sistema VSAT contratado pela Global Eagle.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_7" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_7" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_7" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_7" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_7" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estou feliz com o suporte ao cliente recebido nesta interação.</td>
                                    <td>
                                        <input id="" type="radio"  name="pgt_8" value="1">
                                        <label for="">Discordo Totalmente(1)</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_8" value="2">
                                        <label for="">2</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_8" value="3">
                                        <label for="">3</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_8" value="4">
                                        <label for="">4</label>
                                    </td>
                                    <td>
                                        <input id="" type="radio" name="pgt_8" value="5" checked="checked">
                                        <label for="">Concordo plenamente(5)</label>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php }?>
                <br>
                <div class="card border-primary"  style="background-color: #E9ECEF;">
                    <div class="card-body">
                        <span>Qual a probabilidade de você recomendar a Global Eagle aos seus colegas?</span>

                        <table class="table" <?php if (!$_smarty_tpl->tpl_vars['url']->value){?>id="radioDisabled"<?php }else{ ?>id="radioEnabled"<?php }?> style="width: 80%;">
                            <tbody>
                            <tr>
                                <td>
                                    <label  for="">Nada Provavel: </label>
                                    <input id="" type="radio" name="pgt_9" value="0">
                                    0
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="1">
                                    <label  for="">1</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="2">
                                    <label  for="">2</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="3">
                                    <label  for="">3</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="4">
                                    <label  for="">4</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="5">
                                    <label  for="">5</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="6">
                                    <label  for="">6</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="7">
                                    <label  for="">7</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="8">
                                    <label  for="">8</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="9">
                                    <label  for="">9</label>
                                </td>
                                <td>
                                    <input id="" type="radio" name="pgt_9" value="10" checked="checked">
                                    <label  for="">10: Extremamente Provavel</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>

                <div class="card border-primary"  style="background-color: #E9ECEF;">
                    <div class="card-body">
                        <div class="legend" style="width:100%;">Por favor, insira comentários adicionais ... Se necessário</div>
                        <textarea <?php if (!$_smarty_tpl->tpl_vars['url']->value){?>readonly<?php }else{ ?><?php }?> name="comentarios" rows="3" cols="20" id="" style="width:100%;"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <input  type="submit" name="" value="Enviar" id="" class="btn btn-outline-primary"
                        <?php if (!$_smarty_tpl->tpl_vars['url']->value){?> disabled <?php }else{ ?><?php }?>
                        >
                    </div>
                </div>
            </div>
        </div>
            <footer style="">
                <div class="content-wrapper"></div>
            </footer>
    </form>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/avaliacao.js"></script>

</body>
</html>


<!--<form action="http://saom.vodanet-telecom.com/avaliacao/satisfacao.php" method="post">-->

<!--<div style="height:460px;border:2px">-->
    <!--<div id="container">-->
        <!--<div class="row-fluid" style="margin-top:10px;">-->
            <!--<div class="span12">-->
                <!--<div class="fieldset">-->
                    <!--<div class="legend" style="width:100%;">-->
                                <!--Por favor, insira comentários adicionais ... Se necessário-->
                    <!--</div>-->
                    <!--<textarea name="ctl00$MainContent$txtAdditionalComments" rows="3" cols="20"-->
                                      <!--id="MainContent_txtAdditionalComments" style="width:100%;">-->

                    <!--</textarea>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="row-fluid" style="margin-top:10px">-->
            <!--<div class="span12">-->
                <!--<input  type="submit" name="ctl00$MainContent$btnSumit" value="Enviar" id="MainContent_btnSumit" class="btn">-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="row-fluid" style="margin-top:15px;">-->
            <!--<div class="span6">-->
                <!--<div class="fieldset">-->
                    <!--<div class="legend" style="width:100%;"><font style="vertical-align: inherit;"><font-->
                            <!--style="vertical-align: inherit;">Incidente - Notas do Problema ..</font></font>-->
                    <!--</div>-->
                    <!--<div class="format"><span id="MainContent_lblProblemNotes"><font-->
                            <!--style="vertical-align: inherit;"><font style="vertical-align: inherit;">Uma-->
                        <!--interrupção no modem da Corp (banda C, IMA2) foi detectada por meio de ferramentas-->
                        <!--de monitoramento; </font><font style="vertical-align: inherit;">IMA2 foi observado-->
                        <!--dentro da zona de bloqueio programada</font></font></span></div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="span6">-->
                <!--<div class="fieldset">-->
                    <!--<div class="legend" style="width:100%;"><font style="vertical-align: inherit;"><font-->
                            <!--style="vertical-align: inherit;">Incidente - Notas de Resolução ..</font></font>-->
                    <!--</div>-->
                    <!--<div class="format"><span id="MainContent_lblResolutionNotes"><font-->
                            <!--style="vertical-align: inherit;"><font style="vertical-align: inherit;">O-->
                        <!--sistema foi auto-recuperado quando o navio mudou de posição</font></font></span>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->

    <!--<div style="display:none">-->
        <!--<input name="ctl00$MainContent$txtInvoicesList" type="text" id="MainContent_txtInvoicesList">-->
    <!--</div>-->
<!--</div>-->
<!--<span id="lbl_Exec" class="hiddenLbl"></span>-->
<!--<span id="lbl_UserGroup" class="hiddenLbl"></span>-->
<!--</div>-->
<!--<div id="PnlFooterNav" style="text-align:center;padding: 10px;">-->


<!--</div>-->

<!--<footer>-->
    <!--<div class="content-wrapper">-->
    <!--</div>-->


<!--</footer>-->

<?php }} ?>
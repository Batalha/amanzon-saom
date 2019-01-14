<?php /* Smarty version Smarty 3.1.0, created on 2017-09-04 17:48:59
         compiled from "atendimento/expirado.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136952022759ad920b8c7815-79280734%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '128913517b651a278c5673669b4f6678953469cf' => 
    array (
      0 => 'atendimento/expirado.tpl',
      1 => 1504544317,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136952022759ad920b8c7815-79280734',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'obg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_59ad920b8fa82',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ad920b8fa82')) {function content_59ad920b8fa82($_smarty_tpl) {?><link rel="stylesheet" href="css/style.css">
    <?php if ($_smarty_tpl->tpl_vars['obg']->value!=true){?>
        <div class="container exp1">
            <div class="row text-center">
                <div class="form-group col-md-12 fontExp">
                    <script>
                        window.setTimeout(function(){
                            alert('Sessao Expirado!');
                            location.href="/"
                        },1000);
                    </script>
                </div>
            </div>
        </div>
    <?php }else{ ?>

        <div class="container exp2">
            <div class="row text-center">
                <div class="form-group col-md-12 fontExp">
                    <script>
                        window.setTimeout(function(){
                            alert('Obrigado por nos ajudar a melhorar o atendimento!');
                            location.href="/"
                        },1000);
                    </script>

                </div>
            </div>
        </div>
    <?php }?>
<?php }} ?>
<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="usuario/submenu.tpl" title=submenu}
        </div>
    </div>
</div>
<br>
<div class="container1" style="width: 55%;">

    <form action="Usuario/edit" method="POST" id="fUsEdit" class="form" >
        <input type="hidden" name="idusuarios" id="idusuarios" value="{$obj.idusuarios}"/>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Cadastrar Usuário</div>
            </div>
            <div class="panel-body">
                <div class="">
                    <div class="row">
                        <div id="errorNome" class="form-group col-md-6">
                            <input type="text" name="nome" id="nome" class="form-control"  placeholder="Nome" value="{$obj.nome}"
                                   onkeyup="avascript:retiraErrorUsuario()"
                            >
                        </div>
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="telefone" id="telefone" placeholder="Telefone" value="{$obj.telefone}"/>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="funcao" id="funcao" value="{$obj.funcao}" placeholder="Qual a Funçao?" />
                        </div>
                        <div id="errorEmail" class="form-group col-md-6">
                            <input class="form-control" type="text" name="email" id="email" value="{$obj.email}" placeholder="E-mail"
                                   onchange="javascript:retiraErrorUsuario()"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div id="errorEmpresa" class="form-group col-md-6">
                            <select class="form-control" name="empresas_idempresas" id="empresas_idempresas"
                                    onchange="javascript:retiraErrorUsuario()"
                            >
                                <option value="">Escolha uma empresa</option>
                                {foreach from=$empresas item=empresa}
                                    <option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empresas_idempresas}selected{/if}>{$empresa.empresa}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="incidentes" id="incidentes" type="checkbox" {if $obj.incidentes==1}checked{/if}/>
                                </span>
                                <input type="text" class="form-control" readonly="readonly"  placeholder="Pode ser responsável por incidente?">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div id="errorPerfil" class="form-group col-md-6">
                            <select class="form-control" name="perfis_idperfis" id="perfis_idperfis"
                                    onchange="javascript:retiraErrorUsuario()"
                            >
                                <option value="">Escolha Prfil</option>
                                {foreach from=$perfis item=perfil}
                                    <option value="{$perfil.idperfis}" {if $perfil.idperfis == $obj.perfis_idperfis} selected {/if}>{$perfil.perfil}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="arquivo_supervisor" id="arquivo_supervisor" type="checkbox" {if $obj.arquivo_supervisor==1}checked{/if}/>
                                </span>
                                <input type="text" class="form-control" disabled="disabled"  placeholder="Recebe arquivos compartilhados?">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="" class="form-group col-md-6">
                            <input class="form-control" type="password" name="senha" id="senha" disabled="disabled" value="{$obj.senha}" placeholder="Password"
                                   onchange="javascript:retiraErrorUsuario()"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" name="ativacao" id="ativacao1"  value="1" {if $obj.ativacao==1}checked{/if}/>
                                </span>
                                <input type="text" class="form-control" disabled="disabled" style="font-size: 13px;"  placeholder="Ativar Usuário?">
                                <span class="input-group-addon">
                                    <input type="radio" name="ativacao" id="ativacao2" value="0" {if $obj.ativacao==0}checked{/if}/>
                                </span>
                                <input type="text" class="form-control" disabled="disabled" style="font-size: 14px;"  placeholder="Desativar?">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div id="" class="form-group col-md-6">
                            <input class="form-control" type="text" name="login" id="login" value="{$obj.login}" placeholder="Usuário"
                                   onchange="javascript:retiraErrorUsuario()"
                            />
                        </div>

                    </div>
                    <div class="row" align="center">
                        <div class="form-group">
                            <hr>
                            <input type="button" class="btn btn-primary" value="Editar Usuário"
                                   onClick="javascript:sendPost('Usuario/edit','fUsEdit')"
                                   onmouseover="javascript:verificaCamposUsuario()"
                            />
                            <input type="button" class="btn btn-primary" value="Mudar Senha"
                                   onClick="javascript:getAjaxForm('Usuario/editSenha','conteudo',{ldelim}param:{$obj.idusuarios},ajax:1{rdelim})" />

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
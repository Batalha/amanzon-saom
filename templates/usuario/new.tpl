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

    <form action="Usuario/create" method="POST" id="fUsCreate" class="form" >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Cadastrar Usuário</div>
            </div>
            <div class="panel-body">
                <div class="">
                    <div class="row">
                        <div id="errorNome" class="form-group col-md-6">
                            <input type="text" name="nome" id="nome" class="form-control"  placeholder="Nome"
                                   onkeyup="avascript:retiraErrorUsuario()"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="telefone" id="telefone" placeholder="Telefone"/>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="funcao" id="funcao" placeholder="Qual a Funçao?" />
                        </div>
                        <div id="errorEmail" class="form-group col-md-6">
                            <input class="form-control" type="text" name="email" id="email" placeholder="E-mail"
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
                                    <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="incidentes" id="incidentes" type="checkbox"/>
                                </span>
                                <input type="text" class="form-control" readonly="readonly"  placeholder="Pode ser responsável por incidente?">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="errorPerfil" class="form-group col-md-6">
                            <select class="form-control" id="perfis_idperfis" name="perfis_idperfis"
                                    onchange="javascript:retiraErrorUsuario()"
                            >
                                <option value="">Escolha um Perfil</option>
                                <option value="1">Técnico NOC</option>
                                <option value="5">Supervisor NOC</option>
                                <option value="8">Comercial</option>
                                <option value="9">Financeiro</option>
                                <option value="10">Cliente</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="arquivo_supervisor" id="arquivo_supervisor" type="checkbox" {if $obj.arquivo_supervisor==1}checked{/if}/>
                                </span>
                                <input type="text" class="form-control" readonly="readonly"  placeholder="Recebe arquivos compartilhados?">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="errorLogin" class="form-group col-md-6">
                            <input class="form-control" type="text" name="login" id="login" placeholder="Usuário"
                                   onchange="javascript:retiraErrorUsuario()"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="ativacao" id="ativacao" type="checkbox" {if $obj.ativacao==1}checked{/if}/>
                                </span>
                                <input type="text" class="form-control" readonly="readonly"  placeholder="Ativar Usuário?">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="errorSenha" class="form-group col-md-6">
                            <input class="form-control" type="password" name="senha" id="senha" placeholder="Password"
                                   onchange="javascript:retiraErrorUsuario()"
                            />
                        </div>

                    </div>
                    <div class="row" align="center">
                        <div class="form-group">
                            <hr>
                            <input type="button" class="btn btn-primary " value="Cadastrar Usuário"
                                   onClick="javascript:sendPost('Usuario/create','fUsCreate')"
                                   onmouseover="javascript:verificaCamposUsuario()"

                            />

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>
</div>
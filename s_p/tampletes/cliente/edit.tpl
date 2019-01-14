<div class="container1" style="width: 50%">
    <form action="Cliente_sp/create" method="POST" id="fCCEdit" class="form" >
        <input type="hidden" name="idempresas" id="idempresas" value="{$obj.idempresas}"/>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Editar Cliente</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="empresa">Cliente</label>
                        <input type="text" class="form-control" name="empresa" id="empresa" value="{$obj.empresa}"
                               onchange="javascript:retiraErrorCliente()"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="empresa">Prefixo da Vsat</label>
                        <input type="text" class="form-control" name="prefixo" id="prefixo" value="{$obj.prefixo}"
                               placeholder="Ex: VRTelecom (VR)"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cnpjFaturamento">CNPJ</label>
                        <input type="text" class="form-control" name="cnpjFaturamento" id="cnpjFaturamento" value="{$obj.cnpjFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="usuario_idusuario">Comercial</label>
                        <select name="usuario_idusuario" id="usuario_idusuario" class="form-control" onchange="javascript:retiraError()">
                            <option value="">Escolher Vendedor</option>
                            {foreach from=$listaUsuarios item=vez}
                            {if $vez.ativacao == 1 && $vez.incidentes == 1 && $vez.perfis_idperfis == 8}
                            <option value="{$vez.idusuarios}" {if $obj.usuario_idusuario == $vez.idusuarios} selected{/if}>{$vez.nome}</option>
                            {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="contatoFaturamento">Telefone</label>
                        <input type="text" class="form-control" name="contatoFaturamento" id="contatoFaturamento" value="{$obj.contatoFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-8">
                        <label for="enderecoFaturamento">Endereço</label>
                        <input type="text" class="form-control" name="enderecoFaturamento" id="enderecoFaturamento" value="{$obj.enderecoFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="paisFaturamento">País</label>
                        <input type="text" class="form-control" name="paisFaturamento" id="paisFaturamento" value="{$obj.paisFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cidadeFaturamento">Cidade</label>
                        <input type="text" class="form-control" name="cidadeFaturamento" id="cidadeFaturamento" value="{$obj.cidadeFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>

                    <div class="form-group col-md-4">
                        <label for="estadoFaturamento">Estado</label>
                        <input type="text" class="form-control" name="estadoFaturamento" id="estadoFaturamento" value="{$obj.estadoFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="cepFaturamento">CEP</label>
                        <input type="text" class="form-control" name="cepFaturamento" id="cepFaturamento" value="{$obj.cepFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-8">
                        <label for="emailFaturamento">Email</label>
                        <input type="text" class="form-control" name="emailFaturamento" id="emailFaturamento" value="{$obj.emailFaturamento}"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <hr>
                        <input type="button" class="btn btn-primary " value="Cadastrar Cliente"
                               onClick="javascript:sendPost('Cliente_sp/edit','fCCreate')"

                        />
                        <!--onmouseover="javascript:verificaCamposUsuario()"-->

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
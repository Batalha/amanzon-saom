<div class="container1" style="width: 50%">
    <form action="Cliente_sp/create" method="POST" id="fCCreate" class="form" >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Cadastrar Cliente</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="empresa">Cliente</label>
                        <input type="text" class="form-control" name="empresa" id="empresa"
                               onchange="javascript:retiraErrorCliente()"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="empresa">Prefixo da Vsat</label>
                        <input type="text" class="form-control" name="prefixo" id="prefixo" placeholder="Ex: VRTelecom (VR)"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cnpjFaturamento">CNPJ</label>
                        <input type="text" class="form-control" name="cnpjFaturamento" id="cnpjFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="usuario_idusuario">Comercial</label>
                        <select name="usuario_idusuario" id="usuario_idusuario" class="form-control" onchange="javascript:retiraError()">
                            <option value="">Escolher Vendedor</option>
                            {foreach from=$listaUsuarios item=vez}
                                {if $vez.ativacao == 1 && $vez.incidentes == 1 && $vez.perfis_idperfis == 8}
                                    <option value="{$vez.idusuarios}">{$vez.nome}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="contatoFaturamento">Telefone</label>
                        <input type="text" class="form-control" name="contatoFaturamento" id="contatoFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-8">
                        <label for="enderecoFaturamento">Endereço</label>
                        <input type="text" class="form-control" name="enderecoFaturamento" id="enderecoFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="paisFaturamento">País</label>
                        <input type="text" class="form-control" name="paisFaturamento" id="paisFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cidadeFaturamento">Cidade</label>
                        <input type="text" class="form-control" name="cidadeFaturamento" id="cidadeFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="estadoFaturamento">Estado</label>
                        <input type="text" class="form-control" name="estadoFaturamento" id="estadoFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="cepFaturamento">CEP</label>
                        <input type="text" class="form-control" name="cepFaturamento" id="cepFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                    <div class="form-group col-md-8">
                        <label for="emailFaturamento">Emails</label>
                        <input type="text" class="form-control" name="emailFaturamento" id="emailFaturamento"
                               onchange="javascript:retiraErrorCliente()"
                        />
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <hr>
                        <input type="button" class="btn btn-primary " value="Cadastrar Cliente"
                               onClick="javascript:sendPost('Cliente_sp/create','fCCreate')"

                        />
                               <!--onmouseover="javascript:verificaCamposUsuario()"-->

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
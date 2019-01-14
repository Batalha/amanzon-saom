<div class="container1">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Lista de Clientes</div>
        </div>
        <div class="panel-body cliente">

            <!--tbLista esta adicionado no arquivo funcGlobal.php-->
            <table class="table table-striped tbLista tableCliente">
                <thead>
                <!--<th>id</th>-->
                <th>Empresa</th>
                <th>Prefixo</th>
                <th>Telefone</th>
                <th>CNPJ</th>
                <!--<th>Endeço</th>-->
                <!--<th>País</th>-->
                <!--<th>Cidade</th>-->
                <!--<th>Estado</th>-->
                <!--<th>CEP</th>-->
                <th>Email</th>
                <th>Açoes</th>
                </thead>
                <tbody>
                {foreach from=$arr item=obj}
                <tr class="{$rowCss}">
                    <!--<td >{if isset($obj.idcliente)}{$obj.idcliente}{/if}</td>-->
                    <td >{if isset($obj.empresa)}{$obj.empresa}{/if}</td>
                    <td >{if isset($obj.prefixo)}{$obj.prefixo}{/if}</td>
                    <td >{if isset($obj.contatoFaturamento)}{$obj.contatoFaturamento}{/if}</td>
                    <td >{if isset($obj.cnpjFaturamento)}{$obj.cnpjFaturamento}{/if}</td>
                    <!--<td >{if isset($obj.enderecoFaturamento)}{$obj.enderecoFaturamento}{/if}</td>-->
                    <!--<td >{if isset($obj.paisFaturamento)}{$obj.paisFaturamento}{/if}</td>-->
                    <!--<td >{if isset($obj.cidadeFaturamento)}{$obj.cidadeFaturamento}{/if}</td>-->
                    <!--<td >{if isset($obj.estadoFaturamento)}{$obj.estadoFaturamento}{/if}</td>-->
                    <!--<td >{if isset($obj.cepFaturamento)}{$obj.cepFaturamento}{/if}</td>-->
                    <td >{if isset($obj.emailFaturamento)}{$obj.emailFaturamento}{/if}</td>
                    <td>
                        <button href="#cliente" class="btn btn-info" value="Views" onClick="javascript:getAjaxForm('Cliente_sp/view','conteudo',{ldelim}param:{$obj.idempresas},ajax:1{rdelim})">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </button>
                        <button type="button" class="btn btn-primary" value="Editar" onClick="javascript:getAjaxForm('Cliente_sp/edit',false,{ldelim}param:{$obj.idempresas},ajax:1{rdelim})">
                            <i class="glyphicon glyphicon-edit"></i>
                        </button>
                    </td>

                </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>



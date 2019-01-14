<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="usuario/submenu.tpl" title=submenu}
        </div>
    </div>
</div>
<br>
<div class="container1" style="width: 32%;">
        <form action="Usuario/edit" method="POST" id="fUsEdit" class="form" >
            <input type="hidden" name="idusuarios" id="idusuarios" value="{$obj.idusuarios}"/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title text-center">Edição de Senha</div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input class="form-control" type="password" name="senha" id="senha" placeholder="Senha Nova"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="password" class="form-control"
                                   onblur="javascript:if(this.value!=$('#senha').val())
                                   {literal}
                                           {simpleMsg('A Senha deve ser igual a Confirmação de Senha.')}
                                   {/literal}" name="confirma_senha" id="confirma_senha" placeholder="Confirma a Nova Senha"
                            />
                        </div>
                    </div>

                    <div class="row" align="center">
                        <div class="form-group">
                            <input type="button" class="btn btn-primary" value="Mudar Senha" onClick="javascript:sendPost('Usuario/editSenha','fUsEdit')" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
{*<center>*}
{*{include file="usuario/submenu.tpl" title=submenu}*}

{*<form action="Usuario/edit" method="POST" id="fUsEdit" class="form" >*}
    {*<input type="hidden" name="idusuarios" id="idusuarios" value="{$obj.idusuarios}"/>*}
    {**}
    {**}
    {*<h3>Edição de Senha</h3>*}
    {*<table class="table table-bordered table-striped formulario_cadastro_usuario">*}
        {*<tr>*}
            {*<td>*}
                {*<label for="senha">Senha Nova</label>*}
            {*</td>*}
            {*<td>*}
                {*<input type="password" name="senha" id="senha" size="30" />*}
            {*</td>*}
        {*</tr>*}
        {**}
        {*<tr>*}
            {*<td>*}
                {*<label for="confirma_senha">Confirme a Nova senha </label>*}
            {*</td>*}
            {*<td>*}
                {*<input *}
                	{*type="password" *}
                	{*onblur="javascript:if(this.value!=$('#senha').val()){literal}{simpleMsg('A Senha deve ser igual a Confirmação de Senha.')}{/literal}" *}
                	{*name="confirma_senha" id="confirma_senha" size="30"*}
                {*/>*}
            {*</td>        *}
        {*</tr>*}
    {*</table>*}

    {*<br />*}
    {**}
    {*<center>*}
    	{*<input type="button" value="Mudar Senha" onClick="javascript:sendPost('Usuario/editSenha','fUsEdit')" />*}
    {*</center>*}
{*</form>*}
{*</center>*}
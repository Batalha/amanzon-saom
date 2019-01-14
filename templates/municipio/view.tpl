<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="municipio/submenu.tpl" title=submenu}
        </div>
    </div>
</div>

<div class="container1" style="width: 30%;">
    <form action="Municipio/delete" id="formApagaMunicipio" name="formApagaMunicipio" method="POST" >
        <input type="hidden" name="idmunicipios" id="idmunicipios" value="{$obj.idmunicipios}" />
        <input type="hidden" name="municipio" id="municipio" value="{$obj.municipio}" />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Municipio</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        Municipio :  {$obj.municipio}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        Descriçao do Plano  : {$obj.macroregiao}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        {if $login.perfis_idperfis != 3}
                            <button type="button" class="btn-primary"
                                    onClick="javascript:getAjaxForm('Municipio/edit',false,{ldelim}param:{$obj.idmunicipios},ajax:1{rdelim})">
                                Editar
                            </button>
                            <button type="button" class="btn-danger" onclick="javascript:sendPost('Municipio/delete','formApagaMunicipio')">
                                Excluir
                            </button>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        </form>
</div>

{*<center>*}
{*{include file="municipio/submenu.tpl" title=submenu}*}
{*<form action="Instalacao/edit" method="PobjT" id="FobjCreate" class="form" >*}
     {*<fieldset>*}
            {*<legend>Município</legend>*}
            {*<br />*}
    {*<div style="float:left; margin-right:5px; padding:5px;width:50%">*}
        {**}
        {*<table class="tbForm">*}
             {**}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="municipio">Município</label>*}
                {*</td>*}
                {*<td>*}
                  {*{$obj.municipio}*}
                {*</td>        *}
            {*</tr>    *}
             {*<tr>    *}
                {*<td>*}
                    {*<label for="macroregiao">Descrição do Plano</label>*}
                {*</td>*}
                {*<td>*}
                    {*{$obj.macroregiao}*}
                {*</td>        *}
            {*</tr>    *}
                    {**}
        {*</table>*}
        {*<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>*}
    {*</fieldset> *}
    {*<br />*}
    {**}
    {*{if $login.perfis_idperfis != 3}*}
        {*<center>*}
        	{*<input type="button" value="Editar Municipio" onClick="javascript:getAjaxForm('Municipio/edit',false,{ldelim}param:{$obj.idmunicipios},ajax:1{rdelim})" />*}
        	{*<input type="button" value="Apagar" onclick="javascript:sendPost('Municipio/delete','formApagaMunicipio')" />*}
        {*</center>*}
    {*{/if}*}
        {**}
{*</form>*}

{*<form action="Municipio/delete" id="formApagaMunicipio" name="formApagaMunicipio" method="POST" >*}
	{*<input type="hidden" name="idmunicipios" id="idmunicipios" value="{$obj.idmunicipios}" />*}
	{*<input type="hidden" name="municipio" id="municipio" value="{$obj.municipio}" />*}
{*</form>*}
{*</center>*}
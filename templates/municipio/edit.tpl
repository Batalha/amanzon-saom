<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="municipio/submenu.tpl" title=submenu}
        </div>
    </div>
</div>

<div class="container" style="width: 30%;">
    <form action="Municipio/create" method="POST" id="fMacroCreate" class="form" >
        <input type="hidden" name="idmunicipios" value="{$obj.idmunicipios}" />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Editar Municipio</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <input class="form-control autosave_municipios" type="text" name="municipio" id="municipio" value="{$obj.municipio}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <input class="form-control autosave_municipios" type="text" name="macroregiao" id="macroregiao" value="{$obj.macroregiao}"  />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-primary" onClick="javascript:sendPost('Municipio/edit','fMacroCreate')">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{*<center>*}
{*{include file="municipio/submenu.tpl" title=submenu}*}
{*<form action="Municipio/create" method="POST" id="fMacroCreate" class="form" >*}
    {*<input type="hidden" name="idmunicipios" value="{$obj.idmunicipios}" />*}
    {*<fieldset>*}
    	{*<legend>Editar Município</legend>*}
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
                    {*<input class="autosave_municipios" type="text" name="municipio" id="municipio" value="{$obj.municipio}" />*}
                {*</td>        *}
            {*</tr>    *}
             {*<tr>    *}
                {*<td>*}
                    {*<label for="macroregiao">Descrição do Plano</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input class="autosave_municipios" type="text" name="macroregiao" id="macroregiao" value="{$obj.macroregiao}"  />*}
                {*</td>        *}
            {*</tr>    *}
                    {**}
        {*</table>*}
		{*<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>*}
         {**}
     {*</fieldset>       *}
    {*</div>*}
    {*<br />*}
    {*<center><input type="button" value="Enviar" onClick="javascript:sendPost('Municipio/edit','fMacroCreate')" /></center>*}
{*</form>*}
{*</center>*}
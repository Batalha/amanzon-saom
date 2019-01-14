<br>


<div class="container1" style="width: 65%;">
    <form action="Instalacao/create" method="POST" id="fInsEdit" class="form" >
        <input type="hidden" name="idinstalacoes" id="idinstalacoes" value="{$obj.idinstalacoes}"/>
        <input type="hidden" name="os_idos" id="os_idos" value="{$obj.os_idos}" />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Dados da Instalação</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao" type="text" name="nome" id="nome" value="{$obj.nome}">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select class="form-control autosave_instalacao" name="planos_idplanos" id="planos_idplanos">
                                <option value='1' {if $obj.planos_idplanos == 1}selected{/if}>Plano Básico</option>
                                <option value='2' {if $obj.planos_idplanos == 2}selected{/if}>Plano Clássico</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao" type="text" name="mac" id="mac" alt="mac" value="{$obj.mac}"placeholder="MAC"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao" type="text" name="azimute" id="azimute" value="{$obj.azimute}" placeholder="Azimute"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao" type="text" name="elevacao" id="elevacao" value="{$obj.elevacao}" placeholder="Elevação"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao" type="text" name="cod_area" id="cod_area" value="{$obj.cod_area}" placeholder="Codigo de Area"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" name="nsodu" id="nsodu" class="form-control autosave_instalacao" value="{$obj.nsodu}" placeholder="Nº Serie ODU"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="odu" id="odu" class="form-control autosave_instalacao">
                                <option value="">Escolha uma opção</option>
                                {foreach from=$tipoEquipamentos item=tipoEquipamento}
                                    <option value="{$tipoEquipamento.idtipo_equipamentos}" {if $obj.odu == $tipoEquipamento.idtipo_equipamentos}selected{/if}>{$tipoEquipamento.nome}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" id="os_iplan" name="os_iplan" class='form-control autosave_instalacao' value="{$obj.os_iplan}" placeholder="Ip Lan"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" id="os_ipdvb" name="os_ipdvb" class='form-control autosave_instalacao' value="{$obj.os_ipdvb}" placeholder="Ip DVB"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="buc" id="buc" class="form-control autosave_instalacao">
                                <option value="Satlink 4033" {if $obj.buc == "Satlink 4033"} selected {/if}>Satlink 4033</option>
                                <option value="Satlink 4035" {if $obj.buc == "Satlink 4035"} selected {/if}>Satlink 4035</option>
                                <option value="Invacom 2W"   {if $obj.buc == "Invacom 2W"} selected {/if}>Invacom 2W</option>
                                <option value="Norsat 2W"   {if $obj.buc == "Norsat 2W"} selected {/if}>Norsat 2W</option>
                                <option value="Advantec 2W" {if $obj.buc == "Advantec 2W"} selected {/if}>Advantec 2W</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="lnb" id="lnb" class="form-control autosave_instalacao">
                                <option value="Satlink 4033" {if $obj.lnb == "Satlink 4033"} selected {/if}>Satlink 4033</option>
                                <option value="Satlink 4035" {if $obj.lnb  == "Satlink 4035"} selected {/if}>Satlink 4035</option>
                                <option value="Invacom 2W"   {if $obj.lnb  == "Invacom 2W"} selected {/if}>Invacom 2W</option>
                                <option value="Norsat 2W"   {if $obj.lnb == "Norsat 2W"} selected {/if}>Norsat 2W</option>
                                <option value="Advantec 2W" {if $obj.lnb  == "Advantec 2W"} selected {/if}>Advantec 2W</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="tipo_IDU" class="form-control autosave_instalacao" id="tipo_IDU">
                                <option value="Satlink 2000" {if $obj.tipo_IDU == "Satlink 2000"} selected {/if}>Satlink 2000</option>
                                <option value="Satlink 1900" {if $obj.tipo_IDU == "Satlink 1900"} selected {/if}>Satlink 1900</option>
                                <option value="Satlink 1901" {if $obj.tipo_IDU == "Satlink 1901"} selected {/if}>Satlink 1901</option>
                                <option value="Satlink 1902" {if $obj.tipo_IDU == "Satlink 1902"} selected {/if}>Satlink 1902</option>
                                <option value="Satlink 1910" {if $obj.tipo_IDU == "Satlink 1910"} selected {/if}>Satlink 1910</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">

                            <input class="form-control autosave_instalacao" type="text" name="cod_anatel" id="cod_anatel" value="{$obj.cod_anatel}" placeholder="Codigo Anatel"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="antena" id="antena" class="form-control autosave_instalacao" >
                                <option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>
                                <option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>
                                <option value='Brasil Sat' {if $obj.antena == 'Brasil Sat'} selected {/if}> Brasil Sat</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">

                            <select name="antena_tam" id="antena_tam" class="form-control autosave_instalacao" >
                                <option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>
                                <option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" name="antena_ns" id="antena_ns"  class="form-control autosave_instalacao" value="{$obj.antena_ns}" placeholder="Nº de Serie"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Testou o satLink 2000?">
                            <span class="input-group-addon">
                                <input class="autosave_instalacao" type="checkbox" name="test_sl2000" id="test_sl2000"{if $obj.test_sl2000} checked  {/if} />
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Vsat foi criada no WEBNMS?">
                            <span class="input-group-addon">
                                <input class="autosave_instalacao" type="checkbox" name="webnms" id="webnms"   {if $obj.webnms} checked  {/if} />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Vsat foi criada no PacketShapper?">
                            <span class="input-group-addon">
                            {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}
                                <input class="autosave_instalacao" type="checkbox" name="packetshapper" id="packetshapper"   {if $obj.packetshapper}  checked{/if} />{else}<input type="hidden" name="packetshapper" id="packetshapper" value="{$obj.packetshapper}" />
                            {/if}

                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Registro de licença?">
                            <span class="input-group-addon">
                                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}
                                    <input class="autosave_instalacao" type="checkbox" name="reglicenca" id="reglicenca"   {if $obj.reglicenca}  checked{/if} />{else}<input type="hidden" name="reglicenca" id="reglicenca" value="{$obj.reglicenca}" />
                                {/if}
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Cadastro no Opmanager?">
                            <span class="input-group-addon">
                                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}
                                    <input class="autosave_instalacao" type="checkbox" name="opmanager" id="opmanager"   {if $obj.opmanager}  checked{/if} />{else}<input type="hidden" name="opmanager" id="opmanager" value="{$obj.opmanager}" />
                                {/if}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input class="form-control" type="text" name="data_ativacao" id="data_ativacao" value="{$obj.data_ativacao}" placeholder="Data de Ativação"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <div class="">
                            <input class="form-control autosave_instalacao" type="text" name="analista_prodemge" id="analista_prodemge" value="{$obj.analista_prodemge}" placeholder="Analista Prodemge"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <textarea class="form-control autosave_instalacao" name="obs" id="obs">{$obj.obs}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="button" class="btn btn-primary" value="Salvar" onClick="javascript:sendPost('Instalacao/edit','fInsEdit')" />
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>











{*<center>*}
{*{include file="OS/submenu.tpl" title=submenu}*}

{*<form action="Instalacao/create" method="POST" id="fInsEdit" class="form" >*}
    {*<input type="hidden" name="idinstalacoes" id="idinstalacoes" value="{$obj.idinstalacoes}"/>*}
    {*<input type="hidden" name="os_idos" id="os_idos" value="{$obj.os_idos}" />*}
    {*<fieldset>*}
        {*<legend>Dados da Instalação</legend>*}
    {*<table class="tbForm">*}
          {**}
        {*<tr>*}
            {*<td>*}
                {*<label>Nome</label>*}
            {*</td>*}
            {*<td>*}
               {*<b> {$obj.nome}</b>*}
            {*</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td>*}
                {*<label>Plano</label>*}
            {*</td>*}
            {*<td>*}
                {*<select class="autosave_instalacao" name="planos_idplanos">*}
                    {*<option value='1' {if $obj.planos_idplanos == 1}selected{/if}>Plano Básico</option>*}
                    {*<option value='2' {if $obj.planos_idplanos == 2}selected{/if}>Plano Clássico</option>*}
                {*</select>*}
            {*</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td>*}
                {*<label for="mac">MAC</label>*}
            {*</td>*}
            {*<td>*}
                {*<input class="autosave_instalacao" type="text" name="mac" id="mac" alt="mac" size="30" value="{$obj.mac}"/>*}
            {*</td>*}

            {*<td>*}
                {*<label for="azimute">Azimute </label>*}
            {*</td>*}
            {*<td>*}
                {*<input class="autosave_instalacao" type="text" name="azimute" id="azimute" alt="mac" size="30" value="{$obj.mac}" />*}
            {*</td>        *}
        {*</tr>*}
        {**}
        {*<tr>    *}
            {*<td>*}
                {*<label for="elevacao">Elevação </label>*}
            {*</td>*}
            {*<td>*}
                {*<input class="autosave_instalacao" type="text" name="elevacao" id="elevacao" size="10" value="{$obj.elevacao}" />*}
            {*</td>*}
            {*<td>*}
                {*<label for="cod_area">Código de Área </label>*}
            {*</td>*}
            {*<td>*}
                {*<input class="autosave_instalacao" type="text" name="cod_area" id="cod_area" size="5" value="{$obj.cod_area}" />*}
            {*</td>*}

        {*</tr>*}
        {*<tr>    *}
                {*<td>*}
                    {*<label for="odu">ODU </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="odu" id="odu" class="inputReq autosave_instalacao">*}
                    	{*<option value="">Escolha uma opção</option>*}
                    	{*{foreach from=$tipoEquipamentos item=tipoEquipamento}*}
                    		{*<option value="{$tipoEquipamento.idtipo_equipamentos}" {if $obj.odu == $tipoEquipamento.idtipo_equipamentos}selected{/if}>{$tipoEquipamento.nome}</option>*}
                    	{*{/foreach}*}
                    {*</select>*}
                {*</td>*}

        {*</tr>*}
          {*<tr>    *}
                {*<td>*}
                    {*<label for="nsodu">N° Serie ODU </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsodu" id="nsodu" size="30" class="inputReq autosave_instalacao" value="{$obj.nsodu}" />*}
                {*</td>*}

        {*</tr>*}
        {**}
        {*<tr>*}
        	{*<td>*}
                {*<label for="ipLan" > Ip Lan </label>*}
            {*</td>*}
            {*<td>*}
                {*<input type="text" id="os_iplan" name="os_iplan" class='inputReq autosave_instalacao' value="{$obj.os_iplan}" />*}
            {*</td>*}
            {**}
            {*<td>*}
                {*<label for="ipdvb" > Ip DVB </label>*}
            {*</td>*}
            {*<td>*}
                {*<input type="text" id="os_ipdvb" name="os_ipdvb" class='inputReq autosave_instalacao' value="{$obj.os_ipdvb}" />*}
            {*</td>*}
        {*</tr>*}
        {**}
        {*<tr>*}
                {*<td>*}
                {*<label for="buc"> BUC </label>*}
            {*</td>*}
            {*<td>*}
                {*<select name="buc" id="buc" class="autosave_instalacao">*}
                    {*<option value="Satlink 4033" {if $obj.buc == "Satlink 4033"} selected {/if}>Satlink 4033</option>*}
                    {*<option value="Satlink 4035" {if $obj.buc == "Satlink 4035"} selected {/if}>Satlink 4035</option>*}
                    {*<option value="Invacom 2W"   {if $obj.buc == "Invacom 2W"} selected {/if}>Invacom 2W</option>*}
                    {*<option value="Norsat 2W"   {if $obj.buc == "Norsat 2W"} selected {/if}>Norsat 2W</option>*}
                    {*<option value="Advantec 2W" {if $obj.buc == "Advantec 2W"} selected {/if}>Advantec 2W</option>*}
		{*</select>*}
            {*</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td>*}
                {*<label for="lnb"> LNB </label>*}
            {*</td>*}
            {*<td>*}
                {*<select name="lnb" id="lnb" class="autosave_instalacao">*}
                    {*<option value="Satlink 4033" {if $obj.lnb == "Satlink 4033"} selected {/if}>Satlink 4033</option>*}
                    {*<option value="Satlink 4035" {if $obj.lnb  == "Satlink 4035"} selected {/if}>Satlink 4035</option>*}
                    {*<option value="Invacom 2W"   {if $obj.lnb  == "Invacom 2W"} selected {/if}>Invacom 2W</option>*}
                    {*<option value="Norsat 2W"   {if $obj.lnb == "Norsat 2W"} selected {/if}>Norsat 2W</option>*}
                    {*<option value="Advantec 2W" {if $obj.lnb  == "Advantec 2W"} selected {/if}>Advantec 2W</option>*}
				{*</select>*}
            {*</td>*}
            {*<td>*}
                {*<label for="tipo_IDU">Tipo IDU</label>*}
            {*</td>*}
            {*<td>*}
                {*<select name="tipo_IDU" class="autosave_instalacao">*}
                    {*<option value="Satlink 2000" {if $obj.tipo_IDU == "Satlink 2000"} selected {/if}>Satlink 2000</option>*}
                    {*<option value="Satlink 1900" {if $obj.tipo_IDU == "Satlink 1900"} selected {/if}>Satlink 1900</option>*}
                    {*<option value="Satlink 1901" {if $obj.tipo_IDU == "Satlink 1901"} selected {/if}>Satlink 1901</option>*}
                    {*<option value="Satlink 1902" {if $obj.tipo_IDU == "Satlink 1902"} selected {/if}>Satlink 1902</option>*}
                    {*<option value="Satlink 1910" {if $obj.tipo_IDU == "Satlink 1910"} selected {/if}>Satlink 1910</option>*}
                {*</select>   *}
            {*</td>      *}
        {*</tr>*}
        {*<tr>*}
            {*<td>*}
                {*<label for="cod_anatel">Cód. Anatel </label>*}
            {*</td>*}
            {*<td>*}
                {*<input class="autosave_instalacao" type="text" name="cod_anatel" id="cod_anatel" value="{$obj.cod_anatel}" />*}
            {*</td>*}

        {*</tr>*}
         {*<tr>*}
                {*<td >*}
                    {*<label for="antena">Antena:</label>*}
                {*</td>*}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena" >Marca </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena" id="antena" class="inputReq autosave_instalacao" >*}
                        {*<option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>*}
                        {*<option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>*}
                        {*<option value='Brasil Sat' {if $obj.antena == 'Brasil Sat'} selected {/if}> Brasil Sat</option>*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena_tam">Tamanho </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena_tam" id="antena_tam" class="inputReq autosave_instalacao" >*}
                        {*<option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>*}
                        {*<option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena_ns">N° Série </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="antena_ns" id="antena_ns" size="30" class="inputReq autosave_instalacao" value="{$obj.antena_ns}"  />*}
                {*</td>*}

        {*</tr>*}
        {*<tr>*}
        	{*<td>&nbsp;</td>*}
        {*</tr>*}
        {**}
        {*<tr>*}
        	{*<td class='tdRed'>*}
            	{*<label for="test_sl2000"><b>Testou Sat Link 2000?</b></label>*}
            {*</td>*}
            {*<td class='tdRed'>*}
            	{*<input class="autosave_instalacao" type="checkbox" name="test_sl2000" id="test_sl2000"   {if $obj.test_sl2000} checked  {/if} />*}
            {*</td>*}
        {*</tr>*}
            {**}
		{*<tr>*}
        	{*<td class='tdRed'>*}
            	{*<label for="nms"><b>Vsat foi criada no WEBNMS?</b></label>*}
            {*</td>*}
            {*<td class='tdRed'>*}
            	{*<input class="autosave_instalacao" type="checkbox" name="webnms" id="webnms"   {if $obj.webnms} checked  {/if} />*}
            {*</td>*}
        {*</tr>*}
         {**}
         {**}
		{*<!-- PERMISSOES NECESSÁRIAS -->*}
		{**}
	        {*<tr>*}
	             {*<td class='tdRed'>*}
	                 {*<label for="nms"><b>Vsat foi criada no PacketShapper?</b></label>*}
	             {*</td>*}
	             {*<td class='tdRed' >*}
	                {*{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}  *}
	                	{*<input class="autosave_instalacao" type="checkbox" name="packetshapper" id="packetshapper"   {if $obj.packetshapper}  checked{/if} />{else}<input type="hidden" name="packetshapper" id="packetshapper" value="{$obj.packetshapper}" />*}
	                {*{/if} * PermissÃ£o - NOC*}
	             {*</td>*}
	         {*</tr>*}
	         {*<tr>*}
	             {*<td class='tdRed'>*}
	                 {*<label for="nms"><b>Registro de licença?</b></label>*}
	             {*</td>*}
	             {*<td class='tdRed' >*}
	                {*{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}  *}
	                	{*<input class="autosave_instalacao" type="checkbox" name="reglicenca" id="reglicenca"   {if $obj.reglicenca}  checked{/if} />{else}<input type="hidden" name="reglicenca" id="reglicenca" value="{$obj.reglicenca}" />*}
	                {*{/if} * PermissÃ£o - NOC*}
	             {*</td>*}
	         {*</tr>*}
	         {*<tr>*}
	             {*<td class='tdRed'>*}
	                 {*<label for="nms"><b>Cadastro no Opmanager?</b></label>*}
	             {*</td>*}
	             {*<td class='tdRed' >*}
	                {*{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}  *}
	                	{*<input class="autosave_instalacao" type="checkbox" name="opmanager" id="opmanager"   {if $obj.opmanager}  checked{/if} />{else}<input type="hidden" name="opmanager" id="opmanager" value="{$obj.opmanager}" />*}
	                {*{/if} * PermissÃ£o - NOC*}
	             {*</td>*}
	         {*</tr>*}
	         {*<tr>*}
	             {*<td class='tdRed'>*}
	                 {*<label for="nms"><b>Cadastro no Nagios?</b></label>*}
	             {*</td>*}
	             {*<td class='tdRed' >*}
	                {*{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}  *}
	                	{*<input class="autosave_instalacao" type="checkbox" name="test_prtg" id="test_prtg"   {if $obj.test_prtg}  checked{/if} />{else}<input type="hidden" name="prtg" id="prtg" value="{$obj.prtg}" />*}
	                {*{/if} * PermissÃ£o - NOC*}
	             {*</td>*}
	         {*</tr>*}
	         {**}
	     {*<!-- PERMISSOES NECESSÁRIAS -->*}
	     {**}
         {**}
         {*<!-- *}
         {*<tr>*}
             {*<td class='tdRed'>*}
                 {*<label for="nms"><b>Data do Aceite PRODEMGE</b></label>*}
             {*</td>*}
             {*<td class='tdRed' >*}
                {*<input type="text" name="data_aceite" id="data_aceite" value="{$obj.data_aceite}" size="10"/>*}
             {*</td>*}
         {*</tr>*}
         {*-->*}
          {**}
         {*<tr>*}
             {*<td class='tdRed'>*}
                 {*<label for="analista_prodemge"><b>Analista Prodemge</b></label>*}
             {*</td>*}
             {*<td class='tdRed' >*}
                {*<input class="autosave_instalacao" type="text" name="analista_prodemge" id="analista_prodemge" value="{$obj.analista_prodemge}" size="40"/>*}
             {*</td>*}
         {*</tr>*}
         {*<tr>*}
             {*<td class='tdRed'>*}
                 {*<label for="data_ativacao"><b>Data Ativação</b></label>*}
             {*</td>*}
             {*<td class='tdRed' >*}
                {*<input class="autosave_instalacao" type="text" name="data_ativacao" id="data_ativacao" value="{$obj.data_ativacao}" size="10"/>*}
             {*</td>*}
         {*</tr>*}
        {*<!-- *}
        {*<tr>*}
        	{*<td class='tdRed'>*}
            	{*<label for="sat_vsat_code"><b>Sat Vsat Code:</b></label>*}
            {*</td>*}
            {*<td class='tdRed' >*}
            	{*<input type="text" name="sat_vsat_code" id="sat_vsat_code" value="{$obj.sat_vsat_code}" size="10"/>*}
            {*</td>*}
		{*</tr>*}
		{*-->*}
        {*<tr >*}
            {*<td >*}
                {*<label for="obs" >Observações </label>*}
            {*</td>*}
            {*<td>*}
                {*<textarea class="autosave_instalacao" name="obs" id="obs"  cols="40">{$obj.obs}</textarea>*}
            {*</td>*}

        {*</tr>*}
    {*</table>*}
             {*<div class="divObs"> * Campos marcados em vermelho sÃ£o obrigatórios.</div>*}
    {*</fieldset>*}
    {*<br />*}
    {*<center><input type="button" value="Salvar" onClick="javascript:sendPost('Instalacao/edit','fInsEdit')" /></center>*}
{*</form>*}

{*</center>*}

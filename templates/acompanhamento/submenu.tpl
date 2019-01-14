
<div class="btn-group">
	<span class="btn btn-inverse" style="width:155px;text-align:right;">Acompanhamentos:&nbsp;</span>
	{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 2 }
		<input class="btn btn-info" type="button" id="acompanhamentocom" value=" COM" onclick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCom')">
	{/if}

	{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 }
		<input class="btn btn-info" type="button" id="acompanhamentonoc" value=" NOC" onclick="javascript:getAjaxForm('Acompanhamento/acompanhamentoNoc')">
	{/if}
	<!-- || $login.perfis_idperfis == 3 -->
	{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 3}
		<input class="btn btn-info" type="button" id="acompanhamentocampo" value=" Campo" onclick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCampo')">
	{/if}

</div>
<div hidden="">
	<a href="#acompanhamentocom" onClick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCom')">Acompanhamento COM</a>
	<a href="#acompanhamentonoc" onClick="javascript:getAjaxForm('Acompanhamento/acompanhamentoNoc')">Acompanhamento NOC</a>
	<a href="#acompanhamentocampo" onClick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCampo')">Acompanhamento Campo</a>

</div>

{*<ul class="submenu">*}
	{*{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 2 }*}
		{*<li><input class="btn" type="button" id="acompanhamentocom" value="Acompanhamento COM" onclick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCom')"></li>*}
	{*{/if}*}

 	{*{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 }*}
		{*<li><input class="btn" type="button" id="acompanhamentonoc" value="Acompanhamento NOC" onclick="javascript:getAjaxForm('Acompanhamento/acompanhamentoNoc')"></li>*}

	{*{/if}*}

	{*<!-- || $login.perfis_idperfis == 3 --> *}
	{*{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 3}*}
		{*<li><input class="btn" type="button" id="acompanhamentocampo" value="Acompanhamento Campo" onclick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCampo')"></li>*}
	{*{/if}*}

{*</ul>*}
{*<br />*}

{*<div hidden="">*}
{*<a href="#acompanhamentocom" onClick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCom')">Acompanhamento COM</a>*}
{*<a href="#acompanhamentonoc" onClick="javascript:getAjaxForm('Acompanhamento/acompanhamentoNoc')">Acompanhamento NOC</a>*}
{*<a href="#acompanhamentocampo" onClick="javascript:getAjaxForm('Acompanhamento/acompanhamentoCampo')">Acompanhamento Campo</a>*}

{*</div>*}
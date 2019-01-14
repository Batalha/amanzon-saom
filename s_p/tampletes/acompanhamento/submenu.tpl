
<div class="btn-group">
	<span class="btn btn-inverse" style="width:155px;text-align:right;">Acompanhamentos :&nbsp;</span>
	{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 2}
		<input class="btn btn-primary" type="button" id="acompanhamentocom" value=" COM" onclick="javascript:getAjaxForm('Acompanhamento_sp/acompanhamentoCom')">
	{/if}

 	{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 10 }
		<input class="btn btn-primary" type="button" id="acompanhamentonoc" value=" NOC" onclick="javascript:getAjaxForm('Acompanhamento_sp/acompanhamentoNoc')">
	{/if}
	<!-- || $login.perfis_idperfis == 3 --> 
	{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 3}
		<input class="btn btn-primary" type="button" id="acompanhamentocampo" value=" Campo" onclick="javascript:getAjaxForm('Acompanhamento_sp/acompanhamentoCampo')">
	{/if}

</div>
<br />

<div hidden="">
<a href="#acompanhamentocom" onClick="javascript:getAjaxForm('Acompanhamento_sp/acompanhamentoCom')">Acompanhamento COM</a>
<a href="#acompanhamentonoc" onClick="javascript:getAjaxForm('Acompanhamento_sp/acompanhamentoNoc')">Acompanhamento NOC</a>
<a href="#acompanhamentocampo" onClick="javascript:getAjaxForm('Acompanhamento_sp/acompanhamentoCampo')">Acompanhamento Campo</a>

</div>
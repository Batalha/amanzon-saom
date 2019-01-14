<div class="btn-group">
    <span class="btn btn-inverse" style="width:150px;text-align:right;">Municipios:&nbsp;</span>
    <a href="#listamunicipios" class="btn btn-info" onClick="javascript:getAjaxForm('Municipio/liste')">Municipios</a>
    
    {if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5}
    	<a href="#novomunicipio"  class="btn btn-info" onClick="javascript:getAjaxForm('Municipio/create')">Cadastrar novo município</a>
    {/if}
    
</div>
<br />
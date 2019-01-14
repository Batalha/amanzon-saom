<ul class="submenu">
    
    <li><a href="#listamunicipiossp" onClick="javascript:getAjaxForm('Municipio_sp/liste')">Municipios</a></li>
    
    {if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5}
    	<li><a href="#novomunicipiosp" onClick="javascript:getAjaxForm('Municipio_sp/create')">Cadastrar novo município</a></li>
    {/if}
    
</ul>
<br />
<center>
{include file="s_p/tampletes/municipio/submenu.tpl" title=submenu}
<form action="Instalacao_sp/edit" method="PobjT" id="FobjCreate" class="form" >
     <fieldset>
            <legend>Município</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="municipio">Município</label>
                </td>
                <td>
                  {$obj.municipio}
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="macroregiao">Descrição do Plano</label>
                </td>
                <td>
                    {$obj.macroregiao}
                </td>        
            </tr>    
                    
        </table>
        <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
    </fieldset> 
    <br />
    
    {if $login.perfis_idperfis != 3}
        <center>
        	<input type="button" value="Editar Municipio" onClick="javascript:getAjaxForm('Municipio_sp/edit',false,{ldelim}param:{$obj.idmunicipios_sp},ajax:1{rdelim})" />
        	<input type="button" value="Apagar" onclick="javascript:sendPost('Municipio_sp/delete','formApagaMunicipio')" />
        </center>
    {/if}
        
</form>

<form action="Municipio/delete" id="formApagaMunicipio" name="formApagaMunicipio" method="POST" >
	<input type="hidden" name="idmunicipios_sp" id="idmunicipios_sp" value="{$obj.idmunicipios_sp}" />
	<input type="hidden" name="municipio" id="municipio" value="{$obj.municipio}" />
</form>
</center>
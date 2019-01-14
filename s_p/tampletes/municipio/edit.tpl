<center>
{include file="s_p/tampletes/municipio/submenu.tpl" title=submenu}
<form action="Municipio_sp/create" method="POST" id="fMacroCreate" class="form" >
    <input type="hidden" name="idmunicipios_sp" value="{$obj.idmunicipios_sp}" />
    <fieldset>
    	<legend>Editar Município</legend>
    	<br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="municipio">Município</label>
                </td>
                <td>
                    <input class="autosave_municipios_sp" type="text" name="municipio" id="municipio" value="{$obj.municipio}" />
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="macroregiao">Descrição do Plano</label>
                </td>
                <td>
                    <input class="autosave_municipios_sp" type="text" name="macroregiao" id="macroregiao" value="{$obj.macroregiao}"  />
                </td>        
            </tr>    
                    
        </table>
		<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
         
     </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Enviar" onClick="javascript:sendPost('Municipio_sp/edit','fMacroCreate')" /></center>
</form>
</center>
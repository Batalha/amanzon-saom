<center>
{include file="s_p/tampletes/municipio/submenu.tpl" title=submenu}
<form action="Municipio_sp/create" method="POST" id="fMacroCreate" class="form" >
    
    <fieldset>
    
		<legend>Cadastrar Município</legend>
		<br />
    
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="municipio">Município</label>
                </td>
                <td>
                    <input type="text" name="municipio" id="municipio" />
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="macroregiao">Macroregião</label>
                </td>
                <td>
                    <input type="text" name="macroregiao" id="macroregiao" />
                </td>        
            </tr>    
                    
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
            
    </div>
    
    </fieldset>
    <br />
    
    <center>
    	<input type="button" value="Enviar" onClick="javascript:sendPost('Municipio/create','fMacroCreate')" />
    </center>
    
</form>
</center>

<form action="Cronometro/pausaCronometro" method="POST" id="cronometroEdit" class="form" >
	<input type="hidden" name="cronometro_idcronometro" id="cronometro_idcronometro" value="{$cronometro.idcronometro}"/>
    
    <fieldset>
    
    <legend>Editar Pausa do Cronômetro</legend>
    <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
               
            <tr>    
                <td>
                    <label for="hora_comeco">Hora começo:</label>
                </td>
                <td>
                    <input type="text" readonly="readonly" name="hora_comeco" id="hora_comeco" value="{$cronometro.hora_comeco}" />
                </td>        
            </tr>
             <tr>    
                <td>
                    <label for="motivo">Motivo:</label>
                </td>
                <td>
                    <textarea name="motivo" id="motivo" cols="30" rows="6" >{$cronometro.motivo}</textarea>
                </td>        
            </tr>             
        </table>
		<div class="divObs"></div>
    
    </fieldset>       
    
    </div>
    <br />
    <center><input type="button" value="Despausar" onclick="javascript:despausarCronometro('{$cronometro.idcronometro_interrupcao}')" />&nbsp;&nbsp;&nbsp;<input type="button" value="Atualizar" onClick="javascript:sendPost('Cronometro_interrupcao/edit','cronometroEdit')" /></center>
</form>
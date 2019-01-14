
<form action="Cronometro/pausaCronometro" method="POST" id="cronometroEdit" class="form" >
	<input type="hidden" name="cronometro_idcronometro" id="cronometro_idcronometro" value="{$cronometro.idcronometro}"/>
    <fieldset>
            <legend>Editar Pausa do Cronômetro</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
               
            <tr>    
                <td>
                    <label for="hora_comeco">Data de Início</label>
                </td>
                <td>
                    <input type="text" readonly="readonly" name="hora_comeco" id="hora_comeco" value="{$horaAtual}" />
                </td>        
            </tr>
             <tr>    
                <td>
                    <label for="motivo">Motivo</label>
                </td>
                <td>
                    <textarea name="motivo" id="motivo" cols="30" rows="6" ></textarea>
                </td>        
            </tr>             
        </table>
         <div class="divObs"></div>
    </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Pausar" onClick="javascript:sendPost('Cronometro_interrupcao/create','cronometroEdit')" /></center>
</form>
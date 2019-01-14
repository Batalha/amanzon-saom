<center>
<form action="Cancelamento/create" method="POST" id="fCancelCreate" class="form" >
    <input type="hidden" name="instalacoes_idinstalacoes" id="instalacoes_idinstalacoes" value="{$param}"/>
    <fieldset>
            <legend>Solicitar Cancelamento</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
            <tr>
                <td>
                    <label for="motivo">Motivo do Cancelamento</label>
                </td>
                
            </tr>
            <tr>    
                <td>
                    <textarea id="motivo" name="motivo"  cols="60" rows="10" ></textarea>
                </td>
            </tr>                            
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
     </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Enviar" onClick="javascript:sendPost('Cancelamento/create','fCancelCreate')" /></center>
</form>
</center>
<center>
<form action="MudaPlan/create" method="POST" id="fMDPlanCreate" class="form" >
    
    <fieldset>
            <legend>Mudar Plano {$obj.nome}</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="plano">Plano Atual</label>
                    <input type="hidden" name="idplano_anterior" value="{$obj.rel.planos.idplanos}" />
                    <input type="hidden" name="instalacoes_idinstalacoes" value="{$obj.idinstalacoes}" />
                </td>
                <td>
                    {$obj.rel.planos.plano}
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="descricao">Mudar Para</label>
                </td>
                <td>
                   <select name="planos_idplanos" > 
                   {foreach from=$planos item=i}
                       <option value={$i.idplanos}>{$i.plano}</option>
                   {/foreach}    
                   </select>
                </td>        
            </tr>    
            <tr>    
                <td>
                    <label for="observacao">Observações</label>
                </td>
                <td>
                   <textarea name="observacao" cols="40" rows="7"></textarea>
                </td>        
            </tr>        
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
     </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Enviar" onClick="javascript:sendPost('MudaPlano/create','fMDPlanCreate')" /></center>
</form>
</center>
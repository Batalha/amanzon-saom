<center>
<form action="AgendaInstal/create" method="POST" id="fMPEdit" class="form" >
    
    <fieldset>
            <legend>Mudança de Perfil - {$obj.rel.instalacoes.nome}</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="plano">Plano Atual</label>
                    <input type="hidden" name="idmuda_plano" value="{$obj.idmuda_plano}" />
                    <input type="hidden" name="planos_idplano_anterior" value="{$obj.planos_idplano_anterior}" />
                    <input type="hidden" name="instalacoes_idinstalacoes" value="{$obj.instalacoes_idinstalacoes}" />
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
                       <option value={$i.idplanos} {if $obj.planos_idplanos == $i.idplanos} selected {/if}>{$i.plano}</option>
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
    <center><input type="button" value="Salvar" onClick="javascript:sendPost('MudaPlano/edit','fMPEdit')" /></center>
</form>
</center>

<form action="AgendaInstal/create" method="POST" id="fAtEdit" class="form" >
    <input type="hidden" name="idplanos" id="idplanos" value="{$obj.idplanos}"/>
    <fieldset>
            <legend>Editar Plano</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="plano">Nome do Plano</label>
                </td>
                <td>
                    <input type="text" name="plano" id="plano" value="{$obj.plano}" />
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="descricao">Descrição do Plano</label>
                </td>
                <td>
                    <textarea name="descricao" id="descricao" >{$obj.descricao}</textarea>
                </td>        
            </tr>    
                    
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
     </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Atualizar" onClick="javascript:sendPost('AtendVsat/edit','fAtEdit')" /></center>
</form>

<form action="Plan/create" method="POST" id="fPlanCreate" class="form" >
    
    <fieldset>
            <legend>Cadastrar Plano</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="plano">Nome do Plano</label>
                </td>
                <td>
                    <input type="text" name="plano" id="plano" />
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="descricao">Descrição do Plano</label>
                </td>
                <td>
                    <textarea name="descricao" id="descricao" cols='40' rows='8'></textarea>
                </td>        
            </tr>    
                    
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
     </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Enviar" onClick="javascript:sendPost('Plano/create','fPlanCreate')" /></center>
</form>
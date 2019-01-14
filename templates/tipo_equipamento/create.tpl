
<form action="TipoEquipamento/create" method="POST" id="fEqCreate" class="form" >
    
    <fieldset>
            <legend>Cadastrar Tipo de equipamento</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="nome">Nome</label>
                </td>
                <td>
                    <input type="text" name="nome" id="nome" />
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="descricao">Descrição</label>
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
    <center><input type="button" value="Enviar" onClick="javascript:sendPost('TipoEquipamento/create','fEqCreate')" /></center>
</form>
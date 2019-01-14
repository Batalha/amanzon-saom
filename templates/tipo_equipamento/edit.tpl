
<form action="TipoEquipamento/create" method="POST" id="fEqEdit" class="form" >
    <input type="hidden" name="idtipo_equipamentos" id="idtipo_equipamentos" value="{$obj.idtipo_equipamentos}"/>
    <fieldset>
            <legend>Editar Tipo de Equipamento</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        
        <table class="tbForm">
               
            <tr>    
                <td>
                    <label for="nome">Nome</label>
                </td>
                <td>
                    <input type="text" name="nome" id="nome" value="{$obj.nome}" />
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="descricao">Descrição</label>
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
    <center><input type="button" value="Salvar" onClick="javascript:sendPost('TipoEquipamento/edit','fEqEdit')" /></center>
</form>
<form action="Instalacao_sp/edit" method="PostT" id="FobjCreate" class="form" >
    <fieldset>
        <legend>Plano {$obj.plano}</legend>
             <table class="tbForm">
           <tr>    
                <td>
                    <label for="nome">Nome</label>
                </td>
                <td>
                   {$obj.nome}
                </td>        
            </tr>   
             <tr>    
                <td>
                    <label for="descricao">Descrição</label>
                </td>
                <td>
                    {$obj.descricao}
                </td>        
            </tr>    
        </table>

    </fieldset>
    <br />
    {if $login.perfis_idperfis != 3}
        
        <center>
            <input type="button" value="Editar Tipo de Equipamento" onClick="javascript:getAjaxForm('TipoEquipamento_sp/edit',false,{ldelim}param:{$obj.idtipo_equipamentos},ajax:1{rdelim})" />
        </center>
    {/if}    
</form>

<form action="Instalacao/edit" method="PobjT" id="FobjCreate" class="form" >
    <fieldset>
        <legend>Plano {$obj.plano}</legend>
             <table class="tbForm">
            <tr>    
                <td>
                    <label for="plano">Nome do Plano</label>
                </td>
                <td>
                  {$obj.plano}
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="descricao">Descrição do Plano</label>
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
            <input type="button" value="Editar Plano" onClick="javascript:getAjaxForm('Plano/edit',false,{ldelim}param:{$obj.idplanos},ajax:1{rdelim})" />
        </center>
    {/if}    
</form>

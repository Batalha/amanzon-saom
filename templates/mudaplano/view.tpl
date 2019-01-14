<center>
<form action="Instalacao/edit" method="PobjT" id="FobjCreate" class="form" >
    <fieldset>
        <legend>Mudança de Perfil - {$obj.rel.instalacoes.nome}</legend>
             <table class="tbForm">
            <tr>    
                <td>
                    <label for="plano">Plano Atual</label>
                </td>
                <td>
                  {$obj.rel.planos.plano}
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="planos_idplanos_anterior">Plano Anterior</label>
                </td>
                <td>
                    {$obj.rel.planos_aux.plano}
                </td>        
            </tr>  
            <tr>    
                <td>
                    <label for="observacao">Observações</label>
                </td>
                <td>
                    {$obj.observacao}
                </td>        
            </tr>
        </table>

    </fieldset>
    <br />
    {if $login.perfis_idperfis != 3}
        
        <center>
            <input type="button" value="Editar Mudança de Perfil" onClick="javascript:getAjaxForm('MudaPlano/edit',false,{ldelim}param:{$obj.idmuda_plano},ajax:1{rdelim})" />
        </center>
    {/if}    
</form>
</center>
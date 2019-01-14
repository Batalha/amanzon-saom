<center>
{include file="s_p/tampletes/equipamento/submenu.tpl" title=submenu}

<form action="Equipamento_sp/edit" method="Post" id="FobjCreate" class="form" >
      <table class="tbForm">
             
            <tr>    
                <td>
                    <label for="nome">Número de Série</label>
                </td>
                <td>
                    {$obj.sno}
                </td>        
            </tr>    
             <tr>    
                <td>
                    <label for="mac">MAC</label>
                </td>
                <td>
                   {$obj.mac}
                </td>        
            </tr>
             <tr>    
                <td>
                    <label for="mac">Observações</label>
                </td>
                <td>
                   {$obj.observacoes}
                </td>        
            </tr>
            <tr>    
                <td>
                    <label for="mac">Status</label>
                </td>
                <td>
                    {$obj.status}
                </td>        
            </tr> 
            <tr>    
                <td>
                    <label for="mac">Tipo do equipamento</label>
                </td>
                <td>
                   {$obj.nome_tipo_equipamento}
                </td>        
            </tr>
            <tr>    
                <td>
                    <label for="mac">Vsat</label>
                </td>
                <td>
                	{if isset($obj.local.idinstalacoes_sp)}
                   		{$obj.local.nome}
                   	{/if}
                </td>        
            </tr>            
        </table>
    {if $login.perfis_idperfis != 3}
        
        <center>
            <input type="button" 
            	value="Editar Equipamento"
            	class="btn" 
            	onClick="javascript:
                		getAjaxForm('Equipamento_sp/edit',false,{ldelim}param:{$obj.idequipamentos_sp},ajax:1{rdelim})
                " 
            />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" 
            	value="Apagar Equipamento"
            	class="btn btn-danger" 
            	onClick="javascript:
                	if(confirm('Realmente deseja Apagar esse Equipamento?')){ldelim}
            			$.ajax({ldelim}
            				url:'Equipamento_sp/apaga',
                			type:'POST',
                			data:{ldelim}idequipamentos:{$obj.idequipamentos_sp}{rdelim},
                			success: function(resposta){ldelim}
                					alert('Equipamento apagado com sucesso!');
                    				getAjaxForm('Equipamento_sp/liste');
                			{rdelim}
            			{rdelim});
        			{rdelim}
                " 
            />
        </center>
    {/if}    
</form>
</center>
<center>
<form action="AgendaInstal/create" method="POST" id="fAtEdit" class="form" >
    <input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$obj.idatend_vsat}"/>
    
    <fieldset>
    
    <legend>Atualizar atendimento </legend><br />
    
    <div style="padding:5px;width:900px;text-align:left;">
        
        <table class="tbForm">
			
			<tr>
            	<td colspan="3">
            		<input type="button" value="Editar Atendimento" onclick="javascript:getAjaxForm('AtendVsat/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})" />
            	</td>
            </tr>
            
            <tr>    
                <td>
                    <label for="descricao" class="labelView"><b>Status do Atendimento:</b></label>
                </td>
                <td>
                    {if $obj.status_atend_idstatus_atend == 1}Aberto{/if}
                    {if $obj.status_atend_idstatus_atend == 2}Em Atendimento{/if}
                    {if $obj.status_atend_idstatus_atend == 3}Finalizado{/if}
                </td>        
            </tr>
            
            <tr>
            	<td valign='top'><label class="labelView"><b>Motivo:</b></label></td>
            	<td>
            		<table>
		            {foreach from=$motivosJaPresentes item=motivoJaPresente}
			            <tr>
			            	<td>
			            		<label class="labelView" style='text-transform:capitalize;'>{$motivoJaPresente.tipo_motivo_str}:</label>
			            	</td>
			            	<td>
			            		{$motivoJaPresente.motivo_str}
			            	</td>
			            </tr>
		            {/foreach}
		            </table>
		        </td>
		    </tr>
             
            <tr>    
                <td colspan="2">
                    <label for="descricao" class="labelView"><b>Atendimentos:</b></label><br/><br/>
                    {$obj.atendimento}<br/><br/>
                </td>        
            </tr>
                    
        </table>
        
    </div>
    
    </fieldset>       
    
    <br />
    
    <!-- 
    	<center><input type="button" value="Atualizar" onClick="javascript:sendPost('AtendVsat/edit','fAtEdit')" /></center>
    -->
</form>
</center>
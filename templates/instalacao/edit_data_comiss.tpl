
<center>

<form action="Instalacao/create" method="POST" id="form_data_aceite" class="form" >
    <input type="hidden" name="idinstalacoes" id="idinstalacoes" value="{$obj.idinstalacoes}"/>
    <input type="hidden" name="os_idos" id="os_idos" value="{$obj.os_idos}" />
    {if $obj.data_aceite!='vazio'}
    	<input 
    		type="hidden" 
    		name="data_aceite_original" 
    		id="data_aceite_original" 
    		value="{$obj.data_aceite}" 
    	/>
    {/if}
    
    <table>
    	<tr>
    		<td style="text-align:right;">Data de Aceite Prodemge:</td>
    		<td>&nbsp;</td>
    		<td style="text-align:left;">
    			<input 
    				type="text" 
    				name="data_aceite" 
    				id="data_aceite" 
    				value="{if $obj.data_aceite!='vazio'}{$obj.data_aceite}{/if}" 
    			/>
    		</td>
    	</tr>
    	{if $obj.data_aceite!='vazio'}
    		<tr>
    			<td style="text-align:right;">Justificativa de modificação:</td>
	    		<td>&nbsp;</td>
	    		<td style="text-align:left;">
	    			<textarea 
	    				style="
	    					width:250px;
	    					height:80px;
	    				" 
	    				name="justificativa_mod_data_aceite"
	    				id="justificativa_mod_data_aceite"
	    			></textarea>
	    		</td>
    		</tr>
    	{/if}
    </table><br/>
    
    <center>
    	<input 
    		type="button" 
    		value="Salvar" 
    		onClick="
        		javascript:
            	if( $('#data_aceite_original').val() != 'vazio' )
            	{ldelim}
    	
	            	if(	$('#justificativa_mod_data_aceite').val() == '' )
	                {ldelim}
	                
	        			if( $('#data_aceite').val() == $('#data_aceite_original').val() )
	        			{ldelim}
	        				sendPost('Instalacao/edit_data_aceite','form_data_aceite');
	        			{rdelim}
	        			else
	        			{ldelim}
	        				simpleMsg('Sob modificação é necessário justificar.');
	        			{rdelim}
	        			
	        		{rdelim}
	        		else
	            	{ldelim}
	    				sendPost('Instalacao/edit_data_aceite','form_data_aceite');
	    			{rdelim}
	    			
	    		{rdelim}
	    		else
	    		{ldelim}
    				sendPost('Instalacao/edit_data_aceite','form_data_aceite');
				{rdelim}
        	" 
    	/></center>
</form>

<div style="text-align:left;width:500px;">
	{if $obj.justificativa_mod_data_aceite != ''}
		<b>Modificações anteriores:</b><br/>
		{$obj.justificativa_mod_data_aceite}
	{/if}
</div>

</center>
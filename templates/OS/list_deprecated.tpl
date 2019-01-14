{include file="OS/submenu.tpl" title=submenu}
<center>

<div>
    <input type="text" value="" id="findOS" name="findOS" />
    <select name="typePesq" id="typePesq">
        <option value="identificador">ID</option>
        <option value="numOS" >Número da OS</option>
        <option value="cidade" >Cidade</option>
    </select>
    <input type="button" value="Buscar" onClick="javascript:findOS()" />
    <br /><br />
</div>

<table class="tbLista tableInstalacoes" id="OSlist">
	<thead>
    <tr>
        <th>N° OS</th>
        <th>Orgão</th>
        <th>Cidade</th>
        <th>Macroregião</th>
        <th>Data Solic.</th>
        <th class='titleTable'><a href="#" onclick="javascript:getAjaxForm('OS/liste','conteudo',{ldelim}orderBy:'prazoInstal',ajax:1{rdelim})"  >Prazo</a></th>
        <th>Agendamento</th>
        <th>Vsat criada?</th>
        <th>Comiss.</th>
        <th>Cod. Anatel</th>
        <th>Aceite PRODEMGE</th>
    </tr>
    </thead>
    <tbody>
		{foreach from=$arr item=os}
	    	{cycle values='trCor,trsCor' assign=rowCss}     
	    	<tr class="{$rowCss}" onClick="javascript:getAjaxForm('OS/view','conteudo',{ldelim}param:{$os.idos},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
	        
	        	<td class="_filterCol0 _match">{$os.numOS}</td>
	        	<td class="_filterCol1 _match">SES</td>
	        	<td class="_filterCol2 _match">{$os.rel.municipios_idcidade.municipio}</td>
	        	<td class="_filterCol3 _match">{$os.rel.municipios_idcidade.macroregiao}</td>
	        	<td class="_filterCol4 _match">{$os.dataSolicitacao}</td>
	        	<td class="_filterCol5 _match">{$os.prazoInstal}</td>
	        	
	        	<!-- Agendamento -->
	        	{if isset($os.rel.agenda_instal.idagenda_instal)}
	        		{if $os.rel.agenda_instal.confirm == 1}   
	            		<td class="_filterCol6 _match tdGreen">Confirmado</td>
	         		{elseif $os.rel.agenda_instal.mac}
	            		<td class="_filterCol6 _match tdYel">Agendado</td>
	          		{else}
	              		<td class="_filterCol6 _match tdRed"><B>Agendado</B></td>
	         		{/if}    
	         	{else}
					<td class="_filterCol6 _match tdRed">Não</td>
	        	{/if}
	        	
	        	<!-- Vsat criada? -->
	        	{if isset($os.rel.instalacoes.idinstalacoes)}
	            	{if !$os.rel.instalacoes.webnms && !$os.rel.instalacoes.packetshapper && !$os.rel.instalacoes.reglicenca && !$os.rel.instalacoes.opmanager && !$os.rel.instalacoes.prtg}
	               		<td class="_filterCol7 _match" class='tdYel'>
	               			Incompleta
	               		</td>
	            	{else}
	                	{if ! $os.rel.instalacoes.webnms}
	                    	<td class="_filterCol7 _match" class='tdYel'>Pendente WebNms</td>
	                	{elseif ! $os.rel.instalacoes.packetshapper}
	                    	<td class="_filterCol7 _match" class='tdYel'>Pendente Packet Shapper</td>
	                	{elseif ! $os.rel.instalacoes.reglicenca}    
	                    	<td class="_filterCol7 _match" class='tdYel'>Pendente Registro da licença</td>
	                	{elseif ! $os.rel.instalacoes.opmanager}    
	                    	<td class="_filterCol7 _match" class='tdYel'>Pendente Opmanager</td>
	                 	{elseif ! $os.rel.instalacoes.prtg}    
	                    	<td class="_filterCol7 _match" class='tdYel'>Pendente PRTG</td>
	                	{else}
	                    	<td class="_filterCol7 _match" class='tdGreen'>Completa</td>
	                	{/if}    
	             	{/if}   
	         	{else}
	            	<td class="_filterCol7 _match" class='tdRed'>Não</td>
	        	{/if}
	        	
	        	<!-- Comiss -->
	        	{if !isset($os.rel.instalacoes) or $os.rel.instalacoes.comiss != 1}
	            	<td class="_filterCol8 _match" class='tdRed'>Não</td>
	        	{else}
	            	<td class="_filterCol8 _match" class='tdGreen'>Sim</td>
	        	{/if}
	
				<!-- Cod Anatel -->
	        	{if isset($os.rel.instalacoes.idinstalacoes)}
	            	<td class="_filterCol9 _match" class='tdGreen'>{$os.rel.instalacoes.cod_anatel}</td>
	        	{else}
	            	<td class="_filterCol9 _match" class='tdRed'>Não</td>
	        	{/if}    
	        	
	        	<!-- Aceite PRODEMGE -->
	        	{if isset($os.rel.instalacoes.data_aceite)}
	            	<td class="_filterCol10 _match" class='tdGreen'>{$os.rel.instalacoes.data_aceite|date_format:"%d/%m/%Y"}</td>
	        	{else}
	            	<td class="_filterCol10 _match" class='tdRed'>Não</td>
	        	{/if}    
	    	</tr>
	    	{/foreach}
		</tbody>
</table>

</center>

{if $pag && isset($orderBy)}    
    {pagination total=$pag.total rowspage=$pag.rowspage url=$pag.url div='conteudo' orderBy=$orderBy}
{else}
    {pagination total=$pag.total rowspage=$pag.rowspage url=$pag.url div='conteudo'}
{/if}

<script>
	$('table#tbListat').columnFilters();
</script>
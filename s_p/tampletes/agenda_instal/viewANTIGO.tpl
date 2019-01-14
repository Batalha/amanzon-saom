<center>

<form action="AgendaInstal_sp/create" method="POST" id="fAgConfirm" class="form" >
	
	<input type="hidden" name="nomeForm" id="nomeForm" value="fAgConfirm" />
	<input type="hidden" name="osidos" id="osidos" value="{$obj.rel.os_sp.idos}" />
    <input type='hidden' name='idagenda_instal_sp' id='idagenda_instal_sp' value='{$obj.idagenda_instal_sp}' />
    <input type='hidden' name='confirm' id='confirm' value='1'/>
    
    <fieldset>
    
<!--     <div id="topDadosInstal" align="left"> -->
<!--     	<table class="tableDados"> -->
<!--     		<tr> -->
<!--     			<td><label><b><font color="#ffffff" size="2.9">&nbsp; Editar Agendamento - OS: <B>{$obj.rel.os_sp.numOS}</B></font></b></label></td>    			 -->
<!--     		</tr> -->
<!--     	</table> -->
<!--     </div> -->
<!--     <br /> -->
    
    <div class="agContener">
    	<div class="agenda">
    		<table class="agTable">
    			<tr>
    				<td width="27%"><b>Agendamento realizado em :</b></td><td>{$obj.data_temp}</td>
    			</tr>
    			<tr>
    				<td><b>Data agendada da Instalação :</b></td><td>{if $obj.data=='NULL' || $obj.data=='' || $obj.data=='00/00/0000'}(sem data){else}{$obj.data}{/if}</td>
    			</tr>
    			<tr>
    				<td><b>Usuario que confirmou :</b></td><td>{$obj.rel.usuario_confirm.nome}</td>
    			</tr>
    		</table>
    		
    	</div>
    	<div class="agContato" align="left">
			<h5>Dados de Contato 1</h5>
    	</div>
    	<div class="agDadosContato">
    		<table class="contatoTable">
    			<tr>
    				<td><b>Nome :</b></td><td>{$obj.contato}</td>
    				<td><b>Telefone  :</b></td><td>{$obj.tel}</td>
    				<td><b>Celular :</b></td><td>{$obj.cel}</td>
    			</tr>
    		</table>
    		
    	</div>
    	<div class="agContato" align="left">
    		<h5>Dados de Contato 2</h5>
    	</div>
    	<div class="agDadosContato">
     		<table class="contatoTable">
    			<tr>
    				<td><b>Nome :</b></td><td>{$obj.contato_2}</td>
    				<td><b>Telefone :</b></td><td>{$obj.tel_2}</td>
    				<td><b>Celular :</b></td><td>{$obj.cel_2}</td>
    			</tr>
    		</table>   		
    	</div>
    	<div class="agContato" align="left">
    		<h5>Dados da Instalação</h5>
    	</div>
    	<div class="agDadosInstal">
    		<table border="1" class="agTable">
    			<tr>
    				<td width="18%"><b>N° Série Modem :</b></td><td width="25%">&nbsp;{$obj.nsmodem}</td>
    				<td width="12%"><b>Antena :</b></td><td>&nbsp;{$obj.antena}</td>
    			</tr>
    			<tr>
    				<td><b>MAC :</b></td><td>&nbsp;{$obj.mac}</td>
    				<td><b>N° Série :</b></td><td>&nbsp;{$obj.antena_ns}</td>
    			</tr>
    			<tr>
    				<td><b>ODU :</b></td><td>&nbsp;
    				{if isset($obj.rel.tipo_equipamentos_sp.nome)}
                    	{$obj.rel.tipo_equipamentos_sp.nome}
                    {/if}
    				</td>
    				<td><b>Tamanho :</b></td><td>&nbsp;{$obj.antena_tam}</td>
    			</tr>
    			<tr>
    				<td><b>N° Serie ODU :</b></td><td>&nbsp;{$obj.nsodu}</td>
    				<td><b></b></td><td></td>
    			</tr>
    		</table>    		
    	</div>
    	<div class="agContato" align="left">
    		<h5>Observação</h5>
    	</div>
    	<div class="agDadosObs" style="height: 0 outo;">
    		<table class="agTable">
    			<tr>
    				<td>{$obj.observacoes}</td>
    			</tr>
    		</table>
    	</div>
    	
    </div>
     </fieldset>       
   
    <br />
    <center>
    
	    {if $obj.rel.os_sp.os_status_idos_status != 2}
	    
		    {if ($login.perfis_idperfis == 4 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 5 ) && $obj.confirm != 1}
		        <input type="button" value="Confirmar Agendamento" onClick="javascript:sendPost('AgendaInstal_sp/edit','fAgConfirm')" />
		    {/if}
		    
		    {if $obj.confirm == 1 && $login.perfis_idperfis != 10 && $login.perfis_idperfis != 3 && $login.perfis_idperfis != 12}
		    	<input style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);"	type="text"	value="Para editar agendamento é necessário cancelar a confirmação do mesmo"/><br/><br/>
		        <input type="button" value="Cancelar confirmação de agendamento" onClick="javascript:cancelConfirmAgendSp({$obj.idagenda_instal_sp})" />
		    {/if}
		    
		    {if $obj.confirm != 1 && $login.perfis_idperfis != 10 && $login.perfis_idperfis != 12}
		        <input type="button" value="Editar" onClick="javascript:getAjaxForm('AgendaInstal_sp/edit','divOS',{ldelim}param:{$obj.idagenda_instal_sp},ajax:1{rdelim})" />
		    {/if}
	   		
	        {*<input type="button" value="Ver OS" onClick="javascript:getAjaxForm('OSSP/view_compact','',{ldelim}param:{$obj.rel.os_sp.idos},ajax:1{rdelim})" />*}
     
     	{else}
     	
     		<input 
		    	style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);text-align:center;" 
		    	type="text" 
		    	value="Agendamento de uma OS Cancelada"
		    />
     	
     	{/if}
    </center>    
</form>
    
    <div id="divOS"></div>
    <br/>
    
    </center>
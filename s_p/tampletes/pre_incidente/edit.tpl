

<center>

{include file="s_p/tampletes/incidente/submenu.tpl" title=submenu}

<div style="padding:20px;">
<form id="form_pre_incidente_edicao">
	<fieldset>
	<legend>
		<h2>
			Edição de Pré-Incidente - {$incidente.id_pre_incidentes}
		</h2>
	</legend>
	<table class="table">
		<tr>
			<td style="width:150px;" class="label_right"><h4>Id Prodemge</h4></td>
				<td style="width:15px;">&nbsp;</td>
			<td style="width:150px;"><input type="text" name="id_prodemge" id="id_prodemge" value="{$incidente.id_prodemge}" /></td>
				<td style="width:15px;">&nbsp;</td>
			<td style="width:150px;" class="label_right"><h4>Id Cliente</h4></td>
				<td style="width:15px;">&nbsp;</td>
			<td style="width:150px;"><input type="text" name="id_cliente" id="id_cliente" value="{$incidente.id_cliente}" /></td>
		</tr>
		
		<tr>
			<td class="label_right"><h4>Prazo Limite</h4></td>
				<td>&nbsp;</td>
			<td><input type="text" name="prazo_limite" id="prazo_limite" value="{$incidente.prazo_limite}" /></td>
				<td>&nbsp;</td>
			<td class="label_right"><h4>Designação</h4></td>
				<td>&nbsp;</td>
			<td><input type="text" name="designacao" id="designacao" value="{$incidente.designacao}" /></td>
		</tr>
		
		<tr>
			<td class="label_right"><h4>Responsável</h4></td>
				<td>&nbsp;</td>
			<td>
			
				<select name="responsavel" id="responsavel">
					<option></option>
					{foreach from=$listaUsuarios item=usuario}
						<option {if $usuario.idusuarios eq $incidente.responsavel}selected{/if} value="{$usuario.idusuarios}">{$usuario.nome}</option>
					{/foreach}
				</select>				
				
			</td>
				<td>&nbsp;</td>
			<td class="label_right"><h4>Data do Email</h4></td>
				<td>&nbsp;</td>
			<td><input readonly="readonly" id="data_email" name="data_email" value="{$incidente.data_email}" type="text"/></td>
		</tr>
		
		<tr>
			<td class="label_right"><h4>Identificador</h4></td>
				<td>&nbsp;</td>
			<td><input id="identificador" name="identificador" value="{$incidente.identificador}" type="text"/></td>
				<td>&nbsp;</td>
			<td class="label_right"><h4>&nbsp;</h4></td>
				<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td class="label_right"><h4>Solicitação</h4></td>
				<td>&nbsp;</td>
			<td colspan="5"><textarea id="solicitacao" name="solicitacao" style="width:100%;height:150px;">{$incidente.solicitacao}</textarea></td>
		</tr>
		
		<tr>
			<td class="label_right"><h4>Discussão</h4></td>
				<td>&nbsp;</td>
			<td colspan="5"><textarea id="discussao" name="discussao" style="width:100%;height:150px;">{$incidente.discussao}</textarea></td>
		</tr>
		
		<tr>
			<td colspan="7" style="text-align:center;">
				<input name="id_pre_incidentes" id="id_pre_incidentes" value="{$incidente.id_pre_incidentes}" type="hidden"/>
				<a class="btn"
					onclick="javascript:
						//sendPost('PreIncidentes/update','form_pre_incidente_edicao');
						$.ajax({ldelim}
							url:'PreIncidentes_sp/update',
							type:'POST',
							data:{ldelim}form:$('#form_pre_incidente_edicao').serialize(){rdelim},
							success:function( resposta ){ldelim}
								$('#respostaAjax').html( resposta );
								setTimeout(function(){ldelim}
									$('#respostaAjax span').fadeOut();
								{rdelim},5000);
							{rdelim}
						{rdelim});
					">
					Salvar
				</a>
			</td>
		</tr>
		<tr>
			<td colspan="7" style="text-align:center;">
				<div id="respostaAjax"></div>
			</td>
		</tr>
	</table>
</fieldset>

</form>
</div>

</center>
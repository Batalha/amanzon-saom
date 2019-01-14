
<div
	style="
		width:100%;
	">
	
	<form method="post" action="">
		<input name="id_pre_incidente_nagios" id="id_pre_incidente_nagios" value="{$preIncidente.id_pre_incidentes_nagios}" type="hidden"/>
		
		<table>
			<tr>
				<td>Responsável:</td>
				<td>&nbsp;</td>
				<td>
					<select name="responsavel" id="responsavel">
						<option></option>
						{foreach from=$listaUsuarios item=usuario}
						    <option {if $preIncidente.responsavel eq $usuario.idusuarios}selected{/if} value="{$usuario.idusuarios}">{$usuario.nome}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#" class="btn btn-primary"
						onclick="javascript:
							$.ajax({
								url:'PreIncidentesNagios/atualizaResponsavel',
								type:'POST',
								data:{ responsavel:$('#responsavel').val() , idPreIncidenteNagios:$('#id_pre_incidente_nagios').val() },
								success:function( resposta ){
									$('#respostaModal').html( resposta );
								}
							});
						">
						Salvar
					</a>
				</td>
				<td colspan="2">
					<div id="respostaModal">&nbsp;</div>
				</td>
			</tr>
		</table>
		
	</form>
	
</div>

<div
	style="
		width:100%;
	">
	
	<form method="post" action="">
		<input name="id_pre_incidente" id="id_pre_incidente" value="{$preIncidente.id_pre_incidentes}" type="hidden"/>
		
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
								url:'PreIncidentes/atualizaResponsavel',
								type:'POST',
								data:{ responsavel:$('#responsavel').val() , idPreIncidente:$('#id_pre_incidente').val() },
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
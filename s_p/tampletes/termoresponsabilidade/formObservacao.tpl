
<center>
<br />
<div id="formulario_justifica_desaprovacao_termo_justificativa">
	
	<form name="form_justifica_desaprovacao_termo_responsabilidade" id="form_justifica_desaprovacao_termo_responsabilidade" 
		method="post" action="TermoResponsabilidade_sp/justificaDesaprovacao" enctype="multipart/form-data">
		<input name="id_termo_responsabilidade" id="id_termo_responsabilidade" type="hidden" value="{$termo.id_termo_responsabilidade}"/>
		
		<table>
			<tr>
				<td width="100"><b>Justificativa :</b></td>
				<td rowspan="2">
					<textarea name="comentario" id="comentario" style="width:600px;height:80px;">{$termo.comentario}</textarea>
				</td>
			</tr>
			<tr>
				<td >
					<input type="button" class="btn" value="Enviar"
						onclick="javascript:
							timeout = new Array();
							$('#form_justifica_desaprovacao_termo_responsabilidade').ajaxSubmit({ldelim}
								target: '#termo_responsabilidade_result',
								beforeSubmit: function(){ldelim}{rdelim},
								success: function(resposta){ldelim}
									timeout['tempoResgateTipoResposta'] = setTimeout(function(){ldelim}
										// resgata tipo resposta
										var tipoResposta = $('span.alert').attr('class');
										tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
										// atualiza status
										if( tipoResposta != 'error' ){ldelim} 
											$('#status_termo_responsabilidade').html('Desaprovado');
										{rdelim}
									{rdelim},500); // atualiza status
									
									timeout['tempoAlerta'] = setTimeout(function(){ldelim}
										$('.alert').fadeOut();
									{rdelim},4000); // resposta

									timeout['tempoFecharFormulario'] = setTimeout(function(){ldelim}
										$('#formulario_justifica_desaprovacao_termo_justificativa').fadeOut();
									{rdelim},5000); // retira este formulário
								{rdelim},
								error:function(){ldelim}
									// -- 
								{rdelim}
							{rdelim});
						"/>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div id="termo_responsabilidade_result"></div>
				</td>
			</tr>
		</table>
		
	</form>
	
</div>
</center>
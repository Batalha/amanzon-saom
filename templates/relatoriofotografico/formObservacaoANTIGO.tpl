
<center>
<div id="formulario_justifica_desaprovacao_relatorio_justificativa">
	
	<form name="form_justifica_desaprovacao_relatorio_fotografico" id="form_justifica_desaprovacao_relatorio_fotografico" 
		method="post" action="RelatorioFotografico/justificaDesaprovacao" enctype="multipart/form-data">
		<input name="id_relatorio_fotografico" id="id_relatorio_fotografico" type="hidden" value="{$relatorio.id_relatorio_fotografico}"/>
		
		<table>
			<tr>
				<td style="width:120px;text-align:left;">Justificativa:</td>
				<td style="widdth:10px;">&nbsp;</td>
				<td style="width:100px;text-align:left;">
					<textarea name="comentario" id="comentario" style="width:300px;height:200px;">{$relatorio.comentario}</textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align:left;">
					<input type="button" class="btn" value="Enviar"
						onclick="javascript:
							timeout = new Array();
							$('#form_justifica_desaprovacao_relatorio_fotografico').ajaxSubmit({ldelim}
								target: '#relatorio_fotografico_result',
								beforeSubmit: function(){ldelim}{rdelim},
								success: function(resposta){ldelim}
									timeout['tempoResgateTipoResposta'] = setTimeout(function(){ldelim}
										// resgata tipo resposta
										var tipoResposta = $('span.alert').attr('class');
										tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
										// atualiza status
										if( tipoResposta != 'error' ){ldelim} 
											$('#status_relatorio_fotografico').html('Desaprovado');
										{rdelim}
									{rdelim},500); // atualiza status
									
									timeout['tempoAlerta'] = setTimeout(function(){ldelim}
										$('.alert').fadeOut();
									{rdelim},4000); // resposta

									timeout['tempoFecharFormulario'] = setTimeout(function(){ldelim}
										$('#formulario_justifica_desaprovacao_relatorio_justificativa').fadeOut();
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
					<div id="relatorio_fotografico_result"></div>
				</td>
			</tr>
		</table>
		
	</form>
	
</div>
</center>
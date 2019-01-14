
<center>
<br />
<div>
	

	<form name="form_upload_relatorio_fotografico" id="form_upload_relatorio_fotografico" 
		method="post" action="RelatorioFotografico/upload" enctype="multipart/form-data">
		<input name="id_instalacoes" id="id_instalacoes" type="hidden" value="{$idinstalacao}"/>
		
		<table>
			<tr>
				<td width="220"><b>Relatório Fotográfico :</b></td>
				<td colpan="3" style="text-align:left;">
					<input type="button" class="btn" value="Enviar"
						onclick="javascript:
							$('#form_upload_relatorio_fotografico').ajaxSubmit({ldelim}
								target: '#relatorio_fotografico_result',
								success: function(resposta){ldelim}
									// apresenta o arquivo para o usuario 
									$('#local_arquivo_relatorio_fotografico').html( $('#arquivo_novo_relatorio_fotografico') );
									
									// apresenta o btn para apagar o arquivo
									$.ajax({ldelim}
										url:'RelatorioFotografico/btnApagarRelatorioFotografico',
										type:'POST',
										data:{ldelim}id_instalacoes:{$idinstalacao}{rdelim},
										success:function( resposta ){ldelim}
											$('#btn_apagar_relatorio_fotografico').html( resposta );
											$('#status_relatorio_fotografico').html('Aprovação Pendente');
											
											timeout['tempoApagarAlerta'] = setTimeout(function(){ldelim}// apaga alerta
												$('.alert').fadeOut();
											{rdelim},4500);
										{rdelim}
									{rdelim});
								{rdelim}
							{rdelim});
						"/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="relatorio_fotografico" id="relatorio_fotografico" type="file" value="" />
				</td>
			</tr>
			<tr>

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
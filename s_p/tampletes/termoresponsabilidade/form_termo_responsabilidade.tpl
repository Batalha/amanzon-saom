

<div class="container1" style="width: 40%;">
	<form name="form_upload_termo_responsabilidade" id="form_upload_termo_responsabilidade"
		  method="post" action="TermoResponsabilidade_sp/upload" enctype="multipart/form-data">
		<input name="id_instalacoes" id="id_instalacoes" type="hidden" value="{$idinstalacao}"/>
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="row">
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="230"><b>Termo de Responsabilidade :</b></td>
							<td colpan="3" style="text-align:left;">
								<input type="button" class="btn btn-primary" value="Enviar"
									   onclick="javascript:

											   $('#form_upload_termo_responsabilidade').ajaxSubmit({ldelim}

											   target: '#termo_responsabilidade_result',
											   success: function(resposta){ldelim}
											   // apresenta o arquivo para o usuario
											   $('#local_arquivo_termo_responsabilidade').html( $('#arquivo_novo_termo_responsabilidade') );

											   // apresenta o btn para apagar o arquivo
											   $.ajax({ldelim}
											   url:'TermoResponsabilidade_sp/btnApagarTermoDeResponsabilidade',
											   type:'POST',
											   data:{ldelim}id_instalacoes:{$idinstalacao}{rdelim},
											   success:function( resposta ){ldelim}
											   $('#btn_apagar_termo_responsabilidade').html( resposta );
											   $('#status_termo_responsabilidade').html('Aprovação Pendente');

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
								<input name="termo_responsabilidade" id="termo_responsabilidade" type="file" value="" />
							</td>
						</tr>
						<tr>

						</tr>
						<tr>
							<td colspan="3">
								<div id="termo_responsabilidade_result"></div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>





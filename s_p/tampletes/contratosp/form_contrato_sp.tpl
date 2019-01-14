<script src="libs/jquery-ui-1.8.17/js/jquery-ui-1.8.17.custom.min.js"></script>
<center>
<br />
<div>
	
	<form name="form_upload_contrato" id="form_upload_contrato" 
		method="post" action="ContratoSP/upload" enctype="multipart/form-data">
		<input type="hidden" name="contrato_idpedido_os" id="contrato_idpedido_os" value="{$idpedido_os}"/>
		
		<table>
			<tr>
				<td width="90px"><b>Pedido Os :</b></td>
				<td colspan="2">
					<input name="contrato" id="contrato" type="file" value="" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td colpan="3" style="text-align:left;">
					<input type="button" class="btn" value="Enviar Pedido OS"	
						onclick="javascript:

						
							$('#form_upload_contrato') .ajaxSubmit({ldelim}
									target: '#contrato_sp_result', 
									success: function(resposta)
									{ldelim}
										
										// apresenta o arquivo para o usuario 
										$('#local_arquivo_contrato_sp').html( $('#arquivo_novo_contrato') );
										
										// apresenta o btn para apagar o arquivo
										$.ajax({ldelim}
											url:'ContratoSP/btnApagarContratoSP',
											type:'POST',
											data:{ldelim}contrato_idpedido_os:{$idpedido_os}{rdelim},
											success:function( resposta ){ldelim}
												$('#btn_apagar_contrato_sp').html( resposta );
												
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

			</tr>
			<tr>
				<td colspan="3">
					<div id="contrato_sp_result"></div>
				</td>
			</tr>
		</table>
		
	</form>

</div>
</center>
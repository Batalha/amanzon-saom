
<center>
</br>
<div>
	
	<form name="form_upload_licenca_anatel" id="form_upload_licenca_anatel" 
		method="post" action="Comissionamento/upload_licenca_anatel" enctype="multipart/form-data">
		<input name="idinstalacoes_para_licenca" id="idinstalacoes_para_licenca" type="hidden" value="{$idinstalacao}"/>
		
		<table>
			<tr valign="middle">
				<td style="width: 50%"><b>Licença Anatel :</b></td>
				<td colspan="2" style="text-align:left;">
					<input type="button" class="btn" value="Enviar"
						onclick="javascript:
							$('#form_upload_licenca_anatel').ajaxSubmit({
								target: '#licenca_anatel_result',
								beforeSubmit: function(){},
								success: function(resposta){
									// -- 
									$('#local_arquivo_licenca_anatel').html( $('#arquivo_novo_licenca_anatel') );
								},
								error:function(){
									// -- 
								}
							});
						"/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="licenca_anatel" id="licenca_anatel" type="file" value="" />
				</td>
			</tr>

			<tr>
				<td colspan="3">
					<div id="licenca_anatel_result"></div>
				</td>
			</tr>
		</table>
	</form>
</div>	
</center>
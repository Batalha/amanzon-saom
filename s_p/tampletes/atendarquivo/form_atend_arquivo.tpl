<div style="margin: 0; padding: 0">
	<script type="text/javascript"></script>
	<form name="form_atend_arquivo" id="form_atend_arquivo"
		method="post" action="AtendArquivo_sp/upload" enctype="multipart/form-data">
		<input name="id_atendimento" id="id_atendimento" type="hidden" value="{$idatend_vsat}"/>
		<table border="0" width="100%">
			<tr title="Atenção: Arquivo nao pode ter Caracteres especiais (!@#$%*&.)">
				<td >
					<input class="form-control" name="atend_arquivo[]" id="atend_arquivo" type="file" value="" multiple
					/>
                </td>
				<td align="left">
                    <input type="button" class="btn btn-primary" value="Enviar"	onclick="javascript:
                            $('#form_atend_arquivo').ajaxSubmit({ldelim}
                            target: '#atend_arquivo_result',
                            success: function(resposta){ldelim}

                            // apresenta o arquivo para o usuario
                            $('#local_atend_arquivo').html( $('#arquivo_novo_atend_arquivo') );
                    {rdelim}
                    {rdelim});
                            "/>
				</td>
                <td width="48%">
                    <div id="atend_arquivo_result" style="color: red">"<b>Atenção:</b> Arquivo nao pode ter Caracteres especiais (!@#$%*&)"</div>
                </td>
			</tr>
		</table>
	</form>
</div>
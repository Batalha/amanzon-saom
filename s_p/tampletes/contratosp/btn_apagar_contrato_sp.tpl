
<!-- btn feito para apagar pelo id_instalacoes -->

<a title="Apagar" onclick="javascript:


	timeout = new Array(); // apaga timeout's
	$.ajax({ldelim}
		url:'ContratoSP/apagarContratoSPPeloIdPedidoOs',
		data:{ldelim}contrato_idpedido_os:{$contrato_idpedido_os}{rdelim},
		type:'POST',
		success:function( resposta){ldelim}

			$('#contrato_sp_result').html(resposta);
	
			timeout['tempoRespostaApagar'] = setTimeout(function(){ldelim}
				// resgata tipo resposta
				var tipoResposta = $('span.alert').attr('class');
				tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
				// limpa nome do arquivo
				if( tipoResposta != 'error' ){ldelim}
					$('#local_arquivo_contrato_sp').html('Essa estação não tem nenhum Contrato disponível');
					$('#btn_apagar_contrato').html('');

				{rdelim}
			{rdelim},500); // atualiza status
		{rdelim}
	{rdelim});
	"><i class="icon-remove"></i></a>

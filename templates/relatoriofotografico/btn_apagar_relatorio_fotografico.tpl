
<!-- btn feito para apagar pelo id_instalacoes -->

<a title="Apagar" onclick="javascript:
	timeout = new Array(); // apaga timeout's
	$.ajax({ldelim}
		url:'RelatorioFotografico/apagarRelatorioFotograficoPeloIdInstalacoes',
		data:{ldelim}id_instalacoes:{$id_instalacoes}{rdelim},
		type:'POST',
		success:function( resposta){ldelim}
			$('#dadosInstal').html(resposta);
	
			timeout['tempoRespostaApagar'] = setTimeout(function(){ldelim}
				// resgata tipo resposta
				var tipoResposta = $('span.alert').attr('class');
				tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
				// limpa nome do arquivo
				if( tipoResposta != 'error' ){ldelim}
					$('#local_arquivo_relatorio_fotografico').html('Essa estação não tem nenhum Relatório Fotográfico disponível');
					$('#btn_apagar_relatorio_fotografico').html('');
					$('#status_relatorio_fotografico').html('');
				{rdelim}
			{rdelim},500); // atualiza status
		{rdelim}
	{rdelim});
	"><i class="icon-remove"></i></a>
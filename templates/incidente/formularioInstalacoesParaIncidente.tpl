
<form id="formularioInstalacoesParaIncidente">

<table class="table table-bordered table-striped">

	<tr>
		<td>Instalações:</td>
		<td>
			<input type="hidden" name="idIncidente" id="idIncidente" value="{$idIncidente}"/>
			<input type="text" name="nome_instalacao" class="inputReq"	id="nome_instalacao" value="" />
			<div style="display: none" id="listaInstalacoes">{$listaautocomplete}</div>
		</td>
	</tr>
	<tr>
		<td>ID Prodemge:</td>
		<td>
			<input type="text" name="numero_prodemge" class="inputReq" id="numero_prodemge" value="" />
		</td>
	</tr>
	
	<tr>
		<td>
			<a class="btn" onclick="javascript:
				$.ajax({ldelim}
					url:'Incidente/adicionaInstalacaoEmIncidente',
					type:'POST',
					data:{ldelim}
						idIncidente:$('#idIncidente').val(),
						nomeInstalacao:$('#nome_instalacao').val(),
						numProdemge:$('#numero_prodemge').val()
					{rdelim},
					success:function( resposta ){ldelim}
						if( parseInt(resposta[0]) == 1 ){
							$('#respostaAssociacaoPreExistente').css('display','block');
						}else if( parseInt(resposta[0]) == 2 ){
							$('#respostaAssociacaoFeita').css('display','block');
						}else if(parseInt(resposta[0]) == 3){
							$('#respostaErroAoAssociar').css('display','block');
						}else if(parseInt(resposta[0]) == 4){
							$('#respostaErroAoCadastrarIdProdemge').css('display','block');
						}else if(parseInt(resposta[0]) == 5){
							$('#respostaDeCampoVazio').css('display','block');
						}else if(parseInt(resposta[0]) == 6){
							$('#respostaErroVsatNaoConsta').css('display','block');
						}
						setTimeout( '$(\'.respostas\').fadeOut()' , 2000 );
						atualizaEditorIncidentes = setTimeout( 'atualizaEditorIncidente( $(\'#idincidentes\').val() )' , 3000 );
					{rdelim}
				{rdelim});
			">Inserir</a>
		</td>
		<td>
			<div style="display:none;" class="alert alert-block respostas" id="respostaAssociacaoPreExistente">Essa associação já existe.</div>
			<div style="display:none;" class="alert alert-success respostas" id="respostaAssociacaoFeita">Instalação Associada ao Incidente com Sucesso</div>
			<div style="display:none;" class="alert alert-error respostas" id="respostaErroAoAssociar">Erro ao Associar Instalação ao Incidente.</div>
			<div style="display:none;" class="alert alert-error respostas" id="respostaErroAoCadastrarIdProdemge">Esse ID Prodemge Ja Existe.</div>
			<div style="display:none;" class="alert alert-error respostas" id="respostaErroVsatNaoConsta">Erro! Vsat não consta na lista.</div>
			<div style="display:none;" class="alert alert-error respostas" id="respostaDeCampoVazio">Por favor Preencha todos os campos.</div>
		</td>
	</tr>

</table>

</form>

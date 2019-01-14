<div class="container1" style="margin-top: 0px; width:40%; margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/incidente/submenu.tpl" title=submenu}
	</div>
</div>

<br>

<div class="container1" style="margin-top: 10px;">
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title text-center">Editar Ticket N° {$obj.idincidentes}</div>
				</div>
				<div class="panel-body">
					<form action="AgendaInstal_sp/create" method="POST" id="fAgCreate" class="form" >
						<input type="hidden" name="idincidentes" id="idincidentes" value="{$obj.idincidentes}"/>
						<input type="hidden" name="saom" id="saom" value="{$obj.saom}"/>

						<div class="row">

							<div class="form-group col-md-6">
								<label for="data">Data</label>
								<div class="input-group">
									{if $perfil_incidente == 10}
										<input type="text" name="data" readonly="readonly" id="data" class="form-control" value="{$obj.data}" >
									{else}
										<input type="text" name="data" id="data" class="form-control" value="{$obj.data}" >

									{/if}
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
							</div>

							<div class="form-group col-md-3">
								<label for="solicitacao_idsolicitacao">Ticket</label>
								<select name="solicitacao_idsolicitacao" id="solicitacao_idsolicitacao" class="form-control" onchange="javascript:tipoIncidente();">
									<option value="">Escolher</option>
									{foreach from=$solicitacao item=sl}
										<option value="{$sl.idsolicitacao}" {if $sl.idsolicitacao == $obj.solicitacao_idsolicitacao}selected{/if}>{$sl.nomeSolicitacao}</option>
									{/foreach}
								</select>
							</div>

							<div  id="tipoHidden" class="form-group col-md-3" {if !$obj.tipo_incidente_idtipo} hidden{else}{/if}>
								<label for="tipo_incidente_idtipo">Tipo Incidente</label>
								<select name="tipo_incidente_idtipo" id="tipo_incidente_idtipo" class="form-control">
									<option value=0>Tipo de Ticket</option>
									{foreach from=$tipoIncidente item=tp}
									<option value="{$tp.idtipo}" {if $tp.idtipo == $obj.tipo_incidente_idtipo}selected{/if}>{$tp.nomeTipo}</option>
									{/foreach}
								</select>
							</div>

							<div  id="demoHidden" class="form-group col-md-3" {if !$obj.teste_demo_idteste} hidden{else}{/if}>
								<label for="teste_demo_idteste">Teste Demo</label>
								<select name="teste_demo_idteste" id="teste_demo_idteste" class="form-control">
									<option value=0>Teste Demo</option>
									{foreach from=$testeDemo item=td}
									<option value="{$td.idteste}" {if $td.idteste == $obj.teste_demo_idteste}selected{/if}>{$td.nomeTeste}</option>
									{/foreach}
								</select>
							</div>

						</div>

						<div class="row">

							<div class="form-group col-md-6">
								<label for="prioridade">Prioridade</label>
								<select name="prioridade" id="prioridade" class="form-control">
									<option value="Baixa" {if $obj.prioridade == "Baixa"} selected{/if}>Baixa</option>
									<option value="Media" {if $obj.prioridade == "Média"} selected{/if}>Media</option>
									<option value="Alta" {if $obj.prioridade == "Alta"} selected{/if}>Alta</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="tecnicoNoc">Tecnico</label>
								{if $empresa != 23}
									<select name="tecnicoNoc" id="tecnicoNoc" class="form-control">
										<option value="">Escolher</option>
										{foreach from=$listaUsuarios item=vez}
											{if $vez.ativacao == 1 && $vez.incidentes == 1}
												<option value="{$vez.idusuarios}" {if $vez.idusuarios == $obj.tecnicoNoc}selected{/if}>{$vez.nome}</option>
											{/if}
										{/foreach}
									</select>
								{else}
									<select name="tecnicoNoc" id="tecnicoNoc" class="form-control">
										<option value="67">Tecnico Noc</option>
									</select>
								{/if}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<textarea name="descricao" id="descricao" style="height: 100px;" class="form-control" placeholder="Descrição do Ticket">{$obj.descricao}</textarea>
							</div>
						</div>
						<div class="row">
							<div {if ($instalacao.nome)} onmouseover="javascript:verificaVsatSp()";{/if}></div>

						</div>
					</form>

					<div class="row">
						<div class="col-md-2" style="padding-bottom: 26px;">
							<input type="button" class="btn btn-primary" id="" value="Salvar"
								   onClick="javascript:
										   $.ajax({ldelim}
										   url:'Incidente_sp/update',
										   type:'POST',
										   data:{ldelim}form:$('#fAgCreate').serialize(){rdelim},
										   success:function(resposta)
										   {ldelim}
										   $('#respostaFormAjax').html(resposta);
										   $('#respostaFormAjax').css('display','block');
										   setTimeout( '$(\'#respostaFormAjax\').fadeOut()' , 4000 );
								   {rdelim}
								   {rdelim});
										   " />
							{foreach from=$obj.instalacoes_sp item=instalacao}{/foreach}
							<input type="hidden" name="instVsat" id="instVsat" value="{$instalacao.nome}"/>
						</div>
						<div class="col-md-10">
							<span id="respostaFormAjax" class="alert alert-info" style="display:none;" ></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title text-center">Vsats Cadastrados</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-12">
							{if $perfil_incidente != 10}
								<a class="btn btn-primary" onclick="javascript:abreEscolhaIncidentesSp(); ">Cadastrar Nova Instalação</a>
							{/if}
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							{$i=0}
							<table class="table table-striped">
								<thead>
								<th>Vsat's</th>
								<th class="text-center">Açoes</th>
								</thead>
								<tbody>

								{foreach from=$obj.instalacoes_sp item=instalacao}
									<p hidden="">{$i}</p>
									<tr>
										<td>
											{$instalacao.nome}
										</td>
										<td class="text-center">
											<a class="btn-danger btn-small"  onclick="javascript:
													if( confirm('Deseja retirar essa Instalação desse Incidente?') ){
													{ldelim}
													$.ajax(
													{ldelim}
													url:'Incidente_sp/RetiraAssociacaoComInstalacao',
													type:'POST',
													data:{ldelim}
													nomeInstalacao:'{$instalacao.nome}',
													idInstalacao:'{$instalacao.idinstalacoes_sp}',
													idincidentes:'{$obj.idincidentes}',
													idProd:'{$obj.prodemge_sp[$i++].idprodemge}'
											{rdelim},
													success:function( resposta )
													{ldelim}
													alert(resposta);
													atualizaEditorIncidenteSp( $('#idincidentes').val() );

											{rdelim}
											{rdelim}
													);
											{rdelim}
													}
													">retirar</a>
										</td>

									</tr>
								{/foreach}

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- MODAL -->
<div class="modal hide fade" id="modalInstalacoes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Selecionar Instalação</h3>
	</div>

	<div class="modal-body">

		<div id="modalConteudo">

		</div>

	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>

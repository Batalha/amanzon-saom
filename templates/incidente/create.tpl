<div class="container1" style="margin-top: 0px; margin-left: 7%;">
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>

<div class="container1" style="margin-top: 10px; width: 55%;">
	<form action="AgendaInstal/create" method="POST" id="fAgCreate"	class="form">
		{if $param != 'listaInstalacoes'}
			<input type="hidden" name="instalacoes_idinstalacoes" id="instalacoes_idinstalacoes" value="{$param}" />
		{/if}
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title text-center">Registrar Ticket</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<input type="text" name="data" id="data" size="10" class="form-control" placeholder="Data de Solicitação"
								   onchange="javascript:retiraError()"/>
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6 text-center">
						<input type="text" name="idprodemge" id="idprodemge"	class="form-control"
							   value="{$id_prodemge}" placeholder="{$xml->incidentes->campos->idprodemge}"
						/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<select class="form-control" name="prioridade" id="prioridae">
							<option value="Baixa">Baixa</option>
							<option value="Média">Média</option>
							<option value="Alta">Alta</option>
						</select>
					</div>
					<div id="errorInstalacao" class="form-group col-md-6">
						{if $param == 'listaInstalacoes'}
							<input type="text" name="nome_instalacao" class="form-control"	id="nome_instalacao" value="" placeholder="Instalação"/>

							<div style="display: none" id="listaComplete">{$listaautocomplete}</div>
						{/if}
					</div>
				</div>
				<div class="row">
					<div id="errorTecnico" class="form-group col-md-6">
						{if $SAOM == 'PRODEMGE'}
							<select name="tecnicoNoc" id="tecnicoNoc" class="form-control">
								<option value="">Escolher</option>
								{foreach from=$listaUsuarios item=vez}

									{if (
										($idperfil == 4)&&($vez.perfis_idperfis == 4 or $vez.perfis_idperfis == 5 or $vez.subperfil_idsubperfil == 3 or $vez.subperfil_idsubperfil == 2 or $vez.subperfil_idsubperfil == 1)||
										($idperfil == 5)&&($vez.perfis_idperfis == 5 or $vez.subperfil_idsubperfil == 3 or $vez.subperfil_idsubperfil == 2 or $vez.subperfil_idsubperfil == 1)||
										($idperfil == 1)&&($vez.perfis_idperfis == 1)||
										($idperfil == 2)&&($vez.perfis_idperfis == 2)||
										($idperfil == 3)&&($vez.perfis_idperfis == 3)
										)
									}
										<option value="{$vez.idusuarios}">{$vez.nome}</option>
									{/if}
								{/foreach}
							</select>
						{/if}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<textarea class="form-control" name="descricao" id="descricao" style="height:150px;" placeholder="Descrição do Ticket"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3" style="padding-bottom: 26px;" onmouseover="javascript:verificaCamposIncidente()">
						<input class="btn btn-primary" type="button" id="submitIncidenteCreate" value="Registrar" onClick="javascript:sendPost('Incidente/create','fAgCreate');" />
					</div>
					<div class="col-md-9">
						<span id="respostaFormAjax" class="alert alert-error" style="display:none;" ></span>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>
<br>
<br>
<br>
<br>

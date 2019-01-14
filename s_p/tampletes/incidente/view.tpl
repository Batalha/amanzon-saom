<div class="container1" style="margin-top: 0px; margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/incidente/submenu.tpl" title=submenu}

	</div>
</div>
<br>
<div class="container1" style="width: 70%;">
	<form action="Instalacao_sp/edit" method="PobjT" id="FobjCreate" class="form" >
		<input type="hidden" name="incidentes_idincidentes" id="incidentes_idincidentes" value="{$obj.idincidentes}" />
		<input type="hidden" name="idatend" id="idatend" value="{$idatend}" />
		<input type="hidden" name="tempotrans" id="tempotrans" value="{if $controle[0].interrupcoes != ''}{$controle[0].interrupcoes}{else}{$tempoTranscorrido}{/if}" />
		<input type="hidden" name="tempoAtual" id="tempoAtual" value="{$tempoTranscorrido}" />
		<input type="hidden" name="status" id="status" value="{$status}" />
		<div class="row" style="height: 200px; font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 14px;" >
			<div class="form-group col-md-7" >
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title text-center">Ticket N° {$obj.idincidentes}</div>
					</div>
					<div class="panel-body" style="padding: 0px;">
						<table class="table table-bordered" style="width: 100%">
							<tr><td colspan="2"><b>Téncico NOC responsável:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$tecnicoResponsavel.nome}</td></tr>
							<tr><td width="30%"><b>Prioridade :</b></td><td>{$obj.prioridade}</td></tr>
							<tr><td><b>Data :</b></td><td>{$obj.data}</td></tr>
							<tr>
								<td><b>Tipo Ticket :</b></td><td>{$obj.solicitacao}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="form-group col-md-5">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title text-center">Cronômetro</div>
					</div>
					<div class="panel-body" style="padding: 0px;">
						<table class="table table-bordered" style="width: 100%">
							<tr height="15px">
								<td><b>Inicio Tarefa :</b></td><td>{$cronometro.data_inicio}</td>
							</tr>
							<tr>
								<td><b>Final Tarefa :</b></td><td>
									{if $cronometro.final_tarefa != '0000-00-00 00:00:00' && $cronometro.final_tarefa != '00/00/0000 00:00:00'}
										{$cronometro.final_tarefa}
									{/if}

								</td>
							</tr>
							<tr height="70px">
								<td colspan="2" >
									{if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 8}
											<div class="form-group col-md-8">
												<span id="tempoTranscorrido" class="cronometrofont">
													<input class="form-control input-lg" type="text" value="{if $controle[0].interrupcoes != ''}{$controle[0].interrupcoes}{else}{$tempoTranscorrido}{/if}" readonly="readonly">

												</span>
											</div>
											<div class="form-group col-md-4" {if $controle[0].final_tarefa != ""}hidden{else}{/if}>
												{if !$controle[0].data_pausa}
													<input type="button" class="btn-large btn-success" value="Pausar" onClick="javascript:
															sendPost('Incidente_sp/pausar','fAgCreate')"/>
												{else}
													<input type="button" class="btn-large btn-success" value="Despausar" onClick="javascript:
															sendPost('Incidente_sp/despausar','fAgCreate')"/>
												{/if}
											</div>
									{else}
										<div class="">
											<span id="tempoTranscorrido" class="cronometrofont">
												<input class="form-control input-lg" type="text" value="{if $controle[0].interrupcoes != ''}{$controle[0].interrupcoes}{else}{$tempoTranscorrido}{/if}" readonly="readonly">

											</span>
										</div>
									{/if}
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 14px;">
			<div class="form-group col-md-12">
				<div class="panel panel-primary" style="margin-top: -25px;">
					<div class="panel-body" style="padding: 0px;">
						<table class="table table-bordered">
							<tr>
								<td width="20%"><b>VSAT’s :</b></td>
								<td>
									{foreach from=$obj.instalacoes_sp item=instalacao}
										{$instalacao.nome} <b> / </b>
									{/foreach}

								</td>
							</tr>
							<tr>
								<td><b>Descrição :</b></td>
								<td style="font-size: 11px; padding: 15px 10px 20px 20px;">{$obj.descricao}</td>
							</tr>
						</table>
					</div>
				</div>

			</div>
		</div>
		<div class="row text-center">
			{if $login.perfis_idperfis != 3 && $login.perfis_idperfis != 8}
				{if $login.perfis_idperfis != 10}
					{if $obj.solicitacao_idsolicitacao == 1 ||  $obj.solicitacao_idsolicitacao == 2}
						<input type="button" class="btn btn-success" value="Atualizaçao da OS: {$num_os_sp}" onClick="javascript:getAjaxForm('OSSP/lista_atualizacao_os',false,{ldelim}param:{$obj.instalacoes_sp[0].os_sp_idos},ajax:1{rdelim})" />
					{/if}
				{/if}
				<input type="button" class="btn btn-primary" value="Editar Ticket" onClick="javascript:getAjaxForm('Incidente_sp/edit',false,{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" />
				<input type="button" class="btn btn-primary" value="Atendimentos" onClick="javascript:getAjaxForm('AtendVsat_sp/listeAtendsIncidente','divDinamico',{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" />
			{/if}
		</div>
	</form>
</div>


<div id="divDinamico">


	<div class="container1" style="width: 70%;">
		{if isset($atendimento.idatend_vsat)}
		<!--{*<form action="AgendaInstal_sp/create" method="POST" id="fAtEdit" class="form" >*}-->
		<form action="AtendVsat_sp/edit" method="POST" id="fAtEdit" class="form" >
			<input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$atendimento.idatend_vsat}"/>
			<input type="hidden" name="tmepo_transcorrido" id="tmepo_transcorrido" value="{$tempoTranscorrido}"/>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title">Atendimento : Nº {$atendimento.idatend_vsat}</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3">
							{if $atendimento.perfil_atend != 8}
							{if $atendimento.status_atend_idstatus_atend == 3}
								{if $atendimento.perfil_atend == 4 || $atendimento.perfil_atend == 1 || $atendimento.perfil_atend == 5}
									<input type="button" class="btn btn-success" value="Iniciar Atendimento" onclick="javascript:getAjaxForm('AtendVsat_sp/edit','divDinamico',{ldelim}param:{$atendimento.idatend_vsat},ajax:1{rdelim})" />

								{/if}
							{else}
								<input type="button" class="btn btn-success" value="Iniciar Atendimentos" onclick="javascript:getAjaxForm('AtendVsat_sp/edit','divDinamico',{ldelim}param:{$atendimento.idatend_vsat},ajax:1{rdelim})" />
							{/if}
							{/if}
						</div>
						{if $atendimento.perfil_atend != 10}
							<div class="col-md-6 text-center">
								<h4>Tecnico Responsavel : {$atendimento.usuario.nome}</h4>
							</div>
							{if $atendimento.perfil_atend != 8}
								<div class="col-md-3 text-right">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-incidente-view">Trocar Responsavel</button>

								</div>
							{/if}
						{/if}
					</div>
					<div class="row" style="padding: 0px;">
						<div class="form-group">
							<div class="borda1">
								<div class="borda2">
									<table border="0" width="100%">
										<tr>
											<td align="center" width="100%" bgcolor="white">

												{if $atendimento.perfil_atend != 10}
													{$atendimento.atendimento}

												{else}
													{$atendimento.privado}
												{/if}
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
		{else}
			<div id="caixaReservaParaListagem"></div>
		{/if}
	</div>
</div>


<div class="modal fade bs-incidente-view" id="modal_responsavel_comiss" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Lista de Tecnicos</h4>
			</div>
			<form name="trocar_responsavel" id="trocar_responsavel" action="" method="post">
				<input type="hidden" name="idatendVsat" id="idatendVsat" value="{$atendimento.idatend_vsat}" />
				<input type="hidden" name="idincidente" id="idincidente" value="{$obj.idincidentes}" />
				<div class="modal-body">
					<div class="row">
						<div class="col-md-5">
							<label for="usuarios_idusuarios">Trocar Tecnico Responsavel</label>
							<select name="usuarios_idusuarios" id="usuarios_idusuarios" class="form-control"
									onchange="javascript:selecaoSala()"
							>
								<option value="">Escolher Tecnico</option>
								{foreach from=$listaUsuarios item=vez}
									{if $vez.ativacao == 1 && $vez.incidentes == 1}
										<option value="{$vez.idusuarios}">{$vez.nome}</option>
									{/if}
								{/foreach}
							</select>
						</div>
						<div class="col-md-7">
							<label for="">Tecnico do Ticket</label>
							<div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="tecnico_ticket" id="" value="sim" checked="checked">
                                </span>
								<input type="text" class="form-control" readonly="readonly" value="Trocar Responsavel do Ticket?">
							</div>
						</div>
					</div>
					<br>
					<div class="row esconder" hidden>
						<div class="col-md-5"></div>
						<div class="col-md-7">
							<div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" name="sala" id="" value="2" {if $atendimento.sala == 2}checked="checked"{else}{/if}>
                                </span>
								<input type="text" class="form-control" readonly="readonly"  value="Noc?"

								>
                                <span class="input-group-addon">
                                    <input type="radio" name="sala" id="" value="3" {if $atendimento.sala == 3}checked="checked"{else}{/if}>
                                </span>
								<input type="text" class="form-control" readonly="readonly" value="Campo?">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="resposTrocaResponsavel"></div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary"
							onclick="javascript:
                                $.ajax(
                                    {ldelim}
                                        url:'Incidente_sp/trocaResponsavel',
                                        data:{ldelim}form:$('#trocar_responsavel').serialize(){rdelim},
                                        type:'POST',
                                        async:false,
                                        success:function( resposta )
                                        {ldelim}

                                            var r = jQuery.parseJSON(resposta);
                                            $('#resposTrocaResponsavel').html( r.msg );

		   									if( r.status == 'ok' )
                                                {ldelim}
                                                    setTimeout(function()
                                                    {ldelim}
                                                        $('#resposTrocaResponsavel').html('');
                                                        $('#modal_responsavel_comiss').modal('hide');
                                                    {rdelim},4000);

                                                {rdelim}
                                                else
                                                    {ldelim}
                                                        setTimeout(function()
                                                                        {ldelim}
                                                                            $('#respostaAssociacaoMotivo').html('');
                                                                        {rdelim},2000
                                                                    );

                                                    {rdelim}



                                        {rdelim}
                                    {rdelim}
                                );"

					>Savar dados</button>
				</div>
		</div><!-- /.modal-content -->
		</form>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	<div class="container1" style="width: 70%;">
		<form action="s_p/controller/AgendaInstal_sp/create" method="POST" id="fAtEdit" class="form" enctype="multipart/form-data">
			<input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$obj.idatend_vsat}"/>
			<input type="hidden" name="autorizacao" id="autorizacao" value="{$autorizacao}"/>
			<input type="hidden" name="atendimento_pai" id="atendimento_pai" value="{$obj.atendimento_pai}"/>
			<input type="hidden" name="incidentes_sp_idincidentes" id="incidentes_sp_idincidentes" value="{$obj.incidentes_sp_idincidentes}"/>
			<input type="hidden" name="instalacoes_sp_idinstalacoes_sp" id="instalacoes_sp_idinstalacoes_sp" value="{$obj.instalacoes_sp_idinstalacoes_sp}"/>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title">
						Atualizar atendimento
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-2 text-left" >
							<button id="input_atend_arquivo" name="input_atend_arquivo" style="top:-15px;"
								   type="button" class="btn-large btn-success" onclick="javascript:
									timeout = new Array(); // apaga timeout's
									$.ajax({ldelim}
									url:'AtendArquivo_sp/uploadForm',
									data:{ldelim}idatend_vsat:{$obj.idatend_vsat}{rdelim},
									type:'POST',
									success:function(resposta){ldelim}
									$('#arquivoAtend').html(resposta);
							{rdelim}
							{rdelim});
									">Arquivo  <i class="glyphicon glyphicon-cloud-upload"></i></button>
						</div>
						<div class="form-group col-md-10 text-left">
							<div id="arquivoAtend"></div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<textarea  name="atendimento" id="atendimento" style="height:150px;" placeholder="Atendimento"  class="form-control"></textarea>
						</div>
					</div>
						<div class="row" {if $autorizacao != 1} hidden {/if} >
							<div class="form-group col-md-4 text-left">
								<label for="status_atend_idstatus_atend">Status do Atendimento:</label>
								<select class="form-control" name="status_atend_idstatus_atend" id="status_atend_idstatus_atend" >
									<option value='1' {if $obj.status_atend_idstatus_atend == 1} selected {/if}>Aberto</option>
									<option value='2' {if $obj.status_atend_idstatus_atend == 2} selected {/if}>Em Atendimento</option>
									<option value='3' {if $obj.status_atend_idstatus_atend == 3} selected {/if}>Finalizado</option>
								</select>
							</div>
							<div class="form-group col-md-4 text-left">
								<label for="novoResponsavel">Repassar atendimento:</label>
								<select class="form-control" name="novoResponsavel" id="novoResponsavel">
									<option value="">Técnicos</option>
									{foreach from=$lista_atendentes item=atendentes}
										{if $atendentes.ativacao}
											{if ($atendentes.incidentes == 1)}
												<option value="{$atendentes.idusuarios}">{$atendentes.nome}</option>
											{/if}
										{/if}
									{/foreach}
								</select>
							</div>
							<div class="form-group col-md-4 text-left">
								<label for="tipo_atendimento_idtipo_atendimento">Tipos de atendimento:</label>
								<div class="">
									<select class="form-control autosave_atendvsat" name="tipo_atendimento_idtipo_atendimento" id="tipo_atendimento_idtipo_atendimento">
										{foreach from=$tipo_atendimento item=tipos}
											<option value="{$tipos.idtipo_atendimento}" {if $obj.tipo_atendimento_idtipo_atendimento == $tipos.idtipo_atendimento} selected {/if}>{$tipos.tipo_atendimento}</option>
										{/foreach}
									</select>
								</div>
							</div>
						</div>
						<div class="row" {if $autorizacao != 1} hidden {/if}>
							<div class="form-group col-md-12 text-left">
								<label for="email">Email   - <span style="color: red;">Obs: os emails devem ser separado por (,) virgula</span></label>
								<input class="form-control" type="text" name="email" id="email" placeholder="email-1, email-2, ....etc">
							</div>
						</div>
						<div class="row"  {if $autorizacao != 1} hidden {/if}>
							<div class="form-group col-md-12">
								<div class="">
									<textarea class="form-control autosave_atendvsat" id="resposta_agilis" name="resposta_agilis" style="height:150px;" placeholder="Privado">{$obj.resposta_agilis}</textarea>
								</div>
							</div>
						</div>
					{*{/if}*}
					<div class="row">
						<div class="form-group col-md-3 text-left">
							<input type="button" class="btn btn-primary" value="Atualizar"
								   onClick="javascript:
									   if( $('#status_atend_idstatus_atend').val() == 3 )
										   {ldelim}
                                                if ( $('#horas').val() == '' && $('#minutos').val() == '')
                                                    {ldelim}
                                                        $('#modal_tempo_atendimento').modal();
                                                    {rdelim}
                                                else
                                                    {ldelim}
												        $('#modal_motivo_atendimento').modal();
                                                    {rdelim}

										   {rdelim}

									   else if ( $('#status_atend_idstatus_atend').val() != 3 && $('#autorizacao').val() == 1)
										{ldelim}
											if ( $('#horas').val() == '' && $('#minutos').val() == '')
											{ldelim}
												$('#modal_tempo_atendimento').modal();
											{rdelim}


									   		else
											{ldelim}
												$.ajax(
												   {ldelim}
														url:'AtendVsat_sp/update',
														type:'POST',
														data:
														{ldelim}
															form:$('#fAtEdit').serialize()
														{rdelim},
														success:function(resposta)
															{ldelim}
															   $('#respostaAjax').html(resposta);
															   $('#respostaAjax').css( 'display' , 'block' );
																setTimeout( 'limpaAvisos()' , 5000 );
															{rdelim}
													{rdelim}
												);
												getAjaxForm('AtendVsat_sp/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim});
											{rdelim}
										{rdelim}
										else
										{ldelim}
												$.ajax(
												   {ldelim}
														url:'AtendVsat_sp/update',
														type:'POST',
														data:
														{ldelim}
															form:$('#fAtEdit').serialize()
														{rdelim},
														success:function(resposta)
															{ldelim}
															   $('#respostaAjax').html(resposta);
															   $('#respostaAjax').css( 'display' , 'block' );
																setTimeout( 'limpaAvisos()' , 5000 );
															{rdelim}
													{rdelim}
												);
												getAjaxForm('AtendVsat_sp/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim});
											{rdelim}

								   "/>
						</div>
						<div class="form-group col-md-9" style="margin-top: -15px;">
							<div id="respostaAjax"></div>
						</div>
					</div>
				</div>
			</div>


            <div class="modal hide fade" id="modal_tempo_atendimento" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                 aria-hidden="true" style="width: 30%">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                    <h3 id="modalLabel" class="text-center">Tempo do atendimento</h3>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <h4><b style="color: #006288;">Tempo gasto para resposta ao cliente.</b></h4>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="col-md-12">-->
                            <div class="form-group col-md-2">
                                <label for="horas">Hrs</label>
                                <input class="form-control" type="text" maxlength="2" name="horas" id="horas">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="minutos">Min</label>
                                <input class="form-control" type="text" maxlength="2" name="minutos" id="minutos">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="tipo_resposta">Tipo de Resposta</label>
                                <select class="form-control" name="tipo_resposta" id="tipo_resposta">
                                    <option value="">--Selecione--</option>
                                </select>
                            </div>

                            <!--</div>-->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <table style="width:100%;">
                        <tr>
                            <td style='width:150px;'>
                                <button class="btn" data-dismiss="modal" aria-hidden="true">OK</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
		</form>
	</div>


<!-- ############# MODAL ############# -->




<!-- ############# MODAL ############# -->

	<div class="modal hide fade" id="modal_motivo_atendimento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
	    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    	<h3 id="myModalLabel">Motivo do atendimento</h3>
	  	</div>
	  	<form name="motivo_atendimento" id="motivo_atendimento" action="" method="POST">
			<input name="idatendimento" id="idatendimento" type="hidden" value="{$obj.idatend_vsat}"/>
			<div class="modal-body">

				<div class="container-fluid">
					<div class="row">
						<div class="form-group col-md-12">
							{*<label style="text-transform:capitalize;">Causas</label>*}
							<select class="form-control" name="idmotivo" id="idmotivo">
								<option value="">Causa</option>
								{foreach from=$motivos item=motivo}
									<option value="{$motivo.idmotivo_atendimento}"
											{if $motivosJaPresentes[0].idmotivo == $motivo.idmotivo_atendimento}selected{/if}>
										{$motivo.motivo}
									</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							{*<label style="text-transform:capitalize;">Responsavel</label>*}
							<select class="form-control" name="idresponsavel" id="idresponsavel">
								<option value="">Responsavel</option>
								{foreach from=$responsaveis item=responsavel}
									<option value="{$responsavel.idresponsavel_atendimento}"
											{if $motivosJaPresentes[0].idresponsavel == $responsavel.idresponsavel_atendimento}selected{/if}>
										{$responsavel.responsavel}
									</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">

				<table style="width:528px;">
					<tr>
						<td style='width:382px;'><div id="respostaAssociacaoMotivo"></div></td>
						<td style='width:150px;'>
							<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
							<input type="button" class="btn btn-primary"
								   onclick="javascript:
								$.ajax({ldelim}
									url:'AtendVsat_sp/insereMotivoParaAtendimentoFechado',
									data:{ldelim}form:$('#motivo_atendimento').serialize(){rdelim},
									type:'POST',
									async:false,
									success:function( resposta )
									{ldelim}

										var r = jQuery.parseJSON(resposta);
										$('#respostaAssociacaoMotivo').html( r.msg );

										if( r.status == 'ok' )
										{ldelim}
											setTimeout(function()
											{ldelim}
												$('#respostaAssociacaoMotivo').html('');
												$('#modal_motivo_atendimento').modal('hide');
												$.ajax(
												{ldelim}
													url:'AtendVsat_sp/update',
													type:'POST',
													data:{ldelim}form:$('#fAtEdit').serialize(){rdelim},
													success:function(resposta){ldelim}
														$('#respostaAjax').html(resposta);
														$('#respostaAjax').css( 'display' , 'block' );
														setTimeout( 'limpaAvisos()' , 5000 );
													{rdelim}
												{rdelim});
											{rdelim},
											4000);

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

								{rdelim});
								" value="Salvar"
									/>
							</td>
					</tr>
				</table>
			</div>
	  	</form>
	</div>
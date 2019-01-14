

<div class="container">
	<form action="AgendaInstal/create" method="POST" id="fAtEdit" class="form" >
		<input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$obj.idatend_vsat}"/>
		<input type="hidden" name="atendimento_pai" id="atendimento_pai" value="{$obj.atendimento_pai}"/>
		<input type="hidden" name="incidentes_idincidentes" id="incidentes_idincidentes" value="{$obj.incidentes_idincidentes}"/>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Atualizar atendimento</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12">
						<input type="hidden" name="atendimento_anterior" id="atendimento_anterior" value="{$obj.atendimento}" />
						<textarea name="atendimento" id="atendimento"  style="height:150px;"  class="form-control inputReq" placeholder="Atendimento"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="status_atend_idstatus_atend">Status do Atendimento:</label>
						<select class="form-control" name="status_atend_idstatus_atend" id="status_atend_idstatus_atend" >
							<option value='1' {if $obj.status_atend_idstatus_atend == 1} selected {/if}>Aberto</option>
							<option value='2' {if $obj.status_atend_idstatus_atend == 2} selected {/if}>Em Atendimento</option>
							<option value='3' {if $obj.status_atend_idstatus_atend == 3} selected {/if}>Finalizado</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="novoResponsavel">Repassar atendimento:</label>
						<select class="form-control" name="novoResponsavel" id="novoResponsavel" {if $autorizacao == 0}disabled{/if}>
							<option value="">Técnicos</option>
							{foreach from=$lista_atendentes item=atendentes}
								{if
								($idperfil == 4)&&($atendentes.perfis_idperfis == 1 or $atendentes.perfis_idperfis == 2 or $atendentes.perfis_idperfis == 3 or $atendentes.perfis_idperfis == 5)||
								($idperfil == 5)&&($atendentes.perfis_idperfis == 1 or $atendentes.perfis_idperfis == 2 or $atendentes.perfis_idperfis == 3 or $atendentes.perfis_idperfis == 5)||
								($idperfil == 1)&&($atendentes.perfis_idperfis == 1)||
								($idperfil == 2)&&($atendentes.perfis_idperfis == 2 or $atendentes.subperfil_idsubperfil == 1 )||
								($idperfil == 3)&&($atendentes.perfis_idperfis == 3 or $atendentes.subperfil_idsubperfil == 1 )

								}
									<option value="{$atendentes.idusuarios}">{$atendentes.nome}</option>
								{/if}
							{/foreach}
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="tipo_atendimento_idtipo_atendimento">Tipos de atendimento:</label>
						<div class="">

							<select class="form-control autosave_atendvsat" name="tipo_atendimento_idtipo_atendimento" id="tipo_atendimento_idtipo_atendimento" {if $autorizacao == 0}disabled{/if}>
								{foreach from=$tipo_atendimento item=tipos}
									<option value="{$tipos.idtipo_atendimento}" {if $obj.tipo_atendimento_idtipo_atendimento == $tipos.idtipo_atendimento} selected {/if}>{$tipos.tipo_atendimento}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<textarea class="form-control autosave_atendvsat" id="resposta_agilis" name="resposta_agilis" style="height:150px;" placeholder="Resposta do Agilis">{$obj.resposta_agilis}</textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input type="button" class="btn btn-primary" value="Atualizar"
							   onClick="javascript:
									   if( $('#status_atend_idstatus_atend').val() == 3 ){ldelim}

									   $('#modal_motivo_atendimento').modal();

							   {rdelim}else{ldelim}

									   $.ajax({ldelim}
									   url:'AtendVsat/update',
									   type:'POST',
									   data:{ldelim}form:$('#fAtEdit').serialize(){rdelim},
									   success:function(resposta){ldelim}
									   $('#respostaAjax').html(resposta);
									   $('#respostaAjax').css( 'display' , 'block' );
									   setTimeout( 'limpaAvisos()' , 5000 );
							   {rdelim}
							   {rdelim});

							   {rdelim}
									   " />

						<input type="button" class="btn btn-default" value="Cancelar"
							   onClick="javascript:
									   getAjaxForm('AtendVsat/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim});
									   " />
					</div>
					<div class="form-group col-md-8">
						<div id="respostaAjax"></div>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>


<!-- ############# MODAL ############# -->

<div class="modal hide fade" id="modal_motivo_atendimento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Motivo do atendimento</h3>
	</div>


	<form name="motivo_atendimento" id="motivo_atendimento" action="" method="POST">
		<input name="idatendimento" id="idatendimento" type="hidden" value="{$obj.idatend_vsat}"/>
		<div class="modal-body">



			<table border="0">
				<tr>
					<td style="width:100px;text-align:left;">
						<label style="text-transform:capitalize;">Causas</label>
					</td>
					<td style="width:15px;">&nbsp;</td>
					<td style="width:100px;text-align:left;">
						<select name="idmotivo" id="idmotivo">
							<option></option>
							{foreach from=$motivos item=motivo}
								<option value="{$motivo.idmotivo_atendimento}"
										{if $motivosJaPresentes[0].idmotivo == $motivo.idmotivo_atendimento}selected{/if}>
									{$motivo.motivo}
								</option>
							{/foreach}
						</select>
					</td>
				</tr>
			</table>
			<table border="0">
				<tr>
					<td style="width:100px;text-align:left;">
						<label style="text-transform:capitalize;">Responsavel</label>
					</td>
					<td style="width:15px;">&nbsp;</td>
					<td style="width:100px;text-align:left;">
						<select name="idresponsavel" id="idresponsavel">
							<option></option>
							{foreach from=$responsaveis item=responsavel}
								<option value="{$responsavel.idresponsavel_atendimento}"
										{if $motivosJaPresentes[0].idresponsavel == $responsavel.idresponsavel_atendimento}selected{/if}>
									{$responsavel.responsavel}
								</option>
							{/foreach}
						</select>
					</td>
				</tr>
			</table>


		</div>
		<div class="modal-footer">

			<table style="width:528px;">
				<tr>
					<td style='width:382px;'><div id="respostaAssociacaoMotivo"></div></td>
					<td style='width:150px;'>
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<input type="button" class="btn btn-primary" onclick="javascript:
								$.ajax({ldelim}
								url:'AtendVsat/insereMotivoParaAtendimentoFechado',
								data:{ldelim}form:$('#motivo_atendimento').serialize(){rdelim},
								type:'POST',
								async:false,
								success:function( resposta ){ldelim}

								var r = jQuery.parseJSON(resposta);
								$('#respostaAssociacaoMotivo').html( r.msg );

								if( r.status == 'ok' ){ldelim}

								setTimeout(function(){ldelim}
								$('#respostaAssociacaoMotivo').html('');
								$('#modal_motivo_atendimento').modal('hide');
								$.ajax({ldelim}
								url:'AtendVsat/update',
								type:'POST',
								data:{ldelim}form:$('#fAtEdit').serialize(){rdelim},
								success:function(resposta){ldelim}
								$('#respostaAjax').html(resposta);
								$('#respostaAjax').css( 'display' , 'block' );
								setTimeout( 'limpaAvisos()' , 5000 );
						{rdelim}
						{rdelim});
						{rdelim},4000);

						{rdelim}else{ldelim}

								setTimeout(function(){ldelim}
								$('#respostaAssociacaoMotivo').html('');
						{rdelim},2000);

						{rdelim}

						{rdelim}
						{rdelim});
								" value="Salvar" />
					</td>
				</tr>
			</table>
		</div>
	</form>
</div>
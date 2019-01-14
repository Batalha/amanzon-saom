
<div 
	style="
		width:1020px;
	">
	
	<table class="table">
		<thead style="background: #00A8E7;">
			<tr>
				<th><i class="icon-exclamation-sign"></i>&nbsp;&nbsp;Comissionamentos</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<br/>
					<ul>
					{foreach from=$lista_comissionamentos_pendentes item=comissionamento}
						<li id="comissionamento_{$comissionamento.idinstalacoes_sp}" 
							style="overflow:hidden;width:950px;height:100px;border:1px solid #ccc;">
							
							<table style="width:950px;">
								<tr>
									<td style="padding:0px;border:0px;height:100px;">
									
									<table style="position:relative;width:950px;z-index:5;" 
										id="resumo_comissionamento_{$comissionamento.idinstalacoes_sp}">
										<tr>
											<td style="width:30px;">
												<a title="Ver Comissionamento" class="btn btn-danger" onclick="javascript:
													$.ajax({ldelim}
														url:'OSSP/view',
														async:false,
														type:'POST',
														data:{ldelim}param:{$comissionamento.os_sp_idos}{rdelim},
														success:function(resposta){ldelim}
		
															$('#conteudo').html(resposta);
															$.ajax({ldelim}
																url:'Comissionamento_sp/comiss_view',
																async:false,
																type:'POST',
																data:{ldelim}param:{$comissionamento.idinstalacoes_sp}{rdelim},
																success:function(resposta){ldelim}
		
																	$('#dadosInstal').html(resposta);
																
																{rdelim}
															{rdelim});
															
														{rdelim}
													{rdelim});">
													<i class="icon-bookmark"></i>
												</a><br/><br/>
												<a href="#comissionamento_{$comissionamento.idinstalacoes_sp}" class="btn expande_comissionamento_{$comissionamento.idinstalacoes_sp}" 
													title="Expandir" onclick="javascript:
														$('#comissionamento_{$comissionamento.idinstalacoes_sp}').css('height','auto');
														$('.expande_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','none');
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','block');
														$('#comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','#ccc');
														
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp}').addClass('resumo_comissionamento_home');
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','#EEEEEE');
														altura_resumo_caixaEntrada = document.getElementById( $('.resumo_comissionamento_home').attr('id') ).offsetTop;
														
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}_last').addClass('limite_baixo_caixa_home');
														">
													<i class="icon-arrow-down"></i>
												</a><br/><br/>
												<a href="#comissionamento_{$comissionamento.idinstalacoes_sp}" class="btn esconde_comissionamento_{$comissionamento.idinstalacoes_sp}" 
													title="Esconder" style="display:none;" onclick="javascript:
														$('#comissionamento_{$comissionamento.idinstalacoes_sp}').css('height','100px');
														$('.expande_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','block');
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','none');
														$('#comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','');
														setTimeout(function(){ldelim}window.scrollBy(0,-50);{rdelim},1);

														$('.resumo_comissionamento_home').css('position','relative');
														$('.resumo_comissionamento_home').css('top','0px');
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','none');
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp}').removeClass('resumo_comissionamento_home');
														
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}_last').removeClass('limite_baixo_caixa_home');
														">
													<i class="icon-arrow-up"></i>
												</a>
											</td>
											<td style="width:100px;">
												<b>OS:</b>&nbsp;
												<a title="Ver comissionamento" onclick="javascript:
													$.ajax({ldelim}
														url:'OSSP/view',
														async:false,
														type:'POST',
														data:{ldelim}param:{$comissionamento.os_sp_idos}{rdelim},
														success:function(resposta){ldelim}
		
															$('#conteudo').html(resposta);
															$.ajax({ldelim}
																url:'Comissionamento_sp/comiss_view',
																async:false,
																type:'POST',
																data:{ldelim}param:{$comissionamento.idinstalacoes_sp}{rdelim},
																success:function(resposta){ldelim}
		
																	$('#dadosInstal').html(resposta);
																
																{rdelim}
															{rdelim});
															
														{rdelim}
													{rdelim});
													">{$comissionamento.os.numOS}</a>
											</td>
											<td style="width:230px;">
												<b>Data Solicitação:</b>&nbsp;
												{$comissionamento.os.dataSolicitacao}
											</td>
											<td style="width:170px;">
												<b>Prazo:</b>&nbsp;
												{$comissionamento.os.prazoInstal}
											</td>
											<td style="width:200px;">
												<b>Cidade:</b>&nbsp;
												{$comissionamento.municipio.municipio}
											</td>
											<td style="width:250px;">
												<b>Instalação:</b>&nbsp;
												{$comissionamento.nome}
											</td>
										</tr>
									</table>
									
									</td>
								<tr>

									<td>

										<div class="container1" style="margin-top: 30px;">
											<div class="row">
												<div class="form-group col-md-4">
													<div class="form-group">
														<h4>Técnico de Campo</h4>
													</div>
													<div class="row">
														<div class="form-group"><strong>Nome: </strong> {$comissionamento.teccampo}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Telefone: </strong> {$comissionamento.teccampo_tel}</div>
													</div>
												</div>


												<div class="form-group col-md-4">
													<div class="form-group">
														<h4>Logs</h4>
													</div>
													<div class="row">
														<div class="form-group"><strong>Iniciado Por: </strong> {$comissionamento.usuarioComissionador.nome} - {$comissionamento.create_user_comiss_time}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Responsavel Por: </strong> {$comissionamento.usuarioComissionador.nome} - {$comissionamento.create_user_comiss_time}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Modificado Por: </strong> {$comissionamento.usuarioEditouPorUltimo.nome} - {$comissionamento.last_user_comiss_time}</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="form-group col-md-4">
													<div class="form-group">
														<h4>Dados Instalação</h4>
													</div>
													<div class="row">
														<div class="form-group"><strong>Registro Concessionária: </strong> {$comissionamento.registro_concessionaria}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Nome do Operador(a): </strong> {$comissionamento.ope_eutelsat}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Cross-pol EutelSat: </strong> {$comissionamento.val_crosspol}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Latitude: </strong>
															{$comissionamento.latitude_graus}°&nbsp;
															{$comissionamento.latitude_minutos}"&nbsp;
															{$comissionamento.latitude_segundos}'&nbsp;
															{if $comissionamento.latitude_direcao=='S'}S{elseif $comissionamento.latitude_direcao=='N'}N{/if}
														</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Longitude: </strong>
															{$comissionamento.longitude_graus}°&nbsp;
															{$comissionamento.longitude_minutos}"&nbsp;
															{$comissionamento.longitude_segundos}'&nbsp;
															{if $comissionamento.longitude_direcao=='W'}W{elseif $comissionamento.longitude_direcao=='E'}E{/if}
														</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Azimute: </strong> {$comissionamento.azimute_comiss}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Elevacao: </strong> {$comissionamento.elevacao_comiss}</div>
													</div>
												</div>


												<div class="form-group col-md-4">
													<div class="form-group">
														<h4>Dados Equipamentos</h4>
													</div>
													<div class="row">
														<div class="form-group"><strong>SNR na VSAT: </strong> {$comissionamento.snr_comiss}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>MAC: </strong> {$comissionamento.mac_comiss}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>NS da Vsat:</strong> {$comissionamento.nsmodem_comiss}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>NS da ODU: </strong> {$comissionamento.nsodu_comiss}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>ODU/BUC: </strong> {$comissionamento.tipoEquipamentoODU.nome}</div>
													</div>
													<div class="row">
														<div class="form-group"><strong>Antena marca - NS:</strong>
															{if $comissionamento.antena_comiss eq 'patriot'}
															Patriot
															{elseif $comissionamento.antena_comiss eq 'skyware'}
															Skyware
															{/if}
															&nbsp;&nbsp;&nbsp;{$comissionamento.antena_ns_comiss}
														</div>
													</div>
												</div>
											</div>

											<table>

												<tr><td colspan="2" class="padding10">

														<!-- ----------------------------------------------------------------------------
														----------------------- DADOS TESTES --------------------------------------------
														----------------------------------------------------------------------------- -->

														<!-- Solução temporária, depois retirar-->
														<input type="hidden" name="packetshapper" id="packetshapper" value="1" />
														<input type="hidden" name="reglicenca" id="reglicenca" value="1" />
														<input type="hidden" name="opmanager" id="opmanager" value="1" />
														<input type="hidden" name="webnms" id="webnms" value="1" />
														<!-- Solução temporária, depois retirar -->
														<input type="hidden" name="test_e_termo_aceite" id="test_e_termo_aceite" {if $comissionamento.test_e_termo_aceite == 1 || $comissionamento.termo_aceite != ''}checked{/if} />

														<table class="tabelas_dados">

															<tr>
																<td colspan="6" style="padding-left:10px;text-align:left;border:0px">
																	<h4>Inicio de Testes</h4>
																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label for="test_sl2000">Testou Sat Link 2000?</label>
																</td>
																<td class="texto_check_test" colspan="5" style="border:0px">
																	{if $comissionamento.test_sl2000 eq 1} Sim {else} Não {/if}
																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																   <label>Auto comissionamento foi realizado?</label>
																</td>
																<td class="texto_check_test" colspan="5" style="border:0px">
																	{if $comissionamento.autocomiss eq 1} Sim {else} Não {/if}
																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label>Verificada a versão do software utilizado?</label>
																</td>
																<td class="texto_check_test" colspan="5" style="border:0px">
																	{if $comissionamento.test_software eq 1} Sim {else} Não {/if}
																</td>
															</tr>

															<tr >
																<td class="input_check_test" style="border:0px">
																	<label>Verificado o tamanho e o tipo da antena?</label>
																</td>
																<td class="texto_check_test" colspan="5" style="border:0px">
																	{if $comissionamento.test_antena eq 1} Sim {else} Não {/if}
																</td>
															</tr>

															<tr >
																<td class="input_check_test" style="border:0px">
																	<label>Verificado o tipo do buc?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_buc eq 1} Sim {else} Não {/if}
																</td>
																<td colspan="4" style="border:0px">
																	&nbsp;
																</td>
															</tr>

															<tr >
																<td class="input_check_test" style="border:0px">
																	<label>Verificado os níveis de TX?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_tx eq 1} Sim {else} Não {/if}
																</td>
																<td style="text-align:right;padding-right:10px;border:0px">
																	<div class="tx_input_1" style="{if $comissionamento.test_tx != 1}visibility: hidden{/if}">
																		<label>EB/N0:</label>
																	</div>
																</td>
																<td style="text-align:left;border:0px">
																	<div class="tx_input_1" style="{if $comissionamento.test_tx != 1}visibility: hidden{/if}">
																		{$comissionamento.ebno_comiss}
																	</div>
																</td>
																<td style="text-align:right;padding-right:10px;padding-left:50px;border:0px">
																	<div class="tx_input_2" style="{if $comissionamento.test_tx != 1}visibility: hidden{/if}">
																		<label>EIRP Configurado:</label>
																	</div>
																</td>
																<td style="text-align:left;border:0px">
																	<div class="tx_input_2" style="{if $comissionamento.test_tx != 1}visibility: hidden{/if}">
																		{$comissionamento.eirp_comiss}
																	</div>
																</td>
															</tr>

															<tr >
																<td class="input_check_test" style="border:0px">
																	<label>Teste de calibrate?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_calibrate eq 1} Sim {else} Não {/if}
																</td>
																<td colspan="4" style="border:0px">

																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																   <label>Registro do comprimento/distância do cabo entre buc e modem?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_cabo eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	<div class="cabo_input" style="{if $comissionamento.test_cabo != 1}visibility: hidden;{/if}text-align:right;">
																		<label for="comp_cabo_comiss">Valor:</label>
																	</div>
																</td>
																<td colspan="3" style="border:0px">
																	<div class="cabo_input" style="{if $comissionamento.test_cabo != 1}visibility: hidden;{/if}text-align:left;">
																		{$comissionamento.comp_cabo_comiss}
																	</div>
																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																   <label>Registro de condições climáticas?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_clima eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	<div class="clima_inputs" style="{if $comissionamento.test_clima != 1}visibility:hidden{/if}">
																		{$comissionamento.desc_clima_comiss}
																	<div>
																</td>
																<td colspan="3" style="border:0px">

																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label>Retirou a imagem do PRTG/NAGIOS?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_prtg eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	&nbsp;
																</td>
																<td colspan="3" style="border:0px">

																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label>Coletar informações de RX e TX?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_info_rx_tx eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	&nbsp;
																</td>
																<td colspan="3" style="border:0px">

																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label>Finalizou o Termo de Aceite?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_f_termo_aceite eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	&nbsp;
																</td>
																<td colspan="3" style="border:0px">

																</td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label>Enviou a notificação de início de teste a Prodemge?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.test_notificacao_inicio eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	&nbsp;
																</td>
																<td style="border:0px"></td>
															</tr>

															<tr>
																<td class="input_check_test" style="border:0px">
																	<label>Conectou o cabo RJ45?</label>
																</td>
																<td class="texto_check_test" style="border:0px">
																	{if $comissionamento.cabo_rj45 eq 1} Sim {else} Não {/if}
																</td>
																<td style="border:0px">
																	<div id="pergunta_cabo_rj45">
																		{if $comissionamento.cabo_rj45 eq 1}
																			Onde?
																		{else}
																			Porquê?
																		{/if}
																	</div>
																	<div id="justificativa_cabo_rj45">
																		<span {if $comissionamento.cabo_rj45 eq 1}{else}style="visibility:hidden;position:absolute;"{/if}>
																			{$comissionamento.cabo_rj45_justificativa_sim}
																		</span>

																		<span {if $comissionamento.cabo_rj45 eq 1}style="visibility:hidden;position:absolute;"{else}{/if}>
																			{$comissionamento.cabo_rj45_justificativa_nao}
																		</span>
																	</div>
																</td>
																<td colspan="3" style="border:0px">

																</td>
															</tr>
														</table>
												</td>
												</tr>
											</table>
										</div>


									</td>
								</tr>
							</table>
							
						</li>
						<li style="height:50px;width:950px;">
							<a href="#comissionamento_{$comissionamento.idinstalacoes_sp_sp}">
								<div class="btn expande_comissionamento_{$comissionamento.idinstalacoes_sp}" onclick="javascript:
									$('#comissionamento_{$comissionamento.idinstalacoes_sp}').css('height','auto');
									$('.expande_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','none');
									$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','block');
									$('#comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','#ccc');

									$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp}').addClass('resumo_comissionamento_home');
									$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','#EEEEEE');
									altura_resumo_caixaEntrada = document.getElementById( $('.resumo_comissionamento_home').attr('id') ).offsetTop;
									
									$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}_last').addClass('limite_baixo_caixa_home');
									" style="width:100%;"><i class="icon-arrow-down"></i>&nbsp;Expandir</div>
									
								<div id="esconde_comissionamento_{$comissionamento.idinstalacoes_sp}_last" class="btn esconde_comissionamento_{$comissionamento.idinstalacoes_sp} esconde_comissionamento_{$comissionamento.idinstalacoes_sp}_last" onclick="javascript:
									$('#comissionamento_{$comissionamento.idinstalacoes_sp}').css('height','100px');
									$('.expande_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','block');
									$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}').css('display','none');
									$('#comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','');
									setTimeout(function(){ldelim}window.scrollBy(0,-50);{rdelim},1);
									
									$('.resumo_comissionamento_home').css('position','relative');
									$('.resumo_comissionamento_home').css('top','0px');
									$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp} td').css('background','none');
									$('#resumo_comissionamento_{$comissionamento.idinstalacoes_sp}').removeClass('resumo_comissionamento_home');

									$('.esconde_comissionamento_{$comissionamento.idinstalacoes_sp}_last').removeClass('limite_baixo_caixa_home');
									" style="width:100%;display:none;"><i class="icon-arrow-up"></i>&nbsp;Esconder</div>
							</a>
						</li>
					{/foreach}
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
<hr/>
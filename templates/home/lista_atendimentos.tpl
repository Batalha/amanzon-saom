
<div 
	style="
		width:1020px;
	">
	
	<table class="table">
		<thead style="background: #F2DEDE;">
			<tr>
				<th><i class="icon-exclamation-sign"></i>&nbsp;&nbsp;Atendimentos</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<br/>
					<ul>
					{foreach from=$lista_atendimentos_pendentes item=incidente}
						{foreach from=$incidente item=atendimento_pendente}
						<li id="atendimento_{$atendimento_pendente.idatend_vsat}" 
							style="overflow:hidden;width:950px;height:100px;border:1px solid #ccc;">
							<table style="width:950px;">
								<tr>
									<td style="padding:0px;border:0px;height:100px;">
									
									<table style="position:relative;width:950px;z-index:5;" 
										id="resumo_atendimento_{$atendimento_pendente.idatend_vsat}">
										<tr>
											<td style="width:30px;">
												<a title="Ver Atendimento" class="btn btn-danger" onclick="javascript:
													$.ajax({ldelim}
														url:'Incidente/view',
														async:false,
														type:'POST',
														data:{ldelim}param:{$atendimento_pendente.incidentes_idincidentes}{rdelim},
														success:function(resposta){ldelim}
		
															$('#conteudo').html(resposta);
															$.ajax({ldelim}
																url:'AtendVsat/view',
																async:false,
																type:'POST',
																data:{ldelim}param:{$atendimento_pendente.idatend_vsat}{rdelim},
																success:function(resposta){ldelim}
		
																	$('#divDinamico').html(resposta);
																
																{rdelim}
															{rdelim});
															
														{rdelim}
													{rdelim});">
													<i class="icon-bookmark"></i>
												</a><br/><br/>
												<a href="#atendimento_{$atendimento_pendente.idatend_vsat}" class="btn expande_atendimento_{$atendimento_pendente.idatend_vsat}" 
													title="Expandir" onclick="javascript:
														$('#atendimento_{$atendimento_pendente.idatend_vsat}').css('height','auto');
														$('.expande_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','none');
														$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','block');
														$('#atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','#ccc');
														
														$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat}').addClass('resumo_atendimento_home');
														$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','#EEEEEE');
														altura_resumo_caixaEntrada = document.getElementById( $('.resumo_atendimento_home').attr('id') ).offsetTop;

														$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}_last').addClass('limite_baixo_caixa_home');
														">
													<i class="icon-arrow-down"></i>
												</a><br/><br/>
												<a href="#atendimento_{$atendimento_pendente.idatend_vsat}" class="btn esconde_atendimento_{$atendimento_pendente.idatend_vsat}" 
													title="Esconder" style="display:none;" onclick="javascript:
														$('#atendimento_{$atendimento_pendente.idatend_vsat}').css('height','100px');
														$('.expande_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','block');
														$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','none');
														$('#atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','');
														setTimeout(function(){ldelim}window.scrollBy(0,-50);{rdelim},1);

														$('.resumo_atendimento_home').css('position','relative');
														$('.resumo_atendimento_home').css('top','0px');
														$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','none');
														$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat}').removeClass('resumo_atendimento_home');

														$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}_last').removeClass('limite_baixo_caixa_home');
														">
													<i class="icon-arrow-up"></i>
												</a>
											</td>
											<td style="width:150px;">
												<b>Data:</b>&nbsp;
												{$atendimento_pendente.data}
											</td>
											<td style="width:150px;">
												<b>Incidente:</b>&nbsp;
												<a title="Ver Atendimento" onclick="javascript:
													$.ajax({ldelim}
														url:'Incidente/view',
														async:false,
														type:'POST',
														data:{ldelim}param:{$atendimento_pendente.incidentes_idincidentes}{rdelim},
														success:function(resposta){ldelim}
		
															$('#conteudo').html(resposta);
															$.ajax({ldelim}
																url:'AtendVsat/view',
																async:false,
																type:'POST',
																data:{ldelim}param:{$atendimento_pendente.idatend_vsat}{rdelim},
																success:function(resposta){ldelim}
		
																	$('#divDinamico').html(resposta);
																
																{rdelim}
															{rdelim});
															
														{rdelim}
													{rdelim});
													">{$atendimento_pendente.incidentes_idincidentes}</a>
											</td>
											<td style="width:250px;">
												<b>Atendimento:</b>&nbsp;
												{$atendimento_pendente.resumo_atendimento}
											</td>
											<td style="width:250px;">
												<b>Resposta Agilis:</b>&nbsp;
												{$atendimento_pendente.resumo_resposta_agilis}
											</td>
											<td style="width:150px;">
												<b>Status:</b>&nbsp;
												{$atendimento_pendente.status}
											</td>
										</tr>
									</table>
									
									</td>
								<tr>
									<td style="padding:0px;border:0px;">
										<table>
											<tr><td style="width:450px;">
												<b>Atendimento:</b>&nbsp;
												{$atendimento_pendente.atendimento}
											</td>
												
											<td style="width:50px;">&nbsp;</td>
												
											<td style="width:450px;">
												<b>Resposta Agilis:</b>&nbsp;
												{$atendimento_pendente.resposta_agilis}
											</td></tr>
										</table>
									</td>
								</tr>
							</table>
						</li>
						<li style="height:50px;width:950px;">
							<a href="#atendimento_{$atendimento_pendente.idatend_vsat}">
								<div class="btn expande_atendimento_{$atendimento_pendente.idatend_vsat}" onclick="javascript:
									$('#atendimento_{$atendimento_pendente.idatend_vsat}').css('height','auto');
									$('.expande_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','none');
									$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','block');
									$('#atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','#ccc');

									$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat}').addClass('resumo_atendimento_home');
									$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','#EEEEEE');
									altura_resumo_caixaEntrada = document.getElementById( $('.resumo_atendimento_home').attr('id') ).offsetTop;
									
									$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}_last').addClass('limite_baixo_caixa_home');
									" style="width:100%;"><i class="icon-arrow-down"></i>&nbsp;Expandir</div>
									
								<div id="esconde_atendimento_{$atendimento_pendente.idatend_vsat}_last" class="btn esconde_atendimento_{$atendimento_pendente.idatend_vsat} esconde_atendimento_{$atendimento_pendente.idatend_vsat}_last" onclick="javascript:
									$('#atendimento_{$atendimento_pendente.idatend_vsat}').css('height','100px');
									$('.expande_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','block');
									$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}').css('display','none');
									$('#atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','');
									setTimeout(function(){ldelim}window.scrollBy(0,-50);{rdelim},1);
									
									$('.resumo_atendimento_home').css('position','relative');
									$('.resumo_atendimento_home').css('top','0px');
									$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat} td').css('background','none');
									$('#resumo_atendimento_{$atendimento_pendente.idatend_vsat}').removeClass('resumo_atendimento_home');

									$('.esconde_atendimento_{$atendimento_pendente.idatend_vsat}_last').removeClass('limite_baixo_caixa_home');
									" style="width:100%;display:none;"><i class="icon-arrow-up"></i>&nbsp;Esconder</div>
							</a>
						</li>
						{/foreach}
					{/foreach}
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
<hr/>
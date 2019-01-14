
<div 
	style="
		width:1020px;
	">
	
	<table class="table">
		<thead style="background: #F2DEDE;">
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
						<li id="comissionamento_{$comissionamento.idinstalacoes}" 
							style="overflow:hidden;width:950px;height:100px;border:1px solid #ccc;">
							
							<table style="width:950px;">
								<tr>
									<td style="padding:0px;border:0px;height:100px;">
									
									<table style="position:relative;width:950px;z-index:5;" 
										id="resumo_comissionamento_{$comissionamento.idinstalacoes}">
										<tr>
											<td style="width:30px;">
												<a title="Ver Comissionamento" class="btn btn-danger" onclick="javascript:
													$.ajax({ldelim}
														url:'OS/view',
														async:false,
														type:'POST',
														data:{ldelim}param:{$comissionamento.os_idos}{rdelim},
														success:function(resposta){ldelim}
		
															$('#conteudo').html(resposta);
															$.ajax({ldelim}
																url:'Comissionamento/comiss_view',
																async:false,
																type:'POST',
																data:{ldelim}param:{$comissionamento.idinstalacoes}{rdelim},
																success:function(resposta){ldelim}
		
																	$('#dadosInstal').html(resposta);
																
																{rdelim}
															{rdelim});
															
														{rdelim}
													{rdelim});">
													<i class="icon-bookmark"></i>
												</a><br/><br/>
												<a href="#comissionamento_{$comissionamento.idinstalacoes}" class="btn expande_comissionamento_{$comissionamento.idinstalacoes}" 
													title="Expandir" onclick="javascript:
														$('#comissionamento_{$comissionamento.idinstalacoes}').css('height','auto');
														$('.expande_comissionamento_{$comissionamento.idinstalacoes}').css('display','none');
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes}').css('display','block');
														$('#comissionamento_{$comissionamento.idinstalacoes} td').css('background','#ccc');
														
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes}').addClass('resumo_comissionamento_home');
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes} td').css('background','#EEEEEE');
														altura_resumo_caixaEntrada = document.getElementById( $('.resumo_comissionamento_home').attr('id') ).offsetTop;
														
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes}_last').addClass('limite_baixo_caixa_home');
														">
													<i class="icon-arrow-down"></i>
												</a><br/><br/>
												<a href="#comissionamento_{$comissionamento.idinstalacoes}" class="btn esconde_comissionamento_{$comissionamento.idinstalacoes}" 
													title="Esconder" style="display:none;" onclick="javascript:
														$('#comissionamento_{$comissionamento.idinstalacoes}').css('height','100px');
														$('.expande_comissionamento_{$comissionamento.idinstalacoes}').css('display','block');
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes}').css('display','none');
														$('#comissionamento_{$comissionamento.idinstalacoes} td').css('background','');
														setTimeout(function(){ldelim}window.scrollBy(0,-50);{rdelim},1);

														$('.resumo_comissionamento_home').css('position','relative');
														$('.resumo_comissionamento_home').css('top','0px');
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes} td').css('background','none');
														$('#resumo_comissionamento_{$comissionamento.idinstalacoes}').removeClass('resumo_comissionamento_home');
														
														$('.esconde_comissionamento_{$comissionamento.idinstalacoes}_last').removeClass('limite_baixo_caixa_home');
														">
													<i class="icon-arrow-up"></i>
												</a>
											</td>
											<td style="width:100px;">
												<b>OS:</b>&nbsp;
												<a title="Ver comissionamento" onclick="javascript:
													$.ajax({ldelim}
														url:'OS/view',
														async:false,
														type:'POST',
														data:{ldelim}param:{$comissionamento.os_idos}{rdelim},
														success:function(resposta){ldelim}
		
															$('#conteudo').html(resposta);
															$.ajax({ldelim}
																url:'Comissionamento/comiss_view',
																async:false,
																type:'POST',
																data:{ldelim}param:{$comissionamento.idinstalacoes}{rdelim},
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
									<td style="padding:0px;border:0px;">
									
										<table>
											<tr><td class="padding10">
											
												<!-- ----------------------------------------------------------------------------
												----------------------- TECNICO CAMPO -------------------------------------------
												----------------------------------------------------------------------------- -->
												
												<table>
											    	<tr>
											    		<td colspan="2" style="padding-left:10px;text-align:left;border:0px"><h4>Técnico de Campo</h4></td>
											    	</tr>
													<tr>
											        	<td class="tec_label" style="border:0px">
											                <label for="teccampo">Nome:</label>
											            </td>
											            <td class="tec_input" style="border:0px">
											                {$comissionamento.teccampo}
											            </td>
													</tr>
													<tr>
											            <td class="tec_label" style="border:0px">
											                <label for="teccampo_tel">Telefone:</label>
											            </td>
											            <td class="tec_input" style="border:0px">
											            	{$comissionamento.usuarioTeccampo.nome}
											            </td>
											        </tr>
												</table>
											
											</td><td class="padding10">
											
												<!-- ----------------------------------------------------------------------------
												----------------------- TECNICO RESPONSÁVEL -------------------------------------
												----------------------------------------------------------------------------- -->
												
												<table class="tabela_responsavel">
											    	<tr>
											    		<td colspan="2" style="padding-left:10px;text-align:left;border:0px"><h4>Logs</h4></td>
											    	</tr>
													<tr>
											        	<td class="tec_label" style="border:0px">
											                <label for="teccampo">Comissionado por:</label>
											            </td>
											            <td class="tec_input" style="border:0px">
											            	{$comissionamento.usuarioComissionador.nome} - {$comissionamento.create_user_comiss_time}
											            </td>
													</tr>
													<tr>
											            <td class="tec_label" style="border:0px">
											                <label for="teccampo_tel">Último usuario a modificar:</label>
											            </td>
											            <td class="tec_input" style="border:0px">              
											            	{$comissionamento.usuarioEditouPorUltimo.nome} - {$comissionamento.last_user_comiss_time}
											            </td>
											        </tr>
												</table>
											
											</td></tr>
											<tr><td class="padding10" valign="top">
											
												<!-- ----------------------------------------------------------------------------
												----------------------- DADOS INSTALAÇÃO ----------------------------------------
												----------------------------------------------------------------------------- -->
												
												<input type="hidden" value="1" name="comiss" />
												
												<table class="tabelas_dados largura500">
												
													<tr>
														<td colspan="3" style="padding-left:10px;text-align:left;border:0px"><h4>Dados Instalação</h4></td>
													</tr>
													
											        <tr>
											        	<td class="label_dados_instalacao" style="text-align:left;border:0px">
											        		<label for="registro_concessionaria">Registro Concessionária:</label>
											        	</td>
											        	<td colspan="2" class="label_campo_instalacao" style="text-align:left;border:0px">
											        		{$comissionamento.registro_concessionaria}
											        	</td>
											        </tr>  
											        
											        <tr><td style="border:0px">&nbsp;</td></tr>
											       
											        <tr>    
											        	<td style="text-align:left;border:0px">
											            	<label for="ope_eutelsat">Nome do Operador(a) da EutelSat:</label>
											            </td>
											            <td style="text-align:left;border:0px">
											            	{$comissionamento.ope_eutelsat}
											            </td> 
											            <td style="border:0px">
											            	&nbsp;
											            </td>
											        </tr>
											        
											        <tr><td style="border:0px">&nbsp;</td></tr>
											        
											        <tr>
											        	<td style="text-align:left;border:0px">
											            	<label for="val_crosspol" >Valor do cross-pol EutelSat:</label>
											            </td>
											            <td style="text-align:left;border:0px">
											            	{$comissionamento.val_crosspol}
											            </td>
											            <td style="border:0px">
											            	&nbsp;
											            </td>
											        </tr> 
											        
											        <tr><td style="border:0px">&nbsp;</td></tr>
											        
											        <tr>
											            <td style="text-align:left;border:0px">
											        		<label for="latitude_graus">Latitude:</label>
											            	<!-- <label for="latitude" >Latitude</label> -->
											            </td>
											            <td style="text-align:left;border:0px">
											            	{$comissionamento.latitude_graus}°&nbsp;
											            	{$comissionamento.latitude_minutos}"&nbsp;
											            	{$comissionamento.latitude_segundos}'&nbsp;
											            	{if $comissionamento.latitude_direcao=='S'}S{elseif $comissionamento.latitude_direcao=='N'}N{/if}
											            	</select>
										                </td>
										                <td style="border:0px"></td>
											        </tr>
											        
											        <tr><td>&nbsp;</td></tr>
											        
											        <tr>
											        	<td style="text-align:left;border:0px">
											            	<label for="longitude_graus">Longitude:</label>
											            </td>
											            <td style="text-align:left;border:0px">
										                	{$comissionamento.longitude_graus}°&nbsp;
											            	{$comissionamento.longitude_minutos}"&nbsp;
											            	{$comissionamento.longitude_segundos}'&nbsp;
											            	{if $comissionamento.longitude_direcao=='W'}W{elseif $comissionamento.longitude_direcao=='E'}E{/if}
										                    <!-- <input type="text" id="longitude_comiss" name="longitude_comiss"  /> -->
											            </td>
											            <td style="border:0px"></td>
											        </tr>
											        
											        <tr><td style="border:0px">&nbsp;</td></tr>
											        
											        <tr>
										                <td style="text-align:left;border:0px">
										                    <label for="azimute" >Azimute:</label>
										                </td>
										                <td style="text-align:left;border:0px">
										                    {$comissionamento.azimute_comiss}
										                </td>
										                <td style="border:0px">
										                    <!-- <input type="text" id="azimute_comiss_noc" name="azimute__comiss_noc"  /> -->
										                </td>
											        </tr>
											        
											        <tr><td style="border:0px">&nbsp;</td></tr>
											        
											        <tr>
											        	<td style="text-align:left;border:0px">
										                    <label for="elevacao" >Elevacao:</label>
										                </td>
										                <td style="text-align:left;border:0px">
										                    {$comissionamento.elevacao_comiss}
										                </td>
										                <td style="border:0px">
										                    <!-- <input type="text" id="elevacao_comiss_noc" name="elevacao_comiss_noc"  /> -->
										                </td>
													</tr>
													
											    </table>
										        
										        
										    </td><td class="padding10" valign="top">
										        
										        <!-- ----------------------------------------------------------------------------
												----------------------- DADOS EQUIPAMENTOS --------------------------------------
												----------------------------------------------------------------------------- -->
										        
											    <table class="tabelas_dados">
											    
											        <tr><td colspan="2" style="padding-left:10px;text-align:left;border:0px"><h4>Dados Equipamentos</h4></td></tr>
											        	
											        <tr>
											        	<td class="label_dados_equipamentos" style="border:0px">
											            	<label for="snr" >Valor de SNR na VSAT:</label>
											            </td>
											            
											            <td class="campo_dados_equipamentos" style="border:0px">
											            	{$comissionamento.snr_comiss}
											            </td>
											            
											            <td colspan="2" style="border:0px">
											                    <!-- <input type="text" id="snr_comiss_noc" name="snr_comiss_noc"  /> -->
										                </td>
										            </tr>
										            
										            <tr><td style="border:0px">&nbsp;</td></tr>
										           	
										            <tr >
										                <td class="label_dados_equipamentos" style="border:0px">
										                    <label for="mac">MAC:</label>
										                </td>
										                <td style="border:0px">
										                    {$comissionamento.mac_comiss}
										                </td>
										                <td class="label_dados_equipamentos2" style="border:0px">
										                    <label for="nsmodem">NS da Vsat:</label>
										                </td>
										                <td class="campo_dados_equipamentos2" style="border:0px">
										                    {$comissionamento.nsmodem_comiss}
										                </td>
										            </tr>
										            
										            <tr><td style="border:0px">&nbsp;</td></tr>
										            
										            <tr >
										                <td class="label_dados_equipamentos" style="border:0px">
										                    <label for="nsodu">Número de série ODU:</label>
										                </td>
										                <td style="border:0px">
										                	{$comissionamento.nsodu_comiss}
										                </td>
										                <td class="label_dados_equipamentos2" style="border:0px">
										                    <label for="odu">ODU:</label>
										                </td>
										                <td class="campo_dados_equipamentos2" style="border:0px">
										                	{$comissionamento.tipoEquipamentoODU.nome}
										                </td>
										            </tr>
										            
										            <tr><td style="border:0px">&nbsp;</td></tr>
										            
										            <tr >
										                <td colspan="2" style="padding-right:20px;border:0px">
										                    <label for="nsodu">Antena marca/número de série:</label>
										                </td>
										                <td colspan="2" style="width:400px;text-align:left;border:0px">
										                    {if $comissionamento.antena_comiss eq 'patriot'}
										                    	Patriot
										                    {elseif $comissionamento.antena_comiss eq 'skyware'}
										                    	Skyware
										                    {/if} 
										                    &nbsp;&nbsp;&nbsp;{$comissionamento.antena_ns_comiss}
										                </td>
										            </tr>
										            
										            </table>
											            
											</td></tr>
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
										
									</td>
								</tr>
							</table>
							
						</li>
						<li style="height:50px;width:950px;">
							<a href="#comissionamento_{$comissionamento.idinstalacoes}">
								<div class="btn expande_comissionamento_{$comissionamento.idinstalacoes}" onclick="javascript:
									$('#comissionamento_{$comissionamento.idinstalacoes}').css('height','auto');
									$('.expande_comissionamento_{$comissionamento.idinstalacoes}').css('display','none');
									$('.esconde_comissionamento_{$comissionamento.idinstalacoes}').css('display','block');
									$('#comissionamento_{$comissionamento.idinstalacoes} td').css('background','#ccc');

									$('#resumo_comissionamento_{$comissionamento.idinstalacoes}').addClass('resumo_comissionamento_home');
									$('#resumo_comissionamento_{$comissionamento.idinstalacoes} td').css('background','#EEEEEE');
									altura_resumo_caixaEntrada = document.getElementById( $('.resumo_comissionamento_home').attr('id') ).offsetTop;
									
									$('.esconde_comissionamento_{$comissionamento.idinstalacoes}_last').addClass('limite_baixo_caixa_home');
									" style="width:100%;"><i class="icon-arrow-down"></i>&nbsp;Expandir</div>
									
								<div id="esconde_comissionamento_{$comissionamento.idinstalacoes}_last" class="btn esconde_comissionamento_{$comissionamento.idinstalacoes} esconde_comissionamento_{$comissionamento.idinstalacoes}_last" onclick="javascript:
									$('#comissionamento_{$comissionamento.idinstalacoes}').css('height','100px');
									$('.expande_comissionamento_{$comissionamento.idinstalacoes}').css('display','block');
									$('.esconde_comissionamento_{$comissionamento.idinstalacoes}').css('display','none');
									$('#comissionamento_{$comissionamento.idinstalacoes} td').css('background','');
									setTimeout(function(){ldelim}window.scrollBy(0,-50);{rdelim},1);
									
									$('.resumo_comissionamento_home').css('position','relative');
									$('.resumo_comissionamento_home').css('top','0px');
									$('#resumo_comissionamento_{$comissionamento.idinstalacoes} td').css('background','none');
									$('#resumo_comissionamento_{$comissionamento.idinstalacoes}').removeClass('resumo_comissionamento_home');

									$('.esconde_comissionamento_{$comissionamento.idinstalacoes}_last').removeClass('limite_baixo_caixa_home');
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

<div class="container1">
	<form action="OsPedidoContrato/create" method="POST" id="FCOSCreate" class="form">
	<input type="hidden" name="pedido_os_idpedido_os" id="pedido_os_idpedido_os" value="{$param}">
	<div class="layout_pedido_contrato">
		<b>Ordem de Serviço</b>
		<div class="layoutContrato" >
			<table class="tableContrato" style="width: 1200px;font-size: 10.5px; margin-top: 10px;">
				<tr>
					<td>
						<table border="0" width="100%">
							<tr valign="middle">
								<td width="10%">ORDEM DE SERVIÇO Nº   </td>
								<td width="20%" align="left"><input type="text" style=" max-width: 125px;" name="num_os" id="num_os" value=""></td>
								<td width="30%"></td>
							</tr>
							<tr>
								<td>AO CONTRATO Nº   </td>
								<td width="40%" align="left"><input type="text" style=" max-width: 125px;" name="num_contrato" id="num_contrato" value=""></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
						</table>
					</td>

				</tr>
				<tr>
					<td>
						<table border="0"  width="100%" >

							<tr>
								<td width="25%">&nbsp;&nbsp;Contratante :</td><td>{$empresa} - {$usuario}</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;Cliente Final :</td><td>{$obj.cliente_final}</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;Local e Prazo de Instalação :</td><td>{$obj.local} - Lat: {$obj.lat_graus}º
																												{$obj.lat_minutos}'
																												{$obj.lat_segundos}"
																												{$obj.lat_direcao}

																												Long: {$obj.lon_graus}º
																													  {$obj.lon_minutos}'
																													  {$obj.lon_segundos}"
																													  {$obj.lon_direcao}</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;Descrição do Fornecimento :</td><td>{$obj.rel.canal_venda.plano} - Link de
																						  {$obj.rel.canal_venda.servico} - FC =

																						  {if $obj.fator_comp == 'fc15'}
																							1:5
																						  {else if $obj.fator_comp == 'fc110'}
																							1:10
																						  {else}
																							1:20
																						  {/if}
																						  </td>
							</tr>

						</table>

					</td>
				</tr>
				<tr>
					<td>
						<table  width="100%" >
							<tr>
								<td valign="middle" width="25%">&nbsp;&nbsp;Notas Importantes:</td>
								<td>
									<p style="font-size: 11px;">1) Este é um Termo-Aditivo ao Contrato de Prestação de Transporte IP via Satélite já existente entre Vodanet Serviço de Comunicação e Multimidia Ltda
									   (Nome fantasia: GLOBAL IP) e {$usuario} (Nome Fantasia: {$empresa}).</p>
									<p style="font-size: 11px;">2) Vigência deste Aditivo: O Aditivo vigorará pelo período de <input type="text" style=" max-width: 70px;" name="periodo" id="periodo" value="">
									   a contar da data de atiação do link, podendo ser automaticamente renovado por periodos iguais ou superiores.	</p>
								</td>
							</tr>

						</table>
					</td>
				</tr>

				<tr><td>&nbsp;</td></tr>
				<tr>
					<td >
						<table border="1" width="100%">
							<tr><td colspan="5" style="font-size: 12px;"><b>&nbsp;&nbsp;Equipamentos</b></td></tr>
							<tr align="center" bgcolor="#d8d4d4">
								<td width="13%">Referência</td><td width="40%">Descrição</td><td width="10%">Preço unitário</td><td width="2%">Qtd</td><td width="10%">Preço total</td>
							</tr>
							<tr align="center">
								<td width="10%">
									<select name="ref_equipamento" id="ref_equipamento" style="width: 140px;">
										<option value="kit vsat">KIT VSAT</option>
										<option value="antena">ANTENA</option>
										<option value="modem">MODEM</option>
										<option value="buc">BUC</option>
									</select>
								</td>
								<td width="35%">

			<!-- 					mudar para o select banco futuramente -->

									<select name="desc_equipamento" id="desc_equipamento" style="width: 400px;">

									  <option value=""></option>
									  <optgroup label="Antena + Modem + BUC">
										<option value="ANT 1,2m + MODEM SL 2000 + BUC SL 4033 2w">ANT 1,2m + MODEM SL 2000 + BUC SL 4033 2w</option>
										<option value="ANT 1,8m + MODEM SL 2000 + BUC SL 4033 2w">ANT 1,8m + MODEM SL 2000 + BUC SL 4033 2w</option>
										<option value="ANT 1,2m + MODEM SL 2000 + BUC SL 4033 3w">ANT 1,2m + MODEM SL 2000 + BUC SL 4033 3w</option>
										<option value="ANT 1,8m + MODEM SL 2000 + BUC SL 4033 3w">ANT 1,8m + MODEM SL 2000 + BUC SL 4033 3w</option>
									  </optgroup>
									  <optgroup label="Antena + Modem">
										<option value="ANT 1,2m + MODEM SL 2000">ANT 1,2m + MODEM SL 2000</option>
										<option value="ANT 1,8m + MODEM SL 2000">ANT 1,8m + MODEM SL 2000</option>
									  </optgroup>
									  <optgroup label="Antena + BUC">
										<option value="ANT 1,2m + BUC SL 4033 2w">ANT 1,2m + BUC SL 4033 2w</option>
										<option value="ANT 1,8m + BUC SL 4033 3w">ANT 1,8m + BUC SL 4033 3w</option>
										<option value="ANT 1,2m + BUC SL 4033 3w">ANT 1,2m + BUC SL 4033 3w</option>
										<option value="ANT 1,8m + BUC SL 4033 2w">ANT 1,8m + BUC SL 4033 2w</option>
									  </optgroup>
									  <optgroup label="BUC + Modem">
										<option value="BUC SL 4033 2w + MODEM SL 2000">BUC SL 4033 2w + MODEM SL 2000</option>
										<option value="BUC SL 4033 3w + MODEM SL 2000">BUC SL 4033 3w + MODEM SL 2000</option>
									  </optgroup>
									  <optgroup label="Antena">
										<option value="ANT 1,2m">ANT 1,2m</option>
										<option value="ANT 1,8m">ANT 1,8m</option>
									  </optgroup>
									  <optgroup label="Modem">
										<option value="MODEM SL 2000">MODEM SL 2000</option>
									  </optgroup>
									  <optgroup label="Buc">
										<option value="BUC SL 4033 2w">BUC SL 4033 2w</option>
										<option value="BUC SL 4033 3w">BUC SL 4033 3w</option>
									  </optgroup>
									</select>

								</td>
								<td width="10%">R$: <input type="text" style=" max-width: 90px;" name="preco_equip_uni" id="preco_equip_uni" value=""></td>
								<td width="2%"><input type="text" style=" max-width: 25px;" name="qtd_equipamento" id="qtd_equipamento" value="0"></td>
								<td width="10%">R$: <input type="text" style=" max-width: 90px;" name="preco_equip_total" id="preco_equip_total" value=""></td>
							</tr>
							<tr align="center">
								<td colspan="2"></td>
								<td bgcolor="#d8d4d4">Total</td>
								<td bgcolor="#d8d4d4">&nbsp;</td>
								<td bgcolor="#d8d4d4">R$: <input type="text" style=" max-width: 90px;" name="preco_equipamento" id="preco_equipamento" value="0.00"></td>
							</tr>
							<tr >
								<td colspan="5" ></td>
							</tr>



							<tr>
								<td colspan="5" style="font-size: 12px;">&nbsp;&nbsp;<b>Serviços de Logística e Instalação, Taxa de Adesão e Taxas ANATEL</b></td>
							</tr>
							<tr align="center" bgcolor="#d8d4d4">
								<td width="13%">Referência</td><td width="40%">Descrição</td><td width="10%">Preço unitário</td><td width="2%">Qtd</td><td width="10%">Preço total</td>
							</tr>
							<tr align="center">
								<td>Logística de retirada e transporte</td>
								<td>&nbsp;&nbsp;Retirada dos equipamentos no depósito da GLOBAL IP e transporte até os locais de instalação	</td>
								<td>Por conta da Contratante</td>
								<td>-</td>
								<td>Por conta da Contratante</td>
							</tr>
							<tr align="center">
								<td>Instalação de sites remotos</td>
								<td>&nbsp;&nbsp;Serviços de instalação nos sites remotos do Cliente Final</td>
								<td>Por conta da Contratante</td>
								<td>-</td>
								<td>Por conta da Contratante</td>
							</tr>
							<tr align="center">
								<td>Taxa de Adesão</td>
								<td>&nbsp;&nbsp;Serviços de configuração de Hub, suporte técnico à instalação e testes até a ativação</td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_serv_adesao_uni" id="preco_serv_adesao_uni" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_serv_adesao_uni');"
																							 onblur="javascript:voltaCampo('preco_serv_adesao_uni');"
																							 onKeyPress="return(MascaraMoeda(this,',','.',event));"
																							 onkeyup="referencaCampoUni();"
																							 ></td>
								<td><input type="text" style=" max-width: 25px;" name="qtd_serv_adesao" id="qtd_serv_adesao" value="0"
																								onkeyup="referencaCampoUni();"></td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_serv_adesao_total" id="preco_serv_adesao_total" value="0.00"
																								onfocus="escolhaCampo('preco_serv_adesao_total');"
																								onblur="voltaCampo('preco_serv_adesao_total');"
																								onKeyPress="return(MascaraMoeda(this,',','.',event));"
																								onkeyup="referencaCampoUni();"></td>
							</tr>
							<tr align="center">
								<td>Taxas ANATEL</td>
								<td>&nbsp;&nbsp;Taxas TFI e TFF	</td>
								<td>Por conta da Contratante</td>
								<td>-</td>
								<td>Por conta da Contratante</td>
							</tr>
							<tr align="center">
								<td colspan="2"></td>
								<td bgcolor="#d8d4d4">Total</td>
								<td bgcolor="#d8d4d4">&nbsp;</td>
								<td bgcolor="#d8d4d4">R$: <input style=" max-width: 90px;" type="text" name="preco_servico" id="preco_servico" value="0.00"></td>
							</tr>
							<tr>
								<td colspan="5"></td>
							</tr>
							<tr >
								<td colspan="5" style="font-size: 12px;">&nbsp;&nbsp;<b>Provimento de serviço link satelital</b></td>
							</tr>
							<tr align="center" bgcolor="#d8d4d4">
								<td width="13%">Referência</td><td width="40%">Descrição</td><td width="10%">Preço unitário</td><td width="2%">Qtd</td><td width="10%">Preço total</td>
							</tr>


							<tr align="center">
								<td>Serviço {$obj.rel.canal_venda.plano}</td>
								<td>&nbsp;&nbsp;Link de {$obj.rel.canal_venda.servico} Kbps, fator de compartilhamento {if $obj.fator_comp == 'fc15'}
																							1:5
																						  {else if $obj.fator_comp == 'fc110'}
																							1:10
																						  {else}
																							1:20
																						  {/if}, com acesso à Internet e Kit VSAT em comodato.
									</td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_serv_uni" id="preco_prov_serv_uni" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_serv_uni');"
																							 onblur="javascript:voltaCampo('preco_prov_serv_uni');"
																							 onKeyPress="return(MascaraMoeda(this,',','.',event));"
																							 onkeyup="referencaCampoProv();"
																																				></td>
								<td><input type="text" style=" max-width: 25px;" name="qtd_prov_serv" id="qtd_prov_serv" value="0"
																								onkeyup="referencaCampoProv();"
																								></td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_serv_total" id="preco_prov_serv_total" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_serv_total');"
																							 onblur="javascript:voltaCampo('preco_prov_serv_total');"
																							 onkeyup="referencaCampoProv();"
																													></td>
							</tr>
							<tr align="center">
								<td>Serviço Voip</td>
								<td>&nbsp;&nbsp;Linha Voip para comunicaçao de voz</td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_voip_uni" id="preco_prov_voip_uni" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_voip_uni');"
																							 onblur="javascript:voltaCampo('preco_prov_voip_uni');"
																							 onKeyPress="return(MascaraMoeda(this,',','.',event));"
																							 onkeyup="referencaCampoProv();"
																																				></td>
								<td><input type="text" style=" max-width: 25px;" name="qtd_prov_voip" id="qtd_prov_voip" value="0"
																								onkeyup="referencaCampoProv();"
																								></td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_voip_total" id="preco_prov_voip_total" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_voip_total');"
																							 onblur="javascript:voltaCampo('preco_prov_voip_total');"
																							 onkeyup="referencaCampoProv();"
																													></td>
							</tr>





							<tr align="center">
								<td>Licença QoS	</td>
								<td>&nbsp;&nbsp;Aplicação de Fila de QoS</td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_licenca_uni" id="preco_prov_licenca_uni" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_licenca_uni');"
																							 onblur="javascript:voltaCampo('preco_prov_licenca_uni');"
																							 onKeyPress="return(MascaraMoeda(this,',','.',event));"
																							 onkeyup="referencaCampoProv();"
																												></td>
								<td><input type="text" style=" max-width: 25px;" name="qtd_prov_licenca" id="qtd_prov_licenca" value="0"
																							onkeyup="referencaCampoProv();"
																										></td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_licenca_total" id="preco_prov_licenca_total" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_licenca_total');"
																							 onblur="javascript:voltaCampo('preco_prov_licenca_total');"

																													></td>
							</tr>
							<tr align="center">
								<td>IP Público</td>
								<td>&nbsp;&nbsp;Alocação de IP Público</td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_ip_uni" id="preco_prov_ip_uni" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_ip_uni');"
																							 onblur="javascript:voltaCampo('preco_prov_ip_uni');"
																							 onKeyPress="return(MascaraMoeda(this,',','.',event));"
																							 onkeyup="referencaCampoProv();"
																												></td>
								<td><input type="text" style=" max-width: 25px;" name="qtd_prov_ip" id="qtd_prov_ip" value="0"
																							onkeyup="referencaCampoProv();"
																								></td>
								<td>R$: <input type="text" style=" max-width: 90px;" name="preco_prov_ip_total" id="preco_prov_ip_total" value="0.00"
																							 onfocus="javascript:escolhaCampo('preco_prov_ip_total');"
																							 onblur="javascript:voltaCampo('preco_prov_ip_total');"
																												></td>
							</tr>
							<tr align="center" >
								<td colspan="2"></td>
								<td bgcolor="#d8d4d4">Total</td>
								<td bgcolor="#d8d4d4">&nbsp;</td>
								<td bgcolor="#d8d4d4">R$: <input style=" max-width: 90px;" type="text" name="preco_provimento" id="preco_provimento" value="0.00"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<br>
	<table>
		<tr><td><input type="button" value="Enviar Pedido Os" onclick="javascript:sendPost('OsPedidoContrato/create','FCOSCreate');"></td></tr>
	</table>

	</form>
</div>

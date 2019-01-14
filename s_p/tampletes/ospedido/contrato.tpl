<!doctype html>
<meta charset="UTF-8">
<link href="public/CSS/ospedidocontrato.css" rel="stylesheet" type="text/css"/>
<body>
<br>
<div class="layoutPDFContrato" >
	<table border="0" width="99%" align="center" >
		<tr>
			<td rowspan="2" width="25%"><img src="public/imagens/logoEMC.png" height="70" width="200"></td>
			{*<td rowspan="2" width="25%"><div  id="imagem"></div></td>*}
			<td>&nbsp;</td>
			<td rowspan="2" align="center">Brasilia, {$dateFormate}</td>
		</tr>
		<tr>
			<td>
				<table id="osContrato" align="center">
					<tr>
						<td align="center">
							<b>ORDEM DE SERVI&Ccedil;O N.&deg; &nbsp; {$obj.rel.os_pedido_contrato.num_os}</b> <br />
							<b>AO CONTRATO N&deg; &nbsp;{$obj.rel.os_pedido_contrato.num_contrato}</b>
						<td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr >
			<td colspan="3">
				<table id="dadosLocais"  width="100%">

					<tr>
						<td width="25%">&nbsp;&nbsp;Contratante :</td><td>{$empresa} - {$usuario}</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;Cliente Final :</td><td>{$obj.cliente_final}</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;Local e Prazo de Instala&ccedil;&aacute;o :</td><td>{$obj.local} - Lat: {$obj.lat_graus}º
							{$obj.lat_minutos}'
							{$obj.lat_segundos}"
							{$obj.lat_direcao}

							Long: {$obj.lon_graus}º
							{$obj.lon_minutos}'
							{$obj.lon_segundos}"
							{$obj.lon_direcao}</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;Descri&ccedil;&atilde;o do Fornecimento :</td><td>{$obj.rel.canal_venda.plano} - Link de
							{$obj.rel.canal_venda.servico} - FC =

							{if $obj.fator_comp == 'fc15'}
								1:5
							{elseif $obj.fator_comp == 'fc110'}
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
			<td colspan="3">
				<table id="dadosImport"  width="100%" >
					<tr>
						<td width="25%">&nbsp;&nbsp;Notas Importantes:</td>
						<td>
							<p>1) Este &eacute; um Termo-Aditivo ao Contrato de Presta&ccedil;&atilde;o de Transporte IP via Sat&eacute;lite j&aacute; existente entre Vodanet Servi&ccedil;o de Comunica&ccedil;&atilde;o e Multimidia Ltda
								(Nome fantasia: GLOBAL IP) e {$usuario} (Nome Fantasia: {$empresa}).</p>
							<p>2) Vig&ecirc;ncia deste Aditivo: O Aditivo vigorar&aacute; pelo per&iacute;odo de {$obj.rel.os_pedido_contrato.periodo}
								a contar da data de atia&ccedil;&atilde;o do link, podendo ser automaticamente renovado por periodos iguais ou superiores.	</p>
						</td>
					</tr>

				</table>
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td colspan="3">
				<table border="0" id="dadosEquip" width="100%"  >
					<tr class="linhaTop linhaLeft linhaRight"><td colspan="5"><b>&nbsp;&nbsp;Equipamentos</b></td></tr>
					<tr  align="center" class="linhaLeft linhaRight"  style="background-color:#376091;">
						<td width="13%" height="15"><span>Refer&ecirc;ncia</span></td><td width="40%"><span>Descri&ccedil;&atilde;o</span></td><td width="10%"><span>Pre&ccedil;o unit&aacute;rio</span></td><td width="2%"><span>Qtd</span></td><td width="10%"><span>Pre&ccedil;o total</span></td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">{$obj.rel.os_pedido_contrato.ref_equipamento}</td><td width="40%">{$obj.rel.os_pedido_contrato.desc_equipamento}</td><td width="10%">{$obj.rel.os_pedido_contrato.preco_equip_uni}</td><td width="2%">{$obj.rel.os_pedido_contrato.qtd_equipamento}</td><td width="10%">{$obj.rel.os_pedido_contrato.preco_equip_total}</td>
					</tr>
					<tr align="center">
						<td colspan="2" ></td><td class="tdPreco" bgcolor="#a5a5a5">Total</td><td class="tdPreco" bgcolor="#a5a5a5">&nbsp;</td><td class="tdPreco" bgcolor="#a5a5a5">{$obj.rel.os_pedido_contrato.preco_equipamento}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td colspan="3">
				<table border="0" id="dadosEquip" width="100%"  >
					<tr class="linhaTop linhaLeft linhaRight"><td colspan="5"><b>&nbsp;&nbsp;Servi&ccedil;os de Log&iacute;stica e Instala&ccedil;&atilde;o, Taxa de Adesão e Taxas ANATEL</b></td></tr>
					<tr  align="center" class="linhaLeft linhaRight"  style="background-color:#376091;">
						<td width="13%" height="15"><span>Refer&ecirc;ncia</span></td><td width="40%"><span>Descri&ccedil;&atilde;o</span></td><td width="10%"><span>Pre&ccedil;o unit&aacute;rio</span></td><td width="2%"><span>Qtd</span></td><td width="10%"><span>Pre&ccedil;o total</span></td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Log&iacute;stica de retirada e transporte</td>
						<td width="40%">Retirada dos equipamentos no depósito da GLOBAL IP e transporte at&eacute; os locais de instala&ccedil;&atilde;o</td>
						<td width="10%">Por conta da Contratante</td>
						<td width="2%">-</td>
						<td width="10%">Por conta da Contratante</td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Instala&ccedil;&atilde;o de sites remotos</td>
						<td width="40%">Servi&ccedil;os de instala&ccedil;&atilde;o nos sites remotos do Cliente Final</td>
						<td width="10%">Por conta da Contratante</td>
						<td width="2%">-</td>
						<td width="10%">Por conta da Contratante</td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Taxa de Adesão</td>
						<td width="40%">Servi&ccedil;os de configura&ccedil;&atilde;o de Hub, suporte t&eacute;cnico à instala&ccedil;&atilde;o e testes at&eacute; a ativa&ccedil;&atilde;o</td>
						<td width="10%">R${$obj.rel.os_pedido_contrato.preco_serv_adesao_uni}</td>
						<td width="2%">{$obj.rel.os_pedido_contrato.qtd_serv_adesao}</td>
						<td width="10%">R${$obj.rel.os_pedido_contrato.preco_serv_adesao_total}</td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Taxas ANATEL</td>
						<td width="40%">Taxas TFI e TFF</td>
						<td width="10%">Por conta da Contratante</td>
						<td width="2%">-</td>
						<td width="10%">Por conta da Contratante</td>
					</tr>
					<tr align="center">
						<td colspan="2" ></td><td class="tdPreco" bgcolor="#a5a5a5">Total</td><td class="tdPreco" bgcolor="#a5a5a5">&nbsp;</td><td class="tdPreco" bgcolor="#a5a5a5">R${$obj.rel.os_pedido_contrato.preco_serv_adesao_total}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td colspan="3">
				<table border="0" id="dadosEquip" width="100%"  >
					<tr class="linhaTop linhaLeft linhaRight"><td colspan="5"><b>&nbsp;&nbsp;Provimento de servi&ccedil;o link satelital</b></td></tr>
					<tr  align="center" class="linhaLeft linhaRight"  style="background-color:#376091;">
						<td width="13%" height="15"><span>Refer&ecirc;ncia</span></td><td width="40%"><span>Descri&ccedil;&atilde;o</span></td><td width="10%"><span>Pre&ccedil;o unit&aacute;rio</span></td><td width="2%"><span>Qtd</span></td><td width="10%"><span>Pre&ccedil;o total</span></td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Servi&ccedil;o {$obj.rel.canal_venda.plano}</td>
						<td width="40%">Link de {$obj.rel.canal_venda.servico} Kbps, fator de compartilhamento {if $obj.fator_comp == 'fc15'} 1:5 {else if $obj.fator_comp == 'fc110'} 1:10 {else} 1:20{/if}, com acesso à Internet e Kit VSAT em comodato.</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_serv_uni}</td>
						<td width="2%">{$obj.rel.os_pedido_contrato.qtd_prov_serv}</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_serv_total}</td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Servi&ccedil;o Voip</td>
						<td width="40%">Linha Voip para comunica&ccedil;oes de voz</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_voip_uni}</td>
						<td width="2%">{$obj.rel.os_pedido_contrato.qtd_prov_voip}</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_voip_total}</td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">Licen&ccedil;a QoS</td>
						<td width="40%">Aplica&ccedil;&atilde;o de Fila de QoS</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_licenca_uni}</td>
						<td width="2%">{$obj.rel.os_pedido_contrato.qtd_prov_licenca}</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_licenca_total}</td>
					</tr>
					<tr align="center" class="linhaBottom linhaLeft linhaRight">
						<td width="13%" style="border-bottom: 1px solid;">IP P&uacute;blico</td>
						<td width="40%">Aloca&ccedil;&atilde;o de IP P&uacute;blico</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_ip_uni}</td>
						<td width="2%">{$obj.rel.os_pedido_contrato.qtd_prov_ip}</td>
						<td width="10%">{$obj.rel.os_pedido_contrato.preco_prov_ip_total}</td>
					</tr>
					<tr align="center">
						<td colspan="2" ></td><td class="tdPreco" bgcolor="#a5a5a5">Total</td><td class="tdPreco" bgcolor="#a5a5a5">&nbsp;</td><td class="tdPreco" bgcolor="#a5a5a5">{$obj.rel.os_pedido_contrato.preco_provimento}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td colspan="3">
				<table border="0" id="dadosEquip" width="100%" >
					<tr>
						<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
					</tr>
					<tr>
						<td style="border-top: 2px solid;"><b>CONTRATANTE: <br />Nome e CPF:</b></td><td width="43%"></td><td style="border-top: 2px solid;"><b>CONTRATATADA: <br />Nome e CPF:</b></td>
					</tr>
				</table>
			</td>
		</tr>

	</table>
</div>


</body>
</html>
<br>
<br>
<br>
<br>
<br>






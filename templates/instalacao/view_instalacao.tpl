
<div class="container1" style="margin-bottom: 300px;">
	<form action="" method="POST" id="fInsEdit" class="form">
		<input type="hidden" name="idinstalacoes" id="idinstalacoes"
			value="{$obj.idinstalacoes}" /> <input type="hidden" name="os_idos"
			id="os_idos" value="{$obj.os_idos}" />


		<div class="tipoDadosGlobal">
			<div class="topoDadosResumo">
				<table>
					<tr>
						<td>Informações do Serviço</td>
					</tr>
				</table>
			</div>
			<div class="perguntaDados">
				<table border="1" class="tableDados borda">
					<tr>
						<td colspan="4">
							<table style="width: 100%;">
								<tr>
									<td><b>{$obj.nome}</b></td>
									<td align="right"><b>Cod. Anatel :&nbsp;{$obj.cod_anatel}&nbsp;
											&nbsp;</b></td>

								</tr>
							</table>
						</td>
					</tr>
					<tr align="left" style="border-bottom: 1px solid #888888;">
						<td width="18%" align="left" style="font-weight: bold;">Tecnico de
							Campo :</td>
						<td width="30%">{$obj.teccampo}</td>
						<td width="10%" align="left" style="font-weight: bold;">Telefone :</td>
						<td>{$obj.teccampo_tel}</td>
					</tr>
					<tr align="left">
						<td style="font-weight: bold;">Plano :</td>
						<td>{if $obj.planos_idplanos == 1} Plano Básico {else if
							$obj.planos_idplanos == 2} Plano Clássico {else} Plano nao
							selecionado {/if}</td>
						<td style="font-weight: bold;">Area :</td>
						<td>{$obj.rel.os.areaInstal}</td>
					</tr>
					<tr align="left">
						<td style="font-weight: bold;">Eutelsat Code :</td>
						<td>{$obj.rel.os.eutelsat_code}</td>
						<td style="font-weight: bold;">Serviço :</td>
						<td>Satélite</td>
					</tr>
					<tr align="left">
						<td style="font-weight: bold;">Vel. Download :</td>
						<td>{$obj.rel.os.velDownload}</td>
						<td style="font-weight: bold;">Vel. Upload :</td>
						<td>{$obj.rel.os.velUpload}</td>
					</tr>

				</table>

			</div>

			<div class="topoDados">
				<table>
					<tr>
						<td>Dados da Antena</td>
					</tr>
				</table>
			</div>
			<div class="topoDados">
				<table>
					<tr>
						<td>Dados da ODU</td>
					</tr>
				</table>
			</div>
			<div class="topoDados">
				<table>
					<tr>
						<td>Dados do Modem</td>
					</tr>
				</table>
			</div>
			<div class="AreaDados">
				<table class="tableDados">
					<tr>
						<td align="right" width="40%" style="font-weight: bold;">Antena :</td>
						<td>&nbsp;{$obj.antena}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Marca :</td>
						<td>&nbsp;{$obj.antena}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Tamanho :</td>
						<td>&nbsp;{$obj.antena_tam}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Nº de Serie :</td>
						<td>&nbsp;{$obj.antena_ns}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Azimute :</td>
						<td>&nbsp;{$obj.azimute_comiss}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Elevação :</td>
						<td>&nbsp; {$obj.elevacao_comiss}</td>
					</tr>
				</table>
			</div>
			<div class="AreaDados">
				<table class="tableDados">
					<tr>
						<td align="right" width="40%" style="font-weight: bold;">ODU :</td>
						<td>&nbsp; {foreach from=$tipoEquipamentos item=tipoEquipamento}
							{if $obj.odu == $tipoEquipamento.idtipo_equipamentos}
							{$tipoEquipamento.nome} {/if} {/foreach}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Nº de Serie :</td>
						<td>&nbsp;{$obj.nsodu_comiss}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">BUC :</td>
						<td>&nbsp;{$obj.buc}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">LNB :</td>
						<td>&nbsp;{$obj.lnb}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Tipo de IDU :</td>
						<td>&nbsp;{$obj.tipo_IDU}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Valor SNR :</td>
						<td>&nbsp;{$obj.snr_comiss}</td>
					</tr>
				</table>
			</div>
			<div class="AreaDados">
				<table class="tableDados">
					<tr>
						<td align="right" width="42%" style="font-weight: bold;">MAC :</td>
						<td>&nbsp;{$obj.mac}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">IP Lan :</td>
						<td>&nbsp;{$obj.rel.os.iplan}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">IP DVB :</td>
						<td>&nbsp;{$obj.rel.os.ipdvb}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">NS da Vsat :</td>
						<td>&nbsp;{$obj.nsmodem_comiss}</td>
					</tr>
					<tr>
						<td align="right" style="font-weight: bold;">Codigo de Área :</td>
						<td>&nbsp;{$obj.cod_area}</td>
					</tr>
				</table>
			</div>

			<div class="butao">
				<input type="button" class="btn btn-primary" value="Editar dados da VSAT"
					onclick="javascript: getAjaxForm(
				                    			'Instalacao/edit','dadosInstal',
				                    			{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim} 
				                    			) " />
			</div>

			<div class="InfDados">
				<table class="tableDados">
					<tr>
						<td width="">Dados da Concenssionária :</td>
						<td align="left">{$obj.registro_concessionaria}</td>
						<td>&nbsp;Valor da cross-pol eutelsat :</td>
						<td align="left">{$obj.val_crosspol}</td>
						<td>&nbsp;Latitude :</td>
						<td align="left">{$obj.latitude_graus}° {$obj.latitude_minutos}'
							{$obj.latitude_segundos}" {if $obj.latitude_direcao=='S'}S{elseif
							$obj.latitude_direcao=='N'}N{/if}</td>
						<td>&nbsp;Longitude :</td>
						<td>{$obj.longitude_graus}° {$obj.longitude_minutos}'
							{$obj.longitude_segundos}" {if
							$obj.longitude_direcao=='W'}W{elseif
							$obj.longitude_direcao=='E'}E{/if}</td>
					</tr>

				</table>

			</div>
		</div>
	</form>
</div>

<br>



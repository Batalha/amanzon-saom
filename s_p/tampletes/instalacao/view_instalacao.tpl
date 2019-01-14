

<div class="container1" style="width:75%;">

	<form action="" method="POST" id="fInsEdit" class="form">
		<input type="hidden" name="idinstalacoes_sp" id="idinstalacoes_sp"	value="{$obj.idinstalacoes_sp}" />
		<input type="hidden" name="os_sp_idos" id="os_sp_idos" value="{$obj.os_sp_idos}" />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="pnael-title">Dados da Vsat</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12">
						<table class="table table-bordered">
							<thead><td colspan="4" bgcolor="#87ceeb"><b>Informaçoes do Serviço</b></td></thead>
							<tbody>
								<tr>
									<td colspan="2" bgcolor="#b0c4de">
										<b>{$obj.nome}</b>
									</td>
									<td colspan="2" bgcolor="#b0c4de">
										<b>Cod. Anatel :&nbsp;{$obj.cod_anatel}&nbsp;
											&nbsp;</b>
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
									<td>{if $obj.planos_idplanos == 1} Plano Básico {elseif
										$obj.planos_idplanos == 2} Plano Clássico {else} Plano nao
											selecionado {/if}</td>
									<td style="font-weight: bold;">Area :</td>
									<td>{$obj.rel.os_sp.areaInstal}</td>
								</tr>
								<tr align="left">
									<td style="font-weight: bold;">Telesat Code :</td>
									<td>{$obj.rel.os_sp.eutelsat_code}</td>
									<td style="font-weight: bold;">Serviço :</td>
									<td>Satélite</td>
								</tr>
								<tr align="left">
									<td style="font-weight: bold;">MIR. Download :</td>
									<td>{$obj.rel.os_sp.mirDownload}</td>
									<td width="15%" style="font-weight: bold;">MIR. Upload :</td>
									<td>{$obj.rel.os_sp.mirUpload}</td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<table class="table table-bordered">
							<thead><td colspan="2" bgcolor="#87ceeb"><b>Dados da Antena</b></td></thead>
							<tbody>
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
							</tbody>
						</table>

					</div>
					<div class="form-group col-md-4">
						<table class="table table-bordered">
							<tr><td colspan="2" bgcolor="#87ceeb"><b>Dados da ODU</b></td></tr>
							<tr>
								<td align="right" width="40%" style="font-weight: bold;">ODU :</td>
								<td>&nbsp; {foreach from=$tipoEquipamentos item=tipoEquipamento}
										{if $obj.odu == $tipoEquipamento.idtipo_equipamentos_sp}
											{$tipoEquipamento.nome}
										{/if}
									{/foreach}</td>
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
					<div class="form-group col-md-4">
						<table class="table table-bordered">
							<tr><td colspan="2" bgcolor="#87ceeb"><b>Dados do Modem</b></td></tr>
							<tr>
								<td align="right" width="42%" style="font-weight: bold;">MAC :</td>
								<td>&nbsp;{$obj.mac}</td>
							</tr>
							<tr>
								<td align="right" style="font-weight: bold;">IP Lan :</td>
								<td>&nbsp;{$obj.rel.os_sp.iplan}</td>
							</tr>
							<tr>
								<td align="right" style="font-weight: bold;">IP DVB :</td>
								<td>&nbsp;{$obj.rel.os_sp.ipdvb}</td>
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
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<input type="button" class="btn btn-primary" value="Editar dados da VSAT"
					   onclick="javascript: getAjaxForm('Instalacao_sp/edit','dadosInstal',
							   {ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim}
							   ) " />
			</div>
		</div>
		<br>
		<br>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr>
						<td><b>Dados da Concenssionária :</b></td>
						<td align="left">{$obj.registro_concessionaria}</td>
						<td><b>Valor da cross-pol Telesat :</b></td>
						<td align="left">{$obj.val_crosspol}</td>
						<td><b>Latitude :</b></td>
						<td align="left">{$obj.latitude_graus}° {$obj.latitude_minutos}'
							{$obj.latitude_segundos}" {if $obj.latitude_direcao=='S'}S{elseif
							$obj.latitude_direcao=='N'}N{/if}</td>
						<td><b>Longitude :</b></td>
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


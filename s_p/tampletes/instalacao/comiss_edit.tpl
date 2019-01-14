

<div class="container1" style="width: 55%;">
	<form action="s_p/controller/Comissionamento_sp/edit_comiss" method="POST" id="FCOMISS" class="form" >
		<input type="hidden" name="idinstalacoes_sp" id="idinstalacoes_sp" value="{$obj.idinstalacoes_sp}"/>
		<input name="last_user_comiss" id="last_user_comiss" value="{$session.login.idusuarios}" type="hidden" />
		<input name="last_user_comiss_time" id="last_user_comiss_time" value="{$agora}" type="hidden" />
		<input name="last_user_cross_pol" id="last_user_cross_pol" value="{$agora}" type="hidden" />
		<input name="last_user_snr" id="last_user_snr" value="{$agora}" type="hidden" />
		<input name="last_user_tx" id="last_user_tx" value="{$agora}" type="hidden" />


		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Tecnico de Campo</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-8">
						<input class="form-control" type="text" value="{$obj.teccampo}" name="teccampo" placeholder="Nome" />
					</div>
					<div class="form-group col-md-4">
						<input class="form-control" type="text" value="{$obj.teccampo_tel}" name="teccampo_tel" id="teccampo_tel" placeholder="Telefone do tecnico"/>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Dados de Instalação</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="registro_concessionaria" id="registro_concessionaria" value="{$obj.registro_concessionaria}" placeholder="Registro Concessionária" />
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="ope_eutelsat" id="ope_eutelsat" value="{$obj.ope_eutelsat}" placeholder="Nome do Operador(a) do Satelite" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="satelite" id="satelite" value="{$obj.satelite}" placeholder="Satelite"/>
						</div>
					</div>
					<div class="form-group col-md-2">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="bean" id="bean" value="{$obj.bean}" />
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control autosave_sp" type="text" id="val_crosspol" name="val_crosspol" value="{$obj.val_crosspol}"  placeholder="Valor do cross-pol Satelite"/>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-1">
						<label for="">Lat</label>
					</div>
					<div class="form-group col-md-1">
						<div class="">
						<input class="form-control autosave_sp" onkeyup="num(this);"
							   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
							   type="text" maxlength="2" name="latitude_graus" id="latitude_graus" value="{$obj.latitude_graus}" placeholder="º"/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
						<input class="form-control autosave_sp" onkeyup="num(this);"
							   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
							   type="text" maxlength="2" name="latitude_minutos" id="latitude_minutos" value="{$obj.latitude_minutos}" placeholder='"'/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
						<input class="form-control autosave_sp" onkeyup="num(this);"
							   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
							   type="text" maxlength="2" name="latitude_segundos" id="latitude_segundos" value="{$obj.latitude_segundos}" placeholder="'" />
						</div>
					</div>
					<div class="form-group col-md-2">
						<div class="">
							<select class="form-control autosave_sp" name="latitude_direcao" id="latitude_direcao">
								<option value="S" {if $obj.latitude_direcao=='S'}selected{/if}>S</option>
								<option value="N" {if $obj.latitude_direcao=='N'}selected{/if}>N</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control autosave_sp" type="text" id="azimute_comiss" name="azimute_comiss" value="{$obj.azimute_comiss}" placeholder="Azimute" />
						</div>
					</div>

				</div>
				<div class="row">
					<div class="form-group col-md-1">
						<label for="">Long</label>
					</div>
					<div class="form-group col-md-1">
						<div class="">
						<input class="autosave_sp form-control" onkeyup="num(this);"
							   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
							   type="text" size="2" maxlength="2" name="longitude_graus" id="longitude_graus" value="{$obj.longitude_graus}" placeholder="º"/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
						<input class="autosave_sp form-control"
							   onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
							   type="text" size="2" maxlength="2" name="longitude_minutos" id="longitude_minutos" value="{$obj.longitude_minutos}" placeholder='"'/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
						<input class="autosave_sp form-control" onkeyup="num(this);"
							   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
							   type="text" size="2" maxlength="2" name="longitude_segundos" id="longitude_segundos" value="{$obj.longitude_segundos}" placeholder="'"/>
						</div>
					</div>
					<div class="form-group col-md-2">
						<div class="">
							<select class="form-control autosave_sp" size="1" name="longitude_direcao" id="longitude_direcao">
								<option value="W" {if $obj.longitude_direcao=='W'}selected{/if}>W</option>
								<option value="E" {if $obj.longitude_direcao=='E'}selected{/if}>E</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control autosave_sp" type="text" id="elevacao_comiss" name="elevacao_comiss"  value="{$obj.elevacao_comiss}" placeholder="Elevação"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Dados Equipamentos</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control autosave_sp" type="text" id="snr_comiss" name="snr_comiss" value="{$obj.snr_comiss}"  placeholder="Valor de SNR na VSAT"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<select class="form-control autosave_sp" name="antena_comiss" id="antena_comiss">
								<option value=""> Selecione Antena</option>
								<option {if $obj.antena_comiss eq 'patriot'}selected="selected"{/if} value='patriot'>Patriot</option>
								<option {if $obj.antena_comiss eq 'skyware'}selected="selected"{/if} value='skyware'> Skyware</option>
								<option value='Brasil Sat' {if $obj.antena_comiss eq 'Brasil Sat'} selected="selected" {/if}> Brasil Sat</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-2">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="antena_ns_comiss" id="antena_ns_comiss" value="{$obj.antena_ns_comiss}" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="">
						<input class="form-control" type="text" name="mac_comiss" id="mac_comiss" value="{$obj.mac_comiss}" placeholder="MAC"
							   onblur="javascript: if( this.value != '' ){
                            	                    atualizaNSVsatsp(this.value);
                                                }"   alt="mac" />
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control" readonly="readonly" type="text" name="nsmodem_comiss" id="nsmodem_comiss" value="{$obj.nsmodem_comiss}" placeholder="NS da Vsat"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="">
							<input class="form-control" name="nsodu_comiss" id="nsodu_comiss" placeholder="Número de série ODU/BUC"
								   onblur="javascript:atualizaODUsp();" value="{$obj.nsodu_comiss}"
								   type="text" />
							<div style="display:none" id="listaComplete">{$listaautocomplete}</div>
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="">
							{*<input class="form-control" readonly="readonly" type="text" name="odu" id="odu" value="{$obj.odu}" placeholder="Tipo de ODU"/>*}
						<select name="odu" id="odu" disabled="disabled" class="form-control">
							<option value="">Tipo de ODU: </option>
							{foreach from=$tipoEquipamentos item=tipoEquipamento}
								{if $tipoEquipamento.nome != 'Patriot'}
									<option value="{$tipoEquipamento.idtipo_equipamentos_sp}" {if $obj.odu == $tipoEquipamento.idtipo_equipamentos_sp}selected{/if}>{$tipoEquipamento.nome}</option>
								{/if}
							{/foreach}
						</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="packetshapper" id="packetshapper" value="1" />
		<input type="hidden" name="reglicenca" id="reglicenca" value="1" />
		<input type="hidden" name="opmanager" id="opmanager" value="1" />
		<input type="hidden" name="webnms" id="webnms" value="1" />
		<!-- Solução temporária, depois retirar -->
		<input type="hidden" name="test_e_termo_aceite" id="test_e_termo_aceite" {if $obj.test_e_termo_aceite == 1 || $obj.termo_aceite != ''}checked{/if} />

		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Teste de Calibrate?</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon"  style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_sl2000" id="test_sl2000" {if $obj.test_sl2000} checked  {/if} />
							</span>
							<input type="text" class="form-control" readonly="readonly" value="Testou Sat Link 2000?" >
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon" style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="autocomiss" {if $obj.autocomiss eq 1}checked{/if} />
								{*<label for="autocomiss">Auto comissionamento foi realizado?</label>*}
							</span>
							<input type="text" class="form-control" readonly="readonly" value="Auto comissionamento foi realizado?" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group"  style="text-align: left;">
							<span class="input-group-addon" style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_software" {if $obj.test_software eq 1}checked{/if} />
								{*<label for="test_software">Verificada a versão do software utilizado?</label>*}
							</span>
							<input type="text" class="form-control" readonly="readonly" value="Verificada a versão do software utilizado?" >
						</div>
					</div>
					<div class="form-group col-md-6" >
						<div class="input-group">
							<span class="input-group-addon"  style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_antena" {if $obj.test_antena eq 1}checked{/if} />
								{*<label for="test_antena">Verificado o tamanho e o tipo da antena?</label>*}
							</span>
							<input type="text" class="form-control" readonly="readonly" value="Verificado o tamanho e o tipo da antena?" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon"  style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_buc" {if $obj.test_buc eq 1}checked{/if} />
								{*<label for="test_buc">Verificado o tipo do buc?</label>*}
							</span>
							<input type="text" class="form-control" readonly="readonly" value="Verificado o tipo do buc?" >
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_calibrate" {if $obj.test_calibrate eq 1}checked{/if} />
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Teste de calibrate?">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_info_rx_tx" id="test_info_rx_tx" onClick="showFields(this)" {if $obj.test_info_rx_tx eq 1}checked{/if} />
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Coletar informações de RX e TX?">
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_f_termo_aceite" id="test_f_termo_aceite" onClick="showFields(this)" {if $obj.test_f_termo_aceite eq 1}checked{/if} />
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Finalizou o Termo de Aceite?">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon"  style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_tx" id="test_tx" onClick="showFields(this)" {if $obj.test_tx eq 1}checked{/if} />
								{*<label for="test_tx">Verificado os níveis de TX?</label>*}
							</span>
							<input type="text" class="form-control" readonly="readonly" value="Verificado os níveis de TX?" >
						</div>
					</div>
					<div class="form-group col-md-3 tx_input_1" style="{if $obj.test_tx != 1}visibility: hidden{/if}">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="ebno_comiss" id="ebno_comiss" value="{$obj.ebno_comiss}" placeholder="EB/N0:"/>
						</div>
					</div>
					<div class="form-group col-md-3 tx_input_2" style="{if $obj.test_tx != 1}visibility: hidden{/if}">
						<div class="">
							<input class="form-control autosave_sp" type="text"  name="eirp_comiss" id="eirp_comiss" value="{$obj.eirp_comiss}" placeholder="EIRP Configurado:"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_cabo" id="test_cabo" onClick="showFields(this)" {if $obj.test_cabo eq 1}checked{/if} />
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Distância do cabo entre BUC e Modem?">
						</div>
					</div>
					<div class="form-group col-md-3 cabo_input" style="{if $obj.test_cabo != 1}visibility: hidden;{/if}">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="comp_cabo_comiss" id="comp_cabo_comiss"  value="" placeholder="Valor"/>
						</div>
					</div>
					<div class="form-group col-md-3 cabo_input" style="{if $obj.test_cabo != 1}visibility: hidden;{/if}">
						<div class="">
							<input class="form-control autosave_sp" type="text" name="comp_tipo_cabo_comiss" id="comp_tipo_cabo_comiss" value="{$obj.comp_tipo_cabo_comiss}" placeholder="Tipo de Cabo"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_clima" id="test_clima" onClick="showFields(this)" {if $obj.test_clima eq 1}checked{/if} />
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Registro de condições climáticas?">
						</div>
					</div>
					<div class="form-group col-md-6 clima_inputs" style="{if $obj.test_clima != 1}visibility:hidden{/if}">
							<div class="">
								<input type="text" class="form-control autosave_sp" id="desc_clima_comiss" name="desc_clima_comiss" value="{$obj.desc_clima_comiss}" Clima/>
							</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="cabo_rj45" id="cabo_rj45" onClick="showFields(this)" {if $obj.cabo_rj45 eq 1}checked{/if}/>
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Conectou o cabo RJ45?">
						</div>
					</div>
					<div class="form-group col-md-6">
						<div id="justificativa_cabo_rj45">
							<input class="form-control" type="text" id="cabo_rj45_justificativa_sim" name="cabo_rj45_justificativa_sim"
								   {if $obj.cabo_rj45 eq 1}{else}style="visibility:hidden;position:absolute;"{/if}
								   value="{$obj.cabo_rj45_justificativa_sim}" placeholder="Onde?"/>

							<input class="form-control" type="text" id="cabo_rj45_justificativa_nao" name="cabo_rj45_justificativa_nao"
								   {if $obj.cabo_rj45 eq 1}style="visibility:hidden;position:absolute;"{else}{/if}
								   value="{$obj.cabo_rj45_justificativa_nao}" placeholder="Porquê?"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="conectores_crimpados" id="conectores_crimpados" onClick="showFields(this)" {if $obj.conectores_crimpados eq 1}checked{/if}/>
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Conectores estao Crinpados?">
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="conectores_odu_isolados" id="conectores_odu_isolados" onClick="showFields(this)" {if $obj.conectores_odu_isolados eq 1}checked{/if}/>
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Conectores da ODU estao Isolado?">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="antena_travada" id="antena_travada" onClick="showFields(this)" {if $obj.antena_travada eq 1}checked{/if}/>
							</span>
							<input class="form-control" type="text" readonly="readonly" value="Antena está Travado?">
						</div>
					</div>
					<div class="form-group col-md-6">
						<input class="form-control" type="text" id="confirmacao_endereco_instalacao" name="confirmacao_endereco_instalacao" value="{$obj.confirmacao_endereco_instalacao}" placeholder="Confirmação do endereço de Instalação"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<textarea class="form-control" style="height: 80px;" id="obs_instalacao" name="obs_instalacao" placeholder="Observação">{$obj.obs_instalacao}</textarea>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>


<div id="termo_aceite_area"
		{if
		$obj.test_f_termo_aceite eq 1 &&
		$obj.test_info_rx_tx eq 1 &&
		$obj.test_clima eq 1 &&
		$obj.test_cabo eq 1 &&
		$obj.test_calibrate eq 1 &&
		$obj.test_tx eq 1 &&
		$obj.test_buc eq 1 &&
		$obj.test_antena eq 1 &&
		$obj.test_software eq 1 &&
		$obj.autocomiss eq 1 &&
		$obj.test_sl2000 eq 1
		}
	style="visibility:visible"
		{else}
	style="visibility:hidden"
		{/if}>
	<table class="tbForm" >

		<tr>
			<td>
				<label for="nms">Termo Aceite</label>
			</td>
			<td>
				<form method="post" enctype="multipart/form-data" name="form_termo_aceite_sp" action="Instalacao_sp/uploadTermo" id="form_termo_aceite_sp" >
					<input type="hidden" name="tipo" id="tipo" value="file"/>
					<input type="hidden" name="id" id="id" value="{$obj.idinstalacoes_sp}"/>
					<input
							type="file"
							value="Anexar imagem dos testes"
							name="termo_aceite"
							id="termo_aceite"
							onChange="javascript:
									if(confirm('Está preparado para finalizar esse comissionamento?'))
									{ldelim}
									//var teste = enviaComiss('#FCOMISS');
									sendPost('Comissionamento_sp/edit_comiss','FCOMISS','termo_sp');
							{rdelim}
									else
									{ldelim}
									this.value = '';
							{rdelim}
									"
					/>
				</form>
				<div id="form_termo_aceite_sp_result">

					{if $obj.termo_aceite != ''}<a href="{$obj.termo_aceite}" target="_blank">Termo Aceite</a>{/if}
				</div>
			</td>
		</tr>

	</table>
</div>
<div id="termo_aceite_area_explicacao"
	 class="alert alert-error"
		{if
		$obj.test_f_termo_aceite eq 1 &&
		$obj.test_info_rx_tx eq 1 &&
		$obj.test_clima eq 1 &&
		$obj.test_cabo eq 1 &&
		$obj.test_calibrate eq 1 &&
		$obj.test_tx eq 1 &&
		$obj.test_buc eq 1 &&
		$obj.test_antena eq 1 &&
		$obj.test_software eq 1 &&
		$obj.autocomiss eq 1 &&
		$obj.test_sl2000 eq 1
		}
			style="visibility:hidden"
		{else}
			style="visibility:visible"
		{/if}
>Envio do Termo de Aceite indisponível até que a checklist seja concluída.</div>
<center> <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div></center>

<br />
<center>
	<input
			class="btn"
			type="button"
			value="Salvar"
			style="margin-bottom:10px;"
			onClick="javascript:sendPost('Comissionamento_sp/edit_comiss','FCOMISS')" />
</center>



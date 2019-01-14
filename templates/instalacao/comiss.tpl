
{*<style>
	.tabela_tecnico{
		width:300px;
		padding:5px;
		margin-top:20px;
	}
	.tabelas_dados{
		padding:5px;
		margin-top:20px;
	}
	.tec_label{
		text-align:left;
		padding-right:10px;
		padding-left:10px;
	}
	.tec_input{
		text-align:left;
	}
	
	.padding10{
		padding:0px 10px 10px 10px;
	}
	.floatleft{
		float:left;
		margin-right:15px;
	}
	.largura500{
		width:548px;
	}
	table.largura500 tr td{
		padding-left:10px;
		padding-right:10px;
	}
	.label_dados_instalacao{
		width:245px;
	}
	.label_campo_instalacao{
		width:303px;
	}
	
	.label_dados_equipamentos{
		width:150px;
		text-align:left;
		padding:10px;
	}
	
	.campo_dados_equipamentos{
		width:230px;
	}
	
	.label_dados_equipamentos2{
		width:100px;
		text-align:left;
		padding:10px;
	}
	
	.campo_dados_equipamentos2{
		width:200px;
	}
	
	.input_check_test{
		width:20px;
		text-align:left;
		padding-left:10px;
		padding-right:5px;
	}
	.texto_check_test{
		width:470px;
		text-align:left;
	}
</style>*}

<br>
<span id="comiss_cover" style="display:none">


	<div class="container1" style="width: 55%;">
		<form action="Comissionamento/edit_comiss" method="POST" id="FCOMISS" class="form" >

			<input type="hidden" name="idinstalacoes" id="idinstalacoes" value="{$param}"/>
			<input name="create_user_comiss" id="create_user_comiss" value="{$session.login.idusuarios}" type="hidden" />
			<input name="create_user_comiss_time" id="create_user_comiss_time" value="{$agora}" type="hidden" />


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
					<input type="hidden" value="1" name="comiss" />
					<div class="row">
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control autosave" type="text" name="registro_concessionaria" id="registro_concessionaria" value="" placeholder="Registro Concessionária" />
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control autosave" type="text" name="ope_eutelsat" id="ope_eutelsat" value="" placeholder="Nome do Operador(a) do Satelite" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control autosave" type="text" id="val_crosspol" name="val_crosspol" value=""  placeholder="Valor do cross-pol Satelite"/>
							</div>

						</div>
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control autosave" type="text" id="elevacao_comiss" name="elevacao_comiss"  value="" placeholder="Elevação"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-1">
							<label for="">Lat</label>
						</div>
						<div class="form-group col-md-1">
							<div class="">
								<input class="form-control autosave" onkeyup="num(this);"
									   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
									   type="text" maxlength="2" name="latitude_graus" id="latitude_graus" value="" placeholder="º"/>
							</div>
						</div>
						<div class="form-group col-md-1">
							<div class="">
								<input class="form-control autosave" onkeyup="num(this);"
									   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
									   type="text" maxlength="2" name="latitude_minutos" id="latitude_minutos" value="" placeholder='"'/>
							</div>
						</div>
						<div class="form-group col-md-1">
							<div class="">
								<input class="form-control autosave" onkeyup="num(this);"
									   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
									   type="text" maxlength="2" name="latitude_segundos" id="latitude_segundos" value="" placeholder="'" />
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="">
								<select class="form-control autosave" name="latitude_direcao" id="latitude_direcao">
									<option value="S">S</option>
									<option value="N">N</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control autosave" type="text" id="azimute_comiss" name="azimute_comiss" value="" placeholder="Azimute" />
							</div>
						</div>

					</div>
					<div class="row">
						<div class="form-group col-md-1">
							<label for="">Long</label>
						</div>
						<div class="form-group col-md-1">
							<div class="">
								<input class="autosave form-control" onkeyup="num(this);"
									   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
									   type="text" size="2" maxlength="2" name="longitude_graus" id="longitude_graus" value="{$obj.longitude_graus}" placeholder="º"/>
							</div>
						</div>
						<div class="form-group col-md-1">
							<div class="">
								<input class="autosave form-control"
									   onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
									   type="text" size="2" maxlength="2" name="longitude_minutos" id="longitude_minutos" value="{$obj.longitude_minutos}" placeholder='"'/>
							</div>
						</div>
						<div class="form-group col-md-1">
							<div class="">
								<input class="autosave form-control" onkeyup="num(this);"
									   onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';"
									   type="text" size="2" maxlength="2" name="longitude_segundos" id="longitude_segundos" value="{$obj.longitude_segundos}" placeholder="'"/>
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="">
								<select class="form-control autosave" size="1" name="longitude_direcao" id="longitude_direcao">
									<option value="W">W</option>
									<option value="E">E</option>
								</select>
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
								<input class="form-control autosave" type="text" id="snr_comiss" name="snr_comiss" value=""  placeholder="Valor de SNR na VSAT"/>
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="">
								<select class="form-control autosave" name="antena_comiss" id="antena_comiss">
									<option value=""> Selecione Antena</option>
									<option {if $obj.antena_comiss eq 'patriot'}selected="selected"{/if} value='patriot'>Patriot</option>
									<option {if $obj.antena_comiss eq 'skyware'}selected="selected"{/if} value='skyware'> Skyware</option>
									<option value='Brasil Sat' {if $obj.antena_comiss eq 'Brasil Sat'} selected="selected" {/if}> Brasil Sat</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="">
								<input class="form-control autosave" type="text" name="antena_ns_comiss" id="antena_ns_comiss" value="" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control" type="text" name="mac_comiss" id="mac_comiss" value="" placeholder="MAC"
									   onblur="javascript: if( this.value != '' ){
                            	                    atualizaNSVsat(this.value);
                                                }"   alt="mac" />
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control" readonly="readonly" type="text" name="nsmodem_comiss" id="nsmodem_comiss" value="" placeholder="NS da Vsat"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="">
								<input class="form-control" name="nsodu_comiss" id="nsodu_comiss" placeholder="Número de série ODU/BUC"
									   onblur="javascript:atualizaODU();" value=""
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
										{if $tipoEquipamento.nome != 'Patriot' && $tipoEquipamento.nome != 'Antena Patriot' && $tipoEquipamento.nome != 'Antena Skyware'}
											<option value="{$tipoEquipamento.idtipo_equipamentos}" {if $obj.odu == $tipoEquipamento.idtipo_equipamentos}selected{/if}>{$tipoEquipamento.nome}</option>
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
								<input class="check_obrigatorio" type="checkbox" name="test_sl2000" id="test_sl2000" />
							</span>
								<input type="text" class="form-control" readonly="readonly" value="Testou Sat Link 2000?" >
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon" style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="autocomiss" />
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
								<input class="check_obrigatorio" type="checkbox" name="test_software" />
								{*<label for="test_software">Verificada a versão do software utilizado?</label>*}
							</span>
								<input type="text" class="form-control" readonly="readonly" value="Verificada a versão do software utilizado?" >
							</div>
						</div>
						<div class="form-group col-md-6" >
							<div class="input-group">
							<span class="input-group-addon"  style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_antena"/>
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
								<input class="check_obrigatorio" type="checkbox" name="test_buc" />
								{*<label for="test_buc">Verificado o tipo do buc?</label>*}
							</span>
								<input type="text" class="form-control" readonly="readonly" value="Verificado o tipo do buc?" >
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_calibrate" />
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Teste de calibrate?">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_info_rx_tx" id="test_info_rx_tx" onClick="showFields(this)" />
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Coletar informações de RX e TX?">
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_f_termo_aceite" id="test_f_termo_aceite" onClick="showFields(this)" />
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Finalizou o Termo de Aceite?">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon"  style="text-align: left;">
								<input class="check_obrigatorio" type="checkbox" name="test_tx" id="test_tx" onClick="showFields(this)"  />
								{*<label for="test_tx">Verificado os níveis de TX?</label>*}
							</span>
								<input type="text" class="form-control" readonly="readonly" value="Verificado os níveis de TX?" >
							</div>
						</div>
						<div class="form-group col-md-3 tx_input_1" style="{if $obj.test_tx != 1}visibility: hidden{/if}">
							<div class="">
								<input class="form-control autosave_sp" type="text" name="ebno_comiss" id="ebno_comiss" value="" placeholder="EB/N0:"/>
							</div>
						</div>
						<div class="form-group col-md-3 tx_input_2" style="{if $obj.test_tx != 1}visibility: hidden{/if}">
							<div class="">
								<input class="form-control autosave_sp" type="text"  name="eirp_comiss" id="eirp_comiss" value="" placeholder="EIRP Configurado:"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_cabo" id="test_cabo" onClick="showFields(this)" />
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
								<input class="form-control autosave_sp" type="text" name="comp_tipo_cabo_comiss" id="comp_tipo_cabo_comiss" value="" placeholder="Tipo de Cabo"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_clima" id="test_clima" onClick="showFields(this)" />
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Registro de condições climáticas?">
							</div>
						</div>
						<div class="form-group col-md-6 clima_inputs" style="{if $obj.test_clima != 1}visibility:hidden{/if}">
							<div class="">
								<input type="text" class="form-control autosave_sp" id="desc_clima_comiss" name="desc_clima_comiss" value="" Clima/>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="cabo_rj45" id="cabo_rj45" onClick="showFields(this)"/>
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Conectou o cabo RJ45?">
							</div>
						</div>
						<div class="form-group col-md-6">
							<div id="justificativa_cabo_rj45">
								<input class="form-control" type="text" id="cabo_rj45_justificativa_sim" name="cabo_rj45_justificativa_sim"
									   {if $obj.cabo_rj45 eq 1}{else}style="visibility:hidden;position:absolute;"{/if}
									   value="" placeholder="Onde?"/>

								<input class="form-control" type="text" id="cabo_rj45_justificativa_nao" name="cabo_rj45_justificativa_nao"
									   {if $obj.cabo_rj45 eq 1}style="visibility:hidden;position:absolute;"{else}{/if}
									   value="" placeholder="Porquê?"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_prtg" id="test_prtg" onClick="showFields(this)" />
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Retirou a imagem do PRTG/NAGIOS?">
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input class="check_obrigatorio" type="checkbox" name="test_notificacao_inicio" id="test_notificacao_inicio" onClick="showFields(this)" />
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Enviou a notificação a Prodemge?">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="conectores_crimpados" id="conectores_crimpados" onClick="showFields(this)"/>
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Conectores estao Crinpados?">
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="antena_travada" id="antena_travada" onClick="showFields(this)"/>
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Antena está Travado?">
							</div>
						</div>

					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="conectores_odu_isolados" id="conectores_odu_isolados" onClick="showFields(this)"/>
							</span>
								<input class="form-control" type="text" readonly="readonly" value="Conectores da ODU estao Isolado?">
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
				<form method="post" enctype="multipart/form-data" name="form_termo_aceite_sp" action="Instalacao/uploadTermo" id="form_termo_aceite_sp" >
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
									sendPost('Comissionamento/edit_comiss','FCOMISS','termo_sp');
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
{*<center> <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div></center>*}

<br />
<center>
	<input
			class="btn btn-primary"
			type="button"
			value="Salvar"
			style="margin-bottom:10px;"
			onClick="javascript:sendPost('Comissionamento/edit_comiss','FCOMISS')" />
</center>



{*






    <div
    	style="
    		border:1px solid #CCC;
    	">
    <div 
    	style="
    		width:100%;
    		padding:5px 0px 5px 15px;
    		text-align:left;
    		background:green;
    		margin-top:-10px;
    	">
    	<h3 style="color:#fff;">Dados do Comissionamento</h3>
    </div>
    
	<form action="Comissionamento/edit_comiss" method="POST" id="FCOMISS" class="form" >
	
    <input type="hidden" name="idinstalacoes" id="idinstalacoes" value="{$param}"/>
    <input name="create_user_comiss" id="create_user_comiss" value="{$session.login.idusuarios}" type="hidden" />
    <input name="create_user_comiss_time" id="create_user_comiss_time" value="{$agora}" type="hidden" />
        
	<table>
	<tr><td class="padding10">
	
		<!-- ----------------------------------------------------------------------------
		----------------------- TECNICO CAMPO -------------------------------------------
		----------------------------------------------------------------------------- -->
		
		<table class="tabela_tecnico">
	    	<tr>
	    		<td colspan="2" style="padding-left:10px;text-align:left;"><h4>Técnico de Campo</h4></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2"><hr/></td>
	    	</tr>
			<tr>
	        	<td class="tec_label">
	                <label for="teccampo">Nome:</label>
	            </td>
	            <td class="tec_input">               
	                <input type="text" value="" name="teccampo" />
	            </td>
			</tr>
			<tr>
	            <td class="tec_label">
	                <label for="teccampo_tel">Telefone:</label>
	            </td>
	            <td class="tec_input">              
	                <input type="text" value="" name="teccampo_tel" id="teccampo_tel" />
	            </td>
	        </tr>
		</table>
	
	</td><td></td></tr>
	<tr><td class="padding10">
	
		<!-- ----------------------------------------------------------------------------
		----------------------- DADOS INSTALAÇÃO ----------------------------------------
		----------------------------------------------------------------------------- -->
		
		<input type="hidden" value="1" name="comiss" />
		
		<table class="tabelas_dados largura500">
		
			<tr><td colspan="2" style="padding-left:10px;text-align:left;"><h4>Dados Instalação</h4></td></tr>
			
			<tr><td colspan="3" style="width:10px;"><hr/></td></tr>
	        
	        <tr>
	        	<td class="label_dados_instalacao" style="text-align:left;">
	        		<label for="registro_concessionaria">Registro Concessionária:</label>
	        	</td>
	        	<td colspan="2" class="label_campo_instalacao" style="text-align:left;">
	        		<input class="autosave" type="text" name="registro_concessionaria" id="registro_concessionaria" value="" />
	        	</td>
	        </tr>  
	        
	        <tr><td>&nbsp;</td></tr>
	       
	        <tr>    
	        	<td style="text-align:left;">
	            	<label for="ope_eutelsat">Nome do Operador(a) da EutelSat:</label>
	            </td>
	            <td style="text-align:left;">
	            	<input class="autosave" type="text" name="ope_eutelsat" id="ope_eutelsat" size="30" />
	            </td> 
	            <td>
	            	&nbsp;
	            </td>
	        </tr>
	        
	        <tr><td>&nbsp;</td></tr>
	        
	        <tr>
	        	<td style="text-align:left;">
	            	<label for="val_crosspol" >Valor do cross-pol EutelSat:</label>
	            </td>
	            <td style="text-align:left;">
	            	<input class="autosave" type="text" id="val_crosspol" name="val_crosspol"  />
	            </td>
	            <td>
	            	&nbsp;
	            </td>
	        </tr>   
	        
	        <tr><td>&nbsp;</td></tr>
	        
	        <tr>
	            <td style="text-align:left;">
	        		<label for="latitude_graus">Latitude:</label>
	            	<!-- <label for="latitude" >Latitude</label> -->
	            </td>
	            <td style="text-align:left;">
	            	<input class="autosave inputCurto" onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';" type="text" size="2" maxlength="2" name="latitude_graus" id="latitude_graus" />°&nbsp;
	            	<input class="autosave inputCurto" onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';" type="text" size="2" maxlength="2" name="latitude_minutos" id="latitude_minutos" />"&nbsp;
	            	<input class="autosave inputCurto" onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';" type="text" size="2" maxlength="2" name="latitude_segundos" id="latitude_segundos" />'&nbsp;
	            	<select class="autosave inputCurto" size="1" name="latitude_direcao" id="latitude_direcao">
	            		<option value="S">S</option>
	            		<option value="N">N</option>
	            	</select>
                </td>
                <td></td>
	        </tr> 
	        
	        <tr><td>&nbsp;</td></tr>
	        
	        <tr>
	        	<td style="text-align:left;">
	            	<label for="longitude_graus">Lognitude:</label>
	            </td>
	            <td style="text-align:left;">
                	<input class="autosave inputCurto" onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';" type="text" size="2" maxlength="2" name="longitude_graus" id="longitude_graus" />°&nbsp;
	            	<input class="autosave inputCurto" onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';" type="text" size="2" maxlength="2" name="longitude_minutos" id="longitude_minutos" />"&nbsp;
	            	<input class="autosave inputCurto" onkeyup="num(this);" onblur="javascript:(this.value.length<2 && this.value!='')?this.value = '0'+this.value:'';" type="text" size="2" maxlength="2" name="longitude_segundos" id="longitude_segundos" />'&nbsp;
	            	<select class="autosave inputCurto" size="1" name="longitude_direcao" id="longitude_direcao">
	            		<option value="W">W</option>
	            		<option value="E">E</option>
	            	</select>
	            </td>
	            <td></td>
	        </tr>
	        
	        <tr><td>&nbsp;</td></tr>
	        
	        <tr>
                <td style="text-align:left;">
                    <label for="azimute" >Azimute:</label>
                </td>
                <td style="text-align:left;">
                    <input class="autosave" type="text" id="azimute_comiss" name="azimute_comiss"  />
                </td>
                <td>
                    &nbsp;
                </td>
	        </tr>
	        
	        <tr><td>&nbsp;</td></tr>
	        
	        <tr>
	        	<td style="text-align:left;">
                    <label for="elevacao" >Elevacao:</label>
                </td>
                <td style="text-align:left;">
                    <input class="autosave" type="text" id="elevacao_comiss" name="elevacao_comiss"  />
                </td>
                <td>
                    &nbsp;
                </td>
			</tr>
	    </table>
        
        
    </td><td class="padding10" valign="top">
        
        <!-- ----------------------------------------------------------------------------
		----------------------- DADOS EQUIPAMENTOS --------------------------------------
		----------------------------------------------------------------------------- -->
        
	    <table class="tabelas_dados">
	    
	        <tr><td colspan="2" style="padding-left:10px;text-align:left;"><h4>Dados Equipamentos</h4></td></tr>
	        
	        <tr><td colspan="4"><hr/></td></tr>
	        	
	        <tr>
	        	<td class="label_dados_equipamentos">
	            	<label for="snr" >Valor de SNR na VSAT:</label>
	            </td>
	            
	            <td class="campo_dados_equipamentos">
	            	<input class="autosave" type="text" id="snr_comiss" name="snr_comiss"  />
	            </td>
	            
	            <td colspan="2">
	                    &nbsp;
                </td>
            </tr>
            
            <tr><td>&nbsp;</td></tr>
           	
            <tr >
                <td class="label_dados_equipamentos">
                    <label for="mac">MAC:</label>
                </td>
                <td>
                    <input class="autosave" type="text" name="mac_comiss" id="mac_comiss" onblur="javascript:if( this.value != '' ){ atualizaNSVsat(this.value); }" alt="mac" />
                </td>
                <td class="label_dados_equipamentos2">
                    <label for="nsmodem">NS da Vsat:</label>
                </td>
                <td class="campo_dados_equipamentos2">
                    <input class="autosave" readonly="readonly" type="text" name="nsmodem_comiss" id="nsmodem_comiss" />
                </td>
            </tr>
            
            <tr><td>&nbsp;</td></tr>
            
            <tr >
                <td class="label_dados_equipamentos">
                    <label for="nsodu">Número de série ODU:</label>
                </td>
                <td>
                	<input class="autosave" size="27" name="nsodu_comiss" id="nsodu_comiss" onblur="javascript:atualizaODU()" value="" type="text" />
                	<br/>
                	<div style="display:none" id="listaComplete">{$listaautocomplete}</div>
                </td>
                <td class="label_dados_equipamentos2">
                    <label for="odu">ODU:</label>
                </td>
                <td class="campo_dados_equipamentos2">
                    <select name="odu" id="odu" style="width:210px;" class="autosave inputReq">
                    	<option value="">Escolha uma opção:</option>
                    	{foreach from=$tipoEquipamentos item=tipoEquipamento}
                    		{if $tipoEquipamento.nome != 'Patriot' && $tipoEquipamento.nome != 'Antena Patriot' && $tipoEquipamento.nome != 'Antena Skyware'}
                    			<option value="{$tipoEquipamento.idtipo_equipamentos}">{$tipoEquipamento.nome}</option>
                    		{/if}
                    	{/foreach}
                    </select>
                </td>
            </tr>
            
            <tr><td>&nbsp;</td></tr>
            
            <tr >
                <td colspan="2" style="text-align:right;padding-right:20px;">
                    <label for="nsodu">Antena marca/número de série:</label>
                </td>
                <td colspan="2" style="width:400px;text-align:left;">
                    <select class="autosave" name="antena_comiss" id="antena_comiss" style="width:95px;margin-right:10px;">
                        <option value='patriot' disabled="disabled">Patriot</option>
                        <option value='skyware'> Skyware</option>
                    </select> 
                    <input class="autosave" type="text" name="antena_ns_comiss" id="antena_ns_comiss" />
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
	            
            <table class="tabelas_dados">
            
            	<tr>
                	<td colspan="6" style="padding-left:10px;text-align:left;">
                    	<h4>Inicio de Testes</h4>
                 	</td>
                </tr>
                
                <tr>
                 	<td colspan="6">
                    	<hr />
                	</td>
             	</tr>
             	
             	<tr>
		        	<td class="input_check_test">
		            	<input class="check_obrigatorio" type="checkbox" name="test_sl2000" id="test_sl2000" />
		            </td>
		            <td class="texto_check_test" colspan="5">
		            	<label for="test_sl2000">Testou Sat Link 2000?</label>
		            </td>
		        </tr>
             	
            	<tr>
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="autocomiss" />
	                </td>
	                <td class="texto_check_test" colspan="5">
	                    <label>Auto comissionamento foi realizado?</label>
	                </td>
            	</tr>
            	
             	<tr>
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="test_software" />
	                </td>
	                <td class="texto_check_test" colspan="5">
	                	<label>Verificada a versão do software utilizado?</label>
	                <td>
	                    
	                </td>
	                 <td>
	                    &nbsp;
	                </td>
            	</tr>
            	
             	<tr >
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="test_antena" />
	                </td>
	                <td class="texto_check_test" colspan="5">
	                	<label>Verificado o tamanho e o tipo da antena?</label>
	                <td>
	                    
	                </td>
	                 <td>
	                    &nbsp;
	                </td>
            	</tr>
            	
				<tr >
	                <td class="input_check_test">
	                   	<input class="check_obrigatorio" type="checkbox" name="test_buc" />
	                </td>
	                <td class="texto_check_test">
	                	<label>Verificado o tipo do buc?</label>
	                </td>
	                <td colspan="4">
	                	&nbsp;
	                </td>
	            </tr>
 			           
	            <tr >
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="test_tx" id="test_tx" onClick="showFields(this)" />
	                </td>
	                <td class="texto_check_test">
	                	<label>Verificado os níveis de TX?</label>
	                </td>
	                <td style="text-align:right;padding-right:10px;">
	                	<div class="tx_input_1" style="visibility:hidden">
	                		<label>EB/N0:</label>
	                	</div>
	                </td>
	                <td style="text-align:left;">
	                	<div class="tx_input_1" style="visibility:hidden">
	                		<input class="autosave" type="text" name="ebno_comiss" id="ebno_comiss" size="5" />
	                	</div>
	                </td>
	                <td style="text-align:right;padding-right:10px;padding-left:50px;">
	                	<div class="tx_input_2" style="visibility: hidden">
	                		<label>EIRP Configurado:</label>
	                	</div>
	                </td>
	                <td style="text-align:left;">
	                	<div class="tx_input_2" style="visibility: hidden">
	                		<input class="autosave" type="text"  name="eirp_comiss" id="eirp_comiss" size="5" />
	                	</div>
	                </td>
	            </tr>
	            
              	<tr >
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="test_calibrate" />
	                </td>
	                <td class="texto_check_test">
	                	<label>Teste de calibrate?</label>
	                </td>
	                <td colspan="4">
	                    
	                </td>
	            </tr>
            	<tr>
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="test_cabo" id="test_cabo" onClick="showFields(this)" />
	                </td>
	                <td class="texto_check_test">
	                	<label>Registro do comprimento/distância do cabo entre buc e modem?</label>
	                </td>
	                <td>
	                   	<div class="cabo_input" style="visibility: hidden;text-align:right;padding-lefr:10px;"> 
	                		<label for="comp_cabo_comiss">Valor:</label>
	                	</div>
	                </td>
	                <td colspan="3">
	                	<div class="cabo_input" style="visibility: hidden;text-align:left;">
	                    	<input class="autosave" type="text" name="comp_cabo_comiss" size="5" />
	                    </div>
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="input_check_test">
	                   <input class="check_obrigatorio" type="checkbox" name="test_clima" id="test_clima" onClick="showFields(this)" />
	                </td>
	                <td class="texto_check_test">
	                	<label>Registro de condições climáticas?</label>
	                </td>
	                <td>
	                	<div class="clima_inputs" style="visibility: hidden">
	                		<textarea class="autosave" id="desc_clima_comiss" name="desc_clima_comiss" cols="40"></textarea>
	                	<div>
	                </td>
	                <td colspan="3">
	                    
	                </td>
	            </tr>
	            
            	<tr>
		        	<td class="input_check_test">
		            	<input class="check_obrigatorio" type="checkbox" name="test_prtg" id="test_prtg" onClick="showFields(this)" />
		            </td>
		            <td class="texto_check_test">
		            	<label>Retirou a imagem do PRTG/NAGIOS?</label>
		            </td>
		            <td>
		            	&nbsp;
		            </td>
		            <td colspan="3">
		            	
		            </td>
		        </tr>
		        
		        <tr>
		        	<td class="input_check_test">
		            	<input class="check_obrigatorio" type="checkbox" name="test_info_rx_tx" id="test_info_rx_tx" onClick="showFields(this)" />
		            </td>
		            <td class="texto_check_test">
		            	<label>Coletar informações de RX e TX?</label>
		            </td>
		            <td>
		            	&nbsp;
		            </td>
		            <td colspan="3">
		            	
		            </td>
		        </tr>
		        
		        <tr>
		        	<td class="input_check_test">
		            	<input class="check_obrigatorio" type="checkbox" name="test_f_termo_aceite" id="test_f_termo_aceite" onClick="showFields(this)" />
		            </td>
		            <td class="texto_check_test">
		            	<label>Finalizou o Termo de Aceite?</label>
		            </td>
		            <td>
		            	&nbsp;
		            </td>
		            <td colspan="3">
		            	
		            </td>
		        </tr>
		        
		        <tr>
		        	<td class="input_check_test">
		            	<input class="check_obrigatorio" type="checkbox" name="test_e_termo_aceite" id="test_e_termo_aceite" onClick="showFields(this)"/>
		            </td>
		            <td class="texto_check_test">
		            	<label>Enviou o Termo de Aceite à Prodemge?</label>
		            </td>
		            <td>
		            	&nbsp;
		            </td>
		            <td colspan="3">
		            	
		            </td>
		        </tr>
		        
		        <tr>
		        	<td class="input_check_test">
		            	<input type="checkbox" name="cabo_rj45" id="cabo_rj45" onClick="showFields(this)"/>
		            </td>
		            <td class="texto_check_test">
		            	<label>Conectou o cabo RJ45?</label>
		            </td>
		            <td>
		            	<div id="pergunta_cabo_rj45">
			           		Porquê?
			           	</div>
			           	<div id="justificativa_cabo_rj45">
			           		<textarea 
			           			class="autosave"
			           			id="cabo_rj45_justificativa_sim" 
			           			name="cabo_rj45_justificativa_sim" 
			           			cols="40"
			           			style="visibility:hidden;position:absolute;"
			           		></textarea>
			           		
			           		<textarea 
			           			class="autosave"
			           			id="cabo_rj45_justificativa_nao" 
			           			name="cabo_rj45_justificativa_nao" 
			           			cols="40"
			           		></textarea>
	              		</div>
		            </td>
		            <td colspan="3">
		            	
		            </td>
		        </tr>
          
      		</table>
      		
	</td>
    </tr></table>
    </form>
      	
		<div style="width:100%;padding:10px;"><hr/></div>
		
        <!-- ---------------------------------------------------------------------------------
        --------------- TRECHOS DE UPLOAD ----------------------------------------------------
        ---------------------------------------------------------------------------------- -->
        
		<div id="termo_aceite_area"
      		style="visibility:hidden">		
			<table class="tbForm" >
			
				<tr>
	                <td>
						<label for="nms">Termo Aceite</label>
	                </td>
	                <td>
	                	<form method="post" enctype="multipart/form-data" name="form_termo_aceite" action="Instalacao/uploadTermo" id="form_termo_aceite" >
	                    	<input type="hidden" name="tipo" id="tipo" value="file"/>
	                    	<input type="hidden" name="id" id="id" value="{$param}"/>
	                    	<input 
	                    		type="file" 
	                    		value="Anexar imagem dos testes" 
	                    		name="termo_aceite" 
	                    		id="termo_aceite" 
	                    		onChange="javascript:
	                    			if(confirm('Está preparado para finalizar esse comissionamento?'))
	                    			{ldelim}
	                    				//var teste = enviaComiss('#FCOMISS');
	                    				sendPost('Comissionamento/edit_comiss','FCOMISS','termo');
	                    			{rdelim}
	                    			else
	                    			{ldelim}
	                    				this.value = '';
	                    			{rdelim}
	                    		" 
	                    	/>
	                    </form>
	                    <div id="form_termo_aceite_result"></div>
	            	</td>
				</tr>
				
			</table>
		</div>
		<div id="termo_aceite_area_explicacao"
			class="alert alert-error"
			style="visibility:visible;"
		>Envio do Termo de Aceite indisponível até que a checklist seja concluída.</div>	
        <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
		
    <br />
    <center>
    	<input 
    		class="btn" 
    		type="button" 
    		value="Salvar"
    		style="margin-bottom:10px;" 
    		onClick="javascript:sendPost('Comissionamento/edit_comiss','FCOMISS')" />
    </center>

</span>*}
     
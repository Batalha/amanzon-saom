<div class="container1" style="margin-top: 0px";>
	<div class="row">
		{include file="OS/submenu.tpl" title=submenu}
	</div>
</div>
<br>

<div class="container1" style="width: 66%;">
	<form action="OS/edit" method="POST" id="FOSCreate" class="form" >
		<input type="hidden" name="idos" id="idos" value="{$obj.idos}" />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="pane-title text-center">Cadastrar Os</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_os' type="text" name="numOS" id="numOS" value="{$obj.numOS}" placeholder="Numero da OS"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input class='form-control inputReq autosave_os' type="text" name="identificador" id="identificador" value="{$obj.identificador}" placeholder="Identificador"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<select name="orgao" id="orgao" class="form-control inputNReq">
							<option value="Secretaria de Estado de Saúde">Secretaria de Estado de Saúde</option>
							<option value="Secretaria de Educacao">Secretaria de Educacao</option>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" name="cnpj" id="cnpj" value="{$obj.cnpj}" class='form-control inputReq autosave_os'/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input type="text" name="escola" id="escola" class='form-control inputReq autosave_os' value="{$obj.escola}" placeholder="Escola"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" name="contato" id="contato" class='form-control inputReq autosave_os' value="{$obj.contato}" placeholder="Nome"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input type="text" id="telContato" name="telContato" class='form-control autosave_os' value="{$obj.telContato}" placeholder="Telefone"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class="form-control autosave_os" type="text" id="outroTelContato" name="outroTelContato" value="{$obj.outroTelContato}"  placeholder="Outros telefone"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input type="text" id="email" name="email"  class='form-control autosave_os' value="{$obj.email}" placeholder="Email"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<div class="">
							<input type="text" id="enderecoInstal" name="enderecoInstal" class='form-control autosave_os' value="{$obj.enderecoInstal}" placeholder="Endereço"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<select name="municipios_idcidade" id="municipios_idcidade" class="form-control selectReq autosave_os">
								{foreach from=$arrMun item=i}
									<option value="{$i.idmunicipios}" {if $obj.municipios_idcidade == $i.idmunicipios} selected {/if}>{$i.municipio}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input type="text" id="cep" name="cep" class='form-control autosave_os' alt="cep" value="{$obj.cep}" placeholder="CEP"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input type="text" id="areaInstal" name="areaInstal" size="30" class='form-control'  value="{$obj.areaInstal}" placeholder="Area de Instalação"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input type="text" id="perfil" name="perfil" class='form-control autosave_os' value="{$obj.perfil}" placeholder="Perfil"/>
						</div>
					</div>
				</div>
			</div> {*---PANEL-BODY--*}
		</div>{*---PANEL-HEADING--*}

		<div class="panel panel-primary" style="margin-top: -10px;">
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="velDownload" name="velDownload" class='form-control'  value="{$obj.velUpload}" placeholder="Download"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="velUpload" name="velUpload" class='form-control' value="{$obj.velUpload}" placeholder="Upload"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="padrao" name="padrao" class='form-control autosave_os' value="Sem redundância" placeholder="Padrão"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="iplan" name="iplan" class='form-control inputReq autosave_os' value="{$obj.iplan}"  placeholder="IP Lan"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="mascaraLan" name="mascaraLan" class='form-control inputReq autosave_os' value="{$obj.mascaraLan}"  placeholder="Mascara Lan"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="servico" name="servico" class='form-control autosave_os' value="Satélite" placeholder="Serviço"/>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-primary" style="margin-top: -10px;">
			<div class="panel-heading">
				<div class="panel-title text-center">Faturamento</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
						<select class="form-control autosave_os" name="empresas_idempresas" id="empresas_idempresas">
							<option value="">Selecione uma empresa</option>
							{foreach from=$empresas item=empresa}
								<option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empresas_idempresas}selected{/if}>{$empresa.empresa}</option>
							{/foreach}
						</select>
						</div>
					</div>
					<div class="form-group col-md-8">
						<div class="">
						<input type="text" id="enderecoFaturamento" name="enderecoFaturamento"  value="{$obj.enderecoFaturamento}" class='form-control autosave_os' placeholder="Endereço"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
						<select name="municipios_idcidadeFaturamento" id="municipios_idcidadeFaturamento" class="form-control autosave_os">
							{foreach from=$arrMun item=i}
								<option value={$i.idmunicipios} {if $i.idmunicipios == $obj.municipios_idcidadeFaturamento} selected{/if}>{$i.municipio}</option>
							{/foreach}
						</select>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="cepFaturamento" name="cepFaturamento" class='form-control' value="{$obj.cepFaturamento}" alt="cep" placeholder="CEP"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
						<input type="text" id="emailFaturamento" name="emailFaturamento" size="30" class='form-control autosave_os' value="{$obj.emailFaturamento}" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="input-group">
							<input type="text" id="dataSolicitacao" name="dataSolicitacao" size="10" class='form-control' value="{$obj.dataSolicitacao}"  placeholder="Data Solicitação"/>
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class="form-control" type="text" id="prazoInstal" name="prazoInstal" onfocus="getPrazoInstal()" value="{$obj.prazoInstal}" placeholder="Prazo de Instalação"/>
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<div class="">
						<textarea class="form-control" style="height: 80px;" type="text" id="observacoes" name="observacoes"  placeholder="Observação">{$obj.observacoes}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input class="btn btn-primary" type="button" value="Salvar" onClick="javascript:sendPost('OS/edit','FOSCreate')" />
					</div>
					<div class="form-group col-md-8">
						{*<div id="msg_prazo" style="color:red">*}
						<div class="alert alert-info" id="msg_prazo" style="display:none;"></div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

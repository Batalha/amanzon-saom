<div class="container1" style="margin-top: 0px;">
	<div class="row">
		{include file="OS/submenu.tpl" title=submenu}
	</div>
</div>
<br>



<div class="container1" style="width: 66%;">
	<form action="OS/create" method="POST" id="FOSCreate" class="form" >
		<input type="hidden" name="iduser_cadastro" value="{$login.idusuarios}">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="pane-title text-center">Cadastrar Os</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="numOS" id="numOS" placeholder="Numero da OS"/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="identificador" id="identificador"  placeholder="Identificador"/>
					</div>
					<div class="form-group col-md-4">
						<select name="orgao" id="orgao" class="form-control inputNReq">
							<option value="Secretaria de Educacao">Secretaria de Educacao</option>
							<option value="Secretaria de Estado de Saúde">Secretaria de Estado de Saude</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input type="text" name="cnpj" id="cnpj" value="18.717.516/0001-88" class='form-control inputReq'/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" name="escola" id="escola" class='form-control inputReq' placeholder="Escola"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" name="contato" id="contato" class='form-control inputReq' placeholder="Nome"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input type="text" id="telContato" name="telContato" class='form-control' placeholder="Telefone"/>
					</div>
					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="outroTelContato" name="outroTelContato"  placeholder="Outros telefone"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="email" name="email"  class='form-control' placeholder="Email"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<input type="text" id="enderecoInstal" name="enderecoInstal" class='form-control' placeholder="Endereço"/>
					</div>
					<div class="form-group col-md-4">
						<select name="municipios_idcidade" id="municipios_idcidade" class="form-control">
							<option value="">Cidade</option>
							{foreach from=$arrMun item=i}
								<option value={$i.idmunicipios}>{$i.municipio|utf8_encode}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input type="text" id="cep" name="cep" class='form-control' alt="cep" placeholder="CEP"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="areaInstal" name="areaInstal" size="30" class='form-control'  value="Urbana" placeholder="Area de Instalação"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="perfil" name="perfil" class='form-control' value="4" placeholder="Perfil"/>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-primary" style="margin-top: -10px;">
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<input type="text" id="velDownload" name="velDownload" class='form-control' value="" placeholder="Download"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="velUpload" name="velUpload" class='form-control' value="" placeholder="Upload"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="padrao" name="padrao" class='form-control' value="Sem redundância" placeholder="Padrão"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input type="text" id="iplan" name="iplan" class='form-control inputReq' placeholder="IP Lan"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="mascaraLan" name="mascaraLan" class='form-control inputReq'  placeholder="Mascara Lan"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="servico" name="servico" class='form-control' value="Satélite" placeholder="Serviço"/>
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
						<select class="form-control" name="empresas_idempresas" id="empresas_idempresas">
							<option value="">Selecione uma Empresa</option>
							{foreach from=$empresas item=empresa}
								{if $empresa.local == BH}
									<option value="{$empresa.idempresas}">{$empresa.empresa}</option>
								{/if}
							{/foreach}
						</select>
					</div>
					<div class="form-group col-md-8">
						<input type="text" id="enderecoFaturamento" name="enderecoFaturamento" value="Rua Sapucaí, 429 - Floresta" class='form-control' placeholder="Endereço"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<select name="municipios_idcidadeFaturamento" id="municipios_idcidadeFaturamento" class="form-control">
							{foreach from=$arrMun item=i}
								<option value={$i.idmunicipios} {if $i.municipio == 'BELO HORIZONTE'} selected{/if}>{$i.municipio|utf8_encode}</option>
							{/foreach}
						</select>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="cepFaturamento" name="cepFaturamento" class='form-control' value="" alt="cep" placeholder="CEP"/>
					</div>
					<div class="form-group col-md-4">
						<input type="text" id="emailFaturamento" name="emailFaturamento" size="30" class='form-control' value="marcos.milagres@saude.mg.gov.br" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="input-group">
							<input type="text" id="dataSolicitacao" name="dataSolicitacao" size="10" class='form-control'  placeholder="Data Solicitação"/>
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class="form-control" type="text" id="prazoInstal" name="prazoInstal" onfocus="getPrazoInstal()" placeholder="Prazo de Instalação"/>
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<textarea class="form-control" style="height: 80px;" type="text" id="observacoes" name="observacoes" placeholder="Observação"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input type="button" class="btn btn-primary" value="Cadastrar OS" onClick="javascript:sendPost('OS/create','FOSCreate')" />
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
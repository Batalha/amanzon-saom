<div class="container1" style="margin-top: -10px;  margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
	</div>
</div>

<br>
<div class="container1" style="width: 60%;">
	<form action="s_p/controller/OSSP/edit_outros_canais" method="POST" id="FOSCreateoutrosCanais" class="form" >
		<input type="hidden" name="idos" id="idos" value="{$obj.idos}" />
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title text-center">Outros Canais</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<select class="form-control autosave_ossp" name="empresas_idempresas" id="empresas_idempresas">
								<option value="">Selecione um Clinete</option>
								{foreach from=$empresas item=empresa}
									{if $empresa.local == SP}
										<option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empresas_idempresas}selected{/if}>{$empresa.empresa}</option>
									{/if}
								{/foreach}
							</select>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" name="numOS" id="numOS" value="{$obj.numOS}" placeholder="Numero da Os"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class='form-control' type="text" id="dataSolicitacao" name="dataSolicitacao" value="{$obj.dataSolicitacao}" placeholder="Data Solicatação"   />
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" name="contato" id="contato" value="{$obj.contato}" placeholder="Nome" />
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input  class='form-control autosave_ossp' type="text" id="telContato" name="telContato" value="{$obj.telContato}" placeholder="Celular"
									onkeypress="Mask(this, celular)"
							/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class="form-control autosave_ossp" type="text" id="outroTelContato" name="outroTelContato" value="{$obj.outroTelContato}" placeholder="Telefone"
								   onkeypress="Mask(this, telefone)"
							/>
						</div>
					</div>

				</div>
				<div class="row">

					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="cep" name="cep" value="{$obj.cep}" placeholder="CEP"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp'  type="text" name="cidade" id="cidade" value="{$obj.cidade}" placeholder="Cidade"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" name="estado" id="estado" value="{$obj.estado}" placeholder="Estado"/>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="enderecoInstal" name="enderecoInstal" value="{$obj.enderecoInstal}" placeholder="Endereco da Insatalação"/>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-body">

				<div class="row">
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class="form-control" type="text"  readonly="readonly" value="Speednet:"/>
                            <span class="input-group-addon">
                                <input type="radio" name="speednet" id="speedSim" value="sim" {if $obj.speednet =='sim'}checked="checked"{else}{/if}
									   onclick="escondeSelect(id)"

								/>
                                <label for="">Sim</label>
                                <input type="radio" name="speednet" id="speedNao" value="nao" {if $obj.speednet =='nao'}checked="checked"{else}{/if}
									   onclick="escondeSelect(id)"

								/>
                                <label for="">Não</label>
                            </span>
						</div>
					</div>
					<div class="form-group col-md-4 selecione">
						<select name="speedTipo" id="speedTipo"  {if $obj.speednet =='sim'}{else} disabled="disabled" {/if} class="form-control" onchange="escondeSelect()">
							<option value="">--Selecione--</option>
							<option value="plug&play"{if $obj.speedTipo=='plug&play'} selected {/if}>Plug&Play</option>
							<option value="transparent" {if $obj.speedTipo=='transparent'} selected {/if}>Transparent mode</option>
							<option value="outros"
									{if ($obj.speedTipo!='outros') && $obj.speednet !='nao'}
										selected
									{/if}>Outros</option>
						</select>
					</div>
					<div class="form-group col-md-4 qualTipo"
						 {if $obj.speedTipo == ''}
						 	hidden
						 {/if}
					>
						<input class="form-control" type="text" name="outrospeed" id="outrospeed" value="{$obj.speedTipo}" placeholder="Outros">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class="form-control" type="text" style="width: 45px" readonly="readonly" value="Ip:">
							<span class="input-group-addon">
								<input type="radio" name="iplan" id="iplan" value="sim" {if $obj.iplan =='sim'}checked="checked"{else}{/if} onclick="return chekQtLinhas(this)">
								<label for="">Sim</label>
								<input type="radio" name="iplan" id="iplan" value="nao" {if $obj.iplan =='nao'}checked="checked"{else}{/if} onclick="return chekQtLinhas(this)">
								<label for="">Não</label>
							</span>
							<input class="form-control" type="text" name="qtip" id="qtip" value="{$obj.qtip}" placeholder="Qtd"/>

						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class="form-control" type="text" style="width: 53px" readonly="readonly" value="Voip:">
							<span class="input-group-addon">
								<input type="radio" name="voip" id="voip" value="sim" {if $obj.voip =='sim'}checked="checked"{else}{/if} onclick="return chekQtLinhas(this)">
								<label for="">Sim</label>
								<input type="radio" name="voip" id="voip" value="nao" {if $obj.voip =='nao'}checked="checked"{else}{/if} onclick="return chekQtLinhas(this)">
								<label for="">Não</label>
							</span>
							<input class="form-control" type="text" name="qtlinha" id="qtlinha" value="{$obj.qtlinha}" placeholder="Qtd"/>

						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<select class="form-control autosave_ossp" name="escricao_fornecimento_idescricao_fornecimento" id="escricao_fornecimento_idescricao_fornecimento" >
								<option value="">Selecione um Fornecimento</option>
								{foreach from=$escricoes item=escricao}
									<option value="{$escricao.idescricao_fornecimento}" {if $escricao.idescricao_fornecimen == $obj.escricao_fornecimento_idescricao_fornecimento}selected{/if}>{$escricao.nome_escricao_forn}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="mirDownload" name="mirDownload" value="{$obj.mirDownload}" placeholder="MIR Download"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="mirlUpload" name="mirUpload" value="{$obj.mirUpload}" placeholder="MIR Upload" />
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<select class="form-control autosave_ossp" name="satelite_idsatelite" id="satelite_idsatelite" >
								<option value="">Selecione um Satelite</option>
								{foreach from=$satelites item=satelite}
									<option value="{$satelite.idsatelite}"{if $satelite.idsatelite == $obj.satelite_idsatelite}selected{/if}>{$satelite.nome_satelite}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="cirUpload" name="cirUpload" value="{$obj.cirUpload}" placeholder="CIR Upload" />
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="cirDownload" name="cirDownload" value="{$obj.cirDownload}" placeholder="CIR Download" />
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title text-center">Faturamento</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<select class="form-control" name="empreiteira_idempresas" id="empreiteira_idempresas">
								<option value="">Selecione</option>
								{foreach from=$empresas item=empresa}
									{if $empresa.tipo == EMP}
										<option value="{$empresa.idempresas}"{if $empresa.idempresas == $obj.empreiteira_idempresas}selected{/if}>{$empresa.empresa}</option>
									{/if}
								{/foreach}
							</select>
						</div>
					</div>
					<!--<div class="form-group col-md-4">-->
						<!--<div class="">-->
							<!--<input class='form-control autosave_ossp' type="text" name="cnpjFaturamento" id="cnpjFaturamento" value="{$obj.cnpjFaturamento}" placeholder="CNPJ"-->
								   <!--onkeypress="Mask(this, cnpj)"-->
							<!--/>-->
						<!--</div>-->
					<!--</div>-->
					<!--<div class="form-group col-md-4">-->
						<!--<div class="">-->
							<!--<input  class='form-control autosave_ossp' type="text" id="cepFaturamento" name="cepFaturamento" value="{$obj.cepFaturamento}" placeholder="CEP"-->
									<!--onkeypress="Mask(this, cep)"-->
							<!--/>-->
						<!--</div>-->
					<!--</div>-->
				<!--</div>-->
				<!--<div class="row">-->
					<!--<div class="form-group col-md-4">-->
						<!--<div class="">-->
							<!--<input class='form-control autosave_ossp' type="text" id="enderecoFaturamento" name="enderecoFaturamento" value="{$obj.enderecoFaturamento}" placeholder="Edereço"/>-->
						<!--</div>-->
					<!--</div>-->
					<!--<div class="form-group col-md-4">-->
						<!--<div class="">-->
							<!--<input class='form-control autosave_ossp' type="text" name="cidadeFaturamento" id="cidadeFaturamento" value="{$obj.cidadeFaturamento}" placeholder="Cidade"  />-->
						<!--</div>-->
					<!--</div>-->
					<!--<div class="form-group col-md-4">-->
						<!--<div class="">-->
							<!--<input class='form-control autosave_ossp' type="text" name="estadoFaturamento" id="estadoFaturamento" value="{$obj.estadoFaturamento}" placeholder="Estado"  />-->
						<!--</div>-->
					<!--</div>-->
				<!--</div>-->
				<!--<div class="row">-->

					<!--<div class="form-group col-md-4">-->
						<!--<div class="">-->
							<!--<input class='form-control autosave_ossp' type="text" id="emailFaturamento" name="emailFaturamento" value="{$obj.emailFaturamento}" placeholder="Email" />-->
						<!--</div>-->
					<!--</div>-->

				<!--</div>-->
				<div class="row">
					<div class="form-group col-md-12">
						<div class="">
							<textarea class="form-control autosave_ossp" type="text" id="observacoes" name="observacoes" style="height: 100px;" placeholder="Observação">{$obj.observacoes}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 text-center">
						<input type="button" class="btn btn-info" value="Editar OS" onClick="javascript:sendPost('OSSP/edit_outros_canais','FOSCreateoutrosCanais')" />
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<br>
<br>
<br>
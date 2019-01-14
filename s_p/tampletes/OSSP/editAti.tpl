<div class="container1" style="margin-top: -10px;  margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
	</div>
</div>

<br>

<div class="container1" style="width: 60%;">
	<form action="s_p/controller/OSSP/editAti" method="POST" id="FOSCreateAti" class="form" >
		<input type="hidden" name="idos" id="idos" value="{$obj.idos}" />

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="pane-title text-center">Editar ATI OS - N° {$obj.numOS}</div>
			</div>
			<div class="panel-body">

				<div class="row">
					<div class="form-group col-md-4 paddingForm">
						<select class="form-control" name="empreiteira_idempresas"
								id="empreiteira_idempresas">
							<option value="">Selecione Empreiteira</option>
							{foreach from=$empresas item=empresa}
								{if $empresa.tipo == EMP || $empresa.tipo == EMPT}
									<option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empreiteira_idempresas}selected{/if}>{$empresa.empresa}</option>
								{/if}
							{/foreach}
						</select>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="numOS" id="numOS" value="{$obj.numOS}"
							   placeholder="Numero da Os"/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="identificador" value="{$obj.identificador}"
							   id="identificador" placeholder="Identificador"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<label for="orgao">Orgão</label>
						<input class='form-control inputReq' type="text" name="orgao" id="orgao"
							   value="{$obj.orgao}"/>
					</div>
					<div class="form-group col-md-4">
						<label for="unidade">Unidade</label>
						<input class='form-control inputReq' type="text" name="unidade" id="unidade" valu
							   value="{$obj.unidade}"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<div class="input-group">
							<input class="form-control" type="text" size="10" readonly="readonly"
								   value="Tipo de Acesso:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="acesso" id="p_acesso" value="publico"
												   {if $obj.acesso =='publico'}checked="checked"{else}{/if}
												   onclick="escondeCampo(id)">
                                            <b> Público &nbsp;</b>
                                            <input type="radio" name="acesso" id="e_acesso" value="escola"
												   {if $obj.acesso =='escola'}checked="checked"{else}{/if}
												   onclick="escondeCampo(id)">
                                            <b> Escola &nbsp;</b>
                                            <input type="radio" name="acesso" id="o_acesso"
											   {if $obj.acesso !='publico' && $obj.acesso !='escola'}checked="checked"{else}{/if}
												onclick="escondeCampo(id)">
                                            <b> Outros</b>
                                        </span>
							<input class="form-control" type="text" name="acesso" id="outros" disabled="disabled"
								         {if $obj.acesso != 'publico' && $obj.acesso != 'escola'}
								   			value="{$obj.acesso}"
										 {else}value=" "{/if}
							/>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<input class='form-control inputReq' type="text" name="contato" id="contato" value="{$obj.contato}"
							   placeholder="Nome"
						/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="inep" id="inep" value="{$obj.inep}"
							   placeholder="Inep"
						/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="outroTelContato"
							   name="outroTelContato" value="{$obj.outroTelContato}" placeholder="Telefone 1"
							   onkeypress="Mask(this, telefone)"
						/>
					</div>
					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="outroTelContato2"
							   name="outroTelContato2" value="{$obj.outroTelContato2}" placeholder="Telefone 2"
							   onkeypress="Mask(this, telefone)"
						/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" id="telContato" name="telContato"
							   value="{$obj.telContato}" placeholder="Celular"
							   onkeypress="Mask(this, celular)"

						/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<input class='form-control inputReq' type="email" id="email" name="email" value="{$obj.email}"
							   placeholder="E-email"/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" id="cep" name="cep" value="{$obj.cep}"
							   alt="cep" placeholder="CEP"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<input class='form-control inputReq' type="text" id="enderecoInstal"
							   name="enderecoInstal" value="{$obj.enderecoInstal}" placeholder="Endereço"/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="pais" id="pais" value="{$obj.pais}"
							   placeholder="Pais"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="cidade" id="cidade" value="{$obj.cidade}"
							   placeholder="Cidade"/>
					</div>
					<div class="form-group col-md-4">
						<input class='form-control inputReq' type="text" name="estado" id="estado" value="{$obj.estado}"
							   placeholder="Estado"/>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-success" style="margin-top: -10px;">
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class="form-control" type="text" readonly="readonly"
								   value="Area:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="area_instal" id="u_area_instal" value="urbana"
												{if $obj.area_instal =='urbana'}checked="checked"{else}{/if}
											>
                                            <b>Urbano &nbsp;</b>
                                            <input type="radio" name="area_instal" id="r_area_instal" value="rural"
											   {if $obj.area_instal =='rural'}checked="checked"{else}{/if}
											>
                                            <b>Rural &nbsp;</b>
                                        </span>
						</div>
					</div>
					<div class="form-group col-md-8">
						<div class="input-group">
							<input class="form-control" type="text" size="5" readonly="readonly"
								   value="Tipo de Equipamento:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="tipo_equip" id="o_tipo_equip" value="outdoor"
												   {if $obj.tipo_equip =='outdoor'}checked="checked"{else}{/if}
											>
                                            <b>Outdoor &nbsp;</b>
                                            <input type="radio" name="tipo_equip" id="i_tipo_equip" value="indoor"
												   {if $obj.tipo_equip =='indoor'}checked="checked"{else}{/if}
											>
                                            <b>Indoor &nbsp;</b>
                                            <input type="radio" name="tipo_equip" id="m_tipo_equip" value="movel"
												   {if $obj.tipo_equip =='movel'}checked="checked"{else}{/if}
											>
                                            <b>Movel &nbsp;</b>
                                        </span>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="form-group col-md-1">
						<input class="form-control" type="text" readonly="readonly" value="Lat:"/>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control" type="text" maxlength="2" name="lat_g" id="lat_g"
						   	value="{$obj.lat_g}" placeholder="º"/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control" type="text" maxlength="2" name="lat_m" id="lat_m"
						   	value="{$obj.lat_m}" placeholder='"'/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control" type="text" maxlength="2" name="lat_s" id="lat_s"
						   	value="{$obj.lat_s}"	placeholder="'" />
						</div>
					</div>


					<div class="form-group col-md-2">
						<input class=' form-control inputReq' type="text" id="cirUpload"
							   name="cirUpload" value="{$obj.cirUpload}" placeholder="Up CIR"/>
					</div>
					<div class="form-group col-md-2">
						<input class='form-control inputReq' type="text" id="cirDownload"
							   name="cirDownload" value="{$obj.cirDownload}" placeholder="Down CIR"/>
					</div>
					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="end_rede" name="end_rede"
							   value="{$obj.end_rede}"  placeholder="Endereço de Rede"/>
					</div>

				</div>
				<div class="row">
					<div class="form-group col-md-1">
						<input class="form-control" type="text" readonly="readonly" value="Lon:"/>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control" type="text" maxlength="2" name="long_g" id="long_g"
								   value="{$obj.long_g}" placeholder="º"/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control" type="text" maxlength="2" name="long_m" id="long_m"
								   value="{$obj.long_m}" placeholder='"'/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control" type="text" maxlength="2" name="long_s" id="long_s"
								   value="{$obj.long_s}" placeholder="'" />
						</div>
					</div>
					<div class="form-group col-md-2">
						<input class='form-control inputReq' type="text" id="mirUpload"
							   name="mirUpload" value="{$obj.mirUpload}" placeholder="Up MIR"/>
					</div>
					<div class="form-group col-md-2">
						<input class='form-control inputReq' type="text" id="mirDownload"
							   name="mirDownload" value="{$obj.mirDownload}" placeholder="Down MIR "/>
					</div>

					<div class="form-group col-md-4">
						<input class='form-control' type="text" id="end_lan" name="end_lan"
							   value="{$obj.end_lan}" placeholder="Endereço de Lan"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="wan_fw" name="wan_fw"
							   value="{$obj.wan_fw}" placeholder="Endereço de Wan do FW"
						/>

					</div>

					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="ip_lan_fw" name="ip_lan_fw"
							   value="{$obj.ip_lan_fw}" placeholder="Endereço IP Lan FW"
						/>
					</div>
					<div class="form-group col-md-4">
						<input class="form-control" type="text" id="router" name="router"
							   value="{$obj.router}" placeholder="Endereço do Router"
						/>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-success" style="margin-top: -10px;">
			<div class="panel-heading">
				<div class="panel-title text-center">Faturamento</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<select class="form-control" name="empresas_idempresas"
								id="empresas_idempresas" onchange="getCarregaDadosEmrpesaAti()">
							<option value="">Selecione Cliente</option>
							{foreach from=$empresas item=empresa}
								{if $empresa.local == SP}
									<option value="{$empresa.idempresas}"{if $empresa.idempresas == $obj.empreiteira_idempresas}selected{/if}>{$empresa.empresa}</option>
								{/if}
							{/foreach}
						</select>
					</div>

				</div>
				<div class="row">
					<div class="form-group col-md-12">
                                    <textarea class="form-control" style="height: 80px;" type="text"
											  id="observacoes" name="observacoes"
											  placeholder="Observação">{$obj.observacoes}</textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<input class="btn btn-success" type="button" value="Cadastrar OS"
							   onClick="javascript:sendPost('OSSP/editAti','FOSCreateAti')"/>
					</div>
					<div class="form-group col-md-8">
						<div class="alert alert-warning" id="msg_prazo" style="display:none;"></div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

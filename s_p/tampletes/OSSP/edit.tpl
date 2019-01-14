<div class="container1" style="margin-top: -10px;  margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
	</div>
</div>

<br>

<div class="container1" style="width: 60%;">
	<form action="s_p/controller/OSSP/edit" method="POST" id="FOSCreate" class="form" >
		<input type="hidden" name="idos" id="idos" value="{$obj.idos}" />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="pane-title text-center">Editar OS - N° {$obj.numOS}</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 paddingForm">
						<select class="form-control" name="empreiteira_idempresas" id="empreiteira_idempresas" >
							<option value="">Selecione Empreiteira</option>
							{foreach from=$empresas item=empresa}
								{if $empresa.tipo == EMP}
									<option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empreiteira_idempresas}selected{/if}>{$empresa.empresa}</option>
								{/if}
							{/foreach}
						</select>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" name="numOS" id="numOS" value="{$obj.numOS}" placeholder="Numero da Os"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" name="identificador" id="identificador" value="{$obj.identificador}" placeholder="Identificador" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" name="contato" id="contato" value="{$obj.contato}" placeholder="Nome"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="telContato" name="telContato" placeholder="Celular" value="{$obj.telContato}"
							   onkeypress="Mask(this, celular)"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class="form-control autosave_ossp" type="text" id="outroTelContato" name="outroTelContato" placeholder="Telefone" value="{$obj.outroTelContato}"
							   onkeypress="Mask(this, telefone)"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" id="cep" name="cep" alt="cep" value="{$obj.cep}" placeholder="CEP"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" name="pais" id="pais" value="{$obj.pais}" placeholder="Pais"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" name="estado" id="estado" value="{$obj.estado}" placeholder="Estado" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" name="cidade" id="cidade" value="{$obj.cidade}" placeholder="Cidade"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control inputReq autosave_ossp' type="text" id="enderecoInstal" name="enderecoInstal" value="{$obj.estado}" placeholder="Endereço"/>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-primary" style="margin-top: -10px;">
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input  class='form-control autosave_ossp' type="text" id="mirDownload" name="mirDownload" value="{$obj.mirDownload}" placeholder="MIR Download" />
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="cirDownload" name="cirDownload" value="{$obj.cirDownload}" placeholder="CIR Download"/>
						</div>
					</div>
					<div class="form-group col-md-3">
						<div class="">
							<input class="form-control autosave_ossp" type="text"  id="iplan1" name="iplan1" value="{$obj.iplan1}" placeholder="IP Lan 1"/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control autosave_ossp" type="text"  id="iplanMask1" name="iplanMask1" value="{$obj.iplanMask1}"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input  class='form-control autosave_ossp' type="text" id="mirUpload" name="mirUpload" value="{$obj.mirUpload}" placeholder="MIR Upload"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class=' form-control autosave_ossp' type="text" id="cirUpload" name="cirUpload" value="{$obj.cirUpload}" placeholder="CIR Upload"/>
						</div>
					</div>
					<div class="form-group col-md-3">
						<div class="">
							<input  class='form-control autosave_ossp' type="text"  id="iplan2" name="iplan2" value="{$obj.iplan2}" placeholder="IP Lan 2"/>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="">
							<input class="form-control autosave_ossp" type="text"  id="iplanMask2" name="iplanMask2" value="{$obj.iplanMask2}"/>
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
							<select class="form-control autosave_ossp" name="empresas_idempresas" id="empresas_idempresas" onchange="getCarregaDadosEmrpesa()">
								<option value="">Selecione Cliente</option>
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
							<input  class='form-control autosave_ossp' type="text" name="cnpjFaturamento" id="cnpjFaturamento" value="{$obj.cnpjFaturamento}" placeholder="CNPJ"
								onkeypress="Mask(this, cnpj)"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="cepFaturamento" name="cepFaturamento" value="{$obj.cepFaturamento}" placeholder="CEP"	/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" name="paisFaturamento" id="paisFaturamento" value="{$obj.paisFaturamento}" placeholder="País"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="enderecoFaturamento" name="enderecoFaturamento" value="{$obj.enderecoFaturamento}" placeholder="Endereço"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" name="cidadeFaturamento" id="cidadeFaturamento" value="{$obj.cidadeFaturamento}" placeholder="Cidade"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" id="emailFaturamento" name="emailFaturamento" value="{$obj.emailFaturamento}" placeholder="Email" />
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="">
							<input class='form-control autosave_ossp' type="text" name="estadoFaturamento" id="estadoFaturamento" value="{$obj.estadoFaturamento}"  placeholder="Estado"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="input-group">
							<input class='form-control' type="text" id="dataSolicitacao" name="dataSolicitacao" value="{$obj.dataSolicitacao}" placeholder="Data Solicitação" />
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<div class="">
							<input class="form-control" type="text" id="prazoInstal" name="prazoInstal" value="{$obj.prazoInstal}" onfocus="getPrazoInstal()" placeholder="Prazo de Instalação"/>
						</div>
					</div>
					<div class="form-group col-md-8">
						<div class="">
							<div class="alert alert-warning" id="msg_prazo" style="display:none;"></div>
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
					<div class="form-group col-md-12 text-center">
						<input type="button" class="btn btn-primary" value="Salvar" onClick="javascript:sendPost('OSSP/edit','FOSCreate')" />
					</div>
				</div>
			</div>
		</div>

	</form>
</div>















{*<center>*}
{*<form action="s_p/controller/OSSP/edit" method="POST" id="FOSCreate" class="form" >*}

    {*<input type="hidden" name="idos" id="idos" value="{$obj.idos}" />*}
    {**}
    {**}
 	{*<div class="layoutCadOs">*}
		{*<b>Editar OS - N° {$obj.numOS}</b>*}
		{**}
		{*<table class="layoutTableOs">*}
			{*<tr>*}
                {*<td>Empreiteira</td><td align="center">*}
                    {*<select style="margin-top: 5px;" name="empreiteira_idempresas" id="empreiteira_idempresas" >*}
                        {*<option value="">Selecione</option>*}
                        {*{foreach from=$empresas item=empresa}*}
                            {*{if $empresa.tipo == EMP}*}
                                {*<option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empreiteira_idempresas}selected{/if}>{$empresa.empresa}</option>*}
                            {*{/if}*}
                        {*{/foreach}*}
                    {*</select>*}
                {*</td>*}
				{*<td align="center">Número da OS</td><td align="center"><input type="text" name="numOS" id="numOS" size="30" value="{$obj.numOS}" class='inputReq autosave_ossp'/></td>*}
				{*<td>Identificador</td><td align="center"><input type="text" name="identificador" id="identificador" value="{$obj.identificador}" size="30" class='inputReq autosave_ossp' /></td>*}
			{*</tr>*}
		{*</table>*}
		{**}
		{*<div class="separador">.</div>*}
		{**}
		{*<table border="0"  class="layoutTableOs" style="margin-top: 10px">*}
			{*<tr>*}
				{*<td align="center">CNPJ</td><td align="center"><input type="text" name="cnpj" id="cnpj" value="{$obj.cnpj}" class='inputReq autosave_ossp' /></td>*}
			{*</tr>*}
			{*<tr>*}
				{*<td>Nome</td><td align="center">*}
					{*<input type="text" name="contato" id="contato" value="{$obj.contato}" size="30" class='inputReq autosave_ossp'/></td>*}
				{*<td>Contato 1º</td><td align="center">*}
					{*<input type="text" id="telContato" name="telContato" size="15" value="{$obj.telContato}" class='inputReq autosave_ossp' /></td>*}
				{*<td>Contato 2º</td><td align="center">*}
					{*<input class="autosave_ossp" type="text" id="outroTelContato" name="outroTelContato" size="15" value="{$obj.outroTelContato}"  /></td>*}
			{*</tr>*}
			{*<tr>*}
				{*<td>E-mail</td><td align="center"><input type="text" id="email" name="email" value="{$obj.email}" size="30" class='inputReq autosave_ossp' /></td>*}
				{*<td>End do acesso</td><td align="center"><input type="text" id="enderecoInstal" name="enderecoInstal" value="{$obj.enderecoInstal}" size="60" class='inputReq autosave_ossp'/></td>*}
                {*<td>País</td>*}
                {*<td align="center">*}
                    {*<input type="text" name="pais" id="pais" value="{$obj.pais}" class='inputReq autosave_ossp' />*}
				{*</td>*}
                {*</td>*}
                {*<td>Estado</td>*}
                {*<td align="center">*}
                    {*<input type="text" name="estado" id="estado" value="{$obj.estado}" class='inputReq autosave_ossp' /></td>*}
                {*<select name="municipios_sp_idcidade" id="municipios_sp_idcidade" class="selectReq">*}
                {*{foreach from=$arrMun item=i}*}
                {*<option value={$i.idmunicipios_sp}>{$i.municipio|utf8_encode}</option>*}
                {*{/foreach}    *}
                {*</select>*}

                {*</td>*}


			{*</tr>*}
			{*<tr>*}
                {*<td>Cidade</td>*}
                {*<td align="center">*}
                    {*<input type="text" name="cidade" id="cidade" value="{$obj.cidade}" class='inputReq autosave_ossp' /></td>*}
                {*<select name="municipios_sp_idcidade" id="municipios_sp_idcidade" class="selectReq">*}
                {*{foreach from=$arrMun item=i}*}
                {*<option value={$i.idmunicipios_sp}>{$i.municipio|utf8_encode}</option>*}
                {*{/foreach}    *}
                {*</select>*}

                {*</td>*}
				{*<td>CEP</td><td align="center">*}
					{*<input type="text" id="cep" name="cep" value="{$obj.cep}" alt="cep" class='inputReq autosave_ossp' /></td>*}
				{*<td>Área Instalação</td><td align="center"><input type="text" id="areaInstal" name="areaInstal" value="{$obj.areaInstal}" size="30" class='inputReq autosave_ossp' /></td>*}
				{*<td>Lote</td><td align="center"><input type="text" id="lote" name="lote" value="{$obj.lote}" size="30" class='inputReq autosave_ossp' /></td>*}
			{*</tr>*}
			{*<tr>*}
				{*<td>Perfil</td><td align="center"><input type="text" id="perfil" name="perfil" value="{$obj.perfil}" class='inputReq autosave_ossp' /></td>*}
				{*<td></td><td></td>*}
				{*<td></td><td></td>*}
			{*</tr>*}
			{**}
		{*</table>*}
	{*</div>   *}

	{**}

	{*<div style="width: 980px; height: 145px; margin-top: 10px; padding-top: 8px; background-color: #E9E9E9; border: 1px solid #AAAAAA;">*}
	{**}
		{*<table class="layoutTableOs">*}
			{*<tr>*}
				{*<td>MIR. Download</td><td align="center">*}
					{*<input type="text" id="mirDownload" name="mirDownload" class='inputReq autosave_ossp' value="{$obj.mirDownload}" /></td>*}
				{*<td>MIR. Upload</td><td align="center"><input type="text" id="mirUpload" name="mirUpload" class='inputReq autosave_ossp' value="{$obj.mirUpload}" readonly="readonly" /></td>*}
				{*<td>CIR. Upload</td><td align="center">*}
					{*<input type="text" id="cirUpload" name="cirUpload" class='inputReq autosave_ossp' value="{$obj.cirUpload}" /></td>*}
			{*</tr>*}
			{*<tr>*}
				{*<td>CIR. Download</td><td align="center">*}
					{*<input type="text" id="cirDownload" name="cirDownload" value="{$obj.cirDownload}" class='inputReq autosave_ossp' /></td>*}
				{*<td>Vel. Upload</td><td align="center"><input type="text" id="velUpload" name="velUpload" value="{$obj.velUpload}" class='inputReq autosave_ossp' /></td>*}
				{*<td>Ip Publico </td><td align="center"> <input type="text" id="iplan" name="iplan" value="{$obj.iplan}" class='autosave_ossp' /></td>*}
				{*<td>Padrão</td><td align="center"><input type="text" id="padrao" name="padrao" class='inputReq autosave_ossp' value="Sem redundância" /></td>*}
			{*</tr>*}
			{*<tr>*}
				{*<td>Máscara LAN</td><td align="center"><input type="text" id="mascaraLan" name="mascaraLan" value="{$obj.mascaraLan}" class='autosave_ossp' /></td>*}
				{*<td>Serviço</td><td align="center"> <input type="text" id="servico" name="servico" class='inputReq autosave_ossp' value="Satélite" /></td>*}
			{*</tr>		*}
		{*</table>*}
	{**}
	{*</div>*}
	{**}
 {**}
	{*<div class="layoutCadOsFaturamento" style="margin-top: 10px;">*}
		{*<b>Faturamento</b>*}
		{*<table border="0" class="layoutTableOs" style="margin-top: 30px;">*}
            {*<tr>*}
                {*<td>Empresa</td><td align="center">*}
                    {*<select class="autosave_ossp" name="empresas_idempresas" id="empresas_idempresas">*}
                        {*<option value="">Selecione uma empresa</option>*}
                        {*{foreach from=$empresas item=empresa}*}
                            {*{if $empresa.local == SP}*}
                                {*<option value="{$empresa.idempresas}" {if $empresa.idempresas == $obj.empresas_idempresas}selected{/if}>{$empresa.empresa}</option>*}
                            {*{/if}*}
                        {*{/foreach}*}
                    {*</select>*}
                {*</td>*}
                {*<td>CNPJ</td><td align="center"><input type="text" name="cnpjFaturmanto" id="cnpj" value="{$obj.cnpjFaturamento}" class='inputReq autosave_ossp' /></td>*}
                {*<td>Endereço </td><td align="center"><input type="text" id="enderecoFaturamento" name="enderecoFaturamento" value="{$obj.enderecoFaturamento}" size="60" class='inputReq autosave_ossp'/></td>*}
            {*</tr>*}
            {*<tr>*}
                {*<td>País</td>*}
                {*<td align="center">*}
                    {*<input type="text" name="paisFaturamento" id="paisFaturamento" value="{$obj.paisFaturamento}" class='inputReq autosave_ossp' /></td>*}
                {*<select name="municipios_sp_idcidade" id="municipios_sp_idcidade" class="selectReq">*}
                {*{foreach from=$arrMun item=i}*}
                {*<option value={$i.idmunicipios_sp}>{$i.municipio|utf8_encode}</option>*}
                {*{/foreach}    *}
                {*</select>*}

                {*</td>*}
                {*<td>Estados</td>*}
                {*<td align="center"><input type="text" name="estadoFaturmanto" id="estadoFaturmanto" value="{$obj.estadoFaturamento}" class='inputReq autosave_ossp' /></td>*}
                {*<select name="estados" id="estados" onchange="chamaCidade();">*}
                {*<option>Escolha Estado</option>*}
                {*{foreach from=$arrEstado item=est}*}
                {*<option value={$est.idestados} {if $est. == 'SAO PAULO'} selected{/if}>{$i.municipio|utf8_encode}</option>*}
                {*<option value={$est.idestados}>{$est.sigla} - {$est.nome|utf8_encode}</option>*}
                {*{/foreach}*}
                {*</select>*}
                {*</td>*}
                {*<td>Cidade</td>*}
                {*<td align="center"><input type="text" name="cidadeFaturmanto" id="cidadeFaturmanto" value="{$obj.cidadeFaturamento}" class='inputReq autosave_ossp' /></td>*}
                {*<div id="listaCidade">*}
                {*<select name="municipios_sp_idcidadeFaturamento" id="municipios_sp_idcidadeFaturamento" class="selectReq">*}
                {*<option>Escolha Cidade</option>*}
                {*</div>*}
                {*{foreach from=$arrMun item=i}*}
                {*<option value={$i.idmunicipios_sp} {if $i.municipio == 'SAO PAULO'} selected{/if}>{$i.municipio|utf8_encode}</option>*}
                {*{/foreach}    *}
                {*</select>*}
                {*</td>*}
			{*</tr>*}
			{*<tr>*}
				{*<td>CEP</td>*}
                    {*<td align="center"><input type="text" id="cepFaturamento" name="cepFaturamento" value="{$obj.cepFaturamento}" size="30" class='inputReq autosave_ossp' alt="cep"/>*}
                {*</td>*}
				{*<td>E-mail </td><td align="center"><input type="text" id="emailFaturamento" name="emailFaturamento" size="30" class='inputReq autosave_ossp' value="{$obj.emailFaturamento}" /></td>*}
				{*<td>Data Solicitação</td><td align="center"><input type="text" id="dataSolicitacao" name="dataSolicitacao" value="{$obj.dataSolicitacao}" size="10" class='inputReq autosave_ossp'  /></td>*}
			{*</tr>*}

			{*<tr>*}
				{*<td>Prazo Instalação</td><td align="center">*}
					{*<input type="text" id="prazoInstal" name="prazoInstal" value="{$obj.prazoInstal}" size="10" class="inputImportant autosave_ossp" onfocus="getPrazoInstal()"/>*}
	                {*<div id="msg_prazo" style="color:red"></div>*}
                {*</td>*}

			{*</tr>*}
            {*<tr>*}
				{*<td>Obs</td><td colspan="5"><textarea class="estilotextarea" type="text" id="observacoes" name="observacoes" cols="30" rows="5">{$obj.observacoes}</textarea></td>*}

            {*</tr>*}
		{*</table>*}
		{*<div style="margin-top: 280px"> * Campos marcados em vermelho são obrigatórios.</div>*}
	{**}
	{*</div>*}
	{*<br>*}
    {*<center><input type="button" value="Salvar" onClick="javascript:sendPost('OSSP/edit','FOSCreate')" /></center>*}
{*</form>*}
{*</center>*}
{*<br><br><br>*}


 {*<center><input type="button" value="Salvar" onClick="javascript:sendPost('OSSP/edit','FOSCreate')" /></center>*}





<div class="container1" style="margin-top: 0px;>
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>

<br>


<div class="container1" style="width: 55%;">
	<form id="form_pre_incidente_edicao">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">Edição de Pré-Incidente Nagios - {$incidente.id_pre_incidentes_nagios}</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-6">
					<label for="id_pre_incidentes_nagios">Id Nagios</label>
					<input class="form-control" type="text" name="id_pre_incidentes_nagios" id="id_pre_incidentes_nagios" value="{$incidente.id_pre_incidentes_nagios}" readonly="readonly" />
				</div>
				<div class="form-group col-md-6">
					<label for="vsat">Vsat</label>
					<input class="form-control" type="text" name="vsat" id="vsat" value="{$incidente.vsat}" placeholder="Vsat"/>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="responsavel">Responsavel</label>
					<select class="form-control" name="responsavel" id="responsavel">
						<option></option>
						{foreach from=$listaUsuarios item=usuario}
							<option {if $usuario.idusuarios eq $incidente.responsavel}selected{/if} value="{$usuario.idusuarios}">{$usuario.nome}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="data_evento">Data Evento</label>
					<input class="form-control" readonly="readonly" id="data_evento" name="data_evento" value="{$incidente.data_evento}" type="text"/>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label for="informacoes">Informaçoes</label>
					<textarea class="form-control" id="informacoes" name="informacoes" style="height:150px;">{$incidente.informacoes}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 text-center">
					<a class="btn btn-primary"
					   onclick="javascript:
							   $.ajax({ldelim}
							   url:'PreIncidentesNagios/update',
							   type:'POST',
							   data:{ldelim}form:$('#form_pre_incidente_edicao').serialize(){rdelim},
							   success:function( resposta ){ldelim}
							   $('#respostaAjax').html( resposta );
							   setTimeout(function(){ldelim}
							   $('#respostaAjax span').fadeOut();
					   {rdelim},5000);
					   {rdelim}
					   {rdelim});
							   ">
						Salvar
					</a>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 text-center">
					<div id="respostaAjax"></div>
				</div>
			</div>
		</div>
	</div>
		</form>
</div>

{*<center>*}

{*<div style="padding:20px;">*}
{*<form id="form_pre_incidente_edicao">*}
	{*<fieldset>*}
	{*<legend>*}
		{*<h2>*}
			{*Edição de Pré-Incidente Nagios - {$incidente.id_pre_incidentes_nagios}*}
		{*</h2>*}
	{*</legend>*}
	{*<table class="table">*}
		{*<tr>*}
			{*<td style="width:150px;" class="label_right"><h4>Id Nagios</h4></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;"><input type="text" name="id_pre_incidentes_nagios" id="id_pre_incidentes_nagios" value="{$incidente.id_pre_incidentes_nagios}" readonly="readonly" /></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td class="label_right"><h4>Vsat</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td><input type="text" name="vsat" id="vsat" value="{$incidente.vsat}" /></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Responsável</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>*}
			{**}
				{*<select name="responsavel" id="responsavel">*}
					{*<option></option>*}
					{*{foreach from=$listaUsuarios item=usuario}*}
						{*<option {if $usuario.idusuarios eq $incidente.responsavel}selected{/if} value="{$usuario.idusuarios}">{$usuario.nome}</option>*}
					{*{/foreach}*}
				{*</select>				*}
				{**}
			{*</td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>Data do Email</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td><input readonly="readonly" id="data_evento" name="data_evento" value="{$incidente.data_evento}" type="text"/></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Informações</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td colspan="5"><textarea id="informacoes" name="informacoes" style="width:100%;height:150px;">{$incidente.informacoes}</textarea></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td colspan="7" style="text-align:center;">*}
				{*<a class="btn"*}
					{*onclick="javascript:*}
						{*$.ajax({ldelim}*}
							{*url:'PreIncidentesNagios/update',*}
							{*type:'POST',*}
							{*data:{ldelim}form:$('#form_pre_incidente_edicao').serialize(){rdelim},*}
							{*success:function( resposta ){ldelim}*}
								{*$('#respostaAjax').html( resposta );*}
								{*setTimeout(function(){ldelim}*}
									{*$('#respostaAjax span').fadeOut();*}
								{*{rdelim},5000);*}
							{*{rdelim}*}
						{*{rdelim});*}
					{*">*}
					{*Salvar*}
				{*</a>*}
			{*</td>*}
		{*</tr>*}
		{*<tr>*}
			{*<td colspan="7" style="text-align:center;">*}
				{*<div id="respostaAjax"></div>*}
			{*</td>*}
		{*</tr>*}
	{*</table>*}
{*</fieldset>*}

{*</form>*}
{*</div>*}

{*</center>*}
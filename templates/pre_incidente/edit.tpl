
<div class="container1" style="margin-top: 0px;>
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>
<br>



<div class="container1" style="width: 70%;">
	<form id="form_pre_incidente_edicao">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title text-center">Edição de Pré-Incidente - {$incidente.id_pre_incidentes}</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-6">
					<input class="form-control" type="text" name="id_prodemge" id="id_prodemge" value="{$incidente.id_prodemge}" placeholder="Prodemge"/>
				</div>
				<div class="form-group col-md-6">
					<input class="form-control" type="text" name="id_cliente" id="id_cliente" value="{$incidente.id_cliente}" placeholder="ID Cliente"/>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<input class="form-control" type="text" name="prazo_limite" id="prazo_limite" value="{$incidente.prazo_limite}" placeholder="Prazo Limite"/>
				</div>
				<div class="form-group col-md-6">
					<input class="form-control" type="text" name="designacao" id="designacao" value="{$incidente.designacao}" placeholder="Designação"/>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<select class="form-control" name="responsavel" id="responsavel">
						<option value="">Selecione Responsavel</option>
						{foreach from=$listaUsuarios item=usuario}
							<option {if $usuario.idusuarios eq $incidente.responsavel}selected{/if} value="{$usuario.idusuarios}">{$usuario.nome}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group col-md-6">
					<input class="form-control" readonly="readonly" id="data_email" name="data_email" value="{$incidente.data_email}" type="text"/>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<input class="form-control" id="identificador" name="identificador" value="{$incidente.identificador}" type="text" placeholder="Identificador"/>
				</div>

			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<textarea class="form-control" id="solicitacao" name="solicitacao" style="height: 200px" >{$incidente.solicitacao}</textarea>
				</div>

			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<textarea class="form-control" id="discussao" name="discussao" style="height: 200px">{$incidente.discussao}</textarea>
				</div>

			</div>
			<div class="row">
				<div class="form-group col-md-12 text-center">
					<input name="id_pre_incidentes" id="id_pre_incidentes" value="{$incidente.id_pre_incidentes}" type="hidden"/>
					<a class="btn btn-primary"
					   onclick="javascript:
							   //sendPost('PreIncidentes/update','form_pre_incidente_edicao');
							   $.ajax({ldelim}
							   url:'PreIncidentes/update',
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
			{*Edição de Pré-Incidente - {$incidente.id_pre_incidentes}*}
		{*</h2>*}
	{*</legend>*}
	{*<table class="table">*}
		{*<tr>*}
			{*<td style="width:150px;" class="label_right"><h4>Id Prodemge</h4></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;"><input type="text" name="id_prodemge" id="id_prodemge" value="{$incidente.id_prodemge}" /></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;" class="label_right"><h4>Id Cliente</h4></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;"><input type="text" name="id_cliente" id="id_cliente" value="{$incidente.id_cliente}" /></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Prazo Limite</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td><input type="text" name="prazo_limite" id="prazo_limite" value="{$incidente.prazo_limite}" /></td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>Designação</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td><input type="text" name="designacao" id="designacao" value="{$incidente.designacao}" /></td>*}
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
			{*<td><input readonly="readonly" id="data_email" name="data_email" value="{$incidente.data_email}" type="text"/></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Identificador</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td><input id="identificador" name="identificador" value="{$incidente.identificador}" type="text"/></td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>&nbsp;</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>&nbsp;</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Solicitação</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td colspan="5"><textarea id="solicitacao" name="solicitacao" style="width:100%;height:150px;">{$incidente.solicitacao}</textarea></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Discussão</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td colspan="5"><textarea id="discussao" name="discussao" style="width:100%;height:150px;">{$incidente.discussao}</textarea></td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td colspan="7" style="text-align:center;">*}
				{*<input name="id_pre_incidentes" id="id_pre_incidentes" value="{$incidente.id_pre_incidentes}" type="hidden"/>*}
				{*<a class="btn"*}
					{*onclick="javascript:*}
						{*//sendPost('PreIncidentes/update','form_pre_incidente_edicao');*}
						{*$.ajax({ldelim}*}
							{*url:'PreIncidentes/update',*}
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
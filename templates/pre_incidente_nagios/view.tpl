<div class="container1" style="margin-top: 0px;>
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>

<br>


<div class="container1" style="width: 60%;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Visualização de Pré-Incidente Nagios - {$incidente.id_pre_incidentes_nagios}
			</div>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<td style="width:150px;" class="label_right"><h4>Id Nagios</h4></td>
					<td style="width:15px;">&nbsp;</td>
					<td style="width:150px;">{$incidente.id_pre_incidentes_nagios}</td>
					<td style="width:15px;">&nbsp;</td>
					<td class="label_right"><h4>Designação</h4></td>
					<td>&nbsp;</td>
					<td>{$incidente.vsat}</td>
				</tr>

				<tr>
					<td class="label_right"><h4>Data:</h4></td>
					<td>&nbsp;</td>
					<td>{$incidente.data_evento}</td>
					<td>&nbsp;</td>
					<td class="label_right"><h4>endereço IP</h4></td>
					<td>&nbsp;</td>
					<td>{$incidente.endereco}</td>
				</tr>

				<tr>
					<td class="label_right"><h4>Informações</h4></td>
					<td>&nbsp;</td>
					<td colspan="5">{$incidente.informacoes}</td>
				</tr>

				<tr>
					<td colspan="7" style="text-align:center;">
						{$btn_edit}
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

{*<center>*}

{*<div style="padding:20px;">*}

{*<fieldset>*}
	{*<legend>*}
		{*<h2>*}
			{*Visualização de Pré-Incidente Nagios - {$incidente.id_pre_incidentes_nagios}*}
			{*&nbsp;&nbsp;{$btn_edit}*}
		{*</h2>*}
	{*</legend>*}
	{*<table class="table">*}
		{*<tr>*}
			{*<td style="width:150px;" class="label_right"><h4>Id Nagios</h4></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;">{$incidente.id_pre_incidentes_nagios}</td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td class="label_right"><h4>Designação</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.vsat}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Data:</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.data_evento}</td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>endereço IP</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.endereco}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Informações</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td colspan="5">{$incidente.informacoes}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td colspan="7" style="text-align:center;">*}
				{*{$btn_edit}*}
			{*</td>*}
		{*</tr>*}
	{*</table>*}
{*</fieldset>*}

{*</div>*}

{*</center>*}
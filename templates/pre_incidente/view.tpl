<div class="container1" style="margin-top: 0px;>
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>
<br>

<div class="container1">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">
				<h2>
					Visualização de Pré-Incidente - {$incidente.id_pre_incidentes}
					&nbsp;&nbsp;{$btn_edit}
				</h2>
			</div>
		</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tr>
						<td style="width:150px;" class="label_right"><h4>Id Prodemge</h4></td>
						<td style="width:15px;">&nbsp;</td>
						<td style="width:150px;">{$incidente.id_prodemge}</td>
						<td style="width:15px;">&nbsp;</td>
						<td style="width:150px;" class="label_right"><h4>Id Cliente</h4></td>
						<td style="width:15px;">&nbsp;</td>
						<td style="width:150px;">{$incidente.id_cliente}</td>
					</tr>

					<tr>
						<td class="label_right"><h4>Prazo Limite</h4></td>
						<td>&nbsp;</td>
						<td>{$incidente.prazo_limite}</td>
						<td>&nbsp;</td>
						<td class="label_right"><h4>Designação</h4></td>
						<td>&nbsp;</td>
						<td>{$incidente.designacao}</td>
					</tr>

					<tr>
						<td class="label_right"><h4>Responsável</h4></td>
						<td>&nbsp;</td>
						<td>{$incidente.nome_responsavel}</td>
						<td>&nbsp;</td>
						<td class="label_right"><h4>Data do Email</h4></td>
						<td>&nbsp;</td>
						<td>{$incidente.data_email}</td>
					</tr>

					<tr>
						<td class="label_right"><h4>Identificador:</h4></td>
						<td>&nbsp;</td>
						<td>{$incidente.identificador}</td>
						<td>&nbsp;</td>
						<td class="label_right"><h4>&nbsp;</h4></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

					<tr>
						<td class="label_right"><h4>Solicitação</h4></td>
						<td>&nbsp;</td>
						<td colspan="5">{$incidente.solicitacao}</td>
					</tr>

					<tr>
						<td class="label_right"><h4>Discussão</h4></td>
						<td>&nbsp;</td>
						<td colspan="5">{$incidente.discussao}</td>
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
			{*Visualização de Pré-Incidente - {$incidente.id_pre_incidentes}*}
			{*&nbsp;&nbsp;{$btn_edit}*}
		{*</h2>*}
	{*</legend>*}
	{*<table class="table">*}
		{*<tr>*}
			{*<td style="width:150px;" class="label_right"><h4>Id Prodemge</h4></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;">{$incidente.id_prodemge}</td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;" class="label_right"><h4>Id Cliente</h4></td>*}
				{*<td style="width:15px;">&nbsp;</td>*}
			{*<td style="width:150px;">{$incidente.id_cliente}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Prazo Limite</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.prazo_limite}</td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>Designação</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.designacao}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Responsável</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.nome_responsavel}</td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>Data do Email</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.data_email}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Identificador:</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>{$incidente.identificador}</td>*}
				{*<td>&nbsp;</td>*}
			{*<td class="label_right"><h4>&nbsp;</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td>&nbsp;</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Solicitação</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td colspan="5">{$incidente.solicitacao}</td>*}
		{*</tr>*}
		{**}
		{*<tr>*}
			{*<td class="label_right"><h4>Discussão</h4></td>*}
				{*<td>&nbsp;</td>*}
			{*<td colspan="5">{$incidente.discussao}</td>*}
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
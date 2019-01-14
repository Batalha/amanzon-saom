<div class="container1" style="margin-top: -10px; width:49%; margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
	</div>
</div>
<br>

<div class="container1" style="width:65%;">
	<form action="Instalacao_sp/edit" method="PobjT" id="FobjCreate" class="form" >
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				<table class="tableDados">
					<tr>
						<td><label><b><font color="#ffffff" size="2.9">&nbsp; {$obj.nome} - Dados da Instalação</B></font></b></label></td>
						<td align="right"><label><b><font color="#ffffff">Cod. Anatel :&nbsp;{$obj.cod_anatel}&nbsp; &nbsp; </font></b></label></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-12">
					<h3>OS - {$obj.rel.os_sp.numOS}</h3>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<table class="table table-bordered" >
						<tr><td colspan="2" bgcolor="#87ceeb"><b>Dados da Antena</b></td></tr>
						<tr><td width="40%" style="font-weight: bold;">Antena :</td><td>&nbsp;{$obj.antena}</td></tr>
						<tr><td style="font-weight: bold;">Marca :</td><td>&nbsp;{$obj.antena}</td></tr>
						<tr><td style="font-weight: bold;">MAC :</td><td>&nbsp;{$obj.mac}</td></tr>
						<tr><td style="font-weight: bold;">Nº de Serie :</td><td>&nbsp;{$obj.antena_ns}</td></tr>
						<tr><td style="font-weight: bold;">Azimute :</td><td>&nbsp;{$obj.azimute_comiss}</td></tr>
						<tr><td style="font-weight: bold;">Elevação :</td><td>&nbsp; {$obj.elevacao_comiss}</td></tr>
					</table>
				</div>
				<div class="form-group col-md-6">
					<table class="table table-bordered" >
						<tr><td colspan="2" bgcolor="#87ceeb"><b>Dados da ODU</b></td></tr>
						<tr><td width="40%" style="font-weight: bold;">ODU :</td>
							<td>&nbsp;
								{foreach from=$tipoEquipamentos item=tipoEquipamento}
									{if $obj.odu == $tipoEquipamento.idtipo_equipamentos}
										{$tipoEquipamento.nome}
									{/if}
								{/foreach}
							</td></tr>
						<tr><td style="font-weight: bold;">Nº de Serie :</td><td>&nbsp;{$obj.nsodu_comiss}</td></tr>
						<tr><td style="font-weight: bold;">BUC :</td><td>&nbsp;{$obj.buc}</td></tr>
						<tr><td style="font-weight: bold;">LNB :</td><td>&nbsp;{$obj.lnb}</td></tr>
						<tr><td style="font-weight: bold;">Tipo de IDU :</td><td>&nbsp;{$obj.tipo_IDU}</td></tr>
						<tr><td style="font-weight: bold;">Valor SNR :</td><td>&nbsp;{$obj.snr_comiss}</td></tr>
					</table>
				</div>

			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<table class="table table-bordered">
						<tr><td bgcolor="#87ceeb"><b>Observação</b></td></tr>
						<tr align="left">
							<td>&nbsp;{$obj.obs}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			{if $obj.rel.os_sp.os_status_idos_status != 2}
				{if $login.perfis_idperfis != 3}
					{if $obj.comiss != 1}
						<input class="btn btn-primary" type="button" value="Comissionar" onClick="javascript:getAjaxForm('Instalacao_sp/comiss', 'dadosInstal',{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim},getDadosComissSp,'{$obj.os_sp_idos}' )" />
						<input class="btn btn-primary" type="button" value="Editar Instalação" onClick="javascript:getAjaxForm('Instalacao_sp/edit',false,{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})" />
					{else}
						<input class="btn btn-primary" type="button" value="Ver Comissionamento" onClick="javascript:getAjaxForm('Comissionamento_sp/comiss_view', 'dadosInstal',{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim} )" />
						<input class="btn btn-primary" type="button" value="Editar Instalação" onClick="javascript:getAjaxForm('Instalacao_sp/edit','dadosInstal',{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim})" />

						{if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4}
							<input class="btn btn-primary" type="button" value="Registrar Incidente" onClick="javascript:getAjaxForm('Incidente_sp/create','dadosInstal',{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim})" />
						{/if}

						<input class="btn btn-primary" type="button" value="Realocação" onClick="javascript:getAjaxForm('Realocacao/create','dadosInstal',{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim})" />
						<input class="btn btn-primary" type="button" value="Cancelamento" onClick="javascript:getAjaxForm('Cancelamento/create','dadosInstal',{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim})" />
					{/if}
					<input type="button" class="btn btn-primary" value="Termo Instalação" onClick="window.open('Instalacao_sp/termo/{$obj.idinstalacoes_sp}')" /><!-- javascript:getAjaxForm('Instalacao_sp/termo',false,{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim})*/?> -->
				{/if}
			{else}
				<input style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);text-align:center;" type="text" value="Instalação de uma OS Cancelada"/>
			{/if}
		</div>
	</div>
	</form>
</div>

<div id="dadosInstal"></div>
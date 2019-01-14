<div class="container1" style="width:55%;">
	<form action="AgendaInstal_sp/create" method="POST" id="fAgConfirm" class="form" >

		<input type="hidden" name="nomeForm" id="nomeForm" value="fAgConfirm" />
		<input type="hidden" name="osidos" id="osidos" value="{$obj.rel.os.idos}" />
		<input type='hidden' name='idagenda_instal' id='idagenda_instal' value='{$obj.idagenda_instal}' />
		<input type='hidden' name='confirm' id='confirm' value='1'/>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title text-center">Agendamento</div>
			</div>
			<div class="panel-body" style="padding: 0px;" >
				<div class="row">
					<div class="form-group col-md-12">
						<table class="table table-bordered">
							<tr>
								<td width="35%"><b>Agendamento realizado em :</b></td><td>{$obj.data_temp}</td>
							</tr>
							<tr>
								<td><b>Data agendada da Instalação :</b></td><td>{if $obj.data=='NULL' || $obj.data=='' || $obj.data=='00/00/0000'}(sem data){else}{$obj.data}{/if}</td>
							</tr>
							<tr>
								<td><b>Usuario que confirmou :</b></td><td>{$obj.rel.usuario_confirm.nome}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">

						<table class="table table-bordered">
							<thead>
							<th colspan="2" class="text-center" bgcolor="#87ceeb"><b>Dados de Contato 1</b></th>
							</thead>
							<tbody>
							<tr>
								<td><b>Nome :</b></td><td>{$obj.contato}</td>
							</tr>
							<tr>
								<td><b>Telefone  :</b></td><td>{$obj.tel}</td>
							</tr>
							<tr>
								<td><b>Celular :</b></td><td>{$obj.cel}</td>
							</tr>
							</tbody>
						</table>
					</div>
					<div class="form-group col-md-6">
						<table class="table table-bordered">
							<thead>
							<th colspan="2"  class="text-center" bgcolor="#87ceeb"><b>Dados de Contato 2</b></th>
							</thead>
							<tbody>
							<tr>
								<td><b>Nome :</b></td><td>{$obj.contato_2}</td>
							</tr>
							<tr>
								<td><b>Telefone :</b></td><td>{$obj.tel_2}</td>
							</tr>
							<tr>
								<td><b>Celular :</b></td><td>{$obj.cel_2}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<table border="1" class="table table-bordered">
							<thead>
								<th colspan="6"class="text-center" bgcolor="#87ceeb"><b>Dados Instalaçãp</b></th>
							</thead>
							<tbody>
							<tr>
								<td width="25%"><b>N° Série Modem :</b></td><td width="25%">&nbsp;{$obj.nsmodem}</td>
								<td><b>Antena :</b></td><td>&nbsp;{$obj.antena}</td>
							</tr>
							<tr>
								<td><b>MAC :</b></td><td>&nbsp;{$obj.mac}</td>
								<td><b>N° Série :</b></td><td>&nbsp;{$obj.antena_ns}</td>
							</tr>
							<tr>
								<td><b>ODU :</b></td><td>&nbsp;
									{if isset($obj.rel.tipo_equipamentos.nome)}
										{$obj.rel.tipo_equipamentos.nome}
									{/if}
								</td>
								<td><b>Tamanho :</b></td><td>&nbsp;{$obj.antena_tam}</td>
							</tr>
							<tr>
								<td><b>N° Serie ODU :</b></td><td>&nbsp;{$obj.nsodu}</td>
								<td><b></b></td><td></td>
							</tr>

							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<table class="table table-bordered">
							<thead><th bgcolor="#87ceeb" class="text-center"><b>Observação</b></th></thead>
							<tbody>
							<tr>
								<td>{$obj.observacoes}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				{if $obj.rel.os.os_status_idos_status != 2}

					{if ($login.perfis_idperfis == 2 || $login.perfis_idperfis == 3 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 5 ) && $obj.confirm != 1}
						<button type="button" value="Confirmar Agendamento" class="btn btn-primary" onClick="javascript:sendPost('AgendaInstal/edit','fAgConfirm')">
							Confirmar Agendamento
						</button>
					{/if}
					{if $obj.confirm == 1}
						<input
								style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);"
								type="text"
								value="Para editar agendamento é necessário cancelar a confirmação do mesmo"
						/><br/><br/>
						<button type="button" value="Cancelar confirmação de agendamento" class="btn btn-primary" onClick="javascript:cancelConfirmAgend({$obj.idagenda_instal})" >
							Cancelar confirmação de agendamento
						</button>
					{/if}
					{if $obj.confirm != 1}
						<button type="button" value="" class="btn btn-primary" onClick="javascript:getAjaxForm('AgendaInstal/edit','divOS',{ldelim}param:{$obj.idagenda_instal},ajax:1{rdelim})" >
							Editar
						</button>
					{/if}
					<button type="button" value="" class="btn btn-primary" onClick="javascript:getAjaxForm('OS/view_compact','',{ldelim}param:{$obj.rel.os.idos},ajax:1{rdelim})" >
						Ver OS
					</button>
				{else}
					<input style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);text-align:center;" type="text" value="Agendamento de uma OS Cancelada" />
				{/if}
			</div>
		</div>
	</form>
</div>
<br>
<div id="divOS"></div>

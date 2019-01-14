<center>
<div style="height:20px;">&nbsp;</div>

<div class="container1" style="width: 70%;">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title text-left">
				{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 2 }
					<button type="button" class="btn btn-success" value=""
						   onclick="javascript:getAjaxForm('AtendVsat/create','divDinamico',{ldelim}param:{$incidente},ajax:1{rdelim})">
					Abrir Novo Atendimento
					</button>
				{/if}
			</div>
		</div>
		<div class="panel-body" style="padding: 0px; margin-top: 0px;">
			<table class="table table-striped table-bordered">
				<thead style="background-color: #c0c0c0">
					<th style="width:100px;">Data</th>
					<th style="width:280px;">Atendimento</th>
					<th style="width:250px;">Resposta Agilis</th>
					<th style="width:100px;">Status</th>
					<th style="width:110px;">Instalação</th>
					<th style="width:100px;">Usuário</th>
				</thead>
				<tbody>
				{foreach from=$atendimentos item=obj}
					<tr class="" onClick="javascript:getAjaxForm('AtendVsat/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})">
						<td>{$obj.data}</td>
						<td>{$obj.atendimento}</td>
						<td>{$obj.resposta_agilis}</td>
						<td>{$obj.status}</td>
						<td>{$obj.incidente.instalacoes.0.nome}</td>
						<td>{$obj.usuario.nome}</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>


<center style="margin-top:15px;">

</center>

</center>

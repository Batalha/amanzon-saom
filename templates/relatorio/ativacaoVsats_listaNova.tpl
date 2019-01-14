
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Nome Vsat</th>
			<th>Data Ativação</th>
			<th>Data Agendamento</th>
			<th>Data Aceite Prodemge</th>
		</tr>
	</thead>
	
	<tbody>
		{foreach from=$lista item=item}
		    <tr>
				<td>{$item.nome}</td>
				<td>{$item.data_ativacao}</td>
				<td>{$item.data_agendamento}</td>
				<td>{$item.aceite_prodemge}</td>
			</tr>
		{/foreach}
	</tbody>
</table>
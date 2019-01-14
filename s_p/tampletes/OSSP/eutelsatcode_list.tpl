
<center>

{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}

<table id="tbLista" class="table table-bordered table-striped">

	<thead>
		<tr>
			<td coslpan="4">
				{$lista_contagem} {if $lista_contagem == 1}item{else}itens{/if}.
			</td>
		</tr>
		<tr>
			<th>OS</th>
            <th>Localidade</th>
            <th>Vsat</th>
            <th>Eutelsat Code</th>
		</tr>
		<tr class="filtros">
			<th>
				<input 
					name="os" 
					id="os" 
					type="text" 
					onkeypress="javascript:submitBuscaEutelsat(event)"
					value="{if isset($form)}{if $form.0.value != ''}{$form.0.value}{/if}{/if}"
				/>
			</th>
			<th>
				<input 
					name="localidade" 
					id="localidade" 
					type="text" 
					onkeypress="javascript:submitBuscaEutelsat(event)"
					value="{if isset($form)}{if $form.1.value != ''}{$form.1.value}{/if}{/if}"
				/>
			</th>
			<th>
				<input 
					name="nome" 
					id="nome" 
					type="text" 
					onkeypress="javascript:submitBuscaEutelsat(event)"
					value="{if isset($form)}{if $form.2.value != ''}{$form.2.value}{/if}{/if}"
				/>
			</th>
			<th>
				<input 
					name="eutelsat_code" 
					id="eutelsat_code" 
					type="text" 
					onkeypress="javascript:submitBuscaEutelsat(event)"
					value="{if isset($form)}{if $form.3.value != ''}{$form.3.value}{/if}{/if}"
				/>
			</th>
		</tr>
	</thead>
	
	<tbody>
		{foreach from=$lista item=item}
			<tr id="{$item.id}">
				<td>{$item.os}</td>
				<td>{$item.localidade}</td>
				<td>{$item.nome}</td>
				<td id="vsatcode_{$item.id}">
					<span 
						style="float:left;cursor:pointer;" 
						onclick="javascript:mostraFormEutelsat('{$item.id}')"
						id="spanvalue"
					>{$item.eutelsat_code}</span>
					<span 
						style="float:right;cursor:pointer;"
						onclick="javascript:mostraFormEutelsat('{$item.id}')"
					><i class="icon-pencil"></i></span>
				</td>
			</tr>
		{/foreach}
	</tbody>
	
</table>

</center>
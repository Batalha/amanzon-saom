<center>
{include file="s_p/tampletes/equipamento/submenu.tpl" title=submenu}

<div><h3>Lista de Usuários</h3></div>

<table class="table table-bordered table-striped tbLista tableLocaisequipamentos" style="cursor:pointer">
	<thead>
	    <tr>
	        <th>Nome</th>
	        <th>Descrição</th>
	    </tr>
    </thead>
    
    <tbody>
	    {foreach from=$arr item=obj}
		    <tr>
		    	
		        <td >{if isset($obj.nome)}{$obj.nome}{/if}</td>
		        <td >{if isset($obj.descricao)}{$obj.descricao}{/if}</td>
		        
		    </tr>
	    {/foreach}
	</tbody>
	
</table>
</center>
<center>
{include file="incidente/submenu.tpl" title=submenu}

<style>
	#avisoInstantaneo{
				position:absolute;margin-left:-100px;margin-top:21px;
				width:90px;height:40px;border:1px solid #000;
				background:#fff;color:#000;text-align:right;padding:5px;
				}
	.word-wrap{
			overflow:visible;
			}
</style>

<div id="avisoInstantaneo">Campos de Filtro -></div>

<table class="tbLista tableTecnicos">
	<thead>
	    <tr>
	        <th id="colunaTabelaIncidentesTecnicos1">Nome</th>
	        <th id="colunaTabelaIncidentesTecnicos2">Empresa</th>
	        <th id="colunaTabelaIncidentesTecnicos3">Telefone</th>
	        <th id="colunaTabelaIncidentesTecnicos4">Tarefas</th>
	    </tr>
    </thead>
    <tbody>
	    {foreach from=$listaTecnicos item=obj}
		    {cycle values='trCor,trsCor' assign=rowCss}     
		    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('Incidente/view','conteudo',{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
		        <td class="tableTecnicos _filterCol0 _match">{$obj.nome}</td>
		        <td class="tableTecnicos _filterCol1 _match">{$obj.empresa}</td>
		        <td class="tableTecnicos _filterCol2 _match">{$obj.telefone}</td>
		        <td class="tableTecnicos _filterCol3 _match">{$obj.vsats}</td>
		    </tr>
	    {/foreach}
    </tbody>
</table>

<script>
	$('table.tbLista').columnFilters();
</script>
</center>
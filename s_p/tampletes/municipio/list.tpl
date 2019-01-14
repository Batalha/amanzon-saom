<center>
{include file="s_p/tampletes/municipio/submenu.tpl" title=submenu}
<table class="tbLista">
    <tr>
        <th>ID</th>
        <th>Municípios</th>
        <th>Macroregião</th>
    </tr>
    {foreach from=$arr item=obj}
	    {cycle values='trCor,trsCor' assign=rowCss}     
	    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('Municipio_sp/view','conteudo',{ldelim}param:{$obj.idmunicipios_sp},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
	        <td>{$obj.idmunicipios_sp}</td>
	        <td>{$obj.municipio}</td>
	        <td>{$obj.macroregiao}</td>
	    </tr>
    {/foreach}
</table>
</center>
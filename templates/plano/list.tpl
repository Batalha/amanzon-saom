{include file="plano/submenu.tpl" title=submenu}
<table class="tbLista">
    <tr>
        <th>ID</th>
        <th>Plano</th>
        <th>Descrição</th>
    </tr>
    {foreach from=$arr item=obj}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('Plano/view','conteudo',{ldelim}param:{$obj.idplanos},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
        <td>{$obj.idplanos}</td>
        <td>{$obj.plano}</td>
        <td>{$obj.descricao}</td>
    </tr>
    {/foreach}
</table>
<center>
{include file="mudaplano/submenu.tpl" title=submenu}
<table class="tbLista">
    <tr>
        <th>VSAT</th>
        <th>Plano Atual</th>
        <th>Plano Anterior</th>
        <th>Observação</th>
    </tr>
    {foreach from=$arr item=obj}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('MudaPlano/view','conteudo',{ldelim}param:{$obj.idmuda_plano},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
        <td>{$obj.rel.instalacoes.nome}</td>
        <td>{$obj.rel.planos.plano}</td>
        <td>{$obj.rel.planos_aux.plano}</td>
        <td>{$obj.observacao}</td>
    </tr>
    {/foreach}
</table>
</center>
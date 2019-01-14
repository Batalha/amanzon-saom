<center>
{include file="cancelamento/submenu.tpl" title=submenu}
<table class="tbLista">
    <tr>
        <th>VSAT</th>
        <th>Data</th>
        <th>Motivo</th>
        <th>Status</th>
      
    </tr>
    {foreach from=$arr item=obj}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('Cancelamento/view','conteudo',{ldelim}param:{$obj.idcancelamentos},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
        
        <td>{$obj.rel.instalacoes.nome}</td>
        <td>{$obj.data}</td>
        <td>{$obj.motivo}</td>
        <td>testes</td>
    </tr>
    {/foreach}
</table>
</center>
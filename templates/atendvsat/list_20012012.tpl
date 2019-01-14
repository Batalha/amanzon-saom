{include file="incidente/submenu.tpl" title=submenu}
<table class="tbLista">
    <tr>
        <th>N° Incidente</th>
        <th>VSAT</th>
        <th>Data</th>
        <th>Prioridade</th>
        <th>Descrição</th>
    </tr>
    {foreach from=$arr item=obj}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('Incidente/view','conteudo',{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
        <td>{$obj.idincidentes}</td>
        <td>{$obj.rel.instalacoes.nome}</td>
        <td>{$obj.data}</td>
        <td {if $obj.prioridade == 'Baixa'} class='tdGreen'{elseif $obj.prioridade == 'Média'}class='tdYel'{elseif $obj.prioridade == 'Alta'}class='tdRed'{/if}>{$obj.prioridade}</td>
        <td>{$obj.descricao}
    </tr>
    {/foreach}
</table>
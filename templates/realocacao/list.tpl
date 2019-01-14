<center>
{include file="realocacao/submenu.tpl" title=submenu}
<table class="tbLista">
    <tr>
        <th>VSAT</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>CEP</th>
        <th>Cod. área</th>
        <th>Cidade</th>
        <th>Bairro</th>
        <th>Endereço</th>
      
    </tr>
    {foreach from=$arr item=obj}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('Realocacao/view','conteudo',{ldelim}param:{$obj.idrealocacao},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
        
        <td>{$obj.rel.instalacoes.nome}</td>
        <td>{$obj.latitude}</td>
        <td>{$obj.longitude}</td>
        <td>{$obj.cep}</td>
        <td>{$obj.cod_area}</td>
        <td>{$obj.cidade}</td>
        <td>{$obj.bairro}</td>
        <td>{$obj.endereco}</td>
    </tr>
    {/foreach}
</table>
</center>
<table class="tbLista" id="OSlist">
    <tr>
        
        <th>CCTO</th>
        <th>LOCALIDADE</th>
        <th>OS PRODEMGE</th>
        <th>DATA PEDIDO</th>
        <th>LOTE</th>
        <th>VELOCIDADE</th>
        <th>RAZÃO SOCIAL</th>
        <th>PREVISÃO LINK</th>
        <th>CIRCUITOS ACEITOS</th>
    </tr>
    {foreach from=$arr item=os}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}">
      
        <th>{$os.nomeVsat}</th>
        <td>{$os.rel.municipios_idcidade.municipio}</td>
        <td>{$os.identificador}</td>
        <td>{$os.dataSolicitacao}</td>
        <td>LOTE7</td>
        <td>{$os.velDownload}</td>
        <td>SES</td>
        {if $os.rel.agenda_instal}
            <td>{$os.rel.agenda_instal.data}</td>
            <td>Projetado</td>
        {else}
            <td>--</td>
            <td>Aceito</td>
        {/if}
        
    </tr>
    {/foreach}
</table>

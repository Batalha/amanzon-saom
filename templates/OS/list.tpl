




<center>
<div>
    <input type="text" value="" id="findOS" name="findOS" />
    <select name="typePesq" id="typePesq">
        <option value="identificador">ID</option>
        <option value="numOS" >Número da OS</option>
        <option value="cidade" >Cidade</option>
    </select>
    <input type="button" value="Buscar" onClick="javascript:findOS()" />
    <br />
    <br />
</div>

<table class="tbLista" id="OSlist">
    <tr>
        <th>N° OS</th>
        <th>Orgão</th>
        <th>Cidade</th>
        <th>Macroregião</th>
        <th>Data Solic.</th>
        <th class='titleTable'><a href="#" onclick="javascript:getAjaxForm('OS/liste','conteudo',{ldelim}orderBy:'prazoInstal',ajax:1{rdelim})"  >Prazo</a></th>
        <th>Agendamento</th>
        <th>Vsat criada?</th>
        <th>Comiss.</th>
        <th>Cod. Anatel</th>
        <th>Aceite PRODEMGE</th>
    </tr>
    {foreach from=$arr item=os}
    {cycle values='trCor,trsCor' assign=rowCss}     
    <tr class="{$rowCss}" onClick="javascript:getAjaxForm('OS/view','conteudo',{ldelim}param:{$os.idos},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
        
        <td>{$os.numOS}</td>
        
        <td>SES</td>
        <td>{$os.rel.municipios_idcidade.municipio}</td>
        <td>{$os.rel.municipios_idcidade.macroregiao}</td>
        <td>{$os.dataSolicitacao}</td>
        
        <td >{$os.prazoInstal}</td>
        {if isset($os.rel.agenda_instal.idagenda_instal)}
         {if $os.rel.agenda_instal.confirm == 1}   
            <td class='tdGreen'>Confirmado</td>
         
         {elseif $os.rel.agenda_instal.mac}
             
             <td class='tdYel'>Agendado</td>
          {else}
              <td class='tdRed'><B>Agendado</B></td>
         {/if}       
        {else}
        <td class='tdRed'>Não</td>    
        {/if}
        
        {if isset($os.rel.instalacoes.idinstalacoes)}
            
            {if !$os.rel.instalacoes.webnms && !$os.rel.instalacoes.packetshapper && !$os.rel.instalacoes.reglicenca && !$os.rel.instalacoes.opmanager && !$os.rel.instalacoes.prtg}
               <td class='tdYel'>
                   Incompleta
               </td>
            {else}
                
                {if ! $os.rel.instalacoes.webnms}
                    <td class='tdYel'>Pendente WebNms</td>
                
                {elseif ! $os.rel.instalacoes.packetshapper}
                    <td class='tdYel'>Pendente Packet Shapper</td>
                {elseif ! $os.rel.instalacoes.reglicenca}    
                    <td class='tdYel'>Pendente Registro da licença</td>
                {elseif ! $os.rel.instalacoes.opmanager}    
                    <td class='tdYel'>Pendente Opmanager</td>
                 {elseif ! $os.rel.instalacoes.prtg}    
                    <td class='tdYel'>Pendente PRTG</td>
                   
                {else}
                    <td class='tdGreen'>Completa</td>
                {/if}    
             {/if}   
         {else}
             <td class='tdRed'>Não</td>
        {/if}
        {if !isset($os.rel.instalacoes) or $os.rel.instalacoes.comiss != 1}
            <td class='tdRed'>Não</td>
                
        {else}
            <td class='tdGreen'>Sim</td>
        {/if}

        {if isset($os.rel.instalacoes.idinstalacoes)}
            <td class='tdGreen'>{$os.rel.instalacoes.cod_anatel}</td>
        {else}
            <td class='tdRed'>Não</td>
        {/if}    
        {if isset($os.rel.instalacoes.data_aceite)}
            <td class='tdGreen'>{$os.rel.instalacoes.data_aceite|date_format:"%d/%m/%Y"}</td>
        {else}
            <td class='tdRed'>Não</td>
        {/if}    
    </tr>
    {/foreach}
</table>
</center>
{if $pag && isset($orderBy)}    
    {pagination total=$pag.total rowspage=$pag.rowspage url=$pag.url div='conteudo' orderBy=$orderBy}
{else}
    {pagination total=$pag.total rowspage=$pag.rowspage url=$pag.url div='conteudo'}
{/if}
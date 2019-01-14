<form action="Instalacao/edit" method="PobjT" id="FobjCreate" class="form" >
    <fieldset>
        <legend>{$obj.nome} - Dados da Instalação</legend>
    <table class="tbForm">
        <tr>
            <td>
                OS
            </td>
            <td>
                {$obj.rel.os.numOS}
            </td>
        </tr>
        <tr>
            <td>
                <label for="mac">MAC</label>
            </td>
            <td>
                {$obj.mac}
            </td>

            <td>
                <label for="azimute">Azimute </label>
            </td>
            <td>
                {$obj.azimute}
            </td>        
        </tr>
        <tr>    
            <td>
                <label for="elevacao">Elevação </label>
            </td>
            <td>
                {$obj.elevacao}
            </td>
            <td>
                <label for="cod_area">Código de área </label>
            </td>
            <td>
                {$obj.cod_area}
            </td>

        </tr>
        <tr>
            <td>
                <label for="antena">Antena </label>
            </td>
            <td>
                {$obj.antena} {$obj.antena_tam}
            </td>
            <td>
                <label for="antena_ns">N° Série</label>
            </td>
            <td>
                {$obj.antena_ns}
            </td>    
           
        </tr>
         <tr>
            <td>
                <label for="odu">ODU </label>
            </td>
            <td>
                {$obj.odu}
            </td>
            <td>
                <label for="nsodu">N° Série</label>
            </td>
            <td>
                {$obj.nsodu}
            </td>    
           
        </tr>
        <tr>
            <td>
                <label for="lnb"> LNB </label>
            </td>
            <td>
                {$obj.lnb}
            </td>
            <td>
                <label for="tipo_IDU">Tipo IDU</label>
            </td>
            <td>
                {$obj.tipo_IDU}
            </td>      
        </tr>
        <tr>
            <td>
                 <label for="buc"> BUC </label>
            </td>
            <td>
                {$obj.buc}
            </td>
            <td>
                <label for="cod_anatel">Cód. Anatel </label>
            </td>
            <td>
                {$obj.cod_anatel}
            </td>

        </tr>
        <tr >
            <td colspan="2">
                <label for="obs">Observações </label>
            </td>
            <td>
               {$obj.obs}
            </td>

        </tr>
    </table>

    </fieldset>
    <br />
    {if $login.perfis_idperfis != 3}
        
        <center>
        {if $obj.comiss != 1}
                <input type="button" value="Comissionar" onClick="javascript:getAjaxForm('Instalacao/comiss', 'dadosInstal',{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim},getDadosComiss,'{$obj.os_idos}' )" /><input type="button" value="Editar Instalação" onClick="javascript:getAjaxForm('Instalacao/edit',false,{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})" />
        {else}
                <input type="button" value="Ver Comissionamento" onClick="javascript:getAjaxForm('Instalacao/comiss_view', 'dadosInstal',{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim} )" />
        		<input type="button" value="Editar Instalação" onClick="javascript:getAjaxForm('Instalacao/edit',false,{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})" /><input type="button" value="Registrar Incidente" onClick="javascript:getAjaxForm('Incidente/create','dadosInstal',{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})" /><input type="button" value="Realocação" onClick="javascript:getAjaxForm('Realocacao/create','dadosInstal',{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})" /><input type="button" value="Cancelamento" onClick="javascript:getAjaxForm('Cancelamento/create','dadosInstal',{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})" />
        {/if}  
        <input type="button" value="Termo Instalação" onClick="window.open('instalacao/termo/{$obj.idinstalacoes}')" /><?php /*javascript:getAjaxForm('Instalacao/termo',false,{ldelim}param:{$obj.idinstalacoes},ajax:1{rdelim})*/?>
        </center>
        
    {/if}    
</form>

<div id="dadosInstal">
</div>
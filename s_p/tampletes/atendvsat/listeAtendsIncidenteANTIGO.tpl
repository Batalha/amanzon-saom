<center>
    <div style="height:20px;">&nbsp;</div>

    <table class="tbLista" style="width:1020px !important;">
        <tr>
            <th style="width:80px;">Data</th>
            <th style="width:320px;">Atendimento</th>
            {if $login.perfis_idperfis != 10}
                <th style="width:320px;">Resposta</th>
            {/if}
            <th style="width:100px;">Status Atendimento</th>
            <th style="width:100px;">Instalação</th>
            <th style="width:100px;">Usuário</th>
        </tr>
        {foreach from=$atendimentos item=obj}
            {cycle values='trCor,trsCor' assign=rowCss}
            <tr class="{$rowCss}" onClick="javascript:getAjaxForm('AtendVsat_sp/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
                <td>{$obj.data}</td>
                <td>{$obj.mensagem}</td>
                {if $login.perfis_idperfis != 10}
                    <td>{$obj.resposta_agilis}</td>
                {/if}
                <td>{$obj.status}</td>
                <td>{$obj.incidente.instalacoes_sp.0.nome}</td>
                <td>{$obj.usuario.nome}</td>
            </tr>
        {/foreach}
    </table>

    <center style="margin-top:15px;">
        {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 10}
            <input type="button" value="Abrir Novo Atendimento"
                onclick="javascript:getAjaxForm('AtendVsat_sp/create','divDinamico',{ldelim}param:{$incidente},ajax:1{rdelim})" />
        {/if}
    </center>

</center>
<div style="margin-bottom: 50px;">&nbsp;</div>

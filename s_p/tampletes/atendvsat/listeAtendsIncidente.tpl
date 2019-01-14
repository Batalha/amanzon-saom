


<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                {$obj}
                {if ($login.perfis_idperfis == 10) && $atendimentos[0].status == 'Finalizado'}
                    <button type="button" class="btn btn-success"
                           onclick="javascript:getAjaxForm('AtendVsat_sp/create','divDinamico',{ldelim}param:{$incidente},ajax:1{rdelim})">
                    Abrir Novo Atendimento
                    </button>
                {else}
                    {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 1}
                        <button type="button" class="btn btn-success"
                               onclick="javascript:getAjaxForm('AtendVsat_sp/create','divDinamico',{ldelim}param:{$incidente},ajax:1{rdelim})">
                            Abrir Novo Atendimento
                        </button>

                    {/if}
                {/if}
            </div>
        </div>
        <div class="panel-body" style="padding: 0px; margin-top: 0px;">
                <table class="table table-responsive table-bordered">
                    <thead style="background-color: #EFEFEF">
                        <th style="width:100px;">Data</th>
                        <th style="width:320px;">Atendimento</th>
                        {if $login.perfis_idperfis != 10}
                            <th style="width:300px;">Resposta</th>
                        {/if}
                        <th style="width:80px;">Status</th>
                        <th style="width:100px;">Instalação</th>
                        <th style="width:100px;">Usuário</th>
                    </thead>
                    <tbody>
                        {foreach from=$atendimentos item=obj}
                            <tr class="" onClick="javascript:getAjaxForm('AtendVsat_sp/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})">
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
                    </tbody>
                </table>
        </div>
    </div>
</div>




{*<center>*}
    {*<div style="height:20px;">&nbsp;</div>*}

    {*<table class="tbLista" style="width:1020px !important;">*}
        {*<tr>*}
            {*<th style="width:80px;">Data</th>*}
            {*<th style="width:320px;">Atendimento</th>*}
            {*{if $login.perfis_idperfis != 10}*}
                {*<th style="width:320px;">Resposta</th>*}
            {*{/if}*}
            {*<th style="width:100px;">Status Atendimento</th>*}
            {*<th style="width:100px;">Instalação</th>*}
            {*<th style="width:100px;">Usuário</th>*}
        {*</tr>*}
        {*{foreach from=$atendimentos item=obj}*}
            {*{cycle values='trCor,trsCor' assign=rowCss}*}
            {*<tr class="{$rowCss}" onClick="javascript:getAjaxForm('AtendVsat_sp/view','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})" onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">*}
                {*<td>{$obj.data}</td>*}
                {*<td>{$obj.mensagem}</td>*}
                {*{if $login.perfis_idperfis != 10}*}
                    {*<td>{$obj.resposta_agilis}</td>*}
                {*{/if}*}
                {*<td>{$obj.status}</td>*}
                {*<td>{$obj.incidente.instalacoes_sp.0.nome}</td>*}
                {*<td>{$obj.usuario.nome}</td>*}
            {*</tr>*}
        {*{/foreach}*}
    {*</table>*}

    {*<center style="margin-top:15px;">*}
        {*{if ($login.perfis_idperfis == 10) && $obj.status == 'Finalizado'}*}
            {*<input type="button" value="Abrir Novo Atendimento"*}
                {*onclick="javascript:getAjaxForm('AtendVsat_sp/create','divDinamico',{ldelim}param:{$incidente},ajax:1{rdelim})" />*}
        {*{else}*}
            {*{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 1}*}
                {*<input type="button" value="Abrir Novo Atendimento"*}
                       {*onclick="javascript:getAjaxForm('AtendVsat_sp/create','divDinamico',{ldelim}param:{$incidente},ajax:1{rdelim})" />*}

            {*{/if}    *}
        {*{/if}*}

    {*</center>*}

{*</center>*}
{*<div style="margin-bottom: 50px;">&nbsp;</div>*}

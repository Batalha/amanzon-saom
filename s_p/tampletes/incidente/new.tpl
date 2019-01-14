<div class="container1" style="margin-top: 0px; margin-left: 7%;">
    <div class="row">
        {include file="s_p/tampletes/incidente/submenu.tpl" title=submenu}
    </div>
</div>

<div class="container1" style="margin-top: 10px; width: 55%;">
    <form action="AgendaInstal_sp/create" method="POST" id="fAgCreate"	class="form">
        <input type="hidden" name="numeroIncidente" id="numeroIncidente" value="{$totalIncidentes}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Registrar Ticket</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            {if $perfil == 10}
                            <input type="text" name="data" id="data" size="10" readonly="readonly" class="form-control" value="{$dataAtual}" placeholder="Data de Solicitação"
                                   onchange="javascript:retiraError()"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            {else}
                            <input type="text" name="data" id="data" size="10" class="form-control" placeholder="Data de Solicitação"
                                   onchange="javascript:retiraError()"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            {/if}
                        </div>
                    </div>
                    <div class="form-group col-md-6 text-center">
                        <label class="text-info" style="font-size: 25px;">Ticket  Nº </label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="" style="font-size: 35px;">{$totalIncidentes}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <select class="form-control" name="prioridade" id="prioridae">
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>
                    <div id="errorInstalacao" class="form-group col-md-6">
                        {if $idempresa != 1}
                        <input type="text" name="nome_instalacao" class="form-control" id="nome_instalacao" placeholder="Instalação"
                               value="{$cliente}"
                               onchange="javascript:retiraError()"
                               onfocus="javascript:nomevsat('{$cliente}');"
                        />
                        {else}
                        <input type="text" name="nome_instalacao" class="form-control" id="nome_instalacao" placeholder="Instalação"
                               onchange="javascript:retiraError()"/>
                        {/if}
                        <div style="display: none" id="listaComplete">{$listaautocomplete}</div>
                    </div>
                </div>
                <div class="row">
                    <div id="errorTecnico" class="form-group col-md-6">
                        {if $idempresa == 1}
                        <select name="tecnicoNoc" id="tecnicoNoc" class="form-control" onchange="javascript:retiraError()">
                            <option value="">Escolher Tecnico</option>
                            {foreach from=$listaUsuarios item=vez}
                            {if $vez.ativacao == 1 && $vez.incidentes == 1}
                            <option value="{$vez.idusuarios}">{$vez.nome}</option>
                            {/if}
                            {/foreach}
                        </select>
                        {else}
                        <select name="tecnicoNoc" id="tecnicoNoc" class="form-control">
                            <option value="67">Tecnico Noc</option>
                        </select>
                        {/if}
                    </div>
                    <div id="errorSolicitacao" class="form-group col-md-3">
                        <select name="solicitacao_idsolicitacao" id="solicitacao_idsolicitacao" class="form-control"
                                onchange="javascript:retiraError();tipoIncidente();"
                        >
                            <option value=0>Tipo de Ticket</option>
                            {foreach from=$solicitacao item=sl}
                            <option value="{$sl.idsolicitacao}">{$sl.nomeSolicitacao}</option>
                            {/foreach}
                        </select>
                    </div>
                    <!--<div id="para"></div>-->
                    <div id="tipoHidden" class="form-group col-md-3" hidden>
                        <select name="tipo_incidente_idtipo" id="tipo_incidente_idtipo" class="form-control">
                            <option value=0>--Selecione--</option>
                            {foreach from=$tipoIncidente item=tp}
                            <option value="{$tp.idtipo}">{$tp.nomeTipo}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div id="demoHidden" class="form-group col-md-3" hidden>
                        <select name="teste_demo_idteste" id="teste_demo_idteste" class="form-control">
                            <option value=0>--Selecione--</option>
                            {foreach from=$testeDemo item=td}
                            <option value="{$td.idteste}">{$td.nomeTeste}</option>
                            {/foreach}
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control" name="descricao" id="descricao" style="height:150px;" placeholder="Descrição do Ticket"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="padding-bottom: 26px;" onmouseover="javascript:verificaCamposIncidenteSp()">
                        <input type="button" class="btn btn-primary" id="submitIncidenteCreate" value="Cadastrar Incidente"
                               onClick="javascript:sendPost('Incidente_sp/create','fAgCreate');" />
                    </div>
                    <div class="col-md-9">
                        <span id="respostaFormAjax" class="alert alert-error" style="display:none;" ></span>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
<br>
<br>
<br>
<br>

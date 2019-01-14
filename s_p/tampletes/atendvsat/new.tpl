
<div class="container1" style="width: 70%;">
    <form action="s_p/controller/AtendVsat_sp/create" method="POST" id="fAgCreate" class="form" >
        <input type="hidden" name="incidentes_sp_idincidentes" id="incidentes_sp_idincidentes" value="{$param}"/>
        <input type="hidden" name="instalacoes_sp_idinstalacoes_sp" id="instalacoes_sp_idinstalacoes_sp" value="{$instalacoes_idinstalacoes}"/>
        <input type="hidden" name="data" id="data" value="{$dataAtual}"/>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Realizar atendimento</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios"/>
                        <textarea class="form-control" name="atendimento" id="atendimento" style="height:150px;" placeholder="Atendimento"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="status_atend_idstatus_atend">Status de Atendimento:</label>
                        <select class="form-control" name="status_atend_idstatus_atend" id="status_atend_idstatus_atend">
                            <option value='1'>Em Atendimento</option>
                            <option {if $autorizacao != 0}{else}hidden{/if} value='2'>Finalizado</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nomeResponsavel">Repassar atendimento:</label>
                        <select class="form-control" name="nomeResponsavel" id="nomeResponsavel" {if $autorizacao == 0}disabled{/if}>
                            <option value="">Técnicos</option>
                            {foreach from=$lista_atendentes item=atendentes}
                                {if ($atendentes.incidentes == 1 && $autorizacao != 0)}
                                    <option value="{$atendentes.idusuarios}">{$atendentes.nome}</option>
                                {else}
                                    {if $atendentes.idusuarios == 67}
                                        <option value="{$atendentes.idusuarios}">{$atendentes.nome}</option>
                                    {/if}
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tipo_atendimento_idtipo_atendimento">Tipos de atendimento:</label>
                        <select class="form-control" name="tipo_atendimento_idtipo_atendimento" id="tipo_atendimento_idtipo_atendimento">
                            {foreach from=$tipo_atendimento item=tipos}
                                <option value="{$tipos.idtipo_atendimento}">{$tipos.tipo_atendimento}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row" {if $autorizacao != 0}{else}hidden{/if}>
                    <div class="form-group col-md-12">
                        <textarea class="form-control" id="resposta_agilis" name="resposta_agilis" style="height:150px;" placeholder="Resposta do Agilis"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input class="btn btn-primary" type="button" value="Enviar"
                               onClick="javascript:
                                       $.ajax({ldelim}
                                       url:'AtendVsat_sp/insert',
                                       type:'POST',
                                       data:{ldelim}form:$('#fAgCreate').serialize(){rdelim},
                                       success:function(resposta){ldelim}
                                       $('#respostaAjax').html(resposta);
                                       $('#respostaAjax').css( 'display' , 'block' );
                                       setTimeout( 'limpaAvisos()' , 5000 );
                               {rdelim}
                               {rdelim});
                                       " />
                        &nbsp;&nbsp;&nbsp;
                        <input class="btn" type="button" value="Cancelar" onClick="javascript:getAjaxForm('AtendVsat_sp/liste','divDinamico',{ldelim}param:{$param},ajax:1{rdelim})" />
                    </div>
                    <div class="form-group col-md-8">
                        <div id="respostaAjax" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

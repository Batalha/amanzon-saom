<div class="container1" style="width: 70%;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Atendimento: Nº {$obj.idatend_vsat}</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 text-left">
                    {if $obj.status_atend_idstatus_atend == 3}
                        {if $obj.perfil_atend == 4 || $obj.perfil_atend == 1 || $obj.perfil_atend == 5}
                            <button type="button" class="btn btn-info" onclick="javascript:getAjaxForm('AtendVsat_sp/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})">
                                Continuar Atendimento
                            </button>
                        {/if}
                    {else}
                        <button type="button" class="btn btn-info" onclick="javascript:getAjaxForm('AtendVsat_sp/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})">
                            Continuar Atendimento
                        </button>
                    {/if}
                </div>
                {if $obj.perfil_atend != 10}
                    <div class="col-md-6 text-center">
                        <h4>Tecnico Responsavel : {$obj.rel.usuarios.nome}</h4>
                    </div>
                    <div class="col-md-3 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Trocar Responsavel</button>

                    </div>
                {/if}
            </div>
            <div class="row" style="padding: 0px;">
                <div class="form-group">
                    <div class="borda1">
                        <div class="borda2">
                            <table border="0" width="100%">
                                <tr>
                                    <td align="center" width="100%" bgcolor="white">
                                        {if $obj.perfil_atend != 10}
                                            {$obj.atendimento}
                                        {else}
                                            {$obj.privado}
                                        {/if}


                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-example-modal-sm" id="modal_responsavel_comiss" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de Tecnicos</h4>
            </div>
            <form name="trocar_responsavel" id="trocar_responsavel" action="" method="post">
                <input type="hidden" name="idatendVsat" id="idatendVsat" value="{$obj.idatend_vsat}" />
                <input type="hidden" name="idincidente" id="idincidente" value="{$obj.incidentes_sp_idincidentes}" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="">Tecnico do Atendimento</label>
                            <select name="usuarios_idusuarios" id="usuarios_idusuarios" class="form-control"
                                    onchange="javascript:selecaoSala()"
                            >
                                <option value="">Escolher Tecnico</option>
                                {foreach from=$listaUsuarios item=vez}
                                    {if $vez.ativacao == 1 && $vez.incidentes == 1}
                                        <option value="{$vez.idusuarios}">{$vez.nome}</option>
                                    {/if}
                                {/foreach}
                            </select>

                        </div>
                        <div class="col-md-7">
                            <label for="">Tecnico do Ticket</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="tecnico_ticket" id="" value="sim" checked="checked">
                                </span>
                                <input type="text" class="form-control" readonly="readonly" value="Trocar Responsavel do Ticket?">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row esconder" hidden>
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" name="sala" id="" value="2" {if $obj.sala == 2}checked="checked"{else}{/if}>
                                </span>
                                <input type="text" class="form-control" readonly="readonly"  value="Noc?"

                                >
                                <span class="input-group-addon">
                                    <input type="radio" name="sala" id="" value="3" {if $obj.sala == 3}checked="checked"{else}{/if}>
                                </span>
                                <input type="text" class="form-control" readonly="readonly" value="Campo?">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="resposTrocaResponsavel"></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                            onclick="javascript:
                                $.ajax(
                                    {ldelim}
                                        url:'AtendVsat_sp/trocaResponsavel',
                                        data:{ldelim}form:$('#trocar_responsavel').serialize(){rdelim},
                                        type:'POST',
                                        async:false,
                                        success:function( resposta )
                                        {ldelim}

                                            var r = jQuery.parseJSON(resposta);
                                            $('#resposTrocaResponsavel').html( r.msg );

		   									if( r.status == 'ok' )
                                                {ldelim}
                                                    setTimeout(function()
                                                    {ldelim}
                                                        $('#resposTrocaResponsavel').html('');
                                                        $('#modal_responsavel_comiss').modal('hide');
                                                    {rdelim},4000);

                                                {rdelim}
                                                else
                                                    {ldelim}
                                                        setTimeout(function()
                                                                        {ldelim}
                                                                            $('#respostaAssociacaoMotivo').html('');
                                                                        {rdelim},2000
                                                                    );

                                                    {rdelim}



                                        {rdelim}
                                    {rdelim}
                                );"

                    >Savar dados</button>
                </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
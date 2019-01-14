<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title text-center">
            <b>Upgrade e Downgrade</b>
        </div>
    </div>
    <div class="panel-heading"  style="height: 37px;">
        <div class="panel-title" style="margin-top: -5px;">
            <button  class="btn btn-dark" type="button" id="up" data-toggle="modal" data-target=".bs-atualiza-os">Upgrade / Downgrade</button>
        </div>
    </div>
    <div class="panel-body">
        <div class="row" style="height: auto;">
            <table class="table">
                <thead>
                <tr id="fonts">
                    <!--<th>ID</th>-->
                    <th>Nº da OS</th>
                    <th>Status da Atualizaçao</th>
                    <th>Data</th>
                    <th>Observação</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$obj item=dado}
                <a href="">

                    <tr onClick="javascript:
                        getAjaxForm('OSSP/view_os_atual','conteudo',{ldelim}param:{$dado.id},ajax:1{rdelim});">
                        <!--<td>{$dado.id}</td>-->
                        <td>{$dado.num_os_sp}</td>
                        <td>{$dado.status_atual}</td>
                        <td>{$dado.data}</td>
                        <td>{$dado.observacao}</td>
                    </tr>
                </a>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>

</div>



<div class="modal fade bs-atualiza-os" id="modal_atualizacao_os" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atualização da OS</h4>
            </div>
            <form name="atualizacao_os" id="atualizacao_os" action="" method="post">
                <input type="hidden" name="idos" id="idos" value="{$idos}" />
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="numOs">Nº da OS</label>
                            <input class="form-control" type="text" name="numOS" id="numOS" value="{$numossp}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="status_atual">Atualizaçao</label>
                            <select class="form-control" name="status_atual" id="status_atual">
                                <option value="upgrade">Upgrade</option>
                                <option value="dowgrade">Downgrade</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!--<div class="form-group col-md-6">-->
                        <!--<div class="input-group">-->
                        <!--<input class="form-control" type="text"  readonly="readonly" value="IpPb:"/>-->
                        <!--<span class="input-group-addon">-->
                        <!--<input type="radio" name="iplan" id="iplan" value="sim" onclick="return chekQtLinhas(this)">-->
                        <!--<label for="">Sim</label>-->
                        <!--<input type="radio" name="iplan" id="iplan" value="nao" onclick="return chekQtLinhas(this)">-->
                        <!--<label for="">Não</label>-->
                        <!--</span>-->
                        <!--<input class="form-control" type="text" name="qtip" id="qtip" placeholder="Qtd"/>-->

                        <!--</div>-->
                        <!--</div>-->
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="iplan" id="iplan" value="" placeholder="IP Publico">
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <input class="form-control" type="text" readonly="readonly" value="Voip:"/>
                            <span class="input-group-addon">
                                <input type="radio" name="voip" id="voip" value="sim" onclick="return chekQtLinhas(this)">
                                <label for="">Sim</label>
                                <input type="radio" name="voip" id="voip" value="nao" onclick="return chekQtLinhas(this)">
                                <label for="">Não</label>
                            </span>
                                <input class="form-control" type="text" name="qtlinha" id="qtlinha" placeholder="Qtd"/>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class='form-control inputReq' type="text" id="mirDownload" name="mirDownload" placeholder="MIR Download"/>
                        </div>
                        <div class="form-group col-md-6">
                            <input class='form-control inputReq' type="text" id="mirlUpload" name="mirUpload" placeholder="MIR Upload" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class='form-control inputReq' type="text" id="cirUpload" name="cirUpload" placeholder="CIR Upload" />
                        </div>
                        <div class="form-group col-md-6">
                            <input class='form-control inputReq' type="text" id="cirDownload" name="cirDownload" placeholder="CIR Download" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <input class="form-control" type="text"  readonly="readonly" value="Speednet:"/>
                            <span class="input-group-addon">
                                <input type="radio" name="speednet" id="speedSim" value="sim" onclick="escondeSelect(id)"/>
                                <label for="">Sim</label>
                                <input type="radio" name="speednet" id="speedNao" value="nao" onclick="escondeSelect(id)"/>
                                <label for="">Não</label>
                            </span>
                            </div>
                        </div>
                        <div class="form-group col-md-6 selecione">
                            <select name="speedTipo" id="speedTipo" class="form-control" onchange="escondeSelect()">
                                <option value="">--Selecione--</option>
                                <option value="plug&play">Plug&Play</option>
                                <option value="transparent">Transparent mode</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 qualTipo" hidden>
                            <input class="form-control" type="text" name="outrospeed" id="" placeholder="Outros">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="observacoes">Observação</label>
                            <textarea class="form-control" name="observacoes" id="observacoes" cols="30"></textarea>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div id="respostaAtualOs"></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                            onclick="javascript:
                            $.ajax(
                                {ldelim}
                                    url:'OSSP/new_atual_os',
                                    data:{ldelim}form:$('#atualizacao_os').serialize(){rdelim},
                                    type:'POST',
                                    async:false,
                                    success:function( resposta )
                                    {ldelim}

                                        var r = jQuery.parseJSON(resposta);
                                        $('#respostaAtualOs').html( r.msg );

                                        if( r.status == 'ok' )
                                            {ldelim}
                                                setTimeout(function()
                                                {ldelim}
                                                    $('#respostaAtualOs').html('');
                                                    $('#modal_atualizacao_os').modal('hide');
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
                                            getAjaxForm('OSSP/lista_atualizacao_os',false,{ldelim}param:{$idos},ajax:1{rdelim});
                                    {rdelim}
                                {rdelim}
                        );">
                        Save
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
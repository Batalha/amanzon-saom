
{*<!-- {include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu} -->*}

<!-- div que serve para a verificação, ela guarda a data atual e não permite menor que a mesma por verificação javascript -->

<div class="container1" style="width: 50%;">
    <div id="data_verificacao" style="visibility:hidden;">{$dataAtual}</div>
    <form action="AgendaInstal_sp/create" method="GET" id="fAgCreate" class="form" >
        <input type="hidden" name="os_sp_idos" id="os_sp_idos" value="{$param}"/>
        <input type="hidden" value="{$dataAtual}" name="data_temp"/>
        <input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios" />
        <input type="hidden" name="confirm" id="confirm" value="0" />
        <input type="hidden" name="saom" id="saom" value="2" />

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Dados de Contato</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <input class="form-control" type="text" name="data" id="data" placeholder="Data Agendada" value="" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <input  class="form-control"  type="text" name="contato" id="contato" placeholder="Nome Contato" value=""/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="tel" id="tel"  placeholder="Telefone" value=""
                            onkeypress="Mask(this, telefone)"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <input  class="form-control" type="text" name="cel" id="cel"  placeholder="Celular"value=""
                            onkeypress="Mask(this, celular)"
                        />
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Agendar Instalação</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="antena" class="form-control">
                            <option value='patriot'>Patriot</option>
                            <option value='skyware'> Skyware</option>
                            <option value='brasilsat'> BrasilSat</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="antena_tam" class="form-control">
                            <option value='1.2m'>1.2m</option>
                            <option value='1.8m'>1.8m</option>
                            <option value='1.90m'>0.90m</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 left-inner-addon">
                        <i id="restrictMac" style=" font-size: 1.5em; color: red; padding: 10px; position: absolute; margin: 2px 0px 0px 100px;"></i>
                        <input type="text" name="mac" id="mac" alt="mac"  class="form-control" value="" placeholder="MAC"
                               onblur="javascript: atualizaNSModemsp(this.value);"

                        />
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" readonly="readonly" name="nsmodem" id="nsmodem"  class="form-control" value="" placeholder="Nº Serie do Modem" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <i id="restrictOdu" style=" font-size: 1.5em; color: red; padding: 10px; position: absolute; margin: 2px 0px 0px 100px;"></i>
                        <input type="text" name="nsodu" id="nsodu" class="form-control" placeholder="Nº Serie do ODU/BUC"
                               onblur="javascript:atualizaAgendaODUsp(this.value);"
                        />
                        <div id="listaComplete" style="position:absolute;display:none">{$listaautocomplete}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="odu" id="odu" class="form-control">
                            <option value="">Escolha uma ODU</option>
                            {foreach from=$tipoEquipamento item=tipoEquipamentos}
                                <option value="{$tipoEquipamentos.idtipo_equipamentos_sp}">{$tipoEquipamentos.nome}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea  class="form-control" id="observacoes" name="observacoes" placeholder="Observações" ></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-primary" onClick="javascript:sendPost('AgendaInstal_sp/create','fAgCreate')"><span class="glyphicon glyphicon-ok"></span> Cadastrar agendamento</button>
                    </div>
                    <div class="form-group col-md-8">
                        <span id="respostaConsultaAgenda" class="alert alert-error" style="display: none;"></span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
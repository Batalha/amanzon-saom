

<div class="container1" style="width: 65%;">
    <form action="Instalacao_sp/create" method="POST" id="fInsEdit" class="form" >
        <input type="hidden" name="idinstalacoes_sp" id="idinstalacoes_sp" value="{$obj.idinstalacoes_sp}"/>
        <input type="hidden" name="os_sp_idos" id="os_sp_idos" value="{$obj.os_sp_idos}" />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Dados da Instalação</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao_sp" type="text" name="nome" id="nome" value="{$obj.nome}">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select class="form-control autosave_instalacao_sp" name="planos_idplanos" id="planos_idplanos">
                                <option value='1' {if $obj.planos_idplanos == 1}selected{/if}>Plano Básico</option>
                                <option value='2' {if $obj.planos_idplanos == 2}selected{/if}>Plano Clássico</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao_sp" type="text" name="mac" id="mac" alt="mac" value="{$obj.mac}"placeholder="MAC"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao_sp" type="text" name="azimute" id="azimute" value="{$obj.azimute}" placeholder="Azimute"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input class="form-control autosave_instalacao_sp" type="text" name="elevacao" id="elevacao" value="{$obj.elevacao}" placeholder="Elevação"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                    <div class="">
                        <input class="form-control autosave_instalacao_sp" type="text" name="cod_area" id="cod_area" value="{$obj.cod_area}" placeholder="Codigo de Area"/>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" name="nsodu" id="nsodu" class="form-control autosave_instalacao_sp" value="{$obj.nsodu}" placeholder="Nº Serie ODU"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="odu" id="odu" class="form-control autosave_instalacao_sp">
                                <option value="">Escolha uma opção</option>
                                {foreach from=$tipoEquipamentos item=tipoEquipamento}
                                    <option value="{$tipoEquipamento.idtipo_equipamentos}" {if $obj.odu == $tipoEquipamento.idtipo_equipamentos}selected{/if}>{$tipoEquipamento.nome}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" id="os_iplan" name="os_iplan" class='form-control autosave_instalacao_sp' value="{$obj.os_iplan}" placeholder="Ip Lan"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" id="os_ipdvb" name="os_ipdvb" class='form-control autosave_instalacao_sp' value="{$obj.os_ipdvb}" placeholder="Ip DVB"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="buc" id="buc" class="form-control autosave_instalacao_sp">
                                <option value="Satlink 4033" {if $obj.buc == "Satlink 4033"} selected {/if}>Satlink 4033</option>
                                <option value="Satlink 4035" {if $obj.buc == "Satlink 4035"} selected {/if}>Satlink 4035</option>
                                <option value="Invacom 2W"   {if $obj.buc == "Invacom 2W"} selected {/if}>Invacom 2W</option>
                                <option value="Norsat 2W"   {if $obj.buc == "Norsat 2W"} selected {/if}>Norsat 2W</option>
                                <option value="Advantec 2W" {if $obj.buc == "Advantec 2W"} selected {/if}>Advantec 2W</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="lnb" id="lnb" class="form-control autosave_instalacao_sp">
                                <option value="Satlink 4033" {if $obj.lnb == "Satlink 4033"} selected {/if}>Satlink 4033</option>
                                <option value="Satlink 4035" {if $obj.lnb  == "Satlink 4035"} selected {/if}>Satlink 4035</option>
                                <option value="Invacom 2W"   {if $obj.lnb  == "Invacom 2W"} selected {/if}>Invacom 2W</option>
                                <option value="Norsat 2W"   {if $obj.lnb == "Norsat 2W"} selected {/if}>Norsat 2W</option>
                                <option value="Advantec 2W" {if $obj.lnb  == "Advantec 2W"} selected {/if}>Advantec 2W</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="tipo_IDU" class="form-control autosave_instalacao_sp" id="tipo_IDU">
                                <option value="Satlink 2000" {if $obj.tipo_IDU == "Satlink 2000"} selected {/if}>Satlink 2000</option>
                                <option value="Satlink 1900" {if $obj.tipo_IDU == "Satlink 1900"} selected {/if}>Satlink 1900</option>
                                <option value="Satlink 1901" {if $obj.tipo_IDU == "Satlink 1901"} selected {/if}>Satlink 1901</option>
                                <option value="Satlink 1902" {if $obj.tipo_IDU == "Satlink 1902"} selected {/if}>Satlink 1902</option>
                                <option value="Satlink 1910" {if $obj.tipo_IDU == "Satlink 1910"} selected {/if}>Satlink 1910</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">

                            <input class="form-control autosave_instalacao_sp" type="text" name="cod_anatel" id="cod_anatel" value="{$obj.cod_anatel}" placeholder="Codigo Anatel"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">
                            <select name="antena" id="antena" class="form-control autosave_instalacao_sp" >
                                <option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>
                                <option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>
                                <option value='Brasil Sat' {if $obj.antena == 'Brasil Sat'} selected {/if}> Brasil Sat</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="">

                            <select name="antena_tam" id="antena_tam" class="form-control autosave_instalacao_sp" >
                                <option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>
                                <option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="">
                            <input type="text" name="antena_ns" id="antena_ns"  class="form-control autosave_instalacao_sp" value="{$obj.antena_ns}" placeholder="Nº de Serie"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Testou o satLink 2000?">
                            <span class="input-group-addon">
                                <input class="autosave_instalacao_sp" type="checkbox" name="test_sl2000" id="test_sl2000"{if $obj.test_sl2000} checked  {/if} />
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Vsat foi criada no WEBNMS?">
                            <span class="input-group-addon">
                                <input class="autosave_instalacao_sp" type="checkbox" name="webnms" id="webnms"   {if $obj.webnms} checked  {/if} />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Vsat foi criada no PacketShapper?">
                            <span class="input-group-addon">
                            {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}
                                <input class="autosave_instalacao_sp" type="checkbox" name="packetshapper" id="packetshapper"   {if $obj.packetshapper}  checked{/if} />{else}<input type="hidden" name="packetshapper" id="packetshapper" value="{$obj.packetshapper}" />
                            {/if}

                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Registro de licença?">
                            <span class="input-group-addon">
                                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}
                                    <input class="autosave_instalacao_sp" type="checkbox" name="reglicenca" id="reglicenca"   {if $obj.reglicenca}  checked{/if} />{else}<input type="hidden" name="reglicenca" id="reglicenca" value="{$obj.reglicenca}" />
                                {/if}
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" value="Cadastro no Opmanager?">
                            <span class="input-group-addon">
                                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 4}
                                    <input class="autosave_instalacao_sp" type="checkbox" name="opmanager" id="opmanager"   {if $obj.opmanager}  checked{/if} />{else}<input type="hidden" name="opmanager" id="opmanager" value="{$obj.opmanager}" />
                                {/if}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input class="form-control" type="text" name="data_ativacao" id="data_ativacao" value="{$obj.data_ativacao}" placeholder="Data de Ativação"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <textarea class="form-control autosave_instalacao_sp" name="obs" id="obs">{$obj.obs}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="button" class="btn btn-primary" value="Salvar" onClick="javascript:sendPost('Instalacao_sp/edit','fInsEdit')" />
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>


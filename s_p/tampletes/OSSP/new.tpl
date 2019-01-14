<div class="container1" style="margin-top: -10px; margin-left: 7%;">
    <div class="row">
        {include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
    </div>
</div>
<br>


<div class="container1" style="width: 60%;">


    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#telefone" aria-controls="telefone" role="tab"
                                                      data-toggle="tab">Telefonica</a></li>
            <li role="presentation"><a href="#atiOs" aria-controls="atiOs" role="tab" data-toggle="tab">Ati</a>
            </li>
            <li role="presentation"><a href="#outrasOs" aria-controls="outrasOs" role="tab" data-toggle="tab">Outros</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="telefone">

                <form action="" method="POST" id="FOSCreate" class="form">
                    <input type="hidden" name="tel_iduser_cadastro" value="{$login.idusuarios}">
                    <input type="hidden" name="tel_clientes_idcliente" id="tel_clientes_idcliente">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="pane-title text-center">OS, OI ou Telefonica</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4 paddingForm">
                                    <select class="form-control" name="tel_empreiteira_idempresas"
                                            id="tel_empreiteira_idempresas">
                                        <option value="">Selecione Empreiteira</option>
                                        {foreach from=$empresas item=empresa}
                                        {if $empresa.tipo == EMP || $empresa.tipo == EMPT}
                                        <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                        {/if}
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="tel_numOS" id="tel_numOS"
                                           placeholder="Numero da Os"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="tel_identificador"
                                           id="tel_identificador" placeholder="Identificador"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control inputReq' type="text" name="tel_contato" id="tel_contato"
                                           placeholder="Nome"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="tel_telContato"
                                           name="tel_telContato" placeholder="Celular"
                                           onkeypress="Mask(this, celular)"

                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="tel_outroTelContato"
                                           name="tel_outroTelContato" placeholder="Telefone"
                                           onkeypress="Mask(this, telefone)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="tel_cep" name="tel_cep"
                                           alt="cep" placeholder="CEP"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="tel_pais" id="tel_pais"
                                           placeholder="Pais"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control inputReq' type="text" id="tel_enderecoInstal"
                                           name="tel_enderecoInstal" placeholder="Endereço"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="tel_cidade" id="tel_cidade"
                                           placeholder="Cidade"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="tel_estado" id="tel_estado"
                                           placeholder="Estado"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary" style="margin-top: -10px;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="tel_mirDownload"
                                           name="tel_mirDownload" placeholder="MIR Download"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="tel_cirDownload"
                                           name="tel_cirDownload" placeholder="CIR Download"/>
                                </div>
                                <div class="form-group col-md-3">
                                    <input class="form-control" type="text" id="tel_iplan1" name="tel_iplan1"
                                           placeholder="IP Lan 1"/>
                                </div>
                                <div class="form-group col-md-1">
                                    <input class="form-control" type="text" id="tel_iplanMask1" name="tel_iplanMask1"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="tel_mirUpload"
                                           name="tel_mirUpload" placeholder="MIR Upload"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class=' form-control inputReq' type="text" id="tel_cirUpload"
                                           name="tel_cirUpload" placeholder="CIR Upload"/>
                                </div>
                                <div class="form-group col-md-3">
                                    <input class='form-control' type="text" id="tel_iplan2" name="tel_iplan2"
                                           placeholder="IP Lan 2"/>
                                </div>
                                <div class="form-group col-md-1">
                                    <input class="form-control" type="text" id="tel_iplanMask2" name="tel_iplanMask2"/>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary" style="margin-top: -10px;">
                        <div class="panel-heading">
                            <div class="panel-title text-center">Faturamento</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select class="form-control" name="tel_empresas_idempresas"
                                            id="tel_empresas_idempresas" onchange="getCarregaDadosEmrpesaTel()">
                                        <option value="">Selecione Cliente</option>
                                        {foreach from=$empresas item=empresa}
                                        {if $empresa.local == SP}
                                        <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                        {/if}
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="tel_cnpjFaturamento" id="tel_cnpjFaturamento" placeholder="CNPJ"
                                           onkeypress="Mask(this, cnpj)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" id="tel_cepFaturamento"
                                           name="tel_cepFaturamento" alt="cep" placeholder="CEP"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="tel_paisFaturamento" id="tel_paisFaturamento" placeholder="País"/>
                                </div>
                                <div class="form-group col-md-8">
                                    <input class='form-control' disabled="disabled" type="text"
                                           id="tel_enderecoFaturamento" name="tel_enderecoFaturamento"
                                           placeholder="Endereço"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="tel_cidadeFaturamento" id="tel_cidadeFaturamento"
                                           placeholder="Cidade"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="tel_estadoFaturamento" id="tel_estadoFaturamento"
                                           placeholder="Estado"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <input class='form-control' type="text" id="tel_dataSolicitacao"
                                               name="tel_dataSolicitacao" placeholder="Data Solicitação"/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control' disabled="disabled" type="text"
                                           id="tel_emailFaturamento" name="tel_emailFaturamento" placeholder="Email"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <idv class="input-group">
                                        <input class="form-control" type="text" id="tel_prazoInstal"
                                               name="tel_prazoInstal" onfocus="getPrazoInstalTel()"
                                               placeholder="Prazo de Instalação"/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </idv>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control" style="height: 80px;" type="text"
                                              id="tel_observacoes" name="tel_observacoes"
                                              placeholder="Observação"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class="btn btn-primary" type="button" value="Cadastrar OS"
                                           onClick="javascript:sendPost('OSSP/telefonica','FOSCreate')"/>
                                </div>
                                <div class="form-group col-md-8">
                                    <div class="alert alert-warning" id="tel_msg_prazo" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div role="tabpanel" class="tab-pane" id="atiOs">

                <form action="" method="POST" id="FOSCreateAti" class="form">
                    <input type="hidden" name="ati_iduser_cadastro" value="{$login.idusuarios}">
                    <input type="hidden" name="ati_clientes_idcliente" id="ati_clientes_idcliente">

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="pane-title text-center">ATI - OS</div>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="form-group col-md-4 paddingForm">
                                    <select class="form-control" name="ati_empreiteira_idempresas"
                                            id="ati_empreiteira_idempresas">
                                        <option value="">Selecione Empreiteira</option>
                                        {foreach from=$empresas item=empresa}
                                        {if $empresa.tipo == EMP || $empresa.tipo == EMPT}
                                        <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                        {/if}
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="ati_numOS" id="ati_numOS"
                                           placeholder="Numero da Os"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="ati_identificador"
                                           id="ati_identificador" placeholder="Identificador"/>
                                </div>
                            </div>
                                           <!--value="ADAPI-AGENCIA DE DEFESA AGROPECUARIA DO PIAUI"-->
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="ati_orgao">Orgão</label>
                                    <input class='form-control inputReq' type="text" name="ati_orgao" id="ati_orgao" value=""/>
                                </div>
                                           <!--value="ADAPI-AROAZES"-->
                                <div class="form-group col-md-4">
                                    <label for="ati_unidade">Unidade</label>
                                    <input class='form-control inputReq' type="text" name="ati_unidade" id="ati_unidade"
                                           value=""
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <input class="form-control" type="text" size="10" readonly="readonly"
                                               value="Tipo de Acesso:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="ati_acesso" id="p_acesso" value="publico"
                                                   onclick="escondeCampo(id)">
                                            <b> Público &nbsp;</b>
                                            <input type="radio" name="ati_acesso" id="e_acesso" value="escola"
                                                   onclick="escondeCampo(id)">
                                            <b> Escola &nbsp;</b>
                                            <input type="radio" name="ati_acesso" id="o_acesso"
                                                   onclick="escondeCampo(id)">
                                            <b> Outros</b>
                                        </span>
                                        <input class="form-control" type="text" name="ati_acesso" id="outros"
                                               disabled="disabled"/>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control inputReq' type="text" name="ati_contato" id="ati_contato"
                                           placeholder="Nome"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="ati_inep" id="ati_inep"
                                           placeholder="Inep"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="ati_outroTelContato"
                                           name="ati_outroTelContato" placeholder="Telefone 1"
                                           onkeypress="Mask(this, telefone)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="ati_outroTelContato2"
                                           name="ati_outroTelContato2" placeholder="Telefone 2"
                                           onkeypress="Mask(this, telefone)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="ati_telContato"
                                           name="ati_telContato" placeholder="Celular"
                                           onkeypress="Mask(this, celular)"

                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control inputReq' type="email" id="ati_email" name="ati_email"
                                           placeholder="E-email"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="ati_cep" name="ati_cep"
                                           alt="cep" placeholder="CEP"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control inputReq' type="text" id="ati_enderecoInstal"
                                           name="ati_enderecoInstal" placeholder="Endereço"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="ati_pais" id="ati_pais"
                                           placeholder="Pais"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="ati_cidade" id="ati_cidade"
                                           placeholder="Cidade"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="ati_estado" id="ati_estado"
                                           placeholder="Estado"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success" style="margin-top: -10px;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <input class="form-control" type="text" readonly="readonly"
                                               value="Area:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="ati_area_instal" id="u_area_instal" value="urbana">
                                            <b>Urbano &nbsp;</b>
                                            <input type="radio" name="ati_area_instal" id="r_area_instal" value="rural">
                                            <b>Rural &nbsp;</b>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <div class="input-group">
                                        <input class="form-control" type="text" size="5" readonly="readonly"
                                               value="Tipo de Equipamento:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="ati_tipo_equip" id="o_tipo_equip" value="outdoor">
                                            <b>Outdoor &nbsp;</b>
                                            <input type="radio" name="ati_tipo_equip" id="i_tipo_equip" value="indoor">
                                            <b>Indoor &nbsp;</b>
                                            <input type="radio" name="ati_tipo_equip" id="m_tipo_equip" value="movel">
                                            <b>Movel &nbsp;</b>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-1">
                                    <input class="form-control" type="text" readonly="readonly" value="Lat:"/>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="">
                                        <input class="form-control" type="text" maxlength="2" name="ati_lat_g" id="ati_lat_g" placeholder="º"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="">
                                        <input class="form-control" type="text" maxlength="2" name="ati_lat_m" id="ati_lat_m" placeholder='"'/>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="">
                                        <input class="form-control" type="text" maxlength="2" name="ati_lat_s" id="ati_lat_s" placeholder="'" />
                                    </div>
                                </div>


                                <div class="form-group col-md-2">
                                    <input class=' form-control inputReq' type="text" id="ati_cirUpload"
                                           name="ati_cirUpload" placeholder="Up CIR"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <input class='form-control inputReq' type="text" id="ati_cirDownload"
                                           name="ati_cirDownload" placeholder="Down CIR"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="ati_end_rede" name="ati_end_rede"
                                           placeholder="Endereço de Rede"/>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-1">
                                    <input class="form-control" type="text" readonly="readonly" value="Lon:"/>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="">
                                        <input class="form-control" type="text" maxlength="2" name="ati_long_g" id="ati_long_g" placeholder="º"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="">
                                        <input class="form-control" type="text" maxlength="2" name="ati_long_m" id="ati_long_m" placeholder='"'/>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="">
                                        <input class="form-control" type="text" maxlength="2" name="ati_long_s" id="ati_long_s" placeholder="'" />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <input class='form-control inputReq' type="text" id="ati_mirUpload"
                                           name="ati_mirUpload" placeholder="Up MIR"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <input class='form-control inputReq' type="text" id="ati_mirDownload"
                                           name="ati_mirDownload" placeholder="Down MIR "/>
                                </div>

                                <div class="form-group col-md-4">
                                    <input class='form-control' type="text" id="ati_end_lan" name="ati_end_lan"
                                           placeholder="Endereço de Lan"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="ati_wan_fw" name="ati_wan_fw"
                                    placeholder="Endereço de Wan do FW"
                                    />

                                </div>

                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="ati_ip_lan_fw" name="ati_ip_lan_fw"
                                    placeholder="Endereço IP Lan FW"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="ati_router" name="ati_router"
                                           placeholder="Endereço do Router"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success" style="margin-top: -10px;">
                        <div class="panel-heading">
                            <div class="panel-title text-center">Faturamento</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select class="form-control" name="ati_empresas_idempresas"
                                            id="ati_empresas_idempresas" onchange="getCarregaDadosEmrpesaAti()">
                                        <option value="">Selecione Cliente</option>
                                        {foreach from=$empresas item=empresa}
                                        {if $empresa.local == SP}
                                        <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                        {/if}
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="ati_cnpjFaturamento" id="ati_cnpjFaturamento" placeholder="CNPJ"
                                           onkeypress="Mask(this, cnpj)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" id="ati_cepFaturamento"
                                           name="ati_cepFaturamento" alt="cep" placeholder="CEP"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="ati_paisFaturamento" id="ati_paisFaturamento" placeholder="País"/>
                                </div>
                                <div class="form-group col-md-8">
                                    <input class='form-control' disabled="disabled" type="text"
                                           id="ati_enderecoFaturamento" name="ati_enderecoFaturamento"
                                           placeholder="Endereço"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="ati_cidadeFaturamento" id="ati_cidadeFaturamento"
                                           placeholder="Cidade"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text"
                                           name="ati_estadoFaturamento" id="ati_estadoFaturamento"
                                           placeholder="Estado"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <input class='form-control' type="text" id="ati_dataSolicitacao"
                                               name="ati_dataSolicitacao" placeholder="Data Solicitação"/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control' disabled="disabled" type="text"
                                           id="ati_emailFaturamento" name="ati_emailFaturamento" placeholder="Email"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <idv class="input-group">
                                        <input class="form-control" type="text" id="ati_prazoInstal"
                                               name="ati_prazoInstal" onfocus="getPrazoInstalAti()"
                                               placeholder="Prazo de Instalação"/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </idv>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control" style="height: 80px;" type="text"
                                              id="ati_observacoes" name="ati_observacoes"
                                              placeholder="Observação"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class="btn btn-success" type="button" value="Cadastrar OS"
                                           onClick="javascript:sendPost('OSSP/createAtiOs','FOSCreateAti')"/>
                                </div>
                                <div class="form-group col-md-8">
                                    <div class="alert alert-warning" id="ati_msg_prazo" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div role="tabpanel" class="tab-pane" id="outrasOs">

                <form action="" method="POST" id="FOSCreateoutrosCanais" class="form">
                    <input type="hidden" name="iduser_cadastro" value="{$login.idusuarios}">
                    <input type="hidden" name="clientes_idcliente" id="clientes_idcliente">

                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <strong>Atenção:</strong> VERIFICAR PRIMEIRO SE O CLIENTE ESTA CADASTRADO NO <STRONG>MENU
                        CLIENTE</STRONG>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title text-center">Outros Canais</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select class="form-control" name="empreiteira_idempresas"
                                            id="empreiteira_idempresas">
                                        <option value="">Selecione</option>
                                        {foreach from=$empresas item=empresa}
                                        {if $empresa.tipo == EMP || $empresa.tipo == EMPT}
                                        <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                        {/if}
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="numOS" id="numOS"
                                           placeholder="Numero da Os"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="dataSolicitacao"
                                           name="dataSolicitacao" placeholder="Data Solicatação"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control inputReq' type="text" name="contato" id="contato"
                                           placeholder="Nome"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="telContato" name="telContato"
                                           placeholder="Celular"
                                           onkeypress="Mask(this, celular)"
                                    />
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" id="outroTelContato" name="outroTelContato"
                                           placeholder="Telefone"
                                           onkeypress="Mask(this, telefone)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="cep" name="cep" alt="cep"
                                           placeholder="CEP"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="cidade" id="cidade"
                                           placeholder="Cidade"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" name="estado" id="estado"
                                           placeholder="Estado"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="enderecoInstal"
                                           name="enderecoInstal" placeholder="Endereco da Insatalação"/>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <input class="form-control" type="text" readonly="readonly" value="Speednet:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="speednet" id="speedSim" value="sim"
                                                   onclick="escondeSelect(id)"/>
                                            <label for="">Sim</label>
                                            <input type="radio" name="speednet" id="speedNao" value="nao"
                                                   onclick="escondeSelect(id)"/>
                                            <label for="">Não</label>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 selecione">
                                    <select name="speedTipo" id="speedTipo" class="form-control"
                                            onchange="escondeSelect()">
                                        <option value="">--Selecione--</option>
                                        <option value="plug&play">Plug&Play</option>
                                        <option value="transparent">Transparent mode</option>
                                        <option value="outros">Outros</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 qualTipo" hidden>
                                    <input class="form-control" type="text" name="outrospeed" id=""
                                           placeholder="Outros">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <input class="form-control" type="text" readonly="readonly" value="IpPb:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="iplan" id="iplan" value="sim"
                                                   onclick="return chekQtLinhas(this)">
                                            <label for="">Sim</label>
                                            <input type="radio" name="iplan" id="iplan" value="nao"
                                                   onclick="return chekQtLinhas(this)">
                                            <label for="">Não</label>
                                        </span>
                                        <input class="form-control" type="text" name="qtip" id="qtip"
                                               placeholder="Qtd"/>

                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <input class="form-control" type="text" readonly="readonly" value="Voip:"/>
                                        <span class="input-group-addon">
                                            <input type="radio" name="voip" id="voip" value="sim"
                                                   onclick="return chekQtLinhas(this)">
                                            <label for="">Sim</label>
                                            <input type="radio" name="voip" id="voip" value="nao"
                                                   onclick="return chekQtLinhas(this)">
                                            <label for="">Não</label>
                                        </span>
                                        <input class="form-control" type="text" name="qtlinha" id="qtlinha"
                                               placeholder="Qtd"/>

                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <select class="form-control" name="escricao_fornecimento_idescricao_fornecimento"
                                            id="escricao_fornecimento_idescricao_fornecimento">
                                        <option value="">Selecione um Fornecimento</option>
                                        {foreach from=$escricoes item=escricao}
                                        <option value="{$escricao.idescricao_fornecimento}">
                                            {$escricao.nome_escricao_forn}
                                        </option>
                                        {/foreach}

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="mirDownload" name="mirDownload"
                                           placeholder="MIR Download"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="mirlUpload" name="mirUpload"
                                           placeholder="MIR Upload"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <select class="form-control" name="satelite_idsatelite" id="satelite_idsatelite">
                                        <option value="">Selecione um Satelite</option>
                                        {foreach from=$satelites item=satelite}
                                        <option value="{$satelite.idsatelite}">{$satelite.nome_satelite}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="cirUpload" name="cirUpload"
                                           placeholder="CIR Upload"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control inputReq' type="text" id="cirDownload" name="cirDownload"
                                           placeholder="CIR Download"/>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title text-center">Faturamento</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select class="form-control" name="empresas_idempresas" id="empresas_idempresas"
                                            onchange="getCarregaDadosEmrpesaOs()">
                                        <option value="">Selecione um Cliente</option>
                                        {foreach from=$empresas item=empresa}
                                        {if $empresa.local == SP}
                                        <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                                        {/if}
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" name="cnpjFaturamento"
                                           id="cnpjFaturamento" placeholder="CNPJ"
                                           onkeypress="Mask(this, cnpj)"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" id="cepFaturamento"
                                           name="cepFaturamento" placeholder="CEP"
                                           onkeypress="Mask(this, cep)"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input class='form-control' disabled="disabled" type="text" id="enderecoFaturamento"
                                           name="enderecoFaturamento" placeholder="Edereço"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" name="cidadeFaturamento"
                                           id="cidadeFaturamento" placeholder="Cidade"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" id="paisFaturamento"
                                           name="paisFaturamento" placeholder="Pais"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" name="estadoFaturamento"
                                           id="estadoFaturamento" placeholder="Estado"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class='form-control' disabled="disabled" type="text" id="emailFaturamento"
                                           name="emailFaturamento" placeholder="Email"/>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control" type="text" id="observacoes" name="observacoes"
                                              style="height: 100px;" placeholder="Observação"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 text-center">
                                    <input type="button" class="btn btn-info" value="Salvar"
                                           onClick="javascript:sendPost('OSSP/createOutrosCanais','FOSCreateoutrosCanais')"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>


</div>

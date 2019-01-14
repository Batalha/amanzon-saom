<div class="container1" style="margin-top: -10px; margin-left: 7%;">
    <div class="row">
        {include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
    </div>
</div>

<br>
<div class="container1" style="width: 65%;">
    <form action="s_p/tampletes/OSSP/createOutrosCanais" method="POST" id="FOSCreateoutrosCanais" class="form" >
        <input type="hidden" name="iduser_cadastro" value="{$login.idusuarios}">
        <input type="hidden" name="clientes_idcliente" id="clientes_idcliente">

        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Atenção:</strong> VERIFICAR PRIMEIRO SE O CLIENTE ESTA CADASTRADO NO <STRONG>MENU CLIENTE</STRONG>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title text-center">Outros Canais</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <select class="form-control" name="empreiteira_idempresas" id="empreiteira_idempresas">
                            <option value="">Selecione</option>
                            {foreach from=$empresas item=empresa}
                            {if $empresa.tipo == EMP || $empresa.tipo == EMPT}
                            <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                            {/if}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" name="numOS" id="numOS" placeholder="Numero da Os"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="dataSolicitacao" name="dataSolicitacao" placeholder="Data Solicatação"   />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <input   class='form-control inputReq' type="text" name="contato" id="contato" placeholder="Nome" />
                    </div>
                    <div class="form-group col-md-4">
                        <input  class='form-control inputReq' type="text" id="telContato" name="telContato" placeholder="Celular"
                            onkeypress="Mask(this, celular)"
                        />
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input class="form-control" type="text" id="outroTelContato" name="outroTelContato" placeholder="Telefone"
                               onkeypress="Mask(this, telefone)"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="cep" name="cep" alt="cep" placeholder="CEP"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq'  type="text" name="cidade" id="cidade" placeholder="Cidade"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" name="estado" id="estado" placeholder="Estado"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="enderecoInstal" name="enderecoInstal" placeholder="Endereco da Insatalação"/>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
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
                    <div class="form-group col-md-4 selecione">
                        <select name="speedTipo" id="speedTipo" class="form-control" onchange="escondeSelect()">
                            <option value="">--Selecione--</option>
                            <option value="plug&play">Plug&Play</option>
                            <option value="transparent">Transparent mode</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 qualTipo" hidden>
                        <input class="form-control" type="text" name="outrospeed" id="" placeholder="Outros">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input class="form-control" type="text"  readonly="readonly" value="IpPb:"/>
                            <span class="input-group-addon">
                                <input type="radio" name="iplan" id="iplan" value="sim" onclick="return chekQtLinhas(this)">
                                <label for="">Sim</label>
                                <input type="radio" name="iplan" id="iplan" value="nao" onclick="return chekQtLinhas(this)">
                                <label for="">Não</label>
                            </span>
                            <input class="form-control" type="text" name="qtip" id="qtip" placeholder="Qtd"/>

                        </div>
                    </div>
                    <div class="form-group col-md-4">
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

                    <div class="form-group col-md-4">
                        <select class="form-control" name="escricao_fornecimento_idescricao_fornecimento" id="escricao_fornecimento_idescricao_fornecimento" >
                            <option value="">Selecione um Fornecimento</option>
                            {foreach from=$escricoes item=escricao}
                                <option value="{$escricao.idescricao_fornecimento}">{$escricao.nome_escricao_forn}</option>
                            {/foreach}

                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="mirDownload" name="mirDownload" placeholder="MIR Download"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="mirlUpload" name="mirUpload" placeholder="MIR Upload" />
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control" name="satelite_idsatelite" id="satelite_idsatelite" >
                            <option value="">Selecione um Satelite</option>
                            {foreach from=$satelites item=satelite}
                                <option value="{$satelite.idsatelite}">{$satelite.nome_satelite}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="cirUpload" name="cirUpload" placeholder="CIR Upload" />
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control inputReq' type="text" id="cirDownload" name="cirDownload" placeholder="CIR Download" />
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
                                onchange="getCarregaDadosEmrpesa()">
                            <option value="">Selecione um Cliente</option>
                            {foreach from=$empresas item=empresa}
                            {if $empresa.local == SP}
                            <option value="{$empresa.idempresas}">{$empresa.empresa}</option>
                            {/if}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control' disabled="disabled" type="text" name="cnpjFaturamento" id="cnpjFaturamento" placeholder="CNPJ"
                            onkeypress="Mask(this, cnpj)"
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <input  class='form-control' disabled="disabled" type="text" id="cepFaturamento" name="cepFaturamento"placeholder="CEP"
                            onkeypress="Mask(this, cep)"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <input class='form-control' disabled="disabled" type="text" id="enderecoFaturamento" name="enderecoFaturamento" placeholder="Edereço"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control' disabled="disabled" type="text" name="cidadeFaturamento" id="cidadeFaturamento" placeholder="Cidade"  />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input class='form-control' disabled="disabled" type="text" id="paisFaturamento" name="paisFaturamento" placeholder="Pais" />
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control' disabled="disabled" type="text" name="estadoFaturamento" id="estadoFaturamento" placeholder="Estado"  />
                    </div>
                    <div class="form-group col-md-4">
                        <input class='form-control' disabled="disabled" type="text" id="emailFaturamento" name="emailFaturamento" placeholder="Email" />
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control" type="text" id="observacoes" name="observacoes" style="height: 100px;" placeholder="Observação"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <input type="button" class="btn btn-info" value="Salvar" onClick="javascript:sendPost('OSSP/createOutrosCanais','FOSCreateoutrosCanais')" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


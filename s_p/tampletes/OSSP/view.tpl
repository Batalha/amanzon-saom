<div class="container1" style="margin-top: -10px; width:49%; margin-left: 7%;">
    <div class="row">
        {include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}
    </div>
</div>
<br>

<center>

    <form class="form" id="FOSCreate">
        <input type="hidden" name="idOS_reserva" id="idOS_reserva" value="{$obj.idos}"/>
        <input type="hidden" name="idInstalacoes_reserva" id="idInstalacoes_reserva"/>
        <input type="hidden" name="pausa" id="pausa" value="{if isset($pausaid)}{$pausaid}{/if}"/>

        <div id="acoesOs">
            <table class="acoesTable" style="width: 100%; ">
                <tr style=" border-bottom: 1px solid #BABABA; height: 40px;">
                    <td colspan="3">
                        {if $obj.os_status_idos_status != 2}
                            {if isset($obj.rel.instalacoes_sp.idinstalacoes_sp)}
                                {if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 12}
                                    <div class="divInstOk">
                                        {if $login.perfis_idperfis != 3}
                                            Uma <b>VSAT</b> para esta OS já existe, é a {$obj.rel.instalacoes_sp.nome},
                                            <input type="button" class="btn btn-primary" value="Ver Dados da VSAT" onClick="javascript:
                                                            getAjaxForm('Instalacao_sp/view_instalacao','dadosInstal',	{ldelim}param:{$obj.rel.instalacoes_sp.idinstalacoes_sp},ajax:1{rdelim})"
                                            />
                                        {/if}

                                        <!-- COMISSIONAMENTO -->
                                        {if $obj.rel.instalacoes_sp.comiss != 1}
                                            {if $login.perfis_idperfis != 3}

                                                <input type="button" class="btn btn-primary" value="Comissionar" onClick="javascript:
                                                    $.ajax({ldelim} url: 'OSSP/verificaIplanIpdvb/'+{$obj.idos}, async:false {rdelim}).done(function(response)
                                                    {ldelim}
                                                        if(response == 1)
                                                            {ldelim}
                                                                $('#modal').modal('show');
                                                            {rdelim}
                                                        else
                                                            {ldelim}
                                                                if(confirm('Está preparado para Comissionamento?\n Obs.: a partir dessa confirmação o tempo de execução da tarefa começará a ser contabilizado.'))
                                                                    {ldelim}
                                                                        getAjaxForm('Comissionamento_sp/comiss','dadosInstal',
                                                                            {ldelim}
                                                                                param:{$obj.rel.instalacoes_sp.idinstalacoes_sp},
                                                                                ajax:1
                                                                            {rdelim}
                                                                        );
                                                                    {rdelim}
                                                            {rdelim}
                                                    {rdelim})"
                                                />


                                                <div class="modal hide hide" id="modal">
                                                    <form action="s_p/controller/OSSP/edit" method="post" name="edicao_critica_os"
                                                          id="edicao_critica_os">
                                                        <input name="idos" id="idos" type="hidden" value="{$obj.idos}"/>
                                                        <div class="modal-header">
                                                            <a class="close" data-dismiss="modal">×</a>
                                                            <h3>Edição Crítica da OS</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="text-align:left;">Foi verificado que faltam dados para o
                                                                Comissionamento, para dar continuidade preencha o seguinte formulário:</p>
                                                            <div class="span6">
                                                                <div class="span2">IP Lan:</div>
                                                                <div class="span2">
                                                                    <input style="height:30px;" name="iplan" id="iplan"
                                                                           value="{$obj.iplan}"/>
                                                                </div>
                                                                <div class="span2">IP Dvb:</div>
                                                                <div class="span2">
                                                                    <input style="height:30px;" name="ipdvb" id="ipdvb"
                                                                           value="{$obj.ipdvb}"/>
                                                                </div>
                                                            </div>
                                                            <div style="clear:both"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="#" class="btn" data-dismiss="modal">Fechar</a>
                                                            <a href="#" class="btn btn-primary"
                                                               onclick="javascript: sendPost('OSSP/edicao_critica','edicao_critica_os')">Salvar
                                                                Dados</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            {/if}
                                        {else}
                                            {if $login.perfis_idperfis != 3}
                                                <input type="button" class="btn btn-primary" value="Ver Comissionamento" onClick="javascript: guardaReserva({$obj.rel.instalacoes_sp.idinstalacoes_sp},'#idInstalacoes_reserva');
                                                     getAjaxForm('Comissionamento_sp/comiss_view', 'dadosInstal',
                                                     {ldelim}
                                                        param:{$obj.rel.instalacoes_sp.idinstalacoes_sp},ajax:1
                                                     {rdelim})"/>
                                            {/if}
                                        {/if}
                                        {if $obj.empresas_idempresas == 23}
                                            <input type="button" id="veros" class="btn btn-primary" value="OS - Oi/Telefonica"
                                                onclick="return btmenuOS(this);">
                                        {else if $obj.empresas_idempresas == 66}
                                            <input type="button" id="verosAti" class="btn btn-primary" value=" OS - Ati"
                                               onclick="return btmenuOS(this);">
                                        {else}
                                            <input type="button" id="veroutrosos" class="btn btn-primary" value="OS - Outros"
                                                onclick="return btmenuOS(this);">
                                        {/if}
                                        <!-- DATA DE ACEITE -->
                                        {if $login.perfis_idperfis != 3}
                                            <input type="text" style="float:right;width:190px;padding:3px;margin-top:2px;border:1px solid #000;background:#ccc;color:#000;"
                                               value="Data de Aceite: {if $obj.rel.instalacoes_sp.data_aceite!=''}{$obj.rel.instalacoes_sp.data_aceite}{/if}"
                                               readonly="readonly"/>
                                            {if !$pausado}
                                                {if $obj.rel.instalacoes_sp.comiss == 1 && $usuario_permissao == 1}
                                                    {if $obj.rel.instalacoes_sp.data_aceite == ''}
                                                        <input onclick="javascript:getAjaxForm('Instalacao_sp/edit_data_comiss', 'dadosInstal',{ldelim}param:{$obj.rel.instalacoes_sp.idinstalacoes_sp},ajax:1{rdelim})"
                                                            type="button" class="btn btn-primary" style="float:right;margin-right:10px;"
                                                        value="    Data de Aceite  "/>
                                                    {else}
                                                        <input onclick="javascript:getAjaxForm('Instalacao_sp/edit_data_comiss', 'dadosInstal',{ldelim}param:{$obj.rel.instalacoes_sp.idinstalacoes_sp},ajax:1{rdelim})"
                                                            type="button" class="btn btn-primary" style="float:right;margin-right:10px;"
                                                        value="    Mudar Data  "/>
                                                    {/if}
                                                {/if}
                                            {/if}
                                        {/if}
                                    </div>
                                {else}
                                    <div class="divInstOk">
                                        Uma <b>VSAT</b> para esta OS já existe, é a {$obj.rel.instalacoes_sp.nome},
                                    </div>
                                {/if}

                            {else}
                                {if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 12}
                                    <div class="divInstAviso">
                                        {if $login.perfis_idperfis != 3}
                                            Uma <b>VSAT</b> para esta OS ainda não existe, é a {$obj.rel.instalacoes_sp.nome},
                                            <input class="btn btn-primary" type="button" value="Cadastrar dados da VSAT"
                                                   {if isset($obj.rel.agenda_instal_sp.idagenda_instal_sp)}
                                                   onClick="javascript:getAjaxForm('Instalacao_sp/create', 'dadosInstal',{ldelim}param:{$obj.idos},ajax:1{rdelim},getDadosInstalsp,{$obj.idos})"
                                                   {else}
                                                   onClick="javascript:simpleMsg('Nenhuma instalação ao campo foi agendada, portanto os dados da instalação não podem ser preenchidos.')"
                                                   {/if}
                                            />
                                        {/if}
                                        {if $obj.empresas_idempresas == 23}
                                            {if $login.perfis_idperfis != 11}
                                                <input type="button" id="veros" class="btn btn-primary" value=" OS - Oi/Telefonicar"
                                                       onclick="return btmenuOS(this);">
                                            {/if}
                                        {else if $obj.empresas_idempresas == 66}
                                            {if $login.perfis_idperfis != 11}
                                                <input type="button" id="verosAti" class="btn btn-primary" value=" OS - Ati"
                                                       onclick="return btmenuOS(this);">
                                            {/if}
                                        {else}
                                            {if $login.perfis_idperfis != 10}
                                                <input type="button" id="veroutrosos" class="btn btn-primary" value="OS - Outros"
                                                       onclick="return btmenuOS(this);">
                                            {/if}
                                        {/if}
                                    </div>
                                {else}
                                    <div class="divInstAviso">
                                        Uma <b>VSAT</b> para esta OS ainda não existe, é a {$obj.rel.instalacoes_sp.nome},
                                    </div>
                                {/if}
                            {/if}
                        {/if}
                        <!--{if $obj.empresas_idempresas == 23}-->
                            <!--INSTRUÇOES PARA VOLTAR A OS CANCELADO PARA O PERFIL ADMIN-->
                        <!--{/if}-->
                    </td>
                </tr>

                <tr height="40" style=" border-bottom: 1px solid #BABABA;">
                    <td width="14%">
                        {if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 12}
                            <select name="arquivo" id="arquivo" class="form-control" onchange="return btmenuOS(this);">
                                {if $obj.os_status_idos_status != 2}
                                    {if $login.perfis_idperfis != 3 && $login.perfis_idperfis != 7}
                                        <option value="0">Upload de Arquivos</option>
                                        <option value="1">Agendamento</option>
                                        <option value="2">Licença Anatel</option>
                                        <option value="3">Termo Responsabilidade</option>
                                        <option value="4">Relatório Fotográfico</option>
                                    {else}
                                        {if $login.perfis_idperfis == 3}
                                            <option value="0"></option>
                                            <option value="1">Agendamento</option>
                                            <option value="3">Termo Responsabilidade</option>
                                            <option value="4">Relatório Fotográfico</option>
                                        {/if}
                                        {if $login.perfis_idperfis == 7}
                                            <option value="0"></option>
                                            <option value="1">Agendamento</option>
                                            <option value="3">Termo Responsabilidade</option>
                                            <option value="4">Relatório Fotográfico</option>
                                        {else}
                                            <option value="6">Tecnicos</option>
                                        {/if}
                                    {/if}
                                {else}
                                    <option value="5">OS Cancelado</option>
                                {/if}
                            </select>
                        {else}
                            {if $login.perfis_idperfis == 10}
                                <select name="arquivo" id="arquivo" class="form-control" onchange="return btmenuOS(this);">
                                    {if $obj.os_status_idos_status != 2}
                                    <option value="0">Selecione</option>
                                    <option value="1">Agendamento</option>
                                    {/if}
                                </select>
                            {/if}
                        {/if}
                    </td>
                    <td align="left" width="60%">

                        {if $obj.os_status_idos_status != 2}
                        <div id="para"></div>
                        {else}
                        <input type="button" id="veros" class="btn btn-primary" value="OS Oi-Telefonica"
                               onclick="return btmenuOS(this);">
                        {/if}

                    </td>
                    <td>
                        {if $login.perfis_idperfis != 10}
                        {if $obj.rel.instalacoes_sp.comiss != ''}
                        <div align="right">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target=".bs-example-modal-sm">Trocar Responsavel
                            </button>
                        </div>
                        {/if}
                        {/if}
                    </td>
                </tr>
            </table>
        </div>


        <fieldset id="borda">

            <!-- Dados importantes -->
            <div id="dadosOs" hidden="">
                <div class="areaOS">
                    <div id="linha1">
                        <table border="0" class="tableDados">
                            <tr height="25" style="border: 1px solid #000000; padding: 5px;">
                                <td style="border: 1px solid #000"><img src="../public/imagens/logoEMC.png" height="250"
                                                                        width="120"></td>
                                <td width="15%" align="right" style="font-size: 16px;">
                                    <b>{$obj.rel.empresas.empresa}</b></td>
                                <td width="18%" align="right" style="color: #494949 "><b>OS N° :</b></td>
                                <td width="15%">{$obj.numOS}&nbsp;-&nbsp;{$nomeVsat}</b></td>
                                <td style="font-weight: bold; width: 15%;	 color: #494949">Identificador :</td>
                                <td style="width: 80px; ">{$obj.identificador}</td>
                            </tr>
                        </table>
                        {*
                        <table border="1" class="tableDados">*}
                            {*
                            <tr height="25">*}
                                {*
                                <td style="font-weight: bold; color: #494949">Designação :</td>
                                <td width="40%">{$obj.designacao}</td>
                                *}
                                {*
                            </tr>
                            *}
                            {*
                        </table>
                        *}

                    </div>
                    <div id="linha2">
                        <table class="tableDados" border="1">
                            <tr>
                                <td colspan="4" style="font-weight: bold; color: #494949; background-color: #EAEAEA ">
                                    &nbsp;Contato da Instalação
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;" width="15%">Contato :</td>
                                <td width="40%">&nbsp;&nbsp;&nbsp;{$obj.contato}</td>
                                <td align="right" style="font-weight: bold;">CEP :</td>
                                <td>&nbsp;{$obj.cep}</td>
                            </tr>
                            <tr height="16">
                                <td align="right" style="font-weight: bold;">Telefone :</td>
                                <td>&nbsp;&nbsp;&nbsp; {$obj.telContato} | {$obj.outroTelContato}</td>
                                <td align="right" style="font-weight: bold;">Estado :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.estado}</td>


                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Endereço :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.enderecoInstal}</td>
                                <td align="right" style="font-weight: bold;">País :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.pais}</td>

                            </tr>
                            {*
                            <tr>
                                <td align="right" style="font-weight: bold;">Email :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.email}</td>
                            </tr>
                            *}
                            <tr>
                                <td align="right" style="font-weight: bold;">Cidade :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.cidade}</td>
                                <td></td>
                                <td></td>
                            </tr>

                        </table>
                    </div>
                    <div id="linha2" style="margin-top: -10px">
                        <table class="tableDados" border="1">
                            <tr>
                                <td colspan="4" style="font-weight: bold; color: #494949; background-color: #EAEAEA">
                                    &nbsp;Contato de Faturamento
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="17%" align="right" style="font-weight: bold;">País :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.paisFaturamento}</td>
                            </tr>
                            {if $login.perfis_idperfis != 3 }
                            <tr>
                                <td width="17%" align="right" style="font-weight: bold;">Endereço :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.enderecoFaturamento}</td>
                                <td align="right" style="font-weight: bold;">CEP :</td>
                                <td width="25%">&nbsp;{$cliente.cepFaturamento}</td>
                            </tr>
                            {/if}
                            <tr height="16">
                                {if $login.perfis_idperfis != 3 }
                                <td align="right" style="font-weight: bold;">Cidade :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.cidadeFaturamento}</td>
                                <td align="right" style="font-weight: bold;">CNPJ :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.cnpjFaturamento}</td>
                                {/if}


                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Estado :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.estadoFaturamento}</td>
                                <td align="right" style="font-weight: bold;">Prazo Instalação :</td>
                                <td>&nbsp;&nbsp;&nbsp; {$obj.prazoInstal}</td>
                            </tr>
                            <tr>

                                <td align="right" style="font-weight: bold;">Email :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.emailFaturamento}</td>
                                <td align="right" style="font-weight: bold;">Data Instalação :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.dataSolicitacao}</td>
                            </tr>


                        </table>
                    </div>
                    <div id="linha3">
                        <table class="tableDados" border="1">
                            <tr>
                                <td colspan="6" style="font-weight: bold; color: #494949; background-color: #EAEAEA">
                                    &nbsp;Serviços
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                            {*
                            <tr>
                                <td colspan="6" width="17%"><b>Empresa responsavel para instalação</b> :&nbsp;&nbsp;&nbsp;{$obj.rel.empreiteiras}
                                </td>
                            </tr>
                            *}
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="15%" align="" style="font-weight: bold;">CIR. Download :</td>
                                <td width="18%">{$obj.cirDownload}</td>
                                <td width="15%" align="" style="font-weight: bold;">MIR. Download :</td>
                                <td width="18%">{$obj.mirDownload}</td>
                                <td align="" style="font-weight: bold;">MIR. Upload :</td>
                                <td width="18%">{$obj.mirUpload}</td>
                                {*
                                <td width="19%" style="font-weight: bold;">Area de Instalação :</td>
                                <td width="">{$obj.areaInstal}</td>
                                *}
                            </tr>
                            <tr>
                                <td align="" style="font-weight: bold;">CIR. Upload :</td>
                                <td>{$obj.cirUpload}</td>
                                <td align="" style="font-weight: bold;">Mascara :</td>
                                <td>{$obj.mascaraLan}</td>
                                <td align="" style="font-weight: bold;">Telesat Code :</td>
                                <td>{$obj.eutelsat_code}</td>
                                {*
                                <td align="" style="font-weight: bold;">Vel. Upload :</td>
                                <td>{$obj.velUpload}</td>
                                *}

                            </tr>
                            <tr>
                                <td align="" style="font-weight: bold;">Serviço :</td>
                                <td>Satélite</td>
                                <td align="" style="font-weight: bold;">IP Lan :</td>
                                <td>{$obj.iplan}</td>
                                <td align="" style="font-weight: bold;">Ip DVB :</td>
                                <td>{$obj.ipdvb}</td>
                            <tr>
                                {*
                                <td align="" style="font-weight: bold;">Perfil :</td>
                                <td>{$obj.perfil}</td>
                                *}
                                <td align="" style="font-weight: bold;">Padrão :</td>
                                <td>Sem redundância</td>
                                <td align="" style="font-weight: bold;">IP Publico 1 :</td>
                                <td>
                                    {if $obj.iplan1}
                                    {$obj.iplan1} / {$obj.iplanMask1}
                                    {else}
                                    {/if}

                                </td>
                                <td align="" style="font-weight: bold;">IP Publico 2 :</td>
                                <td>
                                    {if $obj.iplan2}
                                    {$obj.iplan2} / {$obj.iplanMask2}
                                    {else}
                                    {/if}

                                </td>
                            </tr>
                            <tr>
                            </tr>

                        </table>
                    </div>

                    <div id="linha4">
                        <table border="1" style="width: 100%;">
                            <tr>
                                <td style="font-weight: bold; background-color: #EAEAEA">Observação :</td>
                            </tr>
                            <tr>
                                <td>{$obj.observacoes}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                {if $obj.os_status_idos_status != 2}
                {if $login.perfis_idperfis != 3 } <!-- para usuarios que não são "Campo" -->

                <input type="button" class="btn btn-primary" value="Editar dados da OS"
                       onClick="javascript:getAjaxForm('OSSP/edit',false,{ldelim}param:{$obj.idos},ajax:1{rdelim})"/>
                <input type="button" class="btn btn-primary" name="cancelaOS" id="cancelaOS" value="Cancelar OS"
                       onClick="javascript:(confirm('Deseja Cancelar essa OS?'))?getAjaxForm('OSSP/cancela',false,{ldelim}param:{$obj.idos},ajax:1{rdelim}):'';"/>

                {/if}
                {if $login.perfis_idperfis != 6}
                {if $login.perfis_idperfis != 3 }
                {if $obj.rel.instalacoes_sp.data_aceite == ''}
                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 }
                {if $pausado}
                <input class="btn btn-primary" type="button" value="Desparalisar OS"
                       onClick="javascript:getAjaxForm('OSSP/caixaDespausa','caixaPausa')"/>&nbsp;Pausado em
                {$dataPausado}
                {else}
                <input class="btn btn-primary" type="button" value="Paralisar OS"
                       onClick="javascript:getAjaxForm('OSSP/caixaPausa','caixaPausa')"/>
                {/if}

                {/if}
                {/if}
                {/if}
                {/if}
                {/if}
            </div>


            <!-- -----Inicio da Outras OS ------ -->

            <div id="dadosOsAti" hidden="">
                <div class="areaOSAti">
                    <div id="linha1">
                        <table border="0" class="tableDados">
                            <tr height="25" style="border: 1px solid #000000; padding: 5px;">
                                <td style="border: 1px solid #000; width: 24%; padding: 10px 10px"><img
                                        src="../public/imagens/logoEMC.png" height="250"
                                        width="120"></td>
                                <td width="20%" align="right" style="font-size: 12px; text-align: center">
                                    <b>{$obj.rel.empresas.empresa}</b></td>
                                <td width="18%" align="right" style="color: #494949 "><b>OS N° :</b></td>
                                <td width="15%">{$obj.numOS}&nbsp;-&nbsp;{$nomeVsat}</b></td>
                                <td style="font-weight: bold; width: 15%;	 color: #494949">Identificador :</td>
                                <td style="width: 80px; ">{$obj.identificador}</td>
                            </tr>
                        </table>
                    </div>
                    <div id="linha2">
                        <table class="tableDados" border="1">
                            <tr>
                                <td colspan="4" style="font-weight: bold; color: #494949; background-color: #EAEAEA ">
                                    &nbsp;Contato da Instalação
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;" width="15%">Orgão :</td>
                                <td width="40%">&nbsp;&nbsp;&nbsp;{$obj.orgao}</td>
                                <td align="right" style="font-weight: bold;">Unidade :</td>
                                <td>&nbsp;{$obj.unidade}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;" width="15%">Tipo Acesso :</td>
                                <td width="40%">&nbsp;&nbsp;&nbsp;{$obj.acesso}</td>
                                <td align="right" style="font-weight: bold;">Inep :</td>
                                <td>&nbsp;{$obj.inep}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;" width="15%">Nome :</td>
                                <td width="40%">&nbsp;&nbsp;&nbsp;{$obj.contato}</td>
                                <td align="right" style="font-weight: bold;">E-mail :</td>
                                <td>&nbsp;{$obj.email}</td>
                            </tr>
                            <tr height="16">
                                <td align="right" style="font-weight: bold;">Telefone :</td>
                                <td>&nbsp;&nbsp;&nbsp; {$obj.telContato} | {$obj.outroTelContato} |
                                    {$obj.outroTelContato2}
                                </td>
                                <td align="right" style="font-weight: bold;">CEP :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.cep}</td>


                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Endereço :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.enderecoInstal}</td>
                                <td align="right" style="font-weight: bold;">Estado :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.estado}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Cidade :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.cidade}</td>
                                <td align="right" style="font-weight: bold;">País :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.pais}</td>
                            </tr>
                        </table>
                    </div>
                    <div id="linha3">
                        <table class="tableDados" border="1">
                            <tr>
                                <td colspan="4" style="font-weight: bold; color: #494949; background-color: #EAEAEA">
                                    &nbsp;Contato de Faturamento
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="17%" align="right" style="font-weight: bold;">País :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.paisFaturamento}</td>
                            </tr>
                            {if $login.perfis_idperfis != 3 }
                            <tr>
                                <td width="17%" align="right" style="font-weight: bold;">Endereço :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.enderecoFaturamento}</td>
                                <td align="right" style="font-weight: bold;">CEP :</td>
                                <td width="25%">&nbsp;{$cliente.cepFaturamento}</td>
                            </tr>
                            {/if}
                            <tr height="16">
                                {if $login.perfis_idperfis != 3 }
                                <td align="right" style="font-weight: bold;">Cidade :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.cidadeFaturamento}</td>
                                <td align="right" style="font-weight: bold;">CNPJ :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.cnpjFaturamento}</td>
                                {/if}


                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Estado :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$cliente.estadoFaturamento}</td>
                                <td align="right" style="font-weight: bold;">Prazo Instalação :</td>
                                <td>&nbsp;&nbsp;&nbsp; {$obj.prazoInstal}</td>
                            </tr>
                            <tr>

                                <td align="right" style="font-weight: bold;">Email :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.emailFaturamento}</td>
                                <td align="right" style="font-weight: bold;">Data Instalação :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.dataSolicitacao}</td>
                            </tr>


                        </table>
                    </div>
                    <div id="linha4">
                        <table class="tableDados" border="1">
                            <tr>
                                <td colspan="6" style="font-weight: bold; color: #494949; background-color: #EAEAEA">
                                    &nbsp;Serviços
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="15%" align="" style="font-weight: bold;">CIR. Download :</td>
                                <td width="18%">{$obj.cirDownload}</td>
                                <td width="15%" align="" style="font-weight: bold;">Area de Instalação :</td>
                                <td width="18%">{$obj.area_instal}</td>
                                <td width="15%" align="" style="font-weight: bold;">Tipo Equip. :</td>
                                <td width="18%">{$obj.tipo_equip}</td>


                            </tr>
                            <tr>
                                <td align="" style="font-weight: bold;">CIR. Upload :</td>
                                <td>{$obj.cirUpload}</td>
                                <td align="" style="font-weight: bold;">End Rede :</td>
                                <td>{$obj.end_rede}</td>
                                <td align="" style="font-weight: bold;">End Lan :</td>
                                <td>{$obj.end_lan}</td>
                            </tr>
                            <tr>
                                <td width="15%" align="" style="font-weight: bold;">MIR. Download :</td>
                                <td width="18%">{$obj.mirDownload}</td>
                                <td align="" style="font-weight: bold;">Wan Fw :</td>
                                <td>{$obj.wan_fw}</td>
                                <td align="" style="font-weight: bold;">Ip Lan fw :</td>
                                <td>{$obj.ip_lan_fw}</td>
                            </tr>
                            <tr>
                                <td align="" style="font-weight: bold;">MIR. Upload :</td>
                                <td width="18%">{$obj.mirUpload}</td>
                                <td style="font-weight: bold;">Router</td>
                                <td>{$obj.router}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>

                    <div id="linha5">
                        <table border="1" style="width: 100%;">
                            <tr>
                                <td style="font-weight: bold; background-color: #EAEAEA">Observação :</td>
                            </tr>
                            <tr>
                                <td>{$obj.observacoes}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                {if $obj.os_status_idos_status != 2}
                {if $login.perfis_idperfis != 3 } <!-- para usuarios que não são "Campo" -->

                <input type="button" class="btn btn-primary" value="Editar dados da OS"
                       onClick="javascript:getAjaxForm('OSSP/editAti',false,{ldelim}param:{$obj.idos},ajax:1{rdelim})"/>

                <input type="button" class="btn btn-primary" name="cancelaOS" id="cancelaOS" value="Cancelar OS"
                       onClick="javascript:(confirm('Deseja Cancelar essa OS?'))?getAjaxForm('OSSP/cancela',false,{ldelim}param:{$obj.idos},ajax:1{rdelim}):'';"/>

                {/if}
                {if $login.perfis_idperfis != 6}
                {if $login.perfis_idperfis != 3 }
                {if $obj.rel.instalacoes_sp.data_aceite == ''}
                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 }
                {if $pausado}
                <input class="btn btn-primary" type="button" value="Desparalisar OS"
                       onClick="javascript:getAjaxForm('OSSP/caixaDespausa','caixaPausa')"/>&nbsp;Pausado em
                {$dataPausado}
                {else}
                <input class="btn btn-primary" type="button" value="Paralisar OS"
                       onClick="javascript:getAjaxForm('OSSP/caixaPausa','caixaPausa')"/>
                {/if}

                {/if}
                {/if}
                {/if}
                {/if}
                {/if}
            </div>

            <!-- -----Inicio da Outras OS ------ -->

            <div id="dadosOutrasOs" hidden="">
                <div class="areaOS">
                    <div id="linha1">
                        <table class="tableDados" border="0">
                            <tr height="25" style="border: 1px solid #000000; padding: 5px;">
                                <td style="border: 1px solid #000"><img src="../public/imagens/logoEMC.png" height="250"
                                                                        width="120"></td>
                                <td width="15%" align="right" style="font-size: 16px;">
                                    <b>{$obj.rel.empresas.empresa}</b></td>
                                <td width="18%" align="right" style="color: #494949 "><b>OS N° :</b></td>
                                <td width="15%">
                                    {if $obj_selecionado}
                                    {$obj_selecionado.num_os_sp}&nbsp;-&nbsp;{$nomeVsat}
                                    {else}
                                    {$obj_atual.num_os_sp}&nbsp;-&nbsp;{$nomeVsat}
                                    {/if}
                                </td>
                                <td width="20%" align="right" style="font-weight: bold;">Data Instalação :</td>
                                <td>&nbsp;&nbsp;&nbsp;{$obj.dataSolicitacao}</td>

                            </tr>
                        </table>
                        <!--{*<table border="1" class="tableDados">*}-->
                        <!--{*<tr height="25">*}-->
                        <!--{*<td style="font-weight: bold; width: 15%;	 color: #494949">Identificador :</td><td style="width: 80px; ">{$obj.identificador}</td>*}-->
                        <!--{*<td style="font-weight: bold; color: #494949">Designação :</td><td width="40%">{$obj.designacao}</td>*}-->
                        <!--{*</tr>*}-->
                        <!--{*</table>*}-->

                    </div>
                    <div id="linha2" style="margin-top: 30px;">
                        <table class="tableDados" border="1">
                            <tr>
                                <td align="center" colspan="4"
                                    style="font-weight: bold; color: #494949; background-color: #EAEAEA ">&nbsp;Contato
                                    da Instalação
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;" width="15%">Contato :</td>
                                <td align="center">{$obj.contato}</td>
                                <td align="right" style="font-weight: bold;">Telefone :</td>
                                <td align="center">{$obj.telContato} | {$obj.outroTelContato}</td>

                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Endereço :</td>
                                <td align="center">{$obj.enderecoInstal}</td>
                                <td align="right" style="font-weight: bold;">Estado :</td>
                                <td align="center">{$obj.estado}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Cidade :</td>
                                <td align="center">{$obj.cidade}</td>
                                <td align="right" style="font-weight: bold;">CEP :</td>
                                <td align="center">{$obj.cep}</td>
                            </tr>
                        </table>
                    </div>

                    <div id="linha3" style="margin-top: -40px; ">
                        <table class="tableDados" border="1">
                            <tr>
                                <td align="center" colspan="4"
                                    style="font-weight: bold; color: #494949; background-color: #EAEAEA">&nbsp;Serviços
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">IP Lan :</td>
                                <td align="center">
                                    {if $obj_selecionado}
                                    {$obj_selecionado.iplan}
                                    {else}
                                    {if $obj_atual.iplan}
                                    {$obj_atual.iplan}
                                    {else}
                                    {$obj.iplan}
                                    {/if}
                                    {/if}
                                </td>
                                <td width="25%" align="right" style="font-weight: bold;">Voip :</td>
                                <td align="center" width="33%">{if
                                    $obj_selecionado}{$obj_selecionado.voip}{else}{$obj_atual.voip}{/if}
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Fornecimento :</td>
                                <td align="center">{$obj.rel.escricao_fornecimento.nome_escricao_forn}</td>
                                <td align="right" style="font-weight: bold;">Satelite :</td>
                                <td align="center">{$obj.rel.satelite.nome_satelite}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">CIR. Download :</td>
                                <td align="center">{if
                                    $obj_selecionado}{$obj_selecionado.cirDownload}{else}{$obj_atual.cirDownload}{/if}
                                </td>
                                <td align="right" style="font-weight: bold;">CIR. Upload :</td>
                                <td align="center">{if
                                    $obj_selecionado.cirUpload}{$obj_selecionado.cirUpload}{else}{$obj_atual.cirUpload}{/if}
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" align="right" style="font-weight: bold;">MIR. Download :</td>
                                <td align="center">{if
                                    $obj_selecionado}{$obj_selecionado.mirDownload}{else}{$obj_atual.mirDownload}{/if}
                                </td>
                                <td align="right" style="font-weight: bold;">MIR. Upload :</td>
                                <td align="center">{if
                                    $obj_selecionado}{$obj_selecionado.mirUpload}{else}{$obj_atual.mirUpload}{/if}
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Mascara :</td>
                                <td align="center">{$obj.mascaraLan}</td>
                                <td align="right" style="font-weight: bold;">Eutesat Code :</td>
                                <td align="center">{$obj.eutelsat_code}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">SpeedNet :</td>
                                <td align="center">
                                    {if $obj_selecionado}
                                    {if $obj_selecionado.speednet == 'sim'}
                                    {$obj_selecionado.speedTipo}
                                    {else}
                                    {$obj_selecionado.speednet}
                                    {/if}
                                    {else}
                                    {if $obj_atual.speednet == 'sim'}
                                    {$obj_atual.speedTipo}
                                    {else}
                                    {$obj_atual.speednet}
                                    {/if}
                                    {/if}
                                </td>
                                <td></td>
                                <td></td>
                            </tr>


                        </table>
                    </div>

                    <div id="linha2" style="margin-top: 20px;">
                        <table class="tableDados" border="1">
                            <tr>
                                <td align="center" colspan="4"
                                    style="font-weight: bold; color: #494949; background-color: #EAEAEA">&nbsp;Contato
                                    de Faturamento
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td width="15%" align="right" style="font-weight: bold;">Empreiteira :</td>
                                <td align="center" width="28%">{$obj.rel.empreiteiras}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Email :</td>
                                <td align="center">&nbsp;&nbsp;&nbsp;{$cliente.emailFaturamento}</td>
                                <td align="right" style="font-weight: bold;">CNPJ :</td>
                                <td align="center">&nbsp;&nbsp;&nbsp;{$cliente.cnpjFaturamento}</td>
                            </tr>
                            <tr>
                                <td align="right" style="font-weight: bold;">Endereço :</td>
                                <td align="center">{$cliente.enderecoFaturamento}</td>
                                <td align="right" style="font-weight: bold;">Estado :</td>
                                <td align="center">{$cliente.estadoFaturamento}</td>
                            </tr>
                            <tr height="16">
                                <td align="right" style="font-weight: bold;">Cidade :</td>
                                <td align="center">{$cliente.cidadeFaturamento}</td>
                                <td align="right" style="font-weight: bold;">CEP :</td>
                                <td align="center">{$cliente.cepFaturamento}</td>
                            </tr>

                        </table>
                    </div>

                    <div id="linha4" style="margin-top: -30px;">
                        <table border="1" style="width: 100%;">
                            <tr>
                                <td align="center" style="font-weight: bold; background-color: #EAEAEA">Observaçoes</td>
                            </tr>
                            <tr>
                                <td>{$obj.observacoes}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                {if $obj.os_status_idos_status != 2}
                {if $login.perfis_idperfis != 3 } <!-- para usuarios que não são "Campo" -->

                <input type="button" class="btn btn-success" value="Atualizaçao"
                       onClick="javascript:getAjaxForm('OSSP/lista_atualizacao_os',false,{ldelim}param:{$obj.idos},ajax:1{rdelim})"/>
                <input type="button" class="btn btn-primary" value="Editar dados da OS"
                       onClick="javascript:getAjaxForm('OSSP/edit_outros_canais',false,{ldelim}param:{$obj.idos},ajax:1{rdelim})"/>
                <input type="button" class="btn btn-primary" name="cancelaOS" id="cancelaOS" value="Cancelar OS"
                       onClick="javascript:(confirm('Deseja Cancelar essa OS?'))?getAjaxForm('OSSP/cancela',false,{ldelim}param:{$obj.idos},ajax:1{rdelim}):'';"/>

                {/if}
                {if $login.perfis_idperfis != 6}
                {if $login.perfis_idperfis != 3 }
                {if $obj.rel.instalacoes_sp.data_aceite == ''}
                {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 }
                {if $pausado}
                <input class="btn btn-primary" type="button" value="Desparalisar OS"
                       onClick="javascript:getAjaxForm('OSSP/caixaDespausa','caixaPausa')"/>&nbsp;Pausado em
                {$dataPausado}
                {else}
                <input class="btn btn-primary" type="button" value="Paralisar OS"
                       onClick="javascript:getAjaxForm('OSSP/caixaPausa','caixaPausa')"/>
                {/if}

                {/if}
                {/if}
                {/if}
                {/if}
                {/if}
            </div>

            <!---Fim de Outras OS ------ -->

        </fieldset>
        <br/>
        <input name="campoDataPausa" id="campoDataPausa" type="hidden" value=""/>
    </form>
    {if $obj.os_status_idos_status != 2}
    <div hidden="">

        {if $login.perfis_idperfis != 6} <!-- para usuários que não "Cliente SP" -->
        <div id="agend">
            {if ! isset($obj.rel.agenda_instal_sp.idagenda_instal_sp)} <!-- Para ausência de agendamento -->
            {if $pausada != 1}
            <div class='divAgendAviso'>de instalação não existe para esta Ordem de Serviço
                {if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 3 || $login.perfis_idperfis == 2 ||
                $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 7 ||
                $login.perfis_idperfis == 11 || $login.perfis_idperfis == 10},
                <input type="button" class="btn btn-primary" value="Agendar instalação"
                       onClick="javascript:getAjaxForm('AgendaInstal_sp/create','dadosInstal',{ldelim}param:{$obj.idos},ajax:1{rdelim})"/>
                {/if}
            </div>
            {/if}
            {/if}

            {if isset($obj.rel.agenda_instal_sp.idagenda_instal_sp)} <!-- Para presença de agendamento -->
            {if $obj.rel.agenda_instal_sp.confirm != 1}
            {if $pausada != 1}
            <div class='divAgendAviso'> já existe para esta OS, mas ainda não foi confirmado
                <input class="btn btn-primary" type="button" value="Ver agendamento"
                       onClick="javascript:getAjaxForm('AgendaInstal_sp/view','dadosInstal',{ldelim}param:{$obj.rel.agenda_instal_sp.idagenda_instal_sp},ajax:1{rdelim})"/>
            </div>
            {/if}
            {else}
            {if $pausada != 1}
            <div class='divAgendOk'> de instalação já existe para esta OS e já foi confirmado
                <input class="btn btn-primary" type="button" value="Ver agendamento"
                       onClick="javascript:getAjaxForm('AgendaInstal_sp/view','dadosInstal',{ldelim}param:{$obj.rel.agenda_instal_sp.idagenda_instal_sp},ajax:1{rdelim})"/>
            </div>
            {/if}
            {/if}
            {/if}
        </div>
        {/if} <!-- 	Fim do login Prfil -->

        <!-- LICENCA ANATEL -->
        {if $login.perfis_idperfis} <!-- para perfis diferentes de "Campo" -->
        <div id="licencaAnatel">
            <div class="divAgendOk">
                <!-- 			<strong>Licença Anatel:</strong>&nbsp; -->
                {if $licenca_anatel == ''}
                Ainda não disponível
                {else}
                <span id="local_arquivo_licenca_anatel">{$licenca_anatel}</span>
                {/if}
                &nbsp;&nbsp;
                <input id="" name="" type="button" value="Enviar Licença Anatel" class="btn btn-primary" onclick="javascript:
                            $.ajax({ldelim}
                                url:'Comissionamento_sp/formulario_upload_licenca_anatel',
                                data:{ldelim}idinstalacao:{$obj.rel.instalacoes_sp.idinstalacoes_sp}{rdelim},
                                type:'POST',
                                success:function(resposta){ldelim}
                                    $('#arquivoInstal').html(resposta);
                                {rdelim}
                            {rdelim});
                        "/>

            </div>
        </div>
        {/if}

        <!-- TERMO RESPONSABILIDADE -->
        <div id="termoResp" style="">

            <div class="divAgendOk">
                <!-- 		<strong>Termo Responsabilidade:</strong>&nbsp; -->
                {if $termo_responsabilidade == ''}
                <span id="local_arquivo_termo_responsabilidade">Ainda não disponível</span>
                {else}
                        <span id="local_arquivo_termo_responsabilidade">
                            <a href="{$termo_responsabilidade.endereco}{$termo_responsabilidade.nome}"
                               style="color:#000;"
                               target="_blank">
                                <i class='icon-file'></i>
                                {$termo_responsabilidade.nome}
                            </a>
                        </span>
                {/if}
                    <span id="btn_apagar_termo_responsabilidade"> <!-- btn para apagar -->
                        {if $termo_responsabilidade != '' && $login.perfis_idperfis == 3 && $termo_responsabilidade.status != 1}
                            <a title="Apagar" onclick="javascript:
                                timeout = new Array(); // apaga timeout's
                                $.ajax({ldelim}
                                    url:'TermoResponsabilidade_sp/apagarTermoDeResponsabilidade',
                                    data:{ldelim}id_termo_responsabilidade:{$termo_responsabilidade.id_termo_responsabilidade}{rdelim},
                                    type:'POST',
                                    success:function( resposta){ldelim}
                                        $('#arquivoInstal').html(resposta);

                                        timeout['tempoRespostaApagar'] = setTimeout(function(){ldelim}
                                            // resgata tipo resposta
                                            var tipoResposta = $('span.alert').attr('class');
                                            tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
                                            console.log(tipoResposta);
                                            // limpa nomes do arquivo
                                            if( tipoResposta != 'error' ){ldelim}
                                                $('#local_arquivo_termo_responsabilidade').html('Ainda não disponível');
                                                $('#btn_apagar_termo_responsabilidade').html('');
                                                $('#status_termo_responsabilidade').html('');
                                            {rdelim}

                                            timeout['tempoApagarAlerta'] = setTimeout(function(){ldelim}// apaga alerta
                                                $('span.alert').fadeOut();
                                            {rdelim},4500);
                                        {rdelim},500); // atualiza status
                                    {rdelim}
                                {rdelim});
                            "><i class="icon-remove"></i></a>
                        {/if}
                    </span>
                &nbsp;&nbsp;
                {if $login.perfis_idperfis == 3 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 ||
                $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 7}
                <!-- formulario de termo de responsabilidade -->
                {if !isset($termo_responsabilidade.status) || $termo_responsabilidade.status != 1}
                <input id="input_termo_responsabilidade" name="input_termo_responsabilidade"
                       type="button" value="Termo de Responsabilidade" class="btn btn-primary" onclick="javascript:
                                timeout = new Array(); // apaga timeout's
                                $.ajax({ldelim}
                                    url:'TermoResponsabilidade_sp/uploadForm',
                                    data:{ldelim}idinstalacao:{$obj.rel.instalacoes_sp.idinstalacoes_sp}{rdelim},
                                    type:'POST',
                                    success:function(resposta){ldelim}
                                        $('#arquivoInstal').html(resposta);
                                    {rdelim}
                                {rdelim});
                            "/>
                {/if}
                {/if}
                &nbsp;&nbsp;
                    <span id="opcoes_aprovacao_termo_responsabilidade">
                    {if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4 }
                        <!-- usuários NOC/COM -->
                        {if $termo_responsabilidade != ''}
                        <!-- aprovar termo -->
                            <input class="btn btn-success" type="button" value="Aprovar"
                                   onclick="javascript:
                                    timeout = new Array(); // apaga timeout's
                                    $.ajax({ldelim}
                                        url:'TermoResponsabilidade_sp/aprovar',
                                        type:'POST',
                                        data:{ldelim}idTermo:{$termo_responsabilidade.id_termo_responsabilidade}{rdelim},
                                        success: function( resposta ){ldelim}
                                            $('#arquivoInstal').html(resposta); // resposta

                                            timeout['tempoResgateTipoResposta'] = setTimeout(function(){ldelim}
                                                // resgata tipo resposta
                                                var tipoResposta = $('span.alert').attr('class');
                                                tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
                                                // atualiza status
                                                if( tipoResposta != 'error' ){ldelim}
                                                    $('#status_termo_responsabilidade').html('Aprovado');
                                                {rdelim}
                                            {rdelim},500); // atualiza status

                                            timeout['tempoAlerta'] = setTimeout(function(){ldelim}
                                                $('.alert').fadeOut();
                                            {rdelim},4000); // some com resposta
                                        {rdelim}
                                    {rdelim});
                                "/>
                            &nbsp;&nbsp;
                        <!-- desaprovar termo -->
                            <input class="btn btn-danger" type="button" value="Desaprovar"
                                   onclick="javascript:
                                    timeout = new Array();
                                    $.ajax({ldelim}
                                        url:'TermoResponsabilidade_sp/desaprovar',
                                        type:'POST',
                                        data:{ldelim}idTermo:{$termo_responsabilidade.id_termo_responsabilidade}{rdelim},
                                        success: function( resposta ){ldelim}
                                            $('#arquivoInstal').html(resposta);

                                            timeout['tempoAlerta'] = setTimeout(function(){ldelim}
                                                $('.alert').fadeOut();
                                            {rdelim},4000);
                                        {rdelim}
                                    {rdelim});
                            "/>
                        {/if}
                    {/if}
                    </span>
                &nbsp;&nbsp;<strong>Status Atual:</strong>&nbsp;
                    <span id="status_termo_responsabilidade">
                    {if $termo_responsabilidade != ''}
                        {if $termo_responsabilidade.status == 0} <!-- aprovacao pendente -->
                            Aprovação Pendente
                        {elseif $termo_responsabilidade.status == 1} <!-- aprovado -->
                            Aprovado
                        {elseif $termo_responsabilidade.status == 2} <!-- desaprovado -->
                            Desaprovado
                        {/if}
                    {/if}
                    </span>

            </div>
        </div>

        <!-- Fim TERMO RESPONSABILIDADE -->

        <!-- RELATORIO FOTOGRAFICO -->
        <div id="relFoto" style="">
            <div class="divAgendOk">
                <!-- 		<strong>Relatório Fotográfico:</strong>&nbsp; -->
                {if $relatorio_fotografico == ''}
                <span id="local_arquivo_relatorio_fotografico">Ainda não disponível</span>
                {else}
                        <span id="local_arquivo_relatorio_fotografico">
                            <a href="{$relatorio_fotografico.endereco}{$relatorio_fotografico.nome}" style="color:#000;"
                               target="_blank">
                                <i class='icon-file'></i>
                                {$relatorio_fotografico.nome}
                            </a>
                        </span>
                {/if}
                    <span id="btn_apagar_relatorio_fotografico"> <!-- btn para apagar -->
                        {if $relatorio_fotografico != '' && $login.perfis_idperfis == 3 && $relatorio_fotografico.status != 1}
                            <a title="Apagar" onclick="javascript:
                                timeout = new Array(); // apaga timeout's
                                $.ajax({ldelim}
                                    url:'RelatorioFotografico_sp/apagarRelatorioFotografico',
                                    data:{ldelim}id_relatorio_fotografico:{$relatorio_fotografico.id_relatorio_fotografico}{rdelim},
                                    type:'POST',
                                    success:function( resposta){ldelim}
                                        $('#arquivoInstal').html(resposta);

                                        timeout['tempoRespostaApagar'] = setTimeout(function(){ldelim}
                                            // resgata tipo resposta
                                            var tipoResposta = $('span.alert').attr('class');
                                            tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
                                            console.log(tipoResposta);
                                            // limpa nomes do arquivo
                                            if( tipoResposta != 'error' ){ldelim}
                                                $('#local_arquivo_relatorio_fotografico').html('Ainda não disponível');
                                                $('#btn_apagar_relatorio_fotografico').html('');
                                                $('#status_relatorio_fotografico').html('');
                                            {rdelim}

                                            timeout['tempoApagarAlerta'] = setTimeout(function(){ldelim}// apaga alerta
                                                $('span.alert').fadeOut();
                                            {rdelim},4500);
                                        {rdelim},500); // atualiza status
                                    {rdelim}
                                {rdelim});
                            "><i class="icon-remove"></i></a>
                        {/if}
                    </span>
                &nbsp;&nbsp;
                {if $login.perfis_idperfis == 3 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 ||
                $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 7}
                <!-- formulario de relatorio fotografico -->
                {if !isset($relatorio_fotografico.status) || $relatorio_fotografico.status != 1}
                <input id="input_relatorio_fotografico" name="input_relatorio_fotografico"
                       type="button" value="Enviar Relatório Fotográfico" class="btn btn-primary" onclick="javascript:
                                timeout = new Array(); // apaga timeout's
                                $.ajax({ldelim}
                                    url:'RelatorioFotografico_sp/uploadForm',
                                    data:{ldelim}idinstalacao:{$obj.rel.instalacoes_sp.idinstalacoes_sp}{rdelim},
                                    type:'POST',
                                    success:function(resposta){ldelim}
                                        $('#arquivoInstal').html(resposta);
                                    {rdelim}
                                {rdelim});
                            "/>
                {/if}
                {/if}
                &nbsp;&nbsp;
                    <span id="opcoes_aprovacao_relatorio_fotografico">
                    {if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4}
                        <!-- usuários NOC/COM -->
                        {if $relatorio_fotografico != ''}
                        <!-- aprovar relatorio -->
                            <input class="btn btn-success" type="button" value="Aprovar"
                                   onclick="javascript:
                                    timeout = new Array(); // apaga timeout's
                                    $.ajax({ldelim}
                                        url:'RelatorioFotografico_sp/aprovar',
                                        type:'POST',
                                        data:{ldelim}idRelatorio:{$relatorio_fotografico.id_relatorio_fotografico}{rdelim},
                                        success: function( resposta ){ldelim}
                                            $('#arquivoInstal').html(resposta); // resposta

                                            timeout['tempoResgateTipoResposta'] = setTimeout(function(){ldelim}
                                                // resgata tipo resposta
                                                var tipoResposta = $('span.alert').attr('class');
                                                tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
                                                // atualiza status
                                                if( tipoResposta != 'error' ){ldelim}
                                                    $('#status_relatorio_fotografico').html('Aprovado');
                                                {rdelim}
                                            {rdelim},500); // atualiza status

                                            timeout['tempoAlerta'] = setTimeout(function(){ldelim}
                                                $('.alert').fadeOut();
                                            {rdelim},4000); // some com resposta
                                        {rdelim}
                                    {rdelim});
                                "/>
                            &nbsp;&nbsp;
                        <!-- desaprovar relatorio -->
                            <input class="btn btn-danger" type="button" value="Desaprovar" value="Desaprovar"
                                   onclick="javascript:
                                    timeout = new Array();
                                    $.ajax({ldelim}
                                        url:'RelatorioFotografico_sp/desaprovar',
                                        type:'POST',
                                        data:{ldelim}idRelatorio:{$relatorio_fotografico.id_relatorio_fotografico}{rdelim},
                                        success: function( resposta ){ldelim}
                                            $('#arquivoInstal').html(resposta);

                                            timeout['tempoAlerta'] = setTimeout(function(){ldelim}
                                                $('.alert').fadeOut();
                                            {rdelim},4000);
                                        {rdelim}
                                    {rdelim});
                                "/>
                        {/if}
                    {/if}
                    </span>
                &nbsp;&nbsp;<strong>Status Atual:</strong>&nbsp;
                    <span id="status_relatorio_fotografico">
                    {if $relatorio_fotografico != ''}
                        {if $relatorio_fotografico.status == 0} <!-- aprovacao pendente -->
                            Aprovação Pendente
                        {elseif $relatorio_fotografico.status == 1} <!-- aprovado -->
                            Aprovado
                        {elseif $relatorio_fotografico.status == 2} <!-- desaprovado -->
                            Desaprovado
                        {/if}
                    {/if}
                    </span>

            </div>
        </div>

        <!-- Fim RELATORIO FOTOGRAFICO -->

    </div>
    <div id="arquivoInstal"></div>
    {else}
    <input style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);text-align:center;"
           type="text" value="OS Cancelada"/>
    {/if}
    <div id="dadosInstal"></div>
    <div id="caixaPausa"></div>
    <div id="idgoogle">
        {if $GoogleMapCoordinates != false}
        <div id="googlemaps" style="width:90%;height:400px;margin:15px auto;border:3px solid #000;"
             lat="{$GoogleMapCoordinates['latitude']}"
             long="{$GoogleMapCoordinates['longitude']}">
        </div>
        {/if}
    </div>
</center>


<div class="modal fade bs-example-modal-sm" id="modal_responsavel_comiss" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de Tecnicos</h4>
            </div>
            <form name="trocar_responsavel" id="trocar_responsavel" action="" method="post">
                <input type="hidden" name="idOS_reserva" id="idOS_reserva" value="{$obj.idos}"/>
                <div class="modal-body">
                    <label for="">Trocar Tecnico Responsavel</label>
                    <select name="resp_user_comiss" id="resp_user_comiss" class="form-control">
                        <option value="">Escolher Tecnico</option>
                        {foreach from=$listaUsuarios item=vez}
                        {if $vez.ativacao == 1 && $vez.incidentes == 1}
                        <option value="{$vez.idusuarios}">{$vez.nome}</option>
                        {/if}
                        {/foreach}
                    </select>
                </div>
                <div class="modal-footer">
                    <div id="resposTrocaResponsavel"></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                            onclick="javascript:
                                $.ajax(
                                    {ldelim}
                                        url:'OSSP/trocaResponsavel',
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

                    >Save changes
                    </button>
                </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>



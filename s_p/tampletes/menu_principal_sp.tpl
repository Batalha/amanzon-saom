<div id="tab">
    <ul>

        <li id="principal" class="item_menu_principal">
            <a onClick="javascript:chama_item_menu_principal( 'principal_sp' , '' , '#home_sp' )"><span>Principal</span></a>
        </li>

        {if !($login.perfis_idperfis != 8 && $login.perfis_idperfis != 10  && $login.perfis_idperfis != 4 && $login.perfis_idperfis != 5)}
            <li id="menu_solicitacoes" class="item_menu_principal">


                <div
                        onmouseover="javascript:
					$('.drop_menu_solicitacoes').css('display','block');"
                        onmouseout="javascript:
					$('.drop_menu_solicitacoes').css('display','none');">

                    <a href="#solicitacao" onClick="javascript:chama_item_menu_principal( 'os_pedido' , 'lista' , '#solicitacao' )">
                        <span>Pedidos</span></a>

                    <div class="drop_menu drop_menu_solicitacoes">

                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os_pedido' , 'create' , '#novopedidoos_sp' )">
                            Pedido OS
                        </div>
                        <!-- 				    																	    menu	 submenu 				-->
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os_pedido' , 'lista' , '#listapedidoos_sp' )">
                            Ver lista de Pedidos
                        </div>
                    </div>
                </div>
            </li>
        {/if}
        {if $login.perfis_idperfis != 8}
            <li id="menu_instalacoes" class="item_menu_principal">

                <div
                        onmouseover="javascript:$('.drop_menu_instalacoes').css('display','block');"
                        onmouseout="javascript: $('.drop_menu_instalacoes').css('display','none');"
                >

                    <a href="#instalacao_sp" onClick="javascript:chama_item_menu_principal( 'os_sp' , 'lista' , '#instalacao_sp' )">
                        <span>Instalações</span></a>
                    <div class="drop_menu drop_menu_instalacoes">
                        {if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 3 && $login.perfis_idperfis != 12}
                            <div
                                    onmouseover="javascript: $('.item_submenu_cadastro').css('display','block');"
                                    onmouseout="javascript: $('.item_submenu_cadastro').css('display','none');"
                            >

                                <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os_sp' , 'create' , '#novaos_sp' )">Cadastrar OS</div>

                                <!--<div class="item_submenu item_submenu_cadastro">-->

                                    <!--<div class="item_drop_submenu"-->
                                         <!--onClick="javascript:chama_item_menu_principal( 'os_sp' , 'create' , '#novaos_sp' )">-->
                                        <!--OS / Oi / Telefonica-->
                                    <!--</div>-->
                                    <!--<div class="item_drop_submenu"-->
                                         <!--onClick="javascript:chama_item_menu_principal( 'os_sp' , 'create_outros_canais' , '#novocanal_sp' )"-->
                                    <!--&gt;-->
                                        <!--Outros Canais-->
                                    <!--</div>-->

                                <!--</div>-->

                            </div>
                        {/if}


                        <!-- 				    		menu	 submenu 				-->
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os_sp' , 'lista' , '#listaos_sp' )">
                            Ver lista de OS</div>
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'agenda_instal_sp' , 'lista' , '#listaagendamentos_sp' )">
                            Agendamentos</div>
                        {if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 12}
                            <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'instalacoes_sp' , 'lista' , '#listainstalacao_sp' )">
                                Instalações</div>

                            {if $login.perfis_idperfis == 4}
                                <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os_sp' , 'eutelsat_code' , '#listeutelsatcode_sp' )">
                                    Codigo Operadora
                                </div>
                            {/if}


                            <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os_sp' , 'monitor' , '#monitor_sp' )">
                                Monitor</div>
                            {if $login.perfis_idperfis != 3}
                                <div class="item_drop_menu" onClick="javascript:window.open('OSSP/relatorioAcompanhamento')">
                                    Relatório Acomp
                                </div>
                            {/if}
                        {/if}

                    </div>
                </div>
            </li>
        {/if}



        {if $login.perfis_idperfis != 3 && $login.perfis_idperfis != 12 }
            <li id="menu_incidentes" class="item_menu_principal">

                <div
                        onmouseover="javascript:
                                $('.drop_menu_incidentes').css('display','block');"
                        onmouseout="javascript:
                                $('.drop_menu_incidentes').css('display','none');">

                    <a href="#listaincidentes_sp" onClick="javascript:chama_item_menu_principal( 'incidentes_sp' , 'lista' , '#listaincidentes_sp' )"><span>Solicitação</span></a>

                    <div class="drop_menu drop_menu_incidentes">
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'incidentes_sp' , 'lista' , '#listaincidentes_sp' )">
                            Lista <!-- de Buc's e Modem's -->
                        </div>

                        {if $login.perfis_idperfis != 8}
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'incidentes_sp' , 'create_sol' , '#novoincidente_sp' )">
                            Criar Ticket
                        </div>
                        {/if}

                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'atend_vsat_sp' , 'lista' , '#listaatendimentos_sp' )">
                            Atendimentos
                        </div>

                        {if $login.perfis_idperfis != 10}
                            <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'relatorio_inci' , 'create_r' , '#relatorio_incidente_sp' )">
                                Relatorio
                            </div>
                        {/if}
                    </div>
                </div>
            </li>
        {/if}


        {if  $login.empresas_idempresas != 2 && $login.perfis_idperfis != 8 && $login.perfis_idperfis !=9 && $login.perfis_idperfis != 12 && $login.perfis_idperfis != 10}
            <li id="menu_acomp" class="item_menu_principal">

                <div
                        onmouseover="javascript:
						$('.drop_menu_acomp').css('display','block');"
                        onmouseout="javascript:
						$('.drop_menu_acomp').css('display','none');">

                    <a href="#acompanhamento_sp" onClick="javascript:chama_item_menu_principal( 'acomp_sp' , 'lista' , '#acompanhamento_sp' )"><span>Acomp.</span></a>

                </div>

            </li>
        {/if}


        <!--
		{if $login.perfis_idperfis == 1 ||
        $login.perfis_idperfis == 5 ||
        $login.perfis_idperfis == 2 ||
        $login.perfis_idperfis == 4}
		    <li><a href="#mudaplano" onClick="getAjaxForm('MudaPlano/liste')"><span>Mudança de Perfil</span></a></li>
		{/if}
		-->

        {if $login.perfis_idperfis == 1 ||
        $login.perfis_idperfis == 5 ||
        $login.perfis_idperfis == 2 ||
        $login.perfis_idperfis == 4}
            <!-- <li><a href="#realocacao" onclick=""><span>Realocação</span></a></li> -->
        {/if}

        <!--
		{if $login.perfis_idperfis == 1 ||
        $login.perfis_idperfis == 5 ||
        $login.perfis_idperfis == 2 ||
        $login.perfis_idperfis == 4}
		    <li><a href="#cancelamento" onClick="getAjaxForm('Cancelamento/liste')"><span>Cancel</span></a></li>
		{/if}
		-->
        {if $login.idusuarios = 23}
            {if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1}
                <li id="menu_equip" class="item_menu_principal">
                    <div
                            onmouseover="javascript:
							$('.drop_menu_equip').css('display','block');"
                            onmouseout="javascript:
							$('.drop_menu_equip').css('display','none');">

                        <a href="#equipamentos_sp" onClick="javascript:chama_item_menu_principal( 'equip_sp' , 'lista' , '#listaequipamentos_sp' )"><span>Equipamentos</span></a>

                        <div class="drop_menu drop_menu_equip">
                            {if $login.idusuarios == 4}
                                <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'equip_sp' , 'create' , '#novoequipamento_sp' );">
                                    Cadastrar
                                </div>
                            {/if}
                            <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'equip_sp' , 'lista' , '#listaequipamentos_sp' )">
                                Lista <!-- de Buc's e Modem's -->
                            </div>

                            <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'locais_equip_sp' , 'lista' , '#listaequipamentos_sp' )">
                                Locais
                            </div>

                        </div>

                    </div>
                </li>
            {/if}
        {/if}
        {if $login.perfis_idperfis == 4}
            <li><a href="#relatorio" onClick="getAjaxForm('Relatorio/index')"><span>Relatórios</span></a></li>
        {/if}


        {if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1}
            <li id="cliente" class="item_menu_principal">

                <div
                        onmouseover="javascript:
						$('.drop_menu_cliente').css('display','block');"
                        onmouseout="javascript:
						$('.drop_menu_cliente').css('display','none');">

                    <a href="#cliente" onClick="javascript:chama_item_menu_principal( 'cliente_sp' , 'lista' , '#cliente' )"><span>Clientes</span></a>

                    <div class="drop_menu drop_menu_cliente">
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'cliente_sp' , 'lista' , '#cliente' )">
                            Listar Clientes
                        </div>

                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'cliente_sp' , 'create' , '#novocliente' )">
                            Cadastrar Cliente
                        </div>
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'cliente_sp' , 'lista_emails' , '#emails' )">
                            E-mails
                        </div>
                    {if $login.perfis_idperfis == 4}
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'cliente_sp' , 'edicao' , '#sla' )">
                            Perfil SLAs
                        </div>
                    {/if}
                    </div>

                </div>

            </li>
        {/if}


        {if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 1}
            <li id="administrar" class="item_menu_principal">

                <div
                        onmouseover="javascript:
						$('.drop_menu_administrar').css('display','block');"
                        onmouseout="javascript:
						$('.drop_menu_administrar').css('display','none');">

                    <a href="#administrar" onClick="javascript:chama_item_menu_principal( 'administrar' , 'lista' , '#administrar' )"><span>Administrar</span></a>

                    <div class="drop_menu drop_menu_administrar">
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'administrar' , 'lista' , '#administrar' )">
                            Ver lista de Usuários
                        </div>

                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'administrar' , 'create' , '#novousuario' )">
                            Cadastrar Usuário
                        </div>
                    </div>

                </div>

            </li>
        {/if}
        {if $login.perfis_idperfis == 4 }

            <li id="interno" class="item_menu_principal">

                <div
                        onmouseover="javascript:
                                $('.drop_menu_interno').css('display','block');"
                        onmouseout="javascript:
                                $('.drop_menu_interno').css('display','none');">

                    <a href="#interno" onClick="javascript:chama_item_menu_principal( 'interno_sp' , 'lista' , '#interno' )"><span>Serv. Interno</span></a>

                    <div class="drop_menu drop_menu_interno">
                        <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'interno_sp' , 'create' , '#novotarefa' )">
                            Terefa
                        </div>
                    </div>

                </div>

            </li>
        {/if}



        {if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4}
            <li><a href="#municipios" onClick="getAjaxForm('Municipio_sp/liste')"><span>Municípios</span></a></li>
        {/if}

        <li id="troca_senha" class="item_menu_principal"><a onClick="chama_item_menu_principal( 'troca_senha' , '' , '#trocasenha' )"><span>Trocar senha</span></a></li>

        <li><a href="Usuario/logout"><span>Sair</span></a></li>

    </ul>
</div>

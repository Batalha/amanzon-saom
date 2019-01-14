
        <div class="btn-group submenu-os-item" >
            <span class="btn btn-inverse" style="width:150px;text-align:right;">OS's:&nbsp;</span>
            {if $login.perfis_idperfis != 3 && $login.perfis_idperfis != 10 && $login.perfis_idperfis != 12}
                <a class="btn" id="li_submenu_novaos_sp" href="#novaos_sp" onClick="javascript:getAjaxForm('OSSP/Create')">Cadastrar OS</a>
            {/if}
            <a class="btn" id="li_submenu_listaos_sp" href="#listaos_sp" onClick="javascript:getAjaxForm('OSSP/liste')">Ver lista de OS{if $login.empresas_idempresas == 1 && $login.perfis_idperfis==3}'s Vodanet{/if}</a>
		   	{if $login.empresas_idempresas == 1 && $login.perfis_idperfis==3}
		    	<a class="btn" id="li_submenu_listatodasos_sp" href="#listatodasos_sp" onclick="javascript:getAjaxForm('OSSP/listaComTerceiroParametro/aceite-1-tudo')">Ver lista de todas OS's</a>
			{/if}
        </div>
        <br>
        {if $login.perfis_idperfis != 10}
            <div class="btn-group submenu-os-item">
                <span class="btn btn-inverse" style="width:150px;text-align:right;">Agendamentos:&nbsp;</span>
                <a class="btn" id="li_submenu_listaagendamentos_sp" href="#listaagendamentos_sp" onClick="javascript:getAjaxForm('AgendaInstal_sp/liste')">Agendamentos</a>
            </div>
            <br>
            {if $login.perfis_idperfis != 12}
                <div class="btn-group submenu-os-item">
                    <span class="btn btn-inverse" style="width:150px;text-align:right;">Instalações:&nbsp;</span>
                    <a class="btn" id="li_submenu_listainstalacao_sp" href="#listainstalacao_sp" onClick="javascript:getAjaxForm('Instalacao_sp/liste')">Instalações</a>
                    {if $login.perfis_idperfis == 4 || ( $login.perfis_idperfis == 5 && $login.subperfil_idsubperfil == 2 ) }
                        <a class="btn" id="li_submenu_listeutelsatcode_sp" href="#listeutelsatcode_sp" onclick="javascript:getAjaxForm('OSSP/eutelsatcode_list')">Codigo Operadora</a>
                    {/if}
                </div>
                <br>
                <div class="btn-group submenu-os-item">
                    {if $login.perfis_idperfis != 3}
                        <span class="btn btn-inverse" style="width:150px;text-align:right;">Relatórios:&nbsp;</span>
                        <a class="btn" id="li_submenu_monitor_sp" href="#monitor_sp" onClick="javascript:getAjaxForm('Monitor')">Monitor</a>
                        {*<a class="btn" id="li_submenu_relatorio_sp" href="OSSP/relatorio">Relatório</a>*}
                        <a class="btn" id="li_submenu_relatorioacompanhamento_sp" href="OSSP/relatorioAcompanhamento">Relatório Acompanhamento</a>
                        {*<a class="btn" id="li_submenu_relatorioanatel_sp" href="#relatorio_anatel_sp" onclick="javascript:getAjaxForm('OSSP/relatorioAnatel')">Relatório Anatel</a>*}
                    {/if}
                </div>
            {/if}
        {/if}

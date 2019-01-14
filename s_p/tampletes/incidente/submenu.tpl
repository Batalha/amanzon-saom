
		<div class="btn-group submenu-incidente-item" >
			<span class="btn btn-inverse" style="width:150px;text-align:right;">Tickets:&nbsp;</span>

            {if $login.perfis_idperfis != 8}
			<a class="btn" id="li_submenu_novoincidente_sp" href="#novoincidente_sp">Criação de Tickets</a>
            {/if}
			<a class="btn" id="li_submenu_listaincidentes_sp" href="#listaincidentes_sp">Lista de Tickets</a>
		</div>
        <br>
        {if $login.perfis_idperfis != 8}
		<div class="btn-group submenu-incidente-item">
			<span class="btn btn-inverse" style="width:150px;text-align:right;">Atendimentos:&nbsp;</span>
			<a class="btn" id="li_submenu_listaatendimentos_sp" href="#listaatendimentos_sp">Atendimentos</a>

		</div>
        {/if}
        <br>
        {if $login.perfis_idperfis != 10 && $login.perfis_idperfis != 8}
            <div class="btn-group submenu-incidente-item">
                <span class="btn btn-inverse" style="width:150px;text-align:right;">Reparos:&nbsp;</span>
                <a class="btn" id="li_submenu_listaatendimentos_sp" href="#listareparos_sp">Lista Reparos</a>
            </div>
            {*<div class="btn-group submenu-incidente-item">*}
                {*<span class="btn btn-inverse" style="width:150px;text-align:right;">Pré-Incidentes:&nbsp;</span>*}
                {*<a class="btn" id="li_submenu_listapreincidentes_sp" href="#listapreincidentes_sp">Pré-Incidentes Prodemge</a>*}
                {*<a class="btn" id="li_submenu_listapreincidentesnagios_sp" href="#listapreincidentesnagios_sp">Pré-Incidentes Nagios</a>*}
            {*</div>*}
            <br>
            <div class="btn-group submenu-incidente-item">
                <span class="btn btn-inverse" style="width:150px;text-align:right;">Relatórios:&nbsp;</span>
                <a class="btn" id="li_submenu_relatorio" target="_blank" href="Incidente_sp/relatorio">Relório</a>
                {*<a class="btn" id="li_submenu_relatorioincidenteinstalacao_sp" target="_blank" href="Relatorio_sp/incidentesPorInstalacao">Relório de Incidentes por Instalação</a>*}
            </div>
        {/if}
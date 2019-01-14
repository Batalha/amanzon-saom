

<div id="submenu_os">
    
	<div class="btn-group submenu-os-item">

	<span class="btn btn-inverse" style="width:150px;text-align:right;">OS's:&nbsp;</span>

    {if $login.perfis_idperfis != 3}
        <a class="btn" id="li_submenu_novopedidoos_sp" href="#novopedidoos_sp" onClick="javascript:getAjaxForm('OsPedido/create')">Cadastrar Pedido OS</a>
    {/if}    
   	
   	<a class="btn" id="li_submenu_listapedidoos_sp" href="#listapedidoos_sp" onClick="javascript:getAjaxForm('OsPedido/lista')">Ver lista de Pedido OS</a>
   	
   	{if $login.perfis_idperfis != 8}
   	
		   	{if $login.empresas_idempresas == 1 && $login.perfis_idperfis==3}
		    	<a class="btn" id="li_submenu_listatodasoss" href="#listatodasoss" onclick="javascript:getAjaxForm('OS/listaComTerceiroParametro/aceite-1-tudo')">Ver lista de todas OS's</a>
			{/if}

		</div>

		<div class="btn-group submenu-os-item">

			<span class="btn btn-inverse" style="width:150px;text-align:right;">Agendamentos:&nbsp;</span>
		    
		    <a class="btn" id="li_submenu_listaagendamentos" href="#listaagendamentos" onClick="javascript:getAjaxForm('AgendaInstal/liste')">Agendamentos</a>

		</div>

		<div class="btn-group submenu-os-item">
		    
		    <span class="btn btn-inverse" style="width:150px;text-align:right;">Instalações:&nbsp;</span>

		    <a class="btn" id="li_submenu_listainstalacao" href="#listainstalacao" onClick="javascript:getAjaxForm('Instalacao/liste')">Instalações</a>
		    
		    {if $login.perfis_idperfis == 4 || ( $login.perfis_idperfis == 5 && $login.subperfil_idsubperfil == 2 ) }
		    	<a class="btn" id="li_submenu_listeutelsatcode" href="#listeutelsatcode" onclick="javascript:getAjaxForm('OS/eutelsatcode_list')">Eutelsat Code</a>
		    {/if}
	    
		</div>

		<div class="btn-group submenu-os-item">

			<span class="btn btn-inverse" style="width:150px;text-align:right;">Relatórios:&nbsp;</span>

		    {if $login.perfis_idperfis != 3}
		        <a class="btn" id="li_submenu_monitor" href="#monitor" onClick="javascript:getAjaxForm('Monitor')">Monitor</a>
		        <a class="btn" id="li_submenu_relatorio" href="OS/relatorio">Relatório</a>
		        <a class="btn" id="li_submenu_relatorioacompanhamento" href="OS/relatorioAcompanhamento">Relatório Acompanhamento</a>
		    {/if}
		    
		    <a class="btn" id="li_submenu_relatorioanatel" href="#relatorio_anatel" onclick="javascript:getAjaxForm('OS/relatorioAnatel')">Relatório Anatel</a>
	    
	{/if}

	</div>
</div>
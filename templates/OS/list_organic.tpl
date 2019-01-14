<div class="container1" style="margin-top: -10px; margin-left: 7%;">
	<div class="row">
		{include file="OS/submenu.tpl" title=submenu}
	</div>
</div>
<br>


<center>

	<table id="flexmeOS"></table>

</center>

	<div class='fDiv' style="display:none">
		<div class='filtros_flexigrid divFiltro_identificador'>
			<input class="input_filtros" type='text' id='filtro_identificador' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_os_numOS'>
			<input class="input_filtros" type='text' id='filtro_os_numOS' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_instalacoes_vsat'>
			<input class="input_filtros" type='text' id='filtro_instalacoes_vsat' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_municipios_municipio'>
			<input class="input_filtros" type='text' id='filtro_municipios_municipio' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_municipios_macroregiao'>
			<input class="input_filtros" type='text' id='filtro_municipios_macroregiao' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_os_prazoInstal'>
			<input class="input_filtros" type='text' id='filtro_os_prazoInstal' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_os_dataSolicitacao'>
			<input class="input_filtros" type='text' id='filtro_os_dataSolicitacao' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_os_empresas_idempresas'>
			<input class="input_filtros" type='text' id='filtro_os_empresas_idempresas' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_agendamento'>
			<input class="input_filtros" type='text' id='filtro_agendamento' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_comiss'>
			<input class="input_filtros" type='text' id='filtro_comiss' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_vsatCriada'>
			<input class="input_filtros" type='text' id='filtro_vsatCriada' style='width:100%;' />
		</div>
		<!-- <div class='filtros_flexigrid divFiltro_codAnatel'>
			<input class="input_filtros" type='text' id='filtro_codAnatel' style='width:100%;' />
		</div> -->
		<div class='filtros_flexigrid divFiltro_aceiteProdemge'>
			<input class="input_filtros" type='text' id='filtro_aceiteProdemge' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_paralisado'>
			<input class="input_filtros" type='text' id='filtro_paralisado' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_termo_responsabilidade'>
			<input class="input_filtros" type='text' id='filtro_termo_responsabilidade' style='width:100%;' />
		</div>
		<div style='clear:both;width:0px;height:0px;'>&nbsp;</div>
	</div>

<!--<div class='fDiv' style="display:none">-->
	<!--<div class='filtros_flexigrid divFiltro_identificador'>-->
		<!--<input class="input_filtros" type='text' id='filtro_identificador' value="{$identificador}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_os_numOS'>-->
		<!--<input class="input_filtros" type='text' id='filtro_os_numOS' value="{$os_numOS}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_instalacoes_vsat'>-->
		<!--<input class="input_filtros" type='text' id='filtro_instalacoes_vsat' value="{$instalacoes_vsat}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_municipios_municipio'>-->
		<!--<input class="input_filtros" type='text' id='filtro_municipios_municipio' value="{$municipios_municipio}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_municipios_macroregiao'>-->
		<!--<input class="input_filtros" type='text' id='filtro_municipios_macroregiao' value="{$municipios_macroregiao}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_os_prazoInstal'>-->
		<!--<input class="input_filtros" type='text' id='filtro_os_prazoInstal' value="{$os_prazoInstal}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_os_dataSolicitacao'>-->
		<!--<input class="input_filtros" type='text' id='filtro_os_dataSolicitacao' value="{$os_dataSolicitacao}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_os_empresas_idempresas'>-->
		<!--<input class="input_filtros" type='text' id='filtro_os_empresas_idempresas'  value="{$os_empresas_idempresas}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_agendamento'>-->
		<!--<input class="input_filtros" type='text' id='filtro_agendamento' value="{$agendamento}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_comiss'>-->
		<!--<input class="input_filtros" type='text' id='filtro_comiss' value="{$comiss}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_vsatCriada'>-->
		<!--<input class="input_filtros" type='text' id='filtro_vsatCriada' value="{$vsatCriada}" style='width:100%;' />-->
	<!--</div>-->
	<!--&lt;!&ndash; <div class='filtros_flexigrid divFiltro_codAnatel'>-->
        <!--<input class="input_filtros" type='text' id='filtro_codAnatel' style='width:100%;' />-->
    <!--</div> &ndash;&gt;-->
	<!--<div class='filtros_flexigrid divFiltro_aceiteProdemge'>-->
		<!--<input class="input_filtros" type='text' id='filtro_aceiteProdemge' value="{$aceiteProdemge}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_paralisado'>-->
		<!--<input class="input_filtros" type='text' id='filtro_paralisado' value="{$paralisado}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div class='filtros_flexigrid divFiltro_termo_responsabilidade'>-->
		<!--<input class="input_filtros" type='text' id='filtro_termo_responsabilidade' value="{$termo_responsabilidade}" style='width:100%;' />-->
	<!--</div>-->
	<!--<div style='clear:both;width:0px;height:0px;'>&nbsp;</div>-->
<!--</div>-->
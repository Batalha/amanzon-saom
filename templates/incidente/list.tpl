<div class="container1" style="margin-left: 7%;">
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>
<br>
<center>

	{*<div id="incidentes_menu">*}
		{*{include file="incidente/submenu.tpl" title=submenu}*}
	{*</div>*}

	{*<div id="flexmeIncidentes"></div>*}

	<div id="incidentes_ambiente">

		<table id="flexmeIncidentes"></table>

		<div class='fDiv' style="display:none">
			<div class='filtros_flexigrid divFiltro_idincidentes'>
				<input class="input_filtros" type='text' id='filtro_idincidentes' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_instalacoes_nome'>
				<input class="input_filtros" type='text' id='filtro_nome_instalacao' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_data'>
				<input class="input_filtros" type='text' id='filtro_data' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_prioridade'>
				<input class="input_filtros" type='text' id='filtro_prioridade' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_descricao'>
				<input class="input_filtros" type='text' id='filtro_descricao' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_data_final'>
				<input class="input_data_final" type='text' id='filtro_data_final' style='width:100%;' readonly="readonly"/>
			</div>
			<div class='filtros_flexigrid divFiltro_atendimento'>
				<input class="input_filtros" type='text' id='filtro_ultimoAtendimento' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_idprodemge'>
				<input class="input_filtros" type='text' id='filtro_numero_prodemge' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_status'>
				<input class="input_filtros" type='text' id='filtro_status' style='width:100%;' />
			</div>
			<div class='filtros_flexigrid divFiltro_nomeTecnico'>
				<input class="input_filtros" type='text' id='filtro_nomeTecnico' style='width:100%;' />
			</div>
			<div style='clear:both;width:0px;height:0px;'>&nbsp;</div>
		</div>

	</div>


</center>
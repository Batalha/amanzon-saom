<div class="container1" style="margin-top: 0px; margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/incidente/submenu.tpl" title=submenu}
	</div>
</div>
<br>
<center>

	<div id="incidentes_ambiente">

		<table id="flexmeIncidentessp"></table>

		<div class='fDiv' style="display:none">
			<div class='filtros_flexigrid divFiltro_idincidentes'>
				<input class="input_filtros" type='text' id='filtro_idincidentes' value="{$idincidentes}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);"-->
			</div>
			<div class='filtros_flexigrid divFiltro_nome_instalacao'>
				<input class="input_filtros" type='text' id='filtro_nome_instalacao' value="{$nome_instalacao}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>
			<div class='filtros_flexigrid divFiltro_solicitacao'>
				<input class="input_filtros" type='text' id='filtro_solicitacao' value="{$solicitacao}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>
			<div class='filtros_flexigrid divFiltro_data'>
				<input class="input_filtros" type='text' id='filtro_data' value="{$data}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>
			<div class='filtros_flexigrid divFiltro_prioridade'>
				<input class="input_filtros" type='text' id='filtro_prioridade' value="{$prioridade}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>
			<div class='filtros_flexigrid divFiltro_descricao'>
				<input class="input_filtros" type='text' id='filtro_descricao' value="{$descricao}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>
			<div class='filtros_flexigrid divFiltro_data_final'>
				<input class="input_data_final" type='text' id='filtro_data_final' value="{$data_final}"
					   style='width:100%;' readonly="readonly"/>
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>

			<div class='filtros_flexigrid divFiltro_status'>
				<input class="input_filtros" type='text' id='filtro_status' value="{$status}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);"-->
			</div>
			<div class='filtros_flexigrid divFiltro_nomeTecnico'>
				<input class="input_filtros" type='text' id='filtro_nomeTecnico' value="{$nomeTecnico}"
					   style='width:100%;' />
					   <!--onfocus="javascript:com_espaco(this);" -->
			</div>
			<div style='clear:both;width:0px;height:0px;'>&nbsp;</div>
		</div>

	</div>

</center>
<br>
<br>
<br>
<br>
<br>
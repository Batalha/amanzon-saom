
<center>
{include file="incidente/submenu.tpl" title=submenu}

	<table id="flexmeListChamadosFull"></table>

</center>

	<!-- 
		'atualizacao' serve para evitar que o sistema atualize 
		mais de 1 vez o refresh automatico da lista de chamados 
	-->
	<input type="hidden" name="atualizacao" id="atualizacao" value="" />

	<div class='fDiv' style="display:none">
		<div class='filtros_flexigrid divFiltro_atendimento'>
			<input class="input_filtros" type='text' id='filtro_atendimento' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_incidente'>
			<input class="input_filtros" type='text' id='filtro_incidente' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_vsat'>
			<input class="input_filtros" type='text' id='filtro_vsat' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_tecnico'>
			<input class="input_filtros" type='text' id='filtro_tecnico' style='width:100%;' />
		</div>
		<div class='filtros_flexigrid divFiltro_status'>
			<input class="input_filtros" type='text' id='filtro_status' style='width:100%;' />
		</div>
		
		<div style='clear:both;width:0px;height:0px;'>&nbsp;</div>
	</div>
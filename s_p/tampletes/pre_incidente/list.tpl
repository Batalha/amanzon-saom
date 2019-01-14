<div class="container1" style="margin-top: 0px; margin-left: 7%;">
	<div class="row">
		{include file="s_p/tampletes/incidente/submenu.tpl" title=submenu}
	</div>
</div>
<br>
<center>
	
	<div>
		<div class="btn btn-alert" 
			onclick="javascript:
				$.ajax({ldelim}
					url:'http://saom.vodanet-telecom.com/cron_resgateEmailIncidentesProdemgeParaComBh.php',
					success:function( resposta ){ldelim}
						$('#resposta_verificacao_email').html( resposta );
						setTimeout(function(){ldelim}
							$('#informe_resultado').fadeOut();
						{rdelim},3000);
					{rdelim}
				{rdelim});
			"><i class="icon-repeat"></i>&nbsp;&nbsp;Buscar Emails</div>
	</div>
	<div  id="resposta_verificacao_email"></div>
	<div style="height:15px;">&nbsp;</div>

	<table id="flexmePreIncidentessp"></table>

</center>

<div class='fDiv' style="display: none">
	<div class='filtros_flexigrid divFiltro_id_pre_incidentes' style="width: 54px;">
		<input class="input_filtros" type='text' id='filtro_id_pre_incidentes' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_id_prodemge' style="width: 114px;">
		<input class="input_filtros" type='text' id='filtro_id_prodemge' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_id_cliente' style="width: 69px;">
		<input class="input_filtros" type='text' id='filtro_id_cliente' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_prazo_limite' style="width: 99px;">
		<input class="input_filtros" type='text' id='filtro_prazo_limite' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_designacao' style="width: 129px;">
		<input class="input_filtros" type='text' id='filtro_designacao' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_responsavel' style="width: 109px;">
		<input class="input_filtros" type='text' id='filtro_responsavel' style='width: 100%;' />
	</div>
	<div style='clear: both; width: 0px; height: 0px;'>&nbsp;</div>
</div>


<!-- MODAL -->
<div class="modal hide fade" id="modalPreIncidentes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Selecionar Responsável</h3>
	</div>
	
	<div class="modal-body">
		
		<div id="modalConteudo">
			
		</div>
		
	</div>
	
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>

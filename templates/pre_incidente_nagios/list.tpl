<div class="container1" style="margin-top: 0px;>
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>

<br>

<center>
	
	<div>
		<div class="btn btn-alert" 
			onclick="javascript:
				$.ajax({ldelim}
					url:'http://saom.vodanet-telecom.com/cron_resgateEmailIncidentesNagiosParaNagios.php',
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

	<table id="flexmePreIncidentesNagios"></table>

</center>

<div class='fDiv' style="display: none">
	<div class='filtros_flexigrid divFiltro_id_pre_incidentes_nagios' style="width:101px;">
		<input class="input_filtros" type='text' id='filtro_id_pre_incidentes_nagios' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid endereco' style="width:126px;">
		<input class="input_filtros" type='text' id='filtro_endereco' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_vsat' style="width:126px;">
		<input class="input_filtros" type='text' id='filtro_vsat' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_data_evento' style="width:116px;">
		<input class="input_filtros" type='text' id='filtro_data_evento' style='width: 100%;' />
	</div>
	<div class='filtros_flexigrid divFiltro_nome_responsavel' style="width:106px;">
		<input class="input_filtros" type='text' id='filtro_nome_responsavel' style='width: 100%;' />
	</div>
	<div style='clear: both; width: 0px; height: 0px;'>&nbsp;</div>
</div>


<!-- MODAL -->
<div class="modal hide fade" id="modalPreIncidentesNagios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<!-- MODAL - historico -->
<div class="modal hide fade" id="modalPreIncidentesNagiosHistorico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Histórico</h3>
	</div>
	
	<div class="modal-body">
		
		<div id="modalConteudoHistorico">
			
		</div>
		
	</div>
	
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>

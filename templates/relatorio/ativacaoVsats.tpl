
{include file="relatorio/submenu.tpl"}

<div class="container">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#relatorio_dia" data-toggle="tab">Ativações por Dia</a></li>
		<li><a href="#relatorio_periodo" data-toggle="tab">Ativações por Período</a></li>
	</ul>

	<div class="tab-content">
	
		<!-- -----------------------------------------------------
			RELATORIO DIA 
		----------------------------------------------------- -->
		<div class="tab-pane active" id="relatorio_dia">
		
			<form class="form" onsubmit="javascript:return false;">
			<div class="span3">
				Data:&nbsp;<input 
					type="text" 
					name="data_lista_nova" 
					id="data_lista_nova" 
					value="{$data_parametro}"
					onkeyup="javascript:
						if(event.keyCode == 13){
							enviaBuscaDia();
						}
					"
					style="width:100px;"
				/>
			</div>
			<div class="span2">
				<input 
					type="button" 
					class="btn" 
					name="busca_nova_lista" 
					id="busca_nova_lista" 
					value="Atualizar"
					onclick="javascript:enviaBuscaDia()"
				/>
			</div>
			<div class="span2">
				<input 
					type="button" 
					class="btn" 
					name="busca_nova_lista" 
					id="busca_nova_lista" 
					value="Gerar Arquivo CSV"
					onclick="javascript:"
				/>
			</div>
			</form>
			
			<div class="cleaner"></div>
			
			<div id="local_lista_dia">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nome Vsat</th>
							<th>Data Ativação</th>
							<th>Data Agendamento</th>
							<th>Data Aceite Prodemge</th>
						</tr>
					</thead>
					
					<tbody>
						{foreach from=$lista item=item}
						    <tr>
								<td>{$item.nome}</td>
								<td>{$item.data_ativacao}</td>
								<td>{$item.data_agendamento}</td>
								<td>{$item.aceite_prodemge}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
			
		</div>
		
		<!-- -----------------------------------------------------
			RELATORIO PERIODO 
		----------------------------------------------------- -->
		<div class="tab-pane" id="relatorio_periodo">
			
			<form class="form" onsubmit="javascript:return false;">
			<div class="span4">
				Começo:&nbsp;<input 
					type="text" 
					name="data_lista_nova" 
					id="data_lista_nova" 
					value="{$data_parametro}"
					onkeyup="javascript:
						if(event.keyCode == 13){
							enviaBuscaPeriodo();
						}
					"
					style="width:90px;"
				/>&nbsp;&nbsp;
				Fim:&nbsp;<input 
					type="text" 
					name="data_lista_nova" 
					id="data_lista_nova" 
					value="{$data_parametro}"
					onkeyup="javascript:
						if(event.keyCode == 13){
							enviaBuscaPeriodo();
						}
					"
					style="width:90px;"
				/>
			</div>
			<div class="span2">
				<input 
					type="button" 
					class="btn" 
					name="busca_nova_lista" 
					id="busca_nova_lista" 
					value="Atualizar"
					onclick="javascript:enviaBuscaPeriodo()"
				/>
			</div>
			<div class="span2">
				<input 
					type="button" 
					class="btn" 
					name="busca_nova_lista" 
					id="busca_nova_lista" 
					value="Gerar Arquivo CSV"
					onclick="javascript:"
				/>
			</div>
			</form>
			
			<div class="cleaner"></div>
			
			<div id="local_lista_dia">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nome Vsat</th>
							<th>Data Ativação</th>
							<th>Data Agendamento</th>
							<th>Data Aceite Prodemge</th>
						</tr>
					</thead>
					
					<tbody>
						{foreach from=$lista item=item}
						    <tr>
								<td>{$item.nome}</td>
								<td>{$item.data_ativacao}</td>
								<td>{$item.data_agendamento}</td>
								<td>{$item.aceite_prodemge}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	
</div>



<div class="container1" style=" margin-left: 7%;">
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}

	</div>
</div>
<br>
<div class="container1" style="width: 70%;">
	<form action="Instalacao/edit" method="PobjT" id="FobjCreate" class="form" >
		<input type="hidden" name="incidenteID_reserva" id="incidenteID_reserva" value="{$obj.idincidentes}" />
		<input type="hidden" name="status" id="status" value="{$status}" />
		<div class="row" style="height: 200px; font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 14px;" >
			<div class="form-group col-md-7" >
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title text-center">Incidente N° {$obj.idincidentes}</div>
					</div>
					<div class="panel-body" style="padding: 0px;">
						<table class="table table-bordered" style="width: 100%">
							<tr><td colspan="2"><b>Téncico NOC responsável:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$tecnicoResponsavel.nome}</td></tr>
							<tr><td width="30%"><b>Prioridade :</b></td><td>{$obj.prioridade}</td></tr>
							<tr><td><b>Data :</b></td><td>{$obj.data}</td></tr>
							<tr>
								<td><b>Solicitacao :</b></td><td>{$obj.solicitacao}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="form-group col-md-5">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title text-center">Cronômetro</div>
					</div>
					<div class="panel-body" style="padding: 0px;">
						<table class="table table-bordered" style="width: 100%">
							<tr height="15px">
								<td><b>Inicio Tarefa :</b></td><td>{$cronometro.inicio_tarefa}</td>
							</tr>
							<tr>
								<td><b>Final Tarefa :</b></td><td>
									{if $cronometro.final_tarefa != '0000-00-00 00:00:00' && $cronometro.final_tarefa != '00/00/0000 00:00:00'}
										{$cronometro.final_tarefa}
									{/if}

								</td>
							</tr>
							<tr height="70px">
								<td colspan="2">
									<span id="tempoTranscorrido" class="cronometrofont">
										<input class="form-control input-lg" type="text" value="{$tempoTranscorrido}" readonly="readonly">

									</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 14px;"">
		<div class="form-group col-md-12">
			<div class="panel panel-primary" style="margin-top: -25px;">
				<div class="panel-body" style="padding: 0px;">
					<table class="table table-bordered">
						<tr>
							<td width="20%"><b>VSAT’s :</b></td>
							<td>
								{foreach from=$obj.instalacoes item=instalacao}
									{$instalacao.nome} <b> / </b>
								{/foreach}

							</td>
						</tr>
						<tr>
							<td><b>Descrição :</b></td>
							<td style="font-size: 11px; padding: 15px 10px 20px 20px;">{$obj.descricao}</td>
						</tr>
					</table>
				</div>
			</div>

		</div>
</div>
<div class="row text-center">
	{if $login.perfis_idperfis != 3 || $login.empresas_idempresas == 1}
		<input type="button" class="btn btn-primary" value="Editar Incidentes" onClick="javascript:getAjaxForm('Incidente/edit',false,{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" />
		<input type="button" class="btn btn-primary" value="Atendimentos" onClick="javascript:getAjaxForm('AtendVsat/listeAtendsIncidente','divDinamico',{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" />

	{/if}
</div>
</form>
</div>


<div id="divDinamico">
	{if isset($atendimento.idatend_vsat)}
		<div class="container1" style="width: 70%;">
			<form action="AgendaInstal_sp/create" method="POST" id="fAtEdit" class="form" >
				<input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$atendimento.idatend_vsat}"/>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title text-center">Último Atendimento</div>
					</div>
					<div class="panel-body" style="padding: 0px; margin-top: 0px;">
						<div class="row">
								<table class="table table-bordered">
									<tr>
										<td colspan="3">
											<button type="button" class="btn btn-success" onclick="javascript:getAjaxForm('AtendVsat/edit','divDinamico',{ldelim}param:{$atendimento.idatend_vsat},ajax:1{rdelim})">
												Editar Atendimento
											</button>
										</td>
									</tr>
									<tr>
										<td><b>Status do Atendimento:</b></td>
										<td>
											{if $atendimento.status_atend_idstatus_atend == 1}Aberto{/if}
											{if $atendimento.status_atend_idstatus_atend == 2}Em Atendimento{/if}
											{if $atendimento.status_atend_idstatus_atend == 3}Finalizado{/if}
										</td>
									</tr>

									<tr>
										<td><b>Atendimentos:</b></td>
										<td>{$atendimento.atendimento}</td>
									</tr>

								</table>
						</div>
					</div>
				</div>
			</form>
		</div>
	{else}
		<div id="caixaReservaParaListagem"></div>
	{/if}
</div>




{*<center>*}
{*{include file="incidente/submenu.tpl" title=submenu}*}
{*<form action="Instalacao/edit" method="PobjT" id="FobjCreate" class="form" >*}
	{*<fieldset>*}
    {*<div id="topDadosInstal" align="left">*}
    	{*<table class="tableDados">*}
    		{*<tr>*}
    			{*<td><label><b><font color="#ffffff" size="2.9">&nbsp; Incidente N° {$obj.idincidentes}</B></font></b></label></td>    			*}
    		{*</tr>*}
    	{*</table>*}
    {*</div>*}
    {*<br />*}
   	{*<!-- Dados Importantes -->*}
    {*<input type="hidden" name="incidenteID_reserva" id="incidenteID_reserva" value="{$obj.idincidentes}" />*}
    {*<input type="hidden" name="status" id="status" value="{$status}" />*}
    {**}
    {*<div class="incContener">*}
    	{*<div class="dadoIncidente">*}
    		{*<table  class="incTable">*}
    			{*<tr>*}
    			{*<td align="left" width="60%" valign="top">*}
		    		{*<table class="incTable1" border="1" style="width: 100%">*}
		    			{*<tr><td colspan="2"><b>Téncico NOC responsável:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$tecnicoResponsavel.nome}</td></tr>*}
		    			{*<tr><td width="30%"><b>Prioridade :</b></td><td>{$obj.prioridade}</td></tr>*}
		    			{*<tr><td><b>Data :</b></td><td>{$obj.data}</td></tr>*}
		    			{*<tr><td><b>ID Prodenge :</b></td>*}
		    			{*<td>*}
		    				{*{foreach from=$obj.prodemge item=numP }*}
		                	 {*{$numP.numero_prodemge} <b> / </b> *}
		                	{*{/foreach}*}
		    			{*</tr>*}
		    		{*</table>*}
    			{**}
    			{*</td>*}
    			{*<td valign="top" width="40%">*}
		    		{*<table class="incTable1" border="1" style="width: 100%">*}
		    			{*<tr><td colspan="2" align="center"><h3>Cronômetro<h3></td></tr>*}
		    			{*<tr height="15px"><td><b>Inicio Tarefa :</b></td><td>{$cronometro.inicio_tarefa}</td></tr>*}
		    			{*<tr><td><b>Final Tarefa :</b></td><td>*}
						{*{if $cronometro.final_tarefa != '0000-00-00 00:00:00' && $cronometro.final_tarefa != '00/00/0000 00:00:00'}*}
							{*{$cronometro.final_tarefa}*}
						{*{/if}		    			*}
		    			{**}
		    			{*</td></tr>*}
		    			{*<tr height="15px"><td colspan="2"> *}
		    			{*<b>Tempo Transcorrido :</b>*}
		    			{*<span id="tempoTranscorrido" class="cronometrofont">*}
								{*{$tempoTranscorrido}*}
		    			{*</span>*}

		    			{*</td></tr>*}
		    		{*</table>*}
    			{**}
    			{*</td>*}
    			{*</tr>*}
    		{*</table>*}
    	{*</div>*}
    	{*<div class="vsatIncidente">*}
 			{*<table border="1" class="incTable incTable1">*}
	 			{*<tr><td style="width: 18%; padding-top: 5px;" valign="top"><b>VSAT’s :</b></td>*}
	    			{*<td>	    *}
		                	{*{foreach from=$obj.instalacoes item=instalacao}*}
		                	 {*{$instalacao.nome} <b> / </b> *}
		                	{*{/foreach}*}

		            {*</td>*}
	            {*</tr>*}
	            {*<tr>*}
	            	{*<td><b>Descrição :</b></td>*}
	            	{*<td style="font-size: 11px; padding: 15px 10px 20px 20px;">{$obj.descricao}</td>*}
	            {*</tr>*}
 			{*</table>   	*}
    	{*</div>*}
    {**}
    {*</div>*}
        {**}
    {*</fieldset>*}
    {*<br />*}
    {**}
    {*{if $login.perfis_idperfis != 3 || $login.empresas_idempresas == 1}*}
		{*<center>*}
    		{*<input type="button" class="btn" value="Editar Incidentesss" onClick="javascript:getAjaxForm('Incidente/edit',false,{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" />*}
    		{*<input type="button" class="btn" value="Atendimentos" onClick="javascript:getAjaxForm('AtendVsat/listeAtendsIncidente','divDinamico',{ldelim}param:{$obj.idincidentes},ajax:1{rdelim})" />*}

		{*</center>*}
    {*{/if}    *}
    {**}
{*</form>*}

{*<div id="divDinamico">*}

	{*{if isset($atendimento.idatend_vsat)}*}
		{*<center>*}
		{*<form action="AgendaInstal/create" method="POST" id="fAtEdit" class="form" >*}
		    {*<input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$atendimento.idatend_vsat}"/>*}
		    {**}
		    {*<fieldset>*}
		    {*<div id="topDadosInstal" align="left">*}
		    	{*<table class="tableDados">*}
		    		{*<tr>*}
		    			{*<td><label><b><font color="#ffffff" size="2.9">&nbsp; Último Atendimento</B></font></b></label></td>    			*}
		    		{*</tr>*}
		    	{*</table>*}
		    {*</div>*}
		    {*<br />*}
		    {**}
    {*<div class="incContener">*}
    	{*<div class="dadoIncidente">*}
		        {**}
		        {*<table border="1" class="incTable incTable1">*}
					{**}
					{*<tr>*}
		            	{*<td colspan="3">*}
		            		{*<input type="button" class="btn" value="Editar Atendimento" onclick="javascript:getAjaxForm('AtendVsat/edit','divDinamico',{ldelim}param:{$atendimento.idatend_vsat},ajax:1{rdelim})" />*}
		            	{*</td>*}
		            {*</tr>*}
		            {**}
		            {*<tr>    *}
		                {*<td><b>Status do Atendimento:</b></td>*}
		                {*<td>*}
		                    {*{if $atendimento.status_atend_idstatus_atend == 1}Aberto{/if}*}
		                    {*{if $atendimento.status_atend_idstatus_atend == 2}Em Atendimento{/if}*}
		                    {*{if $atendimento.status_atend_idstatus_atend == 3}Finalizado{/if}*}
		                {*</td>        *}
		            {*</tr>*}
		             {**}
		            {*<tr>    *}
		                {*<td><b>Atendimentos:</b></td>*}
		                {*<td>{$atendimento.atendimento}</td>        *}
		            {*</tr>*}
		                    {**}
		        {*</table>*}
		        {**}
		    {*</div>*}
		    {**}
		    {*</fieldset>       *}
		    {**}
		    {*<br />*}
		    {**}
		    {*<!-- *}
		    	{*<center><input type="button" value="Atualizar" onClick="javascript:sendPost('AtendVsat/edit','fAtEdit')" /></center>*}
		    {*-->*}
		{*</form>*}
		{*</center>*}
	{*{else}*}
		{*<div id="caixaReservaParaListagem"></div>*}
	{*{/if}*}

{*</div>*}
{*</center>*}
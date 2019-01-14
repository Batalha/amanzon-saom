
<center>
{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}

<form class="form" id="FOSCreate">
        <input type="hidden" name="idOS_reserva" id="idOS_reserva" value="{$obj.idos}" />
        <input type="hidden" name="idInstalacoes_reserva" id="idInstalacoes_reserva" />
        <input type="hidden" name="pausa" id="pausa" value="{if isset($pausaid)}{$pausaid}{/if}" />

<br />
<div id="acoesOs">
	<table class="acoesTable" style="width: 100%; ">
		<tr style=" border-bottom: 1px solid #BABABA;" >
			<td colspan="2">
			{if $obj.os_status_idos_status != 2}
				{if $login.perfis_idperfis != 3 }
					{if isset($obj.rel.instalacoes.idinstalacoes)}
					<div class="divInstOk">
						Uma <b>VSAT</b> para esta OS já existe, é a {$obj.rel.instalacoes.nome},
					    <input type="button" class="classname" value="    Ver Dados da VSAT  " onClick="javascript: 
						    getAjaxForm('Instalacao_sp/view_instalacao','dadosInstal',	{ldelim}param:{$obj.rel.instalacoes.idinstalacoes},ajax:1{rdelim})"
						/>
					                
						<!-- COMISSIONAMENTO -->
						{if $obj.rel.instalacoes.comiss != 1}
							<input type="button" class="classname" value="    Comissionar  " onClick="javascript: 
								$.ajax({ldelim} url: 'OSSP/verificaIplanIpdvb/'+{$obj.idos}, async:false {rdelim}).done(function(response)
								{ldelim}
						        	if(response == 1)
						            	{ldelim} $('#modal').modal('show');{rdelim}
						            else
							            {ldelim} 
						            		if(confirm('Está preparado para Comissionamento?\n Obs.: a partir dessa confirmação o tempo de execução da tarefa começará a ser contabilizado.'))
							            		{ldelim}
							            			getAjaxForm('Comissionamento_sp/comiss','dadosInstal',
									    				{ldelim}
									            			param:{$obj.rel.instalacoes.idinstalacoes},
									                			ajax:1
									                	{rdelim});
								                {rdelim}
						                {rdelim}
								{rdelim})"
							/>
							
										
						    <div class="modal hide hide" id="modal">
							    <form action="OSSP/edit" method="post" name="edicao_critica_os" id="edicao_critica_os">
								    <input name="idos" id="idos" type="hidden" value="{$obj.idos}" />
								  	<div class="modal-header">
										<a class="close" data-dismiss="modal">×</a>
										<h3>Edição Crítica da OS</h3>
									</div>
									<div class="modal-body">
										<p style="text-align:left;">Foi verificado que faltam dados para o Comissionamento,	para dar continuidade preencha o seguinte formulário:</p>
										<div class="span6">
								    		<div class="span2">IP Lan:</div>
								    		<div class="span2">
								    			<input style="height:30px;" name="iplan" id="iplan" value="{$obj.iplan}" />
								    		</div>
								    		<div class="span2">IP Dvb:</div>
								    		<div class="span2">
								    			<input style="height:30px;" name="ipdvb" id="ipdvb" value="{$obj.ipdvb}"/>
								    		</div>
										</div>
										<div style="clear:both"></div>
									</div>
									<div class="modal-footer">
										<a href="#" class="btn" data-dismiss="modal">Fechar</a>
										<a href="#" class="btn btn-primary" onclick="javascript: sendPost( OSSP/edicao_critica','edicao_critica_os')">Salvar Dados</a>
									</div>  	
								</form>
							</div>
						{else}
							<input type="button" class="classname" value="    Ver Comissionamento  " onClick="javascript: guardaReserva({$obj.rel.instalacoes.idinstalacoes},'#idInstalacoes_reserva');
					             getAjaxForm('Comissionamento_sp/comiss_view', 'dadosInstal',
							     {ldelim}
							      	param:{$obj.rel.instalacoes.idinstalacoes},ajax:1
							     {rdelim})" />
						{/if}
						
						<input type="button" id="veros" class="classname" value="     Ver Dados da OS   " onclick="return btmenuOS(this);">
						
						<!-- DATA DE ACEITE -->
			            <input type="text" style="float:right;width:190px;padding:3px;margin-top:2px;border:1px solid #000;background:#ccc;color:#000;" value="Data de Aceite: {if $obj.rel.instalacoes.data_aceite!=''}{$obj.rel.instalacoes.data_aceite}{/if}" readonly="readonly" />
			            {if !$pausado}
				            {if $obj.rel.instalacoes.comiss == 1 && $usuario_permissao == 1}
				            	{if $obj.rel.instalacoes.data_aceite == ''}
				            		<input onclick="javascript:getAjaxForm('Instalacao_sp/edit_data_comiss', 'dadosInstal',{ldelim}param:{$obj.rel.instalacoes.idinstalacoes},ajax:1{rdelim})" type="button" class="classname" style="float:right;margin-right:10px;" value="    Cadastrar Data de Aceite  "/>
				            	{else}
				            		<input onclick="javascript:getAjaxForm('Instalacao_sp/edit_data_comiss', 'dadosInstal',{ldelim}param:{$obj.rel.instalacoes.idinstalacoes},ajax:1{rdelim})" type="button" class="classname" style="float:right;margin-right:10px;" value="    Mudar Data de Aceite  "/>
				            	{/if}
				            {/if}
				        {/if}
					</div>
				    {else}
				        <div class="divInstAviso">
				        	Uma <b>VSAT</b> para esta OS ainda não existe, é a {$obj.rel.instalacoes.nome},
				        	<input class="btn" type="button" value="Cadastrar dados da VSAT"  {if isset($obj.rel.agenda_instal.idagenda_instal)} onClick="javascript:getAjaxForm('Instalacao_sp/create', 'dadosInstal',{ldelim}param:{$obj.idos},ajax:1{rdelim},getDadosInstal,{$obj.idos})" {else} onClick="javascript:simpleMsg('Nenhuma instalação ao campo foi agendada, portanto os dados da instalação não podem ser preenchidos.')"{/if}/>
				        </div>            
				    {/if}
				{/if}
			{/if}
			
			</td>
		</tr>
		
		<tr height="40" style=" border-bottom: 1px solid #BABABA;">
			<td width="14%">
				<select name="arquivo" id="arquivo" style="width: 180px; margin: 0;" onchange="return btmenuOS(this);">
				{if $obj.os_status_idos_status != 2}
					{if $login.perfis_idperfis != 3}
						<option value="0">Upload de Arquivos</option>
						<option value="1">Agendamento</option>
						<option value="2">Licença Anatel</option>
						<option value="3">Termo Responsabilidade</option>
						<option value="4">Relatório Fotográfico</option>
					{else}
						
						<option value="6">Tecnicos</option>
					{/if}
				{else}
					<option value="5">OS Cancelado</option>
					
				{/if}
				</select>
			</td>
			<td align="left">
				{if $obj.os_status_idos_status != 2}
					{if $login.perfis_idperfis != 3}
						<div id="para" ></div>
					{else}
						<input type="button" id="tecnicos" class="classname" value="     Ver Dados da OS   " onclick="return btmenuOS(this);">
					{/if}
				{else}
					<input type="button" id="veros" class="classname" value="     Ver Dados da OS   " onclick="return btmenuOS(this);">
				{/if}
			</td>
		</tr>
		<tr ><td colspan="2"><div id="arquivoInstal"></div></td></tr>
	</table>

	
</div>
        

<fieldset id="borda">
<div id="dadosInstal"></div>
<!-- Dados importantes -->
<div id="dadosOs" hidden="">
    <div class="areaOS">
    	<div id="linha1">
		    <table border="1"  class="tableDados">
		    	<tr height="25">
		    	<td style="font-weight: bold; width: 15%; color: #494949 ">Orgão :</td><td>{$obj.orgao}</td>
		    	<td style="font-weight: bold; width: 40%; color: #494949 ">OS N° <b>{$obj.numOS}</b>&nbsp;-&nbsp;{$nomeVsat}</td>
		    	
		    	</tr>
		    </table>
		    <table border="1" class="tableDados">
		    	<tr height="25">
		    		<td style="font-weight: bold; width: 15%;	 color: #494949">Identificador :</td><td style="width: 80px; ">{$obj.identificador}</td>
		    		<td style="font-weight: bold; color: #494949">Designação :</td><td width="40%">{$obj.designacao}</td>
		    	</tr>
		    </table>
    	
    	</div>
    	<div id="linha2">
			<table class="tableDados">
				<tr><td colspan="4" style="font-weight: bold; color: #494949;">&nbsp;Contato da Instalação</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td align="right" style="font-weight: bold;">Contato :</td><td>&nbsp;&nbsp;&nbsp;{$obj.contato}</td><td align="right" style="font-weight: bold;">CEP :</td><td>&nbsp;{$obj.cep}</td></tr>
				<tr height="16"><td align="right" style="font-weight: bold;">Telefone :</td><td>&nbsp;&nbsp;&nbsp;1° {$obj.telContato} 2° {$obj.outroTelContato}</td>
				

				
				</tr>
				<tr><td align="right" style="font-weight: bold;">Endereço :</td><td>&nbsp;&nbsp;&nbsp;{$obj.enderecoInstal}</td></tr>
				<tr><td align="right" style="font-weight: bold;">Email :</td><td>&nbsp;&nbsp;&nbsp;{$obj.email}</td></tr>
				<tr><td align="right" style="font-weight: bold;">Cidade :</td><td>&nbsp;&nbsp;&nbsp;{$obj.rel.municipios_idcidade.municipio}</td></tr>
				
			</table>    	
    	</div>
    	<div id="linha2">
			<table class="tableDados">
				<tr><td colspan="4" style="font-weight: bold; color: #494949;">&nbsp;Contato de Faturamento</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
			        {if $login.perfis_idperfis != 3 }
				<tr>
					<td width="17%" align="right" style="font-weight: bold;">Endereço :</td><td>&nbsp;&nbsp;&nbsp;{$obj.enderecoFaturamento} </td>
					<td align="right" style="font-weight: bold;">CEP :</td><td width="25%">&nbsp;{$obj.cepFaturamento}</td>
				</tr>
	                {/if}
				<tr height="16">
			        {if $login.perfis_idperfis != 3 }
					<td align="right" style="font-weight: bold;">Cidade :</td><td>&nbsp;&nbsp;&nbsp;{$obj.rel.municipios_idcidadeFaturamento.municipio}</td>
	               	<td align="right" style="font-weight: bold;">CNPJ :</td><td>&nbsp;&nbsp;&nbsp;{$obj.cnpj}</td>
	                {/if}
					
				
				</tr>
				<tr>
					<td align="right" style="font-weight: bold;">Email :</td><td>&nbsp;&nbsp;&nbsp;{$obj.emailFaturamento}</td>
				</tr>
				<tr><td align="right" style="font-weight: bold;">Prazo Instalação :</td><td>&nbsp;&nbsp;&nbsp; {$obj.prazoInstal}</td></tr>
				<tr><td align="right" style="font-weight: bold;">Data Instalação :</td><td>&nbsp;&nbsp;&nbsp;{$obj.dataSolicitacao}</td></tr>
				
			</table>    	
    	</div>
    	<div id="linha3">
			<table class="tableDados">
				<tr><td colspan="4" style="font-weight: bold; color: #494949;">&nbsp;Serviços</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="5" width="17%"><b>Empresa responsavel para instalação</b> :&nbsp;&nbsp;&nbsp;{$obj.rel.empresas.empresa}</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
					<td width="20%" align="right" style="font-weight: bold;">Vel. Download :</td><td width="3%">&nbsp;</td><td>{$obj.velDownload} </td>
					<td align="right" style="font-weight: bold;">Area de Instalação :</td><td width="3%">&nbsp;</td><td width="42%">{$obj.areaInstal}</td>
				</tr>
	 			<tr>
	 				<td align="right" style="font-weight: bold;">Vel. Upload :</td><td>&nbsp;</td><td>{$obj.velUpload}</td>
					<td align="right" style="font-weight: bold;">Eutesat Code :</td><td>&nbsp;</td><td>{$obj.eutelsat_code}</td>
				
				</tr>
				<tr>
					<td align="right" style="font-weight: bold;">Ip Lan :</td><td>&nbsp;</td><td>{$obj.iplan}</td>
					<td align="right" style="font-weight: bold;">Serviço :</td><td>&nbsp;</td><td>Satélite</td>
				<tr>
					<td align="right" style="font-weight: bold;">Ip DVB :</td><td>&nbsp;</td><td>{$obj.ipdvb}</td>
					<td align="right" style="font-weight: bold;">Lote :</td><td>&nbsp;</td><td>{$obj.lote}</td>
				</tr>
				<tr>
					<td align="right" style="font-weight: bold;">Mascara :</td><td>&nbsp;</td><td>{$obj.mascaraLan}</td>
					<td align="right" style="font-weight: bold;">Perfil :</td><td>&nbsp;</td><td>{$obj.perfil}</td>
				</tr>
				<tr>
					<td align="right" style="font-weight: bold;">Padrão :</td><td>&nbsp;</td><td>Sem redundância</td>
					<td align="right" style="font-weight: bold;">&nbsp;</td><td>&nbsp;</td><td></td>
				</tr>
				
			</table>   
    	</div>	

    	<div id="linha4">
 			<table border="1"  style="width: 100%;">
				<tr><td style="font-weight: bold;">Observação  :</td></tr>
				<tr><td>{$obj.observacoes}</td></tr>
			</table>   	
    	</div>
    </div>
{if $obj.os_status_idos_status != 2}
	{if $login.perfis_idperfis != 3 } <!-- para usuarios que não são "Campo" -->
	
		<input type="button" class="btn" value="Editar dados da OS" onClick="javascript:getAjaxForm('OSSP/edit',false,{ldelim}param:{$obj.idos},ajax:1{rdelim})" />
		<input type="button" class="btn" name="cancelaOS" id="cancelaOS" value="Cancelar OS" onClick="javascript:(confirm('Deseja Cancelar essa OS?'))?getAjaxForm('OSSP/cancela',false,{ldelim}param:{$obj.idos},ajax:1{rdelim}):'';"/>

	{/if}
	{if $login.perfis_idperfis != 6}
		{if $login.perfis_idperfis != 3 }
			{if $obj.rel.instalacoes.data_aceite == ''}
				{if $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4 }
					{if $pausado}
						<input class="btn" type="button" value="Desparalisar OS" onClick="javascript:getAjaxForm('OSSP/caixaDespausa','caixaPausa')" />&nbsp;Pausado em {$dataPausado}
					{else}
					   	<input class="btn" type="button" value="Paralisar OS" onClick="javascript:getAjaxForm('OSSP/caixaPausa','caixaPausa')" />
					{/if}
					    <div id="caixaPausa"></div>
				{/if}
			{/if}
		{/if}
	{/if}
{/if}
</div>

    </fieldset>
    <br />
    <input name="campoDataPausa" id="campoDataPausa" type="hidden" value="" />
</form>
<br />

{if $obj.os_status_idos_status != 2}
<div hidden="">

	{if $login.perfis_idperfis != 6} <!-- para usuários que não "Cliente SP" -->
		<div id="agend">
			{if ! isset($obj.rel.agenda_instal.idagenda_instal)} <!-- Para ausência de agendamento -->
				{if $pausada != 1}
			   		<div class='divAgendAviso'>de instalação não existe para esta Ordem de Serviço{if $login.perfis_idperfis == 3 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5}, 
			   		<input type="button" class="classname" value="  Agendar instalação  " onClick="javascript:getAjaxForm('AgendaInstal_sp/create','dadosInstal',{ldelim}param:{$obj.idos},ajax:1{rdelim})" /> {/if}</div>
				{/if}
			{/if}
			
			{if isset($obj.rel.agenda_instal.idagenda_instal)} <!-- Para presença de agendamento --> 
				{if $obj.rel.agenda_instal.confirm != 1}
					{if $pausada != 1}
			        	<div class='divAgendAviso'> já existe para esta OS, mas ainda não foi confirmado 
			        	<input class="classname" type="button" value="    Ver agendamento  " onClick="javascript:getAjaxForm('AgendaInstal_sp/view','dadosInstal',{ldelim}param:{$obj.rel.agenda_instal.idagenda_instal},ajax:1{rdelim})" /> </div>
			        {/if}           
			    {else}
			    	{if $pausada != 1}
			        	<div class='divAgendOk'> de instalação já existe para esta OS e já foi confirmado 
			        	<input class="classname" type="button" value="    Ver agendamento  " onClick="javascript:getAjaxForm('AgendaInstal_sp/view','dadosInstal',{ldelim}param:{$obj.rel.agenda_instal.idagenda_instal},ajax:1{rdelim})" /> </div>
			    	{/if}
			    {/if}  
			{/if}
		</div>
	{/if} <!-- 	Fim do login Prfil -->
	<br/>
	
	<!-- LICENCA ANATEL -->
	{if $login.perfis_idperfis} <!-- para perfis diferentes de "Campo" -->
		<div id="licencaAnatel" >
			<div class="divAgendOk">
	<!-- 			<strong>Licença Anatel:</strong>&nbsp; -->
				{if $licenca_anatel == ''}
					Ainda não disponível
				{else}
					<span id="local_arquivo_licenca_anatel">{$licenca_anatel}</span>
				{/if} 
				&nbsp;&nbsp;
				<input id="" name="" type="button" value="     Enviar Licença Anatel  " class="classname" onclick="javascript:
					$.ajax({ldelim}
						url:'Comissionamento_sp/formulario_upload_licenca_anatel',
						data:{ldelim}idinstalacao:{$obj.rel.instalacoes.idinstalacoes}{rdelim},
						type:'POST',
						success:function(resposta){ldelim}
							$('#arquivoInstal').html(resposta);
						{rdelim}
					{rdelim});
				"/>
			
			</div>
		</div>
	{/if}
	
	<!-- TERMO RESPONSABILIDADE -->
	<br/>
	<div id="termoResp" style="">
	
		<div class="divAgendOk">
	<!-- 		<strong>Termo Responsabilidade:</strong>&nbsp; -->
			{if $termo_responsabilidade == ''}
				<span id="local_arquivo_termo_responsabilidade">Ainda não disponível</span>
			{else}
				<span id="local_arquivo_termo_responsabilidade">
					<a href="{$termo_responsabilidade.endereco}{$termo_responsabilidade.nome}" style="color:#000;" target="_blank">
						<i class='icon-file'></i>
						{$termo_responsabilidade.nome}
					</a>
				</span>
			{/if}
			<span id="btn_apagar_termo_responsabilidade"> <!-- btn para apagar -->
				{if $termo_responsabilidade != '' && $login.perfis_idperfis == 3 && $termo_responsabilidade.status != 1}
					<a title="Apagar" onclick="javascript:
						timeout = new Array(); // apaga timeout's
						$.ajax({ldelim}
							url:'TermoResponsabilidade_sp/apagarTermoDeResponsabilidade',
							data:{ldelim}id_termo_responsabilidade:{$termo_responsabilidade.id_termo_responsabilidade}{rdelim},
							type:'POST',
							success:function( resposta){ldelim}
								$('#arquivoInstal').html(resposta);
	
								timeout['tempoRespostaApagar'] = setTimeout(function(){ldelim}
									// resgata tipo resposta
									var tipoResposta = $('span.alert').attr('class');
									tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
									console.log(tipoResposta);
									// limpa nomes do arquivo
									if( tipoResposta != 'error' ){ldelim}
										$('#local_arquivo_termo_responsabilidade').html('Ainda não disponível');
										$('#btn_apagar_termo_responsabilidade').html('');
										$('#status_termo_responsabilidade').html('');
									{rdelim}
									
									timeout['tempoApagarAlerta'] = setTimeout(function(){ldelim}// apaga alerta
										$('span.alert').fadeOut();
									{rdelim},4500);
								{rdelim},500); // atualiza status
							{rdelim}
						{rdelim});
					"><i class="icon-remove"></i></a>
				{/if}
			</span>
			&nbsp;&nbsp;
			{if $login.perfis_idperfis == 3 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4} <!-- formulario de termo de responsabilidade -->
				{if !isset($termo_responsabilidade.status) || $termo_responsabilidade.status != 1}
					<input id="input_termo_responsabilidade" name="input_termo_responsabilidade"
						type="button" value="     Termo de Responsabilidade  " class="classname" onclick="javascript:
						timeout = new Array(); // apaga timeout's
						$.ajax({ldelim}
							url:'TermoResponsabilidade_sp/uploadForm',
							data:{ldelim}idinstalacao:{$obj.rel.instalacoes.idinstalacoes}{rdelim},
							type:'POST',
							success:function(resposta){ldelim}
								$('#arquivoInstal').html(resposta);
							{rdelim}
						{rdelim});
					"/>
				{/if}
			{/if}
			&nbsp;&nbsp;
			<span id="opcoes_aprovacao_termo_responsabilidade">
			{if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4 } <!-- usuários NOC/COM -->
				{if $termo_responsabilidade != ''}
					<!-- aprovar termo -->
					<input class="btn btn-success" type="button" value="Aprovar" value="Aprovar"
						onclick="javascript:
							timeout = new Array(); // apaga timeout's
							$.ajax({ldelim}
								url:'TermoResponsabilidade_sp/aprovar',
								type:'POST',
								data:{ldelim}idTermo:{$termo_responsabilidade.id_termo_responsabilidade}{rdelim},
								success: function( resposta ){ldelim}
									$('#arquivoInstal').html(resposta); // resposta
	
									timeout['tempoResgateTipoResposta'] = setTimeout(function(){ldelim}
										// resgata tipo resposta
										var tipoResposta = $('span.alert').attr('class');
										tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
										// atualiza status
										if( tipoResposta != 'error' ){ldelim}
											$('#status_termo_responsabilidade').html('Aprovado');
										{rdelim}
									{rdelim},500); // atualiza status
									
									timeout['tempoAlerta'] = setTimeout(function(){ldelim}
										$('.alert').fadeOut();
									{rdelim},4000); // some com resposta
								{rdelim}
							{rdelim});
						"/>
					&nbsp;&nbsp;
					<!-- desaprovar termo -->
					<input class="btn btn-danger" type="button" value="Desaprovar" value="Desaprovar"
						onclick="javascript:
							timeout = new Array();
							$.ajax({ldelim}
								url:'TermoResponsabilidade_sp/desaprovar',
								type:'POST',
								data:{ldelim}idTermo:{$termo_responsabilidade.id_termo_responsabilidade}{rdelim},
								success: function( resposta ){ldelim}
									$('#arquivoInstal').html(resposta);
	
									timeout['tempoAlerta'] = setTimeout(function(){ldelim}
										$('.alert').fadeOut();
									{rdelim},4000);
								{rdelim}
							{rdelim});
					"/>
				{/if}
			{/if}
			</span>
			&nbsp;&nbsp;<strong>Status Atual:</strong>&nbsp;
			<span id="status_termo_responsabilidade">
			{if $termo_responsabilidade != ''}
				{if $termo_responsabilidade.status == 0} <!-- aprovacao pendente -->
					Aprovação Pendente
				{else if $termo_responsabilidade.status == 1} <!-- aprovado -->
					Aprovado
				{else if $termo_responsabilidade.status == 2} <!-- desaprovado -->
					Desaprovado
				{/if}
			{/if}
			</span>
		
		</div>
	</div>
	
	<!-- Fim TERMO RESPONSABILIDADE -->
	
	<!-- RELATORIO FOTOGRAFICO -->
	
	<br/>
	<div id="relFoto" style="">
		<div class="divAgendOk">
	<!-- 		<strong>Relatório Fotográfico:</strong>&nbsp; -->
			{if $relatorio_fotografico == ''}
				<span id="local_arquivo_relatorio_fotografico">Ainda não disponível</span>
			{else}
				<span id="local_arquivo_relatorio_fotografico">
					<a href="{$relatorio_fotografico.endereco}{$relatorio_fotografico.nome}" style="color:#000;" target="_blank">
						<i class='icon-file'></i>
						{$relatorio_fotografico.nome}
					</a>
				</span>
			{/if}
			<span id="btn_apagar_relatorio_fotografico"> <!-- btn para apagar -->
				{if $relatorio_fotografico != '' && $login.perfis_idperfis == 3 && $relatorio_fotografico.status != 1}
					<a title="Apagar" onclick="javascript:
						timeout = new Array(); // apaga timeout's
						$.ajax({ldelim}
							url:'RelatorioFotografico_sp/apagarRelatorioFotografico',
							data:{ldelim}id_relatorio_fotografico:{$relatorio_fotografico.id_relatorio_fotografico}{rdelim},
							type:'POST',
							success:function( resposta){ldelim}
								$('#arquivoInstal').html(resposta);
	
								timeout['tempoRespostaApagar'] = setTimeout(function(){ldelim}
									// resgata tipo resposta
									var tipoResposta = $('span.alert').attr('class');
									tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
									console.log(tipoResposta);
									// limpa nomes do arquivo
									if( tipoResposta != 'error' ){ldelim}
										$('#local_arquivo_relatorio_fotografico').html('Ainda não disponível');
										$('#btn_apagar_relatorio_fotografico').html('');
										$('#status_relatorio_fotografico').html('');
									{rdelim}
									
									timeout['tempoApagarAlerta'] = setTimeout(function(){ldelim}// apaga alerta
										$('span.alert').fadeOut();
									{rdelim},4500);
								{rdelim},500); // atualiza status
							{rdelim}
						{rdelim});
					"><i class="icon-remove"></i></a>
				{/if}
			</span>
			&nbsp;&nbsp;
			{if $login.perfis_idperfis == 3 || $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4} <!-- formulario de relatorio fotografico -->
				{if !isset($relatorio_fotografico.status) || $relatorio_fotografico.status != 1}
					<input id="input_relatorio_fotografico" name="input_relatorio_fotografico" 
						type="button" value="     Enviar Relatório Fotográfico  " class="classname" onclick="javascript:
						timeout = new Array(); // apaga timeout's
						$.ajax({ldelim}
							url:'RelatorioFotografico_sp/uploadForm',
							data:{ldelim}idinstalacao:{$obj.rel.instalacoes.idinstalacoes}{rdelim},
							type:'POST',
							success:function(resposta){ldelim}
								$('#arquivoInstal').html(resposta);
							{rdelim}
						{rdelim});
					"/>
				{/if}
			{/if}
			&nbsp;&nbsp;
			<span id="opcoes_aprovacao_relatorio_fotografico">
			{if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4} <!-- usuários NOC/COM -->
				{if $relatorio_fotografico != ''}
					<!-- aprovar relatorio -->
					<input class="btn btn-success" type="button" value="Aprovar" value="Aprovar"
						onclick="javascript:
							timeout = new Array(); // apaga timeout's
							$.ajax({ldelim}
								url:'RelatorioFotografico_sp/aprovar',
								type:'POST',
								data:{ldelim}idRelatorio:{$relatorio_fotografico.id_relatorio_fotografico}{rdelim},
								success: function( resposta ){ldelim}
									$('#arquivoInstal').html(resposta); // resposta
	
									timeout['tempoResgateTipoResposta'] = setTimeout(function(){ldelim}
										// resgata tipo resposta
										var tipoResposta = $('span.alert').attr('class');
										tipoResposta = tipoResposta.substr(tipoResposta.indexOf('-')+1)
										// atualiza status
										if( tipoResposta != 'error' ){ldelim}
											$('#status_relatorio_fotografico').html('Aprovado');
										{rdelim}
									{rdelim},500); // atualiza status
									
									timeout['tempoAlerta'] = setTimeout(function(){ldelim}
										$('.alert').fadeOut();
									{rdelim},4000); // some com resposta
								{rdelim}
							{rdelim});
						"/>
					&nbsp;&nbsp;
					<!-- desaprovar relatorio -->
					<input class="btn btn-danger" type="button" value="Desaprovar" value="Desaprovar"
						onclick="javascript:
							timeout = new Array();
							$.ajax({ldelim}
								url:'RelatorioFotografico_sp/desaprovar',
								type:'POST',
								data:{ldelim}idRelatorio:{$relatorio_fotografico.id_relatorio_fotografico}{rdelim},
								success: function( resposta ){ldelim}
									$('#arquivoInstal').html(resposta);
	
									timeout['tempoAlerta'] = setTimeout(function(){ldelim}
										$('.alert').fadeOut();
									{rdelim},4000);
								{rdelim}
							{rdelim});
						"/>
				{/if}
			{/if}
			</span>
			&nbsp;&nbsp;<strong>Status Atual:</strong>&nbsp;
			<span id="status_relatorio_fotografico">
			{if $relatorio_fotografico != ''}
				{if $relatorio_fotografico.status == 0} <!-- aprovacao pendente -->
					Aprovação Pendente
				{else if $relatorio_fotografico.status == 1} <!-- aprovado -->
					Aprovado
				{else if $relatorio_fotografico.status == 2} <!-- desaprovado -->
					Desaprovado
				{/if}
			{/if}
			</span>
		
		</div>
	</div>
	
	<!-- Fim RELATORIO FOTOGRAFICO -->
	
{else}
	<input 
    	style="width:500px;padding:2px;border:1px solid #000;color:red;font-weight:bold;background:url(vazio);text-align:center;" 
    	type="text" 
    	value="OS Cancelada"
    />
{/if}
</div>
    

{if $GoogleMapCoordinates != false}
    <div id="googlemaps" style="width:90%;height:400px;margin:0 auto;border:3px solid #000;" 
        lat="{$GoogleMapCoordinates['latitude']}" 
        long="{$GoogleMapCoordinates['longitude']}"></div>

    </center>
{/if}

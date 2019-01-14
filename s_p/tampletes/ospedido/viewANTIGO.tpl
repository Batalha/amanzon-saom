
<center>
{include file="s_p/tampletes/ospedido/submenu.tpl" title=submenu}
<br />
<form class="form" id="FPOSCreate">
<div id="acoesPedidoOs">
	<table id="fonte" border="1">
	{if !($obj.rel.os_pedido_contrato.idcontrato)}
		<tr >
			{if ! isset($obj.rel.os_pedido_contrato.idcontrato)}
				{if $login.perfis_idperfis == 8 || $login.perfis_idperfis == 4}
				<td width="10%">
							<input type="button" class="classname" value="     Criar Pedido OS  " 
							onClick="javascript:getAjaxForm('OsPedidoContrato/create','dadosPedidoOs',{ldelim}param:{$obj.idpedido_os},ajax:1{rdelim})">
				</td>
				{/if}
			{/if}
			<td align="center" height="40"><b style="color: red">Aguardando Resposta do ACCOUNT EXECUTIVE!</b></td>
		</tr>
	{else}
		<tr height="40">
			<td width="13%"><a class="btn" id="li_submenu_relatorio" href="../OsPedido/contrato/?param={$obj.idpedido_os}"><span class="iconImp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pedido Os</span></a></td>

			<td td width="60%">
			<div class="divContrato">
				{if $contrato_sp == ''}
					<span id="local_arquivo_contrato_sp">&nbsp;<font color="red"> Pedido OS Assinado não disponível</font></span>
				{else}
					<span id="local_arquivo_contrato_sp">
						<a href="{$contrato_sp.endereco}{$contrato_sp.nome}" style="color:#000;" target="_blank">
							<i class='icon-file'></i>
							{$contrato_sp.nome}
						</a>
					</span>
				{/if}
				<span id="btn_apagar_contrato_sp"> 
				<!-- btn para apagar -->
<!-- 					{if $contrato_sp != '' && $login.perfis_idperfis == 4 && $contrato_sp.status != 1} -->
<!--							<input type="button" value="x" onclick="javascript:-->
						<!-- 					{/if}  -->
				</span>
				&nbsp;&nbsp;
				{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 10 || $login.perfis_idperfis == 8} <!-- formulario de contrato -->
<!-- 					{if !isset($contrato_sp.status) || $contrato_sp.status != 1} -->
						<input id="input_contrato_sp" name="input_contrato_sp"
							type="button"  value="     Pedido Os  " class="classname" onclick="javascript:
							timeout = new Array(); // apaga timeout's
							$.ajax({ldelim}
								url:'ContratoSP/uploadForm',
								data:{ldelim}idpedido_os:{$obj.idpedido_os}{rdelim},
								type:'POST',
								success:function(resposta){ldelim}
									$('#arquivoPedidoOs').html(resposta);
								{rdelim}
							{rdelim});
						"/>
<!-- 					{/if} -->
				{/if}
			</div>
				
			</td>
			<td>&nbsp;&nbsp;&nbsp;
				{if isset($obj.rel.os_pedido_contrato.idcontrato)}
					{if $login.perfis_idperfis == 8 || $login.perfis_idperfis == 4 || $login.perfis_idperfis == 10}
						<input type="button" id="vercont" class="classname" value="    Ver Pedido Os" onclick="return btmenuPedidoOS(this);">	
					{/if}	
				{/if}			
			
			</td>
		</tr>
		<tr>
			<td colspan="3"><div id="arquivoPedidoOs"></div></td>
		</tr>
	{/if}
	</table>

</div>




<div id="dadosPedidoOs"></div>
<div  id="resContrato" hidden="">
	<div class="layoutResumo" >
		<table width="100%">
			<tr><td><b>&nbsp;&nbsp;Numero da OS Nº {$obj.rel.os_pedido_contrato.num_os}</b>	</td></tr>
		</table>
		<div style="background-color: white;">
			<table class="resumoContrato" border="0" width="100%" style="margin-top: 5px;">
				<tr>
					<td>
						<table border="0"  width="100%" >
							<tr><td width="25%">&nbsp;&nbsp;Contratante :</td><td>{$empresa} - {$usuario}</td></tr>
							<tr><td>&nbsp;&nbsp;Cliente Final :</td><td>{$obj.cliente_final}</td></tr>
							<tr><td>&nbsp;&nbsp;Local e Prazo de Instalação :</td>
								<td>{$obj.local} - Lat: {$obj.lat_graus}º 
														{$obj.lat_minutos}' 
														{$obj.lat_segundos}" 
														{$obj.lat_direcao}
														 
														Long: {$obj.lon_graus}º
															  {$obj.lon_minutos}'
															  {$obj.lon_segundos}"
															  {$obj.lon_direcao}
								</td>	
							</tr>
							<tr><td>&nbsp;&nbsp;Descrição do Fornecimento :</td>
								<td>{$obj.rel.canal_venda.plano} - Link de 
														  {$obj.rel.canal_venda.servico} - FC = 
														  
														  {if $obj.fator_comp == 'fc15'}
														  	1:5
														  {else if $obj.fator_comp == 'fc110'}
														  	1:10
														  {else}
														  	1:20
														  {/if}
								</td>		
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="resumoContrato" width="100%" align="center">
							<tr><td>&nbsp;</td></tr>
							<tr style="border: 1px solid black; border-color: #595656; background-color: #d6d6d6;  color: black;" align="center"><td style="border: 1px solid black; border-color: #595656;"> &nbsp;&nbsp;<b>Serviços e Produtos</b></td><td><b>Total</b></td></tr>
							<tr style="border: 1px solid black; border-color: #595656;">
								<td width="80%">&nbsp;&nbsp;Equipamentos</td><td align="center">R${$obj.rel.os_pedido_contrato.preco_equipamento}</td>
							</tr>
							<tr style="border: 1px solid black; border-color: #595656;">
								<td>&nbsp;&nbsp;Serviços de Logística e Instalação, Taxa de Adesão e Taxas ANATEL</td><td align="center">R${$obj.rel.os_pedido_contrato.preco_servico}</td>
							</tr>
							<tr style="border: 1px solid black; border-color: #595656;">
								<td>&nbsp;&nbsp;Provimento de serviço link satelital</td><td align="center">R${$obj.rel.os_pedido_contrato.preco_provimento}</td>
							</tr>
						
						</table>
					</td>
				</tr>
	
			</table>
		</div>	
	</div>
</div>
</form>
	<br>
	<br>
	<br>
	<br>
	<br>


</center>

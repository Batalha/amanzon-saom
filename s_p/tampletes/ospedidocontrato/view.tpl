
<center>
<h1>Construindo area de confirmação de OS</h1>


<form>
{if $login.perfis_idperfis == 8 || $login.perfis_idperfis == 4}
	<input type="button" class="classname" value="     Contrato  ">
{/if}

<table style="width: 1000px">
	<tr>
		<td>
			<table  style="width: 100%">
			
				<tr>
					<td>Contratante :</td><td>&nbsp;&nbsp;&nbsp;{$empresa} - {$usuario}</td>		
				</tr>
				<tr>
					<td>Cliente Final :</td><td>&nbsp;&nbsp;&nbsp;{$obj.cliente_final}</td>		
				</tr>
				<tr>
					<td>Local e Prazo de Instalação :</td><td>&nbsp;&nbsp;&nbsp;{$obj.local} - Lat: {$obj.lat_graus}º 
																									{$obj.lat_minutos}' 
																									{$obj.lat_segundos}" 
																									{$obj.lat_direcao}
																									 
																									Long: {$obj.lon_graus}º
																										  {$obj.lon_minutos}'
																										  {$obj.lon_segundos}"
																										  {$obj.lon_direcao}</td>		
				</tr>
				<tr>
					<td>Descrição do Fornecimento :</td><td>&nbsp;&nbsp;&nbsp;{$obj.rel.canal_venda.plano} - Link de 
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
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td >
			<table class="tableContrato" border="0" width="100%">
				<tr><td colspan="5">Equipamentos</td></tr>
				<tr><td>Referência</td><td>Descrição</td><td>Preço unitário</td><td>Qtd</td><td>Preço total</td></tr>
			</table>
		</td>
	</tr>


</table>

</form>
</center>
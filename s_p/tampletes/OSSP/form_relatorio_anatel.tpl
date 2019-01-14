
<center>
	
	{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}

	<div>
	<form name="form_relatorio_anatel" id="form_relatorio_anatel" method="post" 
		enctype="multipart/form-data" 
		action="s_p/controller/OSSP/enviaRelatorioAnatel"
	>
		<table class="" style="width:530px;">
		
			<tr>
				<td>Arquivo CSV com Vsats na primeira coluna:</td>
				<td><input name="arquivo_csv" id="arquivo_csv" type="file"/></td>
				<td>
					<input name="enviar" id="enviar" type="button"  value="Enviar"
						onclick="javascript:
							enviaImg('#form_relatorio_anatel')
						" 
					/>
				</td>
			</tr>
			
		</table>
	</form>
	</div>
	
	<div style="height:15px;">&nbsp;</div>
	
	<div style="" id="form_relatorio_anatel_result"></div>
	
</center>


<center>

{include file="s_p/tampletes/equipamento/submenu.tpl" title=submenu}

<form action="Equipamento/createMulti" method="POST" id="formEnviaPlanilhaEquipamentos" class="form" enctype="multipart/form-data" >
    
    <h3>Cadastro de Equipamentos</h3><br />
    
    <div style="padding:5px;">
        
        <table class="table table-bordered table-striped formulario_cadastro_equipamento">
             
            <tr>    
                <td class="col1">
                    <label>Planilha com equipamentos:</label>
                </td>
                <td>
                    <input type="file" name="planilha" id="planilha"/>
                </td>        
            </tr>  
            <tr>
            	<td colspan="2" class="divObs" style="text-align:right;">
            		* Formatos aceitos: csv, xls, xlsx
            	</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            	<td>
            		<input type="button" class="btn" value="Enviar" 
            			onClick="javascript:
                			$('#resposta').html('<div class=\'alert\'>Efetuando procedimento necessário, aguarde. <i class=\'icon-time\'></i></div>');
                			enviaPlanilhaEquipamentos();
                		" 
            		/>
            	</td>
            </tr>           
        </table>
    
    </div>
    
    <div>
    
    	<table>
    		<tr>
    			<td id="resposta">
    				<div class="alert alert-info">
						É necessário que na planilha as colunas sejam como segue:<br/>
						tipo, sno, mac, local, tipo_local ( municipio OU vsat OU local_equipamento ), vsat, obs 
					</div>
    			</td>
    		</tr>
    	</table>
    
    </div>
    
</form>

</center>
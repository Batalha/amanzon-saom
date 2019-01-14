
<div style="border:1px solid #000;margin-top:5px;width:300px;padding:5px;">
	
	<span>Data da Paralisação:</span>
	 
	<input 
		id="campoDataParalisacao" 
		onchange="javascript:$('#campoDataPausa').val($(this).val())" 
		name="campoDataParalisacao" 
		type="text"  
		style="margin-top:5px;" />
		
	<input 
		type="button"
		class="btn"
		id="submitParalisacao" 
		value="Enviar paralização" 
		onClick="javascript:
			if( $('#campoDataParalisacao').val() != '' ){ 
				sendPost('OSSP/pausa','FOSCreate')
			}else{
				simpleMsg('Data de Paralização não pode ficar em branco.');
			}" 
		style="margin-top:5px;" />
		
	&nbsp;&nbsp;
	
	<input 
		class="btn" 
		type="button" 
		value="Cancelar" 
		onclick="javascript:$('#caixaPausa').html('')"  
		style="margin-top:5px;" />
	
</div>

<div style="border:1px solid #000;margin-top:5px;width:300px;padding:5px;">
	
	<span >Data da Desparalisação:</span> 
	<input id="campoDataParalisacao" onchange="javascript:$('#campoDataPausa').val($(this).val())" name="campoDataParalisacao" type="text"  style="margin-top:5px;" />
	<input type="button" id="submitParalisacao" value="Enviar desparalização" onClick="javascript:if($('#campoDataParalisacao').val()!=''){ldelim}sendPost('OS/despausa','FOSCreate');{rdelim}" style="margin-top:5px;" />
	&nbsp;&nbsp;
	<input type="button" value="Cancelar" onclick="javascript:$('#caixaPausa').html('')"  />
	
</div>
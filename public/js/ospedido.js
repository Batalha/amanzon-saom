

function btmenuPedidoOS(sel){

//	alert(sel.id);
//	var valueOS = sel.value;
	var verOS = sel.id;

	if(verOS == 'vercont'){
		var dadosPediOS = document.getElementById('resContrato').innerHTML;
		var pedidoOsHTML =  dadosPediOS ;
		document.getElementById('dadosPedidoOs').innerHTML = pedidoOsHTML;
	}
//	if(verOS == 'tecnicos'){
//		var dadosOS = document.getElementById('dadosOs').innerHTML;
//		var osHTML =  dadosOS ;
//		document.getElementById('dadosInstal').innerHTML = osHTML;
//	}
	
	
//	var newHTML =  arquivos ;
//	document.getElementById('para').innerHTML = newHTML;
//	document.getElementById('arquivoInstal').innerHTML = '';

//	var valueOS = document.getElementById('arquivo').value;
//	window.location("<?php echo $_SERVER['PHP_SELF'];?>?valueOS="+valueOS);
}
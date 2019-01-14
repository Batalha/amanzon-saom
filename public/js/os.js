/**
 * Arquivo criado para as funções da Página Inicial

 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */


/**
 * Sistema de busca de OS
 */
function findOS()
{
	var findOS = Ext.getDom('findOS').value;/*campo de busca*/
	var tpPesq = Ext.getDom('typePesq').value;/*opcoes de busca*/
	getAjaxForm('OS/liste',false,{where:tpPesq+" LIKE \'%"+findOS+"%\'",ajax:1});
}

function btmenuOS(sel){

	var valueOS = sel.value;
	var verOS = sel.id;


        //alert(arquivos);

	if(valueOS == '1'){
		var arquivos = document.getElementById('agend').innerHTML;
	}else if(valueOS == '2'){
		var arquivos = document.getElementById('licencaAnatel').innerHTML;
	}else if(valueOS == '3'){
		var arquivos = document.getElementById('termoResp').innerHTML;
	}else if(valueOS == '4'){
		var arquivos = document.getElementById('relFoto').innerHTML;
	}else if(valueOS == '5'){
		var arquivos = document.getElementById('osCanc').innerHTML;
	}else if(valueOS == '6'){
		var arquivos = document.getElementById('tecOs').innerHTML;
	}else{
		var arquivos ='';
	}
	if(verOS == 'veros'){
		var dadosOS = document.getElementById('dadosOs').innerHTML;
		var osHTML =  dadosOS ;
		document.getElementById('dadosInstal').innerHTML = osHTML;
	}
	if(verOS == 'tecnicos'){
		var dadosOS = document.getElementById('dadosOs').innerHTML;
		var osHTML =  dadosOS ;
		document.getElementById('dadosInstal').innerHTML = osHTML;
	}
	
	
	var newHTML =  arquivos ;
	document.getElementById('para').innerHTML = newHTML;
	document.getElementById('arquivoInstal').innerHTML = '';

//	var valueOS = document.getElementById('arquivo').value;
//	window.location("<?php echo $_SERVER['PHP_SELF'];?>?valueOS="+valueOS);
}

/**
 * Calcula prazo de instalacao da OS
 */
function getPrazoInstal()
{
    wait('Calculando o prazo de instalação...');
    Ext.Ajax.request({
        url: 'OS/getPrazoInstal',
        params: {
        	data: Ext.getDom('dataSolicitacao').value,
        	cidade: Ext.getDom('municipios_idcidade').value
	    },
	    success: function(response){
	        var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('prazoInstal').value     = r.data_result;     
	        Ext.getDom('msg_prazo').innerHTML   = r.msg;
			$('#msg_prazo').css('display', 'block');
	        hideMsg();
	    }
    });
}




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
	getAjaxForm('OSSP/liste',false,{where:tpPesq+" LIKE \'%"+findOS+"%\'",ajax:1});
}

function btmenuOS(sel){

	var valueOS = sel.value;
	var verOS = sel.id;

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
    if(verOS == 'verosAti'){
        var dadosOS = document.getElementById('dadosOsAti').innerHTML;
        var osHTML =  dadosOS ;
        document.getElementById('dadosInstal').innerHTML = osHTML;
    }
    if(verOS == 'veroutrosos'){
		var dadosOS = document.getElementById('dadosOutrasOs').innerHTML;
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

function chekQtLinhas(checkLinhas){

    var check = checkLinhas.value;
    var checkId = checkLinhas.id;

    if(checkId == 'voip'){
        if(check == 'sim'){
            var qtlinhas = document.getElementById('checkLinhas').innerHTML;
        }else{
            var qtlinhas = '';
        }
        var newHTML = qtlinhas;
        document.getElementById('tdLinhas').innerHTML = newHTML;
    }
    if(checkId == 'iplan'){
        if(check == 'sim'){
            var qtip = document.getElementById('checkIp').innerHTML;
        }else{
            var qtip = '';
        }
        var newHTML = qtip;
        document.getElementById('qtip').innerHTML = newHTML;
    }



}

/**
 * Calcula prazo de instalacao da OS
 */
function getPrazoInstalTel()
{
    wait('Calculando o prazo de instalação...');
    Ext.Ajax.request({
        url: 'OSSP/getPrazoInstal',
        params: {
        	data: Ext.getDom('tel_dataSolicitacao').value,
        	//cidade: Ext.getDom('cidade').value
	    },
	    success: function(response){
	        var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('tel_prazoInstal').value     = r.data_result;
	        Ext.getDom('tel_msg_prazo').innerHTML   = r.msg;
            $('#tel_msg_prazo').css('display', 'block');
	        hideMsg();
	    }
    });
}

function getPrazoInstalAti()
{
    wait('Calculando o prazo de instalação...');
    Ext.Ajax.request({
        url: 'OSSP/getPrazoInstal',
        params: {
            data: Ext.getDom('ati_dataSolicitacao').value,
            //cidade: Ext.getDom('cidade').value
        },
        success: function(response){
            var r = Ext.JSON.decode(response.responseText);
            Ext.getDom('ati_prazoInstal').value     = r.data_result;
            Ext.getDom('ati_msg_prazo').innerHTML   = r.msg;
            $('#ati_msg_prazo').css('display', 'block');
            hideMsg();
        }
    });
}

function getCarregaDadosEmrpesaTel()
{

    wait('Carregando dados Empresa...');
    Ext.Ajax.request({
        url: 'OSSP/getCarregaDadosEmpresa',
        params: {
            data: Ext.getDom('tel_empresas_idempresas').value,
            //cidade: Ext.getDom('cidade').value
        },
        success: function(response){
            var r = Ext.JSON.decode(response.responseText);
            if(r){
                Ext.getDom('tel_clientes_idcliente').value     = r.clientes_idcliente;
                Ext.getDom('tel_emailFaturamento').value     = r.emailFaturamento;
                Ext.getDom('tel_cnpjFaturamento').value     = r.cnpjFaturamento;
                Ext.getDom('tel_enderecoFaturamento').value     = r.enderecoFaturamento;
                Ext.getDom('tel_estadoFaturamento').value     = r.estadoFaturamento;
                Ext.getDom('tel_cidadeFaturamento').value     = r.cidadeFaturamento;
                Ext.getDom('tel_cepFaturamento').value     = r.cepFaturamento;
                Ext.getDom('tel_paisFaturamento').value     = r.paisFaturamento;
                //Ext.getDom('observacoes').value     = r.observacoes;
                hideMsg();
            }else{
                hideMsg();
            }
        }
    });
}

function getCarregaDadosEmrpesaAti()
{

    wait('Carregando dados Empresa...');
    Ext.Ajax.request({
        url: 'OSSP/getCarregaDadosEmpresa',
        params: {
            data: Ext.getDom('ati_empresas_idempresas').value,
            //cidade: Ext.getDom('cidade').value
        },
        success: function(response){
            var r = Ext.JSON.decode(response.responseText);
            if(r){
                Ext.getDom('ati_clientes_idcliente').value     = r.clientes_idcliente;
                Ext.getDom('ati_emailFaturamento').value     = r.emailFaturamento;
                Ext.getDom('ati_cnpjFaturamento').value     = r.cnpjFaturamento;
                Ext.getDom('ati_enderecoFaturamento').value     = r.enderecoFaturamento;
                Ext.getDom('ati_estadoFaturamento').value     = r.estadoFaturamento;
                Ext.getDom('ati_cidadeFaturamento').value     = r.cidadeFaturamento;
                Ext.getDom('ati_cepFaturamento').value     = r.cepFaturamento;
                Ext.getDom('ati_paisFaturamento').value     = r.paisFaturamento;
                //Ext.getDom('observacoes').value     = r.observacoes;
                hideMsg();
            }else{
                hideMsg();
            }
        }
    });
}

function getCarregaDadosEmrpesaOs()
{

    wait('Carregando dados Empresa...');
    Ext.Ajax.request({
        url: 'OSSP/getCarregaDadosEmpresa',
        params: {
            data: Ext.getDom('empresas_idempresas').value,
            //cidade: Ext.getDom('cidade').value
        },
        success: function(response){
            var r = Ext.JSON.decode(response.responseText);
            if(r){
                Ext.getDom('clientes_idcliente').value     = r.clientes_idcliente;
                Ext.getDom('emailFaturamento').value     = r.emailFaturamento;
                Ext.getDom('cnpjFaturamento').value     = r.cnpjFaturamento;
                Ext.getDom('enderecoFaturamento').value     = r.enderecoFaturamento;
                Ext.getDom('estadoFaturamento').value     = r.estadoFaturamento;
                Ext.getDom('cidadeFaturamento').value     = r.cidadeFaturamento;
                Ext.getDom('cepFaturamento').value     = r.cepFaturamento;
                Ext.getDom('paisFaturamento').value     = r.paisFaturamento;
                //Ext.getDom('observacoes').value     = r.observacoes;
                hideMsg();
            }else{
                hideMsg();
            }
        }
    });
}

function escondeSelect(check){

    var speedTipo = $('#speedTipo').val();
    if(check == 'speedSim'){
        //$(".selecione").css("display","block");
        $("#speedTipo").attr("disabled", false);
    }else if(check == 'speedNao'){
        $("#speedTipo").attr("disabled", true);
        $("#speedTipo").val('');
        $("#outrospeed").val('');
        //$(".selecione").css("display","none");
        $(".qualTipo").css("display","none");
    }else if(speedTipo == 'outros'){
        $(".qualTipo").css("display","block");
    }else {
        $("#outrospeed").val('');
        $(".qualTipo").css("display","none");

    }
}

function escondeCampo(check){

    var p = $('#p_acesso').val();
    var e = $('#e_acesso').val();
    if((check == 'p_acesso') || (check == 'e_acesso')){
        //$(".selecione").css("display","block");
        $("#outros").attr("disabled", "disabled");
    }else if (check == 'o_acesso'){
        $("#outros").attr("disabled", false);

    }
}




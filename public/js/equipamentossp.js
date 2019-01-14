/**
 * Arquivo criado para as funções de Equipamentos
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */


/**
 * 
 */

function mostraObsSp(idequipamentos)
{
    $.post('Equipamento_sp/mostraObservacoesNaLista',{idequipamentos:idequipamentos},function(data){
        simpleMsg(data);
    });
}

function enviaPlanilhaEquipamentossP()
{
	$('#formEnviaPlanilhaEquipamentos').ajaxSubmit({
		target: '#resposta',
		beforeSubmit: function(){},
		success: function(resposta){

		}
	});
}

function checado(check){

	if(check == 'cadMac'){
			$( ".esconder" ).css("display","block");
			$( ".selecteModem" ).css("display","block");
			$( ".selecteOdu" ).css("display","none");
			$( ".mac" ).removeAttr("disabled");
			$('#sno').attr('readonly','readonly');
			$( ".sno" ).attr("maxLength","10");

			$("#cadMac").attr("disabled","disabled");
			$("#cadOdu").removeAttr("disabled");

			$( ".sno" ).attr("value","");
	}else if(check == 'cadOdu'){
			$("#sno").attr('readonly', 'readonly');
			$( ".esconder" ).css("display","none");
			$( ".selecteModem" ).css('display','none');
			$( ".mac" ).attr("disabled","disabled");
			$( ".selecteOdu" ).css('display','block');

			$("#cadOdu").attr("disabled","disabled");
			$("#cadMac").removeAttr("disabled");

			$( ".sno" ).attr("value","");
	}
}

function selecaoOdu(){
	selecte = $('#tipo_equipamentosOdu').val();

	if(selecte == 2 || selecte == 3){
		$( "#sno" ).attr("maxLength","20");
		$("input").removeAttr('readonly', false);
		$( ".sno" ).attr("value","");
	}else if(selecte == 6 || selecte == 11 || selecte == 12 ){
		$( "#sno" ).attr("maxLength","9");
		$("input").removeAttr('readonly', false);
		$( ".sno" ).attr("value","");
	}
}

function selecaoModem(){
	selecte = $('#tipo_equipamentosModem').val();


	if(selecte == 1 || selecte == 8 || selecte == 7 || selecte == 9 || selecte == 10){
		$("#sno").removeAttr('readonly',false);
		$( "#sno" ).attr("maxLength","10");
		$( ".sno" ).attr("value","");
	}

}
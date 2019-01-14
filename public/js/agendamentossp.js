/**
 * Arquivo criado para as funções da Página Inicial
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */


function atualizaAgendaODUsp()
{
	var nsodu = $('#nsodu').val();

	$.post('AgendaInstal_sp/resgataODUdeNSODUAgenda',{nsodu:nsodu},function(data)
	{
			var num_data = parseInt(data);
			var _elemento = document.getElementById("odu");
			for ( i =0 ; i < _elemento.length ; i++ )
			{
				_elemento[i].selected = _elemento[i].value == num_data ? true : false;
			}
		$('#restrictOdu').removeClass('glyphicon glyphicon-question-sign');

		if(num_data == 0){
			$('#restrictOdu').addClass('glyphicon glyphicon-question-sign');
			$("#respostaConsultaAgenda").html('ODU ou BUC Não Consta na lista de Equipamentos.');
			$('#respostaConsultaAgenda').css('display','block');
			setTimeout('$(\'#respostaConsultaAgenda\').fadeOut()' , 5000 );
		}else if(num_data == 1){
			$('#restrictOdu').addClass('glyphicon glyphicon-question-sign');
			$("#respostaConsultaAgenda").html('NSODU ja esta sendo Usado por uma VSAT.');
			$('#respostaConsultaAgenda').css('display','block');
			setTimeout('$(\'#respostaConsultaAgenda\').fadeOut()' , 5000 );
		}
	});
}


function atualizaNSModemsp(mac)
{
	// atualiza campo de numero de serie do modem
	$.post('Equipamento_sp/buscaNSAgendaPorMac',{mac:mac},function(data){

		if(data != 'macVazio' && data != 'emUso')
		{
			$('#nsmodem').val(data);
			$('#restrictMac').removeClass('glyphicon glyphicon-question-sign');
		}
		else if(data == 'macVazio'){
			$('#restrictMac').addClass('glyphicon glyphicon-question-sign');
			$('#nsmodem').val('');
			$("#respostaConsultaAgenda").html('MAC Não Consta na lista de Equipamentos.');
			$('#respostaConsultaAgenda').css('display','block');
			setTimeout('$(\'#respostaConsultaAgenda\').fadeOut()', 5000 );
		}else if(data == 'emUso'){
			$('#restrictMac').addClass('glyphicon glyphicon-question-sign');
			$('#nsmodem').val('');
			$("#respostaConsultaAgenda").html('MAC ja esta em uso em outra Vsat.');
			$('#respostaConsultaAgenda').css('display','block');
			setTimeout('$(\'#respostaConsultaAgenda\').fadeOut()' , 5000 );
		}else{
			$('#nsmodem').val('');
		}
	});
}

function  cancelConfirmAgendSp(id)
{
	wait();

	Ext.Ajax.request({

	    url: 'AgendaInstal_sp/cancelConfirmAgendSp',
	    params: {

	        id: id,
	        ajax: 1
	    },

		success: function(response)
		{
		    var r = Ext.JSON.decode(response.responseText);

		    if(r.status == 'ok'){
		        sucessMsg('AgendaInstal_sp/edit');
		    }
		    else{
		        erroMsg(r.msg);
		    }

		}
	});
}
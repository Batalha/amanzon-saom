/**
 * Arquivo criado para as funções de Equipamentos
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */


/**
 * 
 */
function mostraObs(idequipamentos)
{
	$.post('Equipamento/mostraObservacoesNaLista',{idequipamentos:idequipamentos},function(data){
		simpleMsg(data);
	});
}


function enviaPlanilhaEquipamentos()
{
	$('#formEnviaPlanilhaEquipamentos').ajaxSubmit({
		target: '#resposta',
		beforeSubmit: function(){},
		success: function(resposta){
			
		}
	});
}

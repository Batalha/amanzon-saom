/**
 * arquivo para servir om objeto Relatorio
 */

function enviaBuscaDia()
{
	$.ajax({
		url:'Relatorio/novaListaAtivacaoVsatsDia',
		type:'POST',
		data:{data:$('#data_lista_nova').val()},
		success:function(result){
			$('#local_lista_dia').html(result);
		}
	});
}

function enviaBuscaPeriodo()
{
	alert('testando');
	$.ajax({
		url:'Relatorio/novaListaAtivacaoVsatsPeriodo',
		type:'POST',
		data:{data:$('#data_lista_nova').val()},
		success:function(result){
			$('#local_lista_dia').html(result);
		}
	});
}
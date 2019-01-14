

function formCompartilhamento( campo , valor )
{
	this.campo = campo;
	this.valor = valor;
}

function submitBuscaCompartilhamento(event)
{
	if(event.keyCode == 13)
	{
		var form = new Array();
		$('.filtros th input').each(function(){
			form.push( new formCompartilhamento($(this).attr('name'),$(this).val()));
		});
		formJson = JSON.stringify(form);
		console.log(formJson);//TODO: tirar isso pq gera erro no IE
		
		$.ajax({
			type:"POST",
			url:"Compartilhamento/liste",
			data:{form:formJson},
			async:false
		}).done(function(data){
			$("#conteudo").html(data).ready(function(){
				arrumaInputFilter();
			});
		});
	}
}
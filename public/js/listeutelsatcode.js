/**
 * 
 */

function arrumaInputFilterSp()
{
	$('.filtros th input').each(function(){
		$(this).css({width:'100%'});
	});
}

function formEutelsatcode(name, value)
{
	this.name = name;
	this.value = value;
}

function submitBuscaEutelsat(event)
{
	if(event.keyCode == 13)
	{
		var form = new Array();
		$('.filtros th input').each(function(){
			form.push(new formEutelsatcode($(this).attr('name'), $(this).val()));
		});
		formJson = JSON.stringify(form);
		//console.log(formJson);//TODO: tirar isso pq gera erro no IE
		
		$.ajax({
			type:"POST",
			url:"OS/eutelsatcode_list_busca",
			data:{form:formJson},
			async:false
		}).done(function(data){
			$("#conteudo").html(data).ready(function(){
				arrumaInputFilter();
			});
		});
	}
}

function mostraFormEutelsat(linha)
{	
	var value = $("#vsatcode_"+linha+" #spanvalue").html();
	
	var miniform = "<input type='text' class='form-control' name='sat_vsat_code' id='sat_vsat_code' value='"+value+"' />";
	miniform += "<input type='hidden' name='sat_vsat_code_orig' id='sat_vsat_code_orig' value='"+value+"' />";
	$("#vsatcode_"+linha).html(miniform);
	
	if(!$('#buttonSalvaEutelsatcode').exists())
	{
		$('#eutelsatbutton').append("<input onclick='salvaFormeutelsat()' id='buttonSalvaEutelsatcode' type='button' class='btn btn-primary' value='Salvar Eutelsat Codes Modificados'/>");
	}
}

function salvaFormeutelsat()
{
	var query = "";
	
	$('#tbLista tbody tr').each(function(){
		if($(this).find('[id^="vsatcode_"] input#sat_vsat_code').exists())
		{
			var idos = $(this).attr('id');
			
			var satvsatcode = $(this).find('[id^="vsatcode_"] input#sat_vsat_code').val();
			var satvsatcode_orig = $(this).find('[id^="vsatcode_"] input#sat_vsat_code_orig').val();
			
			if(satvsatcode != satvsatcode_orig)
			{
				query += "UPDATE instalacoes ";
				query += "SET sat_vsat_code = '"+satvsatcode+"' ";
				query += "WHERE os_idos = '"+idos+"' ; ";
			}
		}
	});
	
	if(query != '')
	{
		$.ajax({
			type:"POST",
			url:"OS/salva_eutelsat_code",
			data:{query:query},
			async:false
		}).done(function(data){
			//alert(data);
			getAjaxForm('OS/eutelsatcode_list');
		});
	}
	else
	{
		getAjaxForm('OS/eutelsatcode_list')
	}
}

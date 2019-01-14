/**
 * 
 */
function toggle(obj) {
	var el = document.getElementById(obj);
	
	if ( el.style.display != 'none' ) {
	el.style.display = 'none';
	}
	else {
	el.style.display = '';
	}
}

function setaAutoCompleteNSODUSp()
{
	$( "#nsodu_comiss" ).autocomplete({
		source: 'Instalacao_sp/listaDeNumerosDeSerieOdu',
		minLength: 2
	});
}


/* autocomplete */
function atualizaODUsp()
{
	var nsodu = $('#nsodu_comiss').val();

	if (nsodu!=''){
		$('#odu').attr('disabled',true);
	}else{
		$('#odu').removeAttr('disabled');
	}

	$.post('Comissionamento_sp/resgataODUdeNSODU',{nsodu:nsodu},function(data)
	{
		var _elemento = document.getElementById("odu");
		var num_data = parseInt(data);
		for ( i =0 ; i < _elemento.length ; i++ )
		{
			_elemento[i].selected = _elemento[i].value == num_data ? true : false;
		}

	}).done(function(){
		$.ajax({
			type: "POST",
			url: "Controller/atualizaCampo_sp",
			data: {
				tabela:'instalacoes_sp',
				campo:'odu',
				valor:$('#odu').val(),
				linha:$('#idinstalacoes_sp').val(),
				campo_id:'idinstalacoes_sp'
			},
			success:function(data){
				//console.log('resultado: '+data);
			}
		});
	});
}

function atualizaNSVsatsp(mac)
{
	// atualiza campo de numero de serie do modem
	$.post('Equipamento_sp/buscaNSVsatPorMac',{mac:mac},function(data){
		if(data != '')
		{
			$('#nsmodem_comiss').val(data);
		}
		else
		{
			$('#nsmodem_comiss').val('');
		}
	}).done(function(){
		$.ajax({
			type: "POST",
			url: "Controller/atualizaCampo_sp",
			data: {
				tabela:'instalacoes_sp',
				campo:'nsmodem_comiss',
				valor:$('#nsmodem_comiss').val(),
				linha:$('#idinstalacoes_sp').val(),
				campo_id:'idinstalacoes_sp'
			},
			success:function(data){
				//console.log('resultado: '+data);
			}
		});
	});
}

// ------------------------------------------------------------------------------
// ------------------ CAMPOS CHECKBOX OBRIGATÓRIOS DO COMISSIONAMENTO -----------
// ------------------------------------------------------------------------------

//execucao
n = 0;
function validaCheckbox() {
	//13 check_obrigatorio
	n = $(".check_obrigatorio:checked").length;
	if( n == 11 ){
		return true;
	}else{
		return false;
	}
}

$(".check_obrigatorio").live( 'click' , function(){  mostraEscondeEnvioTermo(); } );

//primeira verificacao
function mostraEscondeEnvioTermo(){
	var verificacao_abertura = validaCheckbox();
	if( verificacao_abertura == true ){
		$('#termo_aceite_area').css('visibility','visible');
		$('#termo_aceite_area_explicacao').css('visibility','hidden');
	}else{
		$('#termo_aceite_area').css('visibility','hidden');
		$('#termo_aceite_area_explicacao').css('visibility','visible');
	}
}


// -------------------------------------------------------------------------
// ---------- upload da licença anatel -------------------------------------
// -------------------------------------------------------------------------

function atualizaLicencaAnatel(){
	
	
	
}


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

function setaAutoCompleteNSODU()
{
	$( "#nsodu_comiss" ).autocomplete({
		source: 'Instalacao/listaDeNumerosDeSerieOdu',
		minLength: 2
	});
}

function atualizaNSVsat(mac)
{
	// atualiza campo de numero de serie do modem
	$.post('Equipamento/buscaNSVsatPorMac',{mac:mac},function(data){
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
			url: "Controller/atualizaCampo",
			data: { 
				tabela:'instalacoes',
				campo:'nsmodem_comiss',
				valor:$('#nsmodem_comiss').val(),
				linha:$('#idinstalacoes').val(),
				campo_id:'idinstalacoes'
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
	if( n == 13 ){
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


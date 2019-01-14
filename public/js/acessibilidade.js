/**
 * ACESSIBILIDADES
 */

var altura;
var timeout = new Array();

/* --- SCROLLS --- */
	window.onscroll = function (e) 
	{
		altura = window.pageYOffset;
		
		// para menu superior
		if(altura>120)
		{
			$('#MainMenu').css('position','fixed');
			$('#MainMenu').css('top','0px');
			$('#MainMenu').css('width','100%');
		}
		if(altura<120)
		{
			$('#MainMenu').css('position','relative');
		}
		
		//scrollCaixaEntradaHome();
	}


/* --- MUDA APRESENTACAO DE BOAS VINDAS PARA USUARIO CONECTADO --- */	
	$(document).ready(function(){
		setTimeout('mudaTextoBoasVindas()',5000);
	});
	function mudaTextoBoasVindas()
	{
		$('#mensagemBoasVindas').fadeOut(1000,function(){
			$('#textoUsuarioConectado').html('Usuario conectado:');
			$('#exclamacao').html('');
			$('#mensagemBoasVindas').fadeIn(1000);
		});
	}
	
/* LIMPA AVISOS */
	function limpaAvisos()
	{
		if( $('#respostaAjax').length > 0)
		{
			$('#respostaAjax').css( 'display' , 'none' );
		}
	}
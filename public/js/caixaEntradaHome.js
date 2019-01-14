/**
 * Caixa Entrada
 */

var altura_resumo_caixaEntrada;
var altura_botao_esconder;

/* --- SCROLLS --- */
	function scrollCaixaEntradaHome() 
	{
		if( $('.limite_baixo_caixa_home').length )
		{
			altura_limite_baixo = document.getElementById( $('.limite_baixo_caixa_home').attr('id') ).offsetTop;
			
			// para resumo atendimento home
			if( altura > altura_resumo_caixaEntrada && altura < altura_limite_baixo+250 )
			{
				if( $('.resumo_atendimento_home').length )
				{
					$('.resumo_atendimento_home').css('position','fixed');
					$('.resumo_atendimento_home').css('top','31px');
				}else if( $('.resumo_comissionamento_home').length ){
					$('.resumo_comissionamento_home').css('position','fixed');
					$('.resumo_comissionamento_home').css('top','31px');
				}
			}
			if( altura < altura_resumo_caixaEntrada || altura > altura_limite_baixo+250 )
			{
				if( $('.resumo_atendimento_home').length )
				{
					$('.resumo_atendimento_home').css('position','relative');
					$('.resumo_atendimento_home').css('top','0px');
				}else if( $('.resumo_comissionamento_home').length ){
					$('.resumo_comissionamento_home').css('position','relative');
					$('.resumo_comissionamento_home').css('top','0px');
				}
			}
		}
	}
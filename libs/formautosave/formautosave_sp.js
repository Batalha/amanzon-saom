/**
 * Plugin FormAutoSave beta
 * 
 * @author Sávio Resende
 * @email  lotharthesavior@gail.com
 * 
 * Plugin que salva automaticamente os dados modificados
 * em um formulário no banco de dados na tabela correspondente. 
 * 
 * TODO: arrumar html formulario de exemplo
 * TODO: arrumar php de exemplo
 * TODO: implementar filtros
 */
(function($) {

$.fn.formautosave = function(options) {
	
	//parameters
    options= $.extend({
    	url:"Controller/atualizaCampo_sp",//local que executa a query no banco
    	table:"instalacoes_sp",
    	campo:"name",
    	linha:"#idinstalacoes_sp",
    	campoid:"idinstalacoes_sp",
    	funcSucess:""
    }, options);
    
    //vars
    var formulario, tabela_autosave, campo_autosave, 
    valor_autosave, linha_autosave, campo_id, valorAtual;


    //methods
    $(this).live({
    	focus: function(){// FOCUS
    		valorAtual = $(this).val();
    		$(this).parent().addClass('control-group warning');//classe estilo bootstraptwitter
    	},
    	blur: function(){// BLUR

			tabela_autosave = options.table;
			campo_autosave = $(this).attr(options.campo);
			valor_autosave = $(this).val();
			linha_autosave = $(options.linha).val();
			campo_id = options.campoid;
			var verificacao_campo_vazio = 0;
            //alert(valorAtual);
			if( valor_autosave == '' ){
				$("#conteudo").prepend("<div class='avisoExtra'><span class='label label-important'>Campo Não Atualizado!</span></div>");
				setTimeout("$('.avisoExtra').fadeOut()",2000);
				verificacao_campo_vazio = 1;
			}

    		if( valorAtual != valor_autosave && verificacao_campo_vazio != 1 )// para valor modificado
    		{


    			$(this)
    			.attr("readonly",true) // bloqueia input para atualizacao no banco
    			.ready(function(){

    				$.ajax({
    					url:options.url,
    					async:true,
    					type:"POST",
    					data:{
    						tabela:tabela_autosave,
    						campo:campo_autosave,
    						valor:valor_autosave,
    						linha:linha_autosave,
    						campo_id:campo_id
    						}
    				}).done(function(data){
						//alert(valor_autosave);
    					if(data == true)//sucesso
    					{
    						$("#conteudo").prepend("<div class='avisoExtra'><span class='label label-success'>Campo Atualizado!</span></div>");
    						setTimeout("$('.avisoExtra').fadeOut()",2000);
    						$("#"+campo_autosave)
    							.attr("readonly",false)
    							.parent().addClass('control-group success');
    					}
    					else//erro
    					{
    						$("#conteudo").prepend("<div class='avisoExtra'><span class='label label-important'>Campo Não Atualizado!</span></div>");
    						setTimeout("$('.avisoExtra').fadeOut()",2000);
    						$("#"+campo_autosave)
    							.attr("readonly",false)
    							.parent().addClass('control-group error');
    					}
    				});
    			
    			});

    		}
    			setTimeout("$('#"+campo_autosave+"').parent().attr('class','')",1000);
    	}
    });
    
}

})(jQuery);
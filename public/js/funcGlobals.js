/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 */

var idinserido;

function dump(arr,level) 
{
	var dumped_text = "";
	
	if(!level)
	{
		level = 0;
	}

	/*The padding given at the beginning of the line.*/
	var level_padding = "";

	for(var j=0;j<level+1;j++)
	{
		level_padding += "    ";
	}

	if(typeof(arr) == 'object')
	{ 
		/*Array/Hashes/Objects*/
		for(var item in arr) {
			var value = arr[item];
		 
			if(typeof(value) == 'object') 
			{ 
				/*If it is an array,*/
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} 
			else 
			{
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	}
	else
	{ 
		/*Stings/Chars/Numbers etc.*/
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	
	return dumped_text;
} 

Ext.onReady(function(){
    new Ext.Component({
        renderTo: document.body
    });
});
 
/*Envia parâmetros por Ajax*/
function sendPost(url,form,variavel)
{

    wait();

    var f = $('form').serialize();
//    var f = Ext.serializeForm(form);
//    console.log(f);

    if( variavel == 'termo' )
    {
    	// envio do termo de aceite
    	enviaImg('#form_termo_aceite');

    	f = f+'&termo_aceite='+$('#termo_aceite').val();
    }

    if( variavel == 'termo_sp' )
    {
    	// envio do termo de aceite
    	enviaImg('#form_termo_aceite_sp');

    	f = f+'&termo_aceite='+$('#termo_aceite').val();
    }

	$.ajax({
        url: url,
        type:'POST',
        data: {
        	ajax: 1,
        	form: f
	    },
    	success: function( response )
    	{
    		//console.log(response);
    		var r = jQuery.parseJSON(response);
    		if( r.idinserido ){
    			idinserido = r.idinserido;
    		}
    		
    		if(r.status == 'ok')
	        {
	    		if( (variavel == 'termo') || (variavel == 'termo_sp') ){
	    			sucessMsg('termo',form);
	    		}else{
                    //alert(url);
	    			sucessMsg(url,form);
	    		}
	        }
	        else
	        {   
	        	if( (variavel == 'termo') || (variavel == 'termo_sp') ){
	        		erroMsg(r);
	        		$('#termo_aceite').val('');
	        	}else{
		        	erroMsg(r);
	        	}
	        }
        }
    });
}

/*Mensagem genérica de sucesso*/
function sucessMsg(url,form){
	

    objConfig = {
        title   : 'Sucesso',
        msg     : 'Procedimento concluído',
        buttons : Ext.Msg.OK,
        icon    : Ext.window.MessageBox.INFO,
        fn      : function (btn) {

            if(btn == 'ok')
            {
            	/* Retorno */

				//alert(url);
            	switch(url)
            	{
            		/* PEDIDO DE OS */
            		case 'OsPedido/create':
            			getAjaxForm('OsPedido/liste');
            			
            		break;
            		case 'OsPedidoContrato/create':
            			getAjaxForm('OsPedido/liste');

            			break;
					case 'Cliente_sp/edit':
					case 'Cliente_sp/create':
						getAjaxForm('Cliente_sp/liste');

						break;

					case 'Usuario/create':
						getAjaxForm('Usuario/liste');

						break;

                    /*-----OS de Sao Paulo-----------*/
                    case 'OSSP/telefonica':
            			getAjaxForm('OSSP/liste');

            		break;
					case 'OSSP/createAtiOs':
						getAjaxForm('OSSP/liste');

						break;
					case 'OSSP/createOutrosCanais':
            			getAjaxForm('OSSP/liste');

            		break;
                    case 'OSSP/edit':
            			getAjaxForm('OSSP/liste');

            		break;
					case 'OSSP/editAti':
            			getAjaxForm('OSSP/liste');

            		break;
					case 'OSSP/edit_outros_canais':
            			getAjaxForm('OSSP/liste');

            		break;
                    case 'OSSP/despausa':
                    case 'OSSP/pausa':
                        var idos = $('#idOS_reserva').val();
                        getAjaxForm('OSSP/view','conteudo',{param:idos,ajax:1});
                    break;
                    /* AGENDAMENTO */
                    case 'AgendaInstal_sp/create':
                        getAjaxForm('OSSP/liste');

                    break;
                    case 'AgendaInstal_sp/edit':
                        var idAgendInstal = $('#idagenda_instal_sp').val();
                        getAjaxForm('AgendaInstal_sp/view','conteudo',{param:idAgendInstal,ajax:1});
                    break;

                    case 'Equipamento_sp/edit':
                        getAjaxForm('Equipamento_sp/liste');
                        break;

                    case 'Equipamento_sp/create':
                        getAjaxForm('Equipamento_sp/liste');
                        break;

                    case 'Instalacao_sp/edit': /*Edicao de Comissionamento*/

                        if(form=='fInsEdit')
                        {
                            $('#dadosInstal').html('');
                        }
                        else if(form=='form_data_aceite')
                        {
                            getAjaxForm('OSSP/view','conteudo',{param:$('#os_sp_idos').val(),ajax:1});
                        }
                        else
                        {
                            var idIncidente = $('#idInstalacoes_reserva').val();
                            getAjaxForm('Instalacao_sp/comiss_view', 'dadosInstal',{param:idIncidente,ajax:1});
                        }
                        break;

					case 'Incidente_sp/edit': /*Edicao de Incidente*/
						var incidente = $('#idincidentes').val();
						getAjaxForm('Incidente_sp/view','conteudo',{param:incidente,ajax:1});
						break;
					case 'Incidente_sp/create':
						getAjaxForm('Incidente_sp/view','conteudo',{param:idinserido,ajax:1});
						break;
					case 'Incidente_sp/despausar':
					case 'Incidente_sp/pausar':
						var incidente = $('#incidentes_idincidentes').val();
						var idatend = $('#idatend').val();

						//getAjaxForm('Incidente_sp/view','conteudo',{param:idatend,ajax:1});
						$.ajax({
							url: 'Incidente_sp/view',
							type: 'POST',
							data: {param: incidente, idatend: idatend}
						}).done(function(data) {
							$('#conteudo').html(data)
						});
					break;

					case 'Comissionamento_sp/despausar':
					case 'Comissionamento_sp/pausar':
						var idos = $('#idOS_reserva').val();
						getAjaxForm('OSSP/view','conteudo',{param:idos,ajax:1});
						break;

					case 'Comissionamento_sp/edit_comiss':
						getAjaxForm('OSSP/liste');
						break;

					case 'Instalacao_sp/edit_data_aceite':
						getAjaxForm('OSSP/liste');
						break;
					case 'Instalacao_sp/create':
						getAjaxForm('OSSP/liste');
						break;

					case 'Municipio_sp/delete':
						getAjaxForm('Municipio_sp/liste');
						break;
					case 'Municipio_sp/edit':
						getAjaxForm('Municipio_sp/liste');
						break;





            		/* INCIDENTE */
            		case 'Incidente/edit': /*Edicao de Incidente*/
            			var incidente = $('#idincidentes').val();
            			getAjaxForm('Incidente/view','conteudo',{param:incidente,ajax:1});
            			break;
            		case 'Incidente/create':
            			getAjaxForm('Incidente/view','conteudo',{param:idinserido,ajax:1});
            			break;
            			
            		/* PRE INCIDENTE */
            		case 'PreIncidente/update':
            			var preIncidente = $('#id_pre_incidentes').val();
            			getAjaxForm('PreIncidente/view','conteudo',{param:preIncidente,ajax:1});
            			break;
            			
            		/* ATENDIMENTO */
            		case 'AtendVsat/create': /*Criação de Atendimento*/
            			var incidenteId = $('#incidenteID_reserva').val();
            			getAjaxForm('AtendVsat/listeAtendsIncidente','divDinamico',{param:incidenteId,ajax:1});
            			break;
            		case 'AtendVsat/edit': /*Edicao de Atendimento*/
            			var incidenteId = $('#incidenteID_reserva').val();
            			getAjaxForm('AtendVsat/listeAtendsIncidente','divDinamico',{param:incidenteId,ajax:1});
            			break;
            			
            		/* INSTALACAO */
            		case 'Instalacao/edit': /*Edicao de Comissionamento*/
            			if(form=='fInsEdit')
            			{
            				$('#dadosInstal').html('');
            			}
            			else if(form=='form_data_aceite')
            			{
            				getAjaxForm('OS/view','conteudo',{param:$('#os_idos').val(),ajax:1});
            			}
            			else
            			{
            				var idIncidente = $('#idInstalacoes_reserva').val();
                            //alert(idIncidente);
                			getAjaxForm('Instalacao/comiss_view', 'dadosInstal',{param:idIncidente,ajax:1});
                		}
            			break;
            			
            		/* USUARIO */
            		case 'Usuario/edit':
            			var idusuarios = $('#idusuarios').val();
            			var confsenha = $('#conf_senha').val();
            			if(confsenha==undefined)
            			{
            				getAjaxForm('Usuario/view','conteudo',{param:idusuarios,ajax:1});
            			}
            			else
            			{
            				getAjaxForm('Sistema/home');
            			}
            			break;
            		case 'Usuario/verificaAutorizacaoCompartilhamento':
            			//TODO: executar atividade requisitada
            			if(form == 'identificacao_permissao_usuario'){
            				getAjaxForm(
            					'Compartilhamento/apagaCompartilhamento',
            					'lista_compartilhamento',
            					{param:$("#idcompartilhamento").val()},
            					atualizaListaCompartilhamento()
            				);
            			}
            			break;
            			
            		/* AGENDAMENTO */
            		case 'AgendaInstal/edit':
            			var idAgendInstal = $('#idagenda_instal').val();
            			getAjaxForm('AgendaInstal/view','conteudo',{param:idAgendInstal,ajax:1});
            			break;
            			
            		/* MUNICIPIO */
            		case 'Municipio/delete':
            			getAjaxForm('Municipio/liste');
            			break;
            		
            		/* OS */
            		case 'OS/despausa':
            		case 'OS/pausa':
            			var idos = $('#idOS_reserva').val();
            			getAjaxForm('OS/view','conteudo',{param:idos,ajax:1});
            			break;
            		case 'OS/edicao_critica':
            			$('#modal').modal('hide');
            			var idos = $('#idos').val();
            			getAjaxForm('OS/view','conteudo',{param:idos,ajax:1});
            			break;
            			
            		/* EQUIPAMENTO */
            		case 'Equipamento/edit':
	        			getAjaxForm('Equipamento/liste');
	        			break;
            		
	        		// --------------------------------------
	        		// ---------- TERMO ---------------------
	        		// --------------------------------------
            		case 'termo':
            			break;
	        		
            		default:
                    	getAjaxForm('OS/liste');/*DEFAULT*/
                    	break;
            	}
            	
            }
        }
    }
    Ext.Msg.show(objConfig);
}

/*Mensagem gen�rica de erro*/
function erroMsg(r){

    objConfig = {
        title   : r.title? r.title : 'Erro(s) ao efetuar a operação: ',
        msg     : r.msg,
        buttons : Ext.Msg.OK,
        icon    : Ext.window.MessageBox.Error,
        fn      : function (btn) {
            
           
        }
    }
    Ext.Msg.show(objConfig);
}
/*Mensagem genérica*/
function simpleMsg(msg){

	//alert('chegou');

    objConfig = {
        
            msg     : "<p style='text-align: justify;'>"+msg+"</p>",
            buttons : Ext.Msg.OK,
            icon    : Ext.MessageBox.WARNING,
            width   : 200
    }
    Ext.Msg.show(objConfig);
}

/**
 * Retorna um template
 */

function getAjaxForm(url,div,param,fnSucess,paramFn)
{

	wait();

	retiraCronometros(); // limpa setInterval de cronometros


    //alert(! param);

    if ( ! param)
    {
    	param = {param:'',ajax:1};
    }
    div = ! div ? 'conteudo' : div;

	//alert('TESTE');

    Ext.Ajax.request({
        url: url,
        params: param,
        success: function(response)
        {
        	var text = response.responseText;
        	
        	// console.log(text);
        	
        	Ext.get(div).update(text);
	        loadCal();
	        hideMsg();
	        if(fnSucess)
	        {   
	            if(paramFn) 
	            {
	                param = paramFn;
	            }
	            fnSucess(param);
	        }
	        
	        /*funcao para chamar filtros de colunas das tabelas de listagem*/

	        filtroColum();

	        /* --- CHAMADA DE LISTAGEM DAS LISTAS --- */

			//alert(url);

	        	switch(url)
	        	{
	        	/* --------------Contrato--------*/
	        		case 'OsPedidoContrato/create':
	        		
	        		break;
	        	
	        	
	        	
	        	/* --------------Pedido de OS SAO PAULO--------*/
	        		
	        		case 'OsPedido/liste':
	        			desenhaTabelaListpedidoos_sp();
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listapedidoos_sp').addClass('btn-danger');
	        		
	        		break;
	        		case 'OsPedido/create':
	        			$('#lat').setMask();
	        		
	        		break;
	        		
				/* ------------- OS de Sao paulo ------------ */
					case 'OSSP/liste':
						desenhaTabelaListos_sp();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listaos_sp').addClass('btn-danger');
	        		break;
					case 'OSSP/create':
	        			$('#tel_cep').setMask();
	        			$('#tel_cepFaturamento').setMask();
						$('#ati_cep').setMask();
						$('#ati_cepFaturamento').setMask();
						$('#cep').setMask();
						$('#cepFaturamento').setMask();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_novaos_sp').addClass('btn-danger');
	        			break;

                    //case 'OSSP/createOutrosCanais':
                    //    $('#cep').setMask();
                    //    $('#cepFaturamento').setMask();
                    //    break;

                    case 'OSSP/cancela':
                        getAjaxForm('OSSP/liste','conteudo',{param:param,ajax:1})

                        break;


                    case 'OSSP/listaComTerceiroParametro/aceite-1-tudo':

                        $('.li_submenu').removeClass('btn-danger');
                        $('#li_submenu_listatodasos_sp').addClass('btn-danger');
                        break;


                    case 'OSSP/eutelsatcode_list':
                        arrumaInputFilterSp();

                        $('.li_submenu').removeClass('btn-danger');
                        $('#li_submenu_listeutelsatcode').addClass('btn-danger');
                        break;


                    case 'AgendaInstal_sp/liste':
                        desenhaTabelaAgendamentossp();

                        $('.li_submenu').removeClass('btn-danger');
                        $('#li_submenu_listaagendamentos_sp ').addClass('btn-danger');
                        break;
                    case 'AgendaInstal_sp/create':
                        $('#mac').setMask();



                        break;
                    case 'AgendaInstal_sp/edit':
                        $('#mac').setMask();

						//$('#restrictOdu').addClass('glyphicon glyphicon-question-sign');

                        var lista = $('#listaComplete').html();
                        var listaArray = lista.split(',');
                        $("#nsodu").autocomplete(listaArray);



                        break;

                    // COMISSIONAMENTO SAO PAULO
                    case 'Comissionamento_sp/comiss':
                        /* autocomplete */
                        var lista = $('#listaComplete').html();
                        var listaArray = lista.split(',');
                        $("#nsodu_comiss").focus().autocomplete(listaArray);
                        /* mascara */
                        $('#mac_comiss').setMask();
                        /*para comissionamento*/
                        var idinstalacoes = $('#idinstalacoes_sp').val();
                        //inicia comissionamento
                        $.ajax({
                            type:"POST",
                            url:"Comissionamento_sp/inicia_comiss",
                            async:false,
                            data:{idinstalacoes_sp:idinstalacoes},
                            success: function(data){
                                var resultado = data.split('|');
                                if(resultado[0]=='ok')
                                {
                                    $('#comiss_cover').css('display','block');
                                }
                                else
                                {
                                    simpleMsg(resultado[1]);
                                }
                            }
                        });
                        break;

                    case 'Comissionamento_sp/comiss_view':
                        $.ajax({
                            url:'Log_sp/registro_acesso/comissionamento_view',
                            type:'POST',
                            data:{ idos : $('#idOS_reserva').val() },
                            success:function( response ){
                                if( response == 'erro' ){
                                    //console.log('Erro ao registrar Log de acesso em comiss_view.');
                                }else{
                                    //console.log('Log de acesso em comiss_view registrado.');
                                }
                            }
                        });
                        break;

                    case 'Comissionamento_sp/edit_comiss':
                        /*autosave*/
                        formulario = 'comiss_edit';
                        /* autocomplete */
                        var lista = $('#listaComplete').html();
                        var listaArray = lista.split(',');
                        $("#nsodu_comiss").autocomplete(listaArray);
                        /* mascara */
                        $('#mac_comiss').setMask();
                        /*para comissionamento*/
                        var idinstalacoes = $('#idinstalacoes_sp').val();
						//alert(idinstalacoes);

                        $.ajax({
                            url:'Log_sp/registro_acesso/comissionamento_edit',
                            type:'POST',
                            data:{ idinstalacoes_sp : idinstalacoes },
                            success:function( response ){
                                if( response == 'erro' ){
                                    //console.log('Erro ao registrar Log de acesso em comiss_view.');
                                }else{
                                    //console.log('Log de acesso em comiss_view registrado.');
                                }
                            }
                        });
                        break;

                    case 'Equipamento_sp/liste':
                        //alert('teste');
                        desenhaTabelaEquipamentossp();

						//$.ajax({
						//	url:'Equipamento_sp/listeFonte',
						//	type:'POST',
						//	async:false,
						//	data:{param:param['param']},
						//	success:function( resposta ){
						//		$('#flexmeEquipamentossp').html( resposta );
						//	}
						//});

                        break;
                    case 'Equipamento_sp/edit':
                        $('#mac').setMask();
                        break;
                    case 'Equipamento_sp/create':
                        $('#mac').setMask();
                        break;

                    case 'Instalacao_sp/liste':
                        desenhaTabelaInstalacoes();

                        $('.li_submenu').removeClass('btn-danger');
                        $('#li_submenu_listainstalacao').addClass('btn-danger');
                        break;
                    case 'Instalacao_sp/edit':
                        $('#mac').setMask();
                        $('#azimute').setMask();
                        break;

                    case 'Monitor_sp':
                        /*desenhaTabelaMonitor();*/

                        $('.li_submenu').removeClass('btn-danger');
                        $('#li_submenu_monitor').addClass('btn-danger');
                        break;

                    /* - INCIDENTE - */
                    case 'Incidente_sp/liste':
                        desenhaTabelaIncidentessp();
                        //$.ajax({
							//url:'Incidente_sp/listeFonteFiltro',
							//type:'POST',
							//async:false,
							//data:{param:param['param']},
							//success:function( resposta ){
							//	$('#flexmeIncidentessp').html( resposta );
							//}
                        //});
                        ativaSubmenuIncidentessp(); // incidentes.js

                        $('.li_submenu').removeClass('btn-danger');
                        $('#li_submenu_listaincidentes_sp').addClass('btn-danger');
                        break;

                    case 'Incidente_sp/view':
                        rodaCronometrosp( $('#status').val() );
                        $.ajax({
                            url:'AtendVsat_sp/listeAtendsIncidente',
                            type:'POST',
                            async:false,
                            data:{param:param['param']},
                            success:function( resposta ){
                                $('#caixaReservaParaListagem').html( resposta );
                            }
                        });
                        break;

					case 'Incidente_sp/create':
						var lista = $('#listaComplete').html();
						var listaArray = lista.split(',');
						$("#nome_instalacao").focus().autocomplete(listaArray);

						$('.li_submenu').removeClass('btn-danger');
						$('#li_submenu_novoincidente_sp').addClass('btn-danger');
						break;
					case 'Incidente_sp/edit':
						$('#data_fim').setMask();
						break;

					case 'Incidente_sp/view':
						rodaCronometro( $('#status').val() );
						$.ajax({
							url:'AtendVsat_sp/listeAtendsIncidente',
							type:'POST',
							async:false,
							data:{param:param['param']},
							success:function( resposta ){
								$('#caixaReservaParaListagem').html( resposta );
							}
						});
						break;

					case 'PreIncidentes_sp/liste':
						desenhaTabelaPreIncidentessp();

						$('.li_submenu').removeClass('btn-danger');
						$('#li_submenu_listapreincidentes_sp').addClass('btn-danger');
						break;
					case 'PreIncidentesNagios_sp/liste':
						desenhaTabelaPreIncidentesNagiossp();

						$('.li_submenu').removeClass('btn-danger');
						$('#li_submenu_listapreincidentesnagios_sp').addClass('btn-danger');
						break;


					case 'AtendVsat_sp/liste':
						desenhaTabelaAtendimentossp();

						//$.ajax({
						//	url:'AtendVsat_sp/listeFonte',
						//	type:'POST',
						//	async:false,
						//	data:{param:param['param']},
						//	success:function( resposta ){
						//		$('#flexmeListAtendimentossp').html( resposta );
						//	}
						//});

						$('.li_submenu').removeClass('btn-danger');
						$('#li_submenu_listaatendimentos_sp').addClass('btn-danger');
						break;
					case 'AtendVsat_sp/listeAtendsIncidente':
						rodaCronometrosp( $('#status').val() );
						break;
					case 'AtendVsat_sp/view':
						rodaCronometrosp( $('#status').val() );
						break;
					case 'AtendVsat_sp/edit':
						rodaCronometrosp( $('#status').val() );
						break;
					case 'AtendVsat_sp/create':
						rodaCronometrosp( $('#status').val() );
						break;


                    /* - ACOMPANHAMENTO - SAO PAULO */
                    case 'Acompanhamento_sp/acompanhamentoNoc':
                        desenhaTabelaAcompanhamentosChamadosFullNocsp();

                        //$.ajax({
                        //	url:'Acompanhamento_sp/acompanhamentoNocConteudo',
                        //	type:'POST',
                        //	async:false,
                        //	data:{param:param['param']},
                        //	success:function( resposta ){
                        //		$('#flexmeListChamadosFullsp').html( resposta );
                        //	}
                        //});


                        break;
                    case 'Acompanhamento_sp/acompanhamentoCom':
                        desenhaTabelaAcompanhamentosChamadosFullComsp();
                        //$.ajax({
                        //	url:'Acompanhamento_sp/acompanhamentoComConteudo',
                        //	type:'POST',
                        //	async:false,
                        //	data:{param:param['param']},
                        //	success:function( resposta ){
                        //		$('#flexmeListChamadosFullsp').html( resposta );
                        //	}
                        //});

                        break;
                    case 'Acompanhamento_sp/acompanhamentoCampo':
                        desenhaTabelaAcompanhamentosChamadosFullCamposp();
                        break;


					case 'Usuario/liste':
					$('#_filterText7').prop('type','hidden');
					break;

					case 'Cliente_sp/liste':
						$('#_filterText5').prop('type','hidden');
						break;

					case 'Cliente_sp/liste_emails':
						$('#_filterText3').prop('type','hidden');
						break;

	        	/* ------------- OS -------------- */
	        		case 'OS/Create':
	        			$('#cep').setMask();
	        			$('#cepFaturamento').setMask();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_novaos').addClass('btn-danger');
	        			break;
	        		case 'OS/edit':
	        			$('#cep').setMask();
	        			$('#cepFaturamento').setMask();
	        			break;
	        		case 'OS/liste':
	        			desenhaTabelaListos();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listaos').addClass('btn-danger');
	        			break;
	        		case 'OS/cancela':
	        			getAjaxForm('OS/liste','conteudo',{param:param,ajax:1})

	        			break;
	        		case 'OS/eutelsatcode_list':
            			arrumaInputFilter();
            			
            			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listeutelsatcode').addClass('btn-danger');
            			break;
	        		case 'OS/listaComTerceiroParametro/aceite-1-tudo':
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listatodasoss').addClass('btn-danger');
	        			break;
	        		case 'OS/relatorio':
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_relatorio').addClass('btn-danger');
	        			break;
	        		case 'OS/relatorioAcompanhamento':
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_relatorioacompanhamento').addClass('btn-danger');
	        			break;
	        		case 'OS/relatorioAnatel':
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_relatorioanatel').addClass('btn-danger');
	        			break;
	        		/* - AGENDAMENTO - */
	        		case 'AgendaInstal/liste':
	        			desenhaTabelaAgendamentos();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listaagendamentos').addClass('btn-danger');
	        			break;
	        		case 'AgendaInstal/edit':
	        			var lista = $('#listaComplete').html();
	        			var listaArray = lista.split(',');
	        			$("#nsodu").autocomplete(listaArray);
	        			$('#mac').setMask();
	        			break;
	        		case 'AgendaInstal/create':
	        			$('#mac').setMask();
	        			break;
	        			
	        		/* - INSTALACAO - */
	        		case 'Instalacao/liste':
	        			desenhaTabelaInstalacoes();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listainstalacao').addClass('btn-danger');
	        			break;
	        		case 'Instalacao/edit':
	        			$('#mac').setMask();
	        			$('#azimute').setMask();
	        			break;
	        			
	        		// COMISSIONAMENTO
	        		case 'Comissionamento/comiss':
	        			/* autocomplete */
	        			var lista = $('#listaComplete').html();
	        			var listaArray = lista.split(',');
	        			$("#nsodu_comiss").focus().autocomplete(listaArray);
	        			/* mascara */
	        			$('#mac_comiss').setMask();
	        			/*para comissionamento*/
	        			var idinstalacoes = $('#idinstalacoes').val();
	        			//inicia comissionamento
	        			$.ajax({
	        				type:"POST",
	        				url:"Comissionamento/inicia_comiss",
	        				async:false,
	        				data:{idinstalacoes:idinstalacoes},
	        				success: function(data){
	        					var resultado = data.split('|');
		        				if(resultado[0]=='ok')
		        				{
		        					$('#comiss_cover').css('display','block');
		        				}
		        				else
		        				{
		        					simpleMsg(resultado[1]);
		        				}
		        			}
	        			});
	        			break;
	        		case 'Comissionamento/edit_comiss':
	        			/*autosave*/
	        			formulario = 'comiss_edit';
	        			/* autocomplete */
	        			var lista = $('#listaComplete').html();
	        			var listaArray = lista.split(',');
	        			$("#nsodu_comiss").autocomplete(listaArray);
	        			/* mascara */
	        			$('#mac_comiss').setMask();
	        			/*para comissionamento*/
	        			var idinstalacoes = $('#idinstalacoes').val();
	        			
	        			$.ajax({
	        				url:'Log/registro_acesso/comissionamento_edit',
	        				type:'POST',
	        				data:{ idinstalacoes : idinstalacoes },
	        				success:function( response ){
	        					if( response == 'erro' ){
	        						//console.log('Erro ao registrar Log de acesso em comiss_view.');
	        					}else{
	        						//console.log('Log de acesso em comiss_view registrado.');
	        					}
	        				}
	        			});
	        			break;
	        		case 'Comissionamento/comiss_view':
	        			$.ajax({
	        				url:'Log/registro_acesso/comissionamento_view',
	        				type:'POST',
	        				data:{ idos : $('#idOS_reserva').val() },
	        				success:function( response ){
	        					if( response == 'erro' ){
	        						//console.log('Erro ao registrar Log de acesso em comiss_view.');
	        					}else{
	        						//console.log('Log de acesso em comiss_view registrado.');
	        					}
	        				}
	        			});
	        			break;
	        			
	        		/* - MONITOR - */
	        		case 'Monitor':
	        			/*desenhaTabelaMonitor();*/
							
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_monitor').addClass('btn-danger');
	        			break;
	        			
	        		/* - INCIDENTE - */
	        		case 'Incidente/liste':
	        			desenhaTabelaIncidentes();
                        //$.ajax({
							//url:'Incidente/listeFonte',
							//type:'POST',
							//async:false,
							//data:{param:param['param']},
							//success:function( resposta ){
							//	$('#flexmeIncidentes').html( resposta );
							//}
                        //});
	        			ativaSubmenuIncidentes(); // incidentes.js
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listaincidentes').addClass('btn-danger');
	        			break;
	        		case 'Incidente/view':
	        			rodaCronometro( $('#status').val() );
	        			$.ajax({
							url:'AtendVsat/listeAtendsIncidente',
							type:'POST',
							async:false,
							data:{param:param['param']},
							success:function( resposta ){
								$('#caixaReservaParaListagem').html( resposta );
	        				}
						});
	        			break;
	        		case 'Incidente/create':
	        			var lista = $('#listaComplete').html();
	        			var listaArray = lista.split(',');
						$("#nome_instalacao").focus().autocomplete(listaArray);

	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_novoincidente').addClass('btn-danger');
	        			break;
	        		case 'Incidente/edit':
	        			$('#data_fim').setMask();
	        			break;
	        		case 'PreIncidentes/liste':
	        			desenhaTabelaPreIncidentes();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listapreincidentes').addClass('btn-danger');
	        			break;
	        		case 'PreIncidentesNagios/liste':
	        			desenhaTabelaPreIncidentesNagios();
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listapreincidentesnagios').addClass('btn-danger');
	        			break;
	        		
	        		/* - ACOMPANHAMENTO - */
	        		case 'Acompanhamento/acompanhamentoNoc':
                        //alert('noc');
                        desenhaTabelaAcompanhamentosChamadosFullNoc();
	        			break;
	        		case 'Acompanhamento/acompanhamentoCom':
                        desenhaTabelaAcompanhamentosChamadosFullCom();
                        //$.ajax({
                        //url:'Acompanhamento/acompanhamentoComConteudo',
                        //type:'POST',
                        //async:false,
                        //data:{param:param['param']},
                        //success:function( resposta ){
							//$('#flexmeListChamadosFull').html( resposta );
                        //}
                        //});
	        			break;
	        		case 'Acompanhamento/acompanhamentoCampo':
                        desenhaTabelaAcompanhamentosChamadosFullCampo();
	        			break;


	        			
	        		/* - EQUIPAMENTO - */
	        		case 'Equipamento/liste':
	        			desenhaTabelaEquipamentos();

						//$.ajax({
						//	url:'Equipamento/listeFonte',
						//	type:'POST',
						//	async:false,
						//	data:{param:param['param']},
						//	success:function( resposta ){
						//		$('#flexmeEquipamentos').html( resposta );
						//	}
						//});

	        			break;
	        		case 'Equipamento/edit':
	        			$('#mac').setMask();
	        			break;
	        		case 'Equipamento/create':
	        			$('#mac').setMask();
	        			break;
	        			
	        		/* - COMPARTILHAMENTO - */
	        		case 'Compartilhamento/apagaCompartilhamento':
	        			atualizaListaCompartilhamento();
	        			break;


	        			
	        		/* - ATEND VSAT - */
	        		case 'AtendVsat/liste':
	        			desenhaTabelaAtendimentos();


						//$.ajax({
						//	url:'AtendVsat/listeFonte',
						//	type:'POST',
						//	async:false,
						//	data:{param:param['param']},
						//	success:function( resposta ){
						//		$('#flexmeListAtendimentos').html( resposta );
						//	}
						//});
	        			
	        			$('.li_submenu').removeClass('btn-danger');
	        			$('#li_submenu_listaatendimentos').addClass('btn-danger');
	        			break;
	        		case 'AtendVsat/listeAtendsIncidente':
	        			rodaCronometro( $('#status').val() );
	        			break;
	        		case 'AtendVsat/view':
	        			rodaCronometro( $('#status').val() );
	        			break;
	        		case 'AtendVsat/edit':
	        			rodaCronometro( $('#status').val() );
	        			break;
	        		case 'AtendVsat/create':
	        			rodaCronometro( $('#status').val() );
	        			break;
	        	}
        }
    });
}

/*cria uma mensagem de espera*/
function wait(msg){

   msg = msg ? msg : 'Aguarde, carregando...';
   
   var objConfig = {
        
        title   : msg,
        msg     : "<div id='loading'></div>"
    }
   
   Ext.Msg.show(objConfig);
   
   var p = Ext.create('Ext.ProgressBar', {
        
        renderTo: 'loading'
   });
    
   p.wait();
   
}

function hideWin(div,show){

    if ( ! show )
        
        el = Ext.getDom(div).style.display = 'none';
    
    else
        
        el = Ext.getDom(div).style.display = 'block';
}

function onOver(el){
    
    el.style.backgroundColor = '#b7cbe7';
}

function onUp(el,clas){
    
    if(clas == 'trCor')
        
        clas =  '#e8e7e7';
    else
        
        clas = 'white';
    
    el.style.backgroundColor = clas;
}

function hideMsg()
{
    Ext.Msg.hide();
}

function loadCal()
{
    $(function() 
    {
    	/* para datas */
        $("#data" ).datepicker({dateFormat: 'dd/mm/yy'});
        $("#data_inicio" ).datepicker({dateFormat: 'dd/mm/yy'});
        $("#data_fim" ).datepicker({dateFormat: 'dd/mm/yy'});
        $("#prazoInstal").datepicker({dateFormat: 'dd/mm/yy'});
        $("#data_ativacao").datepicker({dateFormat: 'dd/mm/yy'});
        $("#dataSolicitacao").datepicker({dateFormat: 'dd/mm/yy'});
        $("#tel_dataSolicitacao").datepicker({dateFormat: 'dd/mm/yy'});
        $("#ati_dataSolicitacao").datepicker({dateFormat: 'dd/mm/yy'});
        $("#data_aceite").datepicker({dateFormat: 'dd/mm/yy'});
        $("#campoDataParalisacao").datepicker({dateFormat: 'dd/mm/yy'});
    });
}

function updateList()
{
    var osList = Ext.getDom('OSlist');
    if(osList)
    {
    	getAjaxForm('OS/liste')
    }
}

var getDadosInstal = function getDadosInstal(id)
{
	wait();
    Ext.Ajax.request({
        url: 'Instalacao/getDadosInstal',
        params: {    
            id: id,
            ajax: 1
        },
	    success: function(response){
	    	var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('nome').value = r.nome;
	        Ext.getDom('mac').value = r.mac;
	        Ext.getDom('iplan').value = r.iplan;
	        Ext.getDom('mascaraLan').value = r.mascaraLan;
	        hideMsg();
        }
    });
}

var getDadosInstalsp = function getDadosInstalsp(id)
{
	wait();
    Ext.Ajax.request({
        url: 'Instalacao_sp/getDadosInstalSp',
        params: {
            id: id,
            ajax: 1
        },
	    success: function(response){
	    	var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('nome').value = r.nome;
	        Ext.getDom('mac').value = r.mac;
	        //Ext.getDom('iplan').value = r.iplan;
	        Ext.getDom('mascaraLan').value = r.mascaraLan;
	        hideMsg();
        }
    });
}
 
var  getDadosAgend = function  getDadosAgend(id)
{
    wait();	
    Ext.Ajax.request({
        url: 'Instalacao/getDadosInstal',
        params: {
            id: id,
            ajax: 1
        },
    	success: function(response)
    	{
    		var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('odu').value         = r.agenda_instal.odu;
	        Ext.getDom('nsodu').value       = r.agenda_instal.nsodu;
	        Ext.getDom('antena').value      = r.agenda_instal.antena;
	        Ext.getDom('antena_tam').value  = r.agenda_instal.antena_tam;
	        Ext.getDom('antena_ns').value   = r.agenda_instal.antena_ns;
	        hideMsg();
    	}
    });
}

var  getDadosAgendSp = function  getDadosAgendSp(id)
{
    wait();
    Ext.Ajax.request({
        url: 'Instalacao_sp/getDadosInstalSp',
        params: {
            id: id,
            ajax: 1
        },
    	success: function(response)
    	{
    		var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('odu').value         = r.agenda_instal_sp.odu;
	        Ext.getDom('nsodu').value       = r.agenda_instal_sp.nsodu;
	        Ext.getDom('antena').value      = r.agenda_instal_sp.antena;
	        Ext.getDom('antena_tam').value  = r.agenda_instal_sp.antena_tam;
	        Ext.getDom('antena_ns').value   = r.agenda_instal_sp.antena_ns;
	        hideMsg();
    	}
    });
}

var getDadosComiss = function getDadosAgend(id)
{
    wait();
    Ext.Ajax.request({
        url: 'Instalacao/getDadosComiss',
        params: {
            id: id,
            ajax: 1
        },
    	success: function(response)
    	{
	        var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('nsmodem_comiss').value     = r.rel.agenda_instal.nsmodem;
	        Ext.getDom('nsodu_comiss').value       = r.rel.agenda_instal.nsodu;
	        Ext.getDom('mac_comiss').value         = r.rel.agenda_instal.mac;
	        Ext.getDom('antena_comiss').value      = r.rel.agenda_instal.antena;
	        Ext.getDom('antena_ns_comiss').value   = r.rel.agenda_instal.antena_ns;
	        
	        /*Verificação para o comissionamento*/
			    decisao = confirm('Está preparado para Comissionamento?	\n Obs.: a partir dessa confirmação o tempo de execução da tarefa começará a ser contabilizado.');
			    if(!decisao)
			    {
			    	$('#dadosInstal').html('');
			    	hideMsg();
			    }
			    else
			    {
			    	hideMsg();
			    }
    	}
	});
}

var getDadosComissSp = function getDadosAgend(id)
{
    wait();
    Ext.Ajax.request({
        url: 'Instalacao_sp/getDadosComiss',
        params: {
            id: id,
            ajax: 1
        },
    	success: function(response)
    	{
	        var r = Ext.JSON.decode(response.responseText);
	        Ext.getDom('nsmodem_comiss').value     = r.rel.agenda_instal_sp.nsmodem;
	        Ext.getDom('nsodu_comiss').value       = r.rel.agenda_instal_sp.nsodu;
	        Ext.getDom('mac_comiss').value         = r.rel.agenda_instal_sp.mac;
	        Ext.getDom('antena_comiss').value      = r.rel.agenda_instal_sp.antena;
	        Ext.getDom('antena_ns_comiss').value   = r.rel.agenda_instal_sp.antena_ns;

	        /*Verificação para o comissionamento*/
			    decisao = confirm('Está preparado para Comissionamento?	\n Obs.: a partir dessa confirmação o tempo de execução da tarefa começará a ser contabilizado.');
			    if(!decisao)
			    {
			    	$('#dadosInstal').html('');
			    	hideMsg();
			    }
			    else
			    {
			    	hideMsg();
			    }
    	}
	});
}
 
function btRadioComiss(val)
{
    if ( val == 'não' ){
        
        simpleMsg("Antes que o comissionamento seja realizado, é necessário contactar a EutelSat para efetuar o cross-pol");
        Ext.get('FCOMISS').ghost();
    }
}
 
function enviaImg(form)
{
    //alert(form);
	//debugger;
	
	/*Distingue a imagem*/
		switch(form)
		{
			case '#form_up_img_1':
				var imagemAtual = $('#img1').val();
				var localImg = '#localImg1';
				var pasta = 'incidentes';
				var formato = 'img';
				break;
			case '#form_up_img_2':
				var imagemAtual = $('#img2').val();
				var localImg = '#localImg2';
				var pasta = 'incidentes';
				var formato = 'img';
				break;
			case '#form_up_img_down':
				var imagemAtual = $('#img_down_up').val();
				var localImg = '#form_up_img_down';
				var pasta  = 'instalacoes';
				var formato = 'img';
				break;
			case '#form_up_img_ping':
				var imagemAtual = $('#img_ping').val();
				var localImg = '#form_up_img_ping';
				var pasta  = 'instalacoes';
				var formato = 'img';
				break;



			case '#form_termo_aceite':
				var imagemAtual = $('#termo_aceite').val();
				var localImg = '#form_termo_aceite';
				var pasta  = 'instalacoes';
				var formato = 'file';
				var novoCampo = "termo_aceite";
				break;

            case '#form_termo_aceite_sp':
				var imagemAtual = $('#termo_aceite').val();
				var localImg = '#form_termo_aceite_sp';
				var pasta  = 'instalacoes_sp';
				var formato = 'file';
				var novoCampo = "termo_aceite";
				break;



			case '#upload_licenca_anatel':
				var imagemAtual = $('#licenca_anatel').val();
				var localImg = '#upload_licenca_anatel';
				var pasta  = '';
				var formato = 'licenca_anatel';
				var novoCampo = "";
				break;
			case '#form_compartilhamento':
				var imagemAtual = $('#endereco').val();
				var localImg = '#form_compartilhamento';
				var pasta = 'upload';
				var formato = 'compartilhamento';
				var novoCampo = "";
				break;
			case '#form_relatorio_anatel':
				var imagemAtual = $('#arquivo_csv').val();
				var localImg = '';
				var pasta = 'upload';
				var formato = 'arquivo_csv';
				var novoCampo = "";
				break;
		}
		var imagemAtual2 = imagemAtual.split('\\');
		var imagemEnviada = imagemAtual2[imagemAtual2.length-1];
		
		//alert(form);
	// ---------------------------------------------------------------------------
	// -------------------- Envia a imagem ---------------------------------------
	// ---------------------------------------------------------------------------
		
		$(form).ajaxSubmit({
			target: form+'_result',
			beforeSubmit: function(){},
			success: function(resposta){
				
				// ---------------------------------------------------------------------------
				// --------------  Funcao para trocar o img atual pelo novo  -----------------
				// ---------------------------------------------------------------------------
				
					switch(formato)
					{
						case 'img':
							$(localImg).html('<img style="width:300px;" src="public/imagens/'+pasta+'/'+imagemEnviada+'" />');
							break;
						case 'file':
							$(localImg).html('<a href="public/imagens/'+pasta+'/'+imagemEnviada+'" target="_blank">Termo Aceite</a>');
							$(localImg).append('<input type="hidden" name="'+novoCampo+'" id="'+novoCampo+'" value="public/imagens/'+pasta+'/'+imagemEnviada+'"/>');
							
							// ------------------- codigo para obrigar salvar formulário
							
							break;
						case 'compartilhamento':
							atualizaListaCompartilhamento();
							break;
						case 'licenca_anatel':
							setTimeout(function(){
								$('#local_licenca_anatel_status').fadeOut();
							},5000);
							break;
					}
				
				// ----------------------------------------------------------------------------
				// --- atualiza status e envio de termo (PARA FINALIZACAO DE COMISSIONAMENTO) -
				// ----------------------------------------------------------------------------


				
					switch(form)
					{
						case '#form_termo_aceite':
							var idinstalacoes = $('#idinstalacoes').val();
							$('#test_e_termo_aceite').attr('checked', true).ready(function(){
								$.ajax({
									async:true,
									type:"POST",
									data:{idinstalacoes:idinstalacoes},
									url:"Instalacao/gravaDataFim"
								}).done(function(data){
									//sendPost('Instalacao/edit_comiss','FCOMISS');
								});
							});
							//sendPost('Instalacao/edit_comiss','FCOMISS');
							break;

                        case '#form_termo_aceite_sp':
							var idinstalacoes = $('#idinstalacoes_sp').val();
							$('#test_e_termo_aceite').attr('checked', true).ready(function(){
								$.ajax({
									async:true,
									type:"POST",
									data:{idinstalacoes_sp:idinstalacoes},
									url:"Instalacao_sp/gravaDataFim"
								}).done(function(data){
									//sendPost('Instalacao/edit_comiss','FCOMISS');
								});
							});
							//sendPost('Instalacao/edit_comiss','FCOMISS');
							break;
					}

				setTimeout('$("#recadoEnvioImg").fadeOut("slow")',1000);
				
				
				// ---------------------------------------------------------------------------
				// --------- SOLUCAO PARA ERRO COM A DATA FIM DO COMISSIONAMENTO -------------
				// ---------------------------------------------------------------------------
				
				// sendPost("Instalacao/edit_comiss","FCOMISS")
			},
			error:function(){
				$('#termo_aceite').val('');
			}
		});
	
	//sucessMsg('termo','');
}

	 
function simpleRequest(div,url)
{      
    Ext.Ajax.request({
        url: url,
        
        params: {
            id: id,
            ajax: 1
        },
        
        success: function(response)
    	{
        	var r = Ext.JSON.decode(response.responseText);
        	Ext.getDom(div).innerHTML    = r.result;     
    	}
    });
}

function copyCmpComiss()
{
    Ext.getDom('ope_eutelsat_noc').value = Ext.getDom('ope_eutelsat').value;
    Ext.getDom('val_crosspol_noc').value = Ext.getDom('val_crosspol').value;
    Ext.getDom('latitude_comiss_noc').value = Ext.getDom('latitude_comiss').value;
    Ext.getDom('longitude_comiss_noc').value = Ext.getDom('longitude_comiss').value;
    Ext.getDom('azimute_comiss_noc').value = Ext.getDom('azimute_comiss').value;
    Ext.getDom('elevacao_comiss_noc').value = Ext.getDom('elevacao_comiss').value;
    Ext.getDom('snr_comiss_noc').value = Ext.getDom('snr_comiss').value;
    Ext.getDom('nsmodem_comiss_noc').value = Ext.getDom('nsmodem_comiss').value;
    Ext.getDom('mac_comiss_noc').value = Ext.getDom('mac_comiss').value;
    Ext.getDom('nsodu_comiss_noc').value = Ext.getDom('nsodu_comiss').value;
    Ext.getDom('antena_comiss_noc').value = Ext.getDom('antena_comiss').value;
    Ext.getDom('antena_ns_comiss_noc').value = Ext.getDom('antena_ns_comiss').value;
}

function showFields(cb)
{

    //alert(cb.id);
	switch(cb.id)
	{
		case 'test_tx':
			if(cb.checked) 
			{
				$('.tx_input_1').css('visibility','visible');
				$('.tx_input_2').css('visibility','visible');
	        }
	        else
	        {
	        	$('.tx_input_1').css('visibility','hidden');
				$('.tx_input_2').css('visibility','hidden');
	        }
			break;

		case 'test_cabo':
			if(cb.checked)
			{
				$('.cabo_input').css('visibility','visible');
	        }
	        else 
	        {
	        	$('.cabo_input').css('visibility','hidden');
	        }
			break;
			
		case 'test_clima':
			if(cb.checked) 
			{
				$('.clima_inputs').css('visibility','visible');  
	        }
	        else 
	        {
	        	$('.clima_inputs').css('visibility','hidden');
	        }
			break;
			
		case 'cabo_rj45':
			if(cb.checked)
			{
				$('#pergunta_cabo_rj45').html('Onde?');
				$('#cabo_rj45_justificativa_sim').css({
					visibility:'visible',
					position:'relative'
				});
				$('#cabo_rj45_justificativa_nao').css({
					visibility:'hidden',
					position:'absolute'
				});
			}
			else
			{
				$('#pergunta_cabo_rj45').html('Porque?');
				$('#cabo_rj45_justificativa_sim').css({
					visibility:'hidden',
					position:'absolute'
				});
				$('#cabo_rj45_justificativa_nao').css({
					visibility:'visible',
					position:'relative'
				});
			}
			break;
	} 
         
}

function verifSenha(senha,confSenha)
{
    if( senha != confSenha )
    {
        simpleMsg("Senha e Confirmação de senha são diferentes, por favor corrija.");
        return false;
    }
    else if( senha.length < 5 )
    {
        simpleMsg("Senha muito pequena");
        return false;
    }
    else 
    {
        sendPost('Usuario/trocarSenha','fUsEdit');
        return true;
    }
}

function verifEquip(sno){
    
     Ext.Ajax.request({
        
        url: 'Equipamento/findByNS',
        params: {
            
            sno: sno,
            ajax: 1
    },
    
    success: function(response){
        
        var r = Ext.JSON.decode(response.responseText);
        
        if(r.result == 0) {
           
          var aux = new Array();
          
          aux['title'] = "Erro";
          aux['msg'] = "Número de série não consta na database, verifique se está correto";
          erroMsg(aux);
           
        }
       }
    });
    
}

function verifEquipSp(sno){

     Ext.Ajax.request({

        url: 'Equipamento_sp/findByNS',
        params: {

            sno: sno,
            ajax: 1
    },

    success: function(response){

        var r = Ext.JSON.decode(response.responseText);

        if(r.result == 0) {

          var aux = new Array();

          aux['title'] = "Erro";
          aux['msg'] = "Número de série não consta na database, verifique se está correto";
          erroMsg(aux);

        }
       }
    });

}

/* CODIGO DE STRIP TAGS PARA JAVASCRIPT 
 * fonte: http://phpjs.org/functions/strip_tags:535
 */
	function strip_tags (input, allowed) 
	{
	    // Strips HTML and PHP tags from a string  
	    // 
	    // version: 1109.2015
	    // discuss at: http://phpjs.org/functions/strip_tags
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   improved by: Luke Godfrey
	    // +      input by: Pul
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   bugfixed by: Onno Marsman
	    // +      input by: Alex
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +      input by: Marc Palau
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +      input by: Brett Zamir (http://brett-zamir.me)
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   bugfixed by: Eric Nagel
	    // +      input by: Bobby Drake
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   bugfixed by: Tomasz Wesolowski
	    // +      input by: Evertjan Garretsen
	    // +    revised by: Rafał Kukawski (http://blog.kukawski.pl/)
	    // *     example 1: strip_tags('<p>Kevin</p> <b>van</b> <i>Zonneveld</i>', '<i><b>');
	    // *     returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
	    // *     example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
	    // *     returns 2: '<p>Kevin van Zonneveld</p>'
	    // *     example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
	    // *     returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
	    // *     example 4: strip_tags('1 < 5 5 > 1');
	    // *     returns 4: '1 < 5 5 > 1'
	    // *     example 5: strip_tags('1 <br/> 1');
	    // *     returns 5: '1  1'
	    // *     example 6: strip_tags('1 <br/> 1', '<br>');
	    // *     returns 6: '1  1'
	    // *     example 7: strip_tags('1 <br/> 1', '<br><br/>');
	    // *     returns 7: '1 <br/> 1'
	    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
	        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
	        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	    });
	}
/* CODIGO DE STRIP TAGS PARA JAVASCRIPT - fim */


/* autocomplete */
	function atualizaODU()
	{
		var nsodu = $('#nsodu_comiss').val();
		
		$.post('Comissionamento/resgataODUdeNSODU',{nsodu:nsodu},function(data)
		{
			var _elemento = document.getElementById("odu");
			var num_data = parseInt(data)
			for ( i =0 ; i < _elemento.length ; i++ )
	        {
	        	_elemento[i].selected = _elemento[i].value == num_data ? true : false;
	        }
		});
	}

/* autocomplete */
	
	
/* EXTRAS */
	/* Atualiza lista de compartilhamento */
	function atualizaListaCompartilhamento()
	{
		getAjaxForm('Compartilhamento/listaNova','lista_compartilhamento');
	}
	jQuery.fn.exists = function ()
	{
	    return jQuery(this).length > 0 ? true : false;
	};
	
	$(document).ready(function(){

		$('[placeholder]')
			.focus(function() {
				var input = $(this);
				if( input.val() == input.attr('placeholder') ){
					input.val('');
					input.removeClass('placeholder');
					
					if( input.attr('name') == 'senha' ){
						document.getElementById('senha').type = 'password';
					}
				}
			})
			.blur(function() {
				var input = $(this);
				if (input.val() == '' || input.val() == input.attr('placeholder')) {
					input.addClass('placeholder');
					input.val(input.attr('placeholder'));
					
					if( input.attr('name') == 'senha' ){
						document.getElementById('senha').type = 'text';
					}
				}
			})
			.blur();


	});
/* EXTRAS */

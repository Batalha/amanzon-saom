/**
 * 
 */

$(window).bind('hashchange',function(){
	
	//limpa hash
	var hash = window.location.hash;
		
	hash = hash.substr(1);


    //alert(hash);
	switch(hash)
	{
		//TRATAMENTO DO MENU PRINCIPAL SAO PAULO
		
			case 'instalacao_sp':
				getAjaxForm('OSSP/liste');
			break;

            case 'equipamentos_sp':
                getAjaxForm('Equipamento_sp/liste');
            break;
		
		//TRATAMENTO DO MENU PRINCIPAL
			case 'home':
				getAjaxForm('Sistema/home');
				break;
			case 'solicitacao':
				getAjaxForm('OsPedido/liste');
				break;
			case 'instalacao':
				getAjaxForm('OS/liste');
				break;
			case 'acompanhamento':
				getAjaxForm('Acompanhamento/liste');
				break;
			case 'mudaplano':
				getAjaxForm('MudaPlano/liste');
				break;
			case 'cancelamento':
				getAjaxForm('Cancelamento/liste');
				break;
			case 'equipamentos':
				getAjaxForm('Equipamento/liste');
				break;
			case 'relatorios':
				getAjaxForm('Relatorios/liste');
				break;
			case 'administrar':
				getAjaxForm('Usuario/liste');
				break;
			case 'compartilhamento':
				getAjaxForm('Compartilhamento/liste');
				break;
			case 'municipios':
				getAjaxForm('Municipio/liste');
				break;
			case 'trocasenha':
				getAjaxForm('Usuario/change_pass');
				break;
				
		//TRATAMENTO DE SUBMENUS
			//acompanhamento
			case 'acompanhamentonoc':
				getAjaxForm('Acompanhamento/acompanhamentoNoc');
				break;
			case 'acompanhamentocampo':
				getAjaxForm('Acompanhamento/acompanhamentoCampo');
				break;
			case 'acompanhamentocom':
				getAjaxForm('Acompanhamento/acompanhamentoCom');
				break;
			//agenda_instal
			case 'agendainstal':
				getAjaxForm('AgendaInstal/liste');
				break;
			//cancelamentos
			case 'listacancelamentos':
				getAjaxForm('Cancelamento/liste');
				break;
			//tipo equipamentos
			case 'listatipoequipamentos':
				getAjaxForm('TipoEquipamento/liste');
				break;
			case 'novotipoequipamento':
				getAjaxForm('TipoEquipamento/create');
				break;
			//mudaplano
			case 'listamudaplano':
				getAjaxForm('MudaPlano/liste');
				break;
			//municipio
			case 'listamunicipios':
				getAjaxForm('Municipio/liste');
				break;
			case 'novomunicipio':
				getAjaxForm('Municipio/create');
				break;
			
			//PEDIDO OS SAO PAULO
			
			case 'listapedidoos_sp':
				getAjaxForm('OsPedido/liste');
			break;
				
			//OS SAO PAULO
				
			case 'listaos_sp':
				getAjaxForm('OSSP/liste');
			break;
			case 'novaos_sp':
				getAjaxForm('OSSP/create');
			break;
            case 'listatodasossp':
            getAjaxForm('OSSP/listaComTerceiroParametro/aceite-1-tudo');
            break;

        case 'monitor_sp':
            getAjaxForm('Monitor_sp');
            break;



            //tipo equipamentos
            case 'listatipoequipamentos_sp':
                getAjaxForm('TipoEquipamento_sp/liste');
            break;

            //agenda_instal
            case 'agendainstal':
            getAjaxForm('AgendaInstal_sp/liste');
            break;

            case 'listaagendamentos_sp':
            getAjaxForm('AgendaInstal_sp/liste');
            break;

            case 'novotipoequipamento_sp':
            getAjaxForm('TipoEquipamento_sp/create');
            break;

            case 'listaincidentes_sp':
            getAjaxForm('Incidente_sp/liste');
            break;
            //case 'novoincidente_sp':
            //getAjaxForm('Incidente_sp/create','',{param:'solicitacao',ajax:1});
            //break;
            case 'listaatendimentos_sp':
            getAjaxForm('AtendVsat_sp/liste');
            break;

			//os

			case 'novaos':
				getAjaxForm('OS/Create');
				break;
			case 'listaos':
				getAjaxForm('OS/liste');
				break;
			case 'listatodasoss':
				getAjaxForm('OS/listaComTerceiroParametro/aceite-1-tudo');
				break;
			case 'listaagendamentos':
				getAjaxForm('AgendaInstal/liste');
				break;
			case 'listainstalacao':
				getAjaxForm('Instalacao/liste');
				break;
			case 'listeutelsatcode':
				getAjaxForm('OS/eutelsatcode_list');
				break;
			case 'monitor':
				getAjaxForm('Monitor');
				break;
			//usuarios
			case 'listausuarios':
				getAjaxForm('Usuario/liste');
				break;
			case 'novousuario':
				getAjaxForm('Usuario/Create');
				break;
				
		//TRATAMENTO DE INCIDENTES
			// para menu
			case 'listaincidentes':
				getAjaxForm('Incidente/liste');
				break;
			case 'novoincidente':
				getAjaxForm('Incidente/create','',{param:'listaInstalacoes',ajax:1});
				break;
			case 'listapreincidentes':
				getAjaxForm('PreIncidentes/liste');
				break;
			case 'listapreincidentesnagios':
				getAjaxForm('PreIncidentesNagios/liste');
				break;
			case 'listaatendimentos':
				getAjaxForm('AtendVsat/liste');
				break;
	}
	
});
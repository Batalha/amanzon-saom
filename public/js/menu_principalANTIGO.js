/**
 * 
 */

function chama_item_menu_principal( menu , submenu, hash )
{
	$('.item_menu_principal').removeClass('item_active');
	location.hash = hash;



	switch( menu )
	{
		// ---------------------------------- PRINCIPAL
		case 'principal':
			$('#principal').addClass('item_active');
			
			getAjaxForm('Sistema/home');
			
			break;
			
		// ---------------------------------- OS
		case 'os':
			
			$('#menu_instalacoes').addClass('item_active');
			
			if( submenu == 'lista' ){
				
				getAjaxForm('OS/liste');
				
			}else if( submenu == 'create' ){
				
				getAjaxForm('OS/Create');
				
			}else if( submenu == 'lista_tudo' ){
				
				getAjaxForm('OS/listaComTerceiroParametro/aceite-1-tudo');
				
			}else if( submenu == 'eutelsat_code' ){
				
				getAjaxForm('OS/eutelsatcode_list');
				
			}else if( submenu == 'monitor' ){
				
				getAjaxForm('Monitor');
				
			}else if( submenu == 'relatorio_anatel' ){
				
				getAjaxForm('OS/relatorioAnatel');
				
			}
			
			break;
			// ---------------------------------- OS Sao Paulo-----------------------
			
		case 'os_pedido':
		
			$('#menu_solicitacoes').addClass('item_active');
			if(submenu == 'lista'){
				getAjaxForm('OsPedido/liste');
			}else if(submenu == 'create'){
				getAjaxForm('OsPedido/create');
				
			}
			
		break;
			
		case 'os_sp':
			
			$('#menu_instalacoes').addClass('item_active');
			if( submenu == 'lista' ){
				
				getAjaxForm('OSSP/liste');
				
			}else if( submenu == 'create' ){
				
				getAjaxForm('OSSP/create');

			}else if( submenu == 'eutelsat_code' ){

                getAjaxForm('OSSP/eutelsatcode_list');

            }else if( submenu == 'monitor' ){

                getAjaxForm('Monitor_sp');

            }else if(submenu == 'create_outros_canais'){

                getAjaxForm('OSSP/createOutrosCanais');
            }
			break;

        case 'equip_sp':

            $('#menu_equip').addClass('item_active');

            if( submenu == 'lista' ){
                getAjaxForm('Equipamento_sp/liste');
            }else if( submenu == 'create' ){
                getAjaxForm('Equipamento_sp/create');
            }

            break;

        case 'locais_equip_sp':

            $('#menu_equip').addClass('item_active');

            if( submenu == 'lista' ){
                getAjaxForm('LocaisEquipamentos_sp/liste');
            }else if( submenu == 'create' ){
                getAjaxForm('LocaisEquipamentos_sp/create');
            }

            break;
		
		// ---------------------------------- INSTALAÇÕES
		case 'instalacoes':
			
			if( submenu == 'lista' ){
				
				$('#menu_instalacoes').addClass('item_active');
				getAjaxForm('Instalacao/liste');
				
			}
			
			break;

        // ---------------------------------- INSTALAÇÕES DE SAO PAULO
        case 'instalacoes_sp':

            if( submenu == 'lista' ){

                $('#menu_instalacoes').addClass('item_active');
                getAjaxForm('Instalacao_sp/liste');

            }

            break;
			
		// ---------------------------------- AGENDAMENTOS
		case 'agenda_instal':
			
			if( submenu == 'lista' ){
				
				$('#menu_instalacoes').addClass('item_active');
				getAjaxForm('AgendaInstal/liste');
				
			}
			
			break;

			// ---------------------------------- AGENDAMENTOS  DE SAO PAULO
		case 'agenda_instal_sp':

			if( submenu == 'lista' ){

				$('#menu_instalacoes').addClass('item_active');
				//getAjaxForm('OSSP/liste');
				getAjaxForm('AgendaInstal_sp/liste');

			}

			break;
		
		// ---------------------------------- INCIDENTES
		case 'incidentes':
			
			$('#menu_incidentes').addClass('item_active');
			
			if( submenu == 'lista' ){
				getAjaxForm('Incidente/liste');
			}else if( submenu == 'create' ){
				getAjaxForm('Incidente/create','',{param:'listaInstalacoes',ajax:1});
			}
			
			break;

        // ---------------------------------- INCIDENTES DE SAO PAULO
        case 'incidentes_sp':

            $('#menu_incidentes').addClass('item_active');

            if( submenu == 'lista' ){
                getAjaxForm('Incidente_sp/liste');
            }else if( submenu == 'create' ){
                getAjaxForm('Incidente_sp/create','',{param:'listaInstalacoessp',ajax:1});
            }

            break;
			
		// ---------------------------------- PRÉ INCIDENTES PRODEMGE
		case 'pre_incidentes':
			
			if( submenu == 'lista' ){
				getAjaxForm('PreIncidentes/liste')
			}
			
			break;

			// ---------------------------------- PRÉ INCIDENTES SAO PAULO
		case 'pre_incidentes_sp':

			if( submenu == 'lista' ){
				getAjaxForm('PreIncidentes_sp/liste')
			}

			break;
			
		// ---------------------------------- PRÉ INCIDENTES PRODEMGE
		case 'pre_incidentes_nagios':
			
			if( submenu == 'lista' ){
				getAjaxForm('PreIncidentesNagios/liste')
			}
			
			break;

			// ---------------------------------- PRÉ INCIDENTES NAGIOS SAO PAULO
		case 'pre_incidentes_nagios_sp':

			if( submenu == 'lista' ){
				getAjaxForm('PreIncidentesNagios_sp/liste')
			}

			break;
			
		// ---------------------------------- ATENDIMENTOS atend_vsat
		case 'atend_vsat':
			
			if( submenu == 'lista' ) {
				
				$('#menu_incidentes').addClass('item_active');
				getAjaxForm('AtendVsat/liste')
				
			}
			
			break;

			// ---------------------------------- ATENDIMENTOS atend_vsat SAO PAULO
		case 'atend_vsat_sp':

			if( submenu == 'lista' ) {

				$('#menu_incidentes').addClass('item_active');
				getAjaxForm('AtendVsat_sp/liste')

			}

			break;
		
		
		// ---------------------------------- ACOMPANHAMENTOS
		case 'acomp':
			
			$('#menu_acomp').addClass('item_active');
			
			if( submenu == 'lista' ){
				getAjaxForm('Acompanhamento/liste');
			}
			
			break;

			// ---------------------------------- ACOMPANHAMENTOS SAO PAULO
		case 'acomp_sp':

			$('#menu_acomp').addClass('item_active');

			if( submenu == 'lista' ){
				getAjaxForm('Acompanhamento_sp/liste');
			}

			break;
			
		// ---------------------------------- EQUIPAMENTOS
		case 'equip':
			
			$('#menu_equip').addClass('item_active');
			
			if( submenu == 'lista' ){
				getAjaxForm('Equipamento/liste');
			}else if( submenu == 'create' ){
				getAjaxForm('Equipamento/create');
			}
			
			break;

			// ---------------------------------- EQUIPAMENTOS SAO PAULO
		case 'equip_sp':

			$('#menu_equip').addClass('item_active');

			if( submenu == 'lista' ){
				getAjaxForm('Equipamento_sp/liste');
			}else if( submenu == 'create' ){
				getAjaxForm('Equipamento_sp/create');
			}

			break;
			
		// ---------------------------------- LOCAIS EQUIPAMENTOS
		case 'locais_equip':
			
			$('#menu_equip').addClass('item_active');
			
			if( submenu == 'lista' ){
				getAjaxForm('LocaisEquipamentos/liste');
			}else if( submenu == 'create' ){
				getAjaxForm('LocaisEquipamentos/create');
			}
			
			break;
			
		// ---------------------------------- ADMINISTRAR
		case 'administrar':
			
			$('#administrar').addClass('item_active');
			
			if( submenu == 'lista' ){
				getAjaxForm('Usuario/liste');
			}else if( submenu == 'create' ){
				getAjaxForm('Usuario/Create');
			}
			
			break;
			
		// ---------------------------------- TROCA SENHA
		case 'troca_senha':
			
			$("#troca_senha").addClass('item_active');
			
			getAjaxForm('Usuario/change_pass');
			
			break;
	}
}
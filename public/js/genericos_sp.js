/**
 * Arquivo criado para scripts genéricos
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */

/**
 * Função para delegar função autosave para inputs de formulários
 */

$(document).ready(function(){

	// Use jQuery com a variavel $j para evitar conflitos


	//formulario instalacao/comiss_edit.tpl
	$(".autosave").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"instalacoes",
    	campo:"name",
    	linha:"#idinstalacoes",
    	campoid:"idinstalacoes"
	});
	
	//formulario agenda_instal/edit.tpl
	$(".autosave_agenda_instal").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"agenda_instal",
    	campo:"name",
    	linha:"#idagenda_instal",
    	campoid:"idagenda_instal"
	});
	
	//formulario de atendvsat/edit.tpl
	$(".autosave_atendvsat").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"atend_vsat",
    	campo:"name",
    	linha:"#idatend_vsat",
    	campoid:"idatend_vsat"
	});
	
	//formulario de equipamento/edit.tpl
	$(".autosave_equipamento").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"equipamentos",
    	campo:"name",
    	linha:"#idequipamentos",
    	campoid:"idequipamentos"
	});
	
	//formulario de incidente/edit.tpl
	$(".autosave_incidentes").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"incidentes",
    	campo:"name",
    	linha:"#idincidentes",
    	campoid:"idincidentes"
	});
	
	//formulario de instalacao/edit.tpl - verificar necessidade
	$(".autosave_instalacao").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"instalacoes",
    	campo:"name",
    	linha:"#idinstalacoes",
    	campoid:"idinstalacoes"
	});

    //formulario de OS/edit.tpl

    $(".autosave_os").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"os",
    	campo:"name",
    	linha:"#idos",
    	campoid:"idos"
	});

    //formulario de OSSP/edit.tpl


	//formulario de municipio/edit.tpl
	$(".autosave_municipios").formautosave({
		url:"Controller/atualizaCampo",//local que executa a query no banco
    	table:"municipios",
    	campo:"name",
    	linha:"#idmunicipios",
    	campoid:"idmunicipios"
	});




    //-----------AUTO SAVE DE SAO PAULO---------------


    //formulario agenda_instal/edit.tpl
    $(".autosave_agenda_instal_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"agenda_instal_sp",
        campo:"name",
        linha:"#idagenda_instal_sp",
        campoid:"idagenda_instal_sp"
    });
    //formulario de instalacao/edit.tpl - verificar necessidade
    $(".autosave_instalacao_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"instalacoes_sp",
        campo:"name",
        linha:"#idinstalacoes_sp",
        campoid:"idinstalacoes_sp"
    });
    //formulario de atendvsat/edit.tpl
    $(".autosave_atendvsat_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"atend_vsat_sp",
        campo:"name",
        linha:"#idatend_vsat",
        campoid:"idatend_vsat"
    });

    //formulario de equipamento/edit.tpl
    $(".autosave_equipamento_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"equipamentos_sp",
        campo:"name",
        linha:"#idequipamentos_sp",
        campoid:"idequipamentos_sp"
    });

    //formulario de incidente/edit.tpl
    $(".autosave_incidentes_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"incidentes_sp",
        campo:"name",
        linha:"#idincidentes",
        campoid:"idincidentes"
    });

    //formulario instalacao/comiss_edit.tpl
    $(".autosave_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"instalacoes_sp",
        campo:"name",
        linha:"#idinstalacoes_sp",
        campoid:"idinstalacoes_sp"
    });

    $(".autosave_ossp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"os_sp",
        campo:"name",
        linha:"#idos",
        campoid:"idos"
    });

    $(".autosave_municipios_sp").formautosave({
        url:"Controller/atualizaCampo_sp",//local que executa a query no banco
        table:"municipios_sp",
        campo:"name",
        linha:"#idmunicipios",
        campoid:"idmunicipios_sp"
    });


});


/**
 * Funcao para guardar infromações em inputs reservas
 */
function guardaReserva(informacao,campo)
{
	$(campo).val(informacao);
}

/**
 * FUNCAO DE FILTRO 
 */
var filtroColum = function filtroColums()
{


	$('.tbLista').columnFilters();
	setTimeout('$("#avisoInstantaneo").fadeOut(1000)',2000);

    //$("#_filterText7").attr('hidden');
}

/**
 * FUNCAO PARA SO PERMITIR NUMEROS
 * 
 * fonte: http://forum.imasters.com.br/topic/355977-mascara-jquery-so-para-numeros/
 */
function num(dom)
{
    dom.value=dom.value.replace(/\D/g,'');
}
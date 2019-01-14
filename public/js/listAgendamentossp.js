/**
 * 
 */

function desenhaTabelaAgendamentossp()
{
	$("#flexmeAgendamentossp").flexigrid({
    	url: 'AgendaInstal_sp/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'OS', name : 'os_numos', width : 100, sortable : true, align: 'left'},
			{display: 'Cidade', name : 'os_cidade', width : 150, sortable : true, align: 'left'},
			{display: 'Data Agendamento', name : 'data', width : 100, sortable : true, align: 'left'},
			{display: 'Contato', name : 'contato', width : 150, sortable : true, align: 'left'},
			{display: 'Telefone', name : 'tel', width : 100, sortable : true, align: 'left'},
			{display: 'Confirmado', name : 'confirm', width : 90, sortable : true, align: 'left'},
			{display: 'Empresa', name : 'empresa', width : 90, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListAgendamentossp},
			{separator: true}
        ],
        searchitems : [
            {display: 'OS', name : 'os_numos', isdefault: true},
			{display: 'Cidade', name : 'os_cidade'},
			{display: 'Data Agendamento', name : 'data'},
			{display: 'Contato', name : 'contato'},
			{display: 'Telefone', name : 'tel'},
			{display: 'Confirmado', name : 'confirm'},
			{display: 'Empresa', name : 'empresa'}
        ],
        sortname: "data",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Agendamentos",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 792,
        height: 573,
        singleSelect: true,
        onSuccess: successFlexigridListAgendamentossp,
        onError: successFlexigridListAgendamentossp,
        showToggleBtn: false
	});
}

/* DESATIVADO */
function doCommandListAgendamentossp(com, grid)
{
	if(com == 'Abrir Agendamento Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('AgendaInstal_sp/view','conteudo',{param:id,ajax:1})
		});
	}
}

function successFlexigridListAgendamentossp()
{
	var campos = ["os_numos",
	 	 		  "os_cidade",
	 	 		  "data",
	 	 		  "contato",
	 	 		  "tel",
	 	 		  "confirm",
	 	 		  "empresa"];
	reconstruindoFlexigrid(campos,'AgendaInstal_sp/listeFonteFiltro','AgendaInstal_sp/view','#flexmeAgendamentossp');
	coloreCamposListAgendamentossp();
}

function coloreCamposListAgendamentossp()
{
	/* vsatCriada */
		corEmCampos('confirm','Sim','green');
		corEmCampos('confirm','Não','red');
}

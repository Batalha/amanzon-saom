/**
 * 
 */

function desenhaTabelaListos_sp()
{
	$("#flexmeOSsp").flexigrid({
		url: "OSSP/listeFonte",
        dataType: 'json',
        colModel : [
            {display: 'Identificador', name : 'identificador', width : 70, sortable : true, align: 'left', hidedlg: true },
            {display: 'Nº OS', name : 'os_numOS', width : 60, sortable : true, align: 'left'},
            {display: 'VSAT', name : 'instalacoes_vsat', width : 140, sortable : true, align: 'left'},
			{display: 'País', name : 'pais', width : 70, sortable : true, align: 'left'},
			{display: 'Cidade', name : 'cidade', width : 90, sortable : true, align: 'left'},
			{display: 'UF', name : 'estado', width : 40, sortable : true, align: 'left'},
			{display: 'Prazo', name : 'os_prazoInstal', width : 80, sortable : true, align: 'left'},
			{display: 'Data Solicitação', name : 'os_dataSolicitacao', width : 90, sortable : true, align: 'left'},

			{display: 'Cliente', name : 'os_empresas_idempresas', width : 80, sortable : true, align: 'left'},

			{display: 'Empreiteira', name : 'os_empreiteira_idempresas', width : 70, sortable : true, align: 'left'},

			{display: 'Agendamento', name : 'agendamento', width : 90, sortable : true, align: 'left'},
			{display: 'Comiss', name : 'comiss', title: true, width : 70, sortable : true, align: 'left'},
			//{display: '', name : 'edicao', width : 20, sortable : true, align: 'left'},
			{display: 'Vsat criada?', name : 'vsatCriada', width : 100, sortable : true, align: 'left'},
			// {display: 'Anatel', name : 'codAnatel', width : 60, sortable : true, align: 'left'},
			{display: 'T. A', name : 'aceiteProdemge', width : 80, sortable : true, align: 'left'},
			{display: 'Paralisado', name : 'paralisado', width : 60, sortable : true, align: 'left'},
			{display: 'T. R', name : 'termo_responsabilidade', width : 70, sortable : true, align: 'left'}
		],

        buttons : [
			{name: 'Carregando...', tooltip: 'Add new client', bclass: 'view', onpress : doCommandListossp},
			{separator: true}
        ],
        searchitems : [
            {display: 'Identificador', name : 'identificador'},
			{display: 'Nº OS', name : 'os_numOS'},
			{display: 'VSAT', name : 'instalacoes_vsat'},
			{display: 'País', name : 'pais'},
			{display: 'Cidade', name : 'cidade'},
			{display: 'UF', name : 'estado'},
			{display: 'Prazo', name : 'os_prazoInstal'},
			{display: 'Data Solicitação', name : 'os_dataSolicitacao'},
			{display: 'Cliente', name : 'os_empresas_idempresas'},
			{display: 'Empreiteira', name : 'os_empreiteira_idempresas'},
			{display: 'Agendamento', name : 'agendamento'},
			{display: 'Comiss', name : 'comiss'},
//			{display: '', name : 'edicao'},
			{display: 'Vsat criada?', name : 'vsatCriada'},
			// {display: 'Cod Anatel', name : 'codAnatel'},
			{display: 'T. A', name : 'aceiteProdemge'},
			{display: 'Paralisado', name : 'paralisado'},
			{display: 'T. R', name : 'termo_responsabilidade'}
        ],
        sortname: "instalacoes_vsat",
        sortorder: "desc",
        usepager: true,
        title: "Lista de OS's",
        useRp: false,
        striped: false,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 1280,
        height: 575,
        singleSelect: true,
        onSuccess: successFlexigridListossp,
        onError: successFlexigridListossp,
        showToggleBtn: false,
        query: ''
	});

}


/* DESATIVADO */
function doCommandListossp(com, grid)
{
    if(com == 'Abrir OS Selecionada')
	{
        $('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('OSSP/view','conteudo',{param:id,ajax:1},'initialize');
		});
    }
}

function successFlexigridListossp()
{


    var campos = ["identificador",
	             "os_numOS",
	             "instalacoes_vsat",
		 		 "cidade",
		 		 "pais",
		 		 "estado",
		 		 "os_prazoInstal",
		 		 "os_dataSolicitacao",
		 		 "os_empresas_idempresas",
		 		 "os_empreiteira_idempresas",
		 		 "agendamento",
		 		 "comiss",
//		 		 "edicao",
		 		 "vsatCriada",
		 		 // "codAnatel",
		 		 "aceiteProdemge",
		 		 "paralisado",
		 		 "termo_responsabilidade",
		 		 ];

    //alert(campos);

    reconstruindoFlexigrid(campos,'OSSP/listeFonteFiltro','OSSP/view','#flexmeOSsp');
    coloreCamposlistossp();
}

function coloreCamposlistossp()
{
    //alert('teste');
	/* vsatCriada */
		corEmCampos('vsatCriada','Completa','green');
		corEmCampos('vsatCriada','Pendente Packet Shapper','#FF8C00');
		corEmCampos('vsatCriada','Não','red');
		corEmCampos('vsatCriada','Pendente PRTG','#FF8C00');

	/* aceiteProdemge */
		//corEmCampos('aceiteProdemge','tudo','green');
		//corEmCampos('aceiteProdemge','Não','red');

	/* codAnatel */
		// corEmCampos('codAnatel','Não','red');

	/* instalacoes_idinstalacoes */
		corEmCampos('comiss','tudo','green');
		corEmCampos('comiss','Não','red');
		corEmCampos('comiss','Sim','green');
		corEmCampos('comiss','Em Andamento','#FF8C00');

	/* agenda_instal_confirm */
		corEmCampos('agenda_instal_confirm','Não','red');

	/* agendamento */
		corEmCampos('agendamento','tudo','#FF8C00');
		corEmCampos('agendamento','Confirmado','green');
		corEmCampos('agendamento','Não','red');
		corEmCampos('agendamento','TESTE','red');
		corEmCampos('agendamento','Sem Data','red');

	/* paralisado */
		corEmCampos('paralisado','Não','green');
		corEmCampos('paralisado','Sim','red');

	/* termo de responsabilidade */
		corEmCampos('termo_responsabilidade','Aceito','green');
		corEmCampos('termo_responsabilidade','Rejeitado','red');
		corEmCampos('termo_responsabilidade','Não','red');
}

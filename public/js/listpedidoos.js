/**
 * 
 */

function desenhaTabelaListpedidoos_sp()
{
	$("#flexmePedidoOS").flexigrid({
		url: 'OsPedido/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'Qtd', name : 'idpedido', width : 80, sortable : true, align: 'left'},
            {display: 'Solicitaçoes', name : 'solicita', width : 90, sortable : true, align: 'left'},
			{display: 'Planos', name : 'canal_venda_idcanal_venda', width : 120, sortable : true, align: 'left'},
			{display: 'FC', name : 'fator_comp', width : 80, sortable : true, align: 'left'},
//			{display: 'Prazo', name : 'os_prazoInstal', width : 80, sortable : true, align: 'left'},
			{display: 'Empresa', name : 'pedidoos_empresas_idempresas', width : 80, sortable : true, align: 'left'},
			{display: 'Data Solicitação', name : 'pedido_criado', width : 120, sortable : true, align: 'left'},
			{display: 'Envio de Contrato', name : 'envio_contrato', width : 90, sortable : true, align: 'left'},
//			{display: 'Agendamento', name : 'agendamento', width : 90, sortable : true, align: 'left'},
//			{display: 'Comiss', name : 'comiss', title: true, width : 90, sortable : true, align: 'left'},
////			{display: '', name : 'edicao', width : 20, sortable : true, align: 'left'},
//			{display: 'Vsat criada?', name : 'vsatCriada', width : 100, sortable : true, align: 'left'},
//			// {display: 'Anatel', name : 'codAnatel', width : 60, sortable : true, align: 'left'},
//			{display: 'T. Aceite', name : 'aceiteProdemge', width : 100, sortable : true, align: 'left'},
//			{display: 'Paralisado', name : 'paralisado', width : 80, sortable : true, align: 'left'},
//			{display: 'T. Responsabilidade', name : 'termo_responsabilidade', width : 80, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', tooltip: 'Add new client', bclass: 'view', onpress : doCommandListpedidoos},
			{separator: true}
        ],
        searchitems : [
//            {display: 'Identificador', name : 'identificador'},
//			{display: 'Qtd', name : 'idpedido_os'},
			{display: 'solicitaçoes', name : 'solicita'},
			{display: 'Planos', name : 'canal_venda_idcanal_venda'},
			{display: 'FC', name : 'fator_comp'},
			{display: 'Empresa', name : 'pedidoos_empresas_idempresas'},
			{display: 'Data Solicitação', name : 'pedido_criado'},
			{display: 'Envio de Contrato', name : 'envio_contrato'},
//			{display: 'Comiss', name : 'comiss'},
////			{display: '', name : 'edicao'},
//			{display: 'Vsat criada?', name : 'vsatCriada'},
//			// {display: 'Cod Anatel', name : 'codAnatel'},
//			{display: 'Aceite PRODEMGE', name : 'aceiteProdemge'},
//			{display: 'Paralisado', name : 'paralisado'},
//			{display: 'T. Responsabilidade', name : 'termo_responsabilidade'}
        ],
        sortname: "solicita", //para destacar a coluna na lista
        sortorder: "desc",
        usepager: true,
        title: "Lista de Pedidos de OS's",
        useRp: false,
        striped: false,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 670,
        height: 575,
        singleSelect: true,
        onSuccess: successFlexigridListpedidoos,
        onError: successFlexigridListpedidoos,
        showToggleBtn: false,
        query: ''
	});

}


/* DESATIVADO */
function doCommandListpedidoos(com, grid) 
{
	if(com == 'Abrir OS Selecionada')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('OsPedido/view','conteudo',{param:id,ajax:1},'initialize');
		});
	}
}

function successFlexigridListpedidoos()
{
	var campos = [
//	              "identificador",
	             "idpedido",
	             "solicita",
		 		 "canal_venda_idcanal_venda",
		 		 "fator_comp",
		 		 "pedidoos_empresas_idempresas",
		 		 "pedido_criado",
		 		 "envio_contrato",
//		 		 "agendamento",
//		 		 "comiss",
////		 		 "edicao",
//		 		 "vsatCriada",
//		 		 // "codAnatel",
//		 		 "aceiteProdemge",
//		 		 "paralisado",
//		 		 "termo_responsabilidade"
		 		 ];

	reconstruindoFlexigrid(campos,'OsPedido/listeFonteFiltro','OsPedido/view','#flexmePedidoOS');
	coloreCamposlistos();
}

function coloreCamposlistos()
{
	/*confirmado*/
		corEmCampos('envio_contrato', 'Não', 'red');
		corEmCampos('envio_contrato', 'Sim', 'green');
	
//	/* vsatCriada */
//		corEmCampos('vsatCriada','Completa','green');
//		corEmCampos('vsatCriada','Pendente Packet Shapper','#FF8C00');
//		corEmCampos('vsatCriada','Não','red');
//		corEmCampos('vsatCriada','Pendente PRTG','#FF8C00');
//	
//	/* aceiteProdemge */
//		corEmCampos('aceiteProdemge','tudo','green');
//		corEmCampos('aceiteProdemge','Não','red');
//		
//	/* codAnatel */
//		// corEmCampos('codAnatel','Não','red');
//		
//	/* instalacoes_idinstalacoes */
//		corEmCampos('comiss','tudo','green');
//		corEmCampos('comiss','Não','red');
//		corEmCampos('comiss','Sim','green');
//		corEmCampos('comiss','Em Andamento','#FF8C00');
//		
//	/* agenda_instal_confirm */
//		corEmCampos('agenda_instal_confirm','Não','red');
//		
//	/* agendamento */
//		corEmCampos('agendamento','tudo','#FF8C00');
//		corEmCampos('agendamento','Confirmado','green');
//		corEmCampos('agendamento','Não','red');
//		corEmCampos('agendamento','TESTE','red');
//		corEmCampos('agendamento','Sem Data','red');
//		
//	/* paralisado */
//		corEmCampos('paralisado','Não','green');
//		corEmCampos('paralisado','Sim','red');
//
//	/* termo de responsabilidade */
//		corEmCampos('termo_responsabilidade','Aceito','green');
//		corEmCampos('termo_responsabilidade','Rejeitado','red');
//		corEmCampos('termo_responsabilidade','Não','red');
}

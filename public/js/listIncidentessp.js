/**
 * 
 */

function desenhaTabelaIncidentessp()
{
	limpaJsTelefonemassp();
	//alert('teste');

	$("#flexmeIncidentessp").flexigrid({
    	url: 'Incidente_sp/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'Nº Tickets', 		name : 'idincidentes', width : 80, sortable : true, align: 'left'},
            {display: 'VSAT', 				name : 'nome_instalacao', width : 130, sortable : true, align: 'left'},
            {display: 'Solicitação',		name : 'solicitacao', width : 100, sortable : true, align: 'left'},
			{display: 'Data', 				name : 'data', width : 70, sortable : true, align: 'left'},
			{display: 'Prioridade', 		name : 'prioridade', width : 70, sortable : true, align: 'left'},
			{display: 'Descrição', 			name : 'descricao', width : 150, sortable : true, align: 'left'},
			{display: 'Data Final', 		name : 'data_final', width : 120, sortable : true, align: 'left'},
			//{display: 'Atendimento', 		name : 'ultimoAtendimento', width : 180, sortable : true, align: 'left'},
			{display: 'Status', 			name : 'status', width : 90, sortable : true, align: 'left'},
			{display: 'Técnico Responsável',name : 'nomeTecnico', width : 115, sortable : true, align: 'left'},
			{display: 'Telefonemas Info', 	name : 'telefonemas_info', width : 115, sortable : true, align: 'left', hide:true},
			{display: 'Associacao', 		name : 'associacao', width : 105, sortable : true, align: 'left', hide: true},
			//{display: 'Telefonemas', 		name : 'telefonemas', width : 95, sortable : true, align: 'left'},
			{display: 'Opções', 			name : 'opcoes', width : 105, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListInstalacoessp },
			{separator: true}
        ],
        searchitems : [
            {display: 'Nº Incidente', name : 'idincidentes'},
			{display: 'VSAT', name : 'nome_instalacao'},
			{display: 'Solicitação', name : 'solicitacao'},
			{display: 'Data', name : 'data'},
			{display: 'Prioridade', name : 'prioridade'},
			{display: 'Descrição', name : 'descricao'},
			{display: 'Data Final', name : 'data_final'},
			//{display: 'Atendimento', name : 'ultimoAtendimento'},
			//{display: 'ID Prodemge', name : 'numero_prodemge'},
			{display: 'Status', name : 'status'},
			{display: 'Técnico Responsável', name : 'nomeTecnico'},
			{display: 'Telefonemas Info', name : 'telefonemas_info'},
			//{display: 'Telefonemas', name : 'telefonemas'},
			{display: 'Associacao', name : 'associacao'},
			{display: 'Opções', name : 'opcoes'}
        ],
        sortname: "idincidentes",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Tickets",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 1030,//1124, //*115 para telefonemas
        height: 795,
        singleSelect: true,
        onSuccess: successFlexigridListIncidentessp,
        onError: successFlexigridListIncidentessp,
        showToggleBtn: false
	});

}

/* DESATIVADO */
function doCommandListInstalacoessp(com, grid)
{
	if(com == 'Abrir Instalação Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('Incidente_sp/view','conteudo',{param:id,ajax:1});
		});
	}
}

function chamaIncidente( id ){
	getAjaxForm('Incidente_sp/view','conteudo',{param:id,ajax:1});
}

function successFlexigridListIncidentessp()
{
	//alert('teste');
	var campos = ["idincidentes",
	 	 		  "nome_instalacao",
	 	 		  "solicitacao",
	 	 		  "data",
	 	 		  "prioridade",
	 	 		  "descricao",
	 	 		  "data_final",
	 	 		  //"ultimoAtendimento",
	 	 		  //"numero_prodemge",
	 	 		  "status",
	 	 		  "nomeTecnico",
	 	 		  //"telefonemas_info",
	 	 		  "associacao",
	 	 		  "opcoes"];
	reconstruindoFlexigrid(campos,'Incidente_sp/listeFonteFiltro','Incidente_sp/view','#flexmeIncidentessp');
	//aplicaTelefonemassp();
	coloreCamposListIncidentes();

	//botoes
	var botoes = new botaoFlexiIncidentes();
	botoes.aplicaBtn( 'responsavel' , 'chamaIncidente' , 'Visualizar' );

}

function coloreCamposListIncidentes()
{
	/* prioridade */
		corEmCampos('prioridade','Alta','red');
		corEmCampos('prioridade','Baixa','green');
		corEmCampos('prioridade','Média','#FF8C00');		
}


//############################# Classe de botão Flexigrid

function botaoFlexiIncidentes(){

	//alert(campo);
	this.aplicaBtn = function( campo , funcao , valor ){
		$('#flexmeIncidentessp tr').each(function(){

			// resgate id
			var id = $(this).attr('id');
		//alert(id);
			id = id.substring(id.lastIndexOf('row')+3);

			var cor = 'btn-danger';
			$(this).find('[abbr="opcoes"] div').html('<a type="button" class="btn '+cor+'" onclick="'+funcao+'(\''+id+'\')">'+valor+'</a>');
			
		});
	}
	
}
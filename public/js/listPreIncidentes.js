/**
 * 
 */

var idPreIncidenteFoco = 0;

function desenhaTabelaPreIncidentes()
{
	$("#flexmePreIncidentes").flexigrid({
    	url: 'PreIncidentes/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'id_pre_incidentes', width : 55, sortable : true, align: 'left'},
            {display: 'Id Prodemge', name : 'id_prodemge', width : 115, sortable : true, align: 'left'},
			{display: 'Id Cliente', name : 'id_cliente', width : 70, sortable : true, align: 'left'},
			{display: 'Prazo Limite', name : 'prazo_limite', width : 90, sortable : true, align: 'left'},
			{display: 'Data Email', name : 'data_email', width : 110, sortable : true, align: 'left'},
			{display: 'Designação', name : 'designacao', width : 130, sortable : true, align: 'left'},
			{display: 'Responsável', name : 'responsavel', width : 110, sortable : true, align: 'left'},
			{display: 'Nome Responsável', name : 'nome_responsavel', width : 120, sortable : true, align: 'left',hide: true},
			{display: 'Opções', name : 'opcoes', width : 120, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListPreIncidentes},
			{separator: true}
        ],
        searchitems : [
            {display: 'ID', name : 'id_pre_incidentes', isdefault: true},
			{display: 'Id Prodemge', name : 'id_prodemge'},
			{display: 'Id Cliente', name : 'id_cliente'},
			{display: 'Prazo Limite', name : 'prazo_limite'},
			{display: 'Data Email', name : 'data_email'},
			{display: 'Designação', name : 'designacao'},
			{display: 'Responsável', name : 'responsavel'},
			{display: 'Nome Responsável', name : 'nome_responsavel'},
			{display: 'Opções', name : 'opcoes'}
        ],
        sortname: "id_pre_incidentes",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Pré Incidentes",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 814,
        height: 805,
        singleSelect: false,
        onSuccess: successFlexigridListPreIncidentes,
        onError: successFlexigridListPreIncidentes,
        showToggleBtn: false
	});
}

/* DESATIVADO */
function doCommandListPreIncidentes(com, grid) 
{
	if(com == 'Abrir Instalação Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			//getAjaxForm('PreIncidente/view','conteudo',{param:id,ajax:1})
		});
	}
}

function successFlexigridListPreIncidentes()
{
	var campos = ["id_pre_incidentes",
	              "id_prodemge",
	              "id_cliente",
	              "prazo_limite",
	              "data_email",
	              "designacao",
	              "responsavel",
	              "nome_responsavel"];
	reconstruindoFlexigrid(campos,'PreIncidentes/listeFonteFiltro','PreIncidente/list','#flexmePreIncidentes');
	aplicaOpcoes();
	coloreCamposListIncidentes();
	
	//botoes
	var botoes = new botaoFlexi();
	botoes.aplicaBtn( 'responsavel' , 'abreEscolhaResponsaaveis' , 'Selecionar...' );
}

function coloreCamposListIncidentes()
{
	/* prioridade */
		//corEmCampos('prioridade','Alta','red');
		//corEmCampos('prioridade','Baixa','green');
		//corEmCampos('prioridade','Média','#FF8C00');
}

function aplicaOpcoes(){
	$('#flexmePreIncidentes tr').each(function(){
		var id = $(this).attr('id');
		id = id.substring(id.lastIndexOf('row')+3);
		$(this).find('[abbr="opcoes"] div').html('<a class="btn" onclick="visualizaPreIncidente('+id+')">Visualizar</a>');
	});
}

function visualizaPreIncidente( idPreIncidente ){
	getAjaxForm('PreIncidentes/view','conteudo',{param:idPreIncidente,ajax:1});
}

// --

function abreEscolhaResponsaaveis( idPreIncidente ){
	
	idPreIncidenteFoco = idPreIncidente;
	$('#modalPreIncidentes').modal();
	$.ajax({
		url:'PreIncidentes/listaResponsaveis',
		type:'POST',
		data:{idPreIncidente:idPreIncidente},
		success:function( resposta ){
			$('#modalConteudo').html( resposta );
		}
	});
	
}



// ############################# Classe de botão Flexigrid

function botaoFlexi(){
	
	this.aplicaBtn = function( campo , funcao , valor ){
		$('#flexmePreIncidentes tr').each(function(){
			
			// resgate id
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			
			var cor = '';
			var responsavelSetado = $(this).find('[abbr="nome_responsavel"] div').html();
			if( responsavelSetado == undefined || responsavelSetado == '' || responsavelSetado == '&nbsp;' ){
				cor = 'btn-danger';
				$(this).find('[abbr="responsavel"] div').html('<a type="button" class="btn '+cor+'" onclick="'+funcao+'(\''+id+'\')">'+valor+'</a>');
			}else{
				$(this).find('[abbr="responsavel"] div').html( $(this).find('[abbr="nome_responsavel"] div').html() );
			}
			
		});
	}
	
}
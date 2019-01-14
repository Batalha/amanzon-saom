/**
 * 
 */

var idPreIncidenteFoco = 0;

function desenhaTabelaPreIncidentesNagios()
{
	$("#flexmePreIncidentesNagios").flexigrid({
    	url: 'PreIncidentesNagios/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'ID Nagios', name : 'id_pre_incidentes_nagios', width : 105, sortable : true, align: 'left'},
			{display: 'Endereço', name : 'endereco', width : 130, sortable : true, align: 'left'},
			{display: 'Designação', name : 'vsat', width : 130, sortable : true, align: 'left'},
			{display: 'Data', name : 'data_evento', width : 120, sortable : true, align: 'left'},
			{display: 'Responsável', name : 'nome_responsavel', width : 110, sortable : true, align: 'left'},
			{display: 'Opções', name : 'opcoes', width : 180, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListPreIncidentesNagios},
			{separator: true}
        ],
        searchitems : [
            {display: 'ID Nagios', name : 'id_pre_incidentes_nagios', isdefault: true},
			{display: 'Endereço', name : 'endereco'},
			{display: 'Designação', name : 'vsat'},
			{display: 'Data', name : 'data_evento'},
			{display: 'Responsável', name : 'nome_responsavel'},
			{display: 'Opções', name : 'opcoes'}
        ],
        sortname: "id_pre_incidentes_nagios",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Pré Incidentes Nagios",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 785,
        height: 805,
        singleSelect: false,
        onSuccess: successFlexigridListPreIncidentesNagios,
        onError: successFlexigridListPreIncidentesNagios,
        showToggleBtn: false
	});
}

/* DESATIVADO */
function doCommandListPreIncidentesNagios(com, grid) 
{
	/*
	if(com == 'Abrir Instalação Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			//getAjaxForm('PreIncidente/view','conteudo',{param:id,ajax:1})
		});
	}
	*/
}

function successFlexigridListPreIncidentesNagios()
{		
	var campos = ["id_pre_incidentes_nagios",
	              "endereco",
	              "vsat",
	              "data_evento",
	              "nome_responsavel"];
	reconstruindoFlexigrid(campos,'PreIncidentesNagios/listeFonteFiltro','PreIncidenteNagios/list','#flexmePreIncidentesNagios');
	aplicaOpcoesNagios();
	aplicaOpcoesHistoricoNagios();
	coloreCamposListIncidentesNagios();
	
	//botoes
	var botoes = new botaoFlexiNagios();
	botoes.aplicaBtn( 'nome_responsavel' , 'abreEscolhaResponsaaveis' , 'Selecionar...' );
	
	$('.pGroup select').css('width','60px');
}

function coloreCamposListIncidentesNagios()
{
	/* prioridade */
		//corEmCampos('prioridade','Alta','red');
		//corEmCampos('prioridade','Baixa','green');
		//corEmCampos('prioridade','Média','#FF8C00');
}

function aplicaOpcoesNagios(){
	$('#flexmePreIncidentesNagios tr').each(function(){
		var id = $(this).attr('id');
		id = id.substring(id.lastIndexOf('row')+3);
		$(this).find('[abbr="opcoes"] div').html('<a class="btn" onclick="visualizaPreIncidenteNagios('+id+')">Visualizar</a>');
	});
}

function visualizaPreIncidenteNagios( idPreIncidente ){
	getAjaxForm('PreIncidentesNagios/view','conteudo',{param:idPreIncidente,ajax:1});
}

function aplicaOpcoesHistoricoNagios(){
	$('#flexmePreIncidentesNagios tr').each(function(){
		var designacao = $(this).find('[abbr="vsat"] div').html();
		$(this).find('[abbr="opcoes"] div').append('&nbsp;&nbsp;&nbsp;<a class="btn" onclick="visualizaHistoricoDesignacao(\''+designacao+'\')">Histórico</a>');
	});
}

function visualizaHistoricoDesignacao( designacao ){
	//alert('teste');
	$('#modalPreIncidentesNagiosHistorico').modal();
	$.ajax({
		url:'PreIncidentesNagios/listaHistoricoDesignacao',
		type:'POST',
		data:{designacao:designacao},
		success:function( resposta ){
			$('#modalConteudoHistorico').html( resposta );
		}
	});
}

// --

function abreEscolhaResponsaaveis( idPreIncidenteNagios ){
	
	idPreIncidenteFoco = idPreIncidenteNagios;
	$('#modalPreIncidentesNagios').modal();
	$.ajax({
		url:'PreIncidentesNagios/listaResponsaveis',
		type:'POST',
		data:{idPreIncidenteNagios:idPreIncidenteNagios},
		success:function( resposta ){
			$('#modalConteudo').html( resposta );
		}
	});
	
}



// ############################# Classe de botão Flexigrid

function botaoFlexiNagios(){
	
	this.aplicaBtn = function( campo , funcao , valor ){
		$('#flexmePreIncidentesNagios tr').each(function(){
			
			// resgate id
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			
			var cor = '';
			var responsavelSetado = $(this).find('[abbr="nome_responsavel"] div').html();
			if( responsavelSetado == undefined || responsavelSetado == '' || responsavelSetado == '&nbsp;' ){
				cor = 'btn-danger';
				$(this).find('[abbr="nome_responsavel"] div').html('<a type="button" class="btn '+cor+'" onclick="'+funcao+'(\''+id+'\')">'+valor+'</a>');
			}else{
				$(this).find('[abbr="nome_responsavel"] div').html( $(this).find('[abbr="nome_responsavel"] div').html() );
			}
			
		});
	}
	
}
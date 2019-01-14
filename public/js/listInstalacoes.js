/**
 * 
 */

function desenhaTabelaInstalacoes()
{
	$("#flexmeInstalacoes").flexigrid({
    	url: 'Instalacao/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'Nº OS', name : 'numos', width : 70, sortable : true, align: 'left'},
            {display: 'Nome', name : 'nome', width : 115, sortable : true, align: 'left'},
			{display: 'MAC', name : 'mac', width : 115, sortable : true, align: 'left'},
			{display: 'Cod. Anatel', name : 'cod_anatel', width : 150, sortable : true, align: 'left'},
			{display: 'Status', name : 'status', width : 180, sortable : true, align: 'left'},
			{display: 'Comiss', name : 'comiss', width : 60, sortable : true, align: 'left'},
			{display: 'Aceite PRODEMGE', name : 'aceite_prodemge', width : 100, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListInstalacoes},
			{separator: true}
        ],
        searchitems : [
            {display: 'Nº OS', name : 'numos'},
            {display: 'Nome', name : 'nome', isdefault: true},
			{display: 'MAC', name : 'mac'},
			{display: 'Cod. Anatel', name : 'cod_anatel'},
			{display: 'Status', name : 'status'},
			{display: 'Comiss', name : 'comiss'},
			{display: 'Aceite PRODEMGE', name : 'aceite_prodemge'}
        ],
        sortname: "nome",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Instalações",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 800,
        height: 575,
        singleSelect: true,
        onSuccess: successFlexigridListInstalacoes,
        onError: successFlexigridListInstalacoes,
        showToggleBtn: false
	});
}

/* DESATIVADO */
function doCommandListInstalacoes(com, grid) 
{
	if(com == 'Abrir Instalação Selecionada')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('Instalacao/view','conteudo',{param:id,ajax:1})
		});
	}
}

function successFlexigridListInstalacoes()
{
	var campos = ["numos",
	              "nome",
	 	 		  "mac",
	 	 		  "cod_anatel",
	 	 		  "status",
	 	 		  "comiss",
	 	 		  "aceite_prodemge"];
	reconstruindoFlexigrid(campos,'Instalacao/listeFonteFiltro','Instalacao/view','#flexmeInstalacoes');
	coloreCamposListInstalacoes();
}

function coloreCamposListInstalacoes()
{
	/* comiss */
		corEmCampos('comiss','Sim','green');
		corEmCampos('comiss','Não','red');
		
	/* aceite_prodemge */
		corEmCampos('aceite_prodemge','Não','red');
		
	/* status */
		corEmCampos('status','tudo','#FF8C00');
		corEmCampos('status','Completa','green');
}
/**
 * 
 */

function desenhaTabelaEquipamentos()
{
	$("#flexmeEquipamentos").flexigrid({
    	url: 'Equipamento/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'Tipo', name : 'nome_tipo_equipamentos', width : 110, sortable : true, align: 'left'},
			{display: 'Número de Série', name : 'sno', width : 140, sortable : true, align: 'left'},
			{display: 'MAC', name : 'mac', width : 150, sortable : true, align: 'left'},
			{display: 'Status', name : 'status', width : 80, sortable : true, align: 'left'},
			{display: 'Local', name : 'local', width : 120, sortable : true, align: 'left'},
			{display: 'Vsat', name : 'vsat', width : 100, sortable : true, align: 'left'},
			{display: 'Observações', name : 'observacoes', width : 100, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListInstalacoes},
			{separator: true}
        ],
        searchitems : [
            {display: 'Tipo', name : 'nome_tipo_equipamentos', isdefault: true},
			{display: 'Número de Série', name : 'sno'},
			{display: 'MAC', name : 'mac'},
			{display: 'Status', name : 'status'},
			{display: 'Local', name : 'local'},
			{display: 'Vsat', name : 'vsat'},
			{display: 'Observações', name : 'observacoes'}
        ],
        sortname: "nome_tipo_equipamentos",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Equipamentos",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 810,
        height: 575,
        singleSelect: true,
        onSuccess: successFlexigridListEquipamento,
        onError: successFlexigridListEquipamento,
        showToggleBtn: false
	});
}


/* DESATIVADO */
function doCommandListEquipamento(com, grid) 
{
	if(com == 'Abrir Equipamento Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('Equipamento/view','conteudo',{param:id,ajax:1})
		});
	}
}

function successFlexigridListEquipamento()
{
	var campos = ["nome_tipo_equipamentos",
	 	 		  "sno",
	 	 		  "mac",
	 	 		  "status",
	 	 		  "local",
	 	 		  "vsat",
	 	 		  "observacoes"];
	reconstruindoFlexigrid(campos,'Equipamento/listeFonteFiltro','Equipamento/view','#flexmeEquipamentos');
	coloreCamposListEquipamento();
}

function coloreCamposListEquipamento()
{
	/* status */
		corEmCampos('status','Disponível','green');
		corEmCampos('status','Em uso','red');
		corEmCampos('status','Com Defeito','#1736a8');
		corEmCampos('status','Cliente','black');
//		corEmCampos('status','Equip. transferido','black');
}
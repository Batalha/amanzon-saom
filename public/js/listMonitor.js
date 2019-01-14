/**
 * 
 */

function desenhaTabelaMonitor()
{
	$("#flexme").flexigrid({
    	url: 'Monitor/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'Username', name : 'USERNAME', width : 100, sortable : true, align: 'left'},
			{display: 'Status', name : 'STATUS', width : 150, sortable : true, align: 'left'},
			{display: 'Alarme', name : 'ALARME', width : 100, sortable : true, align: 'left'},
			{display: 'Data', name : 'TIMESTAMP', width : 150, sortable : true, align: 'left'},
			{display: 'Período Off', name : 'PERIOD', width : 100, sortable : true, align: 'left'},
			{display: 'Min Off', name : 'CONTADOR', width : 90, sortable : true, align: 'left'},
			{display: 'N Logoff', name : 'NLOGOFF', width : 90, sortable : true, align: 'left'}
		],
        searchitems : [
            {display: 'Username', name : 'USERNAME', isdefault: true},
			{display: 'Status', name : 'STATUS'},
			{display: 'Alarme', name : 'ALARME'},
			{display: 'Data', name : 'TIMESTAMP'},
			{display: 'Período Off', name : 'PERIOD'},
			{display: 'Min Off', name : 'CONTADOR'},
			{display: 'N Logoff', name : 'NLOGOFF'}
        ],
        sortname: "USERNAME",
        sortorder: "desc",
        usepager: true,
        title: "Monitor",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 700,
        height: 495,
        singleSelect: true,
        onSuccess: coloreCamposListMonitor,
        onError: coloreCamposListMonitor
	});
}

function coloreCamposListMonitor()
{
	/* vsatCriada */
		corEmCamposListMonitor('ALARME','LOGOFF','red');
}

/*corEmCampos('Completa','red')*/
function corEmCamposListMonitor(campo,valor,cor)
{
	$('td[abbr|="'+campo+'"] div').each(function(){
		if(valor=='tudo') /* para todos */
		{
			valor = $(this).html();
			$(this).html('<font style="color:'+cor+'">'+valor+'</font>');
			valor='tudo';
		}
		else /* para selecionados */
		{
		    if(strip_tags ($(this).html(),'')==valor){
		    	$(this).html('<font style="color:'+cor+'">'+valor+'</font>');
		    }
		}
	});
}
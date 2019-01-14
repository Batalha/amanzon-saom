/**
 * Arquivo criado para as funções da Página Inicial
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */



function  cancelConfirmAgend(id)
{
	wait();
	   
	Ext.Ajax.request({
	    
	    url: 'AgendaInstal/cancelConfirmAgend',
	    params: {
	        
	        id: id,
	        ajax: 1
	    },
	
		success: function(response)
		{
		    var r = Ext.JSON.decode(response.responseText);
		    
		    if(r.status == 'ok'){
		        sucessMsg('AgendaInstal/edit');
		    }
		    else{
		        erroMsg(r.msg);
		    }
		    
		}
	});
}

/**
 * Arquivo criado para as funções da Página Inicial
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */


/*
 * OS's
 */
function abrePainelOS()
{
    el = Ext.get('painelAgend');
    el.toggle();
    simpleRequest('resultPen','OS/countAgendPend');
    simpleRequest('resultAgen','OS/countAgend');
    simpleRequest('resultConfirm','OS/countAgendConfirm');
    simpleRequest('resultStatusVenc','OS/countOSVenc');
    simpleRequest('resultStatusConc','OS/countOSConc');
    simpleRequest('resultStatusAberto','OS/countOSAberto');
}
 
/*
 * Instalações
 */
function abrePainelInstal()
{
    el = Ext.get('painelInstal');
    el.toggle();
    simpleRequest('resultInstalPS','Instalacao/countPendShapper');
    simpleRequest('resultInstalPW','Instalacao/countPendWNMS');
    simpleRequest('resultInstalIN','Instalacao/countInc');
    simpleRequest('resultInstalCM','Instalacao/countComiss');
}
 
/*
 * Incidentes
 */
function abrePainelIncid()
{
    el = Ext.get('painelIncid');
    el.toggle();
    simpleRequest('resultadoIncidentesAbertos','Incidente/ContaIncidentesAbertos');
    simpleRequest('resultadoIncidentesAtendimento','Incidente/ContaIncidentesEmAtendimentos');
    simpleRequest('resultadoIncidentesFinalizados','Incidente/ContaIncidentesFinalizados');
}

/*
 * Agendamentos
 */
function abrePainelAgendamentos()
{
    el = Ext.get('painelAgendamentos');
    el.toggle();
    
    $.ajax({
    	url:'AgendaInstal/listaHome',
    	type:'POST',
    	data: {conteudo:'verificacao'}
    }).done(function(data){
    	$('#lista_agendamentos_home').html(data);
    });
}
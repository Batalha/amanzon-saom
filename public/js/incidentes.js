/**
 * Arquivo criado para as funções da Página Inicial
 * 
 * @author Sávio
 * @contact lotharthesavior@gmail.com
 */


var atualizaEditorIncidentes;

var cronometroIncidenteView;

/**
 * FUNCAO para verificação se já existe algum incidente para 
 * aquele IdProdemge.
 */


function verificaVsat(){
	var instVsat = $('#instVsat').val();
		
		if(instVsat=='')/*encontrado - desabilita*/
		{
			simpleMsg('Por favor Inclua uma Vsat.');
			$("#respostaFormAjax").attr("disabled", true);
			
		}	
		else{
			$("#submitIncidenteCreate").attr("disabled", false);
				/*mantém habilitado*/
			
		}
}

function verificaCamposIncidente()
{
	var idProdemge = $('#idprodemge').val();
	var instal = $('#nome_instalacao').val();
	var tecnicoNoc = $('#tecnicoNoc').val();
	var dt= $('#data').val();

	/*busca no banco incidentes com o idprodemge especificado*/
	$.post('Incidente/verificaCamposIncidente',{idProdemge:idProdemge, datas:dt, tecnicoNoc:tecnicoNoc, instal:instal},function(data){
		/*alert(data);*/

		if(data=='encontrado')/*encontrado - desabilita*/
		{
			simpleMsg('Id Prodemge já existente na lista de incidentes.');
			$("#submitIncidenteCreate").attr("disabled", true);
			$("#idprodemge").attr('value', '');
		}
		else if(data=='vazioDt')/*encontrado - desabilita*/
		{
			simpleMsg('Preecha o campo Data.');
			$("#submitIncidenteCreate").attr("disabled", true);
			
		}
		else if(data=='vazioTecnico')/*encontrado - desabilita*/
		{
			simpleMsg('Escolha um Tecnico Noc.');
			$("#submitIncidenteCreate").attr("disabled", true);
			
		}
		else if(data=='vazio')/*encontrado - desabilita*/
		{
			simpleMsg('Id Prodemge Deve ser preenchido.');
			$("#submitIncidenteCreate").attr("disabled", true);
			
		}
		else if(data=='vazioInstalacao')/*encontrado - desabilita*/
		{
			simpleMsg('Escolha a Instalacao.');
			$("#submitIncidenteCreate").attr("disabled", true);
			
		}

//		else if(data=='naoNumerico')/*nao numerico*/
//		{
//			simpleMsg('Id Prodemge deve ser numérico.');
//			$("#submitIncidenteCreate").attr("disabled", true);
//		}
//		else if(data=='seisDigitos')/*diferente de 6 digitos*/
//		{
//			simpleMsg('Id Prodemge deve ter 6 dígitos.');
//			$("#submitIncidenteCreate").attr("disabled", true);
//		}

		else{
			$("#submitIncidenteCreate").attr("disabled", false);
				/*mantém habilitado*/
			
		}

		
	});
}


/**
 * Função para despausar o cronometro
 */
function despausarCronometro(cronometro_interrupcao)
{
	$.post('Cronometro_interrupcao/despausaCronometro',{cronometro_interrupcao:cronometro_interrupcao},function(data){
		/*alert(data.split('|'));*/
		var resposta = data.split('|');
		if(resposta[1]=='ok')
		{
			simpleMsg('Cronômetro despausado.');
			getAjaxForm('Incidente/view','conteudo',{param:resposta[0],ajax:1});
		}
		else
		{
			simpleMsg('Erro ao despausar cronômetro.');
			getAjaxForm('Incidente/view','conteudo',{param:resposta[0],ajax:1});
		}
	});
}

/**
 * Função para editar pausa em cronometro
 */
function editaCronometro(cronometro)
{
	$.post('Cronometro_interrupcao/formEditaPausa',{cronometro:cronometro},function(data){
		$('#divDinamico').html(data);
	});
}

/**
 * Função para pausar cronometro
 */
function pausaCronometro(cronometro)
{
	$.post('Cronometro_interrupcao/formPausa',{cronometro:cronometro},function(data){
		$('#divDinamico').html(data);
	});
}

/**
 * Função para setar cronometro rodando
 */
/*
 * hor,min,seg -> tempo corrido
 */
function rodaCronometro(status){
	if( status == 'Aberto' || status == 'Em Atendimento' || status == 'Sem Atendimento' )
	{
		var medicaoAtual = $('#tempoTranscorrido').html();
		var tempoDividido = medicaoAtual.split(':');
		
		days = retiraZeroEsquerda(tempoDividido[0]);
		hor = retiraZeroEsquerda(tempoDividido[1]);if( hor.length < 2 ){ hor = '0'+hor; }
		min = retiraZeroEsquerda(tempoDividido[2]);if( min.length < 2 ){ min = '0'+min; }
		seg = retiraZeroEsquerda(tempoDividido[3]);if( seg.length < 2 ){ seg = '0'+seg; }
		local = 'tempoTranscorrido';
		
		cronometroIncidenteView = new Date();
		cronometroIncidenteView.setHours(hor);
		cronometroIncidenteView.setMinutes(min);
		cronometroIncidenteView.setSeconds(seg);
		
		cronometroIncidente = setInterval("StartCrono_corrido()",1000);
		//console.log(cronometroIncidenteView);
	}
}
 
function StartCrono_corrido()
{	
	/* interrompe se não tem disponível o campo (para casos de outras páginas) */
	if($('#'+local).html()==null){ return 0; }
	
	cronometroIncidenteView.setSeconds( cronometroIncidenteView.getSeconds() + 1 );
	
	var hor = retiraZeroEsquerda(cronometroIncidenteView.getHours());
		var hora  = new String(hor);
		if( hora.length < 2 ){ hor = '0'+hor; }
	var min = retiraZeroEsquerda(cronometroIncidenteView.getMinutes());
		var minu  = new String(min);
		if( minu.length < 2 ){ min = '0'+min; }
	var seg = retiraZeroEsquerda(cronometroIncidenteView.getSeconds());
		var segu  = new String(seg);
		if( segu.length < 2 ){ seg = '0'+seg; }
	
	hor = hor + ( 24 * days );
		
	var tempo = hor+':'+min+':'+seg;
	
	$('#'+local).html(tempo);
	
	apresentacaoTempoTranscorrido();
}

function apresentacaoTempoTranscorrido(){
	var mostraTempoTranscorrido = $('#tempoTranscorrido').css('visibility');
	if( mostraTempoTranscorrido == 'hidden' ){
		$('#tempoTranscorrido').css('visibility','visible');
	}
}

function ativaSubmenuIncidentes()
{
	$('#submenu a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		switch( $(this).attr('href') ) //atributo href do link clicado
		{
			case '#novoincidente':
				
				break;
			case '#listaincidentes':
				getAjaxForm('Incidente/liste');
				break;
			case '#listaatendimentos':
				getAjaxForm('AtendVsat/liste');
				break;
			case '#relatorio':
				//window.open('http://vodanet-telecom.com/SAOM/Incidente/relatorio');
				//TODO: fazer esse item de menu funcional
				break;
			case '#relatorioIncidentesPorInstalacao':
				getAjaxForm('Relatorio/incidentesPorInstalacao');
				break;
		}
	});
}


// --  chama modal

function abreEscolhaIncidentes(){

	$('#modalInstalacoes').modal();
	$.ajax({
		async:false,
		url:'Incidente/formularioComListaDeInstalacoes',
		type:'POST',
		data:{idIncidente:$('#idincidentes').val()},
		success:function( resposta ){
			
			$('#modalConteudo').html( resposta );
			var lista = $('#listaInstalacoes').html();
	
			var listaArray = lista.split(',');

			$("#nome_instalacao").focus().autocomplete(listaArray);
			
		}
	});
	
}
//function abreInsereNumeroProdemge(){
//	
//	$('#modalProdemge').modal();
//	$.ajax({
//		async:false,
//		url:'Incidente/formularioComListaDeProdemge',
//		type:'POST',
//		data:{idIncidente:$('#idincidentes').val()},
//		success:function( resposta ){
//			
//			$('#modalConteudoPro').html( resposta );
////			var lista = 
////			$("#num_prodemge").html();
////			var listaArray = lista.split(',');
////			$("#num_prodemge").focus().autocomplete(listaArray);
//			
//		}
//	});
//	
//}

function atualizaEditorIncidente( idincidentes ){
	$("#modalInstalacoes").modal("hide");
	getAjaxForm('Incidente/edit',false,{param:idincidentes,ajax:1});
}


// para retirar zero a esquerda
function retiraZeroEsquerda( numero ){
	if( numero[0] ){
		while( numero[0] == 0 ){
			numero = numero.substr(1,numero.length);
		}
	}
	return numero;
}


// 



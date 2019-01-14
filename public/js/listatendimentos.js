
/**
 * 
 */

"use strict";

var tempoCrono;
var controle;
var timeCrono;

function desenhaTabelaAtendimentos()
{
	$("#flexmeListAtendimentos").flexigrid({
    	url: 'AtendVsat/listeFonte',
        dataType: 'json',
        colModel : [
            {display: 'Id Atendimento', name : 'idatend_vsat', width : 80, sortable : true, align: 'left'},
            {display: 'Id Incidente', 	name : 'idincidentes', width : 75, sortable : true, align: 'left'},
            {display: 'Localidade', 	name : 'localidade', width : 137, sortable : true, align: 'left'},
            {display: 'Nome da Vsat', 	name : 'nome_vsat', width : 95, sortable : true, align: 'left'},
            {display: 'Hub', 			name : 'hub', width : 60, sortable : true, align: 'left'},
            {display: 'Usuário', 		name : 'usuario', width : 120, sortable : true, align: 'left'},
            {display: 'Status', 		name : 'status', width : 90, sortable : true, align: 'left'},
            {display: 'Início', 		name : 'inicio', width : 115, sortable : true, align: 'left'},
            {display: 'Fim', 			name : 'fim', width : 115, sortable : true, align: 'left'},
			{display: 'Tempo Passado', 	name : 'tempo_passado', width : 100, sortable : true, align: 'left'}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListAtendimentos},
			{separator: true}
        ],
        searchitems : [
            {display: 'Id Atendimento', name : 'idatend_vsat', isdefault: true},
            {display: 'Id Incidente', name : 'idincidentes'},
            {display: 'Localidade', name : 'localidade'},
            {display: 'Nome da Vsat', name : 'nome_vsat'},
            {display: 'Hub', name : 'hub'},
            {display: 'Usuário', name : 'usuario'},
            {display: 'Status', name : 'status'},
            {display: 'Início', name : 'inicio'},
            {display: 'Fim', name : 'fim'},
			{display: 'Tempo Passado', name : 'tempo_passado'}
        ],
        sortname: "idatend_vsat",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Atendimentos",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 1000,
        height: 590,
        singleSelect: true,
        onSuccess: successFlexigridListAtendimentos,
        onError: successFlexigridListAtendimentos,
        showToggleBtn: false
	});
}


/* DESATIVADO */
function doCommandListAtendimentos(com, grid) 
{
	if(com == 'Abrir Atendimento Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('idatend_vsat');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('AtendVsat/view','conteudo',{param:id,ajax:1})
		});
	}
}


function successFlexigridListAtendimentos()
{
	//hora atual em javascript
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1; //months are zero based
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
			if(curr_hour<10){curr_hour = "0"+curr_hour;}
		var curr_min = d.getMinutes();
			if(curr_min<10){curr_min = "0"+curr_min;}	
		var curr_sec = d.getSeconds();
			if(curr_sec<10){curr_sec = "0"+curr_sec;}
		var dataAtual = curr_year+ "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_min + ":" + curr_sec;

	var campos = ["idatend_vsat",
	              "idincidentes",
	              "localidade",
	              "nome_vsat",
	              "hub",
	              "usuario",
	              "status",
	              "inicio",
	              "fim",
	              "tempo_passado"];
	
	controle = new controleGridAcompanhamento();
	controle.reconstuirGrid(campos,	'AtendVsat/listeFonteFiltro','AtendVsat/view','#flexmeListAtendimentos');
	controle.coloreCampos();
	controle.cronometro();
	//controle.reload();
}

function controleGridAcompanhamento()
{
	/* ---- RECONSTRUÇÃO DA GRID ---- */
	this.reconstuirGrid = function (campos,url,viewAjax,flexme){
		reconstruindoFlexigrid(campos,url,viewAjax,flexme);
	}
	
	/* ---- COLORE CAMPOS ---- */
	this.coloreCampos = function(){
		/* status */
			corEmCampos('status','Em Atendimento','#FF8C00');
			corEmCampos('status','Aberto','green');
			/*corEmCampos('status','Finalizado','#ccc');*/
	}
	
	/* ---- LINK ---- */
	this.chamaAtendimento = function(atend){
		setTimeout("getAjaxForm('AtendVsat/view','divDinamico',{param:"+atend+",ajax:1},$('.carregamentoUrgente').remove())",1000);
	}
	
	/* ---- CRONOMETRO ---- */
	this.cronometro = function(){
		$('#flexmeListAtendimentos td[abbr="tempo_passado"] div').each(function(){
			var seletor = 'cronometro_'+$(this).parent().parent().attr('id');
			
			$(this).attr('id',seletor);
			
			$('#'+seletor).css({
				'fontWeight':'bold',
				'fontSize':'110%'
			});
			
			var tempo = $(this).html();
			
			/* retira cronometro pra chamado finalizado */
				if(
					($('#'+seletor).parent().parent().find('td[abbr="fim"] div').html() != '') &&
					($('#'+seletor).parent().parent().find('td[abbr="fim"] div').html() != '&nbsp;')
				  )
				{
					var tempo = 'Finalizado';
				}
			
			if(tempo != 'Finalizado')
			{
				var tempoRepartido = tempo.split(':');
				controle = new controleGridAcompanhamento();
				controle.cronoAcompanhamento(
							parseInt(tempoRepartido[0]),
							parseInt(tempoRepartido[1]),
							parseInt(tempoRepartido[2]),
							seletor
							);
			}
			else
			{
				$('#'+seletor).css('color','#949494');
			}
		});
	}
	
	this.cronoAcompanhamento = function(hor,min,seg,local){
		var timeCrono;
		StartCrono_corridoAtendimento(hor,min,seg,local);
	}
	
	/* ---- RELOAD ---- */
	/*this.reload = function(){
		//registra 1 atualizacao
			var atualizacoes = $('#atualizacao').val();
			atualizacoes++;
			$('#atualizacao').val(atualizacoes);
		
		//setTimeout('verificaAualizacaoDisponivelNoc()',60000);
	}*/
}


/* ##### EXTRAS #### */

	/* ---- LINK ---- */
	/*function chamaComissionamento_particionado(comiss)
	{
		guardaReserva(comiss,'#idInstalacoes_reserva');
		getAjaxForm('Instalacao/comiss_view','dadosInstal',{param:comiss,ajax:1},$('.carregamentoUrgente').remove());
	}*/

	/* ---- RELOAD PARA ATUALIZACAO ---- */
	/*function verificaAualizacaoDisponivelNoc()
	{
		var ultimaRequisicao = $('#ultimaRequisicao').val();
		$.post('Acompanhamento/verificaAtualizacaoDisponivel',{ultimaRequisicao:ultimaRequisicao},function(data){
			if(data>0)
			{
				atualizaCampo();
			}
			else
			{
				setTimeout('verificaAualizacaoDisponivelNoc()',60000);
			}
		});
	}*/
	
	/*function atualizaAtendimento()
	{
		//verifica e retira uma atualizacao
			var atualizacoes = $('#atualizacao').val();
			if( atualizacoes > 1 )
			{
				atualizacoes--;
				$('#atualizacao').val(atualizacoes);
				
				return 0;
			}
		
		if($("#flexmeListAtendimentos").html()==null)
		{
			return 0;
		}
		else
		{
			//efeito para disfarce
				$('.flexigrid').html('<font style="font-size:20px;font-weight:bold;">Atualizando...</font>');
				
			setTimeout('refreshAtendimento()',1500);
			//$("#flexmeListChamadosFull").flexReload();
		}
	}*/
	
	/*function refreshAtendimento()
	{
		getAjaxForm("Acompanhamento/");
	}*/
	
	/*
	 * hor,min,seg -> tempo corrido
	 */
		function StartCrono_corridoAtendimento(hor,min,seg,local)
		{
			/* interrompe se não tem disponível o campo (para casos de outras páginas) */
				if($('#'+local).html()==null)
				{
					return 0;
				}
			
			seg++;
				
			if (seg > 59) 
			{ 
				min+= 1 ;
				seg = 0;
			}
			
			if (min > 59) 
			{
				min = 0;
				hor+= 1;
			}
			
			if(hor > 3)
			{
				$('#'+local).css('color','red');
			}
			
			timeCrono = (hor < 10) ? "0" + hor : hor;
			timeCrono += ((min < 10) ? ":0" : ":") + min;
			timeCrono += ((seg < 10) ? ":0" : ":") + seg;
			
			$('#'+local).html(timeCrono);
			tempoCrono = '';
			tempoCrono = setTimeout("StartCrono_corridoAtendimento("+hor+","+min+","+seg+",'"+local+"')",1000);
		}
	
	/*
	 * hor,min,seg -> tempo que falta
	 */
		function StartCrono_faltaNoc(hor,min,seg,local)
		{
			/* interrompe se não tem disponível o campo (para casos de outras páginas) */
				if($('#'+local).html()==null)
				{
					return 0;
				}
			
			if ( seg < 1 ) 
			{
				if( min > 0 )
				{
					seg = 59;
					min--;
					var minZerado = 0;
				}
				else
				{
					var minZerado = 1;
				}
			}
			
			if (min < 1) 
			{
				if( hor > 0 )
				{
					min=59;
					hor--;
					var horZerada = 0;
				}
				else
				{
					var horZerada = 1;
				}
			}
			
			timeCrono= (hor < 10) ? "0" + hor : hor;
			timeCrono+= ((min < 10) ? ":0" : ":") + min;
			timeCrono+= ((seg < 10) ? ":0" : ":") + seg;
			
			if( horZerada == 1 && minZerado == 1)
			{
				$('#'+local).html('Vencido');	
				return 0;
			}
			else
			{
				if( hor < 1 )
				{
					$('#'+local).css('color','red');
				}
				$('#'+local).html(timeCrono);
			}
			
			seg--;
			tempoCrono = '';
			tempoCrono = setTimeout("StartCrono_faltaAtendimento("+hor+","+min+","+seg+",'"+local+"')",1000);
		}
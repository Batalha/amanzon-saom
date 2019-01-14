
function desenhaTabelaAcompanhamentosChamadosFullComsp()
{
	$("#flexmeListChamadosFullsp").flexigrid({
    	url: 'Acompanhamento_sp/acompanhamentoComConteudo',
        dataType: 'json',
        colModel : [
            {display: 'Técnico', name : 'tecnico', width : 150, sortable : true, align: 'left'},
            {display: 'Qtd Filho', name : 'numero_qtd', width : 50, sortable : true, align: 'left'},
            {display: 'Tipo', name : 'tipo', width : 100, sortable : true, align: 'left'},
            {display: 'Data Início', name : 'data_inicio', width : 115, sortable : true, align: 'left'},
            {display: 'Incidente', name : 'incidente', width : 65, sortable : true, align: 'left'},
            //{display: 'ID Prodemge', name : 'numero_prodemge', width : 75, sortable : true, align: 'left'},
            {display: 'Vsat', name : 'vsat', width : 115, sortable : true, align: 'left'},
            {display: 'Hub', name : 'hub', width : 100, sortable : true, align: 'left'},
            {display: 'Status', name : 'status', width : 90, sortable : true, align: 'left'},
            {display: 'Data Fim', name : 'data_fim', width : 115, sortable : true, align: 'left'},
            {display: 'Tempo Transcorrido', name : 'tempo_vencimento', width : 115, sortable : true, align: 'left'},
			{display: 'Resposta Agilis', name : 'resposta_agilis', width : 115, sortable : true, align: 'left', hide: true},
			{display: 'Id Instalações', name : 'idinstalacoes', width : 115, sortable : true, align: 'left', hide: true}
		],
        buttons : [
			{name: 'Carregando...', bclass: 'view', onpress : doCommandListInstalacoessp},
			{separator: true}
        ],
        searchitems : [
            {display: 'Técnico', name : 'tecnico', isdefault: true},
            {display: 'Qtd Filho', name : 'numero_qtd'},
            {display: 'Tipo', name : 'tipo'},
            {display: 'Data Início', name : 'data_inicio'},
            {display: 'Incidente', name : 'incidente'},
            //{display: 'ID Prodemge', name : 'numero_prodemge'},
            {display: 'Vsat', name : 'vsat'},
            {display: 'Hub', name : 'hub'},
            {display: 'Status', name : 'status'},
            {display: 'Data Fim', name : 'data_fim'},
            {display: 'Tempo Transcorrido', name : 'tempo_vencimento'},
			{display: 'Resposta Agilis', name : 'resposta_agilis'},
            {display: 'Id Instalações', name : 'idinstalacoes'}
        ],
        sortname: "tecnico",
        sortorder: "desc",
        usepager: true,
        title: "Lista de Acompanhamentos COM",
        useRp: true,
        rp: 20,
        showTableToggleBtn: false,
        resizable: false,
        width: 1100,
        height: 520,
        singleSelect: true,
        onSuccess: successFlexigridListChamadosFullComsp,
        onError: successFlexigridListChamadosFullComsp,
        showToggleBtn: false
	});
}


/* DESATIVADO */
function doCommandListChamadosFull(com, grid) 
{
	if(com == 'Abrir Acompanhamento Selecionado')
	{
		$('.trSelected', grid).each(function() {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			getAjaxForm('Acompanhamento_sp/view_chamados','conteudo',{param:id,ajax:1})
		});
	}
}


function successFlexigridListChamadosFullComsp()
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
	
	var campos = ["tecnico",
	              "numero_qtd",
	              "tipo",
	              "data_inicio",
	              "incidente",
	              "numero_prodemge",
	              "vsat",
	              "hub",
	              "status",
	              "data_fim",
	              "tempo_vencimento",
	              "resposta_agilis"];
	
	var controle = new controleGridCom();
	controle.reconstuirGridSp(
							campos,
							'Acompanhamento_sp/acompanhamentoComConteudoFiltro',
							'',
							'#flexmeListChamadosFullsp',
							controle
							);
	controle.coloreCamposSp();
	controle.cronometroSp();
	controle.reloadSp();
}

function controleGridCom()
{
	/* ---- RECONSTRUÇÃO DA GRID ---- */
	this.reconstuirGridSp = function (campos,url,viewAjax,flexme){
		reconstruindoFlexigrid(campos,url,viewAjax,flexme);
	}
	
	/* ---- COLORE CAMPOS ---- */
	this.coloreCamposSp = function(){
		/* vsatCriada */
			corEmCampos('tempo_vencimento','tudo','red');
			corEmCampos_corRespostaAgilis('resposta_agilis','1','#FF8C00');
		/* status */
			corEmCampos('status','Em Andamento','#FF8C00');
			corEmCampos('status','Aberto','green');
			/*corEmCampos('status','Finalizado','#ccc');*/
	}
	
	/* ---- LINK ---- */
	this.chamaAtendimentoSp = function(atend){
		//setTimeout("getAjaxForm('AtendVsat/view','divDinamico',{param:"+atend+",ajax:1},$('.carregamentoUrgente').remove())",1000);
		$('.carregamentoUrgente').remove();
	}
	this.chamaComissionamentoSp = function(comiss){
		setTimeout("chamaComissionamento_particionado("+comiss+")",1000);
	}
	
	/* ---- CRONOMETRO ---- */
	this.cronometroSp = function(){
		$('#flexmeListChamadosFullsp td[abbr="tempo_vencimento"] div').each(function(){
			var seletor = 'cronometro_'+$(this).parent().parent().attr('id');
			
			$(this).attr('id',seletor);
			
			$('#'+seletor).css({
				'fontWeight':'bold',
				'fontSize':'110%'
			});
			
			var tempo = $(this).html();
			
			/* retira cronometro pra chamado finalizado */
				if(
					$('#'+seletor).parent().parent().find('td[abbr="status"] div').html() == 'Finalizado' ||
					$('#'+seletor).parent().parent().find('td[abbr="status"] div').html() == '-'
				  )
				{
					if($('#'+seletor).parent().parent().find('td[abbr="status"] div').html() != '-')
					{
						var tempo = 'Finalizado';
					}
				}
			
			if(tempo!='Finalizado')
			{
				var tempoRepartido = tempo.split(':');
				controle = new controleGridCom;
				controle.cronoComSp(
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
	
	this.cronoComSp = function(hor,min,seg,local){
		var timeCrono;
		StartCrono_corridoCom(hor,min,seg,local);
	}
	
	/* ---- RELOAD ---- */
	this.reloadSp = function(){
		//registra 1 atualizacao
			var atualizacoes = $('#atualizacao').val();
			atualizacoes++;
			$('#atualizacao').val(atualizacoes);
		
		setTimeout('verificaAualizacaoDisponivelCom()',60000);
	}
}

/* ##### EXTRAS #### */

	/* ---- LINK ---- */
	function chamaComissionamento_particionado(comiss)
	{
		guardaReserva(comiss,'#idInstalacoes_reserva');
		getAjaxForm('Comissionamento_sp/comiss_view','dadosInstal',{param:comiss,ajax:1},$('.carregamentoUrgente').remove());
	}

	/* ---- RELOAD PARA ATUALIZACAO ---- */
	function verificaAualizacaoDisponivelCom()
	{
		var ultimaRequisicao = $('#ultimaRequisicao').val();
		$.post('Acompanhamento_sp/verificaAtualizacaoDisponivel',{ultimaRequisicao:ultimaRequisicao},function(data){
			if(data>0)
			{
				atualizaCampoSp();
			}
			else
			{
				setTimeout('verificaAualizacaoDisponivelCom()',60000);
			}
		});
	}
	function atualizaComSp()
	{
		//verifica e retira uma atualizacao
			var atualizacoes = $('#atualizacao').val();
			if( atualizacoes > 1 )
			{
				atualizacoes--;
				$('#atualizacao').val(atualizacoes);
				
				return 0;
			}
		
		if($("#flexmeListChamadosFullsp").html()==null)
		{
			return 0;
		}
		else
		{
			//efeito para disfarce
				$('.flexigrid').html('<font style="font-size:20px;font-weight:bold;">Atualizando...</font>');
				
			setTimeout('refreshCom()',1500);
			//$("#flexmeListChamadosFull").flexReload();
		}
	}
	
	function refreshCom()
	{
		getAjaxForm("Acompanhamento_sp/acompanhamentoCom");
	}
	
	/*
	 * hor,min,seg -> tempo corrido
	 */
		function StartCrono_corridoCom(hor,min,seg,local){
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
			setTimeout("StartCrono_corridoCom("+hor+","+min+","+seg+",'"+local+"')",1000);
		}
	
	/*
	 * hor,min,seg -> tempo que falta
	 */
		function StartCrono_faltaCom(hor,min,seg,local)
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
			setTimeout("StartCrono_faltaCom("+hor+","+min+","+seg+",'"+local+"')",1000);
		}
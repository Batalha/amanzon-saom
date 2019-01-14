/**
 * 
 */


/*corEmCampos('Completa','red')*/
function corEmCampos(campo,valor,cor)
{
    //alert(campo);
	$('td[abbr|="'+campo+'"] div').each(function(){
		if(valor=='tudo') /* para todos */
		{
			/*$(this).wrap('<font style="color:'+cor+'"/>');*/
			$(this).css('color',cor);
		}
		else /* para selecionados */
		{
		    if(strip_tags ($(this).html(),'')==valor){
		    	$(this).css('color',cor);
		    	/*$(this).wrap('<font style="color:'+cor+'"/>');*/
		    } 
		}
	});
}

function corEmCampos_corRespostaAgilis(campoExterno,valor,cor)
{
	$('td[abbr|="'+campoExterno+'"]').each(function(){
		
		var campoRespostaAgilis = $(this).html();
		//resgate resposta_agilis
			var preRespostaAgilis1 = campoRespostaAgilis.split('">');
			var preRespostaAgilis2 = preRespostaAgilis1[1].split('</');
			var respostaAgilis = preRespostaAgilis2[0]
			
		var respostaAgilis = $(this).find('div').html();
		var hora = $(this).prev().find('div').html();
		
		var horaHora = hora.split(':');
			
		if( respostaAgilis == 1 && parseInt(horaHora[0]) > 0 )
		{
			$(this).prev().find('div').css('color',cor);
		}
	});
}

function reconstruindoFlexigrid(campos,url,viewAjax,flexme)
{

    //alert(flexme);


	/* medidas dos filtros */
	var camposFiltros = [];
	for(var i=0;i<campos.length;i++)
	{
		$('.divFiltro_'+campos[i]).css({'width':$("[abbr='"+campos[i]+"']").css('width')});
		camposFiltros[i] = campos[i];
	}

	/* CONSERTO PARA FIREFOX */
		if( $.browser.mozilla )
		{
			$('.filtros_flexigrid').css({'margin-left':'1px'});
		}
	
	/* acao de filtros */
		$('.input_filtros').keyup(function(event){
			/* ENTER */
				if(event.keyCode==13)
				{
					var filtroAtual;
					var campos = Array();
					var valores = Array();
					
					/* resgate o valor de cada uma das colunas */
						var contador = 0;
						camposExistentes = false;
						$(camposFiltros).each(function(){
							filtroAtual = 'filtro_'+this;
							var valorAtual = $('#'+filtroAtual).val();
							campoAtual = $('#'+filtroAtual).attr('id');
							if( valorAtual )
							{
								campos[contador] = campoAtual;
								valores[contador] = valorAtual;
								contador++;
								camposExistentes = true;
							}
						});
					/* construindo query */
						var query = [];
						if(camposExistentes)
						{
							for(var i=0;i<valores.length;i++)
							{
								if(valores[i] != 'vz' && valores[i] != '')
								{
									query[i] = campos[i].substring(7) +" LIKE '%"+ valores[i] +"%' ";
									
								}
								else
								{
									query[i] = " ( "+campos[i].substring(7)+" = '' OR "+campos[i].substring(7)+" IS NULL OR "+campos[i].substring(7)+" = '0000-00-00' ) ";
									
								}
							}
						}
						
					query = query.join(' AND ');

					p = $(flexme);

					p.flexOptions({
						url:url,
						query:query
					}).flexReload();

				}

			
		});
	
	//mudando posicionamentos
		$('.flexigrid').prepend($('.fDiv'));$('.fDiv').css({'display':'block'});
		$('.flexigrid').prepend($('.sDiv'));
		$('.flexigrid').prepend($('.pDiv'));
		$('.flexigrid').prepend($('.mDiv'));
		$('.tDiv').css({'display':'none'});
		
	//aplicando o click nas linhas


		$('.hDivBox tr').each(function(){
			$('tr').css({
				'cursor':'pointer'
			});

			if(flexme=='#flexmeListChamadosFull') /* CHAMADOS */
			{

				var controle = new controleGridNoc();
				
				$('tr').click(function(){

					var tipo = $(this).find('[abbr="tipo"] div').html();
					var carregamento = "<div class='carregamentoUrgente'>Carregando Atendimento...</div>";
					$('#todo').prepend(carregamento);


					if( tipo == 'Comissionamento' ) /* COMISSIONAMENTO */
					{
						var id = $(this).attr('id');
						id = id.substring(id.lastIndexOf('row')+3);
						var idinstalacoes = $(this).find('[abbr="idinstalacoes"] div').html();
						getAjaxForm('OS/view','conteudo',{param:id,ajax:1},controle.chamaComissionamento(idinstalacoes));
					}
					else /* ATENDIMENTO */
					{
						var id = $(this).find('[abbr="incidente"] div').html();
						var atend = $(this).attr('id');
						atend = atend.substring(atend.lastIndexOf('row')+3);
						getAjaxForm('Incidente/view','conteudo',{param:id,ajax:1},controle.chamaAtendimento(atend));
					}
				});
			}else if(flexme=='#flexmeListChamadosFullsp'){
                var controle = new controleGridNocsp();

                $('tr').click(function(){
                    var tipo = $(this).find('[abbr="tipo"] div').html();
                    var carregamento = "<div class='carregamentoUrgente'>Carregando Atendimento...</div>";
                    $('#todo').prepend(carregamento);
                    if( tipo == 'Comissionamento_sp' ) /* COMISSIONAMENTO */
                    {
                        var id = $(this).attr('id');
                        id = id.substring(id.lastIndexOf('row')+3);
                        var idinstalacoes = $(this).find('[abbr="idinstalacoes"] div').html();
                        getAjaxForm(viewAjax,'conteudo',{param:id,ajax:1},controle.chamaComissionamento(idinstalacoes));
						setTimeout(function(){ initialize(); },1000);
                    }
                    else /* ATENDIMENTO */
                    {
                        var id = $(this).find('[abbr="incidente"] div').html();
                        var atend = $(this).attr('id');
                        atend = atend.substring(atend.lastIndexOf('row')+3);
                        getAjaxForm('Incidente_sp/view','conteudo',{param:id,idatend:atend,ajax:1},controle.chamaAtendimento(atend));
                    }
                });
            }
			else if(flexme == '#flexmeListAtendimentos')
			{

                $('tr').click(function(){
					var id = $(this).find('[abbr="idincidentes"] div').html();
					var idatendimento = $(this).attr('id');
					idatendimento = idatendimento.substring(idatendimento.lastIndexOf('row')+3);
					$.ajax({
						url:'Incidente/view',
						type:'POST',
						data:{param:id}
					}).done(function(data){
						$('#conteudo').html(data).ready(function(){
							$.ajax({
									url:'AtendVsat/listeAtendsIncidente',
									type:'POST',
									data:{param:id}
							}).done(function(data){
								$('#divDinamico').html(data).ready(function(){
									$.ajax({
										url:'AtendVsat/view',
										type:'POST',
										data:{param:idatendimento}
									}).done(function(data){
										$('#divDinamico').html(data);
									});
								});
							});
						});
					});
				});
			}
			else if(flexme == '#flexmeListAtendimentossp')
			{

				$('tr').click(function(){
					var id = $(this).find('[abbr="idincidentes"] div').html();
					var idatendimento = $(this).attr('id');
					idatendimento = idatendimento.substring(idatendimento.lastIndexOf('row')+3);
					//alert(idatendimento);
					$.ajax({
						url:'Incidente_sp/view',
						type:'POST',
						data:{param:id, idatend:idatendimento}
					}).done(function(data){
						$('#conteudo').html(data).ready(function(){
							$.ajax({
									url:'AtendVsat_sp/listeAtendsIncidente',
									type:'POST',
									data:{param:id}
							}).done(function(data){
								$('#divDinamico').html(data).ready(function(){
									$.ajax({
										url:'AtendVsat_sp/view',
										type:'POST',
										data:{param:idatendimento}
									}).done(function(data){
										$('#divDinamico').html(data);
									});
								});
							});
						});
					});
				});
			}
			else if( flexme == '#flexmeOS' )
			{

				$('tr').click(function(){
					var id = $(this).attr('id');
					id = id.substring(id.lastIndexOf('row')+3);
					
					$.ajax({
						url:'Log/registro_acesso/os_view',
						type:'POST',
						data:{ idos : id },
						success:function( response ){
							if( response == 'erro' ){
								//console.log('Erro ao registrar Log de acesso em os_view.');
							}else{
								//console.log('Log de acesso em os_view registrado.');
							}
						}
					});
					
					getAjaxForm(viewAjax,'conteudo',{param:id,ajax:1});
					setTimeout(function(){ initialize(); },1000);
				});
			}
            else if( flexme == '#flexmeOSsp' )
			{

				$('tr').click(function(){
					var id = $(this).attr('id');
					id = id.substring(id.lastIndexOf('row')+3);
                    //alert(id);

					$.ajax({
						url:'Log_sp/registro_acesso/os_view',
						type:'POST',
						data:{ idos : id },
						success:function( response ){
							if( response == 'erro' ){
								//console.log('Erro ao registrar Log de acesso em os_view.');
							}else{
								//console.log('Log de acesso em os_view registrado.');
							}
						}
					});

					getAjaxForm(viewAjax,'conteudo',{param:id,ajax:1});
					setTimeout(function(){ initialize(); },1000);
				});
			}
			else if( flexme == '#flexmePreIncidentes' )
			{
				
			}
			else if( flexme == '#flexmePreIncidentesNagios' )
			{
				
			}
			else if( flexme == '#flexmeIncidentes' )
			{
				
			}
			else if( flexme == '#flexmeIncidentessp' )
			{

			}
			else /* DEFAULT */
			{

				$('tr').click(function(){
					var id = $(this).attr('id');
					id = id.substring(id.lastIndexOf('row')+3);
					getAjaxForm(viewAjax,'conteudo',{param:id,ajax:1});
				});
			}
		});
}
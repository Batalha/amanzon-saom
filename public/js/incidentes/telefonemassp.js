/**
 * 
 */

var objetosTelefonemassp = new Array();

function limpaJsTelefonemassp()
{
	clearInterval( objetosTelefonemassp['intervalo'] );
}

function aplicaTelefonemassp(){
	$('#flexmeIncidentessp tr').each(function(){
		
		var id = $(this).attr('id');
		id = id.substring(id.lastIndexOf('row')+3);
		
		var telefonemaInfo = $(this).find('[abbr="telefonemas_info"] div').html();
		
		var associacao = $(this).find('[abbr="associacao"] div').html();
		
		var telefonema = new Telefonema( associacao , telefonemaInfo );
		
		telefonema.aplicaTelefones();
		
		objetosTelefonemassp.push( telefonema );
		
		telefonema = 0;
		
	});
	
	objetosTelefonemassp['intervalo'] = setInterval( function(){
		iniciaContagemCronometroTelefonemas(); 
	} , 1000);
}

// objeto telefonema
function Telefonema( linha , telefonemasInfo ){
	
	this.associacao = linha;
	this.info = telefonemasInfo;
	this.apresentacaoTelefones;
	
	this.teste = new Array();
	
	this.telefonema1 = new Array();
	this.telefonema2 = new Array();
	this.telefonema3 = new Array();
	
	this.aplicaTelefones = function(){
		
		this.apresentacaoTelefones = '<div style="clear:both;width:115px;cursor:normal;margin:0px 0px 0px 0px;">';
		
		// trabalha com as infos
		var infoSeparada = this.info.split(';');
		
		// escreve os telefones
		this.trataDatasTelefones(  infoSeparada );
		
		// calcula os cronometros
		this.trataCronometrosTelefones();
		
		this.desenhaTelefones();
		
		this.apresentacaoTelefones += '</div>';
		
		var associacaoTemp = this.associacao;
		var apresentacaoTemp = this.apresentacaoTelefones;
		
		$('#flexmeIncidentessp tr').each(function(){
			//console.log($(this).find('[abbr="associacao"] div').html()+' = '+associacaoTemp);
			if( $(this).find('[abbr="associacao"] div').html() == associacaoTemp ){
				$(this).find('[abbr="telefonemas"] div').html( apresentacaoTemp );
			}
		});
		
	}
	
	this.trataDatasTelefones = function( infoSeparada ){
		
		for( i=0 ; i < infoSeparada.length ; i++ ){
			
			switch( i ){
				case 0:  // telefonema1
					
					this.telefonema1['status'] = '';
					
					var temposTelefonema = infoSeparada[i].split('|');
					
					// sem telefonema registrado
					if( temposTelefonema[0] == 'telefonema1:' && temposTelefonema[1] == '' && temposTelefonema[2] == '' ){ this.telefonema1['status'] = false; break; }
					
					//data inicio
					var dataInicio = temposTelefonema[0].split(' ');
					var horaInicio = dataInicio[1].split(':');
					dataInicio[0] = dataInicio[0].substring(dataInicio[0].lastIndexOf('telefonema1:')+12);
					var diaInicio = dataInicio[0].split('-');
					this.telefonema1['dataInicio'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					
					//data fim
					if( temposTelefonema[1] == '' || temposTelefonema[1] == '0000-00-00 00:00:00' || temposTelefonema[1] == 'NULL' ){
						this.telefonema1['status'] = 'rodando';
					}else{
						var dataInicio = temposTelefonema[1].split(' ');
						var horaInicio = dataInicio[1].split(':');
						var diaInicio = dataInicio[0].split('-');
						this.telefonema1['dataFim'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					}
					
					//prazo
					var dataInicio = temposTelefonema[2].split(' ');
					var horaInicio = dataInicio[1].split(':');
					var diaInicio = dataInicio[0].split('-');
					this.telefonema1['prazo'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					
					if( this.telefonema1['status'] == '' ){ this.telefonema1['status'] = 'finalizado'; }
					
					break;
				case 1:  // telefonema2
					
					this.telefonema2['status'] = '';
					
					var temposTelefonema = infoSeparada[i].split('|');
					
					// sem telefonema registrado
					if( temposTelefonema[0] == 'telefonema2:' && temposTelefonema[1] == '' && temposTelefonema[2] == '' ){ this.telefonema2['status'] = false; break; }
					
					//data inicio
					var dataInicio = temposTelefonema[0].split(' ');
					var horaInicio = dataInicio[1].split(':');
					dataInicio[0] = dataInicio[0].substring(dataInicio[0].lastIndexOf('telefonema2:')+12);
					var diaInicio = dataInicio[0].split('-');
					this.telefonema2['dataIncio'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					
					//data fim
					if( temposTelefonema[1] == '' || temposTelefonema[1] == '0000-00-00 00:00:00' || temposTelefonema[1] == 'NULL' ){ 
						this.telefonema2['status'] = 'rodando';
					}else{
						var dataInicio = temposTelefonema[1].split(' ');
						var horaInicio = dataInicio[1].split(':');
						var diaInicio = dataInicio[0].split('-');
						this.telefonema2['dataFim'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					}
					
					//prazo
					var dataInicio = temposTelefonema[2].split(' ');
					var horaInicio = dataInicio[1].split(':');
					var diaInicio = dataInicio[0].split('-');
					this.telefonema2['prazo'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					
					if( this.telefonema2['status'] == '' ){ this.telefonema2['status'] = 'finalizado'; }
					
					break;
				case 2:  // telefonema3
					
					this.telefonema3['status'] = '';
					
					var temposTelefonema = infoSeparada[i].split('|');
					
					// sem telefonema registrado
					if( temposTelefonema[0] == 'telefonema3:' && temposTelefonema[1] == '' && temposTelefonema[2] == '' ){ this.telefonema3['status'] = false; break; }
					
					//data inicio
					var dataInicio = temposTelefonema[0].split(' ');
					var horaInicio = dataInicio[1].split(':');
					dataInicio[0] = dataInicio[0].substring(dataInicio[0].lastIndexOf('telefonema3:')+12);
					var diaInicio = dataInicio[0].split('-');
					this.telefonema3['dataIncio'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					
					//data fim
					if( temposTelefonema[1] == '' || temposTelefonema[1] == '0000-00-00 00:00:00' || temposTelefonema[1] == 'NULL' ){ 
						this.telefonema3['status'] = 'rodando';
					}else{
						var dataInicio = temposTelefonema[1].split(' ');
						var horaInicio = dataInicio[1].split(':');
						var diaInicio = dataInicio[0].split('-');
						this.telefonema3['dataFim'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					}
					
					//prazo
					var dataInicio = temposTelefonema[2].split(' ');
					var horaInicio = dataInicio[1].split(':');
					var diaInicio = dataInicio[0].split('-');
					this.telefonema3['prazo'] = new Date( diaInicio[0] , diaInicio[1]-1 , diaInicio[2] , horaInicio[0] , horaInicio[1] , horaInicio[2] );
					
					if( this.telefonema3['status'] == '' ){ this.telefonema3['status'] = 'finalizado'; }
					
					break;
			}
			
		}
		
	}
	
	this.trataCronometrosTelefones  = function(){
		
		this.telefonema1['cronometro'] = new Array();
		this.telefonema2['cronometro'] = new Array();
		this.telefonema3['cronometro'] = new Array();
		
		if( this.telefonema1['status'] == 'rodando' ){ //telefonema1
			
			this.telefonema1['cronometro']['status'] = 'on';
			this.telefonema2['cronometro']['status'] = 'off';
			this.telefonema3['cronometro']['status'] = 'off';
			
			this.telefonema1['cronometro']['contagem'] = new Date();
			this.telefonema2['cronometro']['contagem'] = new Date();
			this.telefonema3['cronometro']['contagem'] = new Date();
			
		}else if( this.telefonema2['status'] == 'rodando' ){//telefonema2
				
			this.telefonema1['cronometro']['status'] = 'off';
			this.telefonema2['cronometro']['status'] = 'on';
			this.telefonema3['cronometro']['status'] = 'off';
			
			this.telefonema2['cronometro']['contagem'] = new Date();
			this.telefonema3['cronometro']['contagem'] = new Date();
			
		}else if( this.telefonema3['status'] == 'rodando' ){//telefonema3
				
			this.telefonema1['cronometro']['status'] = 'off';
			this.telefonema2['cronometro']['status'] = 'off';
			this.telefonema3['cronometro']['status'] = 'on';
			
			this.telefonema3['cronometro']['contagem'] = new Date();
			
		}else{
			
			this.telefonema1['cronometro']['status'] = 'off';
			this.telefonema2['cronometro']['status'] = 'off';
			this.telefonema3['cronometro']['status'] = 'off';
			
			this.telefonema3['cronometro']['contagem'] = new Date();
			
		}
		
	}
	
	this.desenhaTelefones = function(){
		
		if( this.telefonema1['cronometro']['status'] == 'on' ){ //telefonema1
			
			this.apresentacaoTelefones += '<div id="telefonema1_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 0px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:liberaTelefonemaIncidente( '+this.associacao+' , 1 )">&nbsp;</div>';
			this.apresentacaoTelefones += '<div id="telefonema2_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 20px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
			this.apresentacaoTelefones += '<div id="telefonema3_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 20px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
			
		}else{
			
			if( this.telefonema2['cronometro']['status'] == 'on' ){//telefonema2
				
				this.apresentacaoTelefones += '<div id="telefonema1_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 40px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
				this.apresentacaoTelefones += '<div id="telefonema2_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 0px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:liberaTelefonemaIncidente( '+this.associacao+' , 2 )">&nbsp;</div>';
				this.apresentacaoTelefones += '<div id="telefonema3_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 20px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
				
			}else{
				
				if( this.telefonema3['status'] == 'on' ){//telefonema3
					
					this.apresentacaoTelefones += '<div id="telefonema1_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 40px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
					this.apresentacaoTelefones += '<div id="telefonema2_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 40px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
					this.apresentacaoTelefones += '<div id="telefonema3_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 0px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:liberaTelefonemaIncidente( '+this.associacao+' , 3 )">&nbsp;</div>';
					
				}else{
					
					this.apresentacaoTelefones += '<div id="telefonema1_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 40px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
					this.apresentacaoTelefones += '<div id="telefonema2_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 40px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
					this.apresentacaoTelefones += '<div id="telefonema3_'+this.associacao+'" style="background:url(public/imagens/telefone.gif) 0px 40px;width:20px;height:20px;margin:0px 5px 0px 0px;cursor:pointer;float:left" onclick="javascript:">&nbsp;</div>';
					
				}
				
			}
			
		}
		
	}
	
}

function iniciaContagemCronometroTelefonemas(){
	
	$.each( objetosTelefonemassp , function( index , value ){
		
		if( index != 'intervalo' )
		{
			if( value.telefonema1.cronometro.status == 'on' ){
				
				if( value.telefonema1.cronometro.contagem != undefined ){
					//continua contagem
					//console.log(value.telefonema1.cronometro.contagem+' <-> '+value.telefonema1.prazo);
					if( value.telefonema1.cronometro.contagem.getTime() < value.telefonema1.prazo.getTime() ){
						
						objetosTelefonemassp[index].telefonema1.cronometro.contagem = new Date();
						
					}else{ //muda telefonema
						
						liberaTelefonemaIncidente( value.associacao , 1 );
						
					}
				}else{
					limpaJsTelefonemassp();
				}
				
			}else if( value.telefonema2.cronometro.status == 'on' ){
				
				//continua contagem
				if( value.telefonema2.cronometro.contagem != undefined ){	
					if( value.telefonema2.cronometro.contagem.getTime() < value.telefonema2.prazo.getTime() ){
						
						objetosTelefonemassp[index].telefonema2.cronometro.contagem = new Date();
						
					}else{ //muda telefonema
						
						liberaTelefonemaIncidente( value.associacao , 2 );
						
					}
				}else{
					limpaJsTelefonemassp();
				}
				
			}else if( value.telefonema3.cronometro.status == 'on' ){
				
				if( value.telefonema3.cronometro.contagem != undefined ){
					//continua contagem
					//console.log(value.telefonema3.cronometro.contagem+' <-> '+value.telefonema3.prazo);
					if( value.telefonema3.cronometro.contagem.getTime() < value.telefonema3.prazo.getTime() ){
						
						objetosTelefonemassp[index].telefonema3.cronometro.contagem = new Date();
						
					}else{ //muda telefonema
						
						liberaTelefonemaIncidente( value.associacao , 3 );
						
					}
				}else{
					limpaJsTelefonemassp();
				}
				
			}
		}
		
		//TODO: clearInterval no intervalo para liberar memoria
	});
	
}

function liberaTelefonemaIncidente( associacao , telefonema ){
		
	//console.log(incidente+' - '+telefonema);
	
	$.ajax({
		url: 'TelefonemasParaIncidentes_sp/liberaTelefonemaIncidente',
		type:'POST',
		data:{associacao:associacao,telefonema:telefonema},
		success:function(resposta){
			//return resposta;
			
			$.each( objetosTelefonemassp , function( index , value ){
			
				if( index != 'intervalo' ){
					
					if( value.associacao == associacao ){
						
						if( telefonema == 1 ){
							
							objetosTelefonemassp[index].telefonema1.cronometro.status = 'off';
							$('#telefonema1_'+value.associacao).css('background','url(public/imagens/telefone.gif) 0px 40px');
							objetosTelefonemassp[index].telefonema2.cronometro.status = 'on';
							$('#telefonema2_'+value.associacao).css('background','url(public/imagens/telefone.gif) 0px 0px');
							$('#telefonema2_'+value.associacao).attr('onclick','javascript:liberaTelefonemaIncidente( '+value.associacao+' , 2 )');
							
						}else if( telefonema == 2 ){
							
							objetosTelefonemassp[index].telefonema2.cronometro.status = 'off';
							$('#telefonema2_'+value.associacao).css('background','url(public/imagens/telefone.gif) 0px 40px');
							objetosTelefonemassp[index].telefonema3.cronometro.status = 'on';
							$('#telefonema3_'+value.associacao).css('background','url(public/imagens/telefone.gif) 0px 0px');
							$('#telefonema3_'+value.associacao).attr('onclick','javascript:liberaTelefonemaIncidente( '+value.associacao+' , 3 )');
							
						}else if( telefonema == 3 ){
							
							objetosTelefonemassp[index].telefonema3.cronometro.status = 'off';
							$('#telefonema3_'+associacao).css('background','url(public/imagens/telefone.gif) 0px 40px');
							
						}
						
					}
				}
				
			});
			
		}
	});
	
}
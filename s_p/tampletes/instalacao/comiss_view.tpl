
<style>
	.tabela_tecnico{
		width:300px;
		padding:5px;
		margin-top:20px;
	}
	.tabela_responsavel{
		width:650px;
		padding:5px;
		margin-top:20px;
	}
	.tabelas_dados{
		padding:5px;
		margin-top:20px;
	}
	.tec_label{
		text-align:left;
		padding-right:10px;
		padding-left:10px;
	}
	.tec_input{
		text-align:left;
	}
	
	.padding10{
		padding:0px 10px 10px 10px;
	}
	.floatleft{
		float:left;
		margin-right:15px;
	}
	.largura500{
		width:548px;
	}
	table.largura500 tr td{
		padding-left:10px;
		padding-right:10px;
	}
	.label_dados_instalacao{
		width:245px;
	}
	.label_campo_instalacao{
		width:303px;
	}
	
	.label_dados_equipamentos{
		width:150px;
		text-align:left;
		padding:10px;
	}
	
	.campo_dados_equipamentos{
		width:230px;
	}
	
	.label_dados_equipamentos2{
		width:100px;
		text-align:left;
		padding:10px;
	}
	
	.campo_dados_equipamentos2{
		width:200px;
	}
	
	.input_check_test{
		width:470px;
		text-align:left;
		padding-left:10px;
		padding-right:5px;
	}
	.texto_check_test{
		width:20px;
		text-align:left;
		padding-right:20px;
	}
</style>

<center>
<div id="idcontener">

	{if $obj.data_pausa}
		<div ><h3 style="color: red">Este Comissionamento esta Paralisado</h3> </div>
	{/if}
<form action="s_p/controller/Comissionamento_sp/edit_comiss" method="POST" id="FCOMISS" class="form" >
	<input type="hidden" name="idinstalacoes_sp" id="idinstalacoes_sp" value="{$obj.idinstalacoes_sp}"/>
	<fieldset>
	    <div class="comisContener">
	    	<div class="dadoCriaComis" style="	height: 0 auto;">
	    		<table class="dadoCria" border="0">
	    			<tr height="25" style="color: #646473;">
	    				<td style="font-weight: bold;" width="17%">Tecnico de Campo :</td><td>{$obj.teccampo}</td></tr>
	    			<tr height="25" style="color: #646473;">
	    				<td style="font-weight: bold;">Telefone :</td><td>{$obj.teccampo_tel}</td></tr>
	    			<tr height="25" style="color: #646473;">
	    				<td style="font-weight: bold;">Iniciado por :</td><td>{$obj.comissionado_por} - {$obj.create_user_comiss_time}</td>
					</tr>
					<tr height="25" style="color: #646473;">
						<td style="font-weight: bold;">Responsavel :</td><td>{$obj.responsavel_comiss} - {$obj.resp_comiss_time}</td>
					</tr>
	    			<tr height="25" style="color: #646473;">
	    				<td style="font-weight: bold;">Modificado por :</td><td>{$obj.editado_por} - {$obj.last_user_comiss_time}</td>
					</tr>
					{if $obj.last_user_snr}
						<tr height="25" style="color: #646473;">
							<td style="font-weight: bold;"></td><td>O Campo Valor da SNR na Vsat foi Modificado na data - {$obj.last_user_snr}</td>
						</tr>
					{/if}
					{if $obj.last_user_cross_pol}
						<tr height="25" style="color: #646473;">
							<td style="font-weight: bold;"></td><td>O Campo Valor do cross-pol Satelite foi Modificado na data - {$obj.last_user_cross_pol}</td>
						</tr>
					{/if}
					{if $obj.last_user_tx}
						<tr height="25" style="color: #646473;">
							<td style="font-weight: bold;"></td><td>O Campo Verificado os níveis de TX foi Modificado na data - {$obj.last_user_tx}</td>
						</tr>
					{/if}
	    		</table>
	    	</div>
	    	
	    	<div class="comisTopoDadosInstal">
	    	<h4>Dados Instalação</h4>
	    	</div>
	    	<div class="comisTopoDadosInstal">
	    	<h4>Dados Equipamentos</h4>
	    	</div>
	    	
	    	<div class="comisDados">
	    		<table class="comisTable">
	    			<tr>
	    				<td style="background-color: #FDFFFE"><b>Registro Concessionária:</b></td>
	    				<td style="background-color: #FDFFFE">{$obj.registro_concessionaria}</td>
	    			</tr>
	    			<tr>
	    				<td style="background-color: #EFEFEF"><b>Operador(a) da Satelite:</td>
	    				<td style="background-color: #EFEFEF">{$obj.ope_eutelsat}</td>
	    			</tr>
	    			<tr>
	    				<td style="background-color: #FDFFFE"><b>Satelite / Beam:</td>
	    				<td style="background-color: #FDFFFE">{$obj.satelite} / {$obj.bean}</td>
	    			</tr>
                    <tr>
	    				<td style="background-color: #EFEFEF"><b>Valor do cross-pol Satelite:</td>
	    				<td style="background-color: #EFEFEF">{$obj.val_crosspol}</td>
	    			</tr>
	    			<tr>
	    				<td style="background-color: #FDFFFE"><b>Latitude:</td>
	    				<td style="background-color: #FDFFFE">
			            	{$obj.latitude_graus}°&nbsp;
			            	{$obj.latitude_minutos}'&nbsp;
			            	{$obj.latitude_segundos}"&nbsp;
			            	{if $obj.latitude_direcao=='S'}S{elseif $obj.latitude_direcao=='N'}N{/if}	    				
	    				
	    				</td>
	    			</tr>
	    			<tr>
	    				<td style="background-color: #EFEFEF"><b>Longitude:</td>
	    				<td style="background-color: #EFEFEF">
		                	{$obj.longitude_graus}°&nbsp;
			            	{$obj.longitude_minutos}'&nbsp;
			            	{$obj.longitude_segundos}"&nbsp;
			            	{if $obj.longitude_direcao=='W'}W{elseif $obj.longitude_direcao=='E'}E{/if}	    				
	    				</td>
	    			</tr>
	    			<tr>
	    				<td style="background-color: #FDFFFE"><b>Azimute:</td>
	    				<td style="background-color: #FDFFFE">{$obj.azimute_comiss}</td>
	    			</tr>	    		
	    			<tr>
	    				<td style="background-color: #EFEFEF"><b>Elevacao:</td>
	    				<td style="background-color: #EFEFEF">{$obj.elevacao_comiss}</td>
	    			</tr>	    		
	    		</table>
	    	
	    	</div>
	    	<div class="comisDados">
	    		<table class="comisTable">
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Valor de SNR na VSAT:</b></td>
	    				<td style="background-color: #EFEFEF">{$obj.snr_comiss}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>NS da Vsat :</b></td>
	    				<td style="background-color: #FDFFFE">{$obj.nsmodem_comiss}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>MAC :</b></td>
	    				<td style="background-color: #EFEFEF">{$obj.mac_comiss}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Numero de Serie ODU/BUC :</b></td>
	    				<td style="background-color: #FDFFFE">{$obj.nsodu_comiss}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>ODU/BUC :</b>&nbsp;</td>
	    				<td style="background-color: #EFEFEF">
	    				    {foreach from=$tipoEquipamentos item=tipoEquipamento}
                    			{if $obj.odu == $tipoEquipamento.idtipo_equipamentos_sp}
									{$tipoEquipamento.nome}
								{/if}
                    		{/foreach}
	    				</td>
	    			</tr>	    		
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Antena marca / Número de Serie :</b></td>
	    				<td style="background-color: #FDFFFE">
		                    {if $obj.antena_comiss eq 'patriot'}Patriot{elseif $obj.antena_comiss eq 'skyware'}Skyware{elseif $obj.antena_comiss eq 'Brasil Sat'}Brasil Sat{/if} 
		                    &nbsp;&nbsp;&nbsp;{$obj.antena_ns_comiss}
	    				</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b></b>&nbsp;</td>
	    				<td style="background-color: #EFEFEF">&nbsp;</td>
	    			</tr>
                    <tr >
	    				<td style="background-color: #FDFFFE"><b></b>&nbsp;</td>
	    				<td style="background-color: #FDFFFE">&nbsp;</td>
	    			</tr>
	    		
	    		</table>
	    	</div>
	    	<div class="comisTopoTeste">
	    	<h4>Inicio de Testes</h4>
	    	</div>
	    	
			<!-- ----------------------------------------------------------------------------
			----------------------- DADOS TESTES --------------------------------------------
			----------------------------------------------------------------------------- -->
	        
	        <!-- Solução temporária, depois retirar-->
            <input type="hidden" name="packetshapper" id="packetshapper" value="1" />
            <input type="hidden" name="reglicenca" id="reglicenca" value="1" />
            <input type="hidden" name="opmanager" id="opmanager" value="1" />
            <input type="hidden" name="webnms" id="webnms" value="1" />
 			<!-- Solução temporária, depois retirar -->
 			<input type="hidden" name="test_e_termo_aceite" id="test_e_termo_aceite" {if $obj.test_e_termo_aceite == 1 || $obj.termo_aceite != ''}checked{/if} />	  
 			  	
	    	<div class="comisTeste">
	    		<table class="comisTable">
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Testou Sat Link 2000? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.test_sl2000 eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Auto comissionamento foi realizado? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.autocomiss eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Verificada a versão do software utilizado? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.test_software eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Verificado o tamanho e o tipo da antena? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.test_antena eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Verificado o tipo do buc? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.test_buc eq 1} Sim {else} Não {/if}</td>
	    			</tr>	    		
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Verificado os níveis de TX? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.test_tx eq 1} Sim {else} Não {/if}</td>
	    			</tr>
		            {if $obj.test_tx == 1}
		            <tr>
		            	<td colspan="2" style="padding: 0px;">
			            	<table style="width: 100%">
			            		<tr>
			            			<td style="background-color: #FDFFFE" align="right" width="10%">
			            			<img alt="" src="public/imagens/seta.PNG" width="25" height="25">	</td>
					                <td style="background-color: #FDFFFE" width="18%">
					                	EB/N0:
						            </td>
					                <td style="background-color: #FDFFFE">
					                		{$obj.ebno_comiss}
					                </td>
					            </tr>
					            <tr>
				            		<td style="background-color: #FDFFFE" align="right">
				            		<img alt="" src="public/imagens/seta.PNG" width="25" height="25">	</td>
					                <td style="background-color: #FDFFFE">
					                		EIRP Configurado:
					                </td>
					                <td style="background-color: #FDFFFE">
					                		{$obj.eirp_comiss}
					                </td>
		
			            		</tr>
			            	</table>
		            	
		            	</td>
		            </tr>
		            {/if}  
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Teste de calibrate? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.test_calibrate eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Registro do comprimento/distância do cabo entre buc e modem? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.test_cabo eq 1} Sim {else} Não {/if}</td>
	    			</tr>
		            {if $obj.test_tx == 1}
		            <tr>
		            	<td colspan="2" style="padding: 0px;">
			            	<table style="width: 100%">
			            		<tr>
			            			<td style="background-color: #FDFFFE" align="right" width="10%">
			            			<img alt="" src="public/imagens/seta.PNG" width="25" height="25">	</td>
					                <td style="background-color: #FDFFFE" width="10%">
					                	Valor:
						            </td>
					                <td style="background-color: #FDFFFE">
					                		{$obj.comp_cabo_comiss}
					                </td>
					            </tr>
			            	</table>
		            	
		            	</td>
		            </tr>
		            {/if}  
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Registro de condições climáticas? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.test_clima eq 1} Sim {else} Não {/if}</td>
	    			</tr>
		            {if $obj.test_tx == 1}
                        <tr>
                            <td colspan="2" style="padding: 0px;">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="background-color: #FDFFFE" align="right" width="10%">
                                        <img alt="" src="public/imagens/seta.PNG" width="25" height="25">	</td>
                                        <td style="background-color: #FDFFFE">
                                                {$obj.desc_clima_comiss}
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
		            {/if}  
	    			{*<tr >*}
	    				{*<td style="background-color: #FDFFFE"><b>Retirou a imagem do PRTG/NAGIOS? :</b></td>*}
	    				{*<td style="background-color: #FDFFFE">{if $obj.test_prtg eq 1} Sim {else} Não {/if}</td>*}
	    			{*</tr>*}
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Coletar informações de RX e TX? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.test_info_rx_tx eq 1} Sim {else} Não {/if}</td>
	    			</tr>	
 		
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Finalizou o Termo de Aceite? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.test_f_termo_aceite eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			{*<tr >*}
	    				{*<td style="background-color: #EFEFEF"><b>Enviou a notificação de início de teste a Prodemge? :</b></td>*}
	    				{*<td style="background-color: #EFEFEF">{if $obj.test_notificacao_inicio eq 1} Sim {else} Não {/if}</td>*}
	    			{*</tr>*}
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Conectou o cabo RJ45? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.cabo_rj45 eq 1} Sim {else} Não {/if}</td>
	    			</tr>
		            <tr>
		            	<td colspan="2" style="padding: 0px;">
			            	<table style="width: 100%">
			            		<tr>
			            			<td style="background-color: #FDFFFE" align="right" width="10%">
			            			<img alt="" src="..public/imagens/seta.PNG" width="25" height="25">	</td>
					                <td style="background-color: #FDFFFE" width="10%">
					                	{if $obj.cabo_rj45 eq 1}
						           			Onde?
						           		{else}
						           			Porquê?
						           		{/if}
						            </td>
					                <td style="background-color: #FDFFFE">
					                	{if $obj.cabo_rj45 eq 1}
						           			{$obj.cabo_rj45_justificativa_sim}
						           			
						           		{else}
						           			{$obj.cabo_rj45_justificativa_nao}
						           		
						           		{/if}
					                </td>
					            </tr>
			            	</table>
		            	
		            	</td>
		            </tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Conectores estão crimpados? :</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.conectores_crimpados eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Conectores da ODU estão isolados? :</b></td>
	    				<td style="background-color: #FDFFFE">{if $obj.conectores_odu_isolados eq 1} Sim {else} Não {/if}</td>
	    			</tr>
	    			<tr >
	    				<td style="background-color: #EFEFEF"><b>Antena está travada?</b></td>
	    				<td style="background-color: #EFEFEF">{if $obj.antena_travada eq 1} Sim {else} Não {/if}</td>
	    			</tr>	    		
	    			<tr >
	    				<td style="background-color: #FDFFFE"><b>Confirmação do endereço da instalação:</b>&nbsp;</td>
	    				<td style="background-color: #FDFFFE">{if $obj.confirmacao_endereco_instalacao}Sim {else} Nao {/if}</td>
	    			</tr>
	    			{if $obj.confirmacao_endereco_instalacao}
	    		    <tr>
		            	<td colspan="2" style="padding: 0px;">
			            	<table style="width: 100%">
			            		<tr>
			            			<td style="background-color: #FDFFFE" align="right" width="10%">
			            			<img alt="" src="public/imagens/seta.PNG" width="25" height="25">	</td>
					                <td style="background-color: #FDFFFE">
					                		{$obj.confirmacao_endereco_instalacao}
					                </td>
					            </tr>
			            	</table>
		            	
		            	</td>
		            </tr>
		            {/if}
	    		
	    		</table>
	    	</div>
			<div class="comisTopoTeste" align="left">
				<h5>Observações da instalação:</h5>
			</div>
			<div class="dadoComisObs" style="height: 0 auto;">
				<table class="agTable">
					<tr>
						<td>&nbsp;&nbsp;{$obj.obs_instalacao}</td>
					</tr>
				</table>
			</div>
	    </div>
	</fieldset>
</form>
		
        <!-- ---------------------------------------------------------------------------------
        --------------- TRECHOS DE UPLOAD ----------------------------------------------------
        ---------------------------------------------------------------------------------- -->
        
		<div id="termo_aceite_area">		
			<table class="tbForm" >
			
				<tr>
		        	<td>
		            	<label for="nms">Termo Aceite:</label>
		            </td>
		            <td>
		            	{if $obj.termo_aceite}<a href="{$obj.termo_aceite}" target="_blank">Termo Aceite</a>{/if}
		            </td>
		        </tr>
		        
			</table>
		</div>
        
		
    <br />
    
    <center>

		{if !$obj.data_pausa}
			<input
				type="button"
				class="btn"
				value="Editar dados do Comissionamento"
				onclick="javascript:
						getAjaxForm(
							'Comissionamento_sp/edit_comiss',
							'dadosInstal',
							{ldelim}param:{$obj.idinstalacoes_sp},ajax:1{rdelim})"
			/>
			&nbsp;&nbsp;&nbsp;&nbsp;
			{if $obj.data_final_comiss == '0000-00-00 00:00:00' || $obj.data_final_comiss == ''}
				<input
					type="button"
					value="Reenviar email de aviso de Ativação"
					class="btn btn-warning"
					onclick="javascript:
						if( confirm('Deseja reenviar email de Ativação?') ){ldelim}

							$.ajax({ldelim}
								url:'Instalacao_sp/reenviarEmailInicioAtivacao',
								type:'POST',
								data:{ldelim}instalacao:{$obj.idinstalacoes_sp}{rdelim},
								success:function( resposta ){ldelim}
									if( resposta == 'ok' ){
										var respostaReenvio = '<div class=\'alert alert-success\'>Email reenviado com sucesso.</div>';
									}else{
										var respostaReenvio = '<div class=\'alert alert-error\'>Erro no reenvio do email.</div>';
									}
									$('#resposta_reenvio_email').html(respostaReenvio);
									setTimeout('$(\'#resposta_reenvio_email\').fadeOut()',5000);
								{rdelim}
							{rdelim});

						{rdelim}"
				/>
			{/if}
			&nbsp;&nbsp;&nbsp;&nbsp;
			{*<input	type="button" class="btn" value="Paralisasar Comissionamento"*}
					{*onclick="javascript:*}
							{*getAjaxForm('Comissionamento_sp/caixaPausaComiss','caixaPausaComiss')*}
							{*"/>*}
			<input
					type="button"
					class="btn btn-primary"
					value="Paralisar Comissionamento"
					onClick="javascript:
							sendPost('Comissionamento_sp/pausar','FCOMISS')"
					/>
		{else}
			{*<input	type="button" class="btn" value="Desparalizar Comissionamento"*}
					  {*onclick="javascript:*}
							{*getAjaxForm('Comissionamento_sp/caixaDespausaComiss','caixaDespausaComiss')"	/>*}
			<input
					type="button"
					class="btn btn-primary"
					value="Desparalisar Comissionamento"
					onClick="javascript:
							sendPost('Comissionamento_sp/despausar','FCOMISS')"
			/>
		{/if}
		{*<div id="caixaPausaComiss"></div>*}

		{if $obj.data_pausa}
			Data da Paralisação: {$obj.data_pausa}
		{/if}
    </center>
	<input name="campoDataPausa" id="campoDataPausa" type="hidden" value="" />
    
    <div id="resposta_reenvio_email" style="margin:10px 0 10px 0;"></div>



</div>
</center>
     

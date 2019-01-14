
<div id="tab">
	<ul>
	
		<li id="principal" class="item_menu_principal">
			<a onClick="javascript:chama_item_menu_principal( 'principal' , '' , '#home' )"><span>Principal</span></a></li>
		
		<li id="menu_instalacoes" class="item_menu_principal">
		
			<div 
				onmouseover="javascript:
					$('.drop_menu_instalacoes').css('display','block');"
				onmouseout="javascript:
					$('.drop_menu_instalacoes').css('display','none');">
					
				<a href="#instalacao" onClick="javascript:chama_item_menu_principal( 'os' , 'lista' , '#instalacao' )"><span>Instalações</span></a>
				
				<div class="drop_menu drop_menu_instalacoes">
					
					<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os' , 'create' , '#novaos' )">
				    	Cadastrar OS
				    </div>
				    
				    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os' , 'lista' , '#listaos' )">
				    	Ver lista de OS{if $login.empresas_idempresas == 1 && $login.perfis_idperfis==3}'s Vodanet{/if}
				    </div>
				    
				    {if $login.perfis_idperfis != 8 && $login.perfis_idperfis !=9 && $login.perfis_idperfis !=10}
				    
					    {if $login.empresas_idempresas == 1 && $login.perfis_idperfis==3}
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os' , 'lista_tudo' , '#listaatendimentos' )">
						    	Ver lista de todas OS's
						    </div>
						{/if}
					    
					    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'agenda_instal' , 'lista' , '#listaagendamentos' )">
					    	Agendamentos
					    </div>
					    
					    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'instalacoes' , 'lista' , '#listainstalacao' )">
					    	Instalações
					    </div>
					    
					    {if $login.perfis_idperfis == 4 || ( $login.perfis_idperfis == 5 && $login.subperfil_idsubperfil == 2 ) }
					    	<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os' , 'eutelsat_code' , '#listeutelsatcode' )">
						    	Eutelsat Code
						    </div>
					    {/if}
					    
					    {if ($login.perfis_idperfis != 3) && ($login.perfis_idperfis != 7)}
					    	
					    	<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os' , 'monitor' , '#monitor' )">
						    	Monitor
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:window.open('OS/relatorio')">
						    	Relatório
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:window.open('OS/relatorioAcompanhamento')">
						    	Relatório Acompanhamento
						    </div>
					    	
					    {/if}
					    {if $login.perfis_idperfis != 7}
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'os' , 'relatorio_anatel' , '#relatorio_anatel' )">
						    	Relatório Anatel
						    </div>
						{/if}
					    
					{/if}
				    
				</div>
				
			</div>
			
		</li>
		
		{if $login.perfis_idperfis == 3}
			{if  $login.empresas_idempresas == 1}
				
				<li id="menu_incidentes" class="item_menu_principal">
	    		
		    		<div 
						onmouseover="javascript:
							$('.drop_menu_incidentes').css('display','block');"
						onmouseout="javascript:
							$('.drop_menu_incidentes').css('display','none');">
							
						<a href="#listaincidentes" onClick="javascript:chama_item_menu_principal( 'incidentes' , 'lista' , '#listaincidentes' )"><span>Incidentes</span></a>
						
						<div class="drop_menu drop_menu_incidentes">
							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'incidentes' , 'lista' , '#listaincidentes' )">
								Lista <!-- de Buc's e Modem's -->
							</div>
							
							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'incidentes' , 'create' , '#novoincidente' )">
						    	Criar Incidente
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'atend_vsat' , 'lista' , '#listaatendimentos' )">
						    	Atendimentos
						    </div>
						    
						    <!--<div class="item_drop_menu" onClick="javascript:window.open('Incidente/relatorio');">-->
						    	<!--Relatório-->
						    <!--</div>-->

							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'relatorio_inc_bh' , 'create' , '#relatorio_incidente' )">
								Relatorio_periodo
							</div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'pre_incidentes' , 'lista' , '#listapreincidentes' );">
						    	Pré Incidentes Prodemge
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'pre_incidentes_nagios' , 'lista' , '#listapreincidentesnagios' );">
						    	Pré Incidentes Nagios
						    </div>
						</div>
						
					</div>
		    		
		    	</li>
				
			{/if}
		{else}
		
			{if $login.perfis_idperfis != 8 && $login.perfis_idperfis !=9 && $login.perfis_idperfis !=10}
		    	<li id="menu_incidentes" class="item_menu_principal">
		    		
		    		<div 
						onmouseover="javascript:
							$('.drop_menu_incidentes').css('display','block');"
						onmouseout="javascript:
							$('.drop_menu_incidentes').css('display','none');">
							
						<a href="#listaincidentes" onClick="javascript:chama_item_menu_principal( 'incidentes' , 'lista' , '#listaincidentes' )">
							<span>Incidentes</span>
						</a>
						
						<div class="drop_menu drop_menu_incidentes">
							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'incidentes' , 'lista' , '#listaincidentes' )">
								Lista
							</div>
							
							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'incidentes' , 'create' , '#novoincidente' )">
						    	Criar Incidente
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'atend_vsat' , 'lista' , '#listaatendimentos' )">
						    	Atendimentos
						    </div>
						    
						    <!--<div class="item_drop_menu" onClick="javascript:window.open('Incidente/relatorio');">-->
						    	<!--Relatório-->
						    <!--</div>-->

							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'relatorio_inc_bh' , 'create' , '#relatorio_incidente' )">
								Relatorio_periodo
							</div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'pre_incidentes' , 'lista' , '#listapreincidentes' );">
						    	Pré Incidentes
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'pre_incidentes_nagios' , 'lista' , '#listapreincidentesnagios' );">
						    	Pré Incidentes Nagios
						    </div>
						</div>
						
					</div>
		    		
		    	</li>
		    {/if}
	    	
	    {/if}
		
		{if  $login.empresas_idempresas != 2 && $login.perfis_idperfis != 8 && $login.perfis_idperfis !=9 && $login.perfis_idperfis !=10 && $login.perfis_idperfis != 7}
			<li id="menu_acomp" class="item_menu_principal">
				
				<div 
					onmouseover="javascript:
						$('.drop_menu_acomp').css('display','block');"
					onmouseout="javascript:
						$('.drop_menu_acomp').css('display','none');">
						
					<a href="#acompanhamento" onClick="javascript:chama_item_menu_principal( 'acomp' , 'lista' , '#acompanhamento' )"><span>Acomp.</span></a>
					
				</div>
				
			</li>
		{/if}

		
		<!-- 
		{if $login.perfis_idperfis == 1 || 
			$login.perfis_idperfis == 5 ||
			$login.perfis_idperfis == 2 ||
			$login.perfis_idperfis == 4}
		    <li><a href="#mudaplano" onClick="getAjaxForm('MudaPlano/liste')"><span>Mudança de Perfil</span></a></li>
		{/if}
		-->
		
		{if $login.perfis_idperfis == 1 || 
			$login.perfis_idperfis == 5 ||
			$login.perfis_idperfis == 2 ||
			$login.perfis_idperfis == 4}
		    <!-- <li><a href="#realocacao" onclick=""><span>Realocação</span></a></li> -->
		{/if}
		
		<!-- 
		{if $login.perfis_idperfis == 1 || 
			$login.perfis_idperfis == 5 ||
			$login.perfis_idperfis == 2 ||
			$login.perfis_idperfis == 4}
		    <li><a href="#cancelamento" onClick="getAjaxForm('Cancelamento/liste')"><span>Cancel</span></a></li>
		{/if}
		-->
		
		{if $login.idusuarios = 23}
			{if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 2 || $login.perfis_idperfis == 4}
				<li id="menu_equip" class="item_menu_principal">
					<div 
						onmouseover="javascript:
							$('.drop_menu_equip').css('display','block');"
						onmouseout="javascript:
							$('.drop_menu_equip').css('display','none');">
							
						<a href="#equipamentos" onClick="javascript:chama_item_menu_principal( 'equip' , 'lista' , '#listaequipamentos' )"><span>Equip.</span></a>
						
						<div class="drop_menu drop_menu_equip">
							<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'equip' , 'lista' , '#listaequipamentos' )">
								Lista <!-- de Buc's e Modem's -->
							</div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'locais_equip' , 'lista' , '#listaequipamentos' )">
						    	Lista Locais Extras de Equipamentos
						    </div>
						    
						    <div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'equip' , 'create' , '#novoequipamento' );">
						    	Adicionar 1 Equipamento
						    </div>
						</div>
						
					</div>
				</li>
			{/if}
		{/if}
		
		{if $login.perfis_idperfis == 4}
		    <li><a href="#relatorio" onClick="getAjaxForm('Relatorio/index')"><span>Relatórios</span></a></li>
		{/if}
		
		{if $login.perfis_idperfis == 4}
			<li id="administrar" class="item_menu_principal">
	    		
	    		<div 
					onmouseover="javascript:
						$('.drop_menu_administrar').css('display','block');"
					onmouseout="javascript:
						$('.drop_menu_administrar').css('display','none');">
						
					<a href="#administrar" onClick="javascript:chama_item_menu_principal( 'administrar' , 'lista' , '#administrar' )"><span>Administrar</span></a>
					
					<div class="drop_menu drop_menu_administrar">
						<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'administrar' , 'lista' , '#administrar' )">
							Ver lista de Usuários
						</div>
						
						<div class="item_drop_menu" onClick="javascript:chama_item_menu_principal( 'administrar' , 'create' , '#novousuario' )">
					    	Cadastrar Usuário
					    </div>
					</div>
					
				</div>
	    		
	    	</li>
		{/if}
		
		{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5}
			{if $login.perfis_idperfis == 5}
				{if $login.subperfil_idsubperfil == 2}
					<li><a href="#compartilhamento" onClick="getAjaxForm('Compartilhamento/liste')"><span>Compartilhar Arquivos</span></a></li>
				{/if}
			{else}
				<li><a href="#compartilhamento" onClick="getAjaxForm('Compartilhamento/liste')"><span>Compartilhar Arquivos</span></a></li>
			{/if}
		{else}
			{if $login.arquivo_supervisor == 1 && $login.perfis_idperfis != 8 && $login.perfis_idperfis !=9 && $login.perfis_idperfis !=10}
				<li><a href="#acompanhamento" onClick="getAjaxForm('Compartilhamento/liste')"><span>Arquivos Acompanhamentos</span></a></li>
			{/if}
		{/if}
		
		{if $login.perfis_idperfis == 1 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 4}
		    <li><a href="#municipios" onClick="getAjaxForm('Municipio/liste')"><span>Municípios</span></a></li>
		{/if}
		
		<li id="troca_senha" class="item_menu_principal"><a onClick="chama_item_menu_principal( 'troca_senha' , '' , '#trocasenha' )"><span>Trocar senha</span></a></li>
		
		<li><a href="Usuario/logout"><span>Sair</span></a></li>
	
	</ul>
</div>

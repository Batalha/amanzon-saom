
		<div id="navegRapid" class="painel well" >
	    	<ul>
	        	<li><h4>Acesso Rápido</h4></li>
	        	<li>&nbsp;</li>
	        	<li>
	        		<i class="icon-list-alt"></i>
	        		<a onClick="abrePainelOS()"> Ordem de Serviços</a>
	        	</li>
	        	<li>
	        		<i class="icon-flag"></i>
	        		<a onClick="abrePainelInstal()"> Instalações</a>
	        	</li>
	        	
	        	{if $login.empresas_idempresas == 1}
	        		<li>
	        			<i class="icon-th-list"></i>
		                <a onClick="abrePainelIncid()">Incidentes</a>
	        		</li>
	        		
	        		<li>
	        			<i class="icon-time"></i>
		                <a onClick="abrePainelAgendamentos()">Agendamentos</a>
	        		</li>
	        	{/if}
			</ul>
	    </div>
	    
	    <div id='painelAgend' class="painel" style='visibility: hidden' >
	       
	       <table >
	           <tr>
	               <th colspan='4'>Ordens de Serviços</th> 
	           </tr>
	           <tr>
	               <td colspan="2">Agendamentos</td><td colspan="2">Status das OS</td>   
	           </tr>
	          <tr class="trCor">
	               <td><a href="#" onClick="getAjaxForm('OSSP/liste','conteudo',{ldelim}where:'NOT EXISTS ( SELECT * FROM agenda_instal_sp WHERE agenda_instal.os_sp_idos = idos )',ajax:1{rdelim})" >Pendentes</a></td>
	               <td><div id="resultPen">indefinido</div></td>
	               <td><a href="#"  onClick="getAjaxForm('OSSP/liste','conteudo',{ldelim}where:'NOT EXISTS ( SELECT * FROM instalacoes_sp WHERE instalacoes.os_sp_idos = idos AND instalacoes_sp.comiss) AND prazoInstal < CURDATE( )',ajax:1{rdelim})">Comissionadas</a></td>
	               <td><div id="resultStatusAberto"></div>
	           </tr>
	           <tr class="trsCor">
	               <td><a href="#" onClick="getAjaxForm('OSSP/liste','conteudo',{ldelim}where:'EXISTS ( SELECT * FROM agenda_instal_sp WHERE agenda_instal.os_sp_idos = idos AND NOT agenda_instal_sp.confirm)',ajax:1{rdelim})">Pendente Confirmação</a></td>
	               <td><div id="resultAgen">indefinido</DIV></td>
	               <td><a href="#"  onClick="getAjaxForm('OSSP/liste','conteudo',{ldelim}where:'NOT EXISTS ( SELECT * FROM instalacoes_sp WHERE instalacoes.os_sp_idos = idos AND instalacoes_sp.comiss) AND prazoInstal < CURDATE( )',ajax:1{rdelim})">Prazo de instalação vencido</a></td>
	               <td><div id="resultStatusVenc"></div>    
	           </tr>
	           <tr class="trCor">
	               <td><a href="#" onClick="getAjaxForm('OSSP/liste','conteudo',{ldelim}where:' EXISTS ( SELECT * FROM agenda_instal_sp WHERE agenda_instal.os_sp_idos = idos AND agenda_instal_sp.confirm)',ajax:1{rdelim})">Confirmados</a></td>
	               <td><div id="resultConfirm">indefinido</div></td>
	               <td><a href="#" onClick="getAjaxForm('OSSP/liste','conteudo',{ldelim}where:' EXISTS ( SELECT * FROM instalacoes_sp WHERE instalacoes.os_sp_idos = idos AND instalacoes_sp.comiss)',ajax:1{rdelim})" >Instalações Concluídas</a></td>
	               <td><div id="resultStatusConc"></div>
	           </tr>
	           
	       </table>
	   </div>
	    
	   <div id='painelInstal' class="painel"  style='visibility: hidden'>
	       
	       <table >
	           <tr>
	               <th colspan="2">Instalações</th>
	               
	           </tr>
	           <tr class="trCor">
	               <td><a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'ISNULL(packetshapper)',ajax:1{rdelim})">Pendente Packet Shapper</a></td>
	               <td><div id="resultInstalPS">indefinido</div></td>
	           </tr>
	           <tr class="trsCor">
	               <td><a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'ISNULL(webnms)',ajax:1{rdelim})">Pendente WebNMS</a></td>
	               <td><div id="resultInstalPW">indefinido</DIV></td>
	           </tr>
	           <tr class="trCor">
	               <td><a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'(ISNULL(webnms) OR ISNULL(packetshapper))',ajax:1{rdelim})">Incompleta</a></td>
	               <td><div id="resultInstalIN">indefinido</div></td>
	           </tr>
	           <tr class="trCor">
	               <td><a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'(ISNULL(comiss))',ajax:1{rdelim})">Pendente Comissionamento</a></td>
	               <td><div id="resultInstalCM">indefinido</div></td>
	           </tr>
	           
	       </table>
	   </div>
	    <div id='painelIncid' class="painel"  style='visibility: hidden'>
	       
			<table >
	        	<tr>
	            	<th colspan="2">Incidentes</th>
	           	</tr>
	           	<tr class="trCor">
	            	<td>
	            		<a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'ISNULL(packetshapper)',ajax:1{rdelim})">
	            			Abertos
	            		</a>
	            	</td>
	               	<td><div id="resultadoIncidentesAbertos">indefinido</div></td>
	           	</tr>
	           	<tr class="trsCor">
	            	<td>
	            		<a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'ISNULL(webnms)',ajax:1{rdelim})">
	            			Em atendimento
	            		</a>
	            	</td>
	            	<td><div id="resultadoIncidentesAtendimento">indefinido</DIV></td>
	           	</tr>
				<tr class="trCor">
	            	<td>
	               		<a href="#" onClick="getAjaxForm('Instalacao_sp/liste','conteudo',{ldelim}param:'(ISNULL(webnms) OR ISNULL(packetshapper))',ajax:1{rdelim})">
	               			Finalizados
	               		</a>
	               	</td>
	               	<td><div id="resultadoIncidentesFinalizados">indefinido</div></td>
	           	</tr>
	       	</table>
	       	
	   	</div>
	   	
	   	<div id='painelAgendamentos' class="painel"  style='visibility: hidden'>
			
			<table >
	        	<tr>
					<th colspan="2">Agendamentos para Hoje</th>
	           	</tr>
	           	<tr class="trCor">
	            	<td colspan="2">
	            		
	            		<div id="lista_agendamentos_home">Indefinido</div>
	            		
	            	</td>
	           	</tr>
	       	</table>
	       	
	   	</div>
	   	
	   	<div style="clear: both">
	    </div>
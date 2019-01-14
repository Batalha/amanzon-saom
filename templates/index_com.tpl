<div>
    
    <div id="navegRapid" class="painel" >
        <table   >
            <tr>
               <th colspan="2">
                   Acesso Rápido
               </th>
           </tr>
           <tr>
               <td>
                   <img src="imagens/agenda_icon.png" />
               </td>
               <td>
                   <a href="#" onClick="abrePainelOS()"> Ordem de Serviços</a>
               </td>
               
           </tr>

           <tr>
               <td>
                   <img src="imagens/instalacao_icon.png" />
               </td>
               <td>
                    <a href="#" onClick="abrePainelInstal()"> Instalações</a>
               </td>
               
           </tr>
             <tr>
               <td>
                   <img src="imagens/incidente_icon.png" />
               </td>
               <td>
                    <a href="#" onClick="abrePainelIncid()"> Incidentes</a>
               </td>
               
           </tr>
           
        </table>
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
               <td><a href="#" onClick="getAjaxForm('OS/liste','conteudo',{ldelim}param:'NOT EXISTS ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos )',ajax:1{rdelim})" >Pendentes</a></td>
               <td><div id="resultPen">indefinido</div></td>
               <td><a href="#"  onClick="getAjaxForm('OS/liste','conteudo',{ldelim}param:'NOT EXISTS ( SELECT * FROM instalacoes WHERE instalacoes.os_idos = idos AND instalacoes.comiss) AND prazoInstal < CURDATE( )',ajax:1{rdelim})">Em andamento</a></td>
               <td><div id="resultStatusAberto"></div>
           </tr>
           <tr class="trsCor">
               <td><a href="#" onClick="getAjaxForm('OS/liste','conteudo',{ldelim}param:'EXISTS ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos AND NOT agenda_instal.confirm)',ajax:1{rdelim})">Pendente Confirmação</a></td>
               <td><div id="resultAgen">indefinido</DIV></td>
               <td><a href="#"  onClick="getAjaxForm('OS/liste','conteudo',{ldelim}param:'NOT EXISTS ( SELECT * FROM instalacoes WHERE instalacoes.os_idos = idos AND instalacoes.comiss) AND prazoInstal < CURDATE( )',ajax:1{rdelim})">Prazo de instalação vencido</a></td>
               <td><div id="resultStatusVenc"></div>    
           </tr>
           <tr class="trCor">
               <td><a href="#" onClick="getAjaxForm('OS/liste','conteudo',{ldelim}param:' EXISTS ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos AND agenda_instal.confirm)',ajax:1{rdelim})">Confirmados</a></td>
               <td><div id="resultConfirm">indefinido</div></td>
               <td><a href="#" onClick="getAjaxForm('OS/liste','conteudo',{ldelim}param:' EXISTS ( SELECT * FROM instalacoes WHERE instalacoes.os_idos = idos AND instalacoes.comiss)',ajax:1{rdelim})" >Instalações Concluídas</a></td>
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
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'ISNULL(packetshapper)',ajax:1{rdelim})">Pendente Packet Shapper</a></td>
               <td><div id="resultInstalPS">indefinido</div></td>
           </tr>
           <tr class="trsCor">
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'ISNULL(webnms)',ajax:1{rdelim})">Pendente WebNMS</a></td>
               <td><div id="resultInstalPW">indefinido</DIV></td>
           </tr>
           <tr class="trCor">
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'(ISNULL(webnms) OR ISNULL(packetshapper))',ajax:1{rdelim})">Incompleta</a></td>
               <td><div id="resultInstalIN">indefinido</div></td>
           </tr>
           <tr class="trCor">
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'(ISNULL(comiss))',ajax:1{rdelim})">Pendente Comissionamento</a></td>
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
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'ISNULL(packetshapper)',ajax:1{rdelim})">Abertos</a></td>
               <td><div id="resultInstalPS">indefinido</div></td>
           </tr>
           <tr class="trsCor">
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'ISNULL(webnms)',ajax:1{rdelim})">Em atendimento</a></td>
               <td><div id="resultInstalPW">indefinido</DIV></td>
           </tr>
           <tr class="trCor">
               <td><a href="#" onClick="getAjaxForm('Instalacao/liste','conteudo',{ldelim}param:'(ISNULL(webnms) OR ISNULL(packetshapper))',ajax:1{rdelim})">Finalizados</a></td>
               <td><div id="resultInstalIN">indefinido</div></td>
           </tr>
       </table>
   </div>
    <div style="clear: both">
    </div>
    
</div>
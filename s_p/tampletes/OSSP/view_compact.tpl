
<center>
{include file="s_p/tampletes/OSSP/submenu.tpl" title=submenu}

<form class="form" id="FOSCreate"> 
    <fieldset>
        <legend>OS N° <b>{$obj.numOS}</b></legend>
    <table class="tbForm">
        <tr>
            <td>
                <label for="numOS">Número da OS</label>
            </td>
            <td>
                {$obj.numOS}
            </td>

            <td>
                <label for="identificador">Identificador </label>
            </td>
            <td>
                {$obj.identificador}
            </td>        
        </tr>
        <tr>    
            <td>
                <label for="designacao">Designação </label>
            </td>
            <td>
                {$obj.designacao}
            </td>
            <td>
                <label for="orgao">Orgão </label>
            </td>
            <td>
                {$obj.orgao}
            </td>

        </tr>
        {if $login.perfis_idperfis != 3 }
            <tr>
            <td>
                <label for="cnpj">CNPJ </label>
            </td>
            <td>
                {$obj.cnpj}
            </td>

        </tr>
        {/if}
        <tr>
            <td>
                <label for="contato">Contato </label>
            </td>
            <td>
                {$obj.contato}
            </td>
            <td>
                <label for="telContato"> Tel. Contato </label>
            </td>
            <td>
                1° {$obj.telContato} 2° {$obj.outroTelContato}
            </td>
        </tr>
<!--        <tr>
            <td>
                <label for="nomeSolicitante"> Nome do Solicitante </label>
            </td>
            <td>
               {$obj.nomeSolicitante}
            </td>
            <td>
                <label for="departamento">Departamento</label>
            </td>
            <td>
               {$obj.departamento}
            </td>      
        </tr>-->
        
        <tr>
            <td>
                <label for="email" > Email </label>
            </td>
            <td>
               {$obj.email}
            </td>

        </tr>
        <tr>
            <td>
                <label for="enderecoInstal"> End. do Acesso</label>

            </td>
            <td>
                {$obj.enderecoInstal}
            </td>

        </tr>
        <tr>
            <td>
                <label for="cidade"> Cidade</label>
            </td>
            <td>
               {$obj.rel.municipios_idcidade.municipio}
            </td>
        </tr>
        <tr>
<!--        <tr>
            <td>
                <label for="bairro"> Bairro </label>
            </td>
            <td>
               {$obj.bairro}
            </td>

        </tr>-->
        <tr>
            <td>
               <label for="cep" > CEP</label>
            </td>
            <td>
                {$obj.cep}
            </td>
        </tr>
        <tr>
            <td>
                <label for="velDownload" > Vel. Download </label>
            </td>
            <td>
               {$obj.velDownload}
            </td>
            <td>
                <label for="velUpload" > Vel. Upload </label>
            </td>
            <td>
                {$obj.velUpload}
            </td>
         </tr>

         <tr>
            <td>
                <label for="areaInstal" > Área Instalação </label>
            </td>
            <td>
                {$obj.areaInstal}
            </td>
            <td>
                <label for="lote" > Lote</label>
            </td>
            <td>
               {$obj.lote}
            </td>
         </tr>

<!--         <tr>
            <td>
                <label for="latitude" > Latitude </label>
            </td>
            <td>
                {$obj.latitude}
            </td>
            <td>
                <label for="longitude" > Longitude </label>
            </td>
            <td>
                {$obj.longitude}
            </td>
         </tr>-->
         <tr>
            <td>
                <label for="perfil" > Perfil</label>
            </td>
            <td>
                {$obj.perfil}
            </td>
            
         </tr> 
         <tr>
            <td>
                <label for="padrao" > Padrão</label>
            </td>
            <td>
                Sem redundância
            </td>
             <td>
                <label for="servico" > Serviço</label>
            </td>
            <td>
                Satélite
            </td>
         </tr> 
         <tr>
            <td>
                <label for="ipLan" > Ip Lan </label>
            </td>
            <td>
               {$obj.iplan}
            </td>
            <td>
                <label for="mascaraLan" > Máscara LAN </label>
            </td>
            <td>
                {$obj.mascaraLan}
            </td>
         </tr>
         {if $login.perfis_idperfis != 3 }
         <tr>
<!--            <td>
                <label for="contatoFaturamento" size="30"> Contato Faturamento </label>
            </td>
            <td>
               {$obj.contatoFaturamento}
            </td>-->
            <td>
                <label for="enderecoFaturamento" > Endereço Faturamento </label>
            </td>
            <td>
               {$obj.enderecoFaturamento} 
            </td>
         </tr>
         <tr>
            <td>
                <label for="cidadeFaturamento" > Cidade </label>
            </td>
            <td> 
               {$obj.rel.municipios_idcidadeFaturamento.municipio}
            </td>
             <td>
                <label for="cepFaturamento" > CEP </label>
            </td>
            <td>
                 {$obj.cepFaturamento}
            </td>
         </tr> 
         {/if}
         <tr>
             {if $login.perfis_idperfis != 3 }
            <td>
                <label for="emailFaturamento" > Email Faturamento </label>
            </td>
           
            <td>
                {$obj.emailFaturamento}
            </td>
             {/if}
            <td>
                <label for="dataSolicitacao" > Data Solicitação </label>
            </td>
            <td>
                {$obj.dataSolicitacao}
            </td>
         </tr>

         <tr>
            <td>
                <label for="prazoInstal" > Prazo Instalação </label>
            </td>
            <td>
                {$obj.prazoInstal}
            </td>
         </tr>

         <tr>
            <td>
                <label for="observacoes" > Observações </label>
            </td>
            <td colspan="2">
                {$obj.observacoes}
            </td>
         </tr>
         
    </table>

    </fieldset>
    <br />
</form>
<br>  
</center>
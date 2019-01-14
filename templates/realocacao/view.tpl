<center>
<form action="Realocacao/edit" method="POST" id="fRLEdit" class="form" >
   
   <fieldset>
            <legend>Realocação</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        <label for='data'>Novo Endereço</label>
        <hr/>
        <table class="tbForm">
            <tr>
                <td>
                    <label for="latitude">Latitude</label>
                </td>
                <td>
                    {$obj.latitude}
                </td>
                <td>
                    <label for="longitude">Longitude</label>
                </td>
                <td>
                    {$obj.longitude}
                </td>
            </tr>
            <tr>    
                <td>
                    <label for="cep">CEP</label>
                </td>
                <td >
                   {$obj.cep}
                </td>
                <td>
                    <label for="cep">Código de Área</label>
                </td>
                <td >
                   {$obj.cod_area}
                </td>
            </tr>
            <tr>    
                <td>
                    <label for="tel">Cidade </label>
                </td>
                <td>
                     {$obj.cidade}
                </td>
           </tr>

            <tr>    
                <td>
                    <label for="bairro">Bairro </label>
                </td>
                <td>
                   {$obj.bairro}
                </td>

            </tr>
            <tr>    
                <td>
                    <label for="endereco">Endereço</label>
                </td>
                <td>
                    {$obj.endereco}
                </td>        
            </tr>
            
        </table>
        
        </div>
        <div  style="padding:5px">
            <label for='nsmodem'>Observações</label>
            <hr/>
            <table class="tbForm">
                <tr>    
                  <td >
                      <div></div>
                  </td>

                 </tr>

            </table>
        </div>
        <div style="clear: both"></div>
        <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
           
    </fieldset> 
    <br />
    <center>
        
        <input type="button" value="Editar" onClick="javascript:getAjaxForm('Realocacao/edit',false,{ldelim}param:{$obj.idrealocacao},ajax:1{rdelim})" />
       
    </center>    
</form>
</center>

<form action="AgendaInstal/create" method="POST" id="fAgCreate" class="form" >
    <input type="hidden" name="os_idos" id="os_idos" value="{$param}"/>
    <fieldset>
            <legend>Agendar Instalação</legend>
            <br />
    <div style="float:left; margin-right:5px; padding:5px;width:50%">
        <label for='data'>Dados de contato</label>
        <hr/>
           
        <input type="hidden" value="{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}" name="data_temp"/>
        <input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios" />
        <table class="tbForm">
            <tr>
                <td>
                    <label for="data">Data Agendada da instalação</label>
                </td>
                <td>
                    <input type="text" name="data" id="data" size="10" class="inputData"  />
                </td>

            </tr>
            <tr>    
                <td>
                    <label for="contato">Nome</label>
                </td>
                <td>
                    <input type="text" name="contato" id="contato" size="40" class="inputReq" />
                </td>        
            </tr>
            <tr>    
                <td>
                    <label for="tel">Telefone </label>
                </td>
                <td>
                    <input type="text" name="tel" id="tel" size="30" class="inputReq"  />
                </td>
           </tr>

            <tr>    
                <td>
                    <label for="cel">Celular </label>
                </td>
                <td>
                    <input type="text" name="cel" id="cel" size="30" class="inputReq"  />
                </td>

            </tr>
            
            <tr>
                <td>
                    2° Contato:
                </td>
            </tr>
            <tr>    
                <td>
                    <label for="contato_2">Nome</label>
                </td>
                <td>
                    <input type="text" name="contato_2" id="contato_2" size="30" />
                </td>        
            </tr>
            <tr>    
                <td>
                    <label for="tel_2">Telefone </label>
                </td>
                <td>
                    <input type="text" name="tel_2" id="tel_2" size="30" />
                </td>
           </tr>

            <tr>    
                <td>
                    <label for="cel_2">Celular </label>
                </td>
                <td>
                    <input type="text" name="cel_2" id="cel_2" size="30"/>
                </td>

            </tr>
            <input type="hidden" name="confirm" id="confirm" value="0" />
        </table>

     </div>   
    <div  style="padding:5px">
        <label for='nsmodem'>Dados da Instalação</label>
        <hr/>
        <table class="tbForm">
            <tr>    
                <td>
                    <label for="nsmodem">N° Série Modem </label>
                </td>
                <td>
                    <input type="text" name="nsmodem" id="nsmodem" size="30" class="inputReq" >
                </td>

            </tr>

            <tr>    
                <td>
                    <label for="mac">MAC</label>
                </td>
                <td>
                   Ex. (XX:XX:XX:XX:XX:XX) <input type="text" name="mac" id="mac" size="30" class="inputReq" />
                </td>

            </tr>
            <tr>    
                <td>
                    <label for="odu">ODU </label>
                </td>
                <td>
                    <select name="odu" class="selectReq" >
                        <option value='4033'>4033</option>
                        <option value='4035'>4035</option>
                    </select>
                </td>

            </tr>
            <tr>    
                <td>
                    <label for="nsodu">N° Serie ODU </label>
                </td>
                <td>
                    <input type="text" name="nsodu" id="nsodu" size="30" class="inputReq"  />
                </td>

            </tr>
            <tr>
                <td >
                    <label for="antena">Antena:</label>
                </td>
            </tr>
            <tr>    
                <td>
                    <label for="antena" >Marca </label>
                </td>
                <td>
                    <select name="antena" class="selectReq" >
                        <option value='patriot'>Patriot</option>
                        <option value='skyware'> Skyware</option>
                    </select>
                </td>

            </tr>

            <tr>    
                <td>
                    <label for="antena_tam">Tamanho </label>
                </td>
                <td>
                    <select name="antena_tam" class="selectReq" >
                        <option value='1.2m'>1.2m</option>
                        <option value='1.8m'>1.8m</option>
                    </select>
                </td>

            </tr>

            <tr>    
                <td>
                    <label for="antena_ns">N° Série </label>
                </td>
                <td>
                    <input type="text" name="antena_ns" id="antena_ns" size="30" class="inputReq"  />
                </td>

            </tr>
            
            <tr>    
                <td>
                    <label for="observacoes">Observações </label>
                </td>
                <td>
                    <textarea id="observacoes" name="observacoes" rows="7" cols="40"></textarea>
                </td>
            </tr>
           
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
     </fieldset>       
    </div>
    <br />
    <center><input type="button" value="Cadastrar agendamento" onClick="javascript:sendPost('AgendaInstal/create','fAgCreate')" /></center>
</form>
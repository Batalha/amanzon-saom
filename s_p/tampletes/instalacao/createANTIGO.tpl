
<center>

<form action="Instalacao_sp/create" method="POST" id="FINSCreate" class="form" >
    <input type="hidden" name="os_sp_idos" id="os_sp_idos" value="{$param}"/>
    <div class="cadastroVsat">
        <b>Dados da Vsat</b>
        <table class="tbFormVsat" border="0" width="100%">

            <tr>
                <td width="20%">
                    <label for="nome">Vsat</label>
                </td>
                <td>
                    <input type="text" name="nome" id="nome" />
                </td>
                <td width="10%">
                    <label for="mac">MAC</label>
                </td>
                <td>
                    <input type="text" name="mac" id="mac" size="30" class="inputReq"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="ipLan" > Ip Lan </label>
                </td>
                <td>
                    <input type="text" id="iplan" name="iplan" class='inputReq' />
                </td>
                <td>
                    <label for="ipdvb" > Ip DVB </label>
                </td>
                <td>
                    <input type="text" id="os_ipdvb" name="os_ipdvb" class='inputReq' value="{$obj.rel.os_sp.ipdvb}" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mascaraLan" > Máscara LAN </label>
                </td>
                <td>
                    <input type="text" id="mascaraLan" name="mascaraLan" class='inputReq'  />
                </td>
            </tr>
            <tr>
                <td></td>
                 <td>
                     <label style="float:left;margin-right:15px;" for="nms"><b>Vsat foi criada no WEBNMS?</b></label>
                     <input style="float:left;" type="checkbox" name="webnms" id="webnms" />
                 </td>
                <td></td>
                 <td>
                     <label style="float:left;margin-right:15px;" for="test_sl2000"><b>Testou Sat Link 2000?</b></label>
                     <input style="float:left;" type="checkbox" name="test_sl2000" id="test_sl2000" />
                 </td>
             </tr>
            <tr >
                <td >
                    <label for="obs">Observações </label>
                </td>
                <td colspan="4">
                    <textarea name="obs" id="obs" rows="6" style="width: 600px"></textarea>
                </td>

            </tr>
        </table>
         <div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>
    </div>
    <br />
    <center><input type="button" value="Cadastrar dados" onClick="javascript:sendPost('Instalacao_sp/create','FINSCreate')" /></center>
</form>

</center>

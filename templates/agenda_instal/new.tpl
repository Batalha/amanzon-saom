
<div class="container1" style="width: 50%;">
    <div id="data_verificacao" style="visibility:hidden;">{$dataAtual}</div>
    <form action="AgendaInstal/create" method="GET" id="fAgCreate" class="form" >
        <input type="hidden" name="os_idos" id="os_idos" value="{$param}"/>
        <input type="hidden" value="{$dataAtual}" name="data_temp"/>
        <input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios" />
        <input type="hidden" name="confirm" id="confirm" value="0" />

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Dados de Contato</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <input class="form-control" type="text" name="data" id="data" placeholder="Data Agendada" value="" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <input  class="form-control"  type="text" name="contato" id="contato" placeholder="Nome Contato" value=""/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="tel" id="tel"  placeholder="Telefone" value=""
                               onkeypress="Mask(this, telefone)"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <input  class="form-control" type="text" name="cel" id="cel"  placeholder="Celular"value=""
                                onkeypress="Mask(this, celular)"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <input  class="form-control"  type="text" name="contato_2" id="contato_2" placeholder="Nome Contato" value=""/>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="tel_2" id="tel"  placeholder="Telefone" value=""
                               onkeypress="Mask(this, telefone)"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <input  class="form-control" type="text" name="cel_2" id="cel"  placeholder="Celular"value=""
                                onkeypress="Mask(this, celular)"
                        />
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Agendar Instalação</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="antena" class="form-control">
                            <option value='patriot'>Patriot</option>
                            <option value='skyware'> Skyware</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="antena_tam" class="form-control">
                            <option value='1.2m'>1.2m</option>
                            <option value='1.8m'>1.8m</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" name="mac" id="mac" alt="mac" class="form-control inputReq" value="" placeholder="MAC"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name="nsmodem" id="nsmodem" class="form-control inputReq" value="" placeholder="Nº Série Modem"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" name="nsodu" id="nsodu" class="form-control autoCompleteNSODU"
                               class="inputReq autoCompleteNSODU" placeholder="Nº Serie ODU"
                               onkeyup="javascript:autoCompleteNSODU()"
                               onblur="javascript:onblurBuscaODU()"
                        />
                        <div id="autocompleteNSODU" style="position:absolute;display:none"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="odu" id="odu" class="form-control" >
                            <option value="">Escolha uma opção</option>
                            {foreach from=$tipoEquipamento item=tipoEquipamentos}
                                <option value="{$tipoEquipamentos.idtipo_equipamentos}">{$tipoEquipamentos.nome}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea  class="form-control" id="observacoes" name="observacoes" placeholder="Observações" ></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-primary" onClick="javascript:sendPost('AgendaInstal/create','fAgCreate')"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



{*<center>*}

{*<!-- div que serve para a verificação, ela guarda a data atual e não permite menor que a mesma por verificação javascript -->*}
{*<div id="data_verificacao" style="visibility:hidden;">{$dataAtual}</div>*}

{*<form action="AgendaInstal/create" method="GET" id="fAgCreate" class="form" >*}
    {*<input type="hidden" name="os_idos" id="os_idos" value="{$param}"/>*}
    {*<input type="hidden" value="{$dataAtual}" name="data_temp"/>*}
    {*<input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios" />*}
    {*<input type="hidden" name="confirm" id="confirm" value="0" />*}
    {*<fieldset>*}
            {*<legend>Agendar Instalação</legend>*}
            {*<br />*}
    {*<div style="float:left; margin-right:5px; padding:5px;width:50%">*}
        {*<label for='data'>Dados de contato</label>*}
        {*<hr/>*}
           {**}
        {*<table class="tbForm">*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="data">Data Agendada da instalação</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="data" id="data" size="10" class="inputData" style="float:left" value="" />*}
                {*</td>*}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="contato">Nome</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="contato" id="contato" size="40" class="inputReq" value=""/>*}
                {*</td>        *}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="tel">Telefone </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="tel" id="tel" size="30" class="inputReq"  value=""/>*}
                {*</td>*}
           	{*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="cel">Celular </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="cel" id="cel" size="30" class="inputReq" value="" />*}
                {*</td>*}

            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*2° Contato:*}
                {*</td>*}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="contato_2">Nome</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="contato_2" id="contato_2" size="30" value=""/>*}
                {*</td>        *}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="tel_2">Telefone </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="tel_2" id="tel_2" size="30" value=""/>*}
                {*</td>*}
           	{*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="cel_2">Celular </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="cel_2" id="cel_2" size="30" value=""/>*}
                {*</td>*}
            {*</tr>*}
            {**}
        {*</table>*}

     {*</div>   *}
    {*<div  style="padding:5px">*}
        {*<label for='nsmodem'>Dados da Instalação</label>*}
        {*<hr/>*}
        {*<table class="tbForm">*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="nsmodem">N° Série Modem </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsmodem" id="nsmodem" size="30" class="inputReq" value="" />*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">MAC</label>*}
                {*</td>*}
                {*<td>*}
                   {*<input type="text" name="mac" id="mac" alt="mac" size="30" class="inputReq" value="" />*}
                {*</td>*}

            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="odu">ODU </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="odu" id="odu" class="selectReq" >*}
                    	{*<option value="">Escolha uma opção</option>*}
				        {*{foreach from=$tipoEquipamento item=tipoEquipamentos}*}
                        	{*<option value="{$tipoEquipamentos.idtipo_equipamentos}">{$tipoEquipamentos.nome}</option>*}
                        {*{/foreach}*}
                    {*</select>*}
                {*</td>*}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="nsodu">N° Serie ODU </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsodu" id="nsodu" class="autoCompleteNSODU"*}
                      	{*class="inputReq autoCompleteNSODU"*}
                    	{*onkeyup="javascript:autoCompleteNSODU()" *}
                		{*onblur="javascript:onblurBuscaODU()"*}
                    {*/>*}
                    {*<!-- onchange="javascript:atualizaODU()" -->*}
                    {*<br/>*}
                	{*<div id="autocompleteNSODU" style="position:absolute;display:none"></div>*}
                {*</td>*}

            {*</tr>*}
            {*<tr>*}
                {*<td >*}
                    {*<label for="antena">Antena:</label>*}
                {*</td>*}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena" >Marca </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena" class="selectReq" >*}
                        {*<option value='patriot'>Patriot</option>*}
                        {*<option value='skyware'> Skyware</option>*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena_tam">Tamanho </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena_tam" class="selectReq" >*}
                        {*<option value='1.2m'>1.2m</option>*}
                        {*<option value='1.8m'>1.8m</option>*}
                    {*</select>*}

                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena_ns">N° Série </label>*}
                {*</td>*}
                {*<td>*}
{*<!--                     <input type="text" name="antena_ns" id="antena_ns" size="30" class="inputReq"  /> -->*}
                    {*<input type="text" name="antena_ns" id="antena_ns" size="30" class="inputReq" value=""/>*}
                {*</td>*}

            {*</tr>*}
            {**}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="observacoes">Observações </label>*}
                {*</td>*}
                {*<td>*}
{*<!--                     <textarea id="observacoes" name="observacoes" rows="7" cols="40" class="inputReq"></textarea> -->*}
                    {*<textarea id="observacoes" name="observacoes" rows="7" cols="40" class="inputReq" ></textarea>*}
                {*</td>*}
            {*</tr>*}
           {**}
        {*</table>*}
        {*</div>*}
         {*<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>*}
     {*</fieldset>       *}
    {*<br />*}

    	{*<input type="button" value="Cadastrar agendamento" 	onClick="javascript:sendPost('AgendaInstal/create','fAgCreate')" />    *}
{*</form>*}
{*</center>*}
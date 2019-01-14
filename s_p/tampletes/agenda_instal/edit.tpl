
<div class="container1" style="width: 50%;">
        <form action="AgendaInstal_sp/edit" method="POST" id="fAgEdit" class="form" >
            <input type="hidden" name="emailExtra" id="emailExtra" value="1" />
            <input type="hidden" name="idagenda_instal_sp" id="idagenda_instal_sp" value="{$obj.idagenda_instal_sp}"/>
            <input type="hidden" name="os_sp_idos" id="os_sp_idos" value="{$obj.os_sp_idos}"/>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title text-center">Dados de Contato</div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <input class="form-control" type="text" name="data" id="data" placeholder="Data Agendada" value="{$obj.data}" />
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="">
                                <input  class="form-control"  type="text" name="contato" id="contato" placeholder="Nome Contato" value="{$obj.contato}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="">
                                <input class="form-control" type="text" name="tel" id="tel"  placeholder="Telefone" value="{$obj.tel}"
                                       onkeypress="Mask(this, telefone)"
                                />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="">
                                <input  class="form-control" type="text" name="cel" id="cel"  placeholder="Celular"value="{$obj.cel}"
                                        onkeypress="Mask(this, celular)"
                                />
                            </div>
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
                            <div class="">
                                <select name="antena" id="antena" class="form-control autosave_agenda_instal_sp">
                                    <option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>
                                    <option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="">
                                <select name="antena_tam" id="antena" class="form-control autosave_agenda_instal_sp">
                                    <option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>
                                    <option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="">
                                <i id="restrictMac" style=" font-size: 1.5em; color: red; padding: 10px; position: absolute; margin: 2px 0px 0px 250px;">
                                </i>
                                <input type="text" name="mac" id="mac" alt="mac"  class="form-control" value="{$obj.mac}" placeholder="MAC"
                                       onblur="javascript: atualizaNSModemsp(this.value);"
                                />
                                <div id="listaMacComplete" style="position:absolute;display:none">{$listamacautocomplete}</div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="">
                                <input type="text" name="nsmodem" id="nsmodem" readonly="readonly" class="form-control" value="{$obj.nsmodem}" placeholder="Nº Serie do Modem" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <i id="restrictOdu" style=" font-size: 1.5em; color: red; padding: 10px; position: absolute; margin: 2px 0px 0px 250px;"></i>
                            <input type="text" name="nsodu" id="nsodu" class="form-control" value="{$obj.nsodu}" placeholder="Nº Serie do ODU/BUC"
                                   onblur="javascript:atualizaAgendaODUsp(this.value);"
                            />
                            <div id="listaComplete" style="position:absolute;display:none">{$listaautocomplete}</div>
                        </div>
                        <div class="form-group col-md-6">
                            <select name="odu" id="odu" class="form-control">
                                <option value="">Escolha Tipo de ODU</option>
                                {foreach from=$tipoEquipamento item=tipoEquipamentos}
                                    <option value="{$tipoEquipamentos.idtipo_equipamentos_sp}"
                                            {if isset($obj.rel.tipo_equipamentos_sp)}
                                                {if $tipoEquipamentos.idtipo_equipamentos_sp == $obj.odu}selected{/if}
                                            {/if}
                                    >{$tipoEquipamentos.nome}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="">
                                <textarea id="observacoes" name="observacoes" class="form-control autosave_agenda_instal_sp" style="height: 100px;" placeholder="Observações" >{$obj.observacoes}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 text-left">
                            <button type="button" class="btn btn-primary" onClick="javascript:sendPost('AgendaInstal_sp/edit','fAgEdit')">Gravar Agendamento</button>
                        </div>
                        <div class="form-group col-md-8">
                            <span id="respostaConsultaAgenda" class="alert alert-error" style="display: none;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>




    {*<form action="AgendaInstal_sp/edit" method="POST" id="fAgEdit" class="form" >*}
	{*<input type="hidden" name="emailExtra" id="emailExtra" value="1" />*}
    {*<input type="hidden" name="idagenda_instal_sp" id="idagenda_instal_sp" value="{$obj.idagenda_instal_sp}"/>*}
    {*<input type="hidden" name="os_sp_idos" id="os_sp_idos" value="{$obj.os_sp_idos}"/>*}




    {*<div class="layoutCadAgenda" style="height: 260px;">*}
        {*<b>Dados de contato</b>*}
        {*<table class="tbFormAg" border="0" width="100%">*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="data">Data Agendada da instalação</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="data" id="data" size="10" class="inputData" value="{$obj.data}" style="float:left;" />*}
                 {*</td>*}
            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="contato">Nome</label>*}
                {*</td>*}
                {*<td colspan="4">*}
                    {*<input type="text" name="contato" id="contato" size="40" style="width: 680px" class="inputReq autosave_agenda_instal_sp" value="{$obj.contato}" />*}
                {*</td>*}
            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="tel">Telefone </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="tel" id="tel" size="30" style="width: 300px"class="inputReq autosave_agenda_instal_sp" value="{$obj.tel}"  />*}
                {*</td>*}
                {*<td>*}
                    {*<label for="cel">Celular </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="cel" id="cel" size="30" style="width: 300px" class="inputReq autosave_agenda_instal_sp" value="{$obj.cel}"  />*}
                {*</td>*}
            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="contato_2">Nome</label>*}
                {*</td>*}
                {*<td colspan="4">*}
                    {*<input class="autosave_agenda_instal_sp" type="text" name="contato_2" id="contato_2" size="30" style="width: 680px" value="{$obj.contato_2}" />*}
                {*</td>*}
            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="tel_2">Telefone </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input class="autosave_agenda_instal_sp" type="text" name="tel_2" id="tel_2" size="30" style="width: 300px" value="{$obj.tel_2}" />*}
                {*</td>*}
                {*<td>*}
                    {*<label for="cel_2">Celular </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input class="autosave_agenda_instal_sp" type="text" name="cel_2" id="cel_2" size="30" style="width: 300px" value="{$obj.cel_2}"/>*}
                {*</td>*}
            {*</tr>*}
            {*<input type="hidden" name="confirm" id="confirm" value="0" />*}

        {*</table>*}
    {*</div>*}

    {*<div class="layoutCadAgenda" style="height: 260px;">*}
        {*<b>Dados da Instalação</b>*}

        {*<table class="tbFormAg" border="0" width="100%">*}
            {*<tr>*}
                {*<td width="22%">*}
                    {*<label for="nsmodem">N° Série Modem </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsmodem" id="nsmodem" size="30" style="width: 250px" class="inputReq autosave_agenda_instal_sp" value="{$obj.nsmodem}" />*}
                {*</td>*}
                {*<td>*}
                    {*<label for="mac">MAC </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="mac" alt="mac" id="mac" size="30" style="width: 250px" class="inputReq autosave_agenda_instal_sp" value="{$obj.mac}" />*}
                {*</td>*}

            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="antena" >Antena </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena" class="inputReq autosave_agenda_instal_sp" style="width: 250px">*}
                        {*<option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>*}
                        {*<option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>*}
                    {*</select>*}
                {*</td>*}
                {*<td>*}
                    {*<label for="antena_tam">Tamanho </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena_tam" class="inputReq autosave_agenda_instal_sp"  style="width: 250px">*}
                        {*<option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>*}
                        {*<option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="odu">ODU/BUC </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="odu" id="odu" class="inputReq autosave_agenda_instal_sp" style="width: 250px">*}
                        {*<option value="">Escolha uma opção</option>*}
                        {*{foreach from=$tipoEquipamento item=tipoEquipamentos}*}
                            {*<option*}
                                    {*value="{$tipoEquipamentos.idtipo_equipamentos}"*}
                                    {*{if isset($obj.rel.tipo_equipamentos)}*}
                                        {*{if $tipoEquipamentos.idtipo_equipamentos == $obj.rel.tipo_equipamentos.idtipo_equipamentos}selected{/if}*}
                                    {*{/if}*}
                            {*>{$tipoEquipamentos.nome}</option>*}
                        {*{/foreach}*}
                    {*</select>*}
                {*</td>*}
                {*<td>*}
                    {*<label for="nsodu">N° Serie ODU/BUC </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsodu"	id="nsodu" size="30" style="width: 250px" value="{$obj.nsodu}" class="inputReq autosave_agenda_instal_sp" />*}
                    {*<div style="display:none" id="listaComplete">{$listaautocomplete}</div>*}
                {*</td>*}

            {*</tr>*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="observacoes">Observações </label>*}
                {*</td>*}
                {*<td colspan="4">*}
                    {*<textarea class="autosave_agenda_instal_sp" id="observacoes" name="observacoes" rows="3" style="width: 690px">{$obj.observacoes}</textarea>*}
                {*</td>*}
            {*</tr>*}
        {*</table>*}
    {*</div>*}
    {*<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>*}

     {*<br />*}
    {*<center><input type="button" value="Gravar Agendamento" onClick="javascript:sendPost('AgendaInstal_sp/edit','fAgEdit')" /></center>*}
{*</form>*}
{*</center>*}
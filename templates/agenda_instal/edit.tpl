<div class="container1" style="width: 50%;">
    <div id="data_verificacao" style="visibility:hidden;">{$dataAtual}</div>
    <form action="AgendaInstal/edit" method="POST" id="fAgEdit" class="form" >
        <input type="hidden" name="emailExtra" id="emailExtra" value="1" />
        <input type="hidden" name="idagenda_instal" id="idagenda_instal" value="{$obj.idagenda_instal}"/>
        <input type="hidden" name="os_idos" id="os_idos" value="{$obj.os_idos}"/>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Dados de Contato</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input class="form-control" type="text" name="data" id="data" placeholder="Data Agendada" value="{$obj.data}" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <div hidden="" class="btn-group" data-toggle="buttons-checkbox">
                        <button name="para_teste" class="btn btn-primary {if $obj.para_teste == 1}active{/if}"
                                onclick="javascript:
                                if($('#para_teste').is(':checked'))
                                {ldelim}
                                        $('#para_teste').attr('checked', false);
                                        $('#aviso_teste').html($('#aviso_teste_s').html());
                                        $('#aviso_teste').fadeIn();
                                        //$('#data').css('display','block');
                                        setTimeout('$(\'#aviso_teste\').fadeOut(\'\')',4000);
                                {rdelim}
                                else
                                {ldelim}
                                        $('#para_teste').attr('checked', true);
                                        $('#aviso_teste').html($('#aviso_teste_n').html());
                                        $('#aviso_teste').fadeIn();
                                        //$('#data').css('display','none');
                                        setTimeout('$(\'#aviso_teste\').fadeOut(\'\')',4000);
                                {rdelim}
                                return false;"
                        >Teste</button>
                            <input type="checkbox" name="para_teste" id="para_teste" style="visibility:hidden;" {if $obj.para_teste == 1}checked{/if}/>
                            <div style="clear:both;height:0px;">&nbsp;</div>
                        </div>
                    </div>
                    <div class="form-group col-md-6 text-center">
                        <div style="display:none;" id="aviso_teste"></div>
                        <div style="visibility:hidden;" id="aviso_teste_reserva">
                            <div id="aviso_teste_n"><span class="label label-warning">Agendamento Teste (sem data obrigatória)</span></div>
                            <div id="aviso_teste_s"><span class="label label-warning">Agendamento (com data obrigatória)</span></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                        <input  class="form-control autosave_agenda_instal"  type="text" name="contato" id="contato" placeholder="Nome Contato" value="{$obj.contato}"/>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="">
                        <input class="form-control autosave_agenda_instal" type="text" name="tel" id="tel"  placeholder="Telefone" value="{$obj.tel}"
                               onkeypress="Mask(this, telefone)"
                        />
                            </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="">
                        <input  class="form-control autosave_agenda_instal" type="text" name="cel" id="cel"  placeholder="Celular" value="{$obj.cel}"
                                onkeypress="Mask(this, celular)"
                        />
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                        <input  class="form-control autosave_agenda_instal"  type="text" name="contato_2" id="contato_2" placeholder="Nome Contato" value="{$obj.contato_2}"/>
                            </div>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-6">
                        <div class="">
                        <input class="form-control autosave_agenda_instal" type="text" name="tel_2" id="tel_2"  placeholder="Telefone" value="{$obj.tel_2}"
                               onkeypress="Mask(this, telefone)"
                        />
                            </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="">
                        <input  class="form-control autosave_agenda_instal" type="text" name="cel_2" id="cel_2"  placeholder="Celular" value="{$obj.cel_2}"
                                onkeypress="Mask(this, celular)"
                        />
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="confirm" id="confirm" value="0" />

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Agendar Instalação</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="">
                        <select name="antena" id="antena" class="form-control autosave_agenda_instal" >
                            <option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>
                            <option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>
                        </select>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="">
                        <input type="text" name="antena_ns" id="antena_ns" size="30" class="form-control autosave_agenda_instal" value="{$obj.antena_ns}" placeholder="Nº Série"/>
                            </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="">
                        <select name="antena_tam" id="antena_tam" class="form-control autosave_agenda_instal" >
                            <option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>
                            <option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>
                        </select>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="">
                        <input type="text" name="mac" id="mac" alt="mac" class="form-control autosave_agenda_instal" value="{$obj.mac}" placeholder="MAC"/>
                            </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="">
                        <input type="text" name="nsmodem" id="nsmodem" class="form-control autosave_agenda_instal" value="{$obj.nsmodem}"  placeholder="Nº Série Modem"/>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="">
                        <input type="text" name="nsodu" id="nsodu" class="form-control autosave_agenda_instal"  value="{$obj.nsodu}"
                               class="inputReq autoCompleteNSODU" placeholder="Nº Serie ODU"

                        />
                            </div>
                        <div style="display:none" id="listaComplete">{$listaautocomplete}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="">
                        <select name="odu" id="odu" class="form-control autosave_agenda_instal" >
                            <option value="">Escolha uma opção</option>
                            {foreach from=$tipoEquipamento item=tipoEquipamentos}
                                <option
                                        value="{$tipoEquipamentos.idtipo_equipamentos}"
                                        {if isset($obj.rel.tipo_equipamentos)}
                                            {if $tipoEquipamentos.idtipo_equipamentos == $obj.rel.tipo_equipamentos.idtipo_equipamentos}selected{/if}
                                        {/if}
                                >{$tipoEquipamentos.nome}</option>
                            {/foreach}
                        </select>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                        <textarea  class="form-control autosave_agenda_instal" id="observacoes" name="observacoes" placeholder="Observações" >{$obj.observacoes}</textarea>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-primary" onClick="javascript:sendPost('AgendaInstal/edit','fAgEdit')"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


{*<center>*}

{*<form action="AgendaInstal/edit" method="POST" id="fAgEdit" class="form" >*}
	{*<input type="hidden" name="emailExtra" id="emailExtra" value="1" />*}
    {*<input type="hidden" name="idagenda_instal" id="idagenda_instal" value="{$obj.idagenda_instal}"/>*}
    {*<input type="hidden" name="os_idos" id="os_idos" value="{$obj.os_idos}"/>*}
   {*<fieldset>*}
            {*<legend>Editar Agendamento</legend>*}
            {*<br />*}
    {*<div style="float:left; margin-right:5px; padding:5px;width:50%">*}
        {*<label for='data'>Dados de contato</label>*}
        {*<hr/>*}
        {*<table class="tbForm">*}
            {*<tr>*}
                {*<td>*}
                    {*<label for="data">Data Agendada da instalação</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="data" id="data" size="10" class="inputData" value="{$obj.data}" style="float:left;" />*}
                    {*<div hidden="" class="btn-group" data-toggle="buttons-checkbox" style="float:left;margin-left:4px;">*}
						{*<button *}
							{*name="para_teste" *}
							{*class="btn {if $obj.para_teste == 1}active{/if}" *}
							{*onclick="javascript:*}
								{*if($('#para_teste').is(':checked'))*}
								{*{ldelim}*}
									{*$('#para_teste').attr('checked', false);*}
									{*$('#aviso_teste').html($('#aviso_teste_s').html());*}
									{*$('#aviso_teste').fadeIn();*}
									{*//$('#data').css('display','block');*}
									{*setTimeout('$(\'#aviso_teste\').fadeOut(\'\')',4000);*}
								{*{rdelim}*}
								{*else*}
								{*{ldelim}*}
									{*$('#para_teste').attr('checked', true);*}
									{*$('#aviso_teste').html($('#aviso_teste_n').html());*}
									{*$('#aviso_teste').fadeIn();*}
									{*//$('#data').css('display','none');*}
									{*setTimeout('$(\'#aviso_teste\').fadeOut(\'\')',4000);*}
								{*{rdelim}*}
								{*return false;*}
							{*"*}
						{*>Teste</button>*}
					{*</div>*}
					{*<input type="checkbox" name="para_teste" id="para_teste" style="visibility:hidden;float:left" {if $obj.para_teste == 1}checked{/if}/>*}
					{*<div style="clear:both;height:0px;">&nbsp;</div>*}
				{*</td>*}
            {*</tr>*}
            {*<tr>*}
            	{*<td colspan="2">*}
            		{*<div style="float:left;display:none;" id="aviso_teste"></div>*}
					{*<div style="float:left;visibility:hidden;" id="aviso_teste_reserva">*}
						{*<font id="aviso_teste_n"><span class="label label-warning">Agendamento em Teste (sem data obrigatória)</span></font>*}
						{*<font id="aviso_teste_s"><span class="label label-warning">Agendamento em Produção (com data obrigatória)</span></font>*}
					{*</div>*}
            	{*</td>*}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="contato">Nome</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="contato" id="contato" size="40" class="inputReq autosave_agenda_instal" value="{$obj.contato}" />*}
                {*</td>        *}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="tel">Telefone </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="tel" id="tel" size="30" class="inputReq autosave_agenda_instal" value="{$obj.tel}"  />*}
                {*</td>*}
           {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="cel">Celular </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="cel" id="cel" size="30" class="inputReq autosave_agenda_instal" value="{$obj.cel}"  />*}
                {*</td>*}

            {*</tr>*}
            {**}
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
                    {*<input class="autosave_agenda_instal" type="text" name="contato_2" id="contato_2" size="30" value="{$obj.contato_2}" />*}
                {*</td>        *}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="tel_2">Telefone </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input class="autosave_agenda_instal" type="text" name="tel_2" id="tel_2" size="30" value="{$obj.tel_2}" />*}
                {*</td>*}
           {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="cel_2">Celular </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input class="autosave_agenda_instal" type="text" name="cel_2" id="cel_2" size="30" value="{$obj.cel_2}"/>*}
                {*</td>*}
            {*</tr>*}
            {*<input type="hidden" name="confirm" id="confirm" value="0" />*}
        {*</table>*}

    {*</div>   *}
    {*<div  style="padding:5px">*}
    {**}
        {*<label for='nsmodem'>Dados da Instalação</label>*}
        {*<hr/>*}
        {*<table class="tbForm">*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="nsmodem">N° Série Modem </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsmodem" id="nsmodem" size="30" class="inputReq autosave_agenda_instal" value="{$obj.nsmodem}" />*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">MAC </label>*}
                {*</td>*}
                {*<td>*}
                     {*<input type="text" name="mac" alt="mac" id="mac" size="30" class="inputReq autosave_agenda_instal" value="{$obj.mac}" />*}
                {*</td>*}

            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="odu">ODU </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="odu" id="odu" class="inputReq autosave_agenda_instal" >*}
                    	{*<option value="">Escolha uma opção</option>*}
                        {*{foreach from=$tipoEquipamento item=tipoEquipamentos}*}
                    		{*<option *}
                    			{*value="{$tipoEquipamentos.idtipo_equipamentos}" *}
                    			{*{if isset($obj.rel.tipo_equipamentos)}*}
                    				{*{if $tipoEquipamentos.idtipo_equipamentos == $obj.rel.tipo_equipamentos.idtipo_equipamentos}selected{/if}*}
                    			{*{/if}*}
                    		{*>{$tipoEquipamentos.nome}</option>*}
                    	{*{/foreach}*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}
            {*<tr>*}
                {**}
                {*<td>*}
                    {*<label for="nsodu">N° Serie ODU </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="nsodu"	id="nsodu" size="30" value="{$obj.nsodu}" class="inputReq autosave_agenda_instal" />*}
                    {*<div style="display:none" id="listaComplete">{$listaautocomplete}</div>*}
                {*</td>*}

            {*</tr>*}
            {**}
            {*<tr>*}
                {*<td >*}
                    {*<label for="antena">:: Antena ::</label>*}
                {*</td>*}
            {*</tr>*}
            {**}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena" >Marca </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena" class="inputReq autosave_agenda_instal" >*}
                        {*<option value='patriot' {if $obj.antena == 'patriot'} selected {/if}>Patriot</option>*}
                        {*<option value='skyware' {if $obj.antena == 'skyware'} selected {/if}> Skyware</option>*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena_tam">Tamanho </label>*}
                {*</td>*}
                {*<td>*}
                    {*<select name="antena_tam" class="inputReq autosave_agenda_instal" >*}
                        {*<option value='1.2m' {if $obj.antena_tam == '1.2m'} selected {/if}>1.2m</option>*}
                        {*<option value='1.8m' {if $obj.antena_tam == '1.8m'} selected {/if}>1.8m</option>*}
                    {*</select>*}
                {*</td>*}

            {*</tr>*}

            {*<tr>    *}
                {*<td>*}
                    {*<label for="antena_ns">N° Série </label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="text" name="antena_ns" id="antena_ns" size="30" class="inputReq autosave_agenda_instal" value="{$obj.antena_ns}"/>*}
                {*</td>*}

            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="observacoes">Observações </label>*}
                {*</td>*}
                {*<td>*}
                    {*<textarea class="autosave_agenda_instal" id="observacoes" name="observacoes" rows="7" cols="40">{$obj.observacoes}</textarea>*}
                {*</td>*}
            {*</tr>*}
        {*</table>*}
                 {*<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>*}
     {*</fieldset>       *}
     {*<br />*}
    {*<center><input type="button" value="Gravar Agendamento" onClick="javascript:sendPost('AgendaInstal/edit','fAgEdit')" /></center>*}
{*</form>*}
{*</center>*}
<div class="container1">
    <div class="row">
        {include file="equipamento/submenu.tpl" title=submenu}
    </div>
</div>
<br>

<div class="container" style="width: 40%;">
    <form action="Equipamento/edit" method="PostT" id="FobjCreate" class="form" >
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Equipamento</div>
        </div>
        <div class="panel-body" style="padding: 0px; margin: 0px;">
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <label for="nome">Número de Série</label>
                        </td>
                        <td>
                            {$obj.sno}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mac">MAC</label>
                        </td>
                        <td>
                            {$obj.mac}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mac">Observações</label>
                        </td>
                        <td>
                            {$obj.observacoes}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mac">Status</label>
                        </td>
                        <td>
                            {$obj.status}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mac">Tipo do equipamento</label>
                        </td>
                        <td>
                            {$obj.nome_tipo_equipamento}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mac">Vsat</label>
                        </td>
                        <td>
                            {if isset($obj.local.idinstalacoes)}
                                {$obj.local.nome}
                            {/if}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div class="form-group col-md-12 text-center">
                    <button type="button" class="btn btn-primary"
                           onClick="javascript:
                                   getAjaxForm('Equipamento/edit',false,{ldelim}param:{$obj.idequipamentos},ajax:1{rdelim})
                                   "
                    >Editar Equipamento</button>

                    <button type="button" class="btn btn-danger"
                           onClick="javascript:
                                   if(confirm('Realmente deseja Apagar esse Equipamento?')){ldelim}
                                   $.ajax({ldelim}
                                   url:'Equipamento/apaga',
                                   type:'POST',
                                   data:{ldelim}idequipamentos:{$obj.idequipamentos}{rdelim},
                                   success: function(resposta){ldelim}
                                   if( resposta == 'ok' ){ldelim}
                                   alert('Equipamento apagado com sucesso!');
                           {rdelim}else{ldelim}
                                   alert('Erro ao apagar Equipamento.');
                           {rdelim}
                                   getAjaxForm('Equipamento/liste');
                           {rdelim}
                           {rdelim});
                           {rdelim}
                                   "
                    >Apagar Equipamento</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>


{*<center>*}

{*<form action="Equipamento/edit" method="PostT" id="FobjCreate" class="form" >*}
      {*<table class="tbForm">*}
             {**}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="nome">Número de Série</label>*}
                {*</td>*}
                {*<td>*}
                    {*{$obj.sno}*}
                {*</td>        *}
            {*</tr>    *}
             {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">MAC</label>*}
                {*</td>*}
                {*<td>*}
                   {*{$obj.mac}*}
                {*</td>        *}
            {*</tr>*}
             {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">Observações</label>*}
                {*</td>*}
                {*<td>*}
                   {*{$obj.observacoes}*}
                {*</td>        *}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">Status</label>*}
                {*</td>*}
                {*<td>*}
                    {*{$obj.status}*}
                {*</td>        *}
            {*</tr> *}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">Tipo do equipamento</label>*}
                {*</td>*}
                {*<td>*}
                   {*{$obj.nome_tipo_equipamento}*}
                {*</td>        *}
            {*</tr>*}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="mac">Vsat</label>*}
                {*</td>*}
                {*<td>*}
                	{*{if isset($obj.local.idinstalacoes)}*}
                   		{*{$obj.local.nome}*}
                   	{*{/if}*}
                {*</td>        *}
            {*</tr>            *}
        {*</table>*}
    {*{if $login.perfis_idperfis != 3}*}
        {**}
        {*<center>*}
            {*<input type="button" *}
            	{*value="Editar Equipamento"*}
            	{*class="btn" *}
            	{*onClick="javascript:*}
                		{*getAjaxForm('Equipamento/edit',false,{ldelim}param:{$obj.idequipamentos},ajax:1{rdelim})*}
                {*" *}
            {*/>*}
            {*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*}
            {*<input type="button" *}
            	{*value="Apagar Equipamento"*}
            	{*class="btn btn-danger" *}
            	{*onClick="javascript:*}
                	{*if(confirm('Realmente deseja Apagar esse Equipamento?')){ldelim}*}
            			{*$.ajax({ldelim}*}
            				{*url:'Equipamento/apaga',*}
                			{*type:'POST',*}
                			{*data:{ldelim}idequipamentos:{$obj.idequipamentos}{rdelim},*}
                			{*success: function(resposta){ldelim}*}
                				{*if( resposta == 'ok' ){ldelim}*}
                					{*alert('Equipamento apagado com sucesso!');*}
                				{*{rdelim}else{ldelim}*}
                					{*alert('Erro ao apagar Equipamento.');*}
                				{*{rdelim}*}
                				{*getAjaxForm('Equipamento/liste');*}
                			{*{rdelim}*}
            			{*{rdelim});*}
        			{*{rdelim}*}
                {*" *}
            {*/>*}
        {*</center>*}
    {*{/if}    *}
{*</form>*}
{*</center>*}
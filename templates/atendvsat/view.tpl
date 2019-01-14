<div class="container1" style="width:70%;">
    <form action="AgendaInstal/create" method="POST" id="fAtEdit" class="form" >
        <input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$obj.idatend_vsat}"/>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center"> Atualizar Atendimentos</div>
            </div>
            <div class="panel-body"style="padding: 0px; margin-top: 0px;">
                <table border="1" class="table table-bordered">

                    <tr><td colspan="3">
                            <button type="button" class="btn btn-success" onclick="javascript:getAjaxForm('AtendVsat/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})">
                                Editar Atendimento
                            </button>
                        </td></tr>

                    <tr>
                        <td><b>Status do Atendimento:</b></td>
                        <td>
                            {if $obj.status_atend_idstatus_atend == 1}Aberto{/if}
                            {if $obj.status_atend_idstatus_atend == 2}Em Atendimento{/if}
                            {if $obj.status_atend_idstatus_atend == 3}Finalizado{/if}
                        </td>
                    </tr>

                    <tr>
                        <td><b>Motivo:</b></td>
                        <td>
                            <table>
                                {foreach from=$motivosJaPresentes item=motivoJaPresente}
                                    <tr>
                                        <td>{$motivoJaPresente.tipo_motivo_str}</td>
                                        <td>{$motivoJaPresente.motivo_str}</td>
                                    </tr>
                                {/foreach}
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Atendimentos:</b></td>
                        <td>{$obj.atendimento}</td>
                    </tr>

                </table>
            </div>
        </div>
</div>


{*<center>*}
{*<form action="AgendaInstal/create" method="POST" id="fAtEdit" class="form" >*}
    {*<input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$obj.idatend_vsat}"/>*}
    {**}
    {*<fieldset>*}
		    {*<div id="topDadosInstal" align="left">*}
		    	{*<table class="tableDados">*}
		    		{*<tr>*}
		    			{*<td><label><b><font color="#ffffff" size="2.9">&nbsp; Atualizar Atendimentos</B></font></b></label></td>*}
		    		{*</tr>*}
		    	{*</table>*}
		    {*</div>*}
    {**}
    {*<div class="incContener">*}
    	{*<div class="dadoIncidente" >*}
        {**}
        {*<table border="1" class="incTable incTable1">*}
			{**}
			{*<tr><td colspan="3">*}
            	{*<input type="button" value="Editar Atendimento" onclick="javascript:getAjaxForm('AtendVsat/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})" />*}
            {*</td></tr>*}
            {**}
            {*<tr>    *}
                {*<td><b>Status do Atendimento:</b></td>*}
                {*<td>*}
                    {*{if $obj.status_atend_idstatus_atend == 1}Aberto{/if}*}
                    {*{if $obj.status_atend_idstatus_atend == 2}Em Atendimento{/if}*}
                    {*{if $obj.status_atend_idstatus_atend == 3}Finalizado{/if}*}
                {*</td>        *}
            {*</tr>*}
            {**}
            {*<tr>*}
            	{*<td><b>Motivo:</b></td>*}
            	{*<td>*}
            		{*<table>*}
            		{*{foreach from=$motivosJaPresentes item=motivoJaPresente}*}
			        {*<tr>*}
			        	{*<td>{$motivoJaPresente.tipo_motivo_str}</td>*}
			        	{*<td>{$motivoJaPresente.motivo_str}</td>*}
			        {*</tr>*}
		            {*{/foreach}*}
		            {*</table>*}
		        {*</td>*}
		    {*</tr>*}
             {**}
            {*<tr>    *}
                {*<td><b>Atendimentos:</b></td>*}
                {*<td>{$obj.atendimento}</td>        *}
            {*</tr>*}
                    {**}
        {*</table>*}
        {**}
    {*</div>*}
    {*</div>*}
    {**}
    {*</fieldset>       *}
    {**}
    {*<br />*}
    {**}
    {*<!-- *}
    	{*<center><input type="button" value="Atualizar" onClick="javascript:sendPost('AtendVsat/edit','fAtEdit')" /></center>*}
    {*-->*}
{*</form>*}
{*</center>*}
<center xmlns="http://www.w3.org/1999/html">
<form action="s_p/controller/AgendaInstal_sp/create" method="POST" id="fAtEdit" class="form" enctype="multipart/form-data">
    <input type="hidden" name="idatend_vsat" id="idatend_vsat" value="{$obj.idatend_vsat}"/>
    
    <fieldset>
		    <div id="topDadosInstal" align="left">
		    	<table class="tableDados">
		    		<tr>
		    			<td><label><b><font color="#ffffff" size="2.9">&nbsp; Atualizar Atendimento</B></font></b></label></td>    			
		    		</tr>
		    	</table>
		    </div>
    
    <div class="incContener">
    	<div class="dadoIncidente" >
            <table border="1" class="incTable incTable1">
                <tr><td colspan="3">
                        {if $obj.status_atend_idstatus_atend == 3}
                            {if $obj.perfil_atend == 4 || $obj.perfil_atend == 1 || $obj.perfil_atend == 5}
                                <input type="button" value="Continuar Atendimento" onclick="javascript:getAjaxForm('AtendVsat_sp/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})" />
                            {/if}
                        {else}
                                <input type="button" value="Continuar Atendimento" onclick="javascript:getAjaxForm('AtendVsat_sp/edit','divDinamico',{ldelim}param:{$obj.idatend_vsat},ajax:1{rdelim})" />

                        {/if}
                </td></tr>
                <tr>
                    <td>Aquivos</td>
                    <td>
                        {foreach from=$atendimentoArquivo item=atendArquivo}
                            <a target='_blank' href='upload/atend_arquivo_sp/{$atendArquivo.nome}' title="{$atendArquivo.nome}">
                                {assign var="widgets_ids" value="."|explode:$atendArquivo.nome}
                                    {if $widgets_ids[1] == 'pdf'}
                                        <img src="upload/atend_arquivo_sp/icon/file_extension_pdf.png">
                                    {elseif $widgets_ids[1] == 'jpeg'}
                                        <img src="upload/atend_arquivo_sp/icon/file_extension_jpeg.png">
                                    {elseif $widgets_ids[1] == 'jpg'}
                                        <img src="upload/atend_arquivo_sp/icon/file_extension_jpg.png">
                                    {elseif $widgets_ids[1] == 'png'}
                                        <img src="upload/atend_arquivo_sp/icon/file_extension_png.png">

                                    {/if}
                            </a>
                        {/foreach}
                    </td>
                </tr>
                {*<font style='color:#000;'>{$atendArquivo.nome}</font>*}
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
                    <td></td>
                </tr>
            </table>
        
        </div>

        <div class="borda1">
            <div class="borda2">
                <table border="0" width="100%">
                    <tr>
                        <td align="center" width="100%" bgcolor="white">
                            {$obj.atendimento}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </fieldset>
    
    <br />

</form>
</center>

{*<div class="atendmensagem">*}
    {*<table border="1" width="100%">*}
        {*<tr id="tr1">*}
            {*<td id="td1" align="center">*}
                {*<div id="atenddados">*}
                    {*<b>Celio Batalha</b>*}
                    {*</br>*}
                    {*<p>Analista de Sistema</p>*}
                    {*</br></br>*}
                {*</div>*}
            {*</td>*}
            {*<td >*}
                {*<div id="dadosmensagem">*}

                    {*Celio Pereira Batalha Filho, 19/10/2015 10:08:57*}

                    {*iniciado agora*}
                    {*Em Atendimento*}

                    {*Celio Pereira Batalha Filho, 19/10/2015 10:07:47*}

                    {*Novo Atendimento*}
                    {*Em Atendimento*}

                    {*Celio Pereira Batalha Filho, 19/10/2015 10:07:33*}

                    {*Novo atendiemento*}
                    {*Em Atendimento*}

                {*</div>*}
            {*</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td id="td1" height="30px">teste</td>*}
            {*<td>teste</td>*}
        {*</tr>*}
        {*<div id="publicado">*}
            {*&nbsp;&nbsp;Publicado em: 19/10/2015 10:06:58*}
        {*</div>*}
    {*</table>*}

{*</div>*}
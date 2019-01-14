<div class="container1" style="width: 70%;">
	<form action="AtendVsat/create" method="POST" id="fAgCreate" class="form" >
		<input type="hidden" name="incidentes_idincidentes" id="incidentes_idincidentes" value="{$param}"/>
		<input type="hidden" name="instalacoes_idinstalacoes" id="instalacoes_idinstalacoes" value="{$instalacoes_idinstalacoes}"/>
		<input type="hidden" name="data" id="data" value="{$dataAtual}"/>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title text-center">Realizar atendimento</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12">
						<input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios"/>
						<textarea  name="atendimento" id="atendimento" style="height:150px;" class="form-control inputReq" placeholder="Atendimento" ></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="status_atend_idstatus_atend">Status do Atendimento:</label>
						<select class="form-control" name="status_atend_idstatus_atend" id="status_atend_idstatus_atend">
							<option value='1'>Em Atendimento</option>
							<option value='2'>Finalizado</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="tipo_atendimento_idtipo_atendimento">Tipos de atendimento:</label>
						<div class="">
							<select class="form-control" name="tipo_atendimento_idtipo_atendimento" id="tipo_atendimento_idtipo_atendimento">
								{foreach from=$tipo_atendimento item=tipos}
									<option value="{$tipos.idtipo_atendimento}">{$tipos.tipo_atendimento}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<textarea class="form-control autosave_atendvsat" id="resposta_agilis" name="resposta_agilis" style="height:150px;" placeholder="Resposta do Agilis">{$obj.resposta_agilis}</textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<button type="button" class="btn btn-primary" value="Enviar"
							   onClick="javascript:
									   $.ajax({ldelim}
									   url:'AtendVsat/insert',
									   type:'POST',
									   data:{ldelim}form:$('#fAgCreate').serialize(){rdelim},
									   success:function(resposta){ldelim}
									   $('#respostaAjax').html(resposta);
									   $('#respostaAjax').css( 'display' , 'block' );
									   setTimeout( 'limpaAvisos()' , 5000 );
							   {rdelim}
							   {rdelim});
									   " >Enviar</button>
						<button type="button" class="btn" value="" onClick="javascript:
								getAjaxForm('AtendVsat/liste','divDinamico',{ldelim}param:{$param},ajax:1{rdelim})"
						>Cancelar</button>
					</div>
					<div class="form-group col-md-8">
						<div id="respostaAjax" style="display:none;"></div>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>

{*<center>*}
{*<form action="AtendVsat/create" method="POST" id="fAgCreate" class="form" >*}
    {*<input type="hidden" name="incidentes_idincidentes" id="incidentes_idincidentes" value="{$param}"/>*}
    {*<input type="hidden" name="instalacoes_idinstalacoes" id="instalacoes_idinstalacoes" value="{$instalacoes_idinstalacoes}"/>*}
    {*<input type="hidden" name="data" id="data" value="{$dataAtual}"/>*}
    {*<fieldset>*}
            {*<legend>Realizar atendimento</legend>*}
            {*<br />*}
    {*<div style="padding:5px;">*}
        {**}
        {*<table class="tbForm">*}
             {**}
            {*<tr>    *}
                {*<td>*}
                    {*<label for="atendimento">Atendimento</label>*}
                {*</td>*}
                {*<td>*}
                    {*<input type="hidden" value="{$login.idusuarios}" name="usuarios_idusuarios"/> *}
                    {*<textarea name="atendimento" id="atendimento" style="width:750px;height:200px;" class="inputReq" ></textarea>*}
                {*</td>        *}
            {*</tr>    *}
             {*<tr>    *}
                {*<td>*}
                    {*<label for="descricao">Status do Atendimento</label>*}
                {*</td>*}
                {*<td>*}
                	{*<div style="float:left;margin-right:50px;">*}
	                    {*<select name="status_atend_idstatus_atend" id="status_atend_idstatus_atend">*}
	                        {**}
	                        {*<option value='1'>Em Atendimento</option>*}
	                        {*<option value='2'>Finalizado</option>*}
	                        {**}
	                    {*</select>*}
	                {*</div>*}
	                {**}
	                {*<div style="float:left;margin-right:10px;">*}
	                	{*<label for="tipo_atendimento_idtipo_atendimento">Tipos de atendimento</label>*}
	                {*</div>*}
	                {*<div style="float:left">*}
	                	{*<select name="tipo_atendimento_idtipo_atendimento" id="tipo_atendimento_idtipo_atendimento">*}
	                		{*{foreach from=$tipo_atendimento item=tipos}*}
	                			{*<option value="{$tipos.idtipo_atendimento}">{$tipos.tipo_atendimento}</option>*}
	                		{*{/foreach}*}
	                	{*</select>	*}
	                {*</div>*}
                {*</td>        *}
            {*</tr>   *}
            {**}
            {*<tr>*}
            	{*<td>*}
            		{*<label for="resposta_agilis">Resposta Agilis</label>*}
            	{*</td>*}
            	{*<td>*}
            		{*<textarea id="resposta_agilis" name="resposta_agilis" style="width:750px;height:200px;"></textarea>*}
            	{*</td>*}
            {*</tr> *}
                    {**}
        {*</table>*}
         {*<div class="divObs"> * Campos marcados em vermelho são obrigatórios.</div>*}
         {*<div id="respostaAjax" style="display:none;"></div>*}
     {*</fieldset>       *}
    {*</div>*}
    {*<br />*}
    {*<center>*}
    	{*<input type="button" value="Enviar" *}
    		{*onClick="javascript:*}
        		{*$.ajax({ldelim}*}
					{*url:'AtendVsat/insert',*}
					{*type:'POST',*}
					{*data:{ldelim}form:$('#fAgCreate').serialize(){rdelim},*}
					{*success:function(resposta){ldelim}*}
						{*$('#respostaAjax').html(resposta);*}
						{*$('#respostaAjax').css( 'display' , 'block' );*}
						{*setTimeout( 'limpaAvisos()' , 5000 );*}
					{*{rdelim}*}
				{*{rdelim});*}
        	{*" />*}
    	{*&nbsp;&nbsp;&nbsp;*}
    	{*<input type="button" value="Cancelar" onClick="javascript:*}
				{*getAjaxForm('AtendVsat/liste','divDinamico',{ldelim}param:{$param},ajax:1{rdelim})"*}
		{*/>*}
    {*</center>*}
{*</form>*}
{*</center>*}
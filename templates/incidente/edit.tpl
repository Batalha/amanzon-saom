<div class="container1" style="margin-top: 0px; margin-left: 7%;">
	<div class="row">
		{include file="incidente/submenu.tpl" title=submenu}
	</div>
</div>



<div class="container1" style="margin-top: 10px; width: 85%;">
	<div class="row">
		<div class="form-group col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title text-center">Editar Incidente N° {$obj.idincidentes}</div>
				</div>
				<div class="panel-body">
					<form action="AgendaInstal/create" method="POST" id="fAgCreate" class="form" >
						<input type="hidden" name="idincidentes" id="idincidentes" value="{$obj.idincidentes}"/>
						<input type="hidden" name="saom" id="saom" value="{$obj.saom}"/>

						<div class="row">

							<div class="form-group col-md-6">
								<label for="data">Data</label>
								<div class="input-group">
									<input type="text" name="data" id="data" class="form-control" value="{$obj.data}" >
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="prioridade">Prioridade</label>
								<select name="prioridade" id="prioridade" class="form-control">
									<option value="Baixa" {if $obj.prioridade == "Baixa"} selected{/if}>Baixa</option>
									<option value="Media" {if $obj.prioridade == "Média"} selected{/if}>Media</option>
									<option value="Alta" {if $obj.prioridade == "Alta"} selected{/if}>Alta</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-6">
								<label for="tecnicoNoc">Tecnico</label>
									<select name="tecnicoNoc" id="tecnicoNoc" class="form-control">
									<option value="">Escolher</option>
									{foreach from=$listaUsuarios item=vez}
										{if $vez.ativacao == 1 && $vez.perfis_idperfis == 2}
											<option value="{$vez.idusuarios}" {if $vez.idusuarios eq $obj.tecnicoNoc}selected{/if}>{$vez.nome}</option>
										{/if}
									{/foreach}
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<textarea name="descricao" id="descricao" style="height: 100px;" class="form-control" placeholder="Descrição do Ticket">{$obj.descricao}</textarea>
							</div>
						</div>
						{*<div class="row">*}
							{*<div {if ($instalacao.nome)} onmouseover="javascript:verificaVsatSp()";{/if}></div>*}

						{*</div>*}
					</form>

					<div class="row">
						<div class="col-md-2" style="padding-bottom: 26px;">

							<input class="btn btn-primary" type="button" id="" value="Salvar"
								   onClick="javascript:
										$.ajax({ldelim}
										   url:'Incidente/update',
										   type:'POST',
										   data:{ldelim}form:$('#fAgCreate').serialize(){rdelim},
										   success:function(resposta){ldelim}

										   $('#respostaFormAjax').html(resposta);
										   $('#respostaFormAjax').css('display','block');
										   setTimeout( '$(\'#respostaFormAjax\').fadeOut()' , 4000 );
								   		{rdelim}
								   {rdelim});
										   //sendPost('Incidente/update','fAgCreate');
									"/>
							<input type="hidden" name="instVsat" id="instVsat" value="{$instalacao.nome}"/>
						</div>
						<div class="col-md-10">
							<span id="respostaFormAjax" class="alert alert-info" style="display:none;" ></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title text-center">Vsats Cadastrados</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-12">
							<a class="btn btn-primary" onclick="javascript:abreEscolhaIncidentes(); ">Cadastrar Nova Instalação</a>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							{$i=0}
							<table style="width: 100%;">
								<thead>
									<th><b>Id Prodemge</b></th>
									<th><b>Vsat's</b></th>
									<th class="text-center"><b>Açoes</b></th>
								</thead>

								<tbody>

								<tr>
									<td>
										<table  style="width: 100%;">
											<tbody>
											{foreach from=$obj.prodemge item=prod}
												<tr style="height: 30px; border-bottom: 1px solid #c0c0c0;"><td>{$prod.numero_prodemge}</td></tr>
											{/foreach}
											</tbody>
										</table>
									</td>
									<td>
										<table style="width: 100%;">
											<tbody>
											{foreach from=$obj.instalacoes item=instalacao}
												<tr style="height: 30px; border-bottom: 1px solid #c0c0c0;" ><td>{$instalacao.nome}</td></tr>
											{/foreach}
											</tbody>
										</table>
									</td>
									<td>
										<table style="width: 100%;">
											<tbody>
											{foreach from=$obj.instalacoes item=instalacao}
												<p hidden="">{$i}</p>
												<tr style="height: 30px; border-bottom: 1px solid #c0c0c0;">
													<td class="text-center">
														<a class="btn-danger btn-small"  onclick="javascript:
															if( confirm('Deseja retirar essa Instalação desse Incidente?') ){
																{ldelim}
																	$.ajax(
																	{ldelim}
																	url:'Incidente/RetiraAssociacaoComInstalacao',
																	type:'POST',
																	data:{ldelim}
																		nomeInstalacao:'{$instalacao.nome}',
																		idInstalacao:'{$instalacao.idinstalacoes}',
																		idincidentes:'{$obj.idincidentes}',
																		idProd:'{$obj.prodemge[$i++].idprodemge}'
																	{rdelim},
																		success:function( resposta )
																		{ldelim}
																			alert(resposta);
																			atualizaEditorIncidente( $('#idincidentes').val() );

																		{rdelim}
																	{rdelim});
																{rdelim}
															}
														">retirar</a>
													</td>
												</tr>
											{/foreach}
											</tbody>

										</table>
									</td>
								</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal hide fade" id="modalInstalacoes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Selecionar Instalação</h3>
	</div>

	<div class="modal-body">

		<div id="modalConteudo">

		</div>

	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>

{*<center>*}
{*{include file="incidente/submenu.tpl" title=submenu}*}

{*<div class="form">*}

   {*<form action="AgendaInstal/create" method="POST" id="fAgCreate" class="form" >*}
    {*<div {if ($instalacao.nome)} onmouseover="javascript:verificaVsat()";{/if}><br /><br /><br /></div>*}


	{*<input type="hidden" name="idincidentes" id="idincidentes" value="{$obj.idincidentes}"/>*}
    {*<input type="hidden" name="saom" id="saom" value="{$obj.saom}"/>*}
    {**}
	{*<div class="layoutCadOs" style="width: 780px; height: 375px;">*}
	    {*<b>Editar Incidente N° {$obj.idincidentes}</b>*}
  {**}
       {**}
        {*<table class="tbForm" border="0" >*}

	        {*<tr>*}
{*<!-- 	        	<td> -->*}
{*<!-- 	            	<label for="data">Data</label> -->*}
{*<!-- 	            </td> -->*}
	            {*<td width="20px">*}
	            	{*<input type="text" name="data" id="data" size="10" class="inputReq inputData autosave_incidentes" value="{$obj.data}"  />*}
	            {*</td>*}
   {**}
{*<!-- 	        	<td> -->*}
{*<!--	            	<label for="prioridade">Prioridade </label> -->*}
{*<!-- 	            </td> -->*}
	        	{*<td>*}
		        	{*<select name="prioridade" id="prioridae" class="inputReq autosave_incidentes">*}
		            	{*<option value="Baixa" {if $obj.prioridade == "Baixa"} selected{/if}>Baixa</option>*}
		            	{*<option value="Média" {if $obj.prioridade == "Média"} selected{/if}>Média</option>*}
		            	{*<option value="Alta" {if $obj.prioridade == "Alta"} selected{/if}>Alta</option>*}
		            {*</select> *}
			    {*</td>*}
{*<!-- 			    <td>     	 -->*}
{*<!-- 			        <label for="tecnicoNoc">Responsável</label> -->*}
{*<!-- 			    </td> -->*}
			   	{*<td>*}
			    	{*<select name="tecnicoNoc" class="inputReq autosave_incidentes">*}
			        	{*{foreach from=$listaUsuarios item=vez}*}
			        		{*{if $vez.ativacao == 1 && $vez.perfis_idperfis == 2}*}
			            	{*<option value="{$vez.idusuarios}" {if $vez.idusuarios eq $obj.tecnicoNoc}selected{/if}>{$vez.nome}</option>*}
			            	{*{/if}*}
			           	{*{/foreach}*}
			        {*</select>*}
			    {*</td>*}
	    	{*</tr>*}
	    	{*<tr>    *}
{*<!-- 	        	<td> -->*}
{*<!--	            	<label for="descricao">Problemas</label> -->*}
{*<!-- 	            </td> -->*}
	            {*<td colspan="5">*}
	            	{*<textarea name="descricao" id="descricao" style="width:730px;height:200px;resize:none;" class="inputReq autosave_incidentes" >{$obj.descricao}</textarea>*}
	            {*</td>        *}
	        {*</tr>*}
	        {**}
	    	 {*<tr>*}
{*<!-- 	        	<td> -->*}
{*<!-- 	            	<label for="data_fim">Data final</label> -->*}
{*<!-- 	            </td> -->*}
	        	{*<td colspan="5">*}
	            	{*<input name="data_fim" id="data_fim" alt="data_fim" placeholder="20/07/1969 13:32:00" class="inputData" type="text" value="{$data_fim}"/>   *}
		        {*</td>*}
	    	{*</tr>*}

        	{*<tr>*}
		        {*<td><a class="btn" onclick="javascript:abreEscolhaIncidentes(); ">Cadastrar Nova Instalação</a></td>*}
        	{*</tr>*}
        {*</table>*}
        {*</div>*}
        {*<table bordercolor="white"  border="1" style="width: 780px;" cellspacing="0" cellpadding="0">*}
     		{*<tr>*}
     			{*<td width="40%" bordercolor="white" class="colInstal"  style="padding: 5px;"><b>&nbsp;&nbsp; Id Prodemge</b>*}
     			{*</td><td class="colInstal"><b>&nbsp;&nbsp; Nome da Vsat </b></td>*}
       		{*</tr>*}
			{*<tr>*}
			    {*<td style="padding: 5px;" bgcolor="white">*}
			    	{*<table  style="width: 100%;">*}
				        {*{foreach from=$obj.prodemge item=prod}*}
				    		{*<tr class="{cycle values="black, blue"}"><td>&nbsp;&nbsp;&nbsp;{$prod.numero_prodemge}</td></tr>*}
				        {*{/foreach}*}
			    	{*</table>*}
                {*</td>*}
                {*<td style="padding: 5px;" bgcolor="white">*}
		            {*{$i=0}*}
		            {*<table style="width: 100%;">*}
                		{*{foreach from=$obj.instalacoes item=instalacao}*}
						{*<p hidden="">{$i}</p>*}
		            	{*<tr class="{cycle values="black, blue"}">*}
		            		{*<td>*}
                	    		{*&nbsp;&nbsp;&nbsp;{$instalacao.nome}*}
		            		{*</td>*}
		            		{*<td align="right">*}
	                	    		{*<a style="color:red;"   onclick="javascript:*}
                    	    		{*if( confirm('Deseja retirar essa Instalação desse Incidente?') ){*}
	                        	    	{*{ldelim}*}
		                    	    		{*$.ajax(*}
			    	                    	    {*{ldelim}*}
			                        	    		{*url:'Incidente/RetiraAssociacaoComInstalacao',*}
			                        	    		{*type:'POST',*}
			                        	    		{*data:{ldelim}*}
		                        	    				{*nomeInstalacao:'{$instalacao.nome}', *}
		                        	    				{*idInstalacao:'{$instalacao.idinstalacoes}',*}
		                        	    				{*idincidentes:'{$obj.idincidentes}',*}
			                        	    			{*idProd:'{$obj.prodemge[$i++].idprodemge}'*}
			                        	    		{*{rdelim},*}
			                        	    		{*success:function( resposta )*}
			                        	    		{*{ldelim}*}
			                        	    			{*alert(resposta);*}
			                        	    			{*atualizaEditorIncidente( $('#idincidentes').val() );*}
				  	                    	    		{**}
			                        	    		{*{rdelim}*}
			                        	    	{*{rdelim}*}
		                        	    	{*);*}
	                    	    		{*{rdelim}*}
                    	    		{*}*}
                    	    		{*">[retirar]*}
			                    	{*</a>&nbsp;&nbsp;		            		*}
		            		{*</td>*}
		            		{**}
		            	{*</tr>*}
		            	{*{/foreach}*}
		            {*</table>*}
               {*</td>*}

        	{*</tr>*}
    	{*</table>*}
	{*</form>*}
           {**}

	{*</div>*}

	{*<center>*}
		{*<div {if (!$instalacao.nome)} onmouseover="javascript:verificaVsat()";{/if}> *}
		{** Campos marcados em vermelho são obrigatórios.</div>*}
		{*<br>*}
		{**}
		{*<span id="respostaFormAjax" class="alert alert-block" style="display:none;" ></span>*}
		{*<input type="button" id="" value="Salvar" *}
			{*onClick="javascript:*}
				{*$.ajax({ldelim}*}
					{*url:'Incidente/update',*}
					{*type:'POST',*}
					{*data:{ldelim}form:$('#fAgCreate').serialize(){rdelim},*}
					{*success:function(resposta){ldelim}*}

						{*$('#respostaFormAjax').html(resposta);*}
						{*$('#respostaFormAjax').css('display','block');*}
						{*setTimeout( '$(\'#respostaFormAjax\').fadeOut()' , 4000 );*}
						{**}
					{*{rdelim}*}
				{*{rdelim});*}
				{*//sendPost('Incidente/update','fAgCreate');*}
			{*" />*}
			 {*<input type="hidden" name="instVsat" id="instVsat" value="{$instalacao.nome}"/>*}
			{**}
	{*</center>*}
	{*</fieldset>*}
{*</div>*}
{*</div>*}
{*</center>*}

{*<!-- MODAL -->*}
{*<div class="modal hide fade" id="modalInstalacoes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">*}
	{*<div class="modal-header">*}
		{*<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>*}
		{*<h3 id="myModalLabel">Selecionar Instalação</h3>*}
	{*</div>*}
	{**}
	{*<div class="modal-body">*}
		{**}
		{*<div id="modalConteudo">*}
			{**}
		{*</div>*}
		{**}
	{*</div>*}
	{**}
	{*<div class="modal-footer">*}
		{*<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>*}
	{*</div>*}
{*</div>*}


<center>

	<div id="lista_compartilhamento" class="lista_compartilhamento">
		<table class='table'>
		
		<tr><td colspan='4'>Total de Arquivos: {$contagem}</td></tr>
		
		<tr>
			<th>ID</th>
			<th>Arquivo</a></th>
			<th>Dt de Envio</th>
			<th>Opções</th>
		</tr>
		
		<tr class="filtros">
			<th style="width:15px;">&nbsp;</th>
			<th style="width:300px;">
				<input 
					name="endereco" 
					id="endereco" 
					type="text" 
					style="width:100%;" 
					onkeypress="javascript:submitBuscaCompartilhamento( event )"
					value="{if isset($endereco)}{$endereco}{/if}"
				/>
			</th>
			<th style="width:100px;">
				<input 
					name="data_envio" 
					id="data_envio" 
					type="text"
					style="width:100%;" 
					onkeypress="javascript:submitBuscaCompartilhamento( event )"
					value="{if isset($data_envio)}{$data_envio}{/if}"
				/>
			</th>
			<th style="width:66px;">&nbsp;</th>
		</tr>
		
		{foreach from=$lista item=item key=k}
			<tr>
				<td style="text-align:left;">{$item.idcompartilhamento}</td>
				<td style="text-align:left;">
					<a target="_blank" href="{$item.endereco}">{$item.nome}</a>
				</td>
				<td>
					{$item.data_envio}
				</td>
				<td style="text-align:right;">
					<a 
						href="#" 
						onclick="javascript:
								if(confirm('Deseja realmente apagar esse arquivo?'))
								{ldelim}
									$('#idcompartilhamento').val({$item.idcompartilhamento})
									.ready(function(){
										$('#modal').modal('show');
									});
								{rdelim}
						"
						title="Apagar"
					><i class="icon-remove"></i></a>
				</td>
			</tr>
		{/foreach}
		
		</table>
		<div class="cleaner">&nbsp;</div>
		
		<!-- MODAL -->
			<div class="modal hide" id="modal">
            	<form action="Usuario/verificaAutorizacaoCompartilhamento" onsubmit="return false" method="post" name="identificacao_permissao_usuario" id="identificacao_permissao_usuario">
            		<input name="idcompartilhamento" id="idcompartilhamento" type="hidden" value="" />
            		<input name="idusuarios" id="idusuarios" type="hidden" value="{$login.idusuarios}"/>
            		
				  	<div class="modal-header">
				    	<a class="close" data-dismiss="modal">×</a>
				    	<h3>Confirme sua senha</h3>
				  	</div>
				  	
				  	<div class="modal-body">
				    	<div class="span6">
				    		<div class="span2">Senha:</div>
				    		<div class="span2">
				    			<input 
				    				name="senha" 
				    				id="senha" 
				    				type="password"
				    				value=""
				    				onkeyup="javascript:
					    				if(event.keyCode=='13'){
						    				sendPost('Usuario/verificaAutorizacaoCompartilhamento','identificacao_permissao_usuario');
						    				$('#modal').modal('hide');
						    			}
				    				" 
				    			/>
				    		</div>
				    	</div>
				    	<div style="clear:both"></div>
				  	</div>
				  	
				  	<div class="modal-footer">
				    	<a href="#" class="btn" data-dismiss="modal">Fechar</a>
				    	<a 
				    		href="#" 
				    		class="btn btn-primary" 
				    		onclick="javascript:sendPost('Usuario/verificaAutorizacaoCompartilhamento','identificacao_permissao_usuario')"
				    	>Enviar</a>
				  	</div>
				  	
				</form>
			</div>
		<!-- MODAL - FIM -->
	
	</div>
	
</center>
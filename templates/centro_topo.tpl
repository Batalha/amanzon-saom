	
	{if isset($login) && ($login.perfis_idperfis==6)}
		<div class="well" 
			style="
				width:150px;
				margin-left:-30px;
			"
		>
			<img src="public/imagens/telefonica_logo.fw.png" />
		</div>
	{else}
		<div class="well" style="width:190px;">
			<a href="/{$trocarSistema}" title="Mudar de Sistema" >
	    		<span style="float:left;margin-right:10px;" class="label"><i class="icon-retweet"></i></span>
	    		<h3 style="float:left;">{($SAOM == 'SP')?'São Paulo':'Prodemge'}</h3>
	    	</a>
	    	<div style="clear:both"></div>
	    </div>
	{/if}
	
<div style="width:1020px;margin:0 auto;">

	{if $login.perfis_idperfis != 8 && $login.perfis_idperfis != 9 && $login.perfis_idperfis != 10}
		
		{if $empresa == '1'}
		
			{include file="home/lista_comissionamentos.tpl" title=lista_comissionamentos}
			
			{include file="home/lista_atendimentos.tpl" title=lista_comissionamentos}
		
		{/if}
	    
	    <!-- {include file="home/acesso_rapido.tpl" title=acesso_rapido} -->
	    
	{/if}
    
</div>
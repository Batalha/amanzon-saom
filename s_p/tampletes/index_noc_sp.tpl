<div style="width:1020px;margin:0 auto;">

	{if $login.perfis_idperfis != 8 && $login.perfis_idperfis != 9 && $login.perfis_idperfis != 10}
		
		{if $empresa == '1'}
		
			{include file="s_p/tampletes/home/lista_comissionamentos.tpl" title=lista_comissionamentos}
			
			{include file="s_p/tampletes/home/lista_atendimentos.tpl" title=lista_comissionamentos}
		
		{/if}
	    
	    <!-- {include file="s_p/tampletes/home/acesso_rapido.tpl" title=acesso_rapido} -->
	    
	{/if}
    
</div>
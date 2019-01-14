
{if isset($listaIncidentes)}
	
	{foreach from=$listaIncidentes item=incidente}
	
		<b>Incidente {$incidente.idincidentes}</b><br/>
		
		{if count($incidente.atendimentos.motivo) > 0}
		
			{foreach from=$incidente.atendimentos.motivo item=motivo}
				&nbsp;&nbsp;-{$motivo.motivo}<br/>
			{/foreach}
		
		{else}
			
			&nbsp;&nbsp;Nenhum motivo listado.<br/>
		
		{/if}
		
	{/foreach}
	
{else}
	{$msg}
{/if}
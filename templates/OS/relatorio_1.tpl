
	{$campos}
	{foreach from=$arr item=os}
    {$os.rel.municipios_idcidade.municipio};{$os.identificador};{$os.dataSolicitacao};LOTE7;{$os.velDownload};SES;{$os.prazoInstal};{$os.rel.agenda_instal.observacoes};{if $os.rel.agenda_instal}Projetado;{else}Aceito;{/if}{$os.rel.instalacoes.data_aceite};{$os.enderecoInstal}
    {/foreach}

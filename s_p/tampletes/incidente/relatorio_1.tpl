{$campos}
{foreach from=$arr item=incidente}
{$incidente.idincidentes};{$incidente.data};{$incidente.data_modificacao};{$incidente.nome};{$incidente.empresa};{$incidente.nomeSolicitacao};{$incidente.nomeTipo};{$incidente.nomeTeste};{$incidente.descricao};{$incidente.ordem};{$incidente.motivo};{$incidente.status};{$incidente.avaliacao}
{/foreach}
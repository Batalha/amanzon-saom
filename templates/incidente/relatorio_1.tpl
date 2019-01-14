{$campos}
{foreach from=$arr item=incidente}
{$incidente.idincidentes};{$incidente.vsatNome};{$incidente.data};{$incidente.prioridade};{$incidente.descricao};{$incidente.atendimentos};{$incidente.idprodemge};{$incidente.statusAtendimento};{$incidente.nomeTecnico};{$incidente.responsavel};{$incidente.motivo}
{/foreach}

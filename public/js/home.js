
function abreComissionamentoPendente( idos , idinstalacoes )
{
	var controle = new controleGridNoc();
	getAjaxForm('OS/view','conteudo',{param:idos,ajax:1},controle.chamaComissionamento(idinstalacoes));
}
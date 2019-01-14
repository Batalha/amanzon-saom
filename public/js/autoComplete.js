/**
 * 
 * Instalacao/busca -> exemplo de 'endereco'
 * localVerificaExistencia -> local que verifica a existencia do campo atual
 * 
 */

	/* para atualizar outro campo */
	function atualiza_odu(endereco)
	{
		$("#autocomplete").html("");
		$("#autocomplete").css("display","none");
		
		var nsodu = $('#nsodu_comiss').val();

		$.post(endereco,{nsodu:nsodu},function(data)
		{
			var _elemento = document.getElementById("odu");
			for ( i =0 ; i < _elemento.length ; i++ )
	        {
	        	_elemento[i].selected = _elemento[i].value == data ? true : false;
	        }
		});
	}
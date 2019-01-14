/**
 * 
 */

// para contagem de incidente
	var cronometroIncidente;
	var days = 0;
	var hor;
	var min;
	var seg;
	var local;

function retiraCronometros()
{
	clearInterval( cronometroIncidente );// limpa contagem de incidente
}
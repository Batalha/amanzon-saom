function mudar_cor_over(celula){
   celula.style.backgroundColor="#CBCCFC";
}
function mudar_cor_out(celula){
   celula.style.backgroundColor= "";
}


function bgOver(id){
	try{ document.getElementById(id).style.backgroundColor="#cddcf1"; }catch(e){}
}
function bgOut(id){
	try{ document.getElementById(id).style.backgroundColor=""; }catch(e){}
}


function SoNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla > 47 && tecla < 58) || (tecla == 9)) return true;
    else{
    	if (tecla != 8) return false;
    	else return true;
    }

    if((tecla == 9)) return true;
}



function Mask( obj, mask ) {
	obj.value = mask(obj.value);
}

function telefone(v){
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
	v=v.replace(/(\d{4})(\d)/,"$1-$2") //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
	return v
}

function celular(v){
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
	v=v.replace(/(\d{5})(\d)/,"$1-$2") //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
	return v
}

function cpf(v){
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{3})(\d)/,"$1.$2") //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
	v=v.replace(/(\d{3})(\d)/,"$1.$2") //Coloca um ponto entre o terceiro e o quarto dÃ­gitos

	//de novo (para o segundo bloco de nÃºmeros)
	v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hÃ­fen entre o terceiro e o quarto dÃ­gitos
	return v
}

function time(v){
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{2})(\d)/,"$1:$2") //Coloca dois ponto entre o segundo e o terceiro dÃ­gitos
	return v
}

function peso(v){
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{2})(\d)/,"$1.$2") //Coloca um ponto entre o segundo e o terceiro dÃ­gitos
	return v
}

function altura(v){

	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{1})(\d)/,"$1.$2") //Coloca um ponto entre o primeiro e o segundo dÃ­gitos
	return v
}

function medidas(v){
	var x = v.length;
	v=v.replace(/\D/g,"") // Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{1})(\d)/,"$1.$2") // Coloca um ponto entre o primeiro e o segundo dÃ­gitos
	if(x == 4){	
		v=v.replace(",",'');
		for(var i=0; i<=v; i++){ 
			v=v.replace(/\D/g,"") // Remove tudo o que nÃ£o Ã© dÃ­gito
			v=v.replace(/(\d{2})(\d)/,"$1.$2") // Coloca um ponto entre o primeiro e o segundo dÃ­gitos
		}								
	}
	if(x==5){
		v=v.replace(",",'');
		for(var i=0; i<=v; i++){ 
			v=v.replace(/\D/g,"") // Remove tudo o que nÃ£o Ã© dÃ­gito
			v=v.replace(/(\d{3})(\d)/,"$1.$2") // Coloca um ponto entre o  primeiro e o segundo dÃ­gitos
		}
	}
	return v
}


function cep(v){
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hÃ­fen entre o terceiro e o quarto dÃ­gitos
	return v
}


function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){  
    var sep = 0;  
    var key = '';  
    var i = j = 0;  
    var len = len2 = 0;  
    var strCheck = '0123456789';  
    var aux = aux2 = '';  
    var whichCode = (window.Event) ? e.which : e.keyCode;  
    if (whichCode == 13) return true;  
    key = String.fromCharCode(whichCode); // Valor para o código da Chave  
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida  
    len = objTextBox.value.length;  
    for(i = 0; i < len; i++)  
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;  
    aux = '';  
    for(; i < len; i++)  
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);  
    aux += key;  
    len = aux.length;  
    if (len == 0) objTextBox.value = '';  
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;  
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;  
    if (len > 2) {  
        aux2 = '';  
        for (j = 0, i = len - 3; i >= 0; i--) {  
            if (j == 3) {  
                aux2 += SeparadorMilesimo;  
                j = 0;  
            }  
            aux2 += aux.charAt(i);  
            j++;  
        }  
        objTextBox.value = '';  
        len2 = aux2.length;  
        for (i = len2 - 1; i >= 0; i--)  
        objTextBox.value += aux2.charAt(i);  
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);  
    }  
    return false;  
} 

function data(v)
{
	v=v.replace(/\D/g,"") //Remove tudo o que nÃ£o Ã© dÃ­gito
	v=v.replace(/(\d{2})(\d)/,"$1/$2") //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
	v=v.replace(/(\d{2})(\d)/,"$1/$2") //Coloca um ponto entre o terceiro e o quarto dÃ­gitos

	return v
}

function cnpj(v) {
    v=v.replace(/\D/g,"")                           //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dÃ­gitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dÃ­gitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dÃ­gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hÃ­fen depois do bloco de quatro dÃ­gitos
    return v;
}

function toMaiusculo(src) {
	src.value = src.value.toUpperCase();
}

function toMinusculo(src) {
	src.value = src.value.toLowerCase();
}

function Mascara(e,src,mask) {
    if(window.event) { _TXT = e.keyCode; }
    else if(e.which) { _TXT = e.which; }
    if(_TXT > 47 && _TXT < 58) {
 var i = src.value.length; var saida = mask.substring(0,1); var texto = mask.substring(i)
 if (texto.substring(0,1) != saida) { src.value += texto.substring(0,1); }
    return true; } else { if (_TXT != 8) { return false; }
 else { return true; }
    }
}

/*
Tecla: left arrow (seta esquerda) Código: » 37

Tecla: up arrow (seta pra cima) Código: » 38

Tecla: right arrow (seta direita) Código: » 39

Tecla: down arrow(seta pra baixo) Código: » 40
Tecla: backspace Código: » 8
Tecla: delete Código: » 46
*/

function LimparFormulario(form){

	try{ 		var campos = document.forms[form].getElementsByTagName('input');
	}catch(er){ var campos = 0; }
     for (var x = 0; x < campos.length; x++){
     	if( campos[x].type == "text"	){ campos[x].value= "";			campos[x].checked= false; campos[x].checked= false;	}
     	if( campos[x].type == "hidden"	){ campos[x].value= "";			campos[x].checked= false; campos[x].checked= false;	}
     	if( campos[x].type == "checkbox"){ campos[x].checked = false ; 	}
     	if( campos[x].type == "select"	){ campos[x].selectedIndex= 0; 	}
     }

	try{ 		var campos = document.forms[form].getElementsByTagName('select');
	}catch(er){ var campos = 0; }
     for (var x = 0; x < campos.length; x++){
     	campos[x].selectedIndex= 0;
     	campos[x].checked  = false;
     	campos[x].disabled = false;
     }
}


function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    if (whichCode == 8) return true;
    if (whichCode == 46) return true;

    key = String.fromCharCode(whichCode); // Valor para o codigo da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave invalida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}





//FUNÇÕES INCLUIDAS PARA FORMATAR PONTUAÇÃO DE PROCEDIMENTOS
function formatamoney(c) {  
    var t = this; if(c == undefined) c = 2;        
    var p, d = (t=t.split("."))[1].substr(0, c);  
    for(p = (t=t[0]).length; (p-=3) >= 1;) {  
           t = t.substr(0,p) + "." + t.substr(p);  
    }  
    return t+"."+d+Array(c+1-d.length).join(0);  
}  

String.prototype.formatCurrency=formatamoney  


function demaskvalue(valor, currency){  
	/* 
	* Se currency é false, retorna o valor sem apenas com os números. Se é true, os dois últimos caracteres são considerados as  
	* casas decimais 
	*/  
	var val2 = '';  
	var strCheck = '0123456789';  
	var len = valor.length;  
	   if (len== 0){  
	      return 0.00;  
	   }  
	  
	   if (currency ==true){     
	      /* Elimina os zeros à esquerda  
	      * a variável  <i> passa a ser a localização do primeiro caractere após os zeros e  
	      * val2 contém os caracteres (descontando os zeros à esquerda) 
	      */  
	        
	      for(var i = 0; i < len; i++)  
	         if ((valor.charAt(i) != '0') && (valor.charAt(i) != '.')) break;  
	        
	      for(; i < len; i++){  
	         if (strCheck.indexOf(valor.charAt(i))!=-1) val2+= valor.charAt(i);  
	      }  
	  
	      if(val2.length==0) return "0.00";  
	      if (val2.length==1)return "0.0" + val2;  
	      if (val2.length==2)return "0." + val2;  
	        
	      var parte1 = val2.substring(0,val2.length-2);  
	      var parte2 = val2.substring(val2.length-2);  
	      var returnvalue = parte1 + "." + parte2;  
	      return returnvalue;  
	        
	   }  
	   else{  
	         /* currency é false: retornamos os valores COM os zeros à esquerda,  
	         * sem considerar os últimos 2 algarismos como casas decimais  
	         */  
	         val3 ="";  
	         for(var k=0; k < len; k++){  
	            if (strCheck.indexOf(valor.charAt(k))!=-1) val3+= valor.charAt(k);  
	         }           
	   return val3;  
	   }  
	}  



function reais(obj,event){  
	  
	var whichCode = (window.Event) ? event.which : event.keyCode;  
	/* 
	Executa a formatação após o backspace nos navegadores !document.all 
	*/  
	if (whichCode == 8 && !documentall) {     
	/* 
	Previne a ação padrão nos navegadores 
	*/  
	   if (event.preventDefault){ //standart browsers  
	         event.preventDefault();  
	      }else{ // internet explorer  
	         event.returnValue = false;  
	   }  
	   var valor = obj.value;  
	   var x = valor.substring(0,valor.length-1);  
	   obj.value= demaskvalue(x,true).formatCurrency();  
	   return false;  
	}  
	/* 
	Executa o Formata Reais e faz o format currency novamente após o backspace 
	*/  
	FormataReais(obj,'.','.',event);  
	} // end reais  
	  


function FormataReais(fld, milSep, decSep, e) {  
	var sep = 0;  
	var key = '';  
	var i = j = 0;  
	var len = len2 = 0;  
	var strCheck = '0123456789';  
	var aux = aux2 = '';  
	var whichCode = (window.Event) ? e.which : e.keyCode;  
	  
	//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown  
	if (whichCode == 0 ) return true;  
	if (whichCode == 9 ) return true; //tecla tab  
	if (whichCode == 13) return true; //tecla enter  
	if (whichCode == 16) return true; //shift internet explorer  
	if (whichCode == 17) return true; //control no internet explorer  
	if (whichCode == 27 ) return true; //tecla esc  
	if (whichCode == 34 ) return true; //tecla end  
	if (whichCode == 35 ) return true;//tecla end  
	if (whichCode == 36 ) return true; //tecla home  
	  
	/* 
	O trecho abaixo previne a ação padrão nos navegadores. Não estamos inserindo o caractere normalmente, mas via script 
	*/  
	  
	if (e.preventDefault){ //standart browsers  
	      e.preventDefault()  
	   }else{ // internet explorer  
	      e.returnValue = false  
	}  
	  
	var key = String.fromCharCode(whichCode);  // Valor para o código da Chave  
	if (strCheck.indexOf(key) == -1) return false;  // Chave inválida  
	  
	/* 
	Concatenamos ao value o keycode de key, se esse for um número 
	*/  
	fld.value += key;  
	  
	var len = fld.value.length;  
	var bodeaux = demaskvalue(fld.value,true).formatCurrency();  
	fld.value=bodeaux;  
	  
	/* 
	Essa parte da função tão somente move o cursor para o final no opera. Atualmente não existe como movê-lo no konqueror. 
	*/  
	  if (fld.createTextRange) {  
	    var range = fld.createTextRange();  
	    range.collapse(false);  
	    range.select();  
	  }  
	  else if (fld.setSelectionRange) {  
	    fld.focus();  
	    var length = fld.value.length;  
	    fld.setSelectionRange(length, length);  
	  }  
	  return false;  
	  
	}  
//FIM - FUNÇÕES INCLUIDAS PARA FORMATAR PONTUAÇÃO DE PROCEDIMENTOS



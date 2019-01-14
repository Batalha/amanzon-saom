function escolhaCampo(valor){
    var vez1 = document.getElementById(valor);
//		alert(valor);
    vez1.value='';

}

function voltaCampo(valor){
    var vez1 = document.getElementById(valor).value;
    if(vez1 == ''){
        return document.getElementById(valor).value ='Usuario';
    }else{
        return false;
    }

}function voltaCampoSenha(valor){
    var vez1 = document.getElementById(valor).value;
    if(vez1 == ''){
        return document.getElementById(valor).value ='Senha';
    }else{
        return false;
    }

}

function verificaCamposCliente(){
    var empresas_idempresas = $('#empresas_idempresas').val();
    var cnpjFaturamentto = $('#cnpjFaturamentto').val();
    var contatoFaturamentto = $('#contatoFaturamentto').val();
    var enderecoFaturamentto = $('#enderecoFaturamentto').val();
    var paisFaturamento = $('#paisFaturamento').val();
    var cidadeFaturamento = $('#cidadeFaturamento').val();
    var estadoFaturamento = $('#estadoFaturamento').val();
    var cepFaturamento = $('#estadoFaturamento').val();
    var emailFaturamento = $('#emailFaturamento').val();

    if(empresas_idempresas == ''){
        $("#errorEmpresa").addClass("has-error");
    }else if(cnpjFaturamentto == ''){
        $("#errorCnpj").addClass("has-error");
    }else if(contatoFaturamentto == ''){
        $("#errorContato").addClass("has-error");
    }else if(enderecoFaturamentto == ''){
        $("#errorEndereco").addClass("has-error");
    }else if(paisFaturamento == ''){
        $("#errorPais").addClass("has-error");
    }else if(cidadeFaturamento == ''){
        $("#errorCidade").addClass("has-error");
    }else if(estadoFaturamento == ''){
        $("#errorEstado").addClass("has-error");
    }else if(cepFaturamento == ''){
        $("#errorCep").addClass("has-error");
    }else if(emailFaturamento == ''){
        $("#errorEmail").addClass("has-error");
    }
}

function retiraErrorCliente(){
    var error1 = $('#cnpjFaturamentto').val();
    var error2 = $('#contatoFaturamentto').val();
    var error3 = $('#enderecoFaturamentto').val();
    var error4 = $('#paisFaturamento').val();
    var error5 = $('#empresas_idempresas').val();
    var error6 = $('#cidadeFaturamento').val();
    var error7 = $('#estadoFaturamento').val();
    var error8 = $('#cepFaturamento').val();
    var error9 = $('#emailFaturamento').val();
    var error10 = $('#empresa').val();

    if (error1 != '' || error2 != '' || error3 != '' || error4 != ''||
        error5 != '' || error5 != ''|| error6 != ''|| error7 != ''|| error8 != ''|| error9 != '' || error10 != ''){
        $("#errorNome").removeClass('has-error');
        $("#errorCnpj").removeClass('has-error');
        $("#errorContato").removeClass('has-error');
        $("#errorEndereco").removeClass('has-error');
        $("#errorEmpresa").removeClass('has-error');
        $("#errorPais").removeClass('has-error');
        $("#errorCidade").removeClass('has-error');
        $("#errorEstado").removeClass('has-error');
        $("#errorCep").removeClass('has-error');
        $("#errorEmail").removeClass('has-error');
        $("#errorEmpresa").removeClass('has-error');

    }

}
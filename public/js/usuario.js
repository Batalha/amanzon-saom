/**
 * Created by celio on 23/03/2017.
 */


function verificaCamposUsuario(){
    var nome = $('#nome').val();
    var empresas_idempresas = $('#empresas_idempresas').val();
    var perfis_idperfis = $('#perfis_idperfis').val();
    var email = $('#email').val();
    var login = $('#login').val();
    var senha = $('#senha').val();

    if(nome==''){
        $("#errorNome").addClass("has-error");
    }else if(empresas_idempresas == ''){
        $("#errorEmpresa").addClass("has-error");
    }else if(perfis_idperfis == ''){
        $("#errorPerfil").addClass("has-error");
    }else if(email == ''){
        $("#errorEmail").addClass("has-error");
    }else if(login == ''){
        $("#errorLogin").addClass("has-error");
    }else if(senha == ''){
        $("#errorSenha").addClass("has-error");
    }

        //simpleMsg('Preecha o campo Data.');
        //$("#respostaFormAjax").html('Preecha o campo Data.');
        //$('#respostaFormAjax').css('display','block');
        //setTimeout('$(\'#respostaFormAjax\').fadeOut()' , 8000 );
        //$("#submitIncidenteCreate").attr("disabled", true);

}

function retiraErrorUsuario(){
    var error1 = $('#nome').val();
    var error2 = $('#email').val();
    var error3 = $('#login').val();
    var error4 = $('#senha').val();
    var error5 = $('#empresas_idempresas').val();
    var error6 = $('#perfis_idperfis').val();

    if (error1 != '' || error2 != '' || error3 != '' || error4 != ''|| error5 != '' || error5 != '' ){
        $("#errorNome").removeClass('has-error');
        $("#errorEmail").removeClass('has-error');
        $("#errorLogin").removeClass('has-error');
        $("#errorSenha").removeClass('has-error');
        $("#errorEmpresa").removeClass('has-error');
        $("#errorPerfil").removeClass('has-error');

    }

}
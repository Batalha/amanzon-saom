/**
 * Created by celio on 13/04/2018.
 */


function nomevsat(vsat){

    var input = document.getElementById('nome_instalacao');
    input.onkeydown = function(event) {
        var key = event.keyCode || event.charCode;
        if( key == 8 || key == 46 ){
            document.getElementById('nome_instalacao').value = vsat;
            return false;
        }
    };
}

var atualizaEditorIncidentes;

var cronometroIncidenteView;

function tirar_espaco(espaco){
    espaco.value='';
}

function com_espaco(espaco){
    espaco.value=' ';
}

function verificaVsatSp(){
    var instVsat = $('#instVsat').val();

    if(instVsat=='')/*encontrado - desabilita*/
    {
        simpleMsg('Por favor Inclua uma Vsat.');
        $("#respostaFormAjax").attr("disabled", true);

    }
    else{
        $("#submitIncidenteCreate").attr("disabled", false);
        /*mantém habilitado*/
    }
}

function tipoIncidente(){

    var id_t_incidente = $('#solicitacao_idsolicitacao').val();
    if(id_t_incidente == 7){
        $("#tipoHidden").removeAttr('hidden');
    }else{
        $("#tipoHidden").attr('hidden', true);
    }

    if(id_t_incidente == 8){
        $("#demoHidden").removeAttr('hidden');
    }else{
        $("#demoHidden").attr('hidden', true);
    }
    //var newHTML =  t_incidente ;
    //document.getElementById('para').innerHTML = newHTML;
}


function retiraError(){

    var error1 = $('#data').val();
    var error2 = $('#tecnicoNoc').val();
    var error3 = $('#nome_instalacao').val();
    var error4 = $('#solicitacao_idsolicitacao').val();

    if (error1 != '' || error2 != '' || error3 != '' || error4 != ''){
        $("#errorData").removeClass('has-error');
        $("#errorTecnico").removeClass('has-error');
        $("#errorInstalacao").removeClass('has-error');
        $("#errorSolicitacao").removeClass('has-error');
        $("#submitIncidenteCreate").attr("disabled", false);

    }
}

function verificaDataRelatorio(){
    var dt_i = $('#data_inicio').val();
    var dt_f = $('#data_fim').val();

    if(dt_i != '' || dt_f != ''){
        $("#subitRelatorioIncidente").attr("disabled", true);
    }

    if(dt_i != '' && dt_f != ''){
        $("#subitRelatorioIncidente").attr("disabled", false);

    }
    if(dt_i == '' && dt_f == ''){
        $("#subitRelatorioIncidente").attr("disabled", false);

    }

}

function verificaCamposIncidenteSp()
{
    //var idProdemge = $('#idprodemge').val();
    var instal = $('#nome_instalacao').val();
    var tecnicoNoc = $('#tecnicoNoc').val();
    var dt= $('#data').val();
    var solicitacao= $('#solicitacao_idsolicitacao').val();

    /*busca no banco incidentes com o idprodemge especificado*/
    $.post('Incidente_sp/verificaCamposIncidente',{datas:dt, tecnicoNoc:tecnicoNoc, instal:instal, solicitacao:solicitacao},function(data){
        /*alert(data);*/

        if(data=='vazioDt')/*encontrado - desabilita*/
        {
            $("#errorData").addClass("has-error");
            //simpleMsg('Preecha o campo Data.');
            $("#respostaFormAjax").html('Preecha o campo Data.');
            $('#respostaFormAjax').css('display','block');
            setTimeout('$(\'#respostaFormAjax\').fadeOut()' , 8000 );
            $("#submitIncidenteCreate").attr("disabled", true);

        }
        else if(data=='vazioTecnico')/*encontrado - desabilita*/
        {
            $("#errorTecnico").addClass("has-error");
            $("#respostaFormAjax").html('Escolha o Tecnico Responsavel.');
            $('#respostaFormAjax').css('display','block');
            setTimeout('$(\'#respostaFormAjax\').fadeOut()' , 8000 );
            $("#submitIncidenteCreate").attr("disabled", true);

        }

        else if(data=='vazioInstalacao')/*encontrado - desabilita*/
        {
            //simpleMsg('Escolha a Instalacao.');
            $("#errorInstalacao").addClass("has-error");
            $("#respostaFormAjax").html('Escolha a Instalacao.');
            $('#respostaFormAjax').css('display','block');
            setTimeout('$(\'#respostaFormAjax\').fadeOut()' , 8000 );
            $("#submitIncidenteCreate").attr("disabled", true);

        }
        else if(data=='vazioSolicitacao')/*encontrado - desabilita*/
        {
            //simpleMsg('Escolha Tipo de Ticket.');
            $("#errorSolicitacao").addClass("has-error");
            $("#respostaFormAjax").html('Escolha Tipo de Ticket.');
            $('#respostaFormAjax').css('display','block');
            setTimeout('$(\'#respostaFormAjax\').fadeOut()' , 8000 );
            $("#submitIncidenteCreate").attr("disabled", true);

        }
        else{
            $("#submitIncidenteCreate").attr("disabled", false);
            /*mantém habilitado*/
        }
    });
}


/**
 * Função para despausar o cronometro
 */
function despausarCronometro(cronometro_interrupcao)
{
    $.post('Cronometro_interrupcao_sp/despausaCronometro',{cronometro_interrupcao:cronometro_interrupcao},function(data){
        /*alert(data.split('|'));*/
        var resposta = data.split('|');
        if(resposta[1]=='ok')
        {
            simpleMsg('Cronômetro despausado.');
            getAjaxForm('Incidente_sp/view','conteudo',{param:resposta[0],ajax:1});
        }
        else
        {
            simpleMsg('Erro ao despausar cronômetro.');
            getAjaxForm('Incidente_sp/view','conteudo',{param:resposta[0],ajax:1});
        }
    });
}
/**
 * Função para editar pausa em cronometro
 */
function editaCronometro(cronometro)
{
    $.post('Cronometro_interrupcao_sp/formEditaPausa',{cronometro:cronometro},function(data){
        $('#divDinamico').html(data);
    });
}

/**
 * Função para pausar cronometro
 */
function pausaCronometro(cronometro)
{
    $.post('Cronometro_interrupcao/formPausa',{cronometro:cronometro},function(data){
        $('#divDinamico').html(data);
    });
}

/**
 * Função para setar cronometro rodando
 */
/*
 * hor,min,seg -> tempo corrido
 */
function rodaCronometrosp(status){
    if( status == 'Aberto' || status == 'Em Atendimento' || status == 'Sem Atendimento' )
    {
        var medicaoAtual = $('#tempoTranscorrido').html();
        var tempoDividido = medicaoAtual.split(':');

        days = retiraZeroEsquerda(tempoDividido[0]);
        hor = retiraZeroEsquerda(tempoDividido[1]);if( hor.length < 2 ){ hor = '0'+hor; }
        min = retiraZeroEsquerda(tempoDividido[2]);if( min.length < 2 ){ min = '0'+min; }
        seg = retiraZeroEsquerda(tempoDividido[3]);if( seg.length < 2 ){ seg = '0'+seg; }
        local = 'tempoTranscorrido';

        cronometroIncidenteView = new Date();
        cronometroIncidenteView.setHours(hor);
        cronometroIncidenteView.setMinutes(min);
        cronometroIncidenteView.setSeconds(seg);

        cronometroIncidente = setInterval("StartCrono_corrido()",1000);
        //console.log(cronometroIncidenteView);
    }
}

function StartCrono_corrido()
{
    /* interrompe se não tem disponível o campo (para casos de outras páginas) */
    if($('#'+local).html()==null){ return 0; }

    cronometroIncidenteView.setSeconds( cronometroIncidenteView.getSeconds() + 1 );

    var hor = retiraZeroEsquerda(cronometroIncidenteView.getHours());
    var hora  = new String(hor);
    if( hora.length < 2 ){ hor = '0'+hor; }
    var min = retiraZeroEsquerda(cronometroIncidenteView.getMinutes());
    var minu  = new String(min);
    if( minu.length < 2 ){ min = '0'+min; }
    var seg = retiraZeroEsquerda(cronometroIncidenteView.getSeconds());
    var segu  = new String(seg);
    if( segu.length < 2 ){ seg = '0'+seg; }

    hor = hor + ( 24 * days );

    var tempo = hor+':'+min+':'+seg;

    $('#'+local).html(tempo);

    apresentacaoTempoTranscorrido();
}

function apresentacaoTempoTranscorrido(){
    var mostraTempoTranscorrido = $('#tempoTranscorrido').css('visibility');
    if( mostraTempoTranscorrido == 'hidden' ){
        $('#tempoTranscorrido').css('visibility','visible');
    }
}

function ativaSubmenuIncidentessp()
{
    $('#submenu a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        switch( $(this).attr('href') ) //atributo href do link clicado
        {
            case '#novoincidente_sp':

                break;
            case '#listaincidentes_sp':
                getAjaxForm('Incidente_sp/liste');
                break;
            case '#listaatendimentos_sp':
                getAjaxForm('AtendVsat_sp/liste');
                break;
            case '#relatorio_sp':
                //window.open('http://vodanet-telecom.com/SAOM/Incidente/relatorio');
                //TODO: fazer esse item de menu funcional
                break;
            case '#relatorioIncidentesPorInstalacao_sp':
                getAjaxForm('Relatorio_sp/incidentesPorInstalacao');
                break;
        }
    });
}

// --  chama modal

function abreEscolhaIncidentesSp(){

    $('#modalInstalacoes').modal();
    $.ajax({
        async:false,
        url:'Incidente_sp/formularioComListaDeInstalacoes',
        type:'POST',
        data:{idIncidente:$('#idincidentes').val()},
        success:function( resposta ){

            $('#modalConteudo').html( resposta );
            var lista = $('#listaInstalacoes_sp').html();

            var listaArray = lista.split(',');

            $("#nome_instalacao").focus().autocomplete(listaArray);

        }
    });

}

function atualizaEditorIncidenteSp( idincidentes ){
    $("#modalInstalacoes").modal("hide");
    getAjaxForm('Incidente_sp/edit',false,{param:idincidentes,ajax:1});
}


// para retirar zero a esquerda
function retiraZeroEsquerda( numero ){
    if( numero[0] ){
        while( numero[0] == 0 ){
            numero = numero.substr(1,numero.length);
        }
    }
    return numero;

}

function selecaoSala(){
    selecte = $('#usuarios_idusuarios').val();
    if (selecte == 53){
        $( ".esconder" ).css("display","block");
    }else{
        $( ".esconder" ).css("display","none");

    }
}





//



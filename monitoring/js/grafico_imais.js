/**
 * Created by celio on 08/07/2015.
 */

function btmenus(sel){


    var valueOS = sel.value;
    if(valueOS == '1'){
        var imais = document.getElementById('imais_atte').innerHTML;
    }else if(valueOS == '2'){
        var imais = document.getElementById('imais_bent').innerHTML;

    }

    var newHTML =  imais ;
    document.getElementById('para').innerHTML = newHTML;
    //document.getElementById('arquivoInstal').innerHTML = '';


}
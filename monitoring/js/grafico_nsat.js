/**
 * Created by celio on 08/07/2015.
 */

function btmenus(sel){


    var valueOS = sel.value;
    if(valueOS == '1'){
        var nsat = document.getElementById('nsat_tapaua').innerHTML;
    }else if(valueOS == '2'){
        var nsat = document.getElementById('nsat_eirunepe').innerHTML;

    }

    var newHTML =  nsat ;
    document.getElementById('para').innerHTML = newHTML;
    //document.getElementById('arquivoInstal').innerHTML = '';


}
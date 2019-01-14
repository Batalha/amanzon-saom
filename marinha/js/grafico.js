/**
 * Created by celio on 08/07/2015.
 */

function btmenus(sel){


    var valueOS = sel.value;
    if(valueOS == '1') {
        var marinha = document.getElementById('mFragata').innerHTML;
    }else if(valueOS == '2') {
        var marinha = document.getElementById('mNeBrasil').innerHTML;
    }else if(valueOS == '3') {
        var marinha = document.getElementById('mFragataLiberal').innerHTML;
    }
    else if(valueOS == '4') {
        var marinha = document.getElementById('mNavioApa').innerHTML;
    }
    else if(valueOS == '5') {
        var marinha = document.getElementById('mFragataConst').innerHTML;
    }
    else{
        var marinha =document.getElementById('mFragata').innerHTML;
    }

    var newHTML =  marinha ;
    document.getElementById('para').innerHTML = newHTML;
    //document.getElementById('arquivoInstal').innerHTML = '';


}
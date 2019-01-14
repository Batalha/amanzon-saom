
<?php




error_reporting(E_ALL);
set_time_limit(1800);


curl_login('http://200.143.6.173/zabbix/index.php','request=&name=admin&password=zabbix&autologin=1&enter=Sign+in','','off');
img_grafico('http://200.143.6.173/zabbix/chart2.php?graphid=562&period=3600&width=900','','off');

function curl_login($url,$data,$proxy,$proxystatus){
    $fp = fopen("cookie_562.txt","w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie_562.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie_562.txt");
    curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($login, CURLOPT_TIMEOUT, 40);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    if($proxystatus == 'on'){
        curl_setopt($login, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($login, CURLOPT_HTTPPROXYTUNNEL, TRUE);
        curl_setopt($login, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_HEADER, TRUE);
    curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start();
    return curl_exec($login);
    ob_end_clean();
    curl_close($login);
    unset($login);

}


function img_grafico($site,$proxy, $proxystatus){
    $fp = fopen("zabbix_graph_562.png","w");
    $ch = curl_init();


    curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
    if($proxystatus == 'on'){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie_562.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    ob_start();
    $return = curl_exec($ch);
    ob_end_clean();
    curl_close($ch);

//    header("Content-type: image/png");
    echo "<img src='/fragata/zabbix_graph_562.png'>";
    unlink("cookie_562.txt");
    fclose($fp);
    echo "<meta HTTP-EQUIV='refresh' CONTENT='15;'>";
}




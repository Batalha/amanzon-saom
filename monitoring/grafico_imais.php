<meta HTTP-EQUIV='refresh' CONTENT='15;'>
<?php

error_reporting(E_ALL);
set_time_limit(1800);


include_once 'restrito.php';


//var_dump(($_SESSION['periodo'] == '3600')? 'selected':'');

if(isset($_SESSION['name']) != false && isset($_SESSION['password']) != false){

    if(isset($_SESSION['grafico']) != true){
        $graficoid = '2560';
        $periodo = 3600;
    }else{
        $graficoid = $_SESSION['grafico'];
        $periodo = $_SESSION['periodo'];
//print_r($periodo);

    }

    curl_login('http://92.39.116.154/zabbix/index.php', 'request=&name='.$_SESSION['name'].'&password='.$_SESSION['password'].'&autologin=1&enter=Sign+in', '', 'off', $graficoid);
    img_grafico('http://92.39.116.154/zabbix/chart2.php?graphid='.$graficoid.'&period='.$periodo.'&width=1000', '', 'off', $graficoid);
    unset($graficoid);
}else{
    header("Location: login.php");
}

//dctim2015
//testeoilab


function curl_login($url, $data, $proxy, $proxystatus, $grafid)
{
    $fp = fopen("img/img_imais/cookie_".$grafid.".txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie_".$grafid.".txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie_".$grafid.".txt");
    curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($login, CURLOPT_TIMEOUT, 40);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    if ($proxystatus == 'on') {
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


function img_grafico($site, $proxy, $proxystatus, $grafid)
{
    $fp = fopen("img/img_imais/zabbix_graph_".$grafid.".png", "w");
    $local_graf = "/monitoring/img/img_imais/zabbix_graph_".$grafid.".png";
    $ch = curl_init();


    curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
    if ($proxystatus == 'on') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie_".$grafid.".txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    ob_start();
    curl_exec($ch);
    ob_end_clean();
    curl_close($ch);

    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="css/stilo.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/grafico_imais.js"></script>
    <center>

        <form method="post" action="index.php">
            <input type="hidden" name="name" value="<?php echo $_SESSION['name']; ?>">
            <input type="hidden" name="password" value="<?php echo $_SESSION['password']; ?>">
            <div id="contener">

                <div id="topo">
                    <div id="logo"></div>
                    <div id="logout">
                        <table border="0">
                            <tr><td colspan="2">Bem Vindo!</td></tr>
                            <tr><td>User :</td><td><?php echo $_SESSION['name'] ?></td></tr>
                            <tr><td colspan="2"><a href="index.php">Sair</a></td></tr>
                        </table>
                    </div>

                    <img src="img/bg_body.jpg" width="1113" height="132">
                </div>
                <span id="graf"><b>Gráfico</b></span>

                <div id="acoes">
                    <table  border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <select name="imais" id="imais" onchange="return btmenus(this)";>
                                    <option value="0"><b>Escolha:</b></option>
                                    <option value="1"><b>IMAIS-ATTE:</b></option>
                                    <option value="2"><b>IMAIS-BENT2:</b></option>
                                </select>
                            </td>
                            <td align="left">
                                <div id="para"></div>
                            </td>
                        </tr>
                    </table>

                </div>
                <div id="grafico"><?php echo "<img src=$local_graf>"?></div>
            </div>
        </form>
    </center>


    <div id="imais_atte" hidden="">
        <table border="0">
            <tr>
                <td width="16%"><input type="radio"  <?php echo ($_SESSION['grafico'] == '2566')? 'checked':'' ?> name="graf" value="2566">&nbsp;&nbsp;Traffic</td>
                <!--                            <td width="10%"><input type="radio"  name="graf" value="554">&nbsp;&nbsp;Rx</td>-->
                <!--                <td width="10%"><input type="radio" --><?php //echo ($_SESSION['grafico'] == '570')? 'checked':'' ?><!--  name="graf" value="570">&nbsp;&nbsp;Ping</td>-->
                <td width="10%">&nbsp;&nbsp;Periodo :</td>
                <td width="15%"><select name="periodo">
                        <option value="3600" <?php echo ($_SESSION['periodo'] == '3600')? 'selected':'' ?>>Uma Hora</option>
                        <option value="86400" <?php echo ($_SESSION['periodo'] == '86400')? 'selected':'' ?>>Um Dia</option>
                        <option value="604800" <?php echo ($_SESSION['periodo'] == '604800')? 'selected':'' ?>>Uma Semana</option>
                        <option value="2592000" <?php echo ($_SESSION['periodo'] == '2592000')? 'selected':'' ?>>Um Mes</option>
                    </select></td>
                <td><input type="submit" name="btImaisAtte" value="Gerar Grafico"></td>
            </tr>
        </table>
    </div>

    <div id="imais_bent" hidden="">
        <table border="0">
            <tr>
                <td width="16%"><input type="radio"  <?php echo ($_SESSION['grafico'] == '2560')? 'checked':'' ?> name="graf" value="2560">&nbsp;&nbsp;Traffic</td>
                <!--                            <td width="10%"><input type="radio"  name="graf" value="554">&nbsp;&nbsp;Rx</td>-->
                <!--                <td width="10%"><input type="radio" --><?php //echo ($_SESSION['grafico'] == '570')? 'checked':'' ?><!--  name="graf" value="570">&nbsp;&nbsp;Ping</td>-->
                <td width="10%">&nbsp;&nbsp;Periodo :</td>
                <td width="15%"><select name="periodo">
                        <option value="3600" <?php echo ($_SESSION['periodo'] == '3600')? 'selected':'' ?>>Uma Hora</option>
                        <option value="86400" <?php echo ($_SESSION['periodo'] == '86400')? 'selected':'' ?>>Um Dia</option>
                        <option value="604800" <?php echo ($_SESSION['periodo'] == '604800')? 'selected':'' ?>>Uma Semana</option>
                        <option value="2592000" <?php echo ($_SESSION['periodo'] == '2592000')? 'selected':'' ?>>Um Mes</option>
                    </select></td>
                <td><input type="submit" name="btImaisBent" value="Gerar Grafico"></td>
            </tr>
        </table>
    </div>

  <?php
    unlink("cookie_".$grafid.".txt");
    fclose($fp);
}
?>
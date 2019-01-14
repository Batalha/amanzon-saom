<?php
/**
 * Created by PhpStorm.
 * User: celio
 * Date: 12/01/2015
 * Time: 17:09
 */
?>

<link href="css/stilo.css" rel="stylesheet" type="text/css" />
<center>

    <form method="post" action="index.php">
        <div id="contener">

            <div id="topo">
                <div id="logo"></div>
                <img src="img/bg_body.jpg" width="1113" height="132">
            </div>
            <span id="graf"><b>Gr&aacute;fico</b></span>
            <div id="acoes">
                <table border="0" width="100%">
                    <tr>
                        <td width="15%"><b>Fragata Constituicao:</b></td>
                        <td width="16%"><input type="radio" checked="checked" name="graf" value="562">&nbsp;&nbsp;Traffic Costitucao</td>
                        <td width="10%"><input type="radio"  name="graf" value="554">&nbsp;&nbsp;Rx</td>
                        <td width="10%"><input type="radio"   name="graf" value="551">&nbsp;&nbsp;Ping</td>
                        <td><input type="submit" name="bt" value="Gerar Grafico"></td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <?php include 'grafico.php' ?>


</center>
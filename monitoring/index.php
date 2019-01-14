<?php

//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "saomnovo";

$servername = "localhost";
$username = "saom";
$password = "-7>+:M*';62_F&h";
$dbname = "saomnovo";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    echo "Connection failed: " . mysqli_connect_errno();
}
$nome = $_POST['name'];
$senha = $_POST['password'];

$sql = "SELECT nome, senha, instituicao FROM user_grafico WHERE nome = '$nome' and senha = '$senha'";

//var_dump($sql);
$query = mysqli_query($con, $sql);
if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);

        session_start();
        $_SESSION['name'] = $row['nome'];
        $_SESSION['password'] = $row['senha'];

        if(isset($_POST['graf'])){
            switch($_POST['graf']){

                //---  FRAGATA ----

                case '2566':
                    $_SESSION['grafico'] = $_POST['graf'];
                    break;

                case '2560':
                    $_SESSION['grafico'] = $_POST['graf'];
                    break;

                case '2570':
                    $_SESSION['grafico'] = $_POST['graf'];
                    break;

                case '2574':
                    $_SESSION['grafico'] = $_POST['graf'];
                    break;

            }

        }

        if(isset($_POST['periodo'])){
            switch ($_POST['periodo']){
                case '3600':
                    $_SESSION['periodo'] = $_POST['periodo'];
                    break;
                case '86400':
                    $_SESSION['periodo'] = $_POST['periodo'];
                    break;
                case '604800':
                    $_SESSION['periodo'] = $_POST['periodo'];
                    break;
                case '2592000':
                    $_SESSION['periodo'] = $_POST['periodo'];
                    break;
            }

        }

//    print_r($row['instituicao']);exit;

        switch($row['instituicao']){
            case 'IMAIS':
                header("Location: grafico_imais.php");
                break;
            case 'NSAT':
                header("Location: grafico_nsat.php");
                break;
        }


} else {

    if(isset($_POST['loginErro'])){
        session_start();
        $_SESSION['erro'] = $_POST['loginErro'];

        header("Location: login.php");
    }else{
        session_destroy();
        header("Location: login.php");

    }
}

mysqli_close($con);





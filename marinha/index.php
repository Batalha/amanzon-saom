<?php

//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "saomnovo";

$servername = "localhost";
$username = "root";
$password = "saom@123";
$dbname = "db_saom";


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


//    print_r(var_dump($_POST['periodo']));
    $_SESSION['name'] = $row['nome'];
    $_SESSION['password'] = $row['senha'];

    if(isset($_POST['graf'])){
        switch($_POST['graf']){

            //---Fragata----
            case '571':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            case '570':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            //----Ne Brazil------
            case '910':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            case '912':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            //------Corveta Barroso----
            case '924':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            case '922':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            //------Navio APA----
            case '2548':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            case '2549':
                $_SESSION['grafico'] = $_POST['graf'];
                break;

            //---- FRAGATA CONSTITUICAO  -----
            case '2553':
                $_SESSION['grafico'] = $_POST['graf'];
                break;
            case '2551':
                $_SESSION['grafico'] = $_POST['graf'];
                break;

        }

    }

//print_r($_POST['periodo']);exit;
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

//    print_r($row['instituicao']);
    header("Location: grafico.php");

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

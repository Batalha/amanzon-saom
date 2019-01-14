<?php

/**
 * Created by PhpStorm.
 * User: celio
 * Date: 01/09/2017
 * Time: 15:03
 */


class Conexao
{
    function conexao($sql){

//        $servername = "localhost";
//        $username = "root";
//        $password = "123";
//        $dbname = "saomnovo";

        $servername = "localhost";
        $username = "saom";
        $password = "1sat2vsat";
        $dbname = "saomnovo";


        $con = mysqli_connect($servername, $username, $password, $dbname);
        if (!$con) {
            echo "Connection failed: " . mysqli_connect_errno();
        }
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);

        }
        return $row;

    }

}
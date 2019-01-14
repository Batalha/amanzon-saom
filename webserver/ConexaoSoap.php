<?php

/**
 * Created by PhpStorm.
 * User: celio
 * Date: 01/09/2017
 * Time: 15:03
 */


class ConexaoSoap
{
    public $con;
    function conexao($sql){

//        $servername = "localhost";
//        $username = "root";
//        $password = "123";
//        $dbname = "saomnovo";

        $servername = "localhost";
        $username = "saom";
        $password = "1sat2vsat";
        $dbname = "saomnovo";


        $this->con = mysqli_connect($servername, $username, $password, $dbname);
        if (!$this->con) {
            echo "Connection failed: " . mysqli_connect_errno();
        }
        $query = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);

            return $row;
        }else{
            $ultimo_id = mysqli_insert_id($this->con);
            return $ultimo_id;

        }

    }

    function close(){
        mysqli_close($this->con);
    }

}
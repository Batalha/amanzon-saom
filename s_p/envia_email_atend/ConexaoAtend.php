<?php

class ConexaoAtend
{
    public $con;

    function __construct()
    {
        $this->conexao();
    }

    function conexao(){

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

    }

    function queryDados($sql){
        $query = mysqli_query($this->con, $sql);

        $i = 0;
        while ($row[$i] = mysqli_fetch_assoc($query)) {
            $dados[] = $row[$i];
        }
        return $dados;

        if($ultimo_id = mysqli_insert_id($this->con)){
            return $ultimo_id;
        }
    }

    function queryRow($sql){
        $query = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            return $row;
        }
    }

    function close(){
        mysqli_close($this->con);
    }

}
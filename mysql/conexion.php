<?php

function conectar()
{

    //$servername = "localhost";
    //$username = "u587079173_sistemastb";
    //$password = "qljyLg=8";
    //$database = "u587079173_phicargo";

    $servername = "db";
    $username = "root";
    $password = "root";
    $database = "phicargo";
    $port = "3306";

    $cn = new mysqli($servername, $username, $password, $database, $port);

    if ($cn->connect_error) {
        die("Connection failed: " . $cn->connect_error);
    }
    return $cn;
}

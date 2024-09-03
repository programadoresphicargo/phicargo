<?php

function conectar()
{

    //$servername = "localhost";
    //$username = "u587079173_sistemastb";
    //$password = "qljyLg=8";
    //$database = "u587079173_phicargo";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "phicargo";

    $cn = new mysqli($servername, $username, $password, $database);

    if ($cn->connect_error) {
        die("Connection failed: " . $cn->connect_error);
    }
    return $cn;
}

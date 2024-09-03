<?php

function conectar_servi()
{

    $servername = "localhost";
    $username = "u587079173_root";
    $password = "#76e6EhKD^aQ";
    $database = "u587079173_servicontainer";

    //$servername = "localhost";
    //$username = "root";
    //$password = "";
    //$database = "phicargo";

    $cn = new mysqli($servername, $username, $password, $database);

    if ($cn->connect_error) {
        die("Connection failed: " . $cn->connect_error);
    }
    return $cn;
}

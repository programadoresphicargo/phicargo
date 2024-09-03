<?php

function conectar_inventario()
{

    //$servername = "localhost";
    //$username = "u587079173_sistemaspc";
    //$password = "Sistemasphicargo24";
    //$database = "u587079173_inventario";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "inventario";

    $cn = new mysqli($servername, $username, $password, $database);

    if ($cn->connect_error) {
        die("Connection failed: " . $cn->connect_error);
    }
    return $cn;
}

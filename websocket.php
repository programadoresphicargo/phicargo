<?php
$host = 'localhost';       
$port = '5433';          
$dbname = 'BELCHEZ_MASTER_12_250724';  
$user = 'josimar';     
$password = 'choforo3d2'; 

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);
if ($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión a la base de datos: " . pg_last_error();
}

$query = "SELECT * FROM tms_waybill LIMIT 10";
$result = pg_query($conn, $query);

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        print_r($row);
    }
} else {
    echo "Error en la consulta: " . pg_last_error();
}

pg_close($conn);

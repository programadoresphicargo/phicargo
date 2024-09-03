 <?php
    require_once('../../mysql/conexion.php');
    $cn = conectar();

    $sqlSelect = "SELECT * FROM  reportes where atendido IS NULL";
    $resultado = $cn->query($sqlSelect);
    if ($resultado->num_rows > 0) {
        echo 1;
    } else {
        echo 0;
    }

    ?>
 
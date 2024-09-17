<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$date = date('Y-m-d H:i:s');

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$sql = "SELECT * 
FROM reportes_estatus_maniobras 
inner join maniobra on reportes_estatus_maniobras.id_maniobra = maniobra.id_maniobra 
inner join ubicaciones_maniobras on ubicaciones_maniobras.id_ubicacion = reportes_estatus_maniobras.id_ubicacion 
inner join status on  reportes_estatus_maniobras.id_estatus = status.id_status
where maniobra.id_maniobra = $id_maniobra
order by reportes_estatus_maniobras.fecha_envio desc";
$resultado = $cn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
</head>

<body>
    <ul class="step">
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <li class="step-item">
                <div class="step-content-wrapper">
                    <div class="step-avatar">
                        <img class="step-avatar" src="../../img/automatico.png" alt="Image Description">
                    </div>
                    <div class="step-content">
                        <h5 class="mb-1"><span class="badge bg-success rounded-pill"><?php echo $row['comentario_reporte'] ?></span><span class="badge bg-primary rounded-pill"><?php echo $row['status'] ?></span></h5>
                        <ul class="list-group list-group-sm">
                            <li class="list-group-item list-group-item-light">
                                <div class="row gx-1">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <span class="d-block fs-6 text-dark text-truncate">Coordenadas: <?php echo $row['latitud'] . ',' . $row['longitud'] ?></span>
                                                <span class="d-block fs-6 text-dark text-truncate">Referencia: <?php echo $row['localidad'] ?></span>
                                                <span class="d-block fs-6 text-dark text-truncate">Calle: <?php echo $row['calle'] ?></span>
                                                <span class="d-block fs-6 text-dark text-truncate">Fecha: <?php echo $row['fecha_hora'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</body>

</html>
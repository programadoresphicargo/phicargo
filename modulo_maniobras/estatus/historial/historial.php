<?php
require_once('../../../postgresql/conexion.php');
$cn = conectarPostgresql();
$date = date('Y-m-d H:i:s');

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

try {
    $sql = "SELECT * FROM reportes_estatus_maniobras 
    left join status on status.id_status = reportes_estatus_maniobras.id_estatus
    left join ubicaciones_maniobras on ubicaciones_maniobras.id_ubicacion = reportes_estatus_maniobras.id_ubicacion
    where reportes_estatus_maniobras.id_maniobra = $id_maniobra order by reportes_estatus_maniobras.fecha_hora desc";
    $stmt = $cn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}

?>

<ul class="step">
    <?php foreach ($rows as $row) { ?>
        <li class="step-item">
            <div class="step-content-wrapper">
                <div class="step-avatar">
                    <span class="step-icon step-icon-soft-dark">E</span>
                </div>
                <div class="step-content">
                    <h5 class="mb-1"><span class="badge bg-success rounded-pill"><?php echo $row['comentarios_estatus'] ?></span><span class="badge bg-primary rounded-pill"><?php echo $row['status'] ?></span></h5>
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
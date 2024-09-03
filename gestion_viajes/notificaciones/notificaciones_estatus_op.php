<?php
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');

session_start();
$id_usuario = $_SESSION['userID'];

$cn = conectar();
$sqlSelect = "SELECT 
n.id_viaje, 
v.referencia, 
n.fecha_hora, 
o.nombre_operador, 
u.unidad, 
v.placas, 
COALESCE(c.leido, NULL) AS leido, 
n.descripcion
FROM 
notificaciones n
INNER JOIN 
viajes v ON v.id = n.id_viaje 
INNER JOIN 
operadores o ON o.id = v.employee_id 
INNER JOIN 
unidades u ON u.placas = v.placas 
LEFT JOIN 
control_notificaciones c ON c.id_notificacion = n.id AND c.id_usuario = $id_usuario
WHERE 
n.evento = 'estatus operador'
ORDER BY 
n.fecha_hora DESC
limit 80";
$resultado = $cn->query($sqlSelect);
?>

<ul class="list-group list-group-flush">
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <li class="list-group-item form-check-select <?php echo $row['leido'] == NULL ? 'bg-soft-primary' : '' ?>" onclick="abrir_viaje('<?php echo $row['id_viaje'] ?>')">
            <div class="row">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <img class="avatar avatar-sm avatar-circle" src="../../img/icons/app.png">
                    </div>
                </div>

                <div class="col ms-n3">
                    <h5 class="mb-1">El operador actualizo su estatus</h5>
                    <span class="badge bg-primary rounded-pill"><?php echo $row['descripcion'] ?></span>
                    <p class="text-body">
                        Referencia de viaje: <?php echo $row['referencia'] ?> <br>
                        Operador: <?php echo $row['nombre_operador'] ?> <br>
                        Unidad: <?php echo  $row['unidad'] . ' [' . $row['placas'] . ']' ?></p>
                    <?php
                    $fechaHoraBD = $row['fecha_hora'];
                    $fechaHora = new DateTime($fechaHoraBD);
                    $formatoDeseado = $fechaHora->format('Y/m/d h:i a');
                    echo $formatoDeseado; ?>
                </div>

                <small class="col-auto text-muted text-cap"><?php echo imprimirTiempo($row['fecha_hora']) ?></small>
            </div>
        </li>
    <?php } ?>
</ul>

<script>
    function abrir_viaje(id_viaje) {
        notyf.success('Viaje');
        $('#offcanvas_viaje').offcanvas('show');
        $('#cargadiv5').show();
        $("#contenido").load('../viaje/index.php?id=' + id_viaje, function() {
            $('#cargadiv5').hide();
        });
    }
</script>
<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id = $_POST['id_entrega'];

$sqlInsert = "SELECT * FROM entregas_turnos_visto inner join usuarios on usuarios.id_usuario = entregas_turnos_visto.id_usuario where id_entrega = $id";
$resultado = $cn->query($sqlInsert);
?>
<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-eye"></i> Visto por
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <a class="dropdown-item" href="#"><?php echo $row['nombre'] ?></a>
        <?php } ?>
    </div>
</div>
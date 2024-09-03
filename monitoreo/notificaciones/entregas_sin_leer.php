<?php
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');

$cn = conectar();
$sqlSelect = "SELECT * FROM entrega_turnos inner join usuarios on usuarios.id_usuario = entrega_turnos.usuario";
$resultado = $cn->query($sqlSelect);
?>
<!-- List Group -->
<ul class="list-group list-group-flush navbar-card-list-group">
    <!-- Item -->
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <li class="list-group-item form-check-select" onclick="abrir_entrega('<?php echo $row['id'] ?>')">
            <div class="row">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <img class="avatar avatar-sm avatar-circle" src="../../img/usuario.png" alt="Image Description">
                    </div>
                </div>
                <!-- End Col -->

                <div class="col ms-n2">
                    <h5 class="mb-1"><?php echo $row['nombre'] ?></h5>
                    <p class="text-body fs-5">
                        <?php
                        $texto = strip_tags($row['texto']);
                        $limitePalabras = 10; // Cantidad de palabras a imprimir
                        $palabras = explode(' ', $texto); // Dividir el texto en palabras
                        $textoResumido = implode(' ', array_slice($palabras, 0, $limitePalabras)); // Obtener las primeras palabras

                        if (count($palabras) > $limitePalabras) {
                            $textoResumido .= '...'; // Agregar puntos suspensivos si hay más palabras
                        }

                        echo $textoResumido;
                        ?>
                    </p>
                </div>
                <!-- End Col -->

                <small class="col-auto text-muted text-cap"><?php echo imprimirTiempo($row['fecha_inicio']) ?></small>
                <!-- End Col -->
            </div>
            <!-- End Row -->

            <a class="stretched-link" href="#"></a>
        </li>
    <?php } ?>

    <!-- End Item -->
</ul>
<!-- End List Group -->
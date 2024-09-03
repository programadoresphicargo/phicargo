<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

$SqlSelect = "SELECT * FROM revisiones_elementos_maniobra inner join elementos_checklist on revisiones_elementos_maniobra.elemento_id = elementos_checklist.id_elemento inner join maniobras on maniobras.id = revisiones_elementos_maniobra.maniobra_id where id_cp = $id_cp and maniobras.tipo = '$tipo'";
$resultado = $cn->query($SqlSelect);
?>

<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">Elemento</th>
            <th class="text-center">Estado salida</th>
            <th class="text-center">Evidencias salida</th>
            <th class="text-center">Observaciones salida</th>
            <th class="text-center">Estado entrada</th>
            <th class="text-center">Evidencias entrada</th>
            <th class="text-center">Observaciones entrada</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($row = $resultado->fetch_assoc()) { ?>

            <tr>
                <td><?php echo $row['nombre_elemento']; ?></td>
                <td class="text-center"><?php echo $row['estado_salida'] == 1 ? '<i class="bi bi-check2"></i>' : '<i class="bi bi-x"></i>' ?></td>
                <td class="text-center"><button class="btn btn-link" type="button" onclick="abrir_galeria('<?php echo $row['id_cp'] ?>','Retiro')"><i class="bi bi-image-fill"></i></button></td>
                <td class="text-center"><?php echo $row['observacion_salida']; ?></td>
                <td class="text-center">
                    <?php
                    if ($row['estado_entrada'] == NULL) { ?>
                    <?php } else if ($row['estado_entrada'] == 1) {  ?>
                        <i class="bi bi-check2"></i>
                    <?php } else if ($row['estado_entrada'] == 0) { ?>
                        <i class="bi bi-x"></i>
                    <?php } ?>
                </td>
                <td class="text-center"><button class="btn btn-link" type="button" onclick="abrir_galeria('<?php echo $row['id_cp'] ?>','Ingreso')"><i class="bi bi-image-fill"></i></button></td>
                <td class="text-center"><?php echo $row['observacion_entrada']; ?></td>
            </tr>

        <?php
        } ?>

    </tbody>
</table>

<script>
    function abrir_galeria(id_cp, tipo) {
        $("#modal_galeria_maniobra").offcanvas('show');
        $("#checklist_galeria_contenido").load("../checklist/galeria.php", {
            'id_cp': id_cp,
            'tipo': tipo
        });
    }
</script>
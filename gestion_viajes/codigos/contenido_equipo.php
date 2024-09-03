<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$sql = "SELECT * FROM flota";

$sql2 = "SELECT x_reference, x_reference_2, flota1.vehicle_id AS remolque1_id, flota1.name AS remolque1_info, flota2.vehicle_id AS remolque2_id, flota2.name AS remolque2_info, flota3.vehicle_id AS dolly_id, flota3.name AS dolly_info FROM viajes LEFT JOIN flota AS flota1 ON viajes.remolque1 = flota1.vehicle_id LEFT JOIN flota AS flota2 ON viajes.remolque2 = flota2.vehicle_id LEFT JOIN flota AS flota3 ON viajes.dolly = flota3.vehicle_id where id = $id_viaje";
$resultado2 = $cn->query($sql2);
$row2 = $resultado2->fetch_assoc();

$remolque1_id = $row2['remolque1_id'];
$remolque1 = $row2['remolque1_info'];

$remolque2_id = $row2['remolque2_id'];
$remolque2 = $row2['remolque2_info'];

$dolly_id = $row2['dolly_id'];
$dolly = $row2['dolly_info'];

$contenedor1 = $row2['x_reference'];
$contenedor2 = $row2['x_reference_2'];
?>

<form id="form_equipo">
    <!-- Input Group -->
    <input type="hidden" value="<?php echo $id_viaje ?>" id="id_viaje" name="id_viaje">

    <div class="mb-3">
        <label for="inputGroupFlushGenderSelect" class="form-label">Remolque 1</label>

        <div class="input-group input-group-merge input-group-flush">
            <div class="input-group-prepend input-group-text">
                <i class="bi-person"></i>
            </div>
            <select id="remolque1_edit" name="remolque1_edit" class="form-select">
                <?php $resultado = $cn->query($sql); ?>
                <option value="0">Desmontar equipo</option>
                <?php
                while ($row = $resultado->fetch_assoc()) { ?>
                    <option value="<?php echo $row['vehicle_id'] ?>"><?php echo $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <!-- End Input Group -->
    <!-- Input Group -->
    <div class="mb-3">
        <label for="inputGroupFlushGenderSelect" class="form-label">Remolque 2</label>

        <div class="input-group input-group-merge input-group-flush">
            <div class="input-group-prepend input-group-text">
                <i class="bi-person"></i>
            </div>
            <select id="remolque2_edit" name="remolque2_edit" class="form-select">
                <?php $resultado = $cn->query($sql); ?>
                <option value="0">Desmontar equipo</option>
                <?php while ($row = $resultado->fetch_assoc()) { ?>
                    <option value="<?php echo $row['vehicle_id'] ?>"><?php echo $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <!-- End Input Group -->

    <!-- Input Group -->
    <div class="mb-3">
        <label for="inputGroupFlushGenderSelect" class="form-label">Dolly</label>

        <div class="input-group input-group-merge input-group-flush">
            <div class="input-group-prepend input-group-text">
                <i class="bi-person"></i>
            </div>
            <select id="dolly_edit" name="dolly_edit" class="form-select">
                <?php $resultado = $cn->query($sql); ?>
                <option value="0">Desmontar equipo</option>
                <?php while ($row = $resultado->fetch_assoc()) { ?>
                    <option value="<?php echo $row['vehicle_id'] ?>"><?php echo $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <!-- End Input Group -->

    <!-- Input Group -->
    <div class="mb-3">
        <label class="form-label">Contenedor 1</label>

        <div class="input-group input-group-merge input-group-flush">
            <div class="input-group-prepend input-group-text">
                <i class="bi-person"></i>
            </div>
            <input id="contenedor1_edit" name="contenedor1_edit" class="form-control">
        </div>
    </div>
    <!-- End Input Group -->

    <!-- Input Group -->
    <div class="mb-3">
        <label class="form-label">Contenedor 2</label>

        <div class="input-group input-group-merge input-group-flush">
            <div class="input-group-prepend input-group-text">
                <i class="bi-person"></i>
            </div>
            <input id="contenedor2_edit" name="contenedor2_edit" class="form-control">
        </div>
    </div>
    <!-- End Input Group -->
</form>

<script>
    function abrir_editor(remolque1, remolque2, dolly, contenedor1, contenedor2) {
        $("#editor_equipo_offcanvas").offcanvas('show');
        $("#remolque1_edit").val(remolque1).change();
        $("#remolque2_edit").val(remolque2).change();
        $("#dolly_edit").val(dolly).change();
        $("#contenedor1_edit").val(contenedor1).change();
        $("#contenedor2_edit").val(contenedor2).change();
    }

    abrir_editor(
        '<?php echo $remolque1_id ?>',
        '<?php echo $remolque2_id ?>',
        '<?php echo $dolly_id ?>',
        '<?php echo $contenedor1 ?>',
        '<?php echo $contenedor2 ?>',
    );

    $("#guardar_cambio_equipo").click(function() {
        var datos = $("#form_equipo").serialize();
        $.ajax({
            url: "../codigos/actualizar_equipo.php",
            type: "POST",
            data: datos,
            success: function(response) {
                if (response == 1) {
                    notyf.success('Correcto');
                } else {
                    notyf.error('inCorrecto');
                }
            },
            error: function() {

            }
        });
    });
</script>
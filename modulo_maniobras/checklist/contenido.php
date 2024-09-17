<?php
require_once('../../odoo/odoo-conexion.php');
$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

require_once('get_activos.php');

$data = json_decode($json, true);

if ($tipo == 'Retiro') {
    if ($data !== null) {
        foreach ($data as $item) {
            $operador = ($item['x_operador_retiro_id'] != false ? $item['x_operador_retiro_id'][1] : $item['x_operador_retiro_id']);
            $tracto = ($item['x_eco_retiro_id'] != false ? $item['x_eco_retiro_id'][1] : $item['x_eco_retiro_id']);
            $remolque1 = ($item['x_remolque_1_retiro'] != false ? $item['x_remolque_1_retiro'][1] : $item['x_remolque_1_retiro']);
            $remolque2 = ($item['x_remolque_2_retiro']  != false ? $item['x_remolque_2_retiro'][1] : $item['x_remolque_2_retiro']);
            $dolly = ($item['x_dolly_retiro'] != false ? $item['x_dolly_retiro'][1] : $item['x_dolly_retiro']);
            $x_reference = ($item['x_reference'] != false ? $item['x_reference'] : $item['x_reference']);
        }
    } else {
        echo "Error al decodificar el JSON.";
    }
} else if ($tipo == 'Ingreso') {
    if ($data !== null) {
        foreach ($data as $item) {
            $operador = ($item['x_mov_ingreso_bel_id'] != false ? $item['x_mov_ingreso_bel_id'][1] : $item['x_mov_ingreso_bel_id']);
            $tracto = ($item['x_eco_ingreso_id'] != false ? $item['x_eco_ingreso_id'][1] : $item['x_eco_ingreso_id']);
            $remolque1 = ($item['x_remolque_1_ingreso']  != false ? $item['x_remolque_1_ingreso'][1] : $item['x_remolque_1_ingreso']);
            $remolque2 = ($item['x_remolque_2_ingreso']  != false ? $item['x_remolque_2_ingreso'][1] : $item['x_remolque_2_ingreso']);
            $dolly = ($item['x_dolly_ingreso']  != false ? $item['x_dolly_ingreso'][1] : $item['x_dolly_ingreso']);
            $x_reference = ($item['x_reference'] != false ? $item['x_reference'] : $item['x_reference']);
        }
    } else {
        echo "Error al decodificar el JSON.";
    }
}

?>

<form id="miFormulario">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Vehiculo</th>
                <th scope="col">Validar</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-soft-secondary">
                <th scope="col">Operador</th>
                <th scope="col"></th>
            </tr>
            <?php if ($operador != null) { ?>
                <tr>
                    <th scope="row"><?php echo $operador ?></th>
                    <td>
                        <input type="checkbox" id="formCheck11" class="form-check-input">
                    </td>
                </tr>
            <?php } ?>
            <tr class="bg-soft-secondary">
                <th scope="col">Vehiculos</th>
                <th scope="col"></th>
            </tr>
            <?php if ($tracto != null) { ?>
                <tr>
                    <th scope="row"><?php echo $tracto ?></th>
                    <td>
                        <input type="checkbox" id="formCheck11" class="form-check-input">
                    </td>
                </tr>
            <?php } ?>
            <?php if ($remolque1 != null) { ?>
                <tr>
                    <th scope="row"><?php echo $remolque1 ?></th>
                    <td>
                        <input type="checkbox" id="formCheck11" class="form-check-input">
                    </td>
                </tr>
            <?php } ?>
            <?php if ($remolque2 != null) { ?>
                <tr>
                    <th scope="row"><?php echo $remolque2 ?></th>
                    <td>
                        <input type="checkbox" id="formCheck11" class="form-check-input">
                    </td>
                </tr>
            <?php } ?>
            <?php if ($dolly != null) { ?>
                <tr>
                    <th scope="row"><?php echo $dolly ?></th>
                    <td>
                        <input type="checkbox" id="formCheck11" class="form-check-input">
                    </td>
                </tr>
            <?php } ?>
            <tr class="bg-soft-secondary">
                <th scope="col">Contenedores</th>
                <th scope="col"></th>
            </tr>
            <?php if ($x_reference != null) { ?>
                <tr>
                    <th scope="row"><?php echo $x_reference ?></th>
                    <td>
                        <input type="checkbox" id="formCheck11" class="form-check-input">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>

<button type="button" class="btn btn-primary btn-sm btn-block" id="validar_equipo">Validar salida</button>

<script>
    function comprobarChecklist() {
        // Obtener todos los elementos checkbox dentro del formulario
        const checkboxes = document.querySelectorAll('#miFormulario input[type="checkbox"]');

        let todosSeleccionados = true;

        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                todosSeleccionados = false;
            }
        });

        if (todosSeleccionados) {
            notyf.success("¡Todos los equipos están validados! Iniciando maniobra");
            $('#checklist_maniobra').offcanvas('hide');
            $('#modal_iniciar').modal('show');
        } else {
            notyf.error("No todos los equipos están validados.");
        }
    }

    $("#validar_equipo").click(function() {
        comprobarChecklist();
    });
</script>
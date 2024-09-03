<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT id, nombre_operador from operadores";
$result = $cn->query($sqlSelect);
?>

<!-- Modal -->
<div class="modal fade" id="InicioReporteCola" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar reporte cola</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Select -->
                <form id="FormReporteCola">
                    <div class="tom-select-custom">
                        <select class="js-select form-select" id="operadorescola" name="operadorescola[]" multiple placeholder="Seleccionar operadores">
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_operador'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- End Select -->

                    <div class="flatpickr">

                        <input type="text" id="rangocola" name="rangocola" class="js-flatpickr form-control flatpickr-custom" placeholder="Select dates" data-hs-flatpickr-options='{
         "dateFormat": "d/m/Y",
         "mode": "range"
       }'>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" id="GenerarReporteCola">Generar reporte</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script>
    new TomSelect("#operadorescola", {
        plugins: ['dropdown_input', 'no_backspace_delete', 'remove_button', ],
        singleMultiple: true,
        hideSelected: false,
    });

    flatpickr("#rangocola", {
        dateFormat: "Y-m-d",
        mode: "range",
        locale: {
            rangeSeparator: ' - '
        }
    });
</script>
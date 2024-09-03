<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT id, nombre_operador from operadores where activo = 1  and nombre_operador not like '%PERM/OP%' order by nombre_operador asc";
$result = $cn->query($sqlSelect);
?>

<!-- Modal -->
<div class="modal fade" id="InicioReporteStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Select -->
                <form id="FormReporteStatus">
                    <div class="m-3">
                        <select class="js-example-basic-multiple select2" id="operadores" name="operadores[]" multiple="multiple" placeholder="Seleccionar operadores">
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_operador'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- End Select -->

                    <div class="flatpickr m-3">

                        <input type="text" id="rango" name="rango" class="js-flatpickr form-control flatpickr-custom" placeholder="Seleccionar fechas" data-hs-flatpickr-options='{
         "dateFormat": "d/m/Y",
         "mode": "range"
       }'>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-sm" id="GenerarPDF">Descargar PDF</button>
                <button type="button" class="btn btn-primary btn-sm" id="GenerarReporte">Generar reporte</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script>
    $('.js-example-basic-multiple').select2({
        width: '100%',
        tags: true,
        tokenSeparators: [',', ' '],
    });

    flatpickr("#rango", {
        dateFormat: "Y-m-d",
        mode: "range",
        locale: {
            rangeSeparator: ' - '
        }
    });
</script>
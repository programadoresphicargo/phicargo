<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$fecha = date('Y-m-d');
$sql = "SELECT *, empresas.nombre as nombre_empresa, bancos.nombre as nombre_banco FROM cuentas inner join bancos on bancos.id_banco = cuentas.id_banco inner join empresas on empresas.id_empresa = cuentas.id_empresa";
$resultado = $cn->query($sql);
?>

<div class="modal fade" id="ingresar_saldo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresar nuevo saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormIngresarSaldo">
                    <div class="mb-3">
                        <label class="form-label">Fecha saldo ingresar</label>
                        <input type="text" id="fecha_saldo" name="fecha_saldo" class="form-control" value='<?php echo $fecha ?>' readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cuenta</label>

                        <select class="form-select" id="id_cuenta_ingresar" name="id_cuenta_ingresar" readonly>
                            <?php while ($row = $resultado->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_cuenta'] ?>"><?php echo $row['nombre_empresa'] . ' ' . $row['nombre_banco'] . ' ' . $row['referencia'] ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nuevo saldo</label>
                        <input type="number" id="nuevo_saldo" name="nuevo_saldo" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Disponible</label>
                        <input type="number" id="disponible" name="disponible" class="form-control" value="">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="registrar_saldo">Registrar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    const boton2 = document.getElementById('registrar_saldo');

    boton2.addEventListener('click', () => {
        var datos = $('#FormIngresarSaldo').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../saldos/ingresar_saldo.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    notyf.success('Datos guardados correctamente');
                    $('#ingresar_saldo_modal').modal('hide');
                    $('#saldos_generales').load('../informes/saldos_generales.php', {
                        'fecha': $("#fecha_saldo").val(),
                        'empresas': selectedCheckboxes,
                        'opcion': 'dia'
                    });
                } else if (respuesta == 2) {
                    notyf.success('Datos guardados correctamente');
                    $('#saldos_generales').load('../informes/saldos_generales.php', {
                        'fecha': $("#fecha_saldo").val(),
                        'empresas': selectedCheckboxes,
                        'opcion': 'dia'
                    });
                } else {
                    notyf.error(respuesta);
                }
            }
        });
    });
</script>
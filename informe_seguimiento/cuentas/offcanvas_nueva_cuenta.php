<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM bancos";
$resultado = $cn->query($sql);

$sql2 = "SELECT * FROM empresas";
$resultado2 = $cn->query($sql2);

?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="añadir_nueva_cuenta" aria-labelledby="offcanvasRightLabel" style="width: 30%;">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Cuenta bancaria</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="form_nueva_cuenta">

            <div class="mb-3">
                <label class="form-label" for="">ID Cuenta</label>
                <input class="form-control" type="text" id="id_cuenta" name="id_cuenta" readonly>
            </div>

            <div class="mb-3">
                <!-- Select -->
                <label class="form-label" for="">Empresa</label>
                <select class="form-select" id="id_empresa" name="id_empresa">
                    <?php while ($row2 = $resultado2->fetch_assoc()) { ?>
                        <option value="<?php echo $row2['id_empresa'] ?>"><?php echo $row2['nombre'] ?></option>
                    <?php } ?>
                </select>
                <!-- End Select -->
            </div>

            <div class="mb-3">
                <label class="form-label" for="">Banco</label>
                <!-- Select -->
                <select class="form-select" id="id_banco" name="id_banco">
                    <?php while ($row = $resultado->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_banco'] ?>"><?php echo $row['nombre'] ?></option>
                    <?php } ?>
                    <option value="0"></option>
                </select>
                <!-- End Select -->
            </div>

            <div class="mb-3">
                <label class="form-label" for="">Tipo de cuenta</label>
                <!-- Select -->
                <select class="form-select" id="tipo" name="tipo">
                    <option selected="Cuenta bancaria">Cuenta bancaria</option>
                    <option value="Credito revolvente">Credito revolvente</option>
                    <option value="Inversiones">Inversiones</option>
                    <option value="Tarjeta de credito">Tarjeta de credito</option>
                    <option value="Factoraje">Factoraje</option>
                    <option value="Cartera">Cartera</option>
                </select>
                <!-- End Select -->
            </div>

            <div class="mb-3">
                <label class="form-label" for="">Moneda</label>
                <!-- Select -->
                <select class="form-select" id="moneda" name="moneda">
                    <option selected="MXN">MXN</option>
                    <option value="USD">USD</option>
                </select>
                <!-- End Select -->
            </div>

            <div class="mb-3">
                <label class="form-label" for="">Referencia de cuenta</label>
                <input class="form-control" type="text" id="referencia" name="referencia">
            </div>
        </form>
    </div>
    <div class="offcanvas-footer">
        <button class="btn btn-success btn-block btn-sm" id="registrar_cuenta" style="display: none;">Registrar cuenta</button>
        <button class="btn btn-danger btn-block btn-sm" id="guardar_cambios_cuenta" style="display: none;">Guardar cambios</button>
    </div>
</div>

<script>
    const registrar_cuenta = document.getElementById('registrar_cuenta');

    registrar_cuenta.addEventListener('click', () => {
        datos = $("#form_nueva_cuenta").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../cuentas/registrar_cuenta.php",
            success: function(data) {
                if (data == 1) {
                    $("#añadir_nueva_cuenta").offcanvas('hide');
                    notyf.success('Cuenta registrada correctamente.');
                    $("#cuentas").load('../cuentas/cuentas.php');
                    var formulario = document.getElementById("form_nueva_cuenta");
                    formulario.reset();
                } else {
                    notyf.error(data);
                }
            },
            error: function() {
                notyf.error('Error');
            }
        });
    });

    const btn_editar_cuenta = document.getElementById('guardar_cambios_cuenta');

    btn_editar_cuenta.addEventListener('click', () => {
        datos = $("#form_nueva_cuenta").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../cuentas/editar_cuenta.php",
            success: function(data) {
                if (data == 1) {
                    $("#añadir_nueva_cuenta").offcanvas('hide');
                    notyf.success('Cuenta editada correctamente.');
                    $("#cuentas").load('../cuentas/cuentas.php');
                    var formulario = document.getElementById("form_nueva_cuenta");
                    formulario.reset();
                } else {
                    notyf.error(data);
                }
            },
            error: function() {
                notyf.error('Error');
            }
        });
    });
</script>
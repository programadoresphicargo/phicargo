<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050">
    <div class="modal-dialog modal-xl shadow-lg p-3 mb-5 bg-white rounded" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <h2 class="page-header-title">Maniobra</h2>
                        </div>
                    </div>

                    <button id="registrar_maniobra" type="button" class="btn btn-primary btn-sm" onclick="validateForm('form_maniobra')" style="display: none;">Guardar</button>
                    <button id="cancelar_maniobra" type="button" class="btn btn-sm btn-danger" onclick="confirmar_cancelacion()" style="display: none;">Cancelar</button>
                    <button id="editar_maniobra" type="button" class="btn btn-sm btn-success" style="display: none;">Editar maniobra</button>
                    <button id="guardar_maniobra" type="button" class="btn btn-sm btn-primary" style="display: none;">Guardar cambios</button>

                </div>

                <form id="form_maniobra">

                    <div class="row mb-4">
                        <div class="col-6">

                            <div class="mb-3">
                                <label class="form-label">ID maniobra</label>
                                <input id="id_maniobra" name="id_maniobra" class="form-control form-select-sm">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ID CP</label>
                                <input id="id_cp" name="id_cp" class="form-control form-select-sm">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipo de maniobra</label>
                                <select id="tipo_maniobra" name="tipo_maniobra" class="form-control form-select-sm">
                                    <option value="retiro">Retiro</option>
                                    <option value="ingreso">Ingreso</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect1">Inicio programado</label>
                                <input id="inicio_programado" name="inicio_programado" class="form-control form-select-sm" type="datetime-local" required>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="mb-3">
                                <label class="form-label">Terminal</label>
                                <input id="terminal" name="terminal" class="form-control form-select-sm" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Operador</label>
                                <select id="operador_id" name="operador_id" class="form-control form-select-sm" required>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Unidad</label>
                                <select id="vehicle_id" name="vehicle_id" class="form-control form-select-sm" required>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Remolque 1</label>
                                <select id="trailer1_id" name="trailer1_id" class="form-control form-select-sm">
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Remolque 2</label>
                                <select id="trailer2_id" name="trailer2_id" class="form-control form-select-sm">
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dolly</label>
                                <select id="dolly_id" name="dolly_id" class="form-control form-select-sm">
                                </select>
                            </div>

                        </div>
                    </div>

                </form>

                <div id="contenedores_maniobra"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var id_cp = 0;
    var partner_id = 0;

    function validateForm(formId) {
        const form = document.getElementById(formId);
        if (!form) {
            console.error(`Formulario con id "${formId}" no encontrado.`);
            return;
        }

        const requiredFields = form.querySelectorAll('[required]');
        let formIsValid = true;
        let emptyFields = [];

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                formIsValid = false;
                emptyFields.push(field.getAttribute('name'));
                field.classList.add('border-danger');
            } else {
                field.classList.remove('border-danger');
            }
        });

        if (!formIsValid) {
            emptyFields.forEach(field => {
                notyf.error(`El campo ${field} está vacío`);
            });
        } else {
            guardar_maniobra();
        }
    }

    function guardar_maniobra() {
        var datos = $("#form_maniobra").serialize();
        $.ajax({
            url: '../maniobra_detalle/registrar_maniobra.php',
            type: 'POST',
            data: datos,
            success: function(response) {
                if (response == '1') {
                    $("#exampleModal").modal('hide');
                    notyf.success('Maniobra registrada correctamente');
                    cargar_maniobra(id_cp, partner_id);
                } else {
                    Swal.fire({
                        title: "Error",
                        html: response,
                        icon: "error"
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error(textStatus);
            }
        });
    }
</script>
<script>
    function confirmar_cancelacion(id_maniobra) {
        var datos = $('#form_maniobra').serialize();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas realmente cancelar este registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../maniobra_detalle/cancelar_maniobra.php',
                    type: 'POST',
                    data: datos,
                    success: function(response) {
                        if (response == '1') {
                            $("#exampleModal").modal('hide');
                            Swal.fire(
                                '¡Cancelado!',
                                'El registro ha sido cancelado.',
                                'success'
                            );
                            cargar_maniobra(id_cp, partner_id);
                        } else {
                            notyf.error(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el registro.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
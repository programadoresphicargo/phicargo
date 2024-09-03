<script>
    var id_usuario = '<?php echo $_SESSION['userID']; ?>'

    function comprobar_permiso(id_usuario) {
        $.ajax({
            url: "../metodos/comprobar_permiso_usuarios.php",
            type: 'POST',
            data: {
                'id_usuario': id_usuario
            },
            success: function(result) {
                if (result === 'Administrador' || result === 'Contabilidad' || result === 'Direccion') {
                    $("#page_saldos").css('display', 'block');
                    $("#page_datos_servi").css('display', 'block');
                    $("#page_tank").css('display', 'block');
                }
                
                if (result === 'Servicontainer') {
                    $("#page_datos_servi").css('display', 'block');
                } else {
                }
                
                if (result === 'Trafico' || result === 'Monitoreo' || result === 'Administrador' || result === 'Direccion') {
                    $("#page_viajes_ejecutivo").css('display', 'block');
                    $("#page_maniobras").css('display', 'block');
                    $("#page_tipo_armado").css('display', 'block');
                }

                if (result === 'Mantenimiento' || result === 'Administrador' || result === 'Direccion') {
                    $("#page_mantenimiento").css('display', 'block');
                }

                if (result === 'Contabilidad' || result === 'Administrador' || result === 'Direccion') {
                    $("#page_cartera").css('display', 'block');
                    $("#page_saldos_carta_porte").css('display', 'block');
                    $("#page_pagos").css('display', 'block');
                }
            },
        });
    }

    var radios = document.getElementsByName('grupo');
    var opcion;
    var selectedCheckboxes = [];

    for (var i = 0; i < radios.length; i++) {
        radios[i].addEventListener('change', function() {
            opcion = this.value;
            switch (this.value) {
                case 'dia':
                    $('#listado_reporte').hide();
                    $('#vista_agrupada').hide();

                    comprobar_permiso(id_usuario);

                    $("#page_comentarios").css('display', 'block');

                    break;
                case 'semana':
                    $('#vista_agrupada').show();
                    $('#listado_reporte').show();
                    $('#listado_reporte').load('listado_semanal.php');

                    $("#comentarios").css('display', 'none');
                    $("#page_saldos").css('display', 'none');
                    $("#page_cartera").css('display', 'none');
                    $("#page_saldos_carta_porte").css('display', 'none');
                    $("#page_pagos").css('display', 'none');
                    $("#page_viajes_ejecutivo").css('display', 'none');
                    $("#page_maniobras").css('display', 'none');
                    $("#page_tipo_armado").css('display', 'none');
                    $("#page_mantenimiento").css('display', 'none');
                    $("#page_comentarios").css('display', 'none');

                    break;
                case 'mes':
                    $('#listado_reporte').show();
                    $('#listado_reporte').load('listado_meses.php');

                    $("#comentarios").css('display', 'none');
                    $("#page_saldos").css('display', 'none');
                    $("#page_cartera").css('display', 'none');
                    $("#page_saldos_carta_porte").css('display', 'none');
                    $("#page_pagos").css('display', 'none');
                    $("#page_viajes_ejecutivo").css('display', 'none');
                    $("#page_maniobras").css('display', 'none');
                    $("#page_tipo_armado").css('display', 'none');
                    $("#page_mantenimiento").css('display', 'none');
                    $("#page_comentarios").css('display', 'none');
                    break;
            }
        });
    }

    var fechaActual = new Date();

    var año = fechaActual.getFullYear();
    var mes = fechaActual.getMonth() + 1;
    var dia = fechaActual.getDate();
    var hora = fechaActual.getHours();
    var minutos = fechaActual.getMinutes();
    var segundos = fechaActual.getSeconds();
    var fecha = año + '-' + (mes < 10 ? '0' : '') + mes + '-' + (dia < 10 ? '0' : '') + dia;

    const botonCuentas = document.getElementById('abrir_cuentas');

    botonCuentas.addEventListener('click', () => {
        $("#cuentas").load('../cuentas/cuentas.php');
        $("#listado_cuentas").modal('show');
    });

    const botoncomentarios = document.getElementById('abrir_canvas_comentarios');

    botoncomentarios.addEventListener('click', () => {
        $("#canvas_comentarios").offcanvas('show');
    });

    const boton_abrir_servi = document.getElementById('abrir_modal_datos');

    boton_abrir_servi.addEventListener('click', () => {
        $("#modal_datos_servi").modal('show');
    });

    const boton_abrir_tank = document.getElementById('abrir_modal_tank');

    boton_abrir_tank.addEventListener('click', () => {
        $("#modal_datos_tank").modal('show');
    });

    function consultarViajes() {
        var checkboxes = document.getElementsByName('estados[]');
        selectedCheckboxes = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedCheckboxes.push(checkboxes[i].value);

                switch (checkboxes[i].value) {
                    case '1':
                        $("#listado_reporte").css('display', 'block');

                        comprobar_permiso(id_usuario);

                        $("#page_comentarios").css('display', 'block');
                        break;
                    case '2':
                        $("#page_saldos").css('display', 'block');
                        break;
                    case '3':
                        $("#page_saldos").css('display', 'block');
                        break;
                    default:
                        break;
                }
            } else {
                switch (checkboxes[i].value) {
                    case '1':
                        $("#page_saldos").css('display', 'none');
                        $("#page_cartera").css('display', 'none');
                        $("#page_saldos_carta_porte").css('display', 'none');
                        $("#page_pagos").css('display', 'none');
                        $("#page_viajes_ejecutivo").css('display', 'none');
                        $("#page_maniobras").css('display', 'none');
                        $("#page_tipo_armado").css('display', 'none');
                        $("#page_mantenimiento").css('display', 'none');
                        break;
                    case '2':
                        $("#page_cartera").css('display', 'none');
                        $("#page_saldos_carta_porte").css('display', 'none');
                        $("#page_pagos").css('display', 'none');
                        $("#page_viajes_ejecutivo").css('display', 'none');
                        $("#page_maniobras").css('display', 'none');
                        $("#page_tipo_armado").css('display', 'none');
                        $("#page_mantenimiento").css('display', 'none');
                        break;
                    case '3':
                        $("#page_cartera").css('display', 'none');
                        $("#page_saldos_carta_porte").css('display', 'none');
                        $("#page_pagos").css('display', 'none');
                        $("#page_viajes_ejecutivo").css('display', 'none');
                        $("#page_maniobras").css('display', 'none');
                        $("#page_tipo_armado").css('display', 'none');
                        $("#page_mantenimiento").css('display', 'none');
                        break;
                    default:
                        break;
                }
            }
        }

        $('#saldos_generales').load('../informes/saldos_generales.php', {
            'empresas': $('#grupoCheck').serialize(),
            'fecha': fecha,
            'empresas': selectedCheckboxes,
            'opcion': 'dia'
        });
        console.log('Valores seleccionados:', selectedCheckboxes);
    }

    flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        enableTime: false,
        altInput: true,
        altFormat: "F j, Y",
        defaultDate: new Date(),
        locale: "es",
        onChange: function(selectedDates, dateStr, instance) {
            console.log("Fecha seleccionada: " + dateStr);
            console.log($('#empresas_check').serialize());
            cargar_contenidos(dateStr, 'dia');
        }
    });

    function cargar_contenidos(fecha, opcion) {

        $("#fecha_saldo").val(fecha).change();
        $("#fecha_servi").val(fecha).change();
        $("#fecha_tank").val(fecha).change();

        $('#saldos_generales').load('../informes/saldos_generales.php', {
            'empresas': $('#grupoCheck').serialize(),
            'fecha': fecha,
            'empresas': selectedCheckboxes,
            'opcion': 'dia'
        });

        $('#ingresos').load('../informes/ingresos.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#datos_servi').load('../informes/datos_servi.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#tank').load('../informes/tank-container.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#ejecutivos_viajes').load('../informes/viajes_ejecutivos.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#maniobras').load('../informes/maniobras.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#tipo_armado').load('../informes/tipo_armado.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#mantenimiento').load('../informes/mantenimiento.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#cartera').load('../informes/cartera.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#saldo_carta_porte').load('../informes/saldo_carta_porte.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#pagos').load('../informes/pagos.php', {
            'fecha': fecha,
            'opcion': opcion
        });

        $('#comentarios').load('../comentarios/comentarios.php', {
            'fecha': fecha,
            'opcion': opcion
        });
    }

    var fechaActual = new Date();
    var dia = fechaActual.getDate();
    var mes = fechaActual.getMonth() + 1;
    var anio = fechaActual.getFullYear();
    var fechaFormateada = anio + '-' + mes + '-' + dia;
    $("#fecha_saldo").val(fechaFormateada).change();
    cargar_contenidos(fechaFormateada, 'dia');
</script>
<header id="barra_carga" class="barraInferior" style="display:none">

    <div class="card card-body mb-3 mb-lg-5">
        <h5 id="msg">Enviando correo</h5>

        <div class="d-flex justify-content-between align-items-center">
            <div class="progress flex-grow-1" style="height: 12px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="ms-4" id="porcentaje">0%</span>
        </div>
    </div>

</header>

<script src="../../assets/js/vendor.min.js"></script>
<script src="../../assets/js/theme.min.js"></script>
<script src="../../js/js.cookie.js"></script>
<script src="../../assets/js/notyf.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-deparam/0.5.1/jquery-deparam.min.js"></script>
<script src="../../js/push.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="../../assets/js/select2.min.js"></script>
<script src="../../js/jquery.tabledit.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.5.0/js/rowGroup.dataTables.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.3.1/js/dataTables.searchPanes.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.3.1/js/searchPanes.dataTables.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.3.1/js/searchPanes.bootstrap5.js"></script>

<script src="https://cdn.datatables.net/searchbuilder/1.7.1/js/dataTables.searchBuilder.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.7.1/js/searchBuilder.dataTables.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>


<script src="https://cdn.datatables.net/select/2.0.2/js/dataTables.select.js"></script>
<script src="https://cdn.datatables.net/select/2.0.2/js/select.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<?php
require_once('../../gestion_viajes/reportes/modal.php');
?>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const logoutButton = document.getElementById('logoutButton');
        if (logoutButton) {
            logoutButton.addEventListener('click', () => {
                Swal.fire({
                    title: '¡Adiós!',
                    text: 'Selecciona "Salir" si quieres finalizar tu sesión.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Salir',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../../login/inicio/salirsistema.php';
                    }
                });
            });
        }
    });
</script>

<script>
    (function() {
        const $dropdownBtn = document.getElementById('selectThemeDropdown')
        const $variants = document.querySelectorAll(`[aria-labelledby="selectThemeDropdown"] [data-icon]`)
        const setActiveStyle = function() {
            $variants.forEach($item => {
                if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                    $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`
                    return $item.classList.add('active')
                }

                $item.classList.remove('active')
            })
        }

        $variants.forEach(function($item) {
            $item.addEventListener('click', function() {
                HSThemeAppearance.setAppearance($item.getAttribute('data-value'))
            })
        })

        setActiveStyle()

        window.addEventListener('on-hs-appearance-change', function() {
            setActiveStyle()
        })
    })()
</script>

<script>
    (function() {
        HSBsDropdown.init()
        new HSMegaMenu('.js-mega-menu', {
            desktop: {
                position: 'left'
            }
        })
    })()
</script>

<script>
    (function() {
        new HSStepForm('.js-step-form', {
            finish($el) {
                const $successMessageTempalte = $el.querySelector('.js-success-message').cloneNode(true)

                $successMessageTempalte.style.display = 'block'

                $el.style.display = 'none'
                $el.parentElement.appendChild($successMessageTempalte)
            }
        })
    })();
</script>

<script>
    const notyf = new Notyf({
        duration: 9000,
        position: {
            x: 'right',
            y: 'bottom',
        },
        types: [{
                type: 'success',
                background: '#28ac44',
                duration: 6000,
                dismissible: true
            },
            {
                type: 'warning',
                background: 'orange',
                icon: {
                    className: 'material-icons',
                    tagName: 'i',
                    text: 'warning'
                }
            },
            {
                type: 'error',
                background: '#9a0405',
                duration: 6000,
                dismissible: true
            },
            {
                type: 'info',
                background: '#246cd0',
                icon: false
            },
            {
                type: 'custom-success',
                background: '#4CAF50',
                icon: {
                    className: 'notyf__icon--success',
                    tagName: 'i',
                    text: '', // Puedes personalizar el icono aquí si lo deseas
                }
            }
        ]
    });
</script>
<script>
    function abrir_entrega(id) {
        $('#modal_entrega').modal('show');
        $.ajax({
            url: '../../monitoreo/entrega/buscar_entrega.php',
            type: 'GET',
            data: {
                'id': id
            },
            dataType: 'json',
            success: function(data) {

                alert(data.id);

                var id = data.id;
                var start = data.start;
                var end = data.end;
                var texto = data.texto;
                var title = data.title;
                var usuario = data.usuario;
                var nombre_usuario = data.nombre_usuario;
                var color = data.color;

                alert(id + start + end + texto + title + usuario + nombre_usuario + color);

                $('#id').val(id).change();
                $('#titulo').val(title).change();
                $('#color').val(color).change();
                $('#fecha_creado').val(start).change();
                $('#usuario_autor').val(nombre_usuario).change();
                $('.bg-color').css('background-color', color);

            },
            error: function(xhr, status, error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    }
</script>

<script>
    function alertar_reportes() {
        $.ajax({
            url: '../../gestion_viajes/reportes/contador_noti.php',
            success: function(data) {
                if (data == 1) {
                    $("#led").addClass("btn-status-danger animate__animated animate__flash animate__infinite animate__slower");
                    $("#navbarNotificationsDropdown").addClass("bg-danger animate__animated animate__flash animate__infinite");
                    Push.create("Phi Cargo App", {
                        body: "Existen reportes de operadores que no han sido atendidos.",
                        icon: '../../img/alert.png',
                        timeout: 4000,
                        onClick: function() {
                            window.focus();
                            this.close();
                        }
                    });
                } else {
                    $("#led").removeClass("btn-status-danger animate__animated animate__flash animate__infinite animate__slower");
                    $("#navbarNotificationsDropdown").removeClass("bg-danger animate__animated animate__flash animate__infinite");
                    $("#led").addClass("btn-status-success");
                }
            },
            error: function(xhr, status, error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    }

    alertar_reportes();
    setInterval(alertar_reportes, 300000);

    function alertar_reportes_detenciones() {
        $.ajax({
            url: '../../gestion_viajes/detenciones/notificacion.php',
            success: function(data) {
                if (data == '1') {
                    $("#notificaciones_detenciones").addClass("bg-warning animate__animated animate__flash animate__infinite");
                    Push.create("Phi Cargo App", {
                        body: "Existen detenciones que no han sido atendidas.",
                        icon: '../../img/icons/logo-detencion.png',
                        timeout: 4000,
                        onClick: function() {
                            window.focus();
                            this.close();
                        }
                    });
                } else {
                    $("#notificaciones_detenciones").removeClass("bg-warning animate__animated animate__flash animate__infinite");
                }
            },
            error: function(xhr, status, error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    }

    alertar_reportes_detenciones();
    setInterval(alertar_reportes_detenciones, 300000);

    $("#navbarNotificationsDropdown").click(function() {
        $.ajax({
            type: "POST",
            url: '../../includes2/notificaciones.php',
            success: function(data) {
                $('#notificaciones').html(data);
            },
            error: function(xhr, status, error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });

        $.ajax({
            type: "POST",
            url: '../../includes2/notificaciones_maniobras.php',
            success: function(data) {
                $('#notificaciones_maniobras').html(data);
            },
            error: function(xhr, status, error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    });

    function comprobar_posicionamiento() {
        $.ajax({
            url: '../../alertas_sistema/posicionamiento.php',
            success: function(data) {
                if (data != '') {
                    notyf.open({
                        type: 'info',
                        message: 'Unidades sin posicionar en Motum más de 20 minutos:' + data,
                        icon: true,
                        dismissible: true,
                        duration: 300000
                    });
                }
            },
            error: function(xhr, status, error) {
                notyf.error('Error ajax');
            }
        });
    }

    setInterval(comprobar_posicionamiento, 300000);
</script>

<script>
    function alertas_detenciones() {
        $.ajax({
            type: 'POST',
            url: "../../gestion_viajes/detenciones/registros.php",
            success: function(respuesta) {
                $("#alertas-detenciones").html(respuesta);
            }
        });
    }

    alertas_detenciones();

    $('#notificaciones_detenciones').on('click', function() {
        alertas_detenciones();
    });


    function notificaciones_eo() {
        $.ajax({
            url: '../../gestion_viajes/notificaciones/notificaciones_estatus_op.php',
            success: function(data) {
                $("#notificaciones_estatus_nuevos").html(data);
            },
            error: function(xhr, status, error) {
                notyf.error('Error ajax');
            }
        });
    }

    const dropdown = document.getElementById('modal_notificaciones_estatus_operador');

    dropdown.addEventListener('blur', () => {
        $.ajax({
            url: '../../gestion_viajes/notificaciones/ver_notificacion.php',
            success: function(data) {
                contador_noti_reo();
            },
            error: function(xhr, status, error) {
                notyf.error('Error ajax');
            }
        });
    });

    let numnotireo = null;

    function contador_noti_reo() {
        $.ajax({
            url: '../../gestion_viajes/notificaciones/contador.php',
            success: function(data) {
                if (data !== numnotireo && data !== '0') {
                    $("#num_noti_reo").html(data);

                    if (isAudioEnabled) {
                        var audio = document.getElementById('notificationSound');
                        audio.play().catch(error => console.log("Error al reproducir el audio: ", error));
                    }

                    numnotireo = data;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }

    contador_noti_reo();
    setInterval(contador_noti_reo, 240000);

    function notificaciones_alertas() {
        $.ajax({
            url: '../../gestion_viajes/alertas/gps/notificaciones.php',
            success: function(data) {
                $("#notificaciones_alertas").html(data);
            },
            error: function(xhr, status, error) {
                notyf.error('Error ajax :(');
            }
        });
    }

    notificaciones_alertas();
    setInterval(notificaciones_alertas, 240000);
</script>

</body>

</html>
<?php
require_once('../../monitoreo/entrega/modal.php');
require_once('../../gestion_viajes/detenciones/funciones.php');
require_once('../../gestion_viajes/reportes/modal.php');
require_once('../../gestion_viajes/alertas/gps/modal.php');
?>

<audio id="notificationSound" src="../../audios/estatus_operador.mp3"></audio>

<script>
    let isAudioEnabled = false;

    document.body.addEventListener('click', function() {
        isAudioEnabled = true;
        console.log("Interacción detectada: Audio habilitado.");
        var audio = document.getElementById('notificationSound');
        audio.play().then(() => audio.pause());
    }, {
        once: true
    });
</script>
<?php
require_once('getCP.php');
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');
require_once('../../tiempo/conversiones.php');

$cn = conectar();
$cps = json_decode($json2, true);

?>
<div class="table-responsive">
    <table class="table table-align-middle table-hover table-sm" id="tabla-datos">
        <thead class="thead-light">
            <tr class="ignorar">
                <th class="text-center" scope="col">Referencia</th>
                <th class="text-center" scope="col">Carta porte</th>
                <th class="text-center" scope="col">Fecha</th>
                <th class="text-center" scope="col">POD</th>
                <th class="text-center" scope="col">Fecha Finalizado</th>
                <th class="text-center" scope="col">Finalizado por</th>
                <th class="text-center" scope="col">Sucursal</th>
                <th class="text-center" scope="col">Ejecutivo</th>
                <th class="text-center" scope="col">Operador</th>
                <th class="text-center" scope="col">Unidad</th>
                <th class="text-center" scope="col">Ruta</th>
                <th class="text-center" scope="col">Tipo</th>
                <th class="text-center" scope="col">Contenedores</th>
                <th class="text-center" scope="col">Cliente</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($cps as $cp) { ?>

                <tr onclick="onRowClick(this)" id="<?php echo $cp['travel_id'][0]  ?>" id_cliente="<?php echo $cp['partner_id'][0]  ?>">

                    <td class="openentrega"><span class="d-block h5 mb-0"><?php echo $cp['travel_id'] != false ? $cp['travel_id'][1] : '' ?></span></td>
                    <td width="100px"><?php echo $cp['name'] ?></td>
                    <td width="100px"><?php echo $cp['date_order'] != false ? date('Y-m-d', strtotime(utctocst($cp['date_order']))) : '' ?></td>

                    <td>
                        <?php
                        $id = $cp['travel_id'][0];

                        $sqlpod = "SELECT * FROM pods where id_viaje = $id";
                        $resultadopod = $cn->query($sqlpod);
                        if ($resultadopod->num_rows != 0) {
                        ?>
                            <span class="badge bg-success"><i class="bi bi-check2"></i>Enviado</span>
                        <?php } ?>
                    </td>

                    <td>
                        <?php
                        $id = $cp['travel_id'][0];

                        $sqlv = "SELECT nombre, DATE(fecha_finalizado) AS fecha_sin_hora FROM viajes inner join usuarios on viajes.usuario_finalizado = usuarios.id_usuario where id = $id";
                        $resultadov = $cn->query($sqlv);
                        $rowv = $resultadov->fetch_assoc();
                        if ($resultadov->num_rows != 0) {
                        ?>
                            <?php echo $rowv['fecha_sin_hora'] ?>
                        <?php } ?>
                    </td>

                    <td>
                        <?php
                        if ($resultadov->num_rows != 0) {
                        ?>
                            <?php echo $rowv['nombre'] ?>
                        <?php } ?>
                    </td>

                    <td><?php echo $cp['store_id'] != false ? $cp['store_id'][1] : '' ?></td>
                    <td><?php echo $cp['x_ejecutivo_viaje_bel'] != false ? $cp['x_ejecutivo_viaje_bel'] : '' ?></td>
                    <td><?php echo $cp['x_operador_bel_id'] != false ? $cp['x_operador_bel_id'][1] : '' ?></td>
                    <td><?php echo $cp['vehicle_id'] != false ? $cp['vehicle_id'][1] : '' ?></td>
                    <td><?php echo $cp['route_id'] != false ? $cp['route_id'][1] : '' ?></td>

                    <?php if ($cp['x_modo_bel'] == 'imp') { ?>
                        <td><span class="badge bg-warning rounded-pill">Imp</span></td>
                    <?php } else if ($cp['x_modo_bel'] == 'exp') { ?>
                        <td><span class="badge bg-danger rounded-pill">Exp</span></td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>

                    <td><?php echo $cp['x_reference'] != false ? $cp['x_reference'] : '' ?></td>
                    <td><?php echo $cp['partner_id'] != false ? $cp['partner_id'][1] : '' ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    var filaId;

    function onRowClick(row) {
        filaId = $(row).attr('id');

        if ($(event.target).closest('td').hasClass('openstatus')) {
            console.log('caso 1');
            $('#miOffcanvas').offcanvas('show');

            var filacliente = $(row).attr('id_cliente');
            var primerTdValor = $(row).find('td:first').text();
            $('#titulo_viaje').html(primerTdValor);

            $.ajax({
                type: "POST",
                data: {
                    id: filaId,
                },
                url: "../detalle/correos.php",
                success: function(respuesta) {
                    alert(respuesta);
                    $('#status_enviados').html(respuesta);
                }
            });
            cargar_estado(filaId);
            $('#contenido_envio_status').load('../status/modal/contenido_modal.php', {
                'id': filaId
            });
            enviarViaje(filaId, filacliente);
            placas_universal = $(row).find('td:eq(6)').text();
            modo_universal = $(row).find('td:eq(8)').text();

        } else if ($(event.target).closest('td').hasClass('openentrega')) {
            console.log('caso 2');
            $('#entregaturnooffcanvas').offcanvas('show');
            $('#entregaviajeid').val(filaId);

            $("#listadoentregasviaje").load('../status/modal/entregas.php', {
                'id_viaje': filaId
            });

        } else if ($(event.target).closest('td').hasClass('openalertas')) {
            $('#alertasoffcanvas').offcanvas('show');
            $("#listado_alertas").load('../alertas/canvas/listado.php', {
                'id_viaje': filaId
            });

        } else if ($(event.target).hasClass('ignorar')) {

        } else {
            console.log('caso 3');
            window.location.href = "../../viajes/detalle/index.php?id=" + filaId;
        }
    }

    var flatpickrInstance = flatpickr("#rangoInput", {
        mode: "range",
        FormData: "y-m-d",
        onClose: function(selectedDates, dateStr, instance) {
            if (selectedDates[0] === selectedDates[0]) {
                console.log("PRIMERA OPCION");
            } else if (selectedDates[0] !== selectedDates[0]) {
                console.log("SEGUNDA OPCION");
            } else {
                console.log("La selección no es válida.");
            }
        }
    });

    var selectedOptions = []; // Array para almacenar las opciones seleccionadas
    var fechaInicio = null;
    var fechaFin = null;

    $("#rangoInput").on("change", function() {

        var selectedDates = flatpickrInstance.selectedDates;
        if (selectedDates.length === 2) {
            fechaInicio = selectedDates[0];
            fechaFin = selectedDates[1];
            console.log("Fecha de inicio:", fechaInicio);
            console.log("Fecha de fin:", fechaFin);

            var table2 = document.getElementById('tabla-datos');
            while (table2.rows.length > 1) {
                table2.deleteRow(1);
            }
            table2.innerHTML = contenidoOriginal;

            if (selectedDates[0] != selectedDates[1]) {
                console.log('caso 5');
                agruparTabla("tabla-datos", selectedOptions, {
                    inicio: fechaInicio,
                    fin: fechaFin,
                }, criterioBusqueda);
            } else if (selectedDates[0] != selectedDates[1]) {
                console.log('caso 6');
                agruparTabla("tabla-datos", selectedOptions, {
                    inicio: fechaInicio,
                    fin: fechaFin,
                }, criterioBusqueda);
            } else {
                console.log('caso 7');
                agruparTabla("tabla-datos", selectedOptions, {
                    inicio: fechaInicio,
                    fin: fechaFin,
                }, criterioBusqueda);
            }
        }
    });

    $("#borrar_fecha").on("click", function(e) {
        flatpickrInstance.setDate(null);

        var table2 = document.getElementById('tabla-datos');
        while (table2.rows.length > 1) {
            table2.deleteRow(1);
        }
        table2.innerHTML = contenidoOriginal;

        agruparTabla("tabla-datos", selectedOptions, null, null);
        fechaInicio = null;
        fechaFin = null;
    });

    var table = document.getElementById('tabla-datos');
    var contenidoOriginal = table.innerHTML;

    function agruparTabla(tablaId, columnasReferencia, filtroFecha, criteriosBusqueda) {
        // Obtener la tabla y todas las filas
        var table = document.getElementById(tablaId);
        var rows = table.getElementsByTagName("tr");

        // Verificar si no se proporcionaron columnas de referencia
        if (!columnasReferencia || columnasReferencia.length === 0) {
            filtrarPorFecha(rows, filtroFecha);
            filtrarPorCriterios(rows, criteriosBusqueda);
            return; // Finalizar la ejecución de la función
        }

        // Crear una estructura de datos para almacenar los grupos
        var grupos = {};

        // Recorrer las filas y agrupar los datos
        for (var i = 1; i < rows.length; i++) {
            var fila = rows[i];
            var fecha = fila.cells[4].textContent; // Obtener el valor de la columna de fecha

            // Filtrar por fecha si se proporcionó un filtro
            if (filtroFecha && !cumpleFiltroFecha(fecha, filtroFecha)) {
                continue; // Salta a la siguiente fila si la fecha no cumple el filtro
            }

            // Filtrar por criterios de búsqueda
            if (criteriosBusqueda && criteriosBusqueda.length > 0 && !cumpleCriteriosBusqueda(fila, criteriosBusqueda, columnasReferencia)) {
                continue; // Salta a la siguiente fila si no cumple los criterios de búsqueda
            }

            var grupoActual = grupos;

            for (var j = 0; j < columnasReferencia.length; j++) {
                var columna = columnasReferencia[j];
                var valor = fila.cells[columna].textContent;

                if (!grupoActual.hasOwnProperty(valor)) {
                    grupoActual[valor] = {};
                    grupoActual[valor].contador = 0;
                }

                grupoActual[valor].contador++;
                grupoActual = grupoActual[valor];
            }

            if (!grupoActual.hasOwnProperty("filas")) {
                grupoActual.filas = [];
            }

            grupoActual.filas.push(fila);
        }

        // Función recursiva para generar la estructura HTML
        function generarEstructuraHTML(grupo, nivel) {
            var tablaHTML = "";

            for (var clave in grupo) {
                if (grupo.hasOwnProperty(clave) && clave !== "filas") {
                    var subgrupo = grupo[clave];
                    var filasSubgrupo = subgrupo.filas;
                    var contador = subgrupo.contador;

                    // Eliminar espacios en blanco y ciertos símbolos de la clave
                    var claveSinSimbolos = clave.replace(/[{}()\[\]\/\s+\-.&:]/g, "").trim();

                    if (contador != undefined) {
                        tablaHTML += "<tr class='bg-dark text-white'>";
                        for (var i = 0; i < nivel; i++) {
                            tablaHTML += "<td></td>";
                        }
                        tablaHTML += "<td colspan='14' class='bg-dark text-white'><a class='link link-light' href='#collapse-" + claveSinSimbolos + "' data-bs-toggle='collapse'><i class='bi bi-caret-down'></i>" + ' ' + clave + " (" + contador + ")</a></td>";
                    }
                    tablaHTML += "</tr>";

                    if (filasSubgrupo) {
                        tablaHTML += "<tbody class='collapse' class='collapse' id='collapse-" + claveSinSimbolos + "'><tr>";
                        filasSubgrupo.forEach(function(fila) {
                            tablaHTML += fila.outerHTML;
                        });
                        tablaHTML += "</tr></tbody>";
                    } else {
                        tablaHTML += generarEstructuraHTML(subgrupo, nivel + 1);
                    }
                }
            }

            return tablaHTML;
        }

        // Filtra las filas por fecha
        function filtrarPorFecha(filas, filtroFecha) {
            if (!filtroFecha) {
                return; // No se proporcionó un filtro de fecha
            }

            for (var i = 1; i < filas.length; i++) {
                var fila = filas[i];
                var fecha = fila.cells[4].textContent; // Obtener el valor de la columna de fecha

                if (!cumpleFiltroFecha(fecha, filtroFecha)) {
                    fila.style.display = "none"; // Ocultar fila si la fecha no cumple el filtro
                } else {
                    fila.style.display = ""; // Mostrar fila si la fecha cumple el filtro
                }
            }
        }

        // Verifica si una fecha cumple con el filtro
        function cumpleFiltroFecha(fecha, filtroFecha) {
            var fechaPrevista = new Date(fecha);
            var filtroFechaInicio = new Date(filtroFecha.inicio);
            var filtroFechaFin = new Date(filtroFecha.fin);

            return fechaPrevista >= filtroFechaInicio && fechaPrevista <= filtroFechaFin;
        }

        // Filtra las filas por criterios de búsqueda
        function filtrarPorCriterios(filas, criteriosBusqueda) {
            if (!criteriosBusqueda || criteriosBusqueda.length === 0) {
                return; // No se proporcionaron criterios de búsqueda
            }

            for (var i = 1; i < filas.length; i++) {
                var fila = filas[i];

                if (!cumpleCriteriosBusqueda(fila, criteriosBusqueda, columnasReferencia)) {
                    fila.style.display = "none"; // Ocultar fila si no cumple los criterios de búsqueda
                } else {
                    fila.style.display = ""; // Mostrar fila si cumple los criterios de búsqueda
                }
            }
        }

        // Verifica si una fila cumple con los criterios de búsqueda
        function cumpleCriteriosBusqueda(fila, criteriosBusqueda, columnasReferencia) {
            for (var i = 0; i < criteriosBusqueda.length; i++) {
                var criterio = criteriosBusqueda[i];
                var columnas = criterio.columnas;
                var termino = criterio.termino.toLowerCase();

                var cumpleCriterio = false;

                if (columnasReferencia && columnasReferencia.length > 0) {
                    for (var j = 0; j < columnas.length; j++) {
                        var columna = columnas[j];
                        var valorCelda = fila.cells[columna].textContent.toLowerCase();

                        if (valorCelda.includes(termino)) {
                            cumpleCriterio = true;
                            break;
                        }
                    }
                } else {
                    for (var j = 0; j < fila.cells.length; j++) {
                        var valorCelda = fila.cells[j].textContent.toLowerCase();

                        if (valorCelda.includes(termino)) {
                            cumpleCriterio = true;
                            break;
                        }
                    }
                }

                if (!cumpleCriterio) {
                    return false; // La fila no cumple uno de los criterios de búsqueda
                }
            }

            return true; // La fila cumple todos los criterios de búsqueda
        }

        // Generar la estructura HTML
        var estructuraHTML = generarEstructuraHTML(grupos, 0);

        // Remover todas las filas de la tabla
        while (table.rows.length > 1) {
            table.deleteRow(1);
        }

        // Agregar la estructura HTML generada a la tabla
        table.innerHTML += estructuraHTML;
    }


    $(".dropdown-menu").on("click", function(e) {
        e.stopPropagation(); // Evitar que el clic se propague al elemento padre (el botón del menú desplegable)
    });

    $(".dropdown-menu").on("change", "input[type='checkbox']", function() {
        var optionValue = $(this).val();

        if ($(this).is(":checked")) {
            // Agregar la opción seleccionada al array si no está presente
            if (selectedOptions.indexOf(optionValue) === -1) {
                selectedOptions.push(optionValue);
            }
        } else {
            // Quitar la opción del array si está presente
            var index = selectedOptions.indexOf(optionValue);
            if (index !== -1) {
                selectedOptions.splice(index, 1);
            }
        }

        if (selectedOptions.length == 0) {
            var table3 = document.getElementById('tabla-datos');
            table3.innerHTML = contenidoOriginal;
        } else {
            console.log(selectedOptions); // Imprimir el array de opciones seleccionadas
            var table2 = document.getElementById('tabla-datos');
            while (table2.rows.length > 1) {
                table2.deleteRow(1);
            }
            table2.innerHTML = contenidoOriginal;
            if (fechaInicio != undefined && fechaFin != undefined) {
                console.log('caso 1');
                agruparTabla("tabla-datos", selectedOptions, {
                    inicio: fechaInicio,
                    fin: fechaFin,
                }, criterioBusqueda);
            } else if (fechaInicio) {
                console.log('caso 1');
                agruparTabla("tabla-datos", selectedOptions, {
                    inicio: fechaInicio,
                    fin: fechaFin,
                }, criterioBusqueda);
            } else {
                console.log('caso 3');
                agruparTabla("tabla-datos", selectedOptions, null, criterioBusqueda);
            }
        }
    });

    var valorInput = $('#input').val(); // Obtener el valor del input

    if (valorInput !== '') {
        $('#select').prop('disabled', false); // Habilitar el select si el input tiene contenido
    } else {
        $('#select').prop('disabled', true); // Deshabilitar el select si el input está vacío
    }

    $('#input').on('input', function() {
        var valorInput = $(this).val(); // Obtener el valor del input

        if (valorInput !== '') {
            $('#select').prop('disabled', false); // Habilitar el select si el input tiene contenido
        } else {
            $('#select').prop('disabled', true); // Deshabilitar el select si el input está vacío
        }
    });

    $('#select').on('change', function() {
        var termino = $('#input').val(); // Obtener el valor del input
        var columna = $(this).val(); // Obtener el valor seleccionado del select

        criterioBusqueda.push({
            columnas: [columna],
            termino: termino
        });

        $('#input').val(''); // Borrar el contenido del input
        $('#select').val(100); // Borrar el contenido del input
        $('#select').prop('disabled', true); // Deshabilitar el select si el input está vacío

        console.log(criterioBusqueda); // Mostrar el array criterioBusqueda en la consola
        mostrarLista();

        var table2 = document.getElementById('tabla-datos');
        while (table2.rows.length > 1) {
            table2.deleteRow(1);
        }
        table2.innerHTML = contenidoOriginal;
        if (fechaInicio != undefined && fechaFin != undefined) {
            console.log('caso 1');
            agruparTabla("tabla-datos", selectedOptions, {
                inicio: fechaInicio,
                fin: fechaFin,
            }, criterioBusqueda);
        } else if (fechaInicio) {
            console.log('caso 1');
            agruparTabla("tabla-datos", selectedOptions, {
                inicio: fechaInicio,
                fin: fechaFin,
            }, criterioBusqueda);
        } else {
            console.log('caso 3');
            agruparTabla("tabla-datos", selectedOptions, null, criterioBusqueda);
        }

    });

    function mostrarLista() {
        var lista = $('#lista');
        lista.empty(); // Limpiar la lista antes de actualizarla

        // Recorrer el array criterioBusqueda y agregar elementos a la lista
        for (var i = 0; i < criterioBusqueda.length; i++) {
            var item = criterioBusqueda[i];

            // Crear un elemento de lista con el valor del elemento y un botón para eliminarlo
            var listItem = $('<a class="dropdown-item" href="#">').text('Busqueda: ' + item.termino + ' ');
            var deleteButton = $('<button class="btn btn-primary btn-sm">').text('Quitar').data('index', i);

            // Asociar un evento de click al botón de eliminar para eliminar el elemento correspondiente
            deleteButton.on('click', function() {
                var index = $(this).data('index');
                criterioBusqueda.splice(index, 1); // Eliminar el elemento del array
                mostrarLista(); // Actualizar la lista en el HTML

                var table2 = document.getElementById('tabla-datos');
                while (table2.rows.length > 1) {
                    table2.deleteRow(1);
                }
                table2.innerHTML = contenidoOriginal;
                if (fechaInicio != undefined && fechaFin != undefined) {
                    console.log('caso 1');
                    agruparTabla("tabla-datos", selectedOptions, {
                        inicio: fechaInicio,
                        fin: fechaFin,
                    }, criterioBusqueda);
                } else if (fechaInicio) {
                    console.log('caso 1');
                    agruparTabla("tabla-datos", selectedOptions, {
                        inicio: fechaInicio,
                        fin: fechaFin,
                    }, criterioBusqueda);
                } else {
                    console.log('caso 3');
                    agruparTabla("tabla-datos", selectedOptions, null, criterioBusqueda);
                }
            });

            // Agregar el botón de eliminar al elemento de lista
            listItem.append(deleteButton);

            // Agregar el elemento de lista a la lista en el HTML
            lista.append(listItem);
        }
    }

    function cargar_colores2() {
        $('#tabla-datos tbody tr').each(function() {
            var fila = $(this);

            var segundaColumna = $(this).find('td:eq(1)').text();
            var novenaColumna = $(this).find('td:eq(9)').text();
            console.log(segundaColumna);
            console.log(novenaColumna);

            var estado = segundaColumna;
            var fechaActual = new Date();
            var fechaDada = new Date(novenaColumna);

            if (fechaActual.getTime() < fechaDada.getTime() && estado == 'Disponible') {
                console.log("Falta más de una hora para llegar a la fecha dada.");
            } else if (
                fechaActual.getFullYear() === fechaDada.getFullYear() &&
                fechaActual.getMonth() === fechaDada.getMonth() &&
                fechaActual.getDate() === fechaDada.getDate() && estado == 'Disponible'
            ) {
                var horasRestantes = fechaDada.getHours() - fechaActual.getHours();
                if (horasRestantes >= 1) {
                    console.log("Falta más de una hora para llegar a la fecha dada.");
                } else {
                    console.log("Falta menos de una hora para llegar a la fecha dada.");
                    fila.find('td').addClass('table-warning');
                }
            } else if (estado == 'Disponible') {
                console.log("Se ha sobrepasado la fecha y hora dada.");
                fila.find('td').addClass('table-danger');
            } else {
                console.log("Se ha sobrepasado la fecha y hora dada.");
            }

        });
    }

    function cargar_colores() {
        $('#tabla-datos').DataTable().destroy();
        $('#tabla-datos').DataTable({
            "order": [],
            "orderCellsTop": true,
            "buttons": [],
            "searching": false,
            "aaSorting": [],
            "ordering": true,
            dom: 'Bfrtlip',
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": " Primero ",
                    "last": " Ultimo ",
                    "next": " Proximo ",
                    "previous": " Anterior  "
                }
            },
            "lengthMenu": [
                [200, -1],
                [200, "All"]
            ]
        });
    }

    cargar_colores();

    function obtenerCheckboxesSeleccionados() {
        var checkboxesSeleccionados = [];
        $(".dropdown-menu input[type='checkbox']").each(function() {
            if ($(this).is(":checked")) {
                checkboxesSeleccionados.push($(this).val());
            }
        });
        return checkboxesSeleccionados;
    }

    selectedOptions = obtenerCheckboxesSeleccionados();
    console.log("Checkboxes seleccionados al cargar la página:", selectedOptions);

    if (selectedOptions.length == 0) {
        var table3 = document.getElementById('tabla-datos');
        table3.innerHTML = contenidoOriginal;
        cargar_colores2();
        cargar_detenciones();
        console.log('caso 3');
    } else {
        console.log('caso 3');
        console.log(selectedOptions);
        var table2 = document.getElementById('tabla-datos');
        while (table2.rows.length > 1) {
            table2.deleteRow(1);
        }
        table2.innerHTML = contenidoOriginal;
        if (fechaInicio != undefined && fechaFin != undefined) {
            console.log('caso 1');
            agruparTabla("tabla-datos", selectedOptions, {
                inicio: fechaInicio,
                fin: fechaFin,
            }, criterioBusqueda);
            cargar_colores2();
            cargar_detenciones();

        } else if (fechaInicio) {
            console.log('caso 1');
            agruparTabla("tabla-datos", selectedOptions, {
                inicio: fechaInicio,
                fin: fechaFin,
            }, criterioBusqueda);
            cargar_colores2();
            cargar_detenciones();

        } else {
            console.log('caso 3');
            mostrarLista();
            agruparTabla("tabla-datos", selectedOptions, null, criterioBusqueda);
            cargar_colores2();
            cargar_detenciones();
        }
    }
</script>
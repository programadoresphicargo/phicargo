<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$domain = [
    [
        ['date_order', '>=', '2023-07-01'],
        ['date_order', '<=', '2023-07-31'],
        ['x_status_viaje', '=', ['finalizado']],
        ['travel_id', '!=', false],
    ]
];

if (isset($_POST['searchResults'])) {
    $searchResultsJSON = $_POST['searchResults'];

    $searchResults = json_decode($searchResultsJSON, true);

    if ($searchResults !== null) {
        foreach ($searchResults as $result) {
            $searchText = $result['searchText'];
            $searchField = $result['searchField'];

            $new_condition = [$searchField, 'ilike', $searchText];
            array_push($domain[0], $new_condition);
        }
    } else {
        echo "Hubo un error al decodificar los datos JSON.";
    }
}
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'date_order', 'partner_id', 'x_mov_bel', 'x_eco_retiro', 'x_operador_retiro', 'x_terminal_bel'], 'order' => 'date_order asc'];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    $kwargs
);

$json = json_encode($records);
$datos = json_decode($json, true);

?>

<div class="table-responsive">
    <table class="table table-align-middle table-hover table-sm" id="tabla-datos">
        <thead class="thead-light">
            <tr class="">
                <th>Sucursal</th>
                <th>Ejecutivo</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Carta porte</th>
                <th>Referencia Contenedor </th>
                <th>Status</th>
                <th>Terminal retiro</th>
                <th>Operador retiro</th>
                <th>ECO retiro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $item) { ?>
                <tr data-id="<?php echo $item['id'] ?>">
                    <td><?php echo $item['store_id'][1] ?></td>
                    <td><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                    <td><?php echo $item['date_order'] ?></td>
                    <td><?php echo $item['partner_id'][1] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['x_reference'] ?></td>

                    <?php
                    if ($item['x_status_bel'] == 'Ing') { ?>
                        <td class='text-center'><span class='badge bg-success rounded-pill'>Ingresado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'No Ing') { ?>
                        <td class='text-center'><span class='badge bg-danger rounded-pill'>No Ingresado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'pm') { ?>
                        <td class='text-center'><span class='badge bg-warning rounded-pill'>Patio México</span></td>
                    <?php } else if ($item['x_status_bel'] == 'sm') { ?>
                        <td class='text-center'><span class='badge bg-warning rounded-pill'>Sin Maniobra</span></td>
                    <?php } else if ($item['x_status_bel'] == 'EI') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>En proceso de ingreso</span></td>
                    <?php } else if ($item['x_status_bel'] == 'ru') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>Reutilizado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'can') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>Cancelado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'P') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>En Patio</span></td>
                    <?php } else if ($item['x_status_bel'] == 'V') { ?>
                        <td class='text-center'><span class='badge bg-primary rounded-pill'>En Viaje</span></td>
                    <?php } else { ?>
                        <td class='text-center'><span class='badge bg-dark rounded-pill'>Sin Status</span></td>
                    <?php } ?>

                    <td><?php echo $item['x_mov_bel'] ?></td>
                    <td><?php echo $item['x_eco_retiro'] ?></td>
                    <td><?php echo $item['x_operador_retiro'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<script>
    $('#tabla-datos').on('click', 'tr', function() {
        // Obtén el valor del atributo data-id del elemento <tr> clickeado
        var dataId = $(this).data('id');
        if ($.isNumeric(dataId)) {
            $("#detalles_maniobra").offcanvas("show");
            $('#contenidomaniobracanvas').load('../maniobra/index.php', {
                'id': dataId
            });
        }
    });

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
            var fecha = fila.cells[3].textContent; // Obtener el valor de la columna de fecha

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
                    var claveSinSimbolos = clave.replace(/[{}()\[\]\/\s+\-.&]/g, "").trim();

                    if (contador != undefined) {
                        tablaHTML += "<tr class='bg-dark text-white'>";
                        for (var i = 0; i < nivel; i++) {
                            tablaHTML += "<td></td>";
                        }
                        tablaHTML += "<td colspan='13' class='bg-dark text-white'><a class='link link-light' href='#collapse-" + claveSinSimbolos + "' data-bs-toggle='collapse'><i class='bi bi-caret-down'></i>" + ' ' + clave + " (" + contador + ")</a></td>";
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
                var fecha = fila.cells[3].textContent; // Obtener el valor de la columna de fecha

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
        } else if (fechaInicio) {
            console.log('caso 1');
            agruparTabla("tabla-datos", selectedOptions, {
                inicio: fechaInicio,
                fin: fechaFin,
            }, criterioBusqueda);
        } else {
            console.log('caso 3');
            mostrarLista();
            agruparTabla("tabla-datos", selectedOptions, null, criterioBusqueda);
        }
    }
</script>
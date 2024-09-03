<script>
    var table = document.getElementById('tabla-datos');
    var contenidoOriginal = table.innerHTML;

    function agruparTabla(tablaId, columnasReferencia) {
        // Obtener la tabla y todas las filas
        var table = document.getElementById(tablaId);
        var rows = table.getElementsByTagName("tr");

        // Verificar si no se proporcionaron columnas de referencia
        if (!columnasReferencia || columnasReferencia.length === 0) {
            return; // Finalizar la ejecución de la función
        }

        // Crear una estructura de datos para almacenar los grupos
        var grupos = {};

        // Recorrer las filas y agrupar los datos
        for (var i = 1; i < rows.length; i++) {
            var fila = rows[i];

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
            console.log(selectedOptions);
            var table2 = document.getElementById('tabla-datos');
            while (table2.rows.length > 1) {
                table2.deleteRow(1);
            }
            table2.innerHTML = contenidoOriginal;

            console.log('caso 3');
            agruparTabla("tabla-datos", selectedOptions);

        }
    });

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
        console.log('caso 3');
        agruparTabla("tabla-datos", selectedOptions);

    }
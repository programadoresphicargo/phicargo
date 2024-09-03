<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM visitantes";
$resultado = $cn->query($sql);
?>
<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-striped" id="TablaVisitantes">
    <thead class="thead-light">
        <tr>
            <th scope="col"></th>
            <th scope="col">Nombre del visitante</th>
            <th scope="col">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_array()) { ?>
            <tr>
                <th><img src="../../img/usuario.png" alt="Girl in a jacket" width="30" height="30"></th>
                <th><?php echo $row['nombre_visitante'] ?></th>
                <th><button class="btn btn-primary btn-xs" type="button" onclick="agregarRegistro('<?php echo $row['id_visitante'] ?>','<?php echo $row['nombre_visitante'] ?>')">Seleccionar</button></th>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function eliminarRegistro(id) {
        registrosArray = registrosArray.filter(function(registro) {
            return registro.id !== id;
        });

        actualizarTabla();

        notyf.success("Visitante eliminado del acceso.");
    }

    function actualizarTabla() {
        var tabla = document.getElementById("registrosTable");
        tabla.innerHTML = "<tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>";
        registrosArray.forEach(function(registro) {
            var fila = tabla.insertRow();

            var celdaId = fila.insertCell(0);
            celdaId.innerHTML = registro.id;

            var celdaNombre = fila.insertCell(1);
            celdaNombre.innerHTML = registro.nombre;

            var celdaEliminar = fila.insertCell(2);
            var botonEliminar = document.createElement("button");
            botonEliminar.classList.add("btn", "btn-primary", "btn-xs");
            botonEliminar.innerHTML = "Eliminar";
            botonEliminar.onclick = function() {
                eliminarRegistro(registro.id);
            };
            celdaEliminar.appendChild(botonEliminar);
        });
    }


    function agregarRegistro(id, nombre) {
        if (valorVariable == undefined) {
            console.log(id);
            console.log(nombre);
            var registroExistente = registrosArray.find(function(registro) {
                return registro.id === id;
            });

            if (registroExistente) {
                notyf.success("Visitante ya añadido al acceso.");
                actualizarTabla();
            } else {
                notyf.success("Visitante añadido al acceso.");
                registrosArray.push({
                    id: id,
                    nombre: nombre
                });
                actualizarTabla();
            }
            console.log(registrosArray);
        } else {
            $.ajax({
                url: "enlazar_visitantes.php",
                data: {
                    'id_visitante': id,
                    'id_acceso': valorVariable,
                },
                type: "POST",
                dataType: "json",
                success: function(response) {
                    if (response == 1) {
                        notyf.success("Registro modificado correctamente");
                        cargar_visitantes_2(valorVariable);
                    } else if (response == 2) {
                        notyf.success("Visitante ya añadido.");
                    } else {
                        notyf.error("Error en la solicitud" + response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
                }
            });
        }
    }
</script>

<script>
    $('#TablaVisitantes').DataTable({
        dom: 'Bfrtlip',
        buttons: [{
                extend: 'pdfHtml5',
                text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-primary btn-xs',
            },
            {
                extend: 'excelHtml5',
                text: 'Exel <i class="bi bi-filetype-exe"></i>',
                titleAttr: 'Exportar a Exel',
                className: 'btn btn-primary btn-xs'
            },
            {
                extend: 'print',
                text: 'Impresion <i class="bi bi-printer"></i>',
                className: 'btn btn-primary btn-xs',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        /*
        columnDefs: [ {
            targets: -1,
            visible: false
        } ],*/
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
            [30, 40, 50, -1],
            [30, 40, 50, "All"]
        ]
    });
</script>
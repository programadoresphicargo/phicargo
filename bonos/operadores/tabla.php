<script>
    var datos = [];

    function llenar_array_permisos(id_permiso) {
        datos.push([id_permiso]);
    }

    function abrir_comentario(id_bono) {
        $('#id_bono').val(id_bono);
        $.ajax({
            type: "POST",
            data: {
                'id_bono': id_bono
            },
            url: "cronologia.php",
            success: function(respuesta) {
                $("#cronologia").html(respuesta);
            }
        });
    }
</script>

<?php
require_once('../../mysql/conexion.php');
$usuario = $_POST['usuario'];
$mes = $_POST['mes'];
$año = $_POST['año'];
$sqlSelect = "SELECT bonos.id_bono, id_operador, nombre_operador, km_recorridos, calificacion, excelencia, productividad, operacion, seguridad_vial, cuidado_unidad, rendimiento, sum(excelencia + productividad + operacion + seguridad_vial + cuidado_unidad + rendimiento) as total, comentario FROM bonos inner join operadores on operadores.id = bonos.id_operador left join comentarios on comentarios.id_bono = bonos.id_bono where mes = $mes and año = $año and activo = TRUE group by id_bono order by km_recorridos desc";
$cn = conectar();
$resultado = $cn->query($sqlSelect);

$sqlPermisos = "SELECT id_permiso FROM permisos_usuarios where id_usuario = $usuario";
$resultadoPermisos = $cn->query($sqlPermisos);
while ($rowPermisos = $resultadoPermisos->fetch_assoc()) { ?>
    <script>
        llenar_array_permisos(<?php echo $rowPermisos['id_permiso'] ?>)
    </script>
<?php } ?>

<div class="table-responsive">
    <table class="js-datatable table table-align-middle table-sm table-bordered table-hover text-center" id="bonos_operadores" data-hs-datatables-options='{
                    "dom": "Bfrtip",
                    "buttons": [
                      {
                        "extend": "copy",
                        "className": "d-none"
                      },
                      {
                        "extend": "excel",
                        "className": "d-none"
                      },
                      {
                        "extend": "csv",
                        "className": "d-none"
                      },
                      {
                        "extend": "pdf",
                        "className": "d-none"
                      },
                      {
                        "extend": "print",
                        "className": "d-none"
                      }
                   ],
                   
                   "paging": false,
                   "order": []
                 }'>
        <thead class="thead-light">
            <tr>
                <th>Registro</th>
                <th>Operador</th>
                <th>KM Recorridos</th>
                <th>Calificación</th>
                <th>Excelencia</th>
                <th>Productividad</th>
                <th>Operación</th>
                <th>Seguridad Vial</th>
                <th>Cuidado de la unidad</th>
                <th>Rendimiento</th>
                <th>Total</th>
                <th></th>
                <th>Registro incidencias</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_bono'] ?></td>
                    <td class="bg-dark">
                        <div class="ms-3">
                            <span class="d-block h5 text-inherit mb-0 text-white"><?php echo $row['nombre_operador'] ?></span>
                        </div>
                    </td>
                    <td><?php echo $row['km_recorridos'] ?></td>
                    <td><?php echo number_format($row['calificacion'], 0) ?></td>
                    <td><?php echo $row['excelencia'] ?></td>
                    <td><?php echo $row['productividad'] ?></td>
                    <td><?php echo $row['operacion'] ?></td>
                    <td><?php echo $row['seguridad_vial'] ?></td>
                    <td><?php echo $row['cuidado_unidad'] ?></td>
                    <td><?php echo $row['rendimiento'] ?></td>
                    <td class="bg-soft-success"><?php echo '$ ' . $row['total'] ?></td>
                    <td><button type="button" onclick="abrir_comentario('<?php echo $row['id_bono'] ?>')" class="btn btn-success btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-chat"></i></button></td>
                    <td><button type="button" onclick="iniciar_incidencia('<?php echo $row['id_bono'] ?>')" class="btn btn-danger btn-sm" data-bs-toggle="offcanvas" data-bs-target="#modal_incidencia" aria-controls="modal_incidencia"><i class="bi bi-exclamation-triangle"></i></button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {

        var permisos = [];

        datos.forEach(function(datos, index) {
            let variable = `${datos}`;
            switch (variable) {
                //Legal
                case '9':
                    permisos.push([7, 'seguridad_vial']);
                    break;
                //Mantenimiento
                case '10':
                    permisos.push([3, 'calificacion']);
                    permisos.push([9, 'rendimiento']);
                    break;
                //RH
                case '11':
                    permisos.push([4, 'excelencia']);
                    break;
                //Operaciones
                case '12':
                    permisos.push([5, 'productividad']);
                    permisos.push([6, 'operacion']);
                    permisos.push([8, 'cuidado_unidad']);
                    break;
            }
        });

        console.log(permisos);

        $('#bonos_operadores').Tabledit({
            deleteButton: false,
            editButton: true,
            columns: {
                identifier: [0, 'id_bono'],
                editable: permisos
            },
            eventType: 'dblclick',
            hideIdentifier: true,
            url: 'editar_bono.php',
            buttons: {
                edit: {
                    class: 'btn btn-sm btn-primary',
                    html: '<i class="bi bi-pen"></i>',
                    action: 'edit'
                },
                save: {
                    class: 'btn btn-sm btn-success',
                    html: 'Save'
                },

            }
        });

    });
</script>

<script>
    (function() {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        HSCore.components.HSDatatables.init('.js-datatable')
        const exportDatatable = HSCore.components.HSDatatables.getItem('bonos_operadores')

        document.getElementById('export-copy').addEventListener('click', function() {
            exportDatatable.button('.buttons-copy').trigger()
        })

        document.getElementById('export-excel').addEventListener('click', function() {
            exportDatatable.button('.buttons-excel').trigger()
        })

        document.getElementById('export-csv').addEventListener('click', function() {
            exportDatatable.button('.buttons-csv').trigger()
        })

        document.getElementById('export-pdf').addEventListener('click', function() {
            exportDatatable.button('.buttons-pdf').trigger()
        })

        document.getElementById('export-print').addEventListener('click', function() {
            exportDatatable.button('.buttons-print').trigger()
        })
    })()
</script>
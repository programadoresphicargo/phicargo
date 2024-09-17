<?php
require_once('../../mysql/conexion.php');
require_once('modal_contenedores.php');
$cn = conectar();
$id_cp = $_POST['id_cp'];
$partner_id = $_POST['partner_id'];
?>

<div class="row">
    <div class="col-lg-12">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h2 class="page-header-title">Maniobra</h2>
                </div>
            </div>

            <a class="btn btn-primary btn-sm" href="javascript:;" onclick="nueva_maniobra('<?php echo $id_cp ?>')">
                <i class="bi-people-fille me-1"></i> Añadir maniobra
            </a>

            <a class="btn btn-primary btn-sm" href="javascript:;" onclick="abrir_modal_correos('<?php echo $partner_id ?>')">
                <i class="bi-email me-1"></i> Correos electronicos
            </a>

        </div>
    </div>
</div>

<?php
$sql = "SELECT * FROM maniobra
inner join operadores on operadores.id = maniobra.operador_id
inner join flota on flota.vehicle_id = maniobra.vehicle_id
inner join maniobra_contenedores on maniobra_contenedores.id_maniobra = maniobra.id_maniobra
where id_cp = $id_cp 
order by inicio_programado desc";
$resultado = $cn->query($sql);
?>

<table class="table table-sm table-striped table-hover table-borderless table-thead-bordered">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID Maniobra</th>
            <th scope="col">Tipo maniobra</th>
            <th scope="col">Terminal</th>
            <th scope="col">Conductor</th>
            <th scope="col">Unidad</th>
            <th scope="col">Inicio programado</th>
            <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr onclick="load_maniobra('<?php echo $row['id_maniobra'] ?>','<?php echo $row['estado_maniobra'] ?>')">
                <th><?php echo 'M-' . $row['id_maniobra'] ?></th>
                <td><span class="badge rounded-pill <?php echo $row['tipo_maniobra'] == 'retiro' ? 'bg-primary' : 'bg-warning' ?>"><?php echo $row['tipo_maniobra'] ?></span></td>
                <td><?php echo $row['terminal'] ?></td>
                <td><?php echo $row['nombre_operador'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['inicio_programado'] ?></td>
                <td><?php echo $row['estado_maniobra'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function get_maniobra(id_maniobra) {
        notyf.success('Obteniendo maniobra...');
        $.ajax({
            url: '../maniobra_detalle/get_maniobra.php',
            type: 'POST',
            data: {
                'id_maniobra': id_maniobra,
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#id_maniobra').val(data.id_maniobra);
                $('#tipo_maniobra').val(data.tipo_maniobra);
                $('#inicio_programado').val(data.inicio_programado);
                $('#terminal').val(data.terminal);
                $('#operador_id').val(data.operador_id);
                $('#vehicle_id').val(data.vehicle_id);
                $('#trailer1_id').val(data.trailer1_id);
                $('#trailer2_id').val(data.trailer2_id);
                $('#dolly_id').val(data.dolly_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#resultado').html('<p>Ocurrió un error: ' + textStatus + '</p>');
            }
        });
    }

    function contenedores_maniobra(id_maniobra) {
        $.ajax({
            url: '../maniobra_detalle/contenedores.php',
            method: 'POST',
            data: {
                'id_maniobra': id_maniobra,
            },
            success: function(response) {
                $("#contenedores_maniobra").html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar los datos: ', textStatus, errorThrown);
            }
        });
    }

    function load_maniobra(id_maniobra, estado) {
        $("#exampleModal").modal('show');
        get_maniobra(id_maniobra);
        contenedores_maniobra(id_maniobra);
        if (estado !== 'cancelada') {
            estado_maniobra('editar');
        } else {
            estado_maniobra('cancelada');
        }
    }

    function estado_maniobra(estado) {
        $('#registrar_maniobra, #cancelar_maniobra, #editar_maniobra, #guardar_maniobra').hide();
        switch (estado) {
            case 'nueva':
                $('#registrar_maniobra').show();
                break;
            case 'cancelada':
                break;
            case 'editar':
                $('#editar_maniobra').show();
                $('#cancelar_maniobra').show();
                break;
            case 'guardar':
                $('#guardar_maniobra').show();
                break;
            default:
        }
    }
</script>
<?php
require_once('../../mysql/conexion.php');
require_once('calcular_distancia.php');
$sucursal = $_POST['sucursal'];

$cn = conectar();
$sql = "SELECT * FROM viajes left join operadores on operadores.id = viajes.employee_id left join unidades on unidades.placas = viajes.placas where viajes.estado in ('retorno') and viajes.store_id like '%$sucursal%'";
$resultado = $cn->query($sql);

$data = array();

while ($row = $resultado->fetch_assoc()) {
    $nombre_operador = $row['nombre_operador'];
    $store_id = $row['store_id'];
    $unidad = $row['unidad'];
    $placas = $row['placas'];
    $sql2 = "SELECT placas, latitud, longitud, fecha_hora 
    FROM ultima_ubicacion 
    WHERE placas = '$placas' 
    ORDER BY fecha_hora DESC 
    LIMIT 1";
    $resultado2 = $cn->query($sql2);
    while ($row2 = $resultado2->fetch_assoc()) {
        $latitud = $row2['latitud'];
        $longitud = $row2['longitud'];
        $fecha = $row2['fecha_hora'];

        if ($sucursal == 'veracruz') {
            $latitud2 = 19.225729696213136;
            $longitud2 = -96.19555722199152;
        } else if ($sucursal == 'manzanillo') {
            $latitud2 = 19.113390;
            $longitud2 = -104.342000;
        } else if ($sucursal == 'mexico') {
            $latitud2 = 19.584423;
            $longitud2 = -98.919041;
        }

        $distancia = distanciaEntreCoordenadas($latitud, $longitud, $latitud2, $longitud2);

        $data[] = array(
            'sucursal' => $store_id,
            'unidad' => $unidad,
            'placas' => $placas,
            'nombre_operador' => $nombre_operador,
            'latitud' => $latitud,
            'longitud' => $longitud,
            'distancia' => round($distancia, 2),
            'fecha' => $fecha
        );
    }
}

function compararDistancia($a, $b)
{
    return $a['distancia'] - $b['distancia'];
}

usort($data, 'compararDistancia');

$json_data = json_encode($data);
$data = json_decode($json_data, true);

?>

<div class="alert alert-success" role="alert">
    <div class="d-flex">
        <div class="flex-shrink-0">
            <i class="bi-exclamation-triangle-fill"></i>
        </div>
        <div class="flex-grow-1 ms-2">
            En el siguiente listado se muestran las unidades que estan realizando viaje en estado de retorno hacia su sucursal de origen.
        </div>
    </div>
</div>

<table class="table table-sm table-hover table-striped" id="tabladistancias" style="width: 100%;">
    <thead>
        <tr>
            <th scope="col" class="text-center">Sucursal origen</th>
            <th scope="col" class="text-center">Unidad</th>
            <th scope="col" class="text-center">Operador</th>
            <th scope="col" class="text-center">Ubicación</th>
            <th scope="col" class="text-center">Distancia en KM de sucursal origen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $key => $item) { ?>
            <tr>
                <td class="text-center"><?php echo $item['sucursal'] ?></td>
                <td class="text-center"><span class="badge bg-primary rounded-pill"><?php echo $item['unidad'] ?></span></td>
                <td class="text-center text-dark fw-semibold"><?php echo $item['nombre_operador'] ?></td>
                <td class="text-center"><a class="link link-success" href="https://www.google.com/maps/search/?api=1&query=<?php echo $item['latitud'] . ',' . $item['longitud'] ?>" target="_blank"><?php echo $item['latitud'] . ' , ' . $item['longitud'] ?></a></td>
                <td class="text-center"><?php echo $item['distancia'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#tabladistancias').DataTable({
            "lengthMenu": [50]
        });
    });
</script>
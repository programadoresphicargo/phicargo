<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (isset($_POST['empresas'])) {
    $estadosSeleccionados = implode(',', $_POST['empresas']);
} else {
    $idsEmpresas = [1, 2, 3, 4, 5];
    $estadosSeleccionados = implode(',', $idsEmpresas);
}


$sql4 = "SELECT * from cuentas inner join empresas on empresas.id_empresa = cuentas.id_empresa where cuentas.id_empresa IN ($estadosSeleccionados) group by cuentas.id_empresa order by cuentas.id_empresa";
$resultado4 = $cn->query($sql4);
?>
<h1 class="p-2">Saldos Generales</h1>
<div class="accordion" id="accordionExample">
    <?php while ($row4 = $resultado4->fetch_assoc()) {
        $id_empresa = $row4['id_empresa']; ?>

        <div class="accordion-item">
            <div class="accordion-header" id="headingOne">
                <a class="accordion-button bg-dark link link-light" role="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $row4['id_empresa'] ?>">
                    <?php echo $row4['nombre'] ?>
                </a>
            </div>

            <div id="collapseOne<?php echo $row4['id_empresa'] ?>" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body m-0 p-0">

                    <?php

                    if (isset($_POST['opcion'])) {
                        $opcion = $_POST['opcion'];
                    } else {
                        $opcion = $opcion_select;
                    }

                    switch ($opcion) {

                        case 'dia':
                            $fecha_actual = $_POST['fecha'];
                            $fecha_anterior = date("Y-m-d", strtotime($fecha_actual . " -1 day"));

                            $sql = "SELECT c.id_cuenta, tipo, moneda, referencia, empresas.nombre as nombre_empresa, bancos.nombre as nombre_banco,
MAX(CASE WHEN s1.fecha = '$fecha_anterior' THEN s1.saldo END) AS saldo_anterior,
MAX(CASE WHEN s2.fecha = '$fecha_actual' THEN s2.saldo END) AS saldo_actual,
MAX(CASE WHEN s2.fecha = '$fecha_actual' THEN s2.disponible END) AS disponible,
MAX(CASE WHEN s2.fecha = '$fecha_actual' THEN s2.utilizado END) AS utilizado
FROM cuentas c
LEFT JOIN saldos s1 ON c.id_cuenta = s1.id_cuenta AND s1.fecha = '$fecha_anterior'
LEFT JOIN saldos s2 ON c.id_cuenta = s2.id_cuenta AND s2.fecha = '$fecha_actual'
inner join bancos on bancos.id_banco = c.id_banco
inner join empresas on empresas.id_empresa = c.id_empresa
where c.id_empresa = $id_empresa
group by id_cuenta";
                            $columna1 = $fecha_anterior;
                            $columna2 = $fecha_actual;
                            break;

                        case 'semana':

                            include('../metodos/rango_semana.php');

                            if (isset($_POST['fechaInicial'])) {
                                $rango1 = $_POST['fechaInicial'];
                            } else {
                                $rango1 = $_GET['fechaInicial'];
                            }

                            if (isset($_POST['fechaFinal'])) {
                                $rango2 = $_POST['fechaFinal'];
                            } else {
                                $rango2 = $_GET['fechaFinal'];
                            }

                            $rangoSemanaAnterior = obtenerRangoSemanaAnterior($rango1);
                            $rango3 = $rangoSemanaAnterior[0];
                            $rango4 = $rangoSemanaAnterior[1];

                            $sql = "SELECT c.id_cuenta, tipo, moneda, referencia, empresas.nombre as nombre_empresa, bancos.nombre as nombre_banco,
SUM(CASE WHEN s1.fecha >= '$rango3' and s1.fecha <= '$rango4' THEN s1.saldo END) AS saldo_anterior, SUM(CASE WHEN s1.fecha>= '$rango1' and s1.fecha <= '$rango2' THEN s1.saldo END) AS saldo_actual FROM cuentas c LEFT JOIN saldos s1 ON c.id_cuenta=s1.id_cuenta inner join bancos on bancos.id_banco=c.id_banco inner join empresas on empresas.id_empresa=c.id_empresa where c.id_empresa IN ($estadosSeleccionados) group by id_cuenta";
                            $columna1 = 'Semana anterior';
                            $columna2 = 'Semana seleccionada';
                            break;
                        case 'mes':
                            include('../metodos/obtener_dias_mes.php');
                            if (isset($_POST['mes'])) {
                                $month = $_POST['mes'];
                            } else {
                                $month = $_GET['mes'];
                            }
                            if (isset($_POST['año'])) {
                                $year = $_POST['año'];
                            } else {
                                $year = $_GET['año'];
                            }
                            $fechasMesActual = obtenerPrimerUltimoDia($year, $month);
                            $fechasMesAnterior = obtenerPrimerUltimoDiaMesAnterior($year, $month);
                            $primerDiaAc = $fechasMesActual['primerDia']->format('Y-m-d');
                            $ultimoDiaAc = $fechasMesActual['ultimoDia']->format('Y-m-d');
                            $primerDiaAnt = $fechasMesAnterior['primerDiaMesAnterior']->format('Y-m-d');
                            $ultimoDiaAnt = $fechasMesAnterior['ultimoDiaMesAnterior']->format('Y-m-d');

                            $columna1 = 'Mes anterior';
                            $columna2 = 'Mes actual';

                            $sql = "SELECT c.id_cuenta, moneda, referencia, empresas.nombre as nombre_empresa, bancos.nombre as nombre_banco,
        SUM(CASE WHEN s1.fecha >= '$primerDiaAnt' and s1.fecha <= '$ultimoDiaAnt' THEN s1.saldo END) AS saldo_anterior, SUM(CASE WHEN s1.fecha>= '$primerDiaAc' and s1.fecha <= '$ultimoDiaAc' THEN s1.saldo END) AS saldo_actual FROM cuentas c LEFT JOIN saldos s1 ON c.id_cuenta=s1.id_cuenta inner join bancos on bancos.id_banco=c.id_banco inner join empresas on empresas.id_empresa=c.id_empresa where c.id_empresa IN ($estadosSeleccionados) group by id_cuenta";
                            $columna1 = 'Semana anterior';
                            $columna2 = 'Semana seleccionada';
                            break;
                    }

                    $resultado = $cn->query($sql);
                    $resultadosAgrupados = array();

                    while ($fila = $resultado->fetch_assoc()) {
                        $campoAgrupadoTipo = $fila['tipo'];
                        $campoAgrupadoMoneda = $fila['moneda'];

                        if (!isset($resultadosAgrupados[$campoAgrupadoTipo])) {
                            $resultadosAgrupados[$campoAgrupadoTipo] = array();
                        }

                        if (!isset($resultadosAgrupados[$campoAgrupadoTipo][$campoAgrupadoMoneda])) {
                            $resultadosAgrupados[$campoAgrupadoTipo][$campoAgrupadoMoneda] = array();
                        }

                        $resultadosAgrupados[$campoAgrupadoTipo][$campoAgrupadoMoneda][] = $fila;
                    }
                    ?>

                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover">
                        <tr class="thead-light">
                            <th scope="col"></th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Referencia</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Moneda</th>
                            <th scope="col" class="table-text-end"><?php echo $columna1 ?></th>
                            <th scope="col" class="table-text-end"><?php echo $columna2 ?></th>
                            <th scope="col">Variación</th>
                            <th scope="col">Disponible</th>
                            <th scope="col">Retenido</th>
                            <th scope="col"></th>
                        </tr>

                        <?php
                        foreach ($resultadosAgrupados as $campoTipo => $resultadosTipo) { ?>
                            <tr class="bg-soft-dark">
                                <td colspan="11" class="text-dark"><?php echo $campoTipo ?></td>
                            </tr>
                            <?php

                            foreach ($resultadosTipo as $campoMoneda => $filas) {

                                $total1 = 0;
                                $total2 = 0; ?>

                                <tr class="bg-soft-dark">
                                    <td></td>
                                    <td colspan="10" class="text-dark"><?php echo $campoMoneda ?></td>
                                </tr>

                                <?php foreach ($filas as $row) { ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="ms-3">
                                                <span class="d-block h5 text-inherit mb-0"> <?php echo $row['nombre_empresa'] ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ms-3">
                                                <span class="d-block h5 text-inherit mb-0 text-primary"> <?php echo $row['referencia'] ?> </span>
                                            </div>
                                        </td>
                                        <td><?php echo $row['nombre_banco'] ?></td>
                                        <?php if ($row['moneda'] == 'MXN') { ?>
                                            <td><span class="badge bg-soft-primary text-success"><?php echo $row['moneda'] ?></span></td>
                                        <?php } else { ?>
                                            <td><span class="badge bg-soft-primary text-primary"><?php echo $row['moneda'] ?></span></td>
                                        <?php } ?>

                                        <td class="table-text-end"><?php echo number_format($row['saldo_anterior'], 2, '.', ',') ?></td>
                                        <td class="table-text-end"><?php echo number_format($row['saldo_actual'], 2, '.', ',') ?></td>
                                        <td class="table-text-end">
                                            <?php
                                            $total1 = $row['saldo_anterior'] + $total1;
                                            $total2 = $row['saldo_actual'] + $total2;
                                            if ($row['saldo_anterior'] != 0) {
                                                $porcentaje = (($row['saldo_actual'] - $row['saldo_anterior']) / $row['saldo_anterior']) * 100;
                                                echo number_format($porcentaje, 0) . '%';
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['disponible'] ?></td>
                                        <td><?php echo $row['utilizado'] ?></td>
                                        <td onclick="abrir_saldos('<?php echo $row['id_cuenta'] ?>','<?php echo $row['saldo_actual'] ?>','<?php echo $row['disponible'] ?>')"><button class="btn btn-xs btn-success"><i class="bi bi-pencil-square"></i></button></td>
                                    </tr>
                                <?php  } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="table-text-end">
                                        <h5 class="font-weight-bold">Total</h5>
                                    </td>
                                    <td class="table-text-end">
                                        <h5 class="font-weight-bold"><?php echo number_format($total1, 2, '.', ',') ?></h5>
                                    </td>
                                    <td class="table-text-end">
                                        <h5 class="font-weight-bold"><?php echo number_format($total2, 2, '.', ',') ?></h5>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                        <?php }
                        } ?>
                    </table>

                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    $('#miTabla').DataTable({
        dom: 'Bfrtlip',
        buttons: [{
                extend: 'pdfHtml5',
                text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-xs btn-success',
            },
            {
                extend: 'excelHtml5',
                text: 'Exel <i class="bi bi-filetype-exe"></i>',
                titleAttr: 'Exportar a Exel',
                className: 'btn btn-xs btn-success'
            },
            {
                extend: 'print',
                text: 'Impresion <i class="bi bi-printer"></i>',
                className: 'btn btn-xs btn-success',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
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

    function abrir_saldos(id_cuenta, saldo, disponible) {
        $("#ingresar_saldo_modal").modal('show');
        $("#id_cuenta_ingresar").val(id_cuenta).change();
        $("#nuevo_saldo").val(saldo);
        $("#disponible").val(disponible);
    }
</script>
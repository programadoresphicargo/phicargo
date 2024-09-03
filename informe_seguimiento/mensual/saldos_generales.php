<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
require_once('obtener_dias_mes.php');

$month = $_POST['mes'];
$year = $_POST['año'];

$fechasMesActual = obtenerPrimerUltimoDia($year, $month);
$fechasMesAnterior = obtenerPrimerUltimoDiaMesAnterior($year, $month);

$primerDiaAc = $fechasMesActual['primerDia']->format('Y-m-d');
$ultimoDiaAc = $fechasMesActual['ultimoDia']->format('Y-m-d');
$primerDiaAnt = $fechasMesAnterior['primerDiaMesAnterior']->format('Y-m-d');
$ultimoDiaAnt =  $fechasMesAnterior['ultimoDiaMesAnterior']->format('Y-m-d');

$estadosSeleccionados = 1;

$sql = "SELECT c.id_cuenta, moneda, referencia, empresas.nombre as nombre_empresa, bancos.nombre as nombre_banco,
       MAX(CASE WHEN s1.fecha BETWEEN '$primerDiaAnt' AND '$ultimoDiaAnt' THEN s1.saldo END) AS saldo_anterior, 
       MAX(CASE WHEN s2.fecha BETWEEN '$primerDiaAc' AND '$ultimoDiaAc' THEN s2.saldo END) AS saldo_actual
FROM cuentas c
LEFT JOIN saldos s1 ON c.id_cuenta = s1.id_cuenta
LEFT JOIN saldos s2 ON c.id_cuenta = s2.id_cuenta
inner join bancos on bancos.id_banco = c.id_banco
inner join empresas on empresas.id_empresa = c.id_empresa
where c.id_empresa IN ($estadosSeleccionados)
group by id_cuenta";

$resultado = $cn->query($sql);

?>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">Empresa</th>
            <th scope="col">Banco</th>
            <th scope="col">Moneda</th>
            <th scope="col">Referencia</th>
            <th scope="col">Mes anterior</th>
            <th scope="col">Mes actual</th>
            <th scope="col">Variación</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['nombre_empresa'] ?></td>
                <td><?php echo $row['nombre_banco'] ?></td>
                <td><?php echo $row['moneda'] ?></td>
                <td><?php echo $row['referencia'] ?></td>
                <td><?php echo $row['saldo_anterior'] ?></td>
                <td><?php echo $row['saldo_actual'] ?></td>
                <?php
                if ($row['saldo_anterior'] != 0 || isset($row['saldo_anterior'])) {
                ?><td><?php echo number_format((($row['saldo_actual'] / $row['saldo_anterior']) * 100) - 100, 2) ?></td>
                <?php
                } else {
                ?><td>0</td>
                <?php
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
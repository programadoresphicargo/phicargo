<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$semana_actual = $_POST['semana'];
$semana_anterior = $_POST['semana'] - 1;

$sql = "SELECT c.id_cuenta, empresa, nombre, moneda, referencia,
       MAX(CASE WHEN s1.semana = $semana_anterior THEN s1.saldo END) AS saldo_anterior, 
       MAX(CASE WHEN s2.semana = $semana_actual THEN s2.saldo END) AS saldo_actual, 
       ((-MAX(CASE WHEN s1.semana = $semana_anterior THEN s1.saldo END) / MAX(CASE WHEN s2.semana = $semana_actual THEN s2.saldo END)) + $semana_anterior) AS variacion
FROM cuentas c
LEFT JOIN saldos s1 ON c.id_cuenta = s1.id_cuenta AND s1.semana = $semana_anterior
LEFT JOIN saldos s2 ON c.id_cuenta = s2.id_cuenta AND s2.semana = $semana_actual
inner join bancos on bancos.id_banco = c.banco
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
            <th scope="col">Saldo anterior</th>
            <th scope="col">Saldo actual</th>
            <th scope="col">Variación</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['empresa'] ?></td>
                <td><?php echo $row['nombre'] ?></td>
                <td><?php echo $row['moneda'] ?></td>
                <td><?php echo $row['referencia'] ?></td>
                <td><?php echo $row['saldo_anterior'] ?></td>
                <td><?php echo $row['saldo_actual'] ?></td>
                <td><?php echo $row['variacion'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
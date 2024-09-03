<?php
if (isset($_POST['consulta'])) {
    $consulta_universal = $_POST['consulta'];
} else {
    $consulta_universal = 'finalizado';
}
?>

<script>
    var id_viaje_universal = '<?php echo $_GET['id'] ?>';
    var placas_universal = '<?php echo $vehiculo1 ?>';
    var operador_universal = '<?php echo $id_operador ?>';
    var modo_universal = '<?php echo $x_modo_bel ?>';
    var cliente_universal = '<?php echo $id_cliente ?>';
    var consulta_universal = '<?php echo $consulta_universal; ?>';
</script>
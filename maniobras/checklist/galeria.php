<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

$SqlSelect = "SELECT * FROM maniobras_evidencias where id_maniobra = $id_cp and tipo = '$tipo'";
$resultado = $cn->query($SqlSelect);
?>

<div class="row">
    <div class="col-md-12 justify-content-center mb-5">

        <?php while ($row = $resultado->fetch_assoc()) {
            $ruta = '../../maniobras_evidencias/';
            $nombreArchivo = $row['ruta']; ?>
            <a data-fslightbox="gallery" href="<?php echo $ruta . $nombreArchivo; ?>">
                <img data-fslightbox="gallery" src="<?php echo $ruta . $nombreArchivo; ?>" width='100' height='100'>
            </a>

        <?php } ?>

    </div>
</div>

<script src="../../assets/js/fslightbox.js"></script>
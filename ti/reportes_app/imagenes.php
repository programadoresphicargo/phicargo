<div class="row">
    <?php
    require_once('../../mysql/conexion.php');
    $cn = conectar();
    $id_reporte = $_POST['res_id'];
    $sql = "SELECT * FROM files where res_id = $id_reporte";
    $resultado = $cn->query($sql);
    while ($row = $resultado->fetch_assoc()) {
    ?>
        <div class="col-sm-4 mb-3 mb-sm-0 col-lg-2">
            <a href="data:image/png;base64,<?php echo $row['datas'] ?>" data-fslightbox="gallery">
                <img class="img-fluid" src="data:image/png;base64,<?php echo $row['datas'] ?>" alt="Image Description">
            </a>
        </div>
    <?php } ?>
</div>
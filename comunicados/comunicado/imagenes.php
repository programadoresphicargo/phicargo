<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_comunicado = $_POST['id_comunicado'];
$sqlSelect = "SELECT * FROM comunicados_fotos where id_comunicado = $id_comunicado";
$resultado = $cn->query($sqlSelect);
?>
<!-- Gallery -->
<div id="fancyboxGallery" class="js-fancybox row justify-content-sm-center gx-3">
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <div class="col-6 col-sm-4 col-md-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-sm">
                <img class="card-img-top" src="../fotos/<?php echo $row['id_comunicado'] . '/' . $row['nombre'] ?>" alt="Image Description">

                <div class="card-body">
                    <div class="row col-divider text-center">
                        <div class="col">
                            <a class="text-body" href="../fotos/1/<?php echo $row['id_comunicado'] . '/' . $row['nombre'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View" data-fslightbox="gallery">
                                <i class="bi-eye"></i>
                            </a>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                            <a class="text-danger" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="Borrar_imagen('<?php echo $row['id_comunicado'] ?>','<?php echo $row['nombre'] ?>')">
                                <i class="bi-trash"></i>
                            </a>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Card -->
        </div>
    <?php } ?>
    <!-- End Col -->
</div>
<!-- End Gallery -->

<script>
    function Borrar_imagen(id_comunicado, nombre) {
        $.ajax({
            url: "borrar_imagen.php",
            type: "POST",
            data: {
                'id_comunicado': id_comunicado,
                'nombre': nombre
            },
            success: function(response) {
                $('#imagenes').load('imagenes.php', {
                    'id_comunicado': id_comunicado
                });
            },
        });
    }
</script>
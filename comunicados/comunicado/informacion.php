<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_comunicado = $_POST['id_comunicado'];
$sqlSelect = "SELECT * FROM comunicados where id_comunicado = $id_comunicado";
$resultado = $cn->query($sqlSelect);
$row = $resultado->fetch_assoc();
?>

<!-- Card -->
<form id="FormComunicado">
    <div class="card mb-3 mb-lg-5">
        <!-- Header -->
        <div class="card-header">
            <h4 class="card-header-title">Datos del comunicado</h4>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body">
            <!-- Form -->
            <div class="mb-4">
                <label for="productNameLabel" class="form-label">Titulo <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Products are the goods or services you sell."></i></label>
                <input type="hidden" class="form-control" name="id_comunicado" id="id_comunicado" value="<?php echo $id_comunicado ?>">
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php if (isset($row['titulo'])) {
                                                                                                echo $row['titulo'];
                                                                                            }  ?>">
            </div>
            <!-- End Form -->

            <label class="form-label">Descripción</label>

            <!-- Quill -->
            <div class="quill-custom">
                <div id="editor" class="js-quill" style="height: 15rem;">
                    <?php if (isset($row['descripcion'])) {
                        echo $row['descripcion'];
                    } ?>
                </div>
            </div>
            <!-- End Quill -->
        </div>
        <!-- Body -->
    </div>
</form>
<!-- End Card -->
<script>
    var quill = new Quill('#editor', {
        modules: {
            toolbar: true
        },
        theme: 'snow'
    });
</script>
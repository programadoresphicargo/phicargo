<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT * FROM mascotas";
$resultado = $cn->query($sqlSelect);

$id_operador = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Default Header (Container) | Front - Admin &amp; Dashboard Template</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/vendor.min.css">
    <link rel="stylesheet" href="../../assets/css/theme.min.css?v=1.0">
    <link rel="preload" href="../../assets/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="../../assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
</head>

<body>
    <main id="content" role="main" class="main">

        <div class="content container">

            <div class="row">
                <?php while ($row = $resultado->fetch_assoc()) { ?>
                    <div class="col-sm-6 col-6 mb-3">
                        <!-- Card -->
                        <div class="card card-sm form-check form-check-select-stretched h-100 zi-1" style="max-width: 20rem;" onclick="cambiar_info('<?php echo $row['nombre'] ?>','<?php echo $row['descripcion'] ?>')">
                            <img class="card-img-top" src="../../mascotas/<?php echo $row['foto'] ?>" alt="Card image cap">
                            <!-- Form Check -->
                            <input type="radio" class="form-check-input" name="mascotas" id="<?php echo $row['nombre'] ?>" value="<?php echo $row['id_mascota'] ?>">
                            <label class="form-check-label" for="<?php echo $row['nombre'] ?>"></label>
                            <!-- End Form Check -->
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo $row['nombre'] ?></h4>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="voto" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Confirmar voto para:</h5>
                </div>
                <div class="modal-body">
                    <h4 id="nombre_mascota" class="card-title text-center"></h4>

                    <p class="card-text" id="descripcion">
                        <small class="text-muted"></small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="cancelar_voto">Cancelar</button>
                    <button type="button" class="btn btn-success" id="confirmar_voto">Confirmar voto</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {

        $.ajax({
            type: "POST",
            data: {
                'id_operador': <?php echo $id_operador ?>
            },
            url: "comprobar.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    console.log('Ya voto');
                    window.location.href = "voto_guardado.php";
                } else {
                    console.log('No se guardo el voto');
                }
            }
        });
    });

    function cambiar_info(nombre, descripcion) {
        $("#voto").modal('show');
        $("#nombre_mascota").text(nombre);
        $("#descripcion").text(descripcion);
    };

    $("#cancelar_voto").click(function() {
        $("#voto").modal('hide');
    });

    $("#confirmar_voto").click(function() {
        var radios = document.getElementsByName("mascotas");

        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                var valorSeleccionado = radios[i].value;
                console.log("Radio seleccionado: " + valorSeleccionado);
                break;
            } else {}
        }

        $.ajax({
            type: "POST",
            data: {
                'id_operador': <?php echo $id_operador ?>,
                'id_mascota': valorSeleccionado
            },
            url: "guardar_voto.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    window.location.href = "voto_guardado.php";
                } else {
                    alert('Error en guardar voto');
                }
            }
        });

    });
</script>
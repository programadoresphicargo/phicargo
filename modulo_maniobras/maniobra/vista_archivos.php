<?php
require_once('../../tiempo/tiempo.php');
$directorio = '../archivos/' . $_POST['id'] . "";

function convertirBytes($bytes)
{
    $kb = $bytes / 1024;
    $mb = $kb / 1024;
    $gb = $mb / 1024;

    if ($bytes < 1024) {
        return $bytes . ' bytes';
    } elseif ($kb < 1024) {
        return round($kb, 2) . ' KB';
    } elseif ($mb < 1024) {
        return round($mb, 2) . ' MB';
    } else {
        return round($gb, 2) . ' GB';
    }
}

?>

<div class="offcanvas offcanvas-start" tabindex="-1" id="archivos_adjuntos_modal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Archivos adjuntos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group">
            <?php
            if (is_dir($directorio)) {
                $archivos = scandir($directorio);
                foreach ($archivos as $archivo) {
                    if (!in_array($archivo, array('.', '..'))) {
                        $rutaArchivo = $directorio . '/' . $archivo;
                        $tamañoArchivo = filesize($rutaArchivo);
                        $fechaCreacion = filectime($rutaArchivo); ?>
                        <!-- List Item -->
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img class="avatar avatar-xs avatar-4x3" src="../../img/img.svg" alt="Image Description">
                                </div>
                                <!-- End Col -->

                                <div class="col">
                                    <h5 class="mb-0">
                                        <a class="text-dark" target="_blank" href="<?php echo $directorio . '/' . $archivo ?>"><?php echo $archivo ?></a>
                                    </h5>
                                    <ul class="list-inline list-separator small text-body">
                                        <li class="list-inline-item"><?php echo imprimirTiempo(date('Y-m-d H:i:s', $fechaCreacion)) ?></li>
                                        <li class="list-inline-item"><?php echo convertirBytes($tamañoArchivo) ?></li>
                                    </ul>
                                </div>
                                <!-- End Col -->

                                <div class="col-auto">
                                    <!-- Dropdown -->
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-white btn-sm" id="filesListDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi-chevron-down"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="filesListDropdown1" style="min-width: 13rem;">
                                            <span class="dropdown-header">Opciones</span>

                                            <a class="dropdown-item" download href="<?php echo $directorio . '/' . $archivo ?>">
                                                <i class="bi-download dropdown-item-icon"></i> Descargar
                                            </a>

                                        </div>
                                    </div>
                                    <!-- End Dropdown -->
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->
                        </li>
                <?php
                    }
                }
            } else { ?>
                <!-- Alert -->
                <div class="alert alert-soft-dark mb-5 mb-lg-7" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img class="avatar avatar-xl" src="../../img/vacio.svg" alt="Image Description" data-hs-theme-appearance="default">
                            <img class="avatar avatar-xl" src="../../img/vacio.svg" alt="Image Description" data-hs-theme-appearance="dark">
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <h3 class="alert-heading mb-1">Nada por aquí</h3>
                            <p class="mb-0">Aún no hay archivos adjuntos.</p>
                        </div>
                    </div>
                </div>
                <!-- End Alert -->
            <?php } ?>
            <!-- End List Item -->
        </ul>
    </div>
</div>
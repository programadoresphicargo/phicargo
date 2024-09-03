<?php
require_once('../../mysql/conexion.php');
$sqlSelect = "SELECT * FROM bonos GROUP BY mes, año order by año, mes asc";
$cn = conectar();
$resultado = $cn->query($sqlSelect);
?>

<!-- Folders -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">
    <?php while ($row = $resultado->fetch_array()) { ?>
        <div class="col mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-sm card-hover-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi-folder-plus fs-2 text-body me-2"></i>

                        <h5 class="text-truncate ms-2 mb-0">
                            <?php
                            $monthNumber = $row['mes'];
                            $monthName = date("F", mktime(0, 0, 0, $monthNumber, 10));
                            echo $monthName . ' ' . $row['año'];
                            ?>
                        </h5>
                    </div>
                </div>
                <a class="stretched-link" href="../operadores/index.php?mes=<?php echo $row['mes'] ?>&año=<?php echo $row['año'] ?>"></a>
            </div>
            <!-- End Card -->
        </div>
    <?php } ?>
    <!-- End Col -->
</div>
<!-- End Folders -->
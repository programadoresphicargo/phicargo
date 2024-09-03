 <?php
    require_once('../../../mysql/conexion.php');
    require_once('../../../tiempo/tiempo.php');

    $cn = conectar();

    if (isset($_POST['id_viaje'])) {
        $id_viaje = $_POST['id_viaje'];
        $sqlSelect = "SELECT *, viajes.id as id_viaje FROM entrega_viajes inner join usuarios on usuarios.id_usuario = entrega_viajes.id_usuario inner join viajes on viajes.id = entrega_viajes.id_viaje where id_viaje = $id_viaje order by fecha desc";
    } else {
        $id_entrega = $_POST['id_entrega'];
        $sqlSelect = "SELECT *, viajes.id as id_viaje FROM entrega_viajes inner join usuarios on usuarios.id_usuario = entrega_viajes.id_usuario inner join viajes on viajes.id = entrega_viajes.id_viaje where id_entrega = $id_entrega order by fecha desc";
    }
    $resultado = $cn->query($sqlSelect);

    ?>
 <!-- Step -->
 <h4 class="mb-3">Entregas por viaje</h4>

 <ul class="step">

     <?php while ($row = $resultado->fetch_assoc()) {
            $primeraLetra = substr($row['nombre'], 0, 1);
        ?>
         <!-- Step Item -->
         <li class="step-item">
             <div class="step-content-wrapper">
                 <span class="step-icon step-icon-soft-primary"><?php echo $primeraLetra ?></span>

                 <div class="step-content">

                     <div class="step-title d-flex justify-content-between align-items-center">
                         <a class="text-dark" href="#">Actualización de entrega</a>
                         <span class="text-muted d-block"><?php imprimirTiempo($row['fecha']) ?></span>
                     </div>

                     <div class="d-flex">
                         <span class="flex-shrink-0">
                             <img class="avatar avatar-xs" src="../../img/usuario.png" alt="Image Description">
                         </span>
                         <div class="flex-grow-1 text-truncate ms-2">
                             <span class="d-block small text-muted" title="weekly-reports.xls">Autor: <?php echo $row['nombre'] ?></span>
                             <p class="fs-5 mb-3">Viaje <a href="../detalle/index.php?id=<?php echo $row['id_viaje'] ?>"><span class="badge bg-primary text-white rounded-pill"><span class="legend-indicator bg-white"></span><?php echo $row['referencia'] ?></span></a></p>
                         </div>
                     </div>

                     <p class="fs-5 mb-1"><?php echo $row['texto'] ?></p>
                 </div>
             </div>
         </li>
         <!-- End Step Item -->
     <?php } ?>

 </ul>
 <!-- End Step -->
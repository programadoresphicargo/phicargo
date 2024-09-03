 <?php
    require_once('../../../mysql/conexion.php');
    require_once('../../../tiempo/tiempo.php');

    $cn = conectar();
    $id = $_POST['id_viaje'];
    $sqlV = "SELECT * FROM viajes where id = $id";
    $resultV = $cn->query($sqlV);
    $rowV = $resultV->fetch_assoc();

    $inicio = $rowV['fecha_inicio'];
    $final = $rowV['fecha_finalizado'];
    $placas = $rowV['placas'];

    if (($inicio != null || $inicio != '') && ($final == '' || $final == null)) {
        $sql = "SELECT * FROM alertas inner join ubicaciones on ubicaciones.id = alertas.id_ubicacion where alertas.placas = '$placas' and fecha > '$inicio' order by fecha desc";
    } else {
        $sql = "SELECT * FROM alertas inner join ubicaciones on ubicaciones.id = alertas.id_ubicacion where alertas.placas = '$placas' and fecha between '$inicio' and '$final' order by fecha desc";
    }
    $resultado = $cn->query($sql);
    ?>

 <!-- Step -->
 <ul class="step">

     <?php while ($row = $resultado->fetch_assoc()) { ?>
         <!-- Step Item -->
         <li class="step-item">
             <div class="step-content-wrapper">
                 <span class="step-icon step-icon-danger"><i class="bi bi-exclamation-triangle-fill"></i></span>

                 <div class="step-content">
                     <div class="step-title d-flex justify-content-between align-items-center">
                         <p class="fs-5 mb-1"><span class="badge bg-danger text-white rounded-pill"><span class="legend-indicator bg-white"></span><?php echo $row['evento'] ?></span></p>
                         <span class="text-muted d-block"><?php imprimirTiempo($row['fecha']) ?></span>
                     </div>

                     <p class="fs-5 mb-1"><?php echo  $row['nombre'] ?></p>

                     <?php if ($row['descripcion'] != '') { ?>
                         <a class="step-title text-danger"><?php echo  $row['descripcion'] ?></a>
                     <?php } ?>

                     <ul class="list-group list-group-flush">
                         <li class="list-group-item list-group-item-light">
                             <div class="row">
                                 <div class="col-10">
                                     <span class="d-block fs-5 text-dark text-truncate">Fecha y Hora: <span class="text-muted"><?php echo $row['fecha'] ?></span></span>
                                     <a class="link link-danger" href="https://www.google.com/maps?q=<?php echo $row['latitud'] . ', ' . $row['longitud'] ?>&15z" target="_blank"><span class="d-block fs-5 text-dark text-truncate">Coordenadas: <span class="text-muted"><?php echo $row['latitud'] . ', ' . $row['longitud'] ?></span></span></a>
                                     <span class="d-block fs-5 text-dark">Referencia: <span class="text-muted"><?php echo $row['referencia'] ?></span></span>
                                     <span class="d-block fs-5 text-dark">Calle: <span class="text-muted"><?php echo $row['calle'] ?></span></span>
                                 </div>
                             </div>
                         </li>
                     </ul>

                 </div>
             </div>
         </li>
     <?php } ?>
     <!-- End Step Item -->
 </ul>
 <!-- End Step -->
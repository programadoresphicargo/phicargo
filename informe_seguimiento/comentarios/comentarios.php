   <?php
    require_once('../../mysql/conexion.php');
    $cn = conectar();

    switch ($_POST['opcion']) {
        case 'dia':
            $fecha_informe = $_POST['fecha'];
            $sql = "SELECT * from informe_comentarios inner join usuarios on usuarios.id_usuario = informe_comentarios.id_usuario where fecha_informe = '$fecha_informe' order by fecha desc";
            break;
        case 'semana':
            $fecha_inicial = $_POST['fechaInicial'];
            $fecha_final = $_POST['fechaFinal'];

            $sql = "SELECT * from informe_comentarios inner join usuarios on usuarios.id_usuario = informe_comentarios.id_usuario where DATE(fecha_informe) BETWEEN '$fecha_inicial' and '$fecha_final' order by fecha desc";
            break;
        case 'mes':
            $mes = $_POST['mes'];
            $año = $_POST['año'];

            $sql = "SELECT * from informe_comentarios inner join usuarios on usuarios.id_usuario = informe_comentarios.id_usuario where MONTH(fecha_informe) = $mes and YEAR(fecha_informe) = $año order by fecha desc";
            break;
    }

    $resultado = $cn->query($sql);
    ?>

   <!-- Step -->
   <ul class="step step-icon-xs mb-0">
       <!-- Step Item -->
       <?php while ($row = $resultado->fetch_assoc()) { ?>
           <li class="step-item">
               <div class="step-content-wrapper">
                   <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                   <div class="step-content">
                       <h5 class="step-title">
                           <a class="text-dark" href="#"><?php echo $row['nombre'] ?></a>
                       </h5>

                       <p class="fs-5 mb-1">añadió un comentario:</p>

                       <ul class="list-group">
                           <!-- Item -->
                           <li class="list-group-item list-group-item-light">
                               <div class="row gx-1">
                                   <div class="col-12">
                                       <div class="d-flex">
                                           <span class="flex-shrink-0">
                                               <img class="avatar avatar-xs" src="../../img/coment.png" alt="Image Description">
                                           </span>
                                           <div class="flex-grow-1 text-truncate ms-2">
                                               <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls"><?php echo $row['comentario'] ?></span>
                                           </div>
                                       </div>
                                   </div>
                                   <!-- End Col -->
                               </div>
                               <!-- End Row -->
                           </li>
                           <!-- End Item -->
                       </ul>

                       <span class="text-muted small text-uppercase"><?php echo $row['fecha'] ?></span>
                   </div>
               </div>
           </li>

       <?php } ?>
       <!-- End Step Item -->
   </ul>
   <!-- End Step -->
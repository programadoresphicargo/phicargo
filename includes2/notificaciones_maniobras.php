 <?php
    require_once('../mysql/conexion.php');
    require_once('../tiempo/tiempo.php');
    $cn = conectar();
    $sqlSelect = "SELECT *, reportes.id as id_reporte FROM reportes where id_maniobra is not null order by fecha_hora desc";
    $resultado = $cn->query($sqlSelect);

    ?>
 <!-- List Group -->
 <ul class="list-group list-group-flush navbar-card-list-group">

     <?php while ($row = $resultado->fetch_assoc()) { ?>
         <!-- Item -->
         <li class="list-group-item form-check-select" onclick="abrir_notificacion(1,'<?php echo $row['id_reporte'] ?>')">
             <div class="row">
                 <div class="col-auto">
                     <div class="d-flex align-items-center">
                         <img class="avatar avatar-sm avatar-circle" src="../../img/alert.png" alt="Image Description">
                     </div>
                 </div>
                 <!-- End Col -->

                 <div class="col ms-n2">
                     <h5 class="mb-1">Reporte operador tengo un problema</h5>
                     <p class="text-body fs-5">Referencia de viaje: <?php echo $row['id_maniobra'] ?> <br> Operador: <?php echo $row['id_maniobra'] ?> <br> Unidad: <?php echo $row['id_maniobra'] ?></p>
                 </div>
                 <!-- End Col -->

                 <small class="col-auto text-muted text-cap"><?php echo imprimirTiempo($row['fecha_hora']) ?></small>
                 <!-- End Col -->
             </div>
             <!-- End Row -->
         </li>
     <?php } ?>
     <!-- End Item -->
 </ul>
 <!-- End List Group -->

 <script>
     function abrir_notificacion(noti, id) {
         if (noti == 1) {
             $("#modal_reporte_problema").modal('show');
             $("#info_reporte").load('../../includes2/info_reporte.php', {
                 'id': id
             });
         }
     }
 </script>
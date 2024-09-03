 <?php
    require_once('../mysql/conexion.php');
    require_once('../tiempo/tiempo.php');
    $cn = conectar();

    $sqlSelect = "SELECT *, reportes.id as id_reporte FROM reportes inner join viajes on viajes.id = reportes.id_viaje inner join operadores on operadores.id = viajes.employee_id inner join unidades on unidades.placas = viajes.placas where id_viaje is not null order by fecha_hora desc";
    $resultado = $cn->query($sqlSelect);
    ?>

 <ul class="list-group list-group-flush navbar-card-list-group">
     <?php while ($row = $resultado->fetch_assoc()) { ?>
         <li class="list-group-item form-check-select" onclick="abrir_noti('<?php echo $row['id_reporte'] ?>')">
             <div class="row">
                 <div class="col-auto">
                     <div class="d-flex align-items-center">
                         <img class="avatar avatar-sm avatar-circle" src="../../img/alert.png" alt="Image Description">
                     </div>
                 </div>

                 <div class="col ms-n2">
                     <h5 class="mb-1">Reporte operador tengo un problema</h5>
                     <p class="text-body fs-5">Referencia de viaje: <?php echo $row['referencia'] ?> <br> Operador: <?php echo $row['nombre_operador'] ?> <br> Unidad: <?php echo $row['unidad'] ?></p>
                 </div>

                 <small class="col-auto text-muted text-cap"><?php echo imprimirTiempo($row['fecha_hora']) ?></small>
                 <small class="col-auto text-muted text-cap">
                     <?php if ($row['atendido'] == 1) { ?>
                         <span class="badge bg-success rounded-pill"><i class="bi bi-check-lg"></i>Atendido</span>
                     <?php } else { ?>
                         <span class="badge bg-warning rounded-pill"><i class="bi bi-clock"></i> En espera de <br> ser atendido</span>
                     <?php } ?>
                 </small>
             </div>
         </li>
     <?php } ?>
 </ul>

 <script>
     function abrir_noti(id_reporte) {
         $("#modal_reporte_problema").modal('show');

         $.ajax({
             data: {
                 'id_reporte': id_reporte
             },
             type: 'POST',
             url: "../../gestion_viajes/reportes/get_reporte.php",
             success: function(respuesta) {

                 var data = JSON.parse(respuesta);
                 console.log(data);

                 $('#id_rpo').val(data.id_reporte);
                 $('#fecha_rpo').val(data.fecha_hora).change();
                 $('#referencia_rpo').val(data.referencia).change();
                 $('#operador_rpo').val(data.nombre_operador).change();
                 $('#unidad_rpo').val(data.unidad).change();
                 $('#comentarios_operador_rpo').val(data.comentarios_operador).change();
                 $('#comentarios_monitorista_rpo').val(data.comentarios_monitorista).change();
                 $('#usuario_resolvio_rpo').val(data.nombre).change();
                 $('#fecha_resuelto_rpo').val(data.fecha_resuelto).change();

                 if (data.atendido == '1') {
                     $('#atenderpo').hide();
                     $('#comentarios_monitorista_rpo').prop('disabled', true);
                 } else {
                     $('#atenderpo').show();
                     $('#comentarios_monitorista_rpo').prop('disabled', false);
                 }
             }
         });
     }
 </script>
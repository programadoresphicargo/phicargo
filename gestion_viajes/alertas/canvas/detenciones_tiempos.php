 <?php
    require_once('../../../mysql/conexion.php');
    require_once('../../../tiempo/tiempo.php');
    require_once('procesar_fechas.php');
    require_once('metodos.php');

    $cn = conectar();
    $id = $_POST['id_viaje'];

    $palabras = explode(" ", $_POST['placas']);

    if (isset($palabras[1])) {
        $variable2 = str_replace(["[", "]"], "", $palabras[1]);
    } else {
        $variable2 = $_POST['placas'];
    }

    $sql = "SELECT * FROM reportes_estatus_viajes WHERE id_viaje = $id order by fecha_envio asc";
    $result = $cn->query($sql);

    $inicioViajeFecha = null;
    $llegadaPlantaFecha = null;
    $salidaPlantaFecha = null;
    $finViajeFecha = null;

    procesarFechas($inicioViajeFecha, $llegadaPlantaFecha, $salidaPlantaFecha, $finViajeFecha, $result);
    ?>

 <ul class="step">

     <table class="table table-striped">
         <thead>
             <tr>
                 <th scope="col">Unidad</th>
                 <th scope="col">Tiempo total</th>
             </tr>
         </thead>
         <tbody>
             <tr>
                 <td><?php echo 'Inicio viaje' ?></td>
                 <td><?php echo $inicioViajeFecha ?></td>
             </tr>
             <tr>
                 <td><?php echo 'Llegada a planta' ?></td>
                 <td><?php echo $llegadaPlantaFecha ?></td>
             </tr>
             <tr>
                 <td><?php echo 'Salida de planta' ?></td>
                 <td><?php echo $salidaPlantaFecha ?></td>
             </tr>
             <tr>
                 <td><?php echo 'Fin de viaje' ?></td>
                 <td><?php echo $finViajeFecha ?></td>
             </tr>
         </tbody>
     </table>
 </ul>
 <!-- Step -->
 <ul class="step">
     <li class="step-item">
         <div class="step-content-wrapper">
             <span class="step-icon step-icon-soft-primary"><i class="bi bi-geo-alt-fill"></i></span>
             <div class="step-content">
                 <h5 class="m-2">
                     <a class="text-dark">Detenciones patio a cliente</a>
                 </h5>
                 <ul class="list-group list-group-sm">
                     <li class="list-group-item">
                         <div class="d-flex">
                             <div class="flex-grow-1 text-truncate ms-2">
                                 <?php $htmlGenerado1 = obtenerDetenciones($variable2, $inicioViajeFecha, $llegadaPlantaFecha);
                                    echo $htmlGenerado1;
                                    ?>
                             </div>
                         </div>
                     </li>
                 </ul>
             </div>
         </div>
     </li>

     <li class="step-item">
         <div class="step-content-wrapper">
             <span class="step-icon step-icon-soft-primary"><i class="bi bi-geo-alt-fill"></i></span>
             <div class="step-content">
                 <h5 class="m-2">
                     <a class="text-dark">Detenciones con cliente</a>
                 </h5>
                 <ul class="list-group list-group-sm">
                     <li class="list-group-item">
                         <div class="d-flex">
                             <div class="flex-grow-1 text-truncate ms-2">
                                 <?php $htmlGenerado1 = obtenerDetenciones($variable2, $llegadaPlantaFecha, $salidaPlantaFecha);
                                    echo $htmlGenerado1;
                                    ?>
                             </div>
                         </div>
                     </li>
                 </ul>
             </div>
         </div>
     </li>

     <li class="step-item">
         <div class="step-content-wrapper">
             <span class="step-icon step-icon-soft-primary"><i class="bi bi-geo-alt-fill"></i></span>
             <div class="step-content">
                 <h5 class="m-2">
                     <a class="text-dark">Detenciones de salida con cliente a patio</a>
                 </h5>
                 <ul class="list-group list-group-sm">
                     <li class="list-group-item">
                         <div class="d-flex">
                             <div class="flex-grow-1 text-truncate ms-2">
                                 <?php $htmlGenerado1 = obtenerDetenciones($variable2, $salidaPlantaFecha, $finViajeFecha);
                                    echo $htmlGenerado1;
                                    ?>
                             </div>
                         </div>
                     </li>
                 </ul>
             </div>
         </div>
     </li>

 </ul>
    <?php
    require_once('getManiobra2.php');
    ?>
    <!-- Card -->
    <div class="js-sticky-block card mb-3 mb-lg-5 animate__animated animate__bounceIn" data-hs-sticky-block-options='{
                     "parentSelector": "#accountSidebarNav",
                     "breakpoint": "lg",
                     "startPoint": "#accountSidebarNav",
                     "endPoint": "#stickyBlockEndPoint",
                     "stickyOffsetTop": 20
                   }'>
        <!-- Header -->
        <div class="card-header bg-primary">
            <div class="row">
                <div class="col">
                    <h4 class="card-header-title text-white">Maniobra 1: Retiro</h4>
                </div>
                <div class="col-auto">
                    <?php foreach ($products as $datos) {
                        $datos['x_mov_bel'] != false ? $terminal = $datos['x_mov_bel'] : $terminal = '';
                        $datos['x_inicio_programado_retiro'] != false ? $horario = $datos['x_inicio_programado_retiro'] : $horario = '0000-00-00 00:00:00';
                        $datos['x_operador_retiro_id'] != false ? $operador = $datos['x_operador_retiro_id'][0] : $operador = 0;
                        $datos['x_eco_retiro_id'] != false ? $eco = $datos['x_eco_retiro_id'][0] : $eco = 0;
                        $datos['x_remolque_1_retiro'] != false ? $r1 = $datos['x_remolque_1_retiro'][0] : $r1 = 0;
                        $datos['x_remolque_2_retiro'] != false ? $r2 = $datos['x_remolque_2_retiro'][0] : $r2 = 0;
                        $datos['x_dolly_retiro'] != false ? $dolly = $datos['x_dolly_retiro'][0] : $dolly = 0;
                        $datos['x_tipo_terminal_retiro'] != false ? $tipoterminal = $datos['x_tipo_terminal_retiro'] : $tipoterminal = 'puerto';
                        $datos['x_motogenerador_1_retiro'] != false ? $moto1 = $datos['x_motogenerador_1_retiro'][0] : $moto1 = 0;
                        $datos['x_motogenerador_2_retiro'] != false ? $moto2 = $datos['x_motogenerador_2_retiro'][0] : $moto2 = 0;
                    ?>
                        <button type="button" class="btn btn-soft-dark btn-sm text-white retiro" onclick="InfoManiobraRetiro('<?php echo $terminal ?>','<?php echo $horario ?>',<?php echo $operador ?>, <?php echo $eco ?>,<?php echo $r1 ?>, <?php echo $r2 ?>, <?php echo $dolly ?>,'<?php echo $tipoterminal ?>',<?php echo $moto1 ?>,<?php echo $moto2 ?>)">Asignar equipo</button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body">
            <ul class="list-unstyled list-py-2 text-dark mb-0">
                <?php foreach ($products as $datos) { ?>
                    <li class="pb-0"><span class="card-subtitle">Datos de la maniobra</span></li>
                    <li><i class="bi bi-buildings dropdown-item-icon"></i>Terminal de retiro: <?php echo $datos['x_mov_bel'] == false ? '' : $datos['x_mov_bel'] ?> </li>
                    <li><i class="bi bi-truck dropdown-item-icon"></i>Tipo terminal: <?php echo $datos['x_tipo_terminal_retiro'] == false ? '' : $datos['x_tipo_terminal_retiro'] ?> </li>
                    <li><i class="bi bi-truck dropdown-item-icon"></i>ECO Retiro: <?php echo $datos['x_eco_retiro_id'] == false ? '' : $datos['x_eco_retiro_id'][1] ?> </li>
                    <?php
                    if (isset($datos['x_eco_retiro_id'][1])) {
                        $cadena = $datos['x_eco_retiro_id'][1];
                        $separador = " ";
                        $separada = explode($separador, $cadena);
                        $result = str_replace(array("[", "]"), '', $separada[1]);
                        $eco_retiro = $result;
                    } else {
                        $eco_retiro = '';
                    }
                    ?>
                    <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Remolque 1: <?php echo $datos['x_remolque_1_retiro']  == false ? '' : $datos['x_remolque_1_retiro'][1] ?> </li>
                    <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Remolque 2: <?php echo $datos['x_remolque_2_retiro'] == false ? '' : $datos['x_remolque_2_retiro'][1] ?> </li>
                    <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Dolly: <?php echo $datos['x_dolly_retiro']  == false ? '' : $datos['x_dolly_retiro'][1] ?> </li>
                    <li><i class="bi bi-clock dropdown-item-icon"></i>Inicio programado: <?php echo $datos['x_inicio_programado_retiro'] == false ? '' : $datos['x_inicio_programado_retiro'] ?> </li>
                    <li><i class="bi-person dropdown-item-icon"></i>Operador retiro: <?php echo $datos['x_operador_retiro_id']  == false ? '' : $datos['x_operador_retiro_id'][1] ?> </li>
                    <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Motogenerador 1: <?php echo $datos['x_motogenerador_1_retiro']  == false ? '' : $datos['x_motogenerador_1_retiro'][1] ?> </li>
                    <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Motogenerador 2: <?php echo $datos['x_motogenerador_2_retiro']  == false ? '' : $datos['x_motogenerador_2_retiro'][1] ?> </li>
                <?php } ?>
            </ul>
        </div>
        <!-- End Body -->
    </div>
    <!-- End Card -->
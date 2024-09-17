<?php
require_once('getManiobra2.php');
?>
<!-- Card -->
<div class="js-sticky-block card mb-3 mb-lg-5 animate__animated animate__bounceIn">
    <!-- Header -->
    <div class="card-header bg-success">
        <div class="row">
            <div class="col">
                <h4 class="card-header-title text-white">Maniobra 2: Ingreso</h4>
            </div>
            <div class="col-auto">
                <?php foreach ($products as $datos) {
                    $datos['x_terminal_bel'] != false ? $terminal = $datos['x_terminal_bel'] : $terminal = '';
                    $datos['x_inicio_programado_ingreso'] != false ? $horario = $datos['x_inicio_programado_ingreso'] : $horario = '0000-00-00 00:00:00';
                    $datos['x_eco_ingreso_id'] != false ? $eco = $datos['x_eco_ingreso_id'][0] : $eco = 0;
                    $datos['x_mov_ingreso_bel_id'] != false ? $operador = $datos['x_mov_ingreso_bel_id'][0] : $operador = 0;
                    $datos['x_remolque_1_ingreso'] != false ? $r1 = $datos['x_remolque_1_ingreso'][0] : $r1 = 0;
                    $datos['x_remolque_2_ingreso'] != false ? $r2 = $datos['x_remolque_2_ingreso'][0] : $r2 = 0;
                    $datos['x_dolly_ingreso'] != false ? $dolly = $datos['x_dolly_ingreso'][0] : $dolly = 0;
                    $datos['x_tipo_terminal_ingreso'] != false ? $tipoterminal = $datos['x_tipo_terminal_ingreso'] : $tipoterminal = 'puerto';
                    $datos['x_motogenerador_1_ingreso'] != false ? $moto1 = $datos['x_motogenerador_1_ingreso'][0] : $moto1 = 0;
                    $datos['x_motogenerador_2_ingreso'] != false ? $moto2 = $datos['x_motogenerador_2_ingreso'][0] : $moto2 = 0;
                    $datos['x_cp_enlazada'] != false ? $cp_enlazada = $datos['x_cp_enlazada'][0] : $cp_enlazada = 0;
                ?>
                    <button type="button" class="btn btn-soft-dark btn-sm text-white ingreso" onclick="InfoManiobraIngreso('<?php echo $terminal ?>','<?php echo $horario ?>',<?php echo $operador ?>, <?php echo $eco ?>, <?php echo $r1 ?>, <?php echo $r2 ?>, <?php echo $dolly ?>,'<?php echo $tipoterminal ?>',<?php echo $moto1 ?>,<?php echo $moto2 ?>,<?php echo $cp_enlazada ?>)">Asignar equipo</button>
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
                <li><i class="bi bi-buildings dropdown-item-icon"></i>Terminal de ingreso: <?php echo $datos['x_terminal_bel'] == false ? '' : $datos['x_terminal_bel'] ?> </li>
                <li><i class="bi bi-truck dropdown-item-icon"></i>Tipo terminal: <?php echo $datos['x_tipo_terminal_ingreso'] == false ? '' : $datos['x_tipo_terminal_ingreso'] ?> </li>
                <li><i class="bi bi-truck dropdown-item-icon"></i>ECO Ingreso: <?php echo $datos['x_eco_ingreso_id'] == false ? '' : $datos['x_eco_ingreso_id'][1] ?> </li>
                <?php
                if (isset($datos['x_eco_ingreso_id'][1])) {
                    $cadena = $datos['x_eco_ingreso_id'][1];
                    $separador = " ";
                    $separada = explode($separador, $cadena);
                    $result = str_replace(array("[", "]"), '', $separada[1]);
                    $eco_ingreso = $result;
                } else {
                    $eco_ingreso = '';
                }
                ?>
                <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Remolque 1: <?php echo $datos['x_remolque_1_ingreso'] == false ? '' : $datos['x_remolque_1_ingreso'][1] ?> </li>
                <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Remolque 2: <?php echo $datos['x_remolque_2_ingreso'] == false ? '' : $datos['x_remolque_2_ingreso'][1] ?> </li>
                <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Dolly: <?php echo $datos['x_dolly_ingreso'] == false ? '' : $datos['x_dolly_ingreso'][1] ?> </li>
                <li><i class="bi bi-clock dropdown-item-icon"></i>Inicio programado: <?php echo $datos['x_inicio_programado_ingreso'] == false ? '' : $datos['x_inicio_programado_ingreso'] ?> </li>
                <li><i class="bi-person dropdown-item-icon"></i>Operador retiro: <?php echo $datos['x_mov_ingreso_bel_id'] == false ? '' : $datos['x_mov_ingreso_bel_id'][1] ?> </li>
                <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Motogenerador 1: <?php echo $datos['x_motogenerador_1_ingreso']  == false ? '' : $datos['x_motogenerador_1_ingreso'][1] ?> </li>
                <li><i class="bi bi-truck-flatbed dropdown-item-icon"></i>Motogenerador 2: <?php echo $datos['x_motogenerador_2_ingreso']  == false ? '' : $datos['x_motogenerador_2_ingreso'][1] ?> </li>
            <?php } ?>
        </ul>
    </div>
    <!-- End Body -->
</div>
<!-- End Card -->
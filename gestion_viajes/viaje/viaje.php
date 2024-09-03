<?php

$datos = json_decode($json, true);

foreach ($datos as $row) {
  $id_viaje    = $row['travel_id'][0];
  $referencia    = $row['travel_id'][1];
  $id_operador      = $row['employee_id'][0];
  $operador      = $row['employee_id'][1];
  $vehiculo1 = $row['vehicle_id'][1];

  $vehiculo = explode(" ", $row['vehicle_id'][1]);
  $unidad        = $vehiculo[0];
  $placas        = str_replace(array("[", "]"), "", $vehiculo[1]);

  $id_cliente    = $row['partner_id'][0];
  $cliente       = $row['partner_id'][1];
  $ruta          = $row['route_id'][1];
  $date_start    = $row['date_start'];
  $x_reference   = $row['x_reference'];
  $x_modo_bel    = $row['x_modo_bel'];
  $x_custodia_bel    = $row['x_custodia_bel'];
  $x_date_arrival_shed = $row['x_date_arrival_shed'];
  $ejecutivo     = $row['x_ejecutivo_viaje_bel'];
  $x_modo_bel    = $row['x_modo_bel'];
  $download_point    = $row['download_point'];
  $upload_point    = $row['upload_point'];
  $x_codigo_postal    = $row['x_codigo_postal'];
}
?>

<main role="main" class="bg-soft-secondary">

  <div class="content bg-white" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.03);">
    <div class="row" style="margin-left: 15px;margin-right: 15px">
      <div class="col-lg-12">
        <h1 class="page-header-title"><?php echo $referencia ?></h1>
        <ul class="list-inline list-px-2">
          <li class="list-inline-item">
            <?php if ($x_modo_bel == 'imp') { ?>
              <span class="badge bg-success rounded-pill ms-1"><i class="bi bi-bookmark"></i><?php echo $x_modo_bel == 'imp' ? 'Importación' : 'Exportación' ?></span>
            <?php } else { ?>
              <span class="badge bg-danger rounded-pill ms-1"><i class="bi bi-bookmark"></i><?php echo $x_modo_bel == 'imp' ? 'Importación' : 'Exportación' ?></span>
            <?php } ?>
          </li>
          <li class="list-inline-item">
            <i class="bi bi-person"></i>
            <span><?php echo $operador ?></span>
          </li>
          <li class="list-inline-item">
            <i class="bi bi-truck"></i>
            <span><?php echo $vehiculo1 ?></span>
          </li>
          <li class="list-inline-item">
            <?php if ($x_custodia_bel == 'yes') { ?>
              <span class="badge bg-danger rounded-pill ms-1">Lleva custodia</span>
            <?php } ?>
          </li>
        </ul>
      </div>
      <div class="col-lg-6 col-sm-7 col-md-7">
        <button class="btn btn-success btn-xs" type="button" id='Iniciar_modal' style="display:none;width:150px"><i class="bi bi-play-fill"></i>Iniciar</button>
        <button class="btn btn-danger btn-xs" type="button" id='Finalizar_modal' style="display:none;"> <i class="bi bi-pause"></i> Finalizar</button>
        <button class="btn btn-primary btn-xs" type="button" id="offpods"><i class="bi bi-file-earmark-text-fill"></i> Documentos</button>
        <button class="btn btn-warning btn-xs text-white" type="button" id="checklist"><i class="bi bi-file-earmark-text-fill"></i> Checklist</button>
        <button class="btn btn-danger btn-xs" id="abrir_alertas_detalle" type="button"><i class="bi bi-sign-stop"></i> Alertas y Detenciones</button>
        <button class="btn btn-primary btn-xs" type="button" id='Finalizado' disabled style="display:none;"> <span data-feather="check" class="feather-sm me-1"></span> Finalizado</button>
        <button class="btn btn-morado btn-xs" type="button" id='modal_resguardo' style="display:none;"> <span data-feather="check" class="feather-sm me-1"></span><i class="bi bi-truck"></i> Liberar resguardo</button>
        <button id="btn_enviar_status" type="button" class="btn btn-success btn-xs" style="display:none;"><i class="bi bi-send-plus"></i> Enviar nuevo estatus</button>
        <button type="button" class="btn btn-primary btn-xs" id="modal_ligar_abrir" style="display:none;"><i class="bi bi-envelope-plus"></i> Correos ligados</button>
        <button id="cancelar_viaje_modal" type="button" class="btn btn-danger btn-xs" style="display:none;"><i class="bi bi-x-circle"></i> Cancelar</button>
        <button id="reactivar_viaje" type="button" class="btn btn-success btn-xs" style="display:none;"><i class="bi bi-check-circle"></i> Reactivar</button>
        <button id="abrir_incidencias_canvas" type="button" class="btn btn-danger btn-xs"><i class="bi bi-exclamation-triangle-fill"></i> Registrar para entrega</button>
        <button id="abrir_custodia_canvas" type="button" class="btn btn-primary btn-xs"><i class="bi bi-exclamation-triangle-fill"></i> Custodia</button>
      </div>

      <div class="col-lg-6 col-md-5 col-md-5">
        <ul class="nav nav-tabs align-items-center mt-2">
          <li class="nav-item ms-auto mb-3">
            <div class="d-flex gap-2">
              <div class="arrow-steps">
                <div id="step1" class="step"> <span>En ruta</span> </div>
                <div id="step2" class="step"> <span>En Planta</span> </div>
                <div id="step3" class="step"> <span>Resguardo</span> </div>
                <div id="step4" class="step"> <span>Retorno</span> </div>
                <div id="step5" class="step"> <span>Finalizado</span> </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="content container-fluid">

    <div class="row">
      <div class="col-sm-12 col-lg-3 mt-4">

        <?php if ($x_custodia_bel == 'yes') { ?>
          <div class="card bg-danger mb-3 mb-lg-5">
            <div class="card-body">
              <h1 class="text-white"> Servicio con custodia</h1>
            </div>
          </div>
        <?php } ?>

        <div class="card card-body mb-3 mb-lg-5">
          <h5>Porcentaje de cumplimiento de envio de estatus del operador</h5>
          <div class="progress" style="height: 20px;">
            <div id="progresscumplimiento" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title text-primary">Información del viaje</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-py-2 text-dark mb-0">
              <li class="pb-0"><span class="card-subtitle">Datos</span></li>
              <li><strong>Ejecutivo: </strong> <?php echo $ejecutivo ?></li>
              <li><strong>Cliente: </strong> <?php echo $cliente ?></li>
              <li><strong>Modo: </strong> <?php echo $x_modo_bel == 'imp' ? 'IMPORTACIÓN' : 'EXPORTACIÓN' ?></li>
              <li><strong><?php echo $x_modo_bel == 'imp' ? 'Punto de descarga: ' : 'Punto de carga: ' ?></strong> <?php echo $x_modo_bel == 'imp' ? $download_point : $upload_point ?></li>
              <li><strong>Codigo postal: </strong> <?php echo $x_codigo_postal ?></li>
              <li><strong>Ruta prog: </strong> <?php echo $ruta ?></li>
              <li><strong>Inicio Ruta Prog: </strong> <?php echo $date_start ?></li>
              <li><strong>Planta Prog: </strong> <?php echo $x_date_arrival_shed ?></li>
              <li><strong>Unidad: </strong> <?php echo '[' . $placas . '] ' . $unidad ?></li>
              <li><strong>Contenedores: </strong> <?php echo $x_reference ?></li>
              <li><strong>Operador: </strong> <?php echo '(' . $id_operador . ') ' . $operador ?></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-lg-6 mt-4">
        <div class="d-grid gap-3 gap-lg-5">
          <div class="card">
            <div class="card-header card-header-content-between">
              <h4 class="card-header-title">Línea del tiempo</h4>

              <div class="w-md-50">
                <div class="input-group input-group-merge">
                  <input type="text" class="js-form-search form-control bg-soft-secondary" placeholder="Buscar">
                  <button type="button" class="input-group-append input-group-text">
                  </button>
                </div>
              </div>

              <button class="btn btn-primary btn-sm" id="actualizarhistorial" type="button"><i class="bi bi-arrow-clockwise"></i> Actualizar</button>

              <div class="dropdown">
                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="contentActivityStreamDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi-three-dots-vertical"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="contentActivityStreamDropdown">
                  <span class="dropdown-header">Descargar</span>

                  <a class="dropdown-item" href="estatus/exportar_excel.php?id_viaje=<?php echo $id_viaje ?>" target="_blank">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                  </a>

                </div>
              </div>
            </div>

            <div class="card-body card-body-height" style="height: 100rem;">
              <div id='linea_tiempo_status' class="p-3"></div>
            </div>

            <div class="card-footer">
            </div>
          </div>
        </div>

        <div id="stickyBlockEndPoint"></div>
      </div>

      <div class="col mt-4">
        <div class="card">
          <div class="card-header">
            Ultima ubicacion de estatus reportada a cliente
          </div>
          <div class="card-body" id="map3" style="height: 600px;">
          </div>
          <div class="card-footer">
          </div>
        </div>
      </div>

    </div>
  </div>
</main>
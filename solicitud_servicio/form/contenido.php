  <main id="content" role="main" class="main">
      <div class="content">
          <div class="p-5">
              <div class="row align-items-left">
                  <div class="col-sm">
                      <h1 class="page-header-title">Nueva solicitud</h1>
                      <span id="name_cp" class="badge rounded-pill">Cancelada</span>
                  </div>
                  <div class="col-auto">
                      <button class="btn btn-primary btn-sm" type="button" id="abrir_archivos" style="display: none;">
                          <i class="bi bi-file-earmark-text"></i> Adjuntar archivos
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="" onclick="aprobar()">
                          Aprobar
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="" onclick="imprimir()" disabled>
                          Imprimir
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="" onclick="confirmar()" disabled>
                          Confirmar
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="" onclick="duplicar()">
                          Duplicar
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="" onclick="crear_viaje()">
                          Crear viaje
                      </button>
                      <button class="btn btn-primary btn-sm" type="button" id="actualizar_solicitud" style="display: none;">
                          <i class="bi bi-floppy"></i> Guardar cambios
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="editar_solicitud" style="display: none;">
                          <i class="bi bi-pencil-square"></i> Editar
                      </button>
                      <button class="btn btn-success btn-sm" type="button" id="guardar_solicitud" style="display: none;">
                          <i class="bi bi-floppy"></i> Enviar solicitud
                      </button>
                  </div>
              </div>
              <div class="row p-0 m-0">
                  <div class="col p-0 m-0">
                      <div class="js-nav-scroller hs-nav-scroller-horizontal p-0 m-0">

                          <ul class="nav nav-tabs">
                              <li class="nav-item">
                                  <a class="nav-link active" href="#">Solicitud</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" href="#">Maniobra 1</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" href="../../gestion_viajes/viajes/index.php">Viaje</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" href="#">Maniobra 2</a>
                              </li>
                          </ul>

                      </div>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <?php require_once('form.php'); ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </main>
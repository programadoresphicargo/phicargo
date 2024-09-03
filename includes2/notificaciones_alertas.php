<li class="nav-item d-none d-md-inline-block">
    <div class="dropdown">
        <button type="button" class="btn btn-icon rounded-circle" id="modal_notificaciones_estatus_operador" onclick="notificaciones_alertas()" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
            <i class="bi bi-crosshair"></i>
            <span id="num_noti_alertas" class="badge bg-warning rounded-pill">0</span>
        </button>

        <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="navbarNotificationsDropdown" style="width: 45rem;">
            <div class="card">
                <div class="card-header card-header-content-between">
                    <h4 class="card-title mb-0">Notificaciones de alertas GPS</h4>
                </div>
                <div class="card-body-height" style="height: 35rem">
                    <div id="notificaciones_alertas">
                    </div>
                </div>
                <div class="card-footer">
                    <a class="badge bg-warning text-center" href="../../gestion_viajes/detenciones/index.php">
                        Ver todas las alertas
                    </a>
                </div>
            </div>
        </div>
    </div>
</li>
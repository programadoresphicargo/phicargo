<li class="nav-item d-none d-md-inline-block">
    <div class="dropdown">
        <button type="button" class="btn btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
            <i class="bi-bell"></i>
            <span id="led" class="btn-status btn-sm-status"></span>
        </button>

        <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="navbarNotificationsDropdown" style="width: 45rem;">
            <div class="card">
                <div class="card-header card-header-content-between">
                    <h4 class="card-title mb-0">Notificaciones</h4>
                </div>

                <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#notificationNavOne" id="notificationNavOne-tab" data-bs-toggle="tab" data-bs-target="#notificationNavOne" role="tab" aria-controls="notificationNavOne" aria-selected="true">Reportes de viaje</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#notificationNavTwo" id="notificationNavTwo-tab" data-bs-toggle="tab" data-bs-target="#notificationNavTwo" role="tab" aria-controls="notificationNavTwo" aria-selected="false">Reporte de maniobras</a>
                    </li>
                </ul>

                <div class="card-body-height" style="height: 30rem;">
                    <div class="tab-content" id="notificationTabContent">
                        <div class="tab-pane fade show active" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">
                            <div class="div" id="notificaciones">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel" aria-labelledby="notificationNavTwo-tab">
                            <div class="div" id="notificaciones_maniobras">
                            </div>
                        </div>
                    </div>
                </div>

                <a class="card-footer text-center link link-primary" href="../../gestion_viajes/reportes/index.php">
                    Ver todos los reportes
                </a>
            </div>
        </div>
    </div>
</li>
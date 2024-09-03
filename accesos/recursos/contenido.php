<body class="bg-light">

    <main id="content" role="main" class="main">
        <div class="bg-dark">
            <div class="content container" style="height: 25rem;">
                <div class="page-header page-header-light page-header-reset">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="page-header-title">Sistema de Control de Accesos y Salidas</h1>
                        </div>

                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content container" style="margin-top: -20rem;">
            <div class="navbar-expand-lg">
                <button class="navbar-toggler text-white border-white-10 w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-controls="navbarVerticalNavMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="d-flex justify-content-between align-items-center">
                        <span class="navbar-toggler-text text-white">Nav menu</span>
                        <span class="navbar-toggler-default">
                            <i class="bi-list"></i>
                        </span>
                        <span class="navbar-toggler-toggled">
                            <i class="bi-x"></i>
                        </span>
                    </span>
                </button>

                <aside id="navbarVerticalNavMenu" class="js-navbar-vertical-aside navbar navbar-vertical navbar-vertical-absolute navbar-vertical-detached navbar-shadow navbar-collapse collapse bg-white rounded-2">
                    <div class="navbar-vertical-container">
                        <div class="navbar-vertical-footer-offset">
                            <div class="navbar-vertical-content">
                                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">

                                    <span class="dropdown-header mt-4">Accesos y salidas</span>
                                    <small class="bi-three-dots nav-subtitle-replacer"></small>

                                    <div class="nav-item">
                                        <a class="nav-link " onclick="abrir_accesos_peatonal()" data-placement="left">
                                            <i class="bi-kanban nav-icon"></i>
                                            <span class="nav-link-title">Movimiento peatonal</span>
                                        </a>
                                    </div>

                                    <div class="nav-item">
                                        <a class="nav-link " onclick="abrir_accesos_vehicular()" data-placement="left">
                                            <i class="bi-calendar-week nav-icon"></i>
                                            <span class="nav-link-title">Movimiento vehicular</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="sidebar-detached-content mt-3 mt-lg-0">
                <div class="card card-centered mb-3 mb-lg-5">
                    <div class="card-body py-10">
                        <div class="table-responsive">
                            <div id="registros"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
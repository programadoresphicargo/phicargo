<main id="content" role="main" class="main">
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Disponibilidad de Equipos</h1>
                    </div>
                    <div class="col-auto">
                        <div class="input-group">
                            <div class="navbar-nav-wrap-content-start">
                                <!-- Search Form -->
                                <div class="d-none d-lg-block">
                                    <div class="dropdown ms-2">
                                        <!-- Input Group -->
                                        <div class="d-none d-lg-block">
                                            <div class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
                                                <div class="input-group-prepend input-group-text">
                                                    <i class="bi-search"></i>
                                                </div>

                                                <input id="fullName" type="search" class="js-form-search form-control" placeholder="Buscador" data-hs-form-search-options='{
                           "clearIcon": "#clearSearchResultsIcon",
                           "dropMenuElement": "#searchDropdownMenu4",
                           "dropMenuOffset": 50,
                           "toggleIconOnFocus": true,
                           "activeClass": "focus"
                         }'>
                                                <a class="input-group-append input-group-text" href="javascript:;">
                                                    <i id="clearSearchResultsIcon" class="bi-x-lg" style="display: none;"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- End Input Group -->

                                        <!-- Card Search Content -->
                                        <div id="searchDropdownMenu4" class="hs-form-search-menu-content dropdown-menu dropdown-menu-form-search navbar-dropdown-menu-borderless">
                                            <div class="card">
                                                <!-- Body -->
                                                <div class="card-body-height" style="height: 25rem;">
                                                    <div class="d-lg-none">
                                                        <div class="input-group input-group-merge navbar-input-group mb-5">
                                                            <div class="input-group-prepend input-group-text">
                                                                <i class="bi-search"></i>
                                                            </div>

                                                            <input type="search" class="form-control" placeholder="Search in front" aria-label="Search in front">
                                                            <a class="input-group-append input-group-text" href="javascript:;">
                                                                <i class="bi-x-lg"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <span class="dropdown-header">Campos</span>

                                                    <div id="campos_busqueda">
                                                        <!-- Aquí se generarán dinámicamente los elementos <a> -->
                                                    </div>


                                                    <span class="dropdown-header">Busquedas recientes</span>

                                                    <div id="dropdown-list" class="dropdown-item bg-transparent text-wrap">
                                                        <!-- Aquí se generarán dinámicamente los elementos <a> -->
                                                    </div>

                                                </div>
                                                <!-- End Body -->
                                            </div>
                                        </div>
                                        <!-- End Card Search Content -->

                                    </div>

                                </div>
                                <!-- End Search Form -->
                            </div>
                            <!-- Select -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                <i class="bi bi-funnel-fill"></i> Agrupar por
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenu">
                                <!-- JavaScript generará las opciones aquí -->
                            </div>
                        </div>
                        <!-- End Dropdown -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content container-fluid" style="margin-top: -18rem;">
        <div class="card mb-3">
            <div class="card-body">
                <div id="contenido">
                </div>
            </div>
        </div>
    </div>
</main>
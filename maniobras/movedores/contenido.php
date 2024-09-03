<main id="content" role="main" class="main">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="card-header-title text-primary">Movedores</h1>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="row align-items-sm-center">
                            <div class="col-sm-auto">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-filter me-1"></i> Rango fecha
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered" aria-labelledby="usersFilterDropdown" style="min-width: 22rem;">
                                        <div class="card">
                                            <div class="card-header card-header-content-between">
                                                <h5 class="card-header-title">Filtro</h5>
                                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2">
                                                    <i class="bi-x-lg"></i>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="daterange" class="form-control daterangepicker-custom-input" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 m-0">
                <div id="tabla"></div>
            </div>
        </div>
    </div>
</main>
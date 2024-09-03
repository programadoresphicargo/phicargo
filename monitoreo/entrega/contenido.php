<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Entrega de turno</h1>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">

                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->
        </div>
    </div>
    <!-- End Content -->

    <!-- Content -->
    <div class="content container-fluid" style="margin-top: -18rem;">
        <!-- Card -->
        <div class="card card-centered">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" id="nueva_entrega">+ Nueva Entrega</button>
                    </div>
                    <div class="col-auto">
                        <div class="input-group input-group-merge input-group-flush mb-4">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input id="search-input" type="search" class="form-control" placeholder="Buscar" aria-label="Search by title">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body animate__animated animate__fadeIn">
                <div id='calendar' class="js-fullcalendar fullcalendar-custom"></div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->
</main>
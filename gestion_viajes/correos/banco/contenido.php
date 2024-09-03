<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-correos">
        <div class="content container-fluid" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Banco de Correos</h1>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_ingresar_correo">Nuevo correo</button>
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
        <div class="card card-centered mb-3 mb-lg-5">
            <div class="card-body py-3 my-lg-3">
                <div id="correos_registrados" class="table table-striped table-sm table-responsive">
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->
</main>

<script>
    function editar_correo(id_cliente, nombre, direccion, tipo, cliente) {
        $("#modal_editar_correo").modal('toggle');
        $("#idcorreoup").val(id_cliente).change();
        $("#nombreup").val(nombre).change();
        $("#correoup").val(direccion).change();
        $("#tipoup").val(tipo).change();
        $("#clienteup").val(cliente).change();

    }
</script>
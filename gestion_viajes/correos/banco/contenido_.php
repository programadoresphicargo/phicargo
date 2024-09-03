<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">

                            </ol>
                        </div>
                        <h4 class="page-title">Banco de Correos</h4>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div>
            <!-- end page title end breadcrumb -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Listado de correos</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_ingresar_correo">Ingresar nuevo correo</button>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div id="correos_registrados" class="table table-striped table-sm">
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->

        </div><!-- container -->

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
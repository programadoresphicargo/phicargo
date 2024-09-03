<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">

                    <h1 class="page-header-title">Comunicado</h1>

                    <div class="mt-2">
                        <?php if (isset($_GET['id_comunicado'])) { ?>
                            <a class="btn btn-primary btn-sm" id="guardar" href="javascript:;">
                                <i class="bi bi-check2"></i> Guardar
                            </a>
                        <?php } ?>
                        <?php if (!isset($_GET['id_comunicado'])) { ?>
                            <a class="btn btn-success btn-sm" id="publicar" href="javascript:;">
                                <i class="bi bi-check2-all"></i> Publicar
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle me-1" data-bs-toggle="tooltip" data-bs-placement="right" title="Previous product">
                            <i class="bi-arrow-left"></i>
                        </button>
                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Next product">
                            <i class="bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-8">

                <div id="informacion_comunicado">
                </div>

                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">Media</h4>

                        <!-- Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-sm" id="mediaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Add media from URL <i class="bi-chevron-down"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end mt-1">
                                <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#addImageFromURLModal">
                                    <i class="bi-link dropdown-item-icon"></i> Add image from URL
                                </a>
                                <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#embedVideoModal">
                                    <i class="bi-youtube dropdown-item-icon"></i> Embed video
                                </a>
                            </div>
                        </div>
                        <!-- End Dropdown -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">

                        <div id="imagenes"></div>
                        <!-- Dropzone -->
                        <div id="attachFiles" class="js-dropzone dz-dropzone dz-dropzone-card">
                            <div class="dz-message">
                                <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/dots.svg" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/dots.svg" alt="Image Description" data-hs-theme-appearance="dark">

                                <h5>Arrastra y suelta tus imagenes aquí</h5>

                                <p class="mb-2">or</p>

                                <span class="btn btn-white btn-sm">Buscar archivos</span>
                            </div>
                        </div>
                        <!-- End Dropzone -->
                    </div>
                    <!-- Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="js-add-field card mb-3 mb-lg-5">

                    <!-- Add Variants Field -->
                    <table style="display: none;">
                        <tr id="addVariantsTemplate">
                            <td class="table-column-pe-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="productVariationsCheck13">
                                    <label class="form-check-label" for="productVariationsCheck13"></label>
                                </div>
                            </td>
                            <th>
                                <img class="avatar" src="./assets/img/400x400/img2.jpg" alt="Image Description">
                            </th>
                            <th class="table-column-ps-0">
                                <input type="text" class="form-control" style="min-width: 3rem;">
                            </th>
                            <th class="table-column-ps-0">
                                <input type="text" class="form-control" style="min-width: 6rem;">
                            </th>
                            <th class="table-column-ps-0">
                                <div class="input-group input-group-merge" style="min-width: 7rem;">
                                    <div class="input-group-prepend input-group-text">USD</div>
                                    <input type="text" class="form-control">
                                </div>
                            </th>
                            <th class="table-column-ps-0">
                                <!-- Quantity -->
                                <div class="quantity-counter">
                                    <div class="js-quantity-counter-dynamic row align-items-center">
                                        <div class="col">
                                            <input class="js-result form-control form-control-quantity-counter" type="text" value="1">
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-auto">
                                            <a class="js-minus btn btn-white btn-xs btn-icon rounded-circle" href="javascript:;">
                                                <svg width="8" height="2" viewBox="0 0 8 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 1C0 0.723858 0.223858 0.5 0.5 0.5H7.5C7.77614 0.5 8 0.723858 8 1C8 1.27614 7.77614 1.5 7.5 1.5H0.5C0.223858 1.5 0 1.27614 0 1Z" fill="currentColor" />
                                                </svg>
                                            </a>
                                            <a class="js-plus btn btn-white btn-xs btn-icon rounded-circle" href="javascript:;">
                                                <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0C4.27614 0 4.5 0.223858 4.5 0.5V3.5H7.5C7.77614 3.5 8 3.72386 8 4C8 4.27614 7.77614 4.5 7.5 4.5H4.5V7.5C4.5 7.77614 4.27614 8 4 8C3.72386 8 3.5 7.77614 3.5 7.5V4.5H0.5C0.223858 4.5 0 4.27614 0 4C0 3.72386 0.223858 3.5 0.5 3.5H3.5V0.5C3.5 0.223858 3.72386 0 4 0Z" fill="currentColor" />
                                                </svg>
                                            </a>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <!-- End Quantity -->
                            </th>
                            <th class="table-column-ps-0">
                                <div class="btn-group" role="group" aria-label="Edit group">
                                    <a class="btn btn-white" href="#">
                                        <i class="bi-pencil me-1"></i> Edit
                                    </a>
                                    <a class="btn btn-white" href="#">
                                        <i class="bi-trash"></i>
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </table>
                    <!-- End Add Variants Field -->
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-lg-4">
             
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Footer -->
</main>
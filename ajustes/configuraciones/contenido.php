<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Ajustes</h1>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-3">
                <!-- Navbar -->
                <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
                    <!-- Navbar Toggle -->
                    <!-- Navbar Toggle -->
                    <div class="d-grid">
                        <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                            <span class="d-flex justify-content-between align-items-center">
                                <span class="text-dark">Menu</span>

                                <span class="navbar-toggler-default">
                                    <i class="bi-list"></i>
                                </span>

                                <span class="navbar-toggler-toggled">
                                    <i class="bi-x"></i>
                                </span>
                            </span>
                        </button>
                    </div>
                    <!-- End Navbar Toggle -->
                    <!-- End Navbar Toggle -->

                    <!-- Navbar Collapse -->
                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <ul id="navbarSettings" class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical" data-hs-sticky-block-options='{
                     "parentSelector": "#navbarVerticalNavMenu",
                     "targetSelector": "#header",
                     "breakpoint": "lg",
                     "startPoint": "#navbarVerticalNavMenu",
                     "endPoint": "#stickyBlockEndPoint",
                     "stickyOffsetTop": 20
                   }'>
                            <li class="nav-item">
                                <a class="nav-link" href="#OdooSection">
                                    <i class="bi bi-globe nav-icon"></i> Odoo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#OutlookSection">
                                    <i class="nav-icon bi bi-envelope"></i> Outlook
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Navbar Collapse -->
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-lg-9">
                <div class="d-grid gap-3 gap-lg-5">

                    <!-- Card -->
                    <div id="OdooSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Odoo</h4>
                        </div>

                        <?php
                        try {
                            $Datos = file_get_contents('GuardarCredencialesOdooCorreo.json');
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }

                        $decoded_json = json_decode($Datos, true);
                        $json = json_encode($decoded_json);

                        $URL = $decoded_json[0];
                        $USUARIO = $decoded_json[1];
                        $CONTRASENA = $decoded_json[2];
                        $BASEDATOS = $decoded_json[3];

                        ?>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form id='Odoo_correos'>
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">URL</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-globe"></i>
                                            </div>
                                            <input type="text" class="form-control" name="url_correo" value="<?php echo $URL ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Usuario</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" name="usuario_correo" value="<?php echo $USUARIO ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Contraseña</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-key"></i>
                                            </div>
                                            <input type="text" class="form-control" name="contrasena_correo" value="<?php echo $CONTRASENA ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Base de datos</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-database"></i>
                                            </div>
                                            <input type="text" class="form-control" name="basedatos_correo" value="<?php echo $BASEDATOS ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->


                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" id='GuardarCredencialesOdooCorreo'>Guardar</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="OutlookSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Outlook</h4>
                        </div>

                        <?php
                        try {
                            $Datos = file_get_contents('GuardarDatosCorreos.json');
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }

                        $decoded_json = json_decode($Datos, true);
                        $json = json_encode($decoded_json);

                        $HOST = $decoded_json[0];
                        $PORT = $decoded_json[1];
                        $MAIL = $decoded_json[2];
                        $PASSWOORD = $decoded_json[3];
                        $USERREALNAME = $decoded_json[4];

                        ?>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form id='CorreosAutomaticos'>

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Host</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-globe"></i>
                                            </div>
                                            <input type="text" class="form-control" name="MailHost" value="<?php echo $HOST; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Puerto</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-ethernet"></i>
                                            </div>
                                            <input type="text" class="form-control" name="MailPort" value="<?php echo $PORT; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Correo Electronico</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                            <input type="text" class="form-control" name="Mail" value="<?php echo $MAIL; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Contraseña</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi bi-key"></i>
                                            </div>
                                            <input type="text" class="form-control" name="MailPasswoord" value="<?php echo $PASSWOORD; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Nombre de usuario</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend input-group-text" id="inputGroupMergeFullNameAddOn">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" name="NameRealUser" value="<?php echo $USERREALNAME; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <div class="d-flex justify-content-end">
                                    <button id='GuardarCambiosCorreos' type="button" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->
</main>

<script src="./assets/js/demo.js"></script>
<script src="../../assets/js/vendor.min.js"></script>
<script src="../../assets/js/theme.min.js"></script>

<script>
    (function() {
        window.onload = function() {


            // INITIALIZATION OF NAVBAR VERTICAL ASIDE
            // =======================================================
            new HSSideNav('.js-navbar-vertical-aside').init()


            // INITIALIZATION OF FORM SEARCH
            // =======================================================
            new HSFormSearch('.js-form-search')


            // INITIALIZATION OF BOOTSTRAP DROPDOWN
            // =======================================================
            HSBsDropdown.init()


            // INITIALIZATION OF SELECT
            // =======================================================
            HSCore.components.HSTomSelect.init('.js-select')


            // INITIALIZATION OF INPUT MASK
            // =======================================================
            HSCore.components.HSMask.init('.js-input-mask')


            // INITIALIZATION OF FILE ATTACHMENT
            // =======================================================
            new HSFileAttach('.js-file-attach')


            // INITIALIZATION OF STICKY BLOCKS
            // =======================================================
            new HSStickyBlock('.js-sticky-block', {
                targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
            })


            // SCROLLSPY
            // =======================================================
            new bootstrap.ScrollSpy(document.body, {
                target: '#navbarSettings',
                offset: 100
            })

            new HSScrollspy('#navbarVerticalNavMenu', {
                breakpoint: 'lg',
                scrollOffset: -20
            })
        }
    })()
</script>

<!-- Style Switcher JS -->

<script>
    (function() {
        // STYLE SWITCHER
        // =======================================================
        const $dropdownBtn = document.getElementById('selectThemeDropdown') // Dropdowon trigger
        const $variants = document.querySelectorAll(`[aria-labelledby="selectThemeDropdown"] [data-icon]`) // All items of the dropdown

        // Function to set active style in the dorpdown menu and set icon for dropdown trigger
        const setActiveStyle = function() {
            $variants.forEach($item => {
                if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                    $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`
                    return $item.classList.add('active')
                }

                $item.classList.remove('active')
            })
        }

        // Add a click event to all items of the dropdown to set the style
        $variants.forEach(function($item) {
            $item.addEventListener('click', function() {
                HSThemeAppearance.setAppearance($item.getAttribute('data-value'))
            })
        })

        // Call the setActiveStyle on load page
        setActiveStyle()

        // Add event listener on change style to call the setActiveStyle function
        window.addEventListener('on-hs-appearance-change', function() {
            setActiveStyle()
        })
    })()
</script>

<!-- End Style Switcher JS -->
</body>

</html>
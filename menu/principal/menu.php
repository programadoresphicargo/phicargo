<?php
require_once('../../usuarios/codigo/comprobar_permiso.php');
?>

<body>

  <script src="../../assets/js/hs.theme-appearance.js"></script>

  <main id="content" role="main" class="main">
    <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url(../../img/fondo7.svg);">
      <!-- Shape -->
      <div class="shape shape-bottom zi-1">
        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
          <polygon fill="#fff" points="0,273 1921,273 1921,0 " />
        </svg>
      </div>
      <!-- End Shape -->
    </div>

    <!-- Header -->
    <header class="docs-navbar navbar navbar-expand-lg navbar-end navbar-light">
      <div class="container">
        <div class="navbar-nav-wrap">

          <!-- Toggle -->
          <button type="button" class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#navbarNavUserDropdown" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarNavUserDropdown">
            <span class="navbar-toggler-default">
              <i class="bi-list"></i>
            </span>
            <span class="navbar-toggler-toggled">
              <i class="bi-x"></i>
            </span>
          </button>
          <!-- End Toggle -->

          <nav class="navbar-nav-wrap-col collapse navbar-collapse" id="navbarNavUserDropdown">
            <!-- Navbar -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <!-- Account -->
                <div class="dropdown">
                  <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                    <div class="avatar avatar-sm avatar-circle">
                      <img class="avatar-img" src="../../img/auxuser.png" alt="Image Description">
                      <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                    </div>
                  </a>

                  <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
                    <div class="dropdown-item-text">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="../../img/auxuser.png" alt="Image Description">
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h5 class="mb-0"><?php echo $_SESSION['nombre'] ?></h5>
                          <p class="card-text text-body"><?php echo $_SESSION['userTipo'] ?></p>
                        </div>
                      </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">Cerrar sesión</a>
                  </div>
                </div>
                <!-- End Account -->
              </li>
            </ul>
            <!-- End Navbar -->
          </nav>
        </div>
      </div>
    </header>
    <!-- End Header -->

    <!-- Content -->
    <div class="container">
      <a class="d-flex justify-content-center mb-5 animate__animated animate__fadeIn">
        <img class="zi-2" src="../../img/logoacolor.png" alt="Image Description" style="width: 25rem;">
      </a>

      <div class="mx-auto" style="max-width: 20rem;">
        <!-- Footer -->
        <div class="position-relative text-center zi-1">
          <h1 class="mb-4 text-white animate__animated animate__fadeIn">Aplicaciones</h1>
        </div>
        <!-- End Footer -->
      </div>

      <div class="row mx-auto" style="max-width: 80rem;">

        <?php if (comprobar_permiso(8) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <a href="../../turnos/vista/index.php?sucursal=veracruz">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/turnos.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Turnos</h4>
            </div>
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(1) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <?php if (comprobar_permiso(101) == true) { ?>
              <a href="../../gestion_viajes/fletes/index.php">
              <?php } else if (comprobar_permiso(102) == true) { ?>
                <a href="../../gestion_viajes/finalizados/index.php">
                <?php } ?>

                <div class="avatar avatar-xxl bg-light mb-3 p-3">
                  <img class="avatar-img" src="../../img/volante.png" alt="Image Description">
                </div>
                </a>

                <div class="position-relative text-center zi-1">
                  <h4 class="mb-4">Gestión de viajes</h4>
                </div>
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(38) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../maniobras/control/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/c1.png" alt="">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Maniobras</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(40) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../monitoreo/entrega/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/monitor.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Monitoreo</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(128) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <a href="../../reportes/status/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/report.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Reportes</h4>
            </div>
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(39) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../comunicados/listado/index.php">
              <div class="avatar avatar-xxl bg-light mb-1 p-1">
                <img class="avatar-img" src="../../img/comunicados.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Comunicados</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(3) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../bonos/vista/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/money.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Bonos</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(126) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../accesos/acceso_peatonal/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/segurity.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Accesos</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(7) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../operadores/cuentas/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/person.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Operadores</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(5) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../usuarios/usuarios/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/usuarios.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Usuarios</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(5) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../reservas_servicios/usuarios/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/usuarios_clientes.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Usuarios clientes</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(120) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../informe_seguimiento/menu/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/seguimiento.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Reportes</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(127) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <a href="../../ti/reportes_app/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/programador.png" alt="Image Description">
              </div>
            </a>
            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">TI</h4>
            </div>
          </div>
        <?php } ?>

        <?php if (comprobar_permiso(2) == true) { ?>
          <div class="col text-center animate__animated animate__fadeIn m-3">
            <!-- Card -->
            <a href="../../ajustes/configuraciones/index.php">
              <div class="avatar avatar-xxl bg-light mb-3 p-3">
                <img class="avatar-img" src="../../img/settings.png" alt="Image Description">
              </div>
            </a>

            <div class="position-relative text-center zi-1">
              <h4 class="mb-4">Ajustes</h4>
            </div>
            <!-- End Card -->
          </div>
        <?php } ?>


      </div>
    </div>
    <!-- End Content -->
  </main>

</body>

</html>
<?php
require_once('../../includes2/footer.php');

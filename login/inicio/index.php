<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Bienvenido | Phi-Cargo</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../img/philogo-morado.png">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="./assets/css/vendor.min.css">

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="../../assets/css/theme.min.css?v=1.0">
    <link rel="stylesheet" href="../../assets/css/animate.min.css">
    <link rel="stylesheet" href="../../assets/css/notyf.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- ANIMACION NIEVE
    <link rel="stylesheet" href="nieve.css">
    -->

    <link rel="preload" href="./assets/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="./assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
    <script src="../../includes2/footer.php"></script>

</head>

<body>

    <script src="./assets/js/hs.theme-appearance.js"></script>

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main">
        <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url(../../img/imagen.jpg);">
            <!-- Shape -->
            <div class="shape shape-bottom zi-1">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
                    <polygon fill="#fff" points="0,273 1921,273 1921,0 " />
                </svg>
            </div>
            <!-- End Shape -->
        </div>

        <!-- Content -->
        <div class="container py-5 py-sm-7">
            <a class="d-flex justify-content-center mb-5 logo" href="../inicio/index.php">
                <img class="zi-2 animate__animated animate__fadeIn animate__delay-4s" src="../../img/logoacolor.png" alt="Image Description" style="width: 30rem;">
            </a>

            <div class="mx-auto" style="max-width: 30rem;">
                <!-- Card -->
                <div class="card card-lg mb-5 animate__animated animate__backInUp animate__delay-3s">
                    <div class="card-body">
                        <!-- Form -->
                        <form id='InicioSesion' class="js-validate needs-validation" novalidate>
                            <div class="text-center">
                                <div class="mb-5">
                                    <h1 class="display-5">Iniciar Sesión</h1>
                                    <p>Ingresa tus credenciales para iniciar sesión.</a></p>
                                </div>

                                <span class="divider-center text-muted mb-4">Bienvenido</span>
                            </div>

                            <!-- Form -->
                            <div class="mb-4">
                                <label class="form-label" for="signinSrEmail">Usuario</label>
                                <input type="email" class="form-control form-control-lg" id="usuario" name="usuario" tabindex="1" placeholder="Ingresa tu nombre de usuario" required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-4">
                                <label class="form-label w-100" for="signupSrPassword" tabindex="0">
                                    <span class="d-flex justify-content-between align-items-center">
                                        <span>Password</span>
                                        <a class="form-label-link mb-0" href="./authentication-reset-password-basic.html">¿Olvidaste tu contraseña?</a>
                                    </span>
                                </label>

                                <div class="input-group input-group-merge" data-hs-validation-validate-class>
                                    <input type="password" class="js-toggle-password form-control form-control-lg" id="password" name="password" placeholder="Ingresar contraseña" required minlength="8" data-hs-toggle-password-options='{
                           "target": "#changePassTarget",
                           "defaultClass": "bi-eye-slash",
                           "showClass": "bi-eye",
                           "classChangeTarget": "#changePassIcon"
                         }'>
                                    <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                                        <i id="changePassIcon" class="bi-eye"></i>
                                    </a>
                                </div>

                                <span class="invalid-feedback">Please enter a valid password.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form Check -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="termsCheckbox">
                                <label class="form-check-label" for="termsCheckbox">
                                    Recuerdame
                                </label>
                            </div>
                            <!-- End Form Check -->

                            <div class="d-grid">
                                <button type="button" id="IniciarSesion" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
                <!-- End Card -->

                <!-- Footer -->
                <div class="text-center zi-1">
                    <small class="text-cap text-body mb-4 animate__animated animate__fadeIn animate__delay-4s">TECNOLOGÍAS DE LA INFORMACIÓN - PHI-CARGO 2023</small>
                </div>
                <!-- End Footer -->
            </div>
        </div>
        <!-- End Content -->
    </main>

    <div id="snow-container" title="Click anywhere to remove snow">
    </div>

    <div class="intro">
        <div class="intro-text">
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>
            <div class="content">
                <img class="animate__animated animate__bounceIn" src="../../img/logo_1.png" alt="Image Description" style="width: 20rem;">
            </div>
        </div>
    </div>
    <div class="slider text-center">
        <div class="content">
            <img class="animate__animated animate__bounceIn" src="../../img/lp.png" alt="Image Description" style="width: 50rem;">
        </div>
    </div>

    <?php
    require_once('../../includes2/footer.php');
    require_once('funciones.php');
    //require_once('funciones2.php');
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js" integrity="sha512-IQLehpLoVS4fNzl7IfH8Iowfm5+RiMGtHykgZJl9AWMgqx0AmJ6cRWcB+GaGVtIsnC4voMfm8f2vwtY+6oPjpQ==" crossorigin="anonymous"></script>

    <!-- JS Implementing Plugins -->
    <script src="./assets/js/vendor.min.js"></script>
    <script src="../../assets/js/vanilla-tilt.js"></script>
    <script src="../../js/jquery-3.6.1.min.js"></script>
    <script src="../../assets/js/apps.js"></script>

    <script type="text/javascript">
        VanillaTilt.init(document.querySelector(".logo"), {
            max: 25,
            speed: 400
        });

        //It also supports NodeList
        VanillaTilt.init(document.querySelectorAll(".your-element"));
    </script>

</body>

</html>
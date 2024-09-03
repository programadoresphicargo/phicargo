<body id="body" class="auth-page card-bg">
   <!-- Log In page -->
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="card-body p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-5 col-xl-3 col-lg-4">
                            <div class="card mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="text-center p-3">
                                        <a href="../../login/inicio/index.php" class="logo logo-admin">
                                            <img src="../../img/logo-a.png" height="90" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold font-18">Panel Administrador</h4>   
                                        <p class="text-muted  mb-0">Ingresa tus credenciales para ingresar.</p>  
                                    </div>
                                </div><!--end card-body-->
                                <div class="card-body pt-0">                                    
                                    <form id='InicioSesion'>            
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresar username">                               
                                        </div><!--end form-group--> 
            
                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">Password</label>                                            
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Ingresar password">                            
                                        </div><!--end form-group--> 
            
                                        <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox" id="customSwitchSuccess">
                                                    <label class="form-check-label" for="customSwitchSuccess">Recordar</label>
                                                </div>
                                            </div><!--end col--> 
                                            <div class="col-sm-6 text-end">
                                                <a href="auth-recover-pw.html" class="text-muted font-13"><i class="dripicons-lock"></i> ¿Olvidaste la contraseña?</a>                                    
                                            </div><!--end col--> 
                                        </div><!--end form-group--> 
            
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" id="IniciarSesion" type="button">Iniciar sesión <i class="bi bi-box-arrow-in-right"></i></button>
                                                </div>
                                            </div><!--end col--> 
                                        </div> <!--end form-group-->                           
                                    </form><!--end form-->
                                    
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <div class="col-md-7 col-xl-9 col-lg-8  p-0 vh-100 d-flex justify-content-center auth-bg">
                            <div class="accountbg d-flex align-items-center"> 
                                <div class="account-title text-center text-white">
                                    <div class="border w-25 mx-auto border-warning"></div>
                                </div>
                            </div><!--end /div-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
    <!-- vendor js -->
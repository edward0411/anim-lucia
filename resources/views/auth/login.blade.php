<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ANIM | Agencia Nacional Inmobiliaria Virgilio Barco</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="/dist/img/favicon.ico" type="image/vnd.microsoft.icon" id="favicon" />
    <!-- Estilos ANIM -->
    <link rel="stylesheet" href="/dist/css/estilos_anim.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page">

    <div class="login-box">

        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="login-logo">
                        <a href="../../index.html"><img src="/dist/img/anim_logo_anim.png" alt="ANIM Logo"
                                width="180"></a>

                    </div>
                    <!-- /.login-logo -->
                </div>
                <div class="col-lg-3">
                    <div class="login-logo">

                        <a href="../../index.html"><img src="/dist/img/lucia_logo.png" alt="ANIM Logo" width="150"></a>
                    </div>
                    <!-- /.login-logo -->
                </div>

                <div class="col-lg-6 login-forma">
                    <div class="card">
                        <div class="card-body login-card-body">
                            <p class="login-box-msg"><font size="2">Ingrese su correo electrónico y clave para iniciar sesión</font></p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mb-1">
                                    <input type="email" class="form-control form-control form-control-sm mb-0 @error('email') is-invalid @enderror"
                                        placeholder="Correo electrónico" id="email" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-1">
                                    <input id="password" type="password"
                                        class="form-control form-control form-control form-control-sm mb-0  @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Clave">
                                    
                                    <div class="input-group-append">
                                        <button id="show_password" class="btn btn-default btn-xs" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check-label">
                                            <input type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label for="remember">
                                                Recúerdame
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link btn-xs" href="{{ route('password.request') }}">¿Olvidaste tu contaseña?</a>
                                        @endif
                                  </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-sm  float-right"> Ingresar</button>
                                    </div>
                                   
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.login-card-body -->
                    </div><!-- /.card -->
                </div>
                <!--login-forma-->
                <div class="col-lg-12">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg"><font size="2">Para mejorar le experiencia en nuestro sitio asegúrese de usar:</font></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="login-logo">
                        <a href="../../index.html"><img src="/dist/img/logo_gobierno.png" alt="" width="180"></a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="login-logo">
                        <a href="../../index.html"><img src="/dist/img/cromo.png" alt="" width="30">
                            <h6>Google Chrome</h6>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="login-logo">
                        <a href="../../index.html"><img src="/dist/img/mozilla.png" alt="" width="30">
                            <h6>Mozilla Firefox</h6>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="login-logo">
                        <a href="../../index.html"><img src="/dist/img/edge.png" alt="" width="30">
                            <h6>Microsoft Edge</h6>
                        </a>
                    </div>
                </div>
            </div>
            <!--row-->
        </div>
        <!--container-->



    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>

    <script type="text/javascript">
        function mostrarPassword(){
                var cambio = document.getElementById("password");
                if(cambio.type == "password"){
                    cambio.type = "text";
                    $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                }else{
                    cambio.type = "password";
                    $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            } 
            
            $(document).ready(function () {
            //CheckBox mostrar contraseña
            $('#ShowPassword').click(function () {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
    </script>

</body>

</html>

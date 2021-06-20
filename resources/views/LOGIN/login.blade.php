<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> {{ config('application.title') }}</title>
    <meta name="keywords" content="Dental">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.typeahead.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>


<body class="public-layout">
<div class="app-loader main-loader">
    <div class="loader-box">
        <div class="bounceball"></div>
        <div class="text">Medic Dental<span>app</span></div>
    </div>
</div>
<!-- .main-loader -->

<div class="page-box">
    <div class="app-container page-sign-in">
        <div class="content-box">
            <div class="content-header">
                <div class="app-logo">
                    <div class="logo-wrap">
                        <img src="{{ asset('assets/img/logo.png') }}" alt=""  class="logo-img">
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="w-100">
                    <h2 class="h4 mt-0 mb-1">Inicia tu sesion</h2>
                    <p class="text-muted"> Ingresa con los datos de tu cuenta</p>

                    {{ Form::open(['url'=>route('signin'), 'method'=>'post', 'class'=>"needs-validation", 'novalidate'=>'']) }}
                        @include('LOGIN.errors')
                        <div class="form-group">
                            <input name="email" class="form-control" type="email" placeholder="Correo electrónico" required>
                            <div class="invalid-feedback">Por favor escribe tu correo.</div>
                        </div>

                        <div class="form-group">
                            <input name="password" class="form-control" type="password" placeholder="Contraseña" maxlength="20" required>
                            <div class="invalid-feedback">Por favor escribe tu contraseña.</div>
                        </div>

                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="remember-me" name="rememberme" checked>
                            <label class="custom-control-label" for="remember-me">Mantenerme conectado</label>
                        </div>

                        <div class="actions justify-content-between">
                            <button class="btn btn-primary">
                                <span class="btn-icon icofont-login mr-2"></span>Iniciar sesión
                            </button>
                        </div>
                    {{ Form::close() }}

                    <p class="mt-5 mb-1"><a href="#">¿Olvidaste tu contraseña?</a></p>
                    <p>Aun no tienes cuenta? <a href="{{ route('signup') }}">Registrate!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-migrate-1.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.typeahead.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
<script src="{{ asset('assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/raphael-min.js') }}"></script>
<script src="{{ asset('assets/js/morris.min.js') }}"></script>
<script src="{{ asset('assets/js/echarts.min.js') }}"></script>
<script src="{{ asset('assets/js/echarts-gl.min.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>


</body>
</html>

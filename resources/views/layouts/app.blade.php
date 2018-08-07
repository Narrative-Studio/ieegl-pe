<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>STARTUPS ID</title>
    <link rel="apple-touch-icon" href="{{url("/")}}/img/icon_sid.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url("/")}}/img/icon_sid.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/pages/login-register.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/forms/checkboxes-radios.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/pages/gallery.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/css/custom.min.css">
    <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 1-column  bg-cyan bg-lighten-2 menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="1-column" style="background-color: #8ccfc8 !important;">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-sm navbar navbar-with-menu fixed-top navbar-dark navbar-shadow navbar-border">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="navbar-brand" href="{{url("/")}}">
                        <img class="brand-logo" alt="robust admin logo" src="{{url("/")}}/img/logo_SID.png" style="width: auto;height: 34px;">
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container">
            <div id="navbar-mobile5" class="collapse navbar-collapse">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("/")}}" role="button" aria-haspopup="true" aria-expanded="false"><!--<i class="fa fa-bell-o"></i>--> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{action("HomeController@Acerca")}}" role="button" aria-haspopup="true" aria-expanded="false">Acerca de</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{action("HomeController@Porque")}}" role="button" aria-haspopup="true" aria-expanded="false">¿Por qué Registrarme?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("/")}}" role="button" aria-haspopup="true" aria-expanded="false">Eventos de Emprendimiento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("/")}}" role="button" aria-haspopup="true" aria-expanded="false">Preguntas Frecuentes</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("login")}}" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa ft-unlock"></i> Acceso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("register")}}" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil-square-o "></i> Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

@yield('content')

<!-- ////////////////////////////////////////////////////////////////////////////-->
<footer class="footer fixed-bottom footer-dark navbar-border">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">
            <a href="{{action("HomeController@Aviso")}}">Aviso de Privacidad</a> |
            <a href="{{action("HomeController@Terminos")}}">Términos y Condiciones</a>
        </span>
        <span class="float-md-right d-block d-md-inline-block">
            &copy; Tecnológico de Monterrey {{date('Y')}}, All rights reserved.
        </span>
    </p>
</footer>
<!-- BEGIN VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>

<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="{{url("/")}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/core/app.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/customizer.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{url("/")}}/app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/forms/checkbox-radio.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>
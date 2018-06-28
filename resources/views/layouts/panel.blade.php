<!DOCTYPE html>
<html class="loading" lang="es"  data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="+">
    <title>Panel SID</title>
    <link rel="apple-touch-icon" href="{{url("/")}}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url("/")}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/forms/checkboxes-radios.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/forms/extended/form-extended.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/meteocons/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/css/custom.min.css">
    <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="navbar-brand" href="{{action("PanelController@Index")}}">
                        <img class="brand-logo" alt="" src="{{url("/")}}/img/logo_SID.png" style="width: auto;height: 44px;">
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online">
                                @if(file_exists(public_path('/users_pics/user_'. auth()->user()->_key .'.jpg')))
                                    <img src="{{url('/users_pics/user_'. auth()->user()->_key .'.jpg')}}" alt="avatar">
                                @else
                                    <img src="{{url("/")}}/app-assets/images/avatar.jpg" alt="avatar">
                                @endif
                            </span>
                            <span class="user-name">{{auth()->user()->nombre}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{action('PanelPerfiles@Index')}}"><i class="ft-user"></i> Editar Perfil</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('logout')}}"><i class="ft-power"></i> Salir</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{action("PanelController@Index")}}"><i class="icon-home"></i><span class="menu-title">Dashboard</span></a></li>
            <hr/>
            <li class=" nav-item"><a href="#"><i class="ft-user"></i><span class="menu-title">Mi Perfil</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{action('PanelPerfiles@Cuenta')}}">Mi Cuenta</a></li>
                    <li><a class="menu-item" href="{{action('PanelPerfiles@Index')}}">Datos Personales</a></li>
                    <li><a class="menu-item" href="{{action('PanelPerfiles@Estudios')}}">Estudios</a></li>
                    <li><a class="menu-item" href="#">Identidad</a></li>
                </ul>
            </li>
            <li class=" navigation-header">
                <span data-i18n="nav.category.layouts">Mis Emprendimientos</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <li class=" nav-item"><a href="#"><i class="ft-list"></i><span class="menu-title">Lista</span></a></li>
            <li class=" nav-item"><a href="#"><i class="icon-plus"></i><span class="menu-title">Agregar Emprendimiento</span></a></li>

            <li class=" navigation-header">
                <span data-i18n="nav.category.general">Mi Actividad</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
            </li>
            <li class=" nav-item"><a href="#"><i class="ft-list"></i><span class="menu-title">Lista</span></a></li>
            <li class=" nav-item"><a href="#"><i class="icon-plus"></i><span class="menu-title">Agregar Actividad</span></a></li>
            <hr/>
            <li class=" nav-item"><a href="{{route('logout')}}"><i class="icon-logout"></i><span class="menu-title">Salir</span></a></li>
        </ul>
    </div>
</div>
<div class="app-content content">
    @yield('content')
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">Copyright &copy; {{date('Y')}} <a class="text-bold-800 grey darken-2" href="#" target="_blank">Tecnológico de Monterrey </a>, All rights reserved. </span>
    </p>
</footer>
<!-- BEGIN VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/extensions/moment.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="{{url("/")}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/core/app.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/forms/checkbox-radio.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js" type="text/javascript"></script>
<script src="{{url("/")}}/js/custom.min.js" type="text/javascript"></script>
@yield('js')
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
</body>
</html>
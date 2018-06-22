<!DOCTYPE html>
<html class="loading" lang="es"  data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="+">
    <title>Administrador SID</title>
    <link rel="apple-touch-icon" href="{{url("/")}}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url("/")}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/weather-icons/climacons.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/meteocons/style.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/assets/css/style.css">
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
                    <a class="navbar-brand" href="{{action("AdminController@Index")}}">
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
                        <a class="nav-link" href="#">
                            Hola {{auth()->user()->nombre}}!
                        </a>
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
            <li class=" nav-item"><a href="{{action("AdminController@Index")}}"><i class="icon-home"></i><span class="menu-title">Dashboard</span></a></li>
            <li class=" navigation-header">
                <span>Usuarios</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title">Usuarios</span></a></li>
            <li class=" nav-item"><a href="#"><i class="ft-user-plus"></i><span class="menu-title">Administradores</span></a></li>
            <li class=" nav-item"><a href="#"><i class="ft-shield"></i><span class="menu-title">Roles</span></a></li>
            <li class=" navigation-header">
                <span>Catálogos</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <li class=" nav-item"><a href="#"><i class="fa fa-comments"></i><span class="menu-title">Convocatorias TEC</span></a></li>
            <li class=" nav-item"><a href="#"><i class="fa fa-graduation-cap"></i><span class="menu-title">Universidades</span></a></li>
            <li class=" nav-item"><a href="#"><i class="fa fa-building"></i><span class="menu-title">Industrias y Sectores</span></a></li>
            <li class=" nav-item"><a href="#"><i class="fa fa-seedling"></i><span class="menu-title">Etapas Emprendimientos</span></a></li>
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
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/charts/raphael-min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/charts/morris.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/moment.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/underscore-min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/clndr.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="{{url("/")}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/core/app.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/customizer.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{url("/")}}/app-assets/js/scripts/pages/dashboard-ecommerce.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>
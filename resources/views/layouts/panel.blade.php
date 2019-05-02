<!DOCTYPE html>
<html class="loading" lang="es"  data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>STARTUP IDENTIFICATION</title>
    <link rel="apple-touch-icon" href="{{url("/")}}/img/icon_sid.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url("/")}}/img/icon_sid.png">
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
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/extensions/zoom.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-callout.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/menu/menu-types/vertical-content-menu.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-gradient.css">
    <!--<link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/menu/menu-types/vertical-menu.css">-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/meteocons/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/css/custom.min.css">
    <!-- END Custom CSS-->
    @yield('css')
    <!-- BEGIN VENDOR JS-->
    <script src="{{url("/")}}/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
</head>
<body class="vertical-layout vertical-content-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-content-menu" data-col="2-columns">
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-hide-on-scroll navbar-border navbar-shadow navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="{{action("PanelController@Index")}}"><img class="height-50" alt="robust admin logo" src="{{url("/")}}/img/logo_SID.png">
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu">         </i></a></li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col col-12 mb-2">
                    @yield('breadcrumb')
                </div>
            </div>

            <div class="main-menu menu-static menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
                <div class="main-menu-content">
                    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                        <li class=" nav-item">
                            <a href="{{action("PanelController@Index")}}"><i class="icon-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a>
                        </li>
                        <li class=" navigation-header">
                            <span data-i18n="nav.category.layouts">Mi Información</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
                        </li>
                        <li class=" nav-item">
                            <a href="{{action('PanelPerfiles@Cuenta')}}"><i class="icon-user"></i><span class="menu-title" data-i18n="nav.users.main">Mi Cuenta</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{action('PanelPerfiles@Index')}}"><i class="icon-note"></i><span class="menu-title" data-i18n="nav.users.main">Perfil</span></a>
                        </li>
                        <li class=" nav-item">
                            <a href="{{action('PanelEmprendimientos@Index')}}"><i class="icon-layers"></i><span class="menu-title" data-i18n="nav.page_layouts.main">Emprendimientos</span></a>
                        </li>
                        <li class=" navigation-header">
                            <span data-i18n="nav.category.pages">Convocatorias</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Pages"></i>
                        </li>
                        <li class=" nav-item">
                            <a href="{{action('PanelConvocatorias@Index')}}"><i class="icon-grid"></i><span class="menu-title" data-i18n="nav.project.project_summary">Convocatorias</span></a>
                        </li>
                        <li class=" nav-item">
                            <a href="{{action('PanelConvocatorias@Aplicaciones')}}"><i class="icon-check"></i><span class="menu-title" data-i18n="nav.scrumboard.main">Mis Aplicaciones</span></a>
                        </li>
                        <li class=" navigation-header">
                            <span data-i18n="nav.category.pages"></span>
                        </li>
                        <li class=" nav-item">
                            <a href="{{route('logout')}}"><i class="icon-logout"></i><span class="menu-title">Salir</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="content-body">
                @include('layouts.mensajes')
                @yield('content')
            </div>
            <!-- ////////////////////////////////////////////////////////////////////////////-->
        </div>
    </div>
<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">Copyright &copy; {{date('Y')}} <a class="text-bold-800 grey darken-2" href="#" target="_blank">Tecnológico de Monterrey </a>, All rights reserved. </span>
    </p>
</footer>

<!-- BEGIN VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/select/select2-es.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"  type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/moment.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/transition.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/zoom.min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->

    <script src="{{url("/")}}/app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/ui/headroom.min.js"></script>

<!-- BEGIN ROBUST JS-->
<script src="{{url("/")}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/core/app.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/forms/checkbox-radio.js" type="text/javascript"></script>

<script src="{{url("/")}}/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>

<script src="{{url("/")}}/js/custom.min.js" type="text/javascript"></script>
@yield('js')
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
</body>
</html>
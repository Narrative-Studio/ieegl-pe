<!DOCTYPE html>
<html class="loading" lang="es"  data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="+">
    <title>Administrador STARTUP IDENTIFICATION</title>
    <link rel="apple-touch-icon" href="{{url("/")}}/img/icon_sid.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url("/")}}/img/icon_sid.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/toggle/switchery.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/forms/checkboxes-radios.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/forms/extended/form-extended.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/extensions/zoom.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/vendors/css/editors/tinymce/tinymce.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/meteocons/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/plugins/forms/switch.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/core/colors/palette-switch.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/js/bootstrap-table/bootstrap-table.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

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
                <li class="nav-item" style="width: 100%;">
                    <a class="navbar-brand" href="{{action("AdminController@Index")}}" style="width: 100%;">
                        <img class="brand-logo" alt="" src="{{url("/")}}/img/logo_SID.png" style="width: auto;height: 54px;margin-left: auto;margin-right: auto;margin-top: -8px;">
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
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('usuarios')):?>
                <li class=" navigation-header">
                    <span>Usuarios</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
                </li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('usuarios')):?>
                <li class=" nav-item"><a href="{{action('AdminUsuarios@Index')}}"><i class="ft-users"></i><span class="menu-title">Usuarios</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('administradores')):?>
                <li class=" nav-item"><a href="{{action('AdminAdministradores@Index')}}"><i class="ft-user-plus"></i><span class="menu-title">Administradores</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('roles')):?>
                <li class=" nav-item"><a href="{{action('\App\Http\Controllers\AdminRoles@Index')}}"><i class="ft-shield"></i><span class="menu-title">Roles</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('solicitudes')):?>
                <li class=" navigation-header">
                    <span>Convocatorias</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
                </li>
                <li class=" nav-item"><a href="{{action('AdminSolicitudes@Index')}}"><i class="fa fa-check"></i><span class="menu-title">Solicitudes</span></a></li>
            <?php endif;?>

            <li class=" navigation-header">
                <span>Catálogos</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('convocatorias')):?>
                <li class=" nav-item"><a href="{{action('AdminConvocatorias@Index')}}"><i class="fa fa-comments"></i><span class="menu-title">Convocatorias</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('universidades')):?>
                <li class=" nav-item"><a href="{{action('AdminUniversidades@Index')}}"><i class="fa fa-graduation-cap"></i><span class="menu-title">Universidades</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('industrias_y_sectores')):?>
                <li class=" nav-item"><a href="{{action("AdminIndustrias@Index")}}"><i class="fa fa-building"></i><span class="menu-title">Industrias y Sectores</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('etapas_emprendimientos')):?>
                <li class=" nav-item"><a href="{{action("AdminEtapas@Index")}}"><i class="fa fa-seedling"></i><span class="menu-title">Etapas Emprendimientos</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('terminos_capital')):?>
                <li class=" nav-item"><a href="{{action("AdminTerminos@Index")}}"><i class="fa fa-seedling"></i><span class="menu-title">Términos Capital</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('entidades')):?>
                <li class=" nav-item"><a href="{{action("AdminEntidades@Index")}}"><i class="fa fa-globe"></i><span class="menu-title">Entidades</span></a></li>
            <?php endif;?>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('quien_aplica')):?>
                <li class=" nav-item"><a href="{{action("AdminQuien@Index")}}"><i class="fa fa-address-card"></i><span class="menu-title">Quien Aplica</span></a></li>
            <?php endif;?>

            <li class=" navigation-header">
                <span>Reportes</span><i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Reportes"></i>
            </li>
            <?php if(\App\Http\Controllers\AdminRoles::getAccess('reportes')):?>
            <li class=" nav-item"><a href="{{action('AdminReportes@UsuariosEmprendimientos')}}"><i class="fa fa-pie-chart"></i><span class="menu-title">Usuarios sin emprendimientos</span></a></li>
            <?php endif;?>

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

<!-- MESSAGE BOX-->
<div class="modal fade text-left" id="danger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h4 class="modal-title white" id="myModalLabel10">Eliminar Registro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar permanentemente el registro?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger mb-control-yes" data-dismiss="modal">Si, eliminarlo</button>
                <button class="btn grey btn-outline-secondary"  data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->


<!-- BEGIN VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/select/select2-es.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/moment.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/extensions/zoom.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/editors/tinymce/tinymce.js" type="text/javascript"></script>
<script src="//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="{{url("/")}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/core/app.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/customizer.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/forms/switch.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/forms/checkbox-radio.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/scripts/editors/editor-tinymce.js" type="text/javascript"></script>
<script src="{{url("/")}}/js/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/js/bootstrap-table/locale/bootstrap-table-es-MX.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/js/bootstrap-table/extensions/export/bootstrap-table-export.js" type="text/javascript"></script>
<script src="{{url("/")}}/js/custom.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->
<script>
    function delete_row(row,url){
        $('#danger').modal('show')
        $('#danger').find(".mb-control-yes").on("click",function(){
            window.location.href=url;
        });
    }
</script>
@yield('js')
@yield('modal')
</body>
</html>
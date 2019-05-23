<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>REGISTRO</title>
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
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/css/custom.min.css">
    <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
      data-open="click" data-menu="vertical-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-6 col-12 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <div class="card-header border-0 pb-0">
                                <div class="card-title text-center">
                                    <img class="height-100" src="{{url("/")}}/img/logo_SID.png" alt="">
                                </div>
                            </div>
                            <div class="card-content">

                                <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>Crear cuenta de Emprendedor</span></p>
                                <div class="card-body">
                                    @if(session('error'))
                                        <div class="alert bg-danger alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            Lo sentimos pero el correo electrónico ya fue registrado anteriormente.
                                        </div>
                                    @endif
                                    {!! Form::open(['action' => 'HomeController@RegisterSave', 'method' => 'put']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre">Nombre <span class="required">*</span></label>
                                                    <input type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{old('nombre')}}" name="nombre" id="nombre">
                                                    @if ($errors->has('nombre'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('nombre') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="apellidos">Apellidos <span class="required">*</span></label>
                                                    <input type="text" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" value="{{old('apellidos')}}" name="apellidos" id="apellidos">
                                                    @if ($errors->has('apellidos'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('apellidos') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="telefono">Celular (10 dígitos) <span class="required">*</span></label>
                                                    <input type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" value="{{old('telefono')}}" name="telefono" id="telefono">
                                                    @if ($errors->has('telefono'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('telefono') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Correo Electrónico <span class="required">*</span></label>
                                                    <input class="form-control{{ ($errors->has('email') || session('error')) ? ' is-invalid' : '' }}" type="email" value="{{old('email')}}"  name="email" id="email">
                                                    @if ($errors->has('email') || session('error'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email_confirmation">Confirma Correo Electrónico <span class="required">*</span></label>
                                                    <input class="form-control{{ ($errors->has('email') || session('error')) ? ' is-invalid' : '' }}" type="email" value="{{old('email_confirmation')}}"  name="email_confirmation" id="email_confirmation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Contraseña <span class="required">*</span></label>
                                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"  name="password" id="password">
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirma Contraseña <span class="required">*</span></label>
                                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" id="password-_confirmation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row skin skin-flat">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <table>
                                                        <tr>
                                                            <td valign="top">
                                                                <input type="checkbox" name="terminos_y_condiciones" value="1" @if(old('terminos_y_condiciones')==1) checked @endif>
                                                            </td>
                                                            <td valign="top">
                                                                He leído los <a href="{{action("HomeController@Terminos")}}" target="_blank">Términos y Condiciones de Uso</a> y la <a href="{{action("HomeController@Aviso")}}" target="_blank">Política de Privacidad</a>
                                                                y dar de mi conocimiento para que Startup Identification utilice mi información por motivos y Eventos relacionados al Emprendimiento.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    @if ($errors->has('terminos_y_condiciones'))
                                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                                <strong>{{ $errors->first('terminos_y_condiciones') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div>
                                                    {!! Recaptcha::render([ 'lang' => 'es' ]) !!}
                                                </div>
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="invalid-feedback" role="alert"  style="display: block;">
                                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <button type="button" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-check-square-o"></i> Registrarse
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- BEGIN VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{url("/")}}/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
        type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="{{url("/")}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url("/")}}/app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
</body>
</html>
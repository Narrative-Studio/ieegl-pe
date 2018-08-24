@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-12 col-12 mb-2 text-center">
                <h3 class="content-header-title">Crear cuenta de Emprendedor</h3>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        <p>Por favor llena este formato para iniciar tu proceso de Registro en el Sistema Startups ID.</p>
                                    </div>
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
                                            <h4 class="form-section"><i class="ft-user"></i> Tus datos</h4>
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
            <!-- // Basic form layout section end -->
        </div>
    </div>
</div>
@endsection

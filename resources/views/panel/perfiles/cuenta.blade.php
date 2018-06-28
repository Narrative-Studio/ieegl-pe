@extends('layouts.panel')

@section('titulo') Perfil @endsection
@section('seccion') Perfil @endsection
@section('accion') Mi Cuenta @endsection

@section('js')
@endsection

@section('content')
        <div class="content-wrapper">
            @include('layouts.breadcrum')
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @if(session('error'))
                                            <div class="alert bg-danger alert-dismissible mb-2" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                Lo sentimos pero el correo electrónico ya fue registrado anteriormente.
                                            </div>
                                        @endif
                                        {!! Form::model($item,['action' => 'PanelPerfiles@SaveCuenta', 'method' => 'post']) !!}
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-user"></i> Tus datos</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre <span class="required">*</span></label>
                                                        <?php $class=($errors->has('nombre'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::text('nombre', null, ['class'=>$class]); !!}
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
                                                        <?php $class=($errors->has('apellidos'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::text('apellidos', null, ['class'=>$class]); !!}
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
                                                        <label for="telefono">Celular (10 dígitos)</label>
                                                        <?php $class=($errors->has('telefono'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::text('telefono', null, ['class'=>$class]); !!}
                                                        @if ($errors->has('telefono'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('telefono') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card-text">
                                                        <p><strong>Si desea cambiar su contraseña llene los siguientes campos:</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Contraseña</label>
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
                                                        <label for="password_confirmation">Confirma Contraseña</label>
                                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" id="password-_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="form-actions right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Guardar Datos
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
@endsection
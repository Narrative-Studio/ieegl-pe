@extends('layouts.panel')

@section('titulo') Perfil @endsection
@section('seccion') Perfil @endsection
@section('accion') Mi Cuenta @endsection

@section('breadcrumb')
    <h3 class="content-header-title">MI CUENTA</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action('PanelController@Index')}}">Inicio</a></li>
                <li class="breadcrumb-item">Mi Cuenta</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<!-- Basic form layout section start -->
<section id="basic-form-layouts">
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::model($item,['action' => 'PanelPerfiles@SaveCuenta', 'method' => 'post']) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="required">*</span></label>
                                        <?php $class=($errors->has('nombre'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.nombre', ['campo'=>'nombre','value'=>(isset($item->nombre))?$item->nombre:''])
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
                                        @include('panel.perfiles.campos.apellidos', ['campo'=>'apellidos','value'=>(isset($item->apellidos))?$item->apellidos:''])
                                        @if ($errors->has('apellidos'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('apellidos') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Correo Electrónico</label>
                                        @include('panel.perfiles.campos.email', ['campo'=>'email','value'=>(isset($item->email))?$item->email:''])
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Celular (10 dígitos)</label>
                                        <?php $class=($errors->has('telefono'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.telefono', ['campo'=>'telefono','value'=>(isset($item->telefono))?$item->telefono:''])
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
</div>
</section>
@endsection
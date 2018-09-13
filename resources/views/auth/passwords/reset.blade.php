@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>

            @if($error==0)
                <div class="content-body">
                    <section class="flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-md-4 col-10 box-shadow-2 p-0">
                                <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                    <div class="card-header border-0 pb-0">
                                        <div class="card-title text-center">
                                            <img src="{{url("/")}}/img/logo_SID.png" alt="branding logo" style="height: 60px;">
                                        </div>
                                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                            <span></span>
                                        </h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body pt-0">
                                        @if(!isset($correcto))
                                            <form method="POST" action="{{ action('HomeController@PasswordRecoveryUpdate') }}" aria-label="{{ __('Reset Password') }}">
                                                @csrf
                                                <p style="font-weight: bold;">Proporciona una nueva contraseña para tu cuenta.</p>
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="user-name">Nueva Contraseña</label>
                                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </fieldset>
                                                <fieldset class="form-group floating-label-form-group mb-1">
                                                    <label for="user-password">Repetir Contraseña</label>
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                                </fieldset>
                                                <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> Actualizar Contraseña</button>

                                            </form>
                                            @else
                                                <p class="text-center pt-1 pb-2">Has actualizado tu contraseña para tu cuenta.</p>
                                                <a href="{{route("login")}}" class="btn btn-primary btn-block btn-lg" style="color:#fff;"><i class="ft-unlock"></i> Entrar</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @else
                <div class="content-body">
                    <div class="row justify-content-md-center">
                        <div class="col-xl-6 col-lg-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-dislike font-large-5 mt-2"></i>
                                    <h2 class="mt-3">¡Lo sentimos!</h2>
                                    <p class="mt-3">El token es inválido, vuelve a generarlo.</p>
                                    <hr/>
                                    <div class="form-actions center">
                                        <a href="{{route("recover")}}" class="btn btn-primary btn-min-width mr-1 mb-1"><i class="fa fa-angle-left"></i> Recuperar Contraseña</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

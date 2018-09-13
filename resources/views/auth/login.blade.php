@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>

        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <img src="{{url("/")}}/img/logo_SID.png" alt="branding logo" style="height: 60px;">
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                    <span>Entrar a STARTUPS ID</span>
                                </h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if(session('error_validado'))
                                        <div class="alert bg-danger alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            Aún no confirmas tu correo electrónico, si no lo ves en tu bandeja de entrada revisa en correos no deseados.
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" class="form-horizontal" novalidate>
                                        @csrf
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control input-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="email" placeholder="Correo Electrónico" name="email" tabindex="1" required data-validation-required-message="Pro favor proporciona tu correo electónico.">
                                            <div class="form-control-position">
                                                <i class="ft-mail"></i>
                                            </div>
                                            <div class="help-block font-small-3"></div>
                                            @if ($errors->has('email'))
                                                <div class="help-block font-small-3">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            @endif
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="password" class="form-control input-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Contraseña" tabindex="2" required data-validation-required-message="Por favor porporciona tu contraseña.">
                                            <div class="form-control-position">
                                                <i class="ft ft-lock"></i>
                                            </div>
                                            <div class="help-block font-small-3"></div>
                                            @if ($errors->has('password'))
                                                <div class="help-block font-small-3">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </div>

                                            @endif
                                        </fieldset>
                                        <div class="form-group row">
                                            <div class="col-md-12 col-12 text-right"><a href="{{route('recover')}}" class="card-link">¿Olvidaste tu contraseña?</a></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="ft-unlock"></i> Entrar</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer border-0">
                                <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                    <span>¿No tienes una cuenta?</span>
                                </p>
                                <a href="{{route('register')}}" class="btn btn-info btn-block btn-lg mt-3"><i class="ft-user"></i> Crea una cuenta</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
</div>
@endsection
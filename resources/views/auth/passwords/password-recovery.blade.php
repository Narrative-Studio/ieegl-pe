@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
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
                                    <div class="card-body">
                                        @if(!isset($send))
                                            <form method="POST" action="{{ route('recover-password') }}" class="form-horizontal">
                                                @csrf
                                                <fieldset class="form-group position-relative has-icon-left">

                                                    <input id="email" type="email" class="form-control form-control-lg input-lg {{ (session('error_recover')) ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required>
                                                    <div class="form-control-position">
                                                        <i class="ft-mail"></i>
                                                    </div>
                                                    @if (session('error_recover'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>El correo electrónico no fué encontrado en nuestros registros.</strong>
                                                        </span>
                                                    @endif
                                                </fieldset>
                                                <button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Recuperar Contraseña</button>
                                            </form>
                                        @else
                                            <p class="text-center pt-3">Te hemos enviado los pasos a seguir al correo electrónico que proporcionaste, revisa tu correo.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
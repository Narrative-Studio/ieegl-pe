@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"></div>

            <div class="content-body">
                <div class="row justify-content-md-center">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            @if($error==0)
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <i class="icon-like font-large-5 mt-2"></i>
                                    <h2 class="mt-3">¡Tu cuenta ha sido validada!</h2>
                                    <p class="mt-3">Bienvenido <b>{{$nombre}}</b> a Startup Identification,<br/>entra con tu email y contraseña para completar tu Perfil de Usuario.</p>
                                    <hr/>
                                    <div class="form-actions center">
                                        <a href="{{route("login")}}" class="btn btn-success btn-min-width mr-1 mb-1"><i class="fa ft-unlock"></i> Entrar</a>
                                    </div>
                                </div>
                            @else
                                <div class="card-body text-center">
                                    <i class="icon-dislike font-large-5 mt-2"></i>
                                    <h2 class="mt-3">¡Lo sentimos!</h2>
                                    <p class="mt-3">No podemos validar tu cuenta por que el link es inválido o tu cuenta no existe.</p>
                                    <hr/>
                                    <div class="form-actions center">
                                        <a href="{{url("/")}}" class="btn btn-primary btn-min-width mr-1 mb-1"><i class="fa fa-angle-left"></i> Salir</a>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
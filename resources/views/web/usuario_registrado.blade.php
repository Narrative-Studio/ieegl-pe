@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"></div>

            <div class="content-body">
                <div class="row justify-content-md-center">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body text-center">
                                    <i class="icon-envelope-letter font-large-5 mt-2"></i>
                                    <h2 class="mt-3">¡Solo falta un paso!</h2>
                                    <p>Gracias <b>{{$nombre}}</b> por crear tu cuenta.</p>
                                    <p class="mt-3">Recibirás un correo electrónico para confirmar tu cuenta <br/> para continuar el proceso de registro en Startup Identification</p>
                                    <hr/>
                                    <div class="form-actions center">
                                        <a href="{{url("/")}}" class="btn btn-primary btn-min-width mr-1 mb-1"><i class="fa fa-angle-left"></i> Terminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
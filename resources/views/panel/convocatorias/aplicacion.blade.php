@extends('layouts.panel')

@section('titulo') Listado de Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Aplicación @endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body text-center">
                                @if($puede_aplicar)
                                    <h2>{{$item->nombre}}</h2>
                                    <div class="mt-2">
                                        <i class="icon-check success font-large-5"></i>
                                    </div>
                                    <div class="card-text mt-2">
                                        @if($emprendimiento==false)
                                            <p>Gracias <strong>{{auth()->user()->nombre}} {{auth()->user()->apellidos}}</strong> por aplicar a la convocatoria.</p>
                                        @else
                                            <p>Gracias <strong>{{auth()->user()->nombre}} {{auth()->user()->apellidos}}</strong> por aplicar tu emprendimiento <strong>"{{$emprendimiento->nombre}}"</strong> a la convocatoria.</p>
                                        @endif
                                        <p class="mt-1">Estaremos analizando tu solicitud y en breve te daremos una respuesta.</p>
                                    </div>
                                @else
                                    <div class="alert round bg-warning alert-icon-right alert-dismissible text-center" role="alert">
                                        <span class="alert-icon"><i class="fa fa-info-circle"></i></span>
                                        No podemos hacer la aplicación.
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



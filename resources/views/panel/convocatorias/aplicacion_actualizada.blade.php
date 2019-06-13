@extends('layouts.panel')

@section('titulo') Listado de Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Aplicación @endsection

@section('breadcrumb')
    <h3 class="content-header-title">CONVOCATORIAS</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{action("PanelConvocatorias@Index")}}">Convocatorias</a></li>
                <li class="breadcrumb-item"><a href="{{action("PanelConvocatorias@Ver", $item->_key)}}">{{$item->nombre}}</a></li>
                <li class="breadcrumb-item active">Aplicación Actualizada</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        @if($actualizada)
                            <div class="text-center">
                                <h2>{{$item->nombre}}</h2>
                                <div class="mt-2">
                                    <i class="icon-check success font-large-5"></i>
                                </div>
                                <div class="card-text mt-2">
                                    <p>Tu aplicación para la convocatoria {{$item->nombre}} ha sido actualizada.</p>
                                    <p class="mt-1">Te informaremos sobre tu evaluación muy pronto.</p>
                                </div>
                            </div>
                        @else
                            <h2>Lo sentimos</h2>
                            <h5>No puedes actualizar la apliación por que esta Aprobada o Cancelada.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



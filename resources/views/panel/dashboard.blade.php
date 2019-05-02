@extends('layouts.panel')

@section('titulo') Dashboard @endsection
@section('seccion') Panel de Usuario @endsection
@section('accion') Dashboard @endsection

@section('breadcrumb')
    <h3 class="content-header-title">DASHBOARD</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title pull-left">Mis Emprendimientos</h4>
                        <a href="{{action('PanelEmprendimientos@DatosGenerales')}}" class="btn btn-primary pull-right white"><i class="icon-plus"></i> Agregar Emprendimiento</a>
                    </div>
                    <div class="card-content collapse show">
                        @include('panel.inc.emprendimientos-table')
                    </div>
                </div>
            </div>
        </div>
@endsection

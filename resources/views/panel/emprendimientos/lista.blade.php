@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Mis Emprendimientos @endsection

@section('breadcrumb')
    <h3 class="content-header-title">MIS EMPRENDIMIENTOS</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action('PanelController@Index')}}">Inicio</a></li>
                <li class="breadcrumb-item active">Emprendimientos</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @include('panel.inc.emprendimientos-table')
@endsection

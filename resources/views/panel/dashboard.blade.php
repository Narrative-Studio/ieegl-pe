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
    @include('panel.inc.emprendimientos-table')
@endsection

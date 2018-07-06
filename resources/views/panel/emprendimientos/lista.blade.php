@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Mis Emprendimientos @endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Listado de Emprendimientos</h4>
                        </div>
                        <div class="card-content collapse show">
                            @include('panel.inc.emprendimientos-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

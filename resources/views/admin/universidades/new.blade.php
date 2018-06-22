@extends('layouts.admin')

@section('titulo') Nueva Universidad @endsection
@section('seccion') Universidades @endsection
@section('accion') Nuevo @endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                {!! Form::open(['action' => ['AdminUniversidades@Save'], 'method'=>'PUT', 'class'=>'form-horizontal', 'files' => false]) !!}
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Datos de la Universidad</strong></h3>
                                    </div>
                                    <div class="panel-body form-group-separated">
                                        @include('admin.universidades.partial')
                                    </div>
                                    <div class="panel-footer">
                                        <a href="{{ action('AdminUniversidades@Index') }}" class="btn btn-default">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
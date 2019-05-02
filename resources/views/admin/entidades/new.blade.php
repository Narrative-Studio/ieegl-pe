@extends('layouts.admin')

@section('titulo') Nueva Entidad @endsection
@section('seccion') Entidades @endsection
@section('accion') Nuevo @endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                {!! Form::open(['action' => ['AdminEntidades@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => true]) !!}
                                <div class="form-body">
                                    <div class="panel-heading"></div>
                                    <h4 class="form-section"><i class="ft-user"></i> Datos de la Entidad</h4>
                                    @include('admin.entidades.partial')
                                    <div class="panel-footer">
                                        <a href="{{ action('AdminIndustrias@Index') }}" class="btn btn-default">Cancelar</a>
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
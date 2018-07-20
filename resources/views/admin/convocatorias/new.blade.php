@extends('layouts.admin')

@section('titulo') Nueva Convocatoria @endsection
@section('seccion') Convocatorias @endsection
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
                                {!! Form::open(['action' => ['AdminConvocatorias@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => true]) !!}
                                <div class="form-body">
                                    <div class="panel-heading"></div>
                                    @include('admin.convocatorias.partial')
                                    <hr/>
                                    <div class="panel-footer text-right">
                                        <a href="{{ action('AdminConvocatorias@Index') }}" class="btn btn-default">Cancelar</a>
                                        <button type="submit" class="btn btn-lg btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button>
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
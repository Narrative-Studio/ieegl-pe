@extends('layouts.admin')

@section('titulo') Editar Convocatoria @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Editar @endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                {!! Form::model($item, ['action' => ['AdminConvocatorias@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => true]) !!}
                                {!! Form::hidden('id', $item->_key); !!}
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
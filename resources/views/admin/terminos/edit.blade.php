@extends('layouts.admin')

@section('titulo') Editar Termino @endsection
@section('seccion') Terminos @endsection
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
                                {!! Form::model($item, ['action' => ['AdminTerminos@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => false]) !!}
                                {!! Form::hidden('id', $item->_key); !!}
                                <div class="panel-heading"></div>
                                <h4 class="form-section"><i class="ft-user"></i> Datos del Termino</h4>
                                @include('admin.terminos.partial')
                                <div class="panel-footer">
                                    <a href="{{ action('AdminTerminos@Index') }}" class="btn btn-default">Cancelar</a>
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
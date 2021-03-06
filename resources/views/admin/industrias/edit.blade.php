@extends('layouts.admin')

@section('titulo') Editar Industria @endsection
@section('seccion') Industrias @endsection
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
                                {!! Form::model($item, ['action' => ['AdminIndustrias@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => false]) !!}
                                {!! Form::hidden('id', $item->_key); !!}
                                <div class="panel-heading"></div>
                                <h4 class="form-section"><i class="ft-user"></i> Datos de la Industria</h4>
                                @include('admin.industrias.partial')
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
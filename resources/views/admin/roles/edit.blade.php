@extends('layouts.admin')

@section('titulo') Roles @endsection
@section('seccion') Roles @endsection
@section('accion') Editar Rol @endsection

@section('content')

    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            {!! Form::model($item, ['action' => ['AdminRoles@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => false]) !!}
                            {!! Form::hidden('id', $item->_key) !!}
                                <div class="card-body">
                                    <div class="panel-heading"></div>
                                    <h4 class="form-section"><i class="ft-user"></i> Datos</h4>
                                    @include('admin.roles.partial')
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
@endsection
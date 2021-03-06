@extends('layouts.admin')

@section('titulo') Editar Pregunta @endsection
@section('seccion') Preguntas @endsection
@section('accion') Editar @endsection

@section('js')
    <script>
        $(function() {
            $("#tipo").on('change',function(){
                console.log($(this).val());
                $('#respuestas').css('display', ($(this).val()=='combo' || $(this).val()=='multiple')?'block':'none');
            });
        });
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                {!! Form::model($item, ['action' => ['AdminPreguntas@Save'], 'method'=>'POST', 'class'=>'form form-horizontal', 'files' => false]) !!}
                                {!! Form::hidden('id', $item->_key); !!}
                                <div class="panel-heading"></div>
                                <h4 class="form-section"><i class="fa fa-question-circle"></i> Datos de la Pregunta</h4>
                                @include('admin.preguntas_admin.partial')
                                <div class="panel-footer">
                                    <a href="{{ action('AdminPreguntas@Index') }}" class="btn btn-default">Cancelar</a>
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
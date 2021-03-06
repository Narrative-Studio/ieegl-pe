@extends('layouts.admin')

@section('titulo') Nueva Convocatoria @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Nuevo @endsection

@section('js')
    <script type="text/javascript">
        var json = '';
    </script>
    <script src="{{url("/")}}/app-assets/js/scripts/editors/editor-quill-sid.js" type="text/javascript"></script>
    <script src="{{url("/")}}/js/preguntas.js" type="text/javascript"></script>
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
                                {!! Form::open(['action' => ['AdminConvocatorias@Save'], 'method'=>'POST', 'id'=>'formConvocatoria', 'class'=>'form steps-validation wizard-circle', 'files' => true]) !!}
                                <div class="panel-heading"></div>
                                @include('admin.convocatorias.partial')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
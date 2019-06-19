@extends('layouts.admin')

@section('titulo') Reportes @endsection
@section('seccion') Reportes @endsection
@section('accion') Aplicaciones @endsection

@section('js')
    <script type="text/javascript">
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
                                <h2>Convocatoria: {{$nombre}}</h2>
                                <table id="dataTable"
                                        data-pagination="true"
                                        data-side-pagination="server"
                                        data-search="false"
                                        data-page-size="50"
                                        data-toggle="table"
                                        data-show-export="true"
                                        data-show-columns="true"
                                        data-sort-name="fecha"
                                        data-sort-order="asc"
                                        data-url="{{route('reportes.aplicaciones_ajax', $key)}}"
                                        data-page-list="[50, 100, Unlimited]"
                                        class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th data-sortable="fecha" data-field="fecha">Fecha</th>
                                        <th data-field="aprobado">Estatus</th>
                                        <th data-sortable="fecha_aprobacion" data-field="fecha_aprobacion">Fecha Aprobación</th>
                                        <th data-field="comentarios">Comentarios</th>
                                        @foreach($campos_convocatoria as $key=>$val)
                                            <th data-field="{{$key}}">{{$val}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

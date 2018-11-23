@extends('layouts.admin')

@section('titulo') Reportes @endsection
@section('seccion') Reportes @endsection
@section('accion') Usuarios Full @endsection

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
                                <table id="dataTable"
                                        data-pagination="true"
                                        data-side-pagination="server"
                                        data-search="true"
                                        data-page-size="50"
                                        data-toggle="table"
                                        data-show-export="true"
                                        data-show-columns="true"
                                        data-sort-name="nombre"
                                        data-sort-order="asc"
                                        data-url="{{route('reportes.usuariosFull')}}"
                                        data-page-list="[50, 100, Unlimited]"
                                        class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th data-sortable="true" data-field="_key">ID</th>
                                        <th data-sortable="true" data-field="nombre">Nombre</th>
                                        <th data-field="matricula">Matrícula</th>
                                        <th data-field="email">Email</th>
                                        <th data-field="telefono">Teléfono</th>
                                        <th data-field="biografia">Biografía</th>
                                        <th data-field="sexo">Sexo</th>
                                        <th data-field="fecha_nacimiento">Fecha Nacimiento</th>
                                        <th data-field="dedica_a">A qué se dedica</th>
                                        <th data-field="linkedin">Linkedin</th>
                                        <th data-field="pais">País</th>
                                        <th data-field="estado">Estado</th>
                                        <th data-field="ciudad">Ciudad</th>
                                        <th data-field="universidad">Universidad</th>
                                        <th data-field="campus">Campus Tec</th>
                                        <th data-field="carrera_cursando">Actualmente cursando carrera</th>
                                        <th data-field="fecha_graduacion">Fecha Graduación</th>
                                        <th data-field="fecha">Fecha Alta</th>
                                        <th data-field="validated">Validado</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

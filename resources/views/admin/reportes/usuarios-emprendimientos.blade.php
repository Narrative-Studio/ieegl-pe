@extends('layouts.admin')

@section('titulo') Reportes @endsection
@section('seccion') Reportes @endsection
@section('accion') Usuarios que no cuentan con emprendimientos @endsection

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
                                <table
                                        data-pagination="true"
                                        data-side-pagination="server"
                                        data-search="true"
                                        data-page-size="50"
                                        data-toggle="table"
                                        data-show-export="true"
                                        data-show-columns="true"
                                        data-sort-name="nombre"
                                        data-sort-order="asc"
                                        data-url="{{route('reportes.usuarios-emprendimientos')}}"
                                        data-page-list="[50, 100, Unlimited]"
                                        class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th data-sortable="true" data-field="nombre">Nombre</th>
                                        <th data-field="email">Email</th>
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



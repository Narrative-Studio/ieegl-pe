@extends('layouts.admin')

@section('titulo') Listado de Solicitudes @endsection
@section('seccion') Solicitudes @endsection
@section('accion') Listado @endsection

@section('js')
    <script type="text/javascript">
        $(function(){
            $('#convocatoria').on('change',function(){
               window.location.href="{{action('AdminSolicitudes@Index')}}?convocatoria="+$(this).val();
            });
        });
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body"><!-- project stats -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 >Aplicaciones</h3>
                            <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Selector de Convocatoria -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8 dataTables_length" id="convocatorias_list">
                                            <label><b>Selecciona una convocatoria: </b></label>
                                            {!! Form::select('convocatoria', $convocatorias, \Illuminate\Support\Facades\Input::get('convocatoria'), ['placeholder' => 'Todas las convocatorias', 'id'=>'convocatoria','class'=> 'select2 form-control', 'style'=>'width: 50% !important;']) !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- Task List table -->
                                @if(count($datos)>0)
                                    <div class="table-responsive">
                                        <table id="project-bugs-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                            <thead>
                                            <tr>
                                                <th>Convocatoria</th>
                                                <th>Emprendimiento</th>
                                                <th>Usuario</th>
                                                <th>Fecha de Aplicación</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($datos as $item)
                                                <tr>
                                                <td>
                                                    <a href="{{action('AdminConvocatorias@Edit',['id'=>$item->convocatoria->_key])}}" style="white-space:normal;">{{$item->convocatoria->nombre}}</a>
                                                </td>
                                                <td class="text-left">
                                                    <b>{{$item->emprendimiento}}</b>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-bold-600 font-small-3">{{$item->usuario->nombre}} {{$item->usuario->apellidos}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-bold-600 font-small-3">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_registro)->formatLocalized('%d %B %Y')}}</p>
                                                </td>
                                                <td>
                                                    @if($item->aprobado==1) <span class="badge badge-warning round">Por Revisar</span> @endif
                                                    @if($item->aprobado==4) <span class="badge badge-info round" style="background-color: #ffd95d;">Pendiente</span> @endif
                                                    @if($item->aprobado==2) <span class="badge badge-danger round">Rechazada</span> @endif
                                                    @if($item->aprobado==3) <span class="badge badge-success round">Aprobada</span> @endif
                                                </td>
                                                <td>
                                                    <a href="{{action('AdminSolicitudes@Edit',['id'=>$item->_key])}}" class="btn btn-success btn-sm mt-1"><i class="fa fa-edit"></i> Editar Aplicación </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="dataTables_paginate paging_full_numbers">
                                            {!! $datos->appends(['total' => (int)$total]+\Illuminate\Support\Facades\Input::except('page'))->render() !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="alert round bg-warning alert-icon-right alert-dismissible mb-2 text-center" role="alert">
                                                <span class="alert-icon"><i class="fa fa-info-circle"></i></span>
                                                No hay datos
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ project stats -->
        </div>
    </div>
@endsection



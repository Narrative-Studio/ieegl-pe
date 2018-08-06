@extends('layouts.admin')

@section('titulo') Listado de Solicitudes @endsection
@section('seccion') Solicitudes @endsection
@section('accion') Listado @endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            @if(count($datos)>0)
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-primary white">
                                        <tr>
                                            <th>Convocatoria</th>
                                            <th>Usuario</th>
                                            <th>Emprendimiento</th>
                                            <th>Fecha Aplicación</th>
                                            <th>Estatus</th>
                                            <th width="150">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datos as $item)
                                            <tr>
                                                <td>{{$item->convocatoria->nombre}}</td>
                                                <td>{{$item->usuario->nombre}}</td>
                                                <td>
                                                    @if($item->convocatoria->quien!='6375236')
                                                        {{$item->emprendimiento->nombre}}
                                                    @else
                                                        <i>No aplica</i>
                                                    @endif
                                                </td>
                                                <td style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_registro)->formatLocalized('%d %B %Y')}}</td>
                                                <td>
                                                    @if($item->aprobado==1) <div class="badge badge-warning">Pendiente</div> @endif
                                                    @if($item->aprobado==2) <div class="badge badge-danger">Rechazada</div> @endif
                                                    @if($item->aprobado==3) <div class="badge badge-success">Aprobada</div> @endif
                                                    @if($item->aprobado==4) <div class="badge badge-success" style="background-color: #ffd95d;">Pendiente de Pago</div> @endif
                                                </td>
                                                <td>
                                                    <a href="{{action('AdminSolicitudes@Edit',['id'=>$item->_key])}}" class="btn btn-sm btn-success mr-0"><i class="fa fa-edit"></i> Editar Aplicación</a>
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
    </div>
@endsection



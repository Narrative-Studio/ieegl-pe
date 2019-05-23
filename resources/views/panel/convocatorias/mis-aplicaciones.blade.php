@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Mis Aplicaciones @endsection


@section('breadcrumb')
    <h3 class="content-header-title">MIS APLICACIONES</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
                <li class="breadcrumb-item active">Mis Aplicaciones</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4 class="card-title">Listado de Aplicaciones</h4>
                </div>
                <div class="card-content collapse show">
                    @if($convocatorias)


                        <div class="table-responsive">
                            <table id="project-bugs-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>Convocatoria</th>
                                    <th>Fecha</th>
                                    <th>Emprendimiento</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($convocatorias as $item)
                                    <tr>
                                        <td class="text-left">
                                            <a href="{{action('PanelConvocatorias@VerAplicacion',['id'=>$item->_key])}}" class="text-bold-600">{{$item->nombre}}</a>
                                            <div class="text-muted font-small-2" style="white-space:normal;">{!! $item->descripcion !!}</div>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-bold-600 font-small-3">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_registro)->formatLocalized('%d %B %Y')}}</p>
                                        </td>
                                        <td><span href="#" class="text-bold-600">
                                            @if($item->quien!='6375236')
                                                    {{$item->emprendimiento}}
                                                @else
                                                    <i>No aplica</i>
                                                @endif
                                        </span>
                                        </td>
                                        <td>
                                            @if($item->aprobado==1) <div class="badge badge-warning">Pendiente</div> @endif
                                            @if($item->aprobado==2) <div class="badge badge-danger">Rechazada</div> @endif
                                            @if($item->aprobado==3) <div class="badge badge-success">Aprobada</div> @endif
                                            @if($item->aprobado==4) <div class="badge badge-success" style="background-color: #ffd95d;">Pendiente de Pago</div> @endif
                                        </td>
                                        <td>
                                            <a href="{{action('PanelConvocatorias@VerAplicacion',['id'=>$item->_key])}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Ver Aplicación</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-sm-12">
                                <div class="dataTables_paginate paging_full_numbers">
                                    {!! $convocatorias->appends(['total' => (int)$total]+\Illuminate\Support\Facades\Input::except('page'))->render() !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="bs-callout-warning callout-border-left p-1">
                                        <strong>Aún no tenemos Convocatorias</strong>
                                        <p>Muy pronto tendrémos convocatorias para que puedas aplicar tus Emprendimientos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                                    <th>Aplicación</th>
                                    <th>Emprendimiento</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($convocatorias as $item)
                                    <tr @if($item->activo=="deleted") style="background-color: #0000000f;color: #0000002e;" @endif>
                                        <td class="text-left">
                                            @if($item->activo!="deleted")
                                                <a href="{{action('PanelConvocatorias@VerAplicacion',['id'=>$item->_key])}}" class="text-bold-600">{{$item->nombre}}</a>
                                                <div class="text-muted font-small-2" style="white-space:normal;">{!! $item->descripcion !!}</div>
                                            @else
                                                <span class="text-bold-600">{{$item->nombre}}</span> (no disponible)
                                                <div class="font-small-2" style="white-space:normal;">{!! $item->descripcion !!}</div>
                                            @endif
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
                                            @if($item->activo=="deleted")
                                                <span class="badge" style="background-color: #c6c6c685;">No disponible</span>
                                            @else
                                                @if($item->aprobado==1) <span class="badge badge-warning">Por Revisar</span> @endif
                                                @if($item->aprobado==4) <span class="badge badge-info">Pendiente</span> @endif
                                                @if($item->aprobado==2) <span class="badge badge-danger">Rechazada</span> @endif
                                                @if($item->aprobado==3) <span class="badge badge-success">Aprobada</span> @endif
                                            @endif
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

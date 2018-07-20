@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Listado @endsection
@section('accion') Listado @endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Listado de Convocatorias</h4>
                        </div>
                        <div class="card-content collapse show">
                            @if($convocatorias)
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-primary white">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>¿Quién puede aplicar?</th>
                                            <th width="150">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($convocatorias as $item)
                                            <tr>
                                                <td>{{$item->nombre}}</td>
                                                <td>{{$item->descripcion}}</td>
                                                <td style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</td>
                                                <td style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</td>
                                                <td>{{$item->quien_nombre}}</td>
                                                <td>
                                                    <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->_key])}}" class="btn btn-sm btn-success mr-0"><i class="fa fa-edit"></i> Ver/Aplicar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
    </div>
@endsection

@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Mis Aplicaciones @endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Listado de Aplicaciones</h4>
                        </div>
                        <div class="card-content collapse show">
                            @if($convocatorias)
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-primary white">
                                        <tr>
                                            <th>Convocatoria</th>
                                            <th>Emprendimiento</th>
                                            <th>Fecha Aplicación</th>
                                            <th>Estatus</th>
                                            <th width="150">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($convocatorias as $item)
                                            <tr>
                                                <td>{{$item->nombre}}<br/><small>{!! $item->descripcion !!}</small></td>
                                                <td>
                                                    @if($item->quien!='6375236')
                                                        {{$item->emprendimiento}}
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
                                                    <a href="{{action('PanelConvocatorias@VerAplicacion',['id'=>$item->_key])}}" class="btn btn-sm btn-success mr-0"><i class="fa fa-eye"></i> Ver Aplicación</a>
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
    </div>
@endsection

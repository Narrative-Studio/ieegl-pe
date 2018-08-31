@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Listado de Convocatorias @endsection

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
                            @if(count($convocatorias)>0)
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-primary white">
                                        <tr>
                                            <th>Nombre</th>
                                            <th width="150">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($convocatorias as $item)
                                            <tr>
                                                <td>
                                                    <h3>{{$item->nombre}}</h3>
                                                    <h6 style="color: #6a569c;"><span style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</span> - <span style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</span></h6>
                                                    <span style="display: block;margin-top: 23px;margin-bottom: 12px;">
                                                        {!! $item->descripcion_corta !!}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->_key])}}" class="btn btn-success mr-0"><i class="fa fa-edit"></i> Ver/Aplicar</a>
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

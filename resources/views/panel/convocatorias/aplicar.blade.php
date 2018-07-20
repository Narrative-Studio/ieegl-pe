@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Aplicar @endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <h2>{{$item->nombre}}</h2>
                                <div class="card-text">
                                    <p>{{$item->descripcion}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="row justify-content-md-center">
                <div class="col-md-6 col-sm-12">
                    <div class="bs-callout-warning callout-border-left callout-bordered mb-2 p-1">
                        <strong>Respuesta a solicitud:</strong>
                        <p>En este momento no puede aplicar hasta que ingrese la información especificada abajo.</p>
                    </div>
                </div>
            </section>
            <section class="row">
                <div class="col-md-12 col-sm-12">
                    <div id="with-header" class="card">
                        <div class="card-content collapse show">
                            <div class="card-body border-top-blue-grey border-top-lighten-5 ">

                                <ul class="list-group mb-3 card">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <small class="text-muted">Emprendimiento</small>
                                            <h6 class="">{{$emprendimiento->nombre}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="col-sm-4 col-xs-6 p-0">
                                            <small class="text-muted">Datos Generales</small>
                                            <h6 class="date">
                                                <h6>
                                                    @if($emprendimiento->module_datos==true)
                                                        <div class="badge badge-success">Completado</div>
                                                    @else
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-danger btn-sm">Pendiente</button>
                                                            <button type="button" class="btn btn-lighten-5 btn-sm"><i class="fa fa-edit"></i> Completar</button>
                                                        </div>
                                                    @endif
                                                </h6>
                                            </h6>
                                        </div>
                                        <div class="col-sm-4 col-xs-6 p-0">
                                            <small class="text-muted">Medios Digitales</small>
                                            <h6>
                                                @if($emprendimiento->module_medios==true)
                                                    <div class="badge badge-success">Completado</div>
                                                @else
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-danger btn-sm">Pendiente</button>
                                                        <button type="button" class="btn btn-lighten-5 btn-sm"><i class="fa fa-edit"></i> Completar</button>
                                                    </div>
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="col-sm-4 d-xs-none d-sm-block p-0"></div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="col-4 p-0">
                                            <small class="text-muted">Ventas</small>
                                            <h6>
                                                @if($emprendimiento->module_ventas==true)
                                                    <div class="badge badge-success">Completado</div>
                                                @else
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-danger btn-sm">Pendiente</button>
                                                        <button type="button" class="btn btn-lighten-5 btn-sm"><i class="fa fa-edit"></i> Completar</button>
                                                    </div>
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="col-4 p-0">
                                            <small class="text-muted">Clientes</small>
                                            <h6>
                                                @if($emprendimiento->module_clientes==true)
                                                    <div class="badge badge-success">Completado</div>
                                                @else
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-danger btn-sm">Pendiente</button>
                                                        <button type="button" class="btn btn-lighten-5 btn-sm"><i class="fa fa-edit"></i> Completar</button>
                                                    </div>
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="col-4 p-0">
                                            <small class="text-muted">Info. Financiera</small>
                                            <h6>
                                                @if($emprendimiento->module_financiera==true)
                                                    <div class="badge badge-success">Completado</div>
                                                @else
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-danger btn-sm">Pendiente</button>
                                                        <button type="button" class="btn btn-lighten-5 btn-sm"><i class="fa fa-edit"></i> Completar</button>
                                                    </div>
                                                @endif
                                            </h6>
                                        </div>
                                        <!--<div class="col-4 p-0">
                                            <small class="text-muted">Inversión</small>
                                            <h6 class="date">@if($emprendimiento->module_inversion==true) <div class="badge badge-success">Completado</div> @else <div class="badge badge-danger">Pendiente</div> @endif</h6>
                                        </div>-->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {!! Form::open(['action' => ['PanelConvocatorias@Aplicar', $item->_key], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
        <div class="row mt-2">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-lg btn-success mt-2" style="zoom: 1.5;"><i class="fa fa-check"></i> Aplicar a esta convocatoria</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

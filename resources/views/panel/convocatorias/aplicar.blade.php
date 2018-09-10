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
                                    <p>{!! $item->descripcion_corta !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php

            ?>

            @if($verificar!=true)
                <section class="row justify-content-md-center">
                    <div class="col-md-6 col-sm-12">
                        @if($puede_aplicar == false)
                            <div class="bs-callout-warning callout-border-left callout-bordered mb-2 p-1">
                                <strong>Respuesta a solicitud:</strong>
                                <p>En este momento no puede aplicar hasta que ingrese la información especificada abajo.</p>
                            </div>
                        @else
                            <div class="bs-callout-success callout-border-left callout-bordered mb-2 p-1">
                                <strong>Respuesta a solicitud:</strong>
                                <p>¡Enhorabuena! Puedes aplicar a la convocatoria.</p>
                            </div>
                        @endif
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-12 col-sm-12">
                        <div id="with-header" class="card">
                            <div class="card-content collapse show">
                                <div class="card-body border-top-blue-grey border-top-lighten-5 ">

                                    <ul class="list-group mb-0 card">
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div>
                                                <small class="text-muted">Emprendimiento</small>
                                                <h3 class="">{{$emprendimiento->nombre}}</h3>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div class="row" style="width: 100%;">
                                                <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                    <h5>Datos Generales</h5>
                                                    <h6 class="pr-md-2">
                                                        @if(isset($errores['generales']) || isset($errores['mvp']))
                                                            @if(isset($errores['generales']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                     {{$errores['generales']}}
                                                                </div>
                                                            @endif
                                                            @if(isset($errores['mvp']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                     {{$errores['mvp']}}
                                                                </div>
                                                            @endif
                                                            <a href="{{action('PanelEmprendimientos@DatosGenerales', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i> Editar Datos Generales</a>
                                                        @else
                                                            <div class="badge badge-success">Aceptado</div>
                                                        @endif
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                    <h5>Medios Digitales</h5>
                                                    <h6 class="pr-md-2">
                                                        @if(isset($errores['medios']))
                                                            <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                {{$errores['medios']}}
                                                            </div>
                                                            <a href="{{action('PanelEmprendimientos@MediosDigitales', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i> Editar Medios Digitales</a>
                                                        @else
                                                            <div class="badge badge-success">Aceptado</div>
                                                        @endif
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                    <h5>Info. Financiera</h5>
                                                    <h6 class="pr-md-2">
                                                        @if(isset($errores['ventas']) || isset($errores['lanzado']) || isset($errores['financiera']))
                                                            @if(isset($errores['ventas']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                    {{$errores['ventas']}}
                                                                </div>
                                                            @endif
                                                            @if(isset($errores['lanzado']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                    {{$errores['lanzado']}}
                                                                </div>
                                                            @endif
                                                            @if(isset($errores['financiera']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                    {{$errores['financiera']}}
                                                                </div>
                                                            @endif
                                                            <a href="{{action('PanelEmprendimientos@Financiera', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i> Editar Información Financiera</a>
                                                        @else
                                                            <div class="badge badge-success">Aceptado</div>
                                                        @endif
                                                    </h6>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div class="row" style="width: 100%;">
                                                <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                    <h5>Mercado</h5>
                                                    <h6 class="pr-md-2">
                                                        @if(isset($errores['clientes']) || isset($errores['usuarios']))
                                                            @if(isset($errores['clientes']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                    {{$errores['clientes']}}
                                                                </div>
                                                            @endif
                                                            @if(isset($errores['usuarios']))
                                                                <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                    {{$errores['usuarios']}}
                                                                </div>
                                                            @endif
                                                            <a href="{{action('PanelEmprendimientos@Mercado', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i>  Editar Mercado</a>
                                                        @else
                                                            <div class="badge badge-success">Aceptado</div>
                                                        @endif
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                    <h5>Inversión</h5>
                                                    <h6 class="pr-md-2">
                                                        @if(isset($errores['inversion']))
                                                            <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                                <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                                {{$errores['inversion']}}
                                                            </div>
                                                            <a href="{{action('PanelEmprendimientos@Inversion', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i> Editar Inversión</a>
                                                        @else
                                                            <div class="badge badge-success">Aceptado</div>
                                                        @endif
                                                    </h6>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <section class="row justify-content-md-center">
                    <div class="col-md-6 col-sm-12">
                        <div class="bs-callout-danger callout-border-left callout-bordered mb-2 p-1">
                            <strong>No puedes aplicar de nuevo</strong>
                            <p>Ya tienes una aplicación de <b>{{$emprendimiento->nombre}}</b> a esta convocatoria, solo puedes aplicar una vez tu emprendimiento en la misma convocatoria.</p>
                        </div>
                    </div>
                </section>
            @endif
        </div>
        @if($verificar!=true)
            @if($puede_aplicar==true)
                {!! Form::open(['action' => ['PanelConvocatorias@Aplicacion', $item->_key], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                {!! Form::hidden('emprendimiento', $emprendimiento->_key) !!}
                <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-lg btn-success mt-2" style="zoom: 1.5;"><i class="fa fa-check"></i> Aplicar a esta convocatoria</button>
                    </div>
                </div>
                {!! Form::close() !!}
            @endif
        @else
            <div class="row mt-2">
                <div class="col-sm-12 text-center">
                    <a href="javascript:window.history.back();" class="btn btn-lg btn-primary mt-2"><i class="fa fa-arrow-left"></i> Regresar a la convocatoria</a>
                </div>
            </div>
        @endif
    </div>
@endsection

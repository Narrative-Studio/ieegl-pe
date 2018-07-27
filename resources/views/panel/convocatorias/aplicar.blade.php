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

            <?php

            ?>

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
                            <p>¡En Horabuena! Puedes aplicar a la convocatoria.</p>
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
                                                    @if(isset($errores['generales']))
                                                        <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                            <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                            {{$errores['generales']}}
                                                        </div>
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
                                                <h5>Ventas</h5>
                                                <h6 class="pr-md-2">
                                                    @if(isset($errores['ventas']))
                                                        <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                            <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                            {{$errores['ventas']}}
                                                        </div>
                                                        <a href="{{action('PanelEmprendimientos@Ventas', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i> Editar Ventas</a>
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
                                                <h5>Clientes</h5>
                                                <h6 class="pr-md-2">
                                                    @if(isset($errores['clientes']))
                                                        <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                            <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                            {{$errores['clientes']}}
                                                        </div>
                                                        <a href="{{action('PanelEmprendimientos@Clientes', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i>  Editar Clientes</a>
                                                    @else
                                                        <div class="badge badge-success">Aceptado</div>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Usuarios</h5>
                                                <h6 class="pr-md-2">
                                                    @if(isset($errores['usuarios']))
                                                        <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                            <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                            {{$errores['usuarios']}}
                                                        </div>
                                                        <a href="{{action('PanelEmprendimientos@Usuarios', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i>  Editar Usuarios</a>
                                                    @else
                                                        <div class="badge badge-success">Aceptado</div>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Info. Financiera</h5>
                                                <h6 class="pr-md-2">
                                                    @if(isset($errores['financiera']))
                                                        <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                                                            <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                                            {{$errores['financiera']}}
                                                        </div>
                                                        <a href="{{action('PanelEmprendimientos@Financiera', $emprendimiento->_key)}}" class="btn btn-grey btn-sm"><i class="fa fa-edit"></i> Editar Información Financiera</a>
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
        </div>
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
    </div>
@endsection

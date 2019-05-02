@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Información @endsection

@section('breadcrumb')
    <h3 class="content-header-title">CONVOCATORIA {{$item->nombre}}</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
                <li class="breadcrumb-item"><a href="#">Convocatorias</a></li>
                <li class="breadcrumb-item active">{{$item->nombre}}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

        <div id="user-profile">
            <div class="row">
                <div class="col-md-12">
                    <div class="card profile-with-cover">
                        <?php
                        if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->_key.'.jpg'))){
                            $img = url('/convocatorias_pics/imagen_'.$item->_key.'.jpg');
                        }else{
                            $img = url('/app-assets/images/carousel/22.jpg');
                        }
                        ?>
                        <div class="card-img-top img-fluid bg-cover height-300" style="background: url('{{$img}}?{{str_random(15)}}') 50%;"></div>
                        <div class="media profil-cover-details w-100">
                            <div class="media-left pl-2 pt-2 pb-2">
                                <a href="#" class="profile-image">
                                    <img src="../../../app-assets/images/heineken.png" class="rounded-circle img-border height-100" alt="Card image">
                                </a>
                            </div>
                            <div class="media-body pt-2 px-2">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="card-title">{{$item->entidad}}</h2>
                                        <small class="block"></small>
                                    </div>
                                    <div class="col text-right">

                                        @if($verificar==true)
                                            <div class="row mt-2">
                                                <div class="col-sm-12 text-center">
                                                    <button type="normal" class="btn btn-lg btn-grey mt-2" style="zoom: 1.5;" disabled="disabled"><i class="fa fa-close"></i> No puedes aplicar de nuevo a esta convocatoria</button>
                                                </div>
                                            </div>
                                        @else
                                            @if($item->quien_key!='6375236')
                                                {!! Form::open(['action' => ['PanelConvocatorias@Aplicar', $item->_key], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}

                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn btn-success dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-check"></i> APLICAR
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 49px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a class="dropdown-item" href="#">Emprendimiento 1</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Emprendimiento 2</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Emprendimiento 3</a>
                                                    </div>
                                                </div>

                                                <!--<div class="row mt-2">
                                                    <div class="col-sm-12 text-center">
                                                        <h1>¿Quieres aplicar a esta convocatoria?</h1>
                                                        <label>Indica con cuál de tus emprendimientos quieres aplicar:</label>
                                                        <div class="form-group row justify-content-md-center">
                                                            <div class="col-md-3">
                                                                <?php $class=($errors->has('emprendimiento'))?'form-control is-invalid':'form-control'; ?>
                                                                {!! Form::select('emprendimiento', $emprendimientos, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class,'required'=>'required']) !!}
                                                                @if ($errors->has('emprendimiento'))
                                                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('emprendimiento') }}</strong></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-lg btn-success mt-2" style="zoom: 1.5;"><i class="fa fa-check"></i> Aplicar a esta convocatoria</button>
                                                    </div>
                                                </div>-->
                                                {!! Form::close() !!}
                                            @else
                                                {!! Form::open(['action' => ['PanelConvocatorias@Aplicacion', $item->_key], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                                                <div class="row mt-2">
                                                    <div class="col-sm-12 text-center">
                                                        <button type="submit" class="btn btn-lg btn-success mt-2" style="zoom: 1.5;"><i class="fa fa-check"></i> Aplicar a esta convocatoria</button>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Task Progress -->
        <section class="row">
            <div class="col-xl-6 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <div class="card-header">
                            <h4 class="card-title">DETALLES DE LA CONVOCATORIA</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="pb-1">
                                <div class="badge badge-success">
                                    <i class="fa fa-calendar-o font-medium-2"></i>
                                </div>
                                <small> Fecha de Inicio:</small>
                                <span> {{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</span>
                            </div>
                            <div class="pb-1">
                                <div class="badge badge-success">
                                    <i class="fa fa-calendar-o font-medium-2"></i>
                                </div>
                                <small>Fecha de Cierre:</small>
                                <span> {{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</span>
                            </div>

                            <p>{!! $item->descripcion !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Task Progress -->
            <!-- Bug Progress -->
            <div class="col-xl-6 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">REGLAS PARA APLICAR</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <h6><strong>Quien puede aplicar:</strong></h6>
                            <p>{{$item->quien}}</p>
                            <h6><strong>Descripción de las Reglas</strong></h6>
                            {!! $item->comentarios !!}
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Bug Progress -->
        </section>



<!--
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <h2>{{$item->nombre}}</h2>
                                <div class="card-text">
                                    <p>{!! $item->descripcion !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="row">
                <div class="col-md-6 col-sm-12">
                    <div id="with-header" class="card">
                        <div class="card-content collapse show">
                            <div class="card-body border-top-blue-grey border-top-lighten-5 ">

                                <ul class="list-group mb-0 card">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <small class="text-muted">¿Quién convoca?</small>
                                            <h6 class="">{{$item->entidad}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="col-6 p-0">
                                            <small class="text-muted">¿Cuándo inicia?</small>
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                        <div class="col-6 p-0">
                                            <small class="text-muted">¿Cuándo términa?</small>
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div>
                                            <small class="text-muted">¿Quién puede aplicar?</small>
                                            <h6 class="">{{$item->quien}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div class="col-6 p-0">
                                            <small class="text-muted">Fecha de Inicio del Evento</small>
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_evento)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                        <div class="col-6 p-0">
                                            <small class="text-muted">Fecha Final del Evento</small>
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_evento)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div>
                                            <small class="text-muted">Contacto responsable</small>
                                            <h6 class="">{{$item->responsable->nombre}}</h6>
                                        </div>
                                    </li>
                                    @if($item->comentarios!='')
                                        <li class="list-group-item d-flex justify-content-between">
                                            <div>
                                                <h6 class="">{!! $item->comentarios !!}</h6>
                                            </div>
                                        </li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div id="with-header-border-0" class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->_key.'.jpg')))
                                    <img src="{{url('/convocatorias_pics/imagen_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="100%" height="" border="0" alt="" class="rounded img-fluid" data-aaction="zoom" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @if($verificar==true)
            <div class="row mt-2">
                <div class="col-sm-12 text-center">
                    <button type="normal" class="btn btn-lg btn-grey mt-2" style="zoom: 1.5;" disabled="disabled"><i class="fa fa-close"></i> No puedes aplicar de nuevo a esta convocatoria</button>
                </div>
            </div>
        @else
            @if($item->quien_key!='6375236')
                {!! Form::open(['action' => ['PanelConvocatorias@Aplicar', $item->_key], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <h1>¿Quieres aplicar a esta convocatoria?</h1>
                            <label>Indica con cuál de tus emprendimientos quieres aplicar:</label>
                            <div class="form-group row justify-content-md-center">
                                <div class="col-md-3">
                                    <?php $class=($errors->has('emprendimiento'))?'form-control is-invalid':'form-control'; ?>
                                    {!! Form::select('emprendimiento', $emprendimientos, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class,'required'=>'required']) !!}
                                    @if ($errors->has('emprendimiento'))
                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('emprendimiento') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        <button type="submit" class="btn btn-lg btn-success mt-2" style="zoom: 1.5;"><i class="fa fa-check"></i> Aplicar a esta convocatoria</button>
                    </div>
                </div>
                {!! Form::close() !!}
           @else
                {!! Form::open(['action' => ['PanelConvocatorias@Aplicacion', $item->_key], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-lg btn-success mt-2" style="zoom: 1.5;"><i class="fa fa-check"></i> Aplicar a esta convocatoria</button>
                    </div>
                </div>
                {!! Form::close() !!}
            @endif
        @endif
    </div>
@endsection

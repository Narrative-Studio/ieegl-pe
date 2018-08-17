@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Información @endsection

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
                                    <p>{!! nl2br($item->descripcion) !!}</p>
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
                                                <h6 class="">{!! nl2br($item->comentarios) !!}</h6>
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
                            <label>Indica con cual de tus emprendimientos quieres aplicar:</label>
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

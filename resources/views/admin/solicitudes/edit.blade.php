@extends('layouts.panel')

@section('titulo') Solicitudes @endsection
@section('seccion') Solicitudes @endsection
@section('accion') Ver Aplicación @endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <h2>{{$item->convocatoria->nombre}}</h2>
                                <div class="card-text">
                                    <p>{{$item->convocatoria->descripcion}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="card-text">
                                    <h6>Emprendimiento aplicado: </h6>
                                    <h4>{{$item->emprendimiento}}</h4>
                                </div>
                                <hr/>
                                <h4>Status:
                                    @if($item->aprobado==1) <div class="badge badge-warning">Pendiente</div> @endif
                                    @if($item->aprobado==2) <div class="badge badge-danger">Rechazada</div> @endif
                                    @if($item->aprobado==3) <div class="badge badge-success">Aprobada</div> @endif
                                </h4>
                                @if($item->comentarios!='')
                                    <hr/>
                                    <div class="card-text">
                                        <h4>Comentarios: </h4>
                                        <p>{{$item->comentarios}}</p>
                                    </div>
                                @endif
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
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                        <div class="col-6 p-0">
                                            <small class="text-muted">¿Cuándo términa?</small>
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</h6>
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
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_inicio_evento)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                        <div class="col-6 p-0">
                                            <small class="text-muted">Fecha Final del Evento</small>
                                            <h6 class="date">{{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_fin_evento)->formatLocalized('%d %B %Y')}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div>
                                            <small class="text-muted">Contacto responsable</small>
                                            <h6 class="">{{$item->responsable}}</h6>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div id="with-header-border-0" class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->convocatoria->_key.'.jpg')))
                                    <img src="{{url('/convocatorias_pics/imagen_'.$item->convocatoria->_key.'.jpg')}}?{{str_random(15)}}" width="100%" height="" border="0" alt="" class="rounded img-fluid" data-aaction="zoom" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row mt-2">
                <div class="col-sm-12 text-center">
                    <a href="javascript:window.history.go(-1);" class="btn btn-lg btn-success mt-2" style="zoom: 1;"><i class="fa fa-arrow-left"></i> Regresar a Aplicaciones</a>
                </div>
            </div>
        </div>
    </div>
@endsection

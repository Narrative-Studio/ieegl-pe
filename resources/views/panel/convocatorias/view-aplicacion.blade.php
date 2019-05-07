@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Ver Aplicación @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/pages/users.css">
@endsection

@section('breadcrumb')
    <h3 class="content-header-title">Aplicación a {{$item->convocatoria->nombre}}</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action('PanelController@Index')}}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{action('PanelConvocatorias@Aplicaciones')}}">Mis Convocatorias</a></li>
                <li class="breadcrumb-item active">Aplicacion a {{$item->convocatoria->nombre}}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')

    <section class="row">
        <!-- Detalles de la Aplicación -->
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">DETALLES DE LA APLICACIÓN</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <h6><strong>Estatus de la Aplicación</strong></h6>
                        @if($item->aprobado==1) <h3 class="m-0 badge badge-default mb-2 badge-warning">Pendiente</h3> @endif
                        @if($item->aprobado==2) <h3 class="m-0 badge badge-default mb-2 badge-danger">Rechazada</h3> @endif
                        @if($item->aprobado==3) <h3 class="m-0 badge badge-default mb-2 badge-success">Aprobada</h3> @endif
                        @if($item->aprobado==4) <h3 class="m-0 badge badge-default mb-2 badge-warning">Pendiente de Pago</h3> @endif
                        <div class="mb-2">
                            <h6><strong>Nombre del Emprendimiento:</strong></h6>
                            <a href="#">{{$item->emprendimiento}}</a></div>
                        @if($item->comentarios!='')
                            <div class="mb-2">
                                <h6><strong>Comentarios</strong></h6>
                                {{$item->comentarios}}
                            </div>
                        @endif
                        @if($item->convocatoria->pago==true)
                            @if($item->aprobado==4)
                                @if($item->pago == "No")
                                    <div class="mb-2">
                                        <h6><strong>Por favor realice su pago en</strong></h6>
                                        <div class="iframe-pago">
                                            <iframe src="{!! $item->convocatoria->pago_iframe !!}"></iframe>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--/ DEtalles de la convocatira -->
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card bg-grey bg-lighten-2">
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
                        <div class="card profile-card-with-cover mb-0">
                            <?php
                            if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->convocatoria->_key.'.jpg'))){
                                $img = url('/convocatorias_pics/imagen_'.$item->convocatoria->_key.'.jpg');
                            }else{
                                $img = url('/app-assets/images/carousel/22.jpg');
                            }
                            ?>
                            <div class="card-img-top img-fluid bg-cover height-200" style="background: url({{$img}});"></div>
                            <div class="card-profile-image">
                                @if(isset($item->entidad_ext))
                                    @if(file_exists(public_path('/entidades_pics/imagen_'.$item->entidad_key.'.'.$item->entidad_ext)))
                                        <img src="{{url('/entidades_pics/imagen_'.$item->entidad_key.'.'.$item->entidad_ext)}}?{{str_random(15)}}" class="rounded-circle img-border box-shadow-1 height-100" />
                                    @else
                                        <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" class="rounded-circle img-border box-shadow-1 height-100" alt="" />
                                    @endif
                                @else
                                    <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" class="rounded-circle img-border box-shadow-1 height-100" alt="" />
                                @endif
                            </div>
                            <div class="profile-card-with-cover-content text-center pt-1">
                                <div class="card-body m-0">
                                    <h4 class="card-title mb-1"><a href=#>{{$item->convocatoria->nombre}}</a> </h4>
                                    <small><strong> Del {{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}} al {{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</strong></small>
                                    <small class="block">{!! $item->convocatoria->descripcion_corta !!}</small>
                                </div>

                                <div class="text-center">
                                    <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->convocatoria->_key])}}" class="btn mr-1 mb-1 btn-outline-secondary">Ver Convocatoria</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

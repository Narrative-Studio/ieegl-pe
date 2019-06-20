@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Ver Aplicación @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/pages/users.css">
    @if($item->convocatoria->activo=="deleted")
        <style>
            .card-body, .card-body h6, .card-body h4{
                color: #0000002e !important;
            }
            .card-body img, .card-body .card-img-top {
                -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
                filter: grayscale(100%);
            }
            .card-body .card-img-top{
                opacity: 0.5;
                filter: alpha(opacity=50); /* For IE8 and earlier */
            }
        </style>
    @endif
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
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <h6><strong>Estatus de la Aplicación</strong></h6>
                        @if($item->convocatoria->activo=="deleted")
                            <h3 class="m-0 badge mb-2" style="background-color: #c6c6c685;">No disponible</h3>
                        @else
                            @if($item->aprobado==1) <h3 class="m-0 badge mb-2 badge-warning">Por Revisar</h3> @endif
                            @if($item->aprobado==4) <h3 class="m-0 badge mb-2 badge-info">Pendiente</h3> @endif
                            @if($item->aprobado==2) <h3 class="m-0 badge mb-2 badge-danger">Rechazada</h3> @endif
                            @if($item->aprobado==3) <h3 class="m-0 badge mb-2 badge-success">Aprobada</h3> @endif
                        @endif
                        <div class="mb-2">
                            <h6><strong>Nombre del Emprendimiento:</strong></h6>
                            @if($item->convocatoria->activo!="deleted")
                                <a href="{{action('PanelEmprendimientos@DatosGenerales', $item->emprendimiento_id)}}">{{$item->emprendimiento}}</a>
                            @else
                                <span>{{$item->emprendimiento}}</span>
                            @endif
                        </div>
                        @if($item->comentarios!='')
                            <div class="mb-2">
                                <h6><strong>Comentarios</strong></h6>
                                {{$item->comentarios}}
                            </div>
                        @endif
                        @if($item->convocatoria->activo!="deleted")
                            @if($item->aprobado==1 || $item->aprobado==4)
                                <a href="{{action('PanelConvocatorias@EditarAplicacion', $item->_key)}}" class="btn btn-primary">Editar Aplicación</a>
                            @else
                                <a href="{{action('PanelConvocatorias@EditarAplicacion', $item->_key)}}" class="btn btn-secondary">Ver Aplicación</a>
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
                            <div class="card-img-top img-fluid bg-cover height-200" style="background: url({{$img}});background-position: center !important;"></div>
                            <div class="card-profile-image">
                                @if(isset($item->entidad_ext))
                                    @if(file_exists(public_path('/entidades_pics/imagen_'.$item->entidad_key.'.'.$item->entidad_ext)))
                                        <img src="{{url('/entidades_pics/imagen_'.$item->entidad_key.'.'.$item->entidad_ext)}}?{{str_random(15)}}" class="rounded-circle img-border box-shadow-1 bg-white width-100 height-100" />
                                    @else
                                        <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" class="rounded-circle img-border box-shadow-1  bg-white width-100 height-100" alt="" />
                                    @endif
                                @else
                                    <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" class="rounded-circle img-border box-shadow-1  bg-white width-100 height-100" alt="" />
                                @endif
                            </div>
                            <div class="profile-card-with-cover-content text-center pt-1">
                                <div class="card-body m-0">
                                    <h4 class="card-title mb-1">
                                        @if($item->convocatoria->activo!="deleted")
                                            <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->convocatoria->_key])}}">{{$item->convocatoria->nombre}}</a>
                                        @else
                                            {{$item->convocatoria->nombre}}
                                        @endif
                                    </h4>
                                    <small><strong> Del {{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}} al {{\Illuminate\Support\Carbon::createFromTimestamp($item->convocatoria->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</strong></small>
                                    <small class="block">{!! $item->convocatoria->descripcion_corta !!}</small>
                                </div>
                                @if($item->convocatoria->activo!="deleted")
                                    <div class="text-center">
                                        <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->convocatoria->_key])}}" class="btn mr-1 mb-1 btn-outline-secondary">Ver Convocatoria</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

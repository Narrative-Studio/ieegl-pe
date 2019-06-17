@extends('layouts.panel')

@section('titulo') Dashboard @endsection
@section('seccion') Panel de Usuario @endsection
@section('accion') Dashboard @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/pages/users.css">
@endsection

@section('breadcrumb')
    <h3 class="content-header-title">DASHBOARD</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card no-border box-shadow-0">
                <div class="card-content">
                    <div class="card-body bg-gray bg-lighten-4">
                        <div class="card-profile-image text-center">

                            @if(file_exists(public_path('/users_pics/user_'. auth()->user()->_key .'.jpg')))
                                <img src="{{url('/users_pics/user_'. auth()->user()->_key .'.jpg')}}" class="rounded-circle img-border box-shadow-1" height="105" alt="Card image">
                            @else
                                <img src="https://www.tinygraphs.com/isogrids/sidtec?theme=seascape&numcolors=4&size=105&fmt=svg" height="105" class="rounded-circle img-border box-shadow-1" alt="Card image">
                            @endif
                        </div>
                        <div class="text-center">
                            <span class="my-2 font-medium-4 text-bold-500 success">{{auth()->user()->nombre}} {{auth()->user()->apellidos}}</span>
                            <span class="block">{{auth()->user()->email}}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-grey py-2 text-center no-border">
                        <div class="row">
                            <div class="col-6 text-center display-table-cell">
                                <a href="{{action('PanelPerfiles@Cuenta')}}"><i class="icon-user font-large-1 white lighten-3 valign-middle"></i> <span class="white valign-middle">Mi Cuenta</span></a>
                            </div>
                            <div class="col-6 text-center display-table-cell">
                                <a href="{{action('PanelPerfiles@Index')}}"><i class="icon-note font-large-1 white lighten-3 valign-middle"></i> <span class="white valign-middle">Perfil</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card">
                <a href="{{action('PanelEmprendimientos@DatosGenerales')}}">
                    <div class="card-content">
                        <div class="media align-items-stretch">
                            <div class="p-2 bg-success text-white media-body text-left rounded-left">
                                <h5 class="text-white text-bold-400 mt-1">Crear Emprendimiento</h5>
                            </div>
                            <div class="p-2 text-center bg-success bg-darken-2 rounded-right">
                                <i class="icon-plus font-large-2 text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                <div class="pb-2">
                                    <div class="clearfix mb-1">
                                        <i class="icon-layers font-large-2 success float-left mt-1"></i>
                                        <span class="font-large-2 text-bold-300 blue-grey float-right">{{$dashboard->total_e}}</span>
                                    </div>
                                    <div class="clearfix">
                                        <span class=" float-right success"> Emprendimientos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                <div class="pb-2">
                                    <div class="clearfix mb-1">
                                        <i class="icon-check font-large-2 success float-left mt-1"></i>
                                        <span class="font-large-2 text-bold-300 blue-grey float-right">{{$dashboard->total_app}}</span>
                                    </div>
                                    <div class="clearfix">
                                        <span class="success float-right">Aplicaciones</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card bg-grey bg-lighten-2">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">CONVOCATORIAS ABIERTAS</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a href="{{action('PanelConvocatorias@Index')}}">Ver todas <i class="ft-arrow-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <section class="row p-2">
                    @foreach($dashboard->convocatorias as $item)
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card profile-card-with-cover box-shadow-2 mb-3">

                                <?php
                                if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->_key.'.jpg'))){
                                    $img = url('/convocatorias_pics/imagen_'.$item->_key.'.jpg');
                                }else{
                                    $img = url('/app-assets/images/carousel/22.jpg');
                                }
                                ?>

                                <div class="card-img-top img-fluid bg-cover height-200" style="background: url('{{$img}}?{{str_random(15)}}');background-position: center center !important;"></div>
                                <div class="card-profile-image">
                                    @if(isset($item->entidad_ext))
                                        @if(file_exists(public_path('/entidades_pics/imagen_'.$item->entidad_key.'.'.$item->entidad_ext)))
                                            <img src="{{url('/entidades_pics/imagen_'.$item->entidad_key.'.'.$item->entidad_ext)}}?{{str_random(15)}}" class="rounded-circle img-border height-100" />
                                        @else
                                            <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" class="rounded-circle img-border height-100" alt="" />
                                        @endif
                                    @else
                                        <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" class="rounded-circle img-border height-100" alt="" />
                                    @endif
                                </div>
                                <div class="profile-card-with-cover-content text-center">
                                    <div class="card-body pb-0 pt-0">
                                        <h4>{{$item->nombre}}</h4>
                                        <h6><span style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</span> - <span style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</span></h6>
                                        <small class="block"> {!! $item->descripcion_corta !!}</small>
                                    </div>
                                    <div class="card-body pb-0">
                                        <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->_key,'nombre'=>str_slug($item->nombre, '-')])}}" class="btn btn-outline-secondary btn-md btn-square mr-1 mb-1">
                                            <i class="fa fa-plus"></i> Ver Convocatoria
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

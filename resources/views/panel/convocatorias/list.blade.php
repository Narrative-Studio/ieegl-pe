@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Listado de Convocatorias @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{url("/")}}/app-assets/css/pages/users.css">
@endsection

@section('breadcrumb')
    <h3 class="content-header-title">CONVOCATORIAS</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
                <li class="breadcrumb-item active">Convocatorias</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if(count($convocatorias)>0)
        <section id="user-profile-cards-with-cover-image" class="row">
            @foreach($convocatorias as $item)
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
                                <a href="{{action('PanelConvocatorias@Ver',['id'=>$item->_key])}}" class="btn btn-outline-secondary btn-md btn-square mr-1 mb-1">
                                    <i class="fa fa-plus"></i> Ver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
                <div class="col-sm-12">
                    <div class="dataTables_paginate paging_full_numbers">
                        {!! $convocatorias->appends(['total' => (int)$total]+\Illuminate\Support\Facades\Input::except('page'))->render() !!}
                    </div>
                </div>
        </section>

    @else
        <div class="row">
            <div class="col-md-12">
                <div class="bs-callout-warning callout-border-left p-1">
                    <strong>Aún no tenemos Convocatorias</strong>
                    <h6 style="color: #6a569c;"><span style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_inicio_convocatoria)->formatLocalized('%d %B %Y')}}</span> - <span style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</span></h6>
                    <p>Muy pronto tendrémos convocatorias para que puedas aplicar tus Emprendimientos.</p>
                </div>
            </div>
        </div>
    @endif
@endsection
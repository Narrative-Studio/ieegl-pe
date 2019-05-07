@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Información @endsection

@section('breadcrumb')
    <h3 class="content-header-title">CONVOCATORIA {{$item->nombre}}</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action('PanelController@Index')}}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{action('PanelConvocatorias@Index')}}">Convocatorias</a></li>
                <li class="breadcrumb-item active">{{$item->nombre}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('breadright')
    <div class="media width-250 float-right">
        <div class="media-body media-right text-right">
            @if($item->activo=='Si')
                <h3 class="m-0 badge badge-default badge-success bg-light-green">ABIERTA</h3>
            @else
                <h3 class="m-0 badge badge-default badge-danger">CERRADA</h3>
            @endif
            <br><span class="text-muted">Status</span>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        function Aplicar(value){
            $('#form_emprendimiento').val(value);
            $('#form_aplicar').submit();
        }
    </script>
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
                                <div class="profile-image">
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
                            </div>
                            <div class="media-body pt-2 px-2">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="card-title">{{$item->entidad}}</h2>
                                        <small class="block">{{$item->entidad_desc}}</small>
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
                                                {!! Form::open(['action' => ['PanelConvocatorias@Aplicar', $item->_key], 'id'=>'form_aplicar','method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                                                <input type="hidden" name="emprendimiento" id="form_emprendimiento" value=""/>

                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn btn-success dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-check"></i> APLICAR
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 49px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        @foreach($emprendimientos as $k=>$v)
                                                            <a class="dropdown-item" href="javascript:;" onclick="Aplicar('{{$k}}')">{{$v}}</a>
                                                            <div class="dropdown-divider"></div>
                                                        @endforeach
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
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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
@endsection

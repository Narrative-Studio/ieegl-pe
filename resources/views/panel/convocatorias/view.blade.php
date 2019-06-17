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

@section('header')
    <meta content="Article" name="mediatype">
    <meta content="index,follow" name="robots">

    <meta property="og:title"              content="{{$item->nombre}}" />
    <meta property="og:description"        content="{!! $item->descripcion_corta !!}" />
    @if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->_key.'.jpg')))
    <meta property="og:image"              content="{{url('/convocatorias_pics/imagen_'.$item->_key.'.jpg')}}" />
    @endif
    <meta property="og:url"                content="{{action('PanelConvocatorias@Ver',['id'=>$item->_key,'nombre'=>str_slug($item->nombre, '-')])}}" />
    <!--<meta property="fb:app_id"             content="1426579487650492" />-->
    <meta property="og:type"               content="article" />
    <meta property="og:site_name"          content="Startup Identification" />
@endsection

@section('js')
    <script type="text/javascript">
        function Aplicar(value, nombre){
            $.ajax({
                method: "GET",
                url: "{{action('PanelConvocatorias@Aplicar',$item->_key)}}",
                data: { type: "json", emprendimiento: value},
                dataType: 'json'
            }).done(function(data) {
                console.log(data.puede_aplicar);
                if(data.puede_aplicar==false){
                    $("#errorModal #nombre").html(nombre);
                    $("#errorModal #mensaje").html(data.msg);
                    $("#errorModal").modal();
                }else{
                    $('#form_emprendimiento').val(value);
                    $('#form_aplicar').submit();
                }
            })
        }
    </script>
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5d017f294351e90012650636&product=inline-share-buttons' async='async'></script>
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
                        <div class="">
                            <div class="row">
                                <div class="col-md-9">
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
                                            <h2 class="card-title">{{$item->entidad}}</h2>
                                            <small class="block">{!! $item->descripcion_corta !!}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center text-md-right" style=" position: relative;top: 50%;-ms-transform: translateY(-50%);transform: translateY(-50%);z-index: 100;">

                                        @if($verificar==true)
                                            <div class="row mt-2">
                                                <div class="col-sm-12 text-center">
                                                    <button type="normal" class="btn btn-lg btn-grey mt-2" style="zoom: 1.5;" disabled="disabled"><i class="fa fa-close"></i> No puedes aplicar de nuevo a esta convocatoria</button>
                                                </div>
                                            </div>
                                        @else
                                            @if(auth()->user())
                                                @if($item->quien_key!='6375236')
                                                    {!! Form::open(['action' => ['PanelConvocatorias@Aplicar', $item->_key], 'id'=>'form_aplicar','method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                                                    <input type="hidden" name="emprendimiento" id="form_emprendimiento" value=""/>

                                                    <div class="btn-group mr-1 mb-1">
                                                        <button type="button" class="btn btn-success dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-check"></i> APLICAR
                                                        </button>
                                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 49px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            @if(count($emprendimientos)<1)
                                                                <a class="dropdown-item" href="{{action('PanelEmprendimientos@DatosGenerales')}}">Crear nuevo emprendimiento</a>
                                                            @else
                                                                @foreach($emprendimientos as $k=>$v)
                                                                    <a class="dropdown-item" href="javascript:;" onclick="Aplicar('{{$k}}','{{$v}}')">{{$v}}</a>
                                                                    @if(count($emprendimientos)>1)<div class="dropdown-divider"></div>@endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['action' => ['PanelConvocatorias@Aplicar', $item->_key], 'id'=>'form_aplicar','method'=>'POST', 'class'=>'form', 'files' => false]) !!}
                                                    <input type="hidden" name="emprendimiento" id="form_emprendimiento" value=""/>

                                                    <div class="btn-group mr-1 mb-1">
                                                        <button type="button" class="btn btn-success dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-check"></i> APLICAR
                                                        </button>
                                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 49px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            @if(count($emprendimientos)<1)
                                                                <a class="dropdown-item" href="{{action('PanelEmprendimientos@DatosGenerales')}}">Crear nuevo emprendimiento</a>
                                                            @else
                                                                @foreach($emprendimientos as $k=>$v)
                                                                    <a class="dropdown-item" href="javascript:;" onclick="Aplicar('{{$k}}','{{$v}}')">{{$v}}</a>
                                                                    @if(count($emprendimientos)>1)<div class="dropdown-divider"></div>@endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                @endif
                                            @else
                                                <div class="btn-group mr-1 mb-1">
                                                    <a href="{{route('login')}}" class="btn btn-success btn-lg">
                                                        <i class="fa fa-check"></i> APLICAR
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="mb-2 pr-1">
                            <div class="sharethis-inline-share-buttons"></div>
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

        <!-- Modal -->
        <div class="modal fade text-left" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel2"><i class="fa fa-road2"></i>No puedes aplicar</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Lo sentimos, no puedes aplicar con tu emprendimiento "<span class="text-bold-600" id="nombre"></span>" por esta razón:
                        <div class="alert alert-icon-left alert-arrow-left alert-warning alert-dismissible mt-1 font-small-3" role="alert">
                            <span class="alert-icon"><i class="fa fa-warning"></i></span>
                            <span id="mensaje"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

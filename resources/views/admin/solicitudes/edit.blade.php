@extends('layouts.admin')

@section('titulo') Solicitudes @endsection
@section('seccion') Solicitudes @endsection
@section('accion') Ver Aplicación @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.modal-body input, .modal-body select, .modal-body textarea').attr('disabled','disabled');
            $('.modal-body input[type="file"]').css('display','none');
            $('.modal-body input[type="checkbox"]').not(':checked').parent().parent().css('display','none');
            $('.modal-body input[type="radio"]').not(':checked').parent().parent().css('display','none');
            $('.modal-body input[type="radio"]:checked').css('display','none');

            @if(isset($item->lanzar_producto) && $item->lanzar_producto=="Si")
                $('#mas_ventas').removeClass('invisible');
            @endif

            @if(isset($item->realizado_ventas) &&  $item->realizado_ventas=="Si")
                $('#montos_ventas').removeClass('invisible');
            @endif
        })
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <h2>{{$solicitud->convocatoria->nombre}}</h2>
                                <div class="card-text">
                                    <p>{{$solicitud->convocatoria->descripcion}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="row">
                <div class="col-md-12 col-sm-12">
                    <div id="with-header" class="card">
                        <div class="card-content collapse show">
                            <div class="card-body border-top-blue-success border-top-lighten-5 ">

                                <ul class="list-group mb-0 card">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <small class="text-muted">Emprendimiento</small>
                                            <h3 class="">{{$solicitud->emprendimiento->nombre}}</h3>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Datos Generales</h5>
                                                <h6 class="pr-md-2">
                                                    <button type="button" class="btn btn-success btn-sm btn-modal" data-toggle="modal" data-target="DatosGenerales"><i class="fa fa-edit"></i> Ver Datos Generales</button>
                                                </h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Medios Digitales</h5>
                                                <h6 class="pr-md-2">
                                                    <button type="button" class="btn btn-success btn-sm btn-modal" data-toggle="modal" data-target="MediosDigitales"><i class="fa fa-edit"></i> Ver Medios Digitales</button>
                                                </h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Ventas</h5>
                                                <h6 class="pr-md-2">
                                                    <button type="button" class="btn btn-success btn-sm btn-modal" data-toggle="modal" data-target="Ventas"><i class="fa fa-edit"></i> Ver Ventas</button>
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Clientes</h5>
                                                <h6 class="pr-md-2">
                                                    <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Ver Datos Generales</a>
                                                </h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Usuarios</h5>
                                                <h6 class="pr-md-2">
                                                    <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Ver Datos Generales</a>
                                                </h6>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                                <h5>Info. Financiera</h5>
                                                <h6 class="pr-md-2">
                                                    <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Ver Datos Generales</a>
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
        {!! Form::model($solicitud,['action' => ['AdminSolicitudes@Save'], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
        {!! Form::hidden('id', $solicitud->_key) !!}
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Estatus <span class="required">*</span></label>
                        {!! Form::select('aprobado', [1=>'Pendiente',2=>'Rechazada', 3=>'Aprobada'], null, ['class'=> 'form-control select2 ']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Comentarios <span class="required">*</span></label>
                        {!! Form::textarea('comentarios', null, ['class'=> 'form-control', 'rows'=>3]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <input type="hidden" value="0" name="enviar" id="enviar">
                    <button type="submit" class="btn btn-lg btn-grey-blue" onclick="document.getElementById('enviar').value = '1'"><i class="fa fa-envelope"></i> Actualizar y Enviar Correo de Solicitud</button>
                    <button type="submit" class="btn btn-lg btn-blue"><i class="fa fa-save"></i> Actualizar Solicitud</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection



@section('modal')
    <!-- Modales -->
    <div class="modal fade text-left" id="DatosGenerales" tabindex="-1" role="dialog" aria-labelledby="tit1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tit1">Datos Generales</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model($item,['action' => 'AdminSolicitudes@Index', 'method' => 'get', 'files'=>'true']) !!}
                        @include('panel.emprendimientos.inc.datos-generales')
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="MediosDigitales" tabindex="-1" role="dialog" aria-labelledby="tit2" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tit2">Medios Digitales</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model($item,['action' => 'AdminSolicitudes@Index', 'method' => 'get', 'files'=>'true']) !!}
                    @include('panel.emprendimientos.inc.medios-digitales')
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="Ventas" tabindex="-1" role="dialog" aria-labelledby="tit3" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tit3">Ventas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model($item,['action' => 'AdminSolicitudes@Index', 'method' => 'get', 'files'=>'true']) !!}
                    @include('panel.emprendimientos.inc.ventas')
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

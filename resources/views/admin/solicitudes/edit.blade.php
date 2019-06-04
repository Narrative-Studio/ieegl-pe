@extends('layouts.admin')

@section('titulo') Solicitudes @endsection
@section('seccion') Solicitudes @endsection
@section('accion') Ver Aplicación @endsection

@section('js')
    <script type="text/javascript">
    </script>
@endsection

@section('content')

    {!! Form::model($solicitud,['action' => ['AdminSolicitudes@Save'], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
    {!! Form::hidden('id', $solicitud->_key) !!}

    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- project stats -->

            @if( $solicitud->convocatoria->quien!='6375236')
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
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6" >
                                    <h6><strong>Convocatoria:</strong></h6>
                                    <a href=# >{{$solicitud->convocatoria->nombre}}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4" >
                                    <h6><strong>Nombre del Emprendimiento:</strong></h6>
                                    <a href=# >{{$item->nombre}}</a>
                                </div>
                                <div class="col-sm-12 col-md-4" >
                                    <h6><strong>Fecha de Aplicación:</strong></h6>
                                    <p>{{date('d/m/Y H:m', $solicitud->fecha_registro)}}</p>
                                </div>
                                <div class="col-sm-12 col-md-4 text-right" >
                                    <h6><strong>Estatus de la Aplicación</strong></h6>
                                    @if($solicitud->aprobado==1) <h3 class="m-0 mb-2 badge badge-warning round">Por Revisar</h3> @endif
                                    @if($solicitud->aprobado==2) <h3 class="m-0 mb-2 badge badge-danger round">Rechazada</h3> @endif
                                    @if($solicitud->aprobado==3) <h3 class="m-0 mb-2 badge badge-info round">Aprobada</h3> @endif
                                    @if($solicitud->aprobado==4) <h3 class="m-0 mb-2 badge badge-success round" style="background-color: #ffd95d;">Pendiente de Pago</h3> @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sección 1 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">SECCIÓN 1</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 1:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 2:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 3:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 4:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 5:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 6:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ sección 1 -->
                <!-- Sección 2 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">SECCIÓN 2</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 1:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 2:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 3:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 4:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 5:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 6:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ sección 2 -->
                <!-- Sección 3 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">SECCIÓN 3</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 1:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 2:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 3:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 4:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>Campo 5:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Campo 6:</strong></h6>
                                    <p>Respuesta a Campo 1</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ sección 3 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Comentarios</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Estatus <span class="required">*</span></label>
                                        {!! Form::select('aprobado', [1=>'Pendiente', 4=>'Pendiente de Pago',2=>'Rechazada', 3=>'Aprobada'], null, ['class'=> 'form-control select2 ']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstName3">
                                            Comentarios :
                                            <span class="danger">*</span>
                                        </label>
                                        {!! Form::textarea('comentarios', null, ['class'=> 'form-control', 'rows'=>3]) !!}
                                    </div>
                                </div>
                            </div>
                            @if($solicitud->convocatoria->pago == true)
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Pagado <span class="required">*</span></label>
                                        <div class="row skin skin-flat">
                                            <div class="col-sm-1">
                                                <fieldset>
                                                    {!! Form::radio('pago', "Si", null, ['id'=>'f1', 'required'=>'required']); !!}
                                                    <label for="f1">Si</label>
                                                </fieldset>
                                            </div>
                                            <div class="col-sm-2">
                                                <fieldset>
                                                    {!! Form::radio('pago', "No", null, ['id'=>'f2', 'required'=>'required']); !!}
                                                    <label for="f2">No</label>
                                                </fieldset>
                                            </div>
                                        </div>
                                        @if ($errors->has('pago'))
                                            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('pago') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <input type="hidden" value="0" name="enviar" id="enviar">
                                    <button type="submit" class="btn btn-lg btn-grey-blue" onclick="document.getElementById('enviar').value = '1'"><i class="fa fa-envelope"></i> Actualizar y Enviar Correo de Solicitud</button>
                                    <button type="submit" class="btn btn-lg btn-blue"><i class="fa fa-save"></i> Actualizar Solicitud</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ sección 3 -->
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection

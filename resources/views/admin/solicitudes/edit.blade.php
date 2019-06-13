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
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-1">
                                <div class="col-sm-12 col-md-6" >
                                    <h6><strong>Convocatoria:</strong></h6>
                                    <a href="{{action('AdminConvocatorias@Edit', $solicitud->convocatoria->_key)}}">{{$solicitud->convocatoria->nombre}}</a>
                                </div>
                                <div class="col-sm-12 col-md-6 text-right" >
                                    <h6><strong>Estatus de la Aplicación</strong></h6>
                                    @if($solicitud->aprobado==1) <h3 class="m-0 mb-2 badge badge-warning round">Por Revisar</h3> @endif
                                    @if($solicitud->aprobado==4) <h3 class="m-0 mb-2 badge badge-info round" style="background-color: #ffd95d;">Pendiente</h3> @endif
                                    @if($solicitud->aprobado==2) <h3 class="m-0 mb-2 badge badge-danger round">Rechazada</h3> @endif
                                    @if($solicitud->aprobado==3) <h3 class="m-0 mb-2 badge badge-success round">Aprobada</h3> @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4" >
                                    <h6><strong>Nombre del Emprendimiento:</strong></h6>
                                    ({{$item->_key}}) {{$item->nombre}}
                                </div>
                                <div class="col-sm-12 col-md-5" >
                                    <h6><strong>Usuario:</strong></h6>
                                    <a href="{{action('AdminUsuarios@Edit', $solicitud->usuario->_key)}}">{{$solicitud->usuario->nombre}} {{$solicitud->usuario->apellidos}}</a> ({{$solicitud->usuario->email}})
                                </div>
                                <div class="col-sm-12 col-md-3 text-right" >
                                    <h6><strong>Fecha de Aplicación:</strong></h6>
                                    <p>{{date('d/m/Y H:m', $solicitud->fecha_registro)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sección 1 -->
                <?php $i = 0; ?>
                @foreach($solicitud->convocatoria->preguntas as $pregunta)
                    <?php $i++; ?>
                    @if($pregunta->tipo=='categorias')
                        @if($i>1) </div></div></div></div> @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$pregunta->nombre}}</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                    @else
                        <?php
                            switch ($pregunta->tipo){
                                case 'nueva':
                                    $campo = 'n_'.$pregunta->campo;
                                    break;
                                case 'catalogos':
                                    $campo = 'p_'.$pregunta->campo;
                                    break;
                                default:
                                    $campo = $pregunta->campo;
                                    break;
                            }
                            $preg = $preguntas_solicitud[$pregunta->tipo][$campo];
                            switch($pregunta->campo){
                                case 'industria_o_sector':
                                    $respuesta = \App\Http\Controllers\AdminSolicitudes::returnRespuestas($preg, $industrias);
                                    break;
                                case 'etapa_emprendimiento':
                                    $respuesta = $etapas[$preg];
                                    break;
                                case 'como_te_enteraste':
                                    $respuesta = $enteraste[$preg];
                                    break;
                                case 'pais':
                                    $respuesta = $paises[$preg];
                                    break;
                                case 'estado':
                                    $respuesta = $estados[$preg];
                                    break;
                                case 'campus':
                                    $respuesta = $campus[$preg];
                                    break;
                                default:
                                    if((is_array($preg))){
                                        $respuesta = (is_array($preg))?implode(', ',$preg):$preg;
                                    }else{
                                        if(preg_match_all('/\d{4}-\d{2}-\d{2}/m', $preg)){
                                            $respuesta = date('d/m/Y', strtotime($preg));
                                        }else{
                                            $respuesta = $preg;
                                        }
                                    }
                                    break;
                            }
                        ?>
                        <div class="col-md-6">
                            <h6><strong>{{$pregunta->nombre}}:</strong></h6>
                            <p>{{$respuesta}}</p>
                        </div>
                    @endif
                @endforeach
                </div></div></div></div>
                <div class="card datos-status">
                    <div class="card-header">
                        <h4 class="card-title">Datos de Status</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Estatus <span class="required">*</span></label>
                                        {!! Form::select('aprobado', [4=>'Pendiente',3=>'Aprobada',2=>'Rechazada'], null, ['class'=> 'form-control select2 ']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstName3">
                                            Comentarios para el emprendedor:
                                            <span class="danger">*</span>
                                        </label>
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
                        </div>
                    </div>
                </div>
                <!--/ sección 3 -->
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection

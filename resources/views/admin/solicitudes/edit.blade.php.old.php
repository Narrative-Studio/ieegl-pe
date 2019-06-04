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
                                <p>{!! $solicitud->convocatoria->descripcion_corta !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if( $solicitud->convocatoria->quien!='6375236')
        <section class="row">
            <div class="col-md-12 col-sm-12">
                <div id="with-header" class="card">
                    <div class="card-content collapse show">
                        <div class="card-body border-top-blue-success border-top-lighten-5 ">

                            <ul class="list-group mb-0 card">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <small class="text-muted">Emprendimiento</small>
                                        <h3 class="">{{$item->nombre}}</h3>
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
                                            <h5>Inversión</h5>
                                            <h6 class="pr-md-2">
                                                <button type="button" class="btn btn-success btn-sm btn-modal" data-toggle="modal" data-target="Inversion"><i class="fa fa-edit"></i> Ver Inversión</button>
                                            </h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div class="row" style="width: 100%;">
                                        <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                            <h5>Mercado</h5>
                                            <h6 class="pr-md-2">
                                                <button type="button" class="btn btn-success btn-sm btn-modal" data-toggle="modal" data-target="Mercado"><i class="fa fa-edit"></i> Ver Mercado</button>
                                            </h6>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                            <h5>Info. Financiera</h5>
                                            <h6 class="pr-md-2">
                                                <button type="button" class="btn btn-success btn-sm btn-modal" data-toggle="modal" data-target="Financiera"><i class="fa fa-edit"></i> Ver Inversión</button>
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
        @endif
    </div>
    {!! Form::model($solicitud,['action' => ['AdminSolicitudes@Save'], 'method'=>'POST', 'class'=>'form', 'files' => false]) !!}
    {!! Form::hidden('id', $solicitud->_key) !!}
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
                <label for="">Comentarios <span class="required">*</span></label>
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
    {!! Form::close() !!}
</div>
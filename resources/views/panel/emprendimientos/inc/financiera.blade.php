<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Fecha de fundación de tu emprendimiento <span class="required">*</span></label>
                <?php $class=($errors->has('fecha_fundacion'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::date('fecha_fundacion', null, ['class'=>$class]); !!}
                @if ($errors->has('fecha_fundacion'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fundacion') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Ya lanzaste tu producto/servicio al mercado? <span class="required">*</span></label>
                <?php $class=($errors->has('lanzar_producto'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('lanzar_producto', "Si", null, ['id'=>'l1', 'class'=>'lanzar '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('lanzar_producto', "No", null, ['id'=>'l2', 'class'=>'lanzar '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('lanzar_producto'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('lanzar_producto') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div id="mas_ventas" class="invisible">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿En qué fecha lanzaste tu producto/servicio? <span class="required">*</span></label>
                    <?php $class=($errors->has('fecha_lanzamiento'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::date('fecha_lanzamiento', null, ['class'=>$class]); !!}
                    @if ($errors->has('fecha_lanzamiento'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_lanzamiento') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Tienes una Patente o IP de tu producto o servicio? <span class="required">*</span></label>
                    <?php $class=($errors->has('patente_ip'))?'form-control is-invalid':'form-control'; ?>
                    <div class="row skin skin-flat">
                        <div class="col-sm-1">
                            <fieldset>
                                {!! Form::radio('patente_ip', "Si", null, ['id'=>'pat1', 'class'=>'lanzar '.$class]); !!}
                                <label for="pat1">Si</label>
                            </fieldset>
                        </div>
                        <div class="col-sm-2">
                            <fieldset>
                                {!! Form::radio('patente_ip', "No", null, ['id'=>'pat2', 'class'=>'lanzar '.$class]); !!}
                                <label for="pat2">No</label>
                            </fieldset>
                        </div>
                    </div>
                    @if ($errors->has('patente_ip'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('patente_ip') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $class=($errors->has('modelo_ventas'))?'is-invalid':''; ?>
                <div class="form-group {{$class}}">
                    <label for="">Modelo de Ventas de tu Emprendimiento <span class="required">*</span></label>
                    <?php $class=($errors->has('modelo_ventas'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::select('modelo_ventas', $modelos_ventas, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class, 'id'=>'modelo_ventas']) !!}
                    @if ($errors->has('modelo_ventas'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('modelo_ventas') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label for="">Adjunta la Cédula de Identificación Fiscal de tu Startup <small>(si aplica)</small></label>
                    <div class="row">
                        <div class="col-md-4">
                            @if(isset($item->_key))
                                @if(file_exists(public_path('/emprendimientos_pics/cedula_'.$item->_key.'.jpg')))
                                    <img src="{{url('/emprendimientos_pics/cedula_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="120" height="120" border="0" alt=""  class="rounded img-fluid" data-action="zoom"  />
                                @else
                                    <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                                @endif
                            @endif
                        </div>
                        <div class="col-md-8">
                            <input type='file' name="cedula_identificacion" id="" accept=".jpg, .jpeg" />
                            @if ($errors->has('cedula_identificacion'))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('cedula_identificacion') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Has realizado ventas? <span class="required">*</span></label>
                    <?php $class=($errors->has('realizado_ventas'))?'form-control is-invalid':'form-control'; ?>
                    <div class="row skin skin-flat">
                        <div class="col-sm-1">
                            <fieldset>
                                {!! Form::radio('realizado_ventas', "Si", null, ['id'=>'v1', 'class'=>'ventas '.$class]); !!}
                                <label for="v1">Si</label>
                            </fieldset>
                        </div>
                        <div class="col-sm-2">
                            <fieldset>
                                {!! Form::radio('realizado_ventas', "No", null, ['id'=>'v2', 'class'=>'ventas '.$class]); !!}
                                <label for="v2">No</label>
                            </fieldset>
                        </div>
                    </div>
                    @if ($errors->has('realizado_ventas'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('realizado_ventas') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div  id="montos_ventas" class="invisible">
            <div class="row mb-2 mt-2">
                <div class="col-sm-12">
                    <h2>Información de Ventas</h2>
                    <p>Captura la siguiente información para el período solicitado:</p>
                </div>
            </div>
            <!-- Meses de montos -->
            <div class="row">
                <div class="@if(count($meses)>1) col-md-6 @else col-md-12 @endif">
                    <?php $i = 0;?>
                    @foreach($meses as $year=>$months)
                        @include('panel.emprendimientos.inc.tabla-montos')
                    @endforeach
                </div>
            </div>
            <!--/ Meses de montos -->
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="">Indica cuánto es el gasto mensual de tu emprendimiento (USD) </label>
                    <?php $class=($errors->has("gasto_mensual"))?'form-control is-invalid':'form-control'; ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('gasto_mensual', (isset($item->gasto_mensual))?$item->gasto_mensual:0, ['class'=>'money '.$class, 'value'=>'0']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>
                    @if ($errors->has('gasto_mensual'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('gasto_mensual') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="">Actualmente, ¿tu emprendimiento pierde dinero? indica cuánto (USD) </label>
                    <?php $class=($errors->has("pierde_dinero"))?'form-control is-invalid':'form-control'; ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('pierde_dinero', (isset($item->pierde_dinero))?$item->pierde_dinero:0, ['class'=>'money '.$class, 'value'=>'0']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>
                    @if ($errors->has('pierde_dinero'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('pierde_dinero') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Alguno de tus socios ha tenido un "exit" o ha venido de una empresa? <span class="required">*</span></label>
                    <?php $class=($errors->has('socio_exit_empresa'))?'form-control is-invalid':'form-control'; ?>
                    <div class="row skin skin-flat">
                        <div class="col-sm-1">
                            <fieldset>
                                {!! Form::radio('socio_exit_empresa', "Si", null, ['id'=>'socio1', 'class'=>$class]); !!}
                                <label for="socio1">Si</label>
                            </fieldset>
                        </div>
                        <div class="col-sm-2">
                            <fieldset>
                                {!! Form::radio('socio_exit_empresa', "No", null, ['id'=>'socio2', 'class'=>$class]); !!}
                                <label for="socio2">No</label>
                            </fieldset>
                        </div>
                    </div>
                    @if ($errors->has('socio_exit_empresa'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('socio_exit_empresa') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
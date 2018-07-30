<div class="form-body">
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
                    <div class="col-sm-1">
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
                    <label for="">¿En qué fecha? <span class="required">*</span></label>
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
                        <div class="col-sm-1">
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
                    <p>Capture la siguiente información para el período solicitado:</p>
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
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="" class="">Cual fué la venta total de tu emprendimiento el año pasado <small>(si aplica)</small></label>
                        <?php $class=($errors->has("venta_total_año_pasado"))?'form-control is-invalid':'form-control'; ?>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            {!! Form::text('venta_total_año_pasado', (isset($item->venta_total_año_pasado))?$item->venta_total_año_pasado:0, ['class'=>'money '.$class]); !!}
                            <div class="input-group-append">
                                <span class="input-group-text">USD</span>
                            </div>
                        </div>
                        @if ($errors->has('venta_total_año_pasado'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('venta_total_año_pasado') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
            <!--/ Meses de montos -->
        </div>
    </div>
</div>
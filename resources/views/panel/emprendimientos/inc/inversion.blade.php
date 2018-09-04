<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Tienes socios operadores? <span class="required">*</span></label>
                <?php $class=($errors->has('socios_operadores'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('socios_operadores', "Si", null, ['id'=>'so1', 'class'=>'socios_operadores '.$class]); !!}
                            <label for="so1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('socios_operadores', "No", null, ['id'=>'so2', 'class'=>'socios_operadores '.$class]); !!}
                            <label for="so2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('socios_operadores'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('socios_operadores') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Los socios operadores, ¿han invertido capital?  <span class="required">*</span></label>
                <?php $class=($errors->has('invertido_capital'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('invertido_capital', "Si", null, ['id'=>'l1', 'class'=>'invertido_capital '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('invertido_capital', "No", null, ['id'=>'l2', 'class'=>'invertido_capital '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('invertido_capital'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('invertido_capital') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div id="montos_ventas_inversion" class="invisible">
        <div class="row mb-2 mt-2">
            <div class="col-sm-12">
                <h2>Información de Capital</h2>
                <p>¿Cuánto capital ($USD) ha invertido cada uno de ellos y cuándo?</p>
            </div>
        </div>
        <!-- Inversion Socios -->
        <div class="row repetir1">
            <div class="col-sm-12">
                <div class="repeater-default">
                    <div data-repeater-list="capital">
                        <div data-repeater-item>
                            <div class="row">
                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label>Socio <span class="required">*</span></label>
                                    <br>
                                    {!! Form::text('socio', null, ['class'=>'form-control']); !!}
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label>Año <span class="required">*</span></label>
                                    <br>
                                    {!! Form::text('year', null, ['class'=>'form-control integer']); !!}
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label>Mes <span class="required">*</span></label>
                                    <br>
                                    {!! Form::select('mes', $meses_inversion, null, ['class'=>'form-control', 'style'=>'text-transform:capitalize;']); !!}
                                </div>
                                <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3">
                                    <label>Monto (USD) <span class="required">*</span></label>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        {!! Form::text('monto', null, ['class'=>'money form-control']); !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text">USD</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                    <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Remover</button>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="form-group overflow-hidden">
                        <div class="">
                            <button type="button" data-repeater-create class="btn btn-primary">
                                <i class="ft-plus"></i> Agregar otro Socio
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Inversion Socios -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for=""> ¿Haz levantado capital? <span class="required">*</span></label>
                <?php $class=($errors->has('levantado_capital'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('levantado_capital', "Si", null, ['id'=>'l1', 'class'=>'levantado_capital '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('levantado_capital', "No", null, ['id'=>'l2', 'class'=>'levantado_capital '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('levantado_capital'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('levantado_capital') }}</strong></span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for=""> ¿Haz recibido inversión? <span class="required">*</span></label>
                <?php $class=($errors->has('recibido_inversion'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('recibido_inversion', "Si", null, ['id'=>'re1', 'class'=>'recibido_inversion '.$class]); !!}
                            <label for="re1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('recibido_inversion', "No", null, ['id'=>'re2', 'class'=>'recibido_inversion '.$class]); !!}
                            <label for="re2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('recibido_inversion'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('recibido_inversion') }}</strong></span>
                @endif
            </div>
        </div>
    </div>

    <div id="recibir_inversion" class="invisible">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿De quién? <span class="required">*</span></label>
                    <?php $class=($errors->has('recibido_inversion_dequien'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::text('recibido_inversion_dequien', null, ['class'=>$class]); !!}
                    @if ($errors->has('recibido_inversion_dequien'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('recibido_inversion_dequien') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">¿Cuánto? (USD)</label>
                    <?php $class=($errors->has('recibido_inversion_cuanto'))?'form-control is-invalid':'form-control'; ?>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('recibido_inversion_cuanto', null, ['class'=>'money2 form-control']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>

                    @if ($errors->has('recibido_inversion_cuanto'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('recibido_inversion_cuanto') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Cómo? <span class="required">*</span><small>Selecciona todos los que correspondan.</small></label>
                    <div class="row skin skin-flat col-sm-12">
                        @foreach($vehiculos as $key=>$val)
                            <div class="radio_input">
                                <fieldset>
                                    {!! Form::checkbox('recibido_inversion_como[]', $key, null, ['id'=>'reci_'.$key, 'class'=>'form-control']); !!}
                                    <label for="reci_{{$key}}">{{$val}}</label>
                                </fieldset>
                            </div>
                        @endforeach
                    </div>
                    @if ($errors->has('recibido_inversion_como'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('recibido_inversion_como') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Indica la fecha última en la que levantaron capital <span class="required">*</span></label>
                    <?php $class=($errors->has('recibido_inversion_fecha_levantaron_capital'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::date('recibido_inversion_fecha_levantaron_capital', null, ['class'=>$class]); !!}
                    @if ($errors->has('recibido_inversion_fecha_levantaron_capital'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('recibido_inversion_fecha_levantaron_capital') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Qué vehículo de inversión utilizaste? <span class="required">*</span><small>Selecciona todos los que correspondan.</small></label>
                    <div class="row skin skin-flat col-sm-12">
                        @foreach($vehiculos as $key=>$val)
                            <div class="radio_input">
                                <fieldset>
                                    {!! Form::checkbox('recibido_inversion_vehiculo[]', $key, null, ['id'=>'reci_veh_'.$key, 'class'=>'form-control']); !!}
                                    <label for="reci_veh_{{$key}}">{{$val}}</label>
                                </fieldset>
                            </div>
                        @endforeach
                    </div>
                    @if ($errors->has('recibido_inversion_vehiculo'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('recibido_inversion_vehiculo') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Actualmente estás buscando capital? <span class="required">*</span></label>
                <?php $class=($errors->has('buscando_capital'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('buscando_capital', "Si", null, ['id'=>'l1', 'class'=>'buscando_capital '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('buscando_capital', "No", null, ['id'=>'l2', 'class'=>'buscando_capital '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('buscando_capital'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('buscando_capital') }}</strong></span>
                @endif
            </div>
        </div>
    </div>

    <div id="buscar_capital" class="invisible">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">¿Cuánto capital estás buscando? (USD) <span class="required">*</span></label>
                    <?php $class=($errors->has('capital_cuanto'))?'form-control is-invalid':'form-control'; ?>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('capital_cuanto', null, ['class'=>'money2 form-control']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>

                    @if ($errors->has('capital_cuanto'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('capital_cuanto') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Con qué vehículo de inversión buscas capital? <span class="required">*</span></label>
                    <div class="row skin skin-flat col-sm-12">
                        @foreach($vehiculos as $key=>$val)
                            <div class="radio_input">
                                <fieldset>
                                    {!! Form::checkbox('vehiculo_inversion[]', $key, null, ['id'=>'vehiculo_'.$key, 'class'=>'form-control']); !!}
                                    <label for="vehiculo_{{$key}}">{{$val}}</label>
                                </fieldset>
                            </div>
                        @endforeach
                    </div>
                    @if ($errors->has('vehiculo_inversion'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('vehiculo_inversion') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
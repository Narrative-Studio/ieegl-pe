<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for=""> ¿Has levantado capital? <span class="required">*</span></label>
                <?php $class=($errors->has('levantado_capital'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-2">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si has levandato capital, ¿Cuánto ha sido? (USD)</label>
                <?php $class=($errors->has('recibido_capital_cuanto'))?'form-control is-invalid':'form-control'; ?>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    {!! Form::text('recibido_capital_cuanto', null, ['class'=>'money2 form-control']); !!}
                    <div class="input-group-append">
                        <span class="input-group-text">USD</span>
                    </div>
                </div>

                @if ($errors->has('recibido_capital_cuanto'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('recibido_capital_cuanto') }}</strong></span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for=""> ¿Has recibido inversión? <span class="required">*</span></label>
                <?php $class=($errors->has('recibido_inversion'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-2">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si has recibido inversión, ¿Cuánto ha sido? (USD)</label>
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

    <div class="row ">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Actualmente estás buscando capital? <span class="required">*</span></label>
                <?php $class=($errors->has('buscando_capital'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-2">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si estas buscando capital, ¿Cuánto capital estás buscando? (USD)</label>
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
</div>
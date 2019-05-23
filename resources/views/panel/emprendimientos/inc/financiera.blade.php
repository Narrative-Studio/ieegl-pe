<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Ya lanzaste tu producto/servicio al mercado? <span class="required">*</span></label>
                <?php $class=($errors->has('lanzar_producto'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-2">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si ya lanzaste tu producto, ¿En qué fecha fue? <span class="required">*</span></label>
                <?php $class=($errors->has('fecha_lanzamiento'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::date('fecha_lanzamiento', null, ['class'=>$class]); !!}
                @if ($errors->has('fecha_lanzamiento'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_lanzamiento') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Tienes una Patente o IP de tu producto o servicio? <span class="required">*</span></label>
                    <?php $class=($errors->has('patente_ip'))?'form-control is-invalid':'form-control'; ?>
                    <div class="row skin skin-flat">
                        <div class="col-sm-2">
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
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Has tenido ventas? <span class="required">*</span></label>
                    <?php $class=($errors->has('realizado_ventas'))?'form-control is-invalid':'form-control'; ?>
                    <div class="row skin skin-flat">
                        <div class="col-sm-2">
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
        <label for="" class="">Si ya has tenido ventas, ¿cuánto ha sido en los últimos 3 meses? (USD)</label>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes 1</label>
                    <?php $class=($errors->has('mes1'))?'form-control is-invalid':'form-control'; ?>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('mes1', null, ['class'=>'money2 form-control']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>

                    @if ($errors->has('mes1'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mes1') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes 2</label>
                    <?php $class=($errors->has('mes2'))?'form-control is-invalid':'form-control'; ?>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('mes2', null, ['class'=>'money2 form-control']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>

                    @if ($errors->has('mes2'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mes2') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes 3</label>
                    <?php $class=($errors->has('mes3'))?'form-control is-invalid':'form-control'; ?>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        {!! Form::text('mes3', null, ['class'=>'money2 form-control']); !!}
                        <div class="input-group-append">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>

                    @if ($errors->has('mes3'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mes3') }}</strong></span>
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
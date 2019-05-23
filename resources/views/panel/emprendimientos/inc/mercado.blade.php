<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Tienes clientes? <span class="required">*</span></label>
                <?php $class=($errors->has('tiene_clientes'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('tiene_clientes', "Si", null, ['id'=>'l1', 'class'=>'tiene_clientes '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('tiene_clientes', "No", null, ['id'=>'l2', 'class'=>'tiene_clientes '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('tiene_clientes'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('tiene_clientes') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="">Si tienes clientes, ¿Cuántos están activos en tu emprendimiento? </label>
                <?php $class=($errors->has("clientes_activos"))?'form-control is-invalid':'form-control'; ?>
                <div class="input-group">
                    {!! Form::number('clientes_activos', null, ['class'=>$class, 'value'=>'0', 'min'=>0]); !!}
                </div>
                @if ($errors->has('clientes_activos'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('clientes_activos') }}</strong></span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Tienes usuarios? <span class="required">*</span></label>
                <?php $class=($errors->has('tiene_usuarios'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('tiene_usuarios', "Si", null, ['id'=>'l1', 'class'=>'tiene_usuarios '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('tiene_usuarios', "No", null, ['id'=>'l2', 'class'=>'tiene_usuarios '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('tiene_usuarios'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('tiene_usuarios') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="">Si tienes usuarios, ¿Cuántos están activos en tu emprendimiento? </label>
                <?php $class=($errors->has("usuarios_activos"))?'form-control is-invalid':'form-control'; ?>
                <div class="input-group">
                    {!! Form::number('usuarios_activos', null, ['class'=>$class, 'value'=>'0', 'min'=>0]); !!}
                </div>
                @if ($errors->has('usuarios_activos'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('usuarios_activos') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
</div>
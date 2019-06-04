<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Tienes clientes? <span class="required">*</span></label>
                <?php $class=($errors->has('tiene_clientes'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.tiene_clientes', ['campo'=>'tiene_clientes','value'=>($item)?$item->tiene_clientes:''])
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
                    @include('panel.emprendimientos.campos.clientes_activos', ['campo'=>'clientes_activos','value'=>($item)?$item->clientes_activos:''])
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
                @include('panel.emprendimientos.campos.tiene_usuarios', ['campo'=>'tiene_usuarios','value'=>($item)?$item->tiene_usuarios:''])
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
                    @include('panel.emprendimientos.campos.usuarios_activos', ['campo'=>'usuarios_activos','value'=>($item)?$item->usuarios_activos:''])
                </div>
                @if ($errors->has('usuarios_activos'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('usuarios_activos') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
</div>
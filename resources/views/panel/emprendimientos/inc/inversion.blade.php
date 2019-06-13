<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for=""> ¿Has levantado capital? <span class="required">*</span></label>
                <?php $class=($errors->has('levantado_capital'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.levantado_capital', ['campo'=>'levantado_capital','value'=>(isset($item->levantado_capital))?$item->levantado_capital:''])
                @if ($errors->has('levantado_capital'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('levantado_capital') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si has levandato capital, ¿Cuánto ha sido? (USD)</label>
                <?php $class=($errors->has('recibido_capital_cuanto'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.recibido_capital_cuanto', ['campo'=>'recibido_capital_cuanto','value'=>(isset($item->recibido_capital_cuanto))?$item->recibido_capital_cuanto:''])
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
                @include('panel.emprendimientos.campos.recibido_inversion', ['campo'=>'recibido_inversion','value'=>(isset($item->recibido_inversion))?$item->recibido_inversion:''])
                @if ($errors->has('recibido_inversion'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('recibido_inversion') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si has recibido inversión, ¿Cuánto ha sido? (USD)</label>
                <?php $class=($errors->has('recibido_inversion_cuanto'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.recibido_inversion_cuanto', ['campo'=>'recibido_inversion_cuanto','value'=>(isset($item->recibido_inversion_cuanto))?$item->recibido_inversion_cuanto:''])
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
                @include('panel.emprendimientos.campos.buscando_capital', ['campo'=>'buscando_capital','value'=>(isset($item->buscando_capital))?$item->buscando_capital:''])
                @if ($errors->has('buscando_capital'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('buscando_capital') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si estas buscando capital, ¿Cuánto capital estás buscando? (USD)</label>
                <?php $class=($errors->has('capital_cuanto'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.capital_cuanto', ['campo'=>'capital_cuanto','value'=>(isset($item->capital_cuanto))?$item->capital_cuanto:''])
                @if ($errors->has('capital_cuanto'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('capital_cuanto') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
</div>
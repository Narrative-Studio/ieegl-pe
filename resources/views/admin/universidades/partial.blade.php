<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">Nombre</label>
    <div class="col-md-6 col-xs-12">
        <?php $class=($errors->has('nombre'))?'form-control error':'form-control'; ?>
        {!! Form::text('nombre', (isset($item))?$item->nombre:old('nombre'), ['class' => $class]) !!}
    </div>
</div>
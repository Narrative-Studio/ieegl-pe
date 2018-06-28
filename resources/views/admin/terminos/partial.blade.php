<div class="form-group row">
    <label class="col-md-2 label-control">Nombre</label>
    <div class="col-md-10">
        <?php $class=($errors->has('nombre'))?'form-control error':'form-control'; ?>
        {!! Form::text('nombre', null, ['class' => $class]) !!}
    </div>
</div>
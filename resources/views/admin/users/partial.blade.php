<div class="form-group row">
    <label class="col-md-2 label-control">Nombre</label>
    <div class="col-md-10">
        <?php $class=($errors->has('nombre'))?'form-control error':'form-control'; ?>
        {!! Form::text('nombre', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Apellidos</label>
    <div class="col-md-10">
        <?php $class=($errors->has('apellidos'))?'form-control error':'form-control'; ?>
        {!! Form::text('apellidos', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Correo</label>
    <div class="col-md-10">
        <?php $class=($errors->has('email'))?'form-control error':'form-control'; ?>
        {!! Form::text('email', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Telefono</label>
    <div class="col-md-10">
        <?php $class=($errors->has('telefono'))?'form-control error':'form-control'; ?>
        {!! Form::text('telefono', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Validado</label>
    <div class="col-md-10">
        <?php $class=($errors->has('validated'))?'form-control error':'form-control'; ?>
        {!! Form::checkbox('validated', 1, null, ['class' => 'switch', 'data-group-cls'=>"btn-group-sm"]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Activo</label>
    <div class="col-md-10">
        <?php $class=($errors->has('active'))?'form-control error':'form-control'; ?>
            {!! Form::checkbox('active', 1, null, ['class' => 'switch', 'data-group-cls'=>"btn-group-sm"]) !!}
    </div>
</div>
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
<?php $class=($errors->has('rol_id'))?'is-invalid':''; ?>
<div class="form-group {{$class}} row">
    <label class="col-md-2 label-control" for="">Rol <span class="required">*</span></label>
    <div class="col-md-10">
        <?php $class=($errors->has('rol_id'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::select('rol_id', $roles, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class]) !!}
        @if ($errors->has('rol_id'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('rol_id') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Activo</label>
    <div class="col-md-10">
        <?php $class=($errors->has('active'))?'form-control error':'form-control'; ?>
            {!! Form::checkbox('active', 1, null, ['class' => 'switch', 'data-group-cls'=>"btn-group-sm"]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Password</label>
    <div class="col-md-10">
        <?php $class=($errors->has('password'))?'form-control error':'form-control'; ?>
        {!! Form::text('password', '', ['class' => $class, 'type'=>'password']) !!}
    </div>
</div>
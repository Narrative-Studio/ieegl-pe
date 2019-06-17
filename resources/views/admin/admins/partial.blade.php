<div class="form-group row">
    <label class="col-md-2 label-control">Nombre <span class="required">*</span></label>
    <div class="col-md-10">
        <?php $class=($errors->has('nombre'))?'form-control error':'form-control'; ?>
        {!! Form::text('nombre', null, ['class' => $class, 'autocomplete'=>'off']) !!}
        @if ($errors->has('nombre'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('nombre') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Apellidos <span class="required">*</span></label>
    <div class="col-md-10">
        <?php $class=($errors->has('apellidos'))?'form-control error':'form-control'; ?>
        {!! Form::text('apellidos', null, ['class' => $class, 'autocomplete'=>'off']) !!}
        @if ($errors->has('apellidos'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('apellidos') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Correo <span class="required">*</span></label>
    <div class="col-md-10">
        <?php $class=($errors->has('email'))?'form-control error':'form-control'; ?>
        @if(!isset($item->_key))
            {!! Form::text('email', null, ['class' => $class, 'autocomplete'=>'nope']) !!}
        @else
            {!! Form::text('email', null, ['class' => $class, 'autocomplete'=>'nope', 'disabled'=>'disabled', 'readonly'=>'readonly']) !!}
        @endif
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
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
    <label class="col-md-2 label-control">Activo <span class="required">*</span></label>
    <div class="col-md-10">
        <?php $class=($errors->has('active'))?'form-control error':'form-control'; ?>
        {!! Form::checkbox('active', 1, null, ['class' => 'switch', 'data-group-cls'=>"btn-group-sm"]) !!}
        @if ($errors->has('active'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('active') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Password <span class="required">*</span></label>
    <div class="col-md-10">
        <?php $class=($errors->has('password'))?'form-control error':'form-control'; ?>
        {!! Form::text('password', '', ['class' => $class, 'type'=>'password', 'autocomplete'=>'off']) !!}
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
    </div>
</div>
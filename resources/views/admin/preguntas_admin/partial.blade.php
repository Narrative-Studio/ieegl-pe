<div class="form-group row">
    <label class="col-md-2 label-control">Pregunta</label>
    <div class="col-md-10">
        <?php $class=($errors->has('pregunta'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::text('pregunta', null, ['class' => $class]) !!}
        @if ($errors->has('pregunta'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('pregunta') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Descripción del campo</label>
    <div class="col-md-10">
        <?php $class=($errors->has('descripcion'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::text('descripcion', null, ['class' => $class]) !!}
    </div>
</div>
<?php $class=($errors->has('categoria'))?'is-invalid':''; ?>
<div class="form-group {{$class}} row">
    <label class="col-md-2 label-control">Categoría</label>
    <div class="col-md-10">
        <?php $class=($errors->has('categoria'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::select('categoria', $categorias, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class, 'id'=>'categoria']) !!}
        @if ($errors->has('categoria'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('categoria') }}</strong></span>
        @endif
    </div>
</div>
<?php $class=($errors->has('tipo'))?'is-invalid':''; ?>
<div class="form-group {{$class}} row">
    <label class="col-md-2 label-control">Tipo</label>
    <div class="col-md-10">
        <?php $class=($errors->has('tipo'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::select('tipo', ['text'=>'Texto','combo'=>'Combo','multiple'=>'Multiple','textarea'=>'Textarea'], null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class, 'id'=>'tipo']) !!}
        @if ($errors->has('tipo'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('tipo') }}</strong></span>
        @endif
    </div>
</div>
<div id="respuestas" style="display: @if(isset($item->_key)) @if($item->tipo=='combo' || $item->tipo=='multiple') block @else none @endif @else none @endif">
    <div class="form-group row">
        <label class="col-md-2 label-control">Respuestas</label>
        <div class="col-md-10">
            <small>Respuesta por renglón</small>
            <?php $class=($errors->has('respuestas'))?'form-control is-invalid':'form-control'; ?>
            {!! Form::textarea('respuestas', null, ['class'=> $class]) !!}
            @if ($errors->has('respuestas'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('respuestas') }}</strong></span>
            @endif
        </div>
    </div>
</div>
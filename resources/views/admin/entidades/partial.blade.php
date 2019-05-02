<div class="form-group row">
    <label class="col-md-2 label-control">Nombre</label>
    <div class="col-md-10">
        <?php $class=($errors->has('nombre'))?'form-control error':'form-control'; ?>
        {!! Form::text('nombre', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Descripción</label>
    <div class="col-md-10">
        <?php $class=($errors->has('descripcion'))?'form-control error':'form-control'; ?>
        {!! Form::textarea('descripcion', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Imagen</label>
    <div class="col-md-10">
        @if(isset($item->ext))
            @if(file_exists(public_path('/entidades_pics/imagen_'.$item->_key.'.'.$item->ext)))
                <img src="{{url('/entidades_pics/imagen_'.$item->_key.'.'.$item->ext)}}?{{str_random(15)}}" width="120" height="" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
            @else
                <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
            @endif
        @endif
        <input type='file' name="imagen" id="" accept=".jpg, .jpeg, .png, gif" style="margin-top: 20px; display: block;" class="" />
        @if ($errors->has('imagen'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('imagen') }}</strong></span>
        @endif
    </div>
</div>
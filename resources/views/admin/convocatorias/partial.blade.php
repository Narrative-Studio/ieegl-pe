<h4 class="form-section"><i class="ft-command"></i> Información General</h4>
<div class="form-group row">
    <label class="col-md-4 label-control">Nombre</label>
    <div class="col-md-8">
        <?php $class=($errors->has('nombre'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::text('nombre', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control">Descripción corta</label>
    <div class="col-md-8">
        <?php $class=($errors->has('descripcion_corta'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::textarea('descripcion_corta', null, ['class' => 'tinymce '.$class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control">Descripción</label>
    <div class="col-md-8">
        <?php $class=($errors->has('descripcion'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::textarea('descripcion', null, ['class' => 'tinymce '.$class]) !!}
    </div>
</div>
<?php $class=($errors->has('entidad'))?'is-invalid':''; ?>
<div class="form-group {{$class}} row">
    <label class="col-md-4 label-control" for="">¿Quién convoca? <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('entidad'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::select('entidad', $entidades, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class]) !!}
        @if ($errors->has('entidad'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('entidad') }}</strong></span>
        @endif
    </div>
</div>
<?php $class=($errors->has('quien'))?'is-invalid':''; ?>
<div class="form-group {{$class}} row">
    <label class="col-md-4 label-control"  for="">¿Quién puede aplicar? <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('quien'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::select('quien', $quien, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class]) !!}
        @if ($errors->has('quien'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('quien') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">Fecha inicio período convocatoria <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('fecha_inicio_convocatoria'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::date('fecha_inicio_convocatoria', (isset($item))?date('Y-m-d', $item->fecha_inicio_convocatoria):null, ['class'=>$class]); !!}
        @if ($errors->has('fecha_inicio_convocatoria'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_inicio_convocatoria') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control"  for="">Fecha fin de convocatoria <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('fecha_fin_convocatoria'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::date('fecha_fin_convocatoria', (isset($item))?date('Y-m-d', $item->fecha_fin_convocatoria):null, ['class'=>$class]); !!}
        @if ($errors->has('fecha_fin_convocatoria'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fin_convocatoria') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control"  for="">Fecha inicial del evento <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('fecha_inicio_evento'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::date('fecha_inicio_evento', (isset($item))?date('Y-m-d', $item->fecha_inicio_evento):null, ['class'=>$class]); !!}
        @if ($errors->has('fecha_inicio_evento'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_inicio_evento') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control"  for="">Fecha final del evento <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('fecha_fin_evento'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::date('fecha_fin_evento', (isset($item))?date('Y-m-d', $item->fecha_fin_evento):null, ['class'=>$class]); !!}
        @if ($errors->has('fecha_fin_evento'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fin_evento') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">Imagen/Banner que acompaña a la convocatoria <span class="required">*</span></label>
    <div class="col-md-8">
        @if(isset($item->_key))
            @if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->_key.'.jpg')))
                <img src="{{url('/convocatorias_pics/imagen_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="400" height="" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
            @else
                <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
            @endif
        @endif
        <input type='file' name="imagen" id="" accept=".jpg, .jpeg" style="margin-top: 20px; display: block;" />
        @if ($errors->has('imagen'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('imagen') }}</strong></span>
        @endif
        <hr/>
    </div>
</div>
<?php $class=($errors->has('responsable'))?'is-invalid':''; ?>
<div class="form-group {{$class}} row">
    <label class="col-md-4 label-control" for="">Responsable Interno de la Convocatoria <span class="required">*</span></label>
    <div class="col-md-8">
        <?php $class=($errors->has('responsable'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::select('responsable', $usuarios, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class]) !!}
        @if ($errors->has('responsable'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('responsable') }}</strong></span>
        @endif
    </div>
</div>
<h4 class="form-section"><i class="ft-command"></i> Reglas para aplicar la Convocatoria</h4>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">Información de ventas registradas <span class="required">*</span></label>
    <div class="col-md-8">
        <div class="row skin skin-flat">
            <div class="col-sm-1">
                <fieldset>
                    {!! Form::radio('ventas', "Si", null, ['id'=>'v1', 'class'=>$class]); !!}
                    <label for="v1">Si</label>
                </fieldset>
            </div>
            <div class="col-sm-2">
                <fieldset>
                    {!! Form::radio('ventas', "No", null, ['id'=>'v2', 'class'=>$class]); !!}
                    <label for="v2">No</label>
                </fieldset>
            </div>
        </div>
        @if ($errors->has('ventas'))
            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('ventas') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">Tiene clientes <span class="required">*</span></label>
    <div class="col-md-8">
        <div class="row skin skin-flat">
            <div class="col-sm-1">
                <fieldset>
                    {!! Form::radio('clientes', "Si", null, ['id'=>'c1', 'class'=>$class]); !!}
                    <label for="c1">Si</label>
                </fieldset>
            </div>
            <div class="col-sm-2">
                <fieldset>
                    {!! Form::radio('clientes', "No", null, ['id'=>'c2', 'class'=>$class]); !!}
                    <label for="c2">No</label>
                </fieldset>
            </div>
        </div>
        @if ($errors->has('clientes'))
            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('clientes') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">Tiene usuarios <span class="required">*</span></label>
    <div class="col-md-8">
        <div class="row skin skin-flat">
            <div class="col-sm-1">
                <fieldset>
                    {!! Form::radio('usuarios', "Si", null, ['id'=>'u1', 'class'=>$class]); !!}
                    <label for="u1">Si</label>
                </fieldset>
            </div>
            <div class="col-sm-2">
                <fieldset>
                    {!! Form::radio('usuarios', "No", null, ['id'=>'u2', 'class'=>$class]); !!}
                    <label for="u2">No</label>
                </fieldset>
            </div>
        </div>
        @if ($errors->has('usuarios'))
            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('usuarios') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">Información Financiera registrada <span class="required">*</span></label>
    <div class="col-md-8">
        <div class="row skin skin-flat">
            <div class="col-sm-1">
                <fieldset>
                    {!! Form::radio('financiera', "Si", null, ['id'=>'f1', 'class'=>$class]); !!}
                    <label for="f1">Si</label>
                </fieldset>
            </div>
            <div class="col-sm-2">
                <fieldset>
                    {!! Form::radio('financiera', "No", null, ['id'=>'f2', 'class'=>$class]); !!}
                    <label for="f2">No</label>
                </fieldset>
            </div>
        </div>
        @if ($errors->has('financiera'))
            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('financiera') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">¿Se necesita Pago? <span class="required">*</span></label>
    <div class="col-md-8">
        <div class="row skin skin-flat">
            <div class="col-sm-1">
                <fieldset>
                    {!! Form::radio('pago', "Si", null, ['id'=>'f1', 'class'=>$class]); !!}
                    <label for="f1">Si</label>
                </fieldset>
            </div>
            <div class="col-sm-2">
                <fieldset>
                    {!! Form::radio('pago', "No", null, ['id'=>'f2', 'class'=>$class]); !!}
                    <label for="f2">No</label>
                </fieldset>
            </div>
        </div>
        @if ($errors->has('pago'))
            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('pago') }}</strong></span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control">Comentarios adicionales</label>
    <div class="col-md-8">
        <?php $class=($errors->has('comentarios'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::textarea('comentarios', null, ['class' =>'tinymce '. $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 label-control">URL de Pago</label>
    <div class="col-md-8">
        <?php $class=($errors->has('pago_iframe'))?'form-control is-invalid':'form-control'; ?>
        {!! Form::text('pago_iframe', null, ['class' => $class]) !!}
    </div>
</div>
<h4 class="form-section"><i class="ft-command"></i> Publicar Convocatoria</h4>
<div class="form-group row">
    <label class="col-md-4 label-control" for="">¿Será visible en la lista de convocatorias del sistema? <span class="required">*</span></label>
    <div class="col-md-8">
        <div class="row skin skin-flat">
            <div class="col-sm-1">
                <fieldset>
                    {!! Form::radio('activo', "Si", null, ['id'=>'p1', 'class'=>$class]); !!}
                    <label for="p1">Si</label>
                </fieldset>
            </div>
            <div class="col-sm-2">
                <fieldset>
                    {!! Form::radio('activo', "No", null, ['id'=>'p2', 'class'=>$class]); !!}
                    <label for="p2">No</label>
                </fieldset>
                <small>(mantener como Draft)</small>
            </div>
        </div>
        @if ($errors->has('activo'))
            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('activo') }}</strong></span>
        @endif
    </div>
</div>
<h6>Selección de preguntas</h6>
<fieldset class="p-0">
    <div class="cargador_preguntas hidden">
        <div class="tit"><i class="fa fa-spin fa-cog"></i> Cargando preguntas</div>
    </div>
    <div class="row preguntas">
        <div class="col-md-6">
            <h4 class="form-section">Catálogos de preguntas</h4>
            <div class="row head">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-4 label-control" style="margin-top:1em;line-height: 1em;">Selecciona una categoría</label>
                        <div class="col-md-8">
                            {!! Form::select('catego', ['datos_usuario'=>'Datos del Usuario','datos_emprendimiento'=>'Datos del Emprendimiento','datos_catalogo'=>'Pregunta de Catálogo', 'datos_nueva'=>'Nueva Pregunta'], 'usuario', ['class'=> 'select2','id'=>'select_categoria']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="preguntas">
                <div id="sortable" class="list-group">
                    @include('admin.convocatorias.datos-usuario')
                    @include('admin.convocatorias.datos-catalogo')
                    @include('admin.convocatorias.datos-nuevas')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="form-section">Arma tu convocatoria</h4>
            <div class="row head">
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="javscript:;" onclick="addTitle(true)"><i class="fa fa-plus-circle"></i> Agregar categoría</a>
                    </div>
                </div>
            </div>
            <!-- titulo clone -->
            <div class="item hidden titulo" id="cloneTitle">
                <div class="row">
                    <div class="col-10">
                        <input class="form-control titulos" type="text" data-dato="categorias" data-name="nombre" value="Nombre de Categoría">
                        <input type="hidden" value="categorias" data-dato="categorias" data-name="tipo" />
                    </div>
                    <div class="col-2 text-right">
                        <button class="btn btn-default btn-sm" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></button>
                        <button class="btn btn-default btn-sm handle"><span class="fa fa-reorder"></span></button>
                    </div>
                </div>
            </div>
            <!--/ titulo clone -->
            <div class="preguntas">
                <div id="sortable2" class="list-group">
                </div>
            </div>
            <!--<a href="javascript:muestra()">Mostrar</a>
            <button type="submit">Mandar</button>-->
        </div>
    </div>
</fieldset>
<h6>Información General</h6>
<fieldset class="p-0">
    <h4 class="form-section"><i class="ft-command"></i> Información General</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Nombre <span class="required">*</span></label>
                <?php $class=($errors->has('nombre'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('nombre', null, ['class' => $class.' required']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <?php $class=($errors->has('entidad'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label class="label-control" for="">¿Quién convoca? <span class="required">*</span></label>
                <?php $class=($errors->has('entidad'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::select('entidad', $entidades, null, ['placeholder' => 'Selecciona','class'=> 'select2 required '.$class]) !!}
                @if ($errors->has('entidad'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('entidad') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Descripción corta <span class="required">*</span></label>
                <?php $class=($errors->has('descripcion_corta'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('descripcion_corta', null, ['class' => 'tinymce '.$class.' required']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Descripción <span class="required">*</span></label>
                <?php $class=($errors->has('descripcion'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('descripcion', null, ['class' => 'tinymce '.$class.' required']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control" for="">Fecha inicio período convocatoria <span class="required">*</span></label>
                    <?php $class=($errors->has('fecha_inicio_convocatoria'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::date('fecha_inicio_convocatoria', (isset($item))?date('Y-m-d', $item->fecha_inicio_convocatoria):null, ['class'=>$class.' required']); !!}
                    @if ($errors->has('fecha_inicio_convocatoria'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_inicio_convocatoria') }}</strong></span>
                    @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control"  for="">Fecha fin de convocatoria <span class="required">*</span></label>
                    <?php $class=($errors->has('fecha_fin_convocatoria'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::date('fecha_fin_convocatoria', (isset($item))?date('Y-m-d', $item->fecha_fin_convocatoria):null, ['class'=>$class.' required']); !!}
                    @if ($errors->has('fecha_fin_convocatoria'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fin_convocatoria') }}</strong></span>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control"  for="">Fecha inicial del evento <span class="required">*</span></label>
                    <?php $class=($errors->has('fecha_inicio_evento'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::date('fecha_inicio_evento', (isset($item))?date('Y-m-d', $item->fecha_inicio_evento):null, ['class'=>$class.' required']); !!}
                    @if ($errors->has('fecha_inicio_evento'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_inicio_evento') }}</strong></span>
                    @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control"  for="">Fecha final del evento <span class="required">*</span></label>
                    <?php $class=($errors->has('fecha_fin_evento'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::date('fecha_fin_evento', (isset($item))?date('Y-m-d', $item->fecha_fin_evento):null, ['class'=>$class.' required']); !!}
                    @if ($errors->has('fecha_fin_evento'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fin_evento') }}</strong></span>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $class=($errors->has('responsable'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label class="label-control" for="">Responsable Interno de la Convocatoria <span class="required">*</span></label>
                    <?php $class=($errors->has('responsable'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::select('responsable', $usuarios, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class.' required']) !!}
                    @if ($errors->has('responsable'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('responsable') }}</strong></span>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="row col-12 label-control" for="">Imagen/Banner que acompaña a la convocatoria <span class="required">*</span></label>
                    @if(isset($item->_key))
                        @if(file_exists(public_path('/convocatorias_pics/imagen_'.$item->_key.'.jpg')))
                            <img src="{{url('/convocatorias_pics/imagen_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="400" height="" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
                        @else
                            <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                        @endif
                    @endif
                    <input type='file' name="imagen" id="" accept=".jpg, .jpeg" style="margin-top: 20px; display: block;" class="" />
                    @if ($errors->has('imagen'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('imagen') }}</strong></span>
                    @endif
                    <hr/>
            </div>
        </div>
    </div>
</fieldset>
<h6>Reglas para aplicar</h6>
<fieldset class="p-0">
    <h4 class="form-section"><i class="ft-command"></i> Reglas para aplicar la Convocatoria</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="label-control" for="">Información de ventas registradas <span class="required">*</span></label>
                <div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('ventas', "Si", null, ['id'=>'v1', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="v1">Si</label>
                    </div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('ventas', "No", null, ['id'=>'v2', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="v2">No</label>
                    </div>
                    @if ($errors->has('ventas'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('ventas') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label-control" for="">Tiene clientes <span class="required">*</span></label>
                <div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('clientes', "Si", null, ['id'=>'c1', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="c1">Si</label>
                    </div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('clientes', "No", null, ['id'=>'c2', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="c2">No</label>
                    </div>
                    @if ($errors->has('clientes'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('clientes') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label-control" for="">Tiene usuarios <span class="required">*</span></label>
                <div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('usuarios', "Si", null, ['id'=>'u1', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="u1">Si</label>
                    </div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('usuarios', "No", null, ['id'=>'u2', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="u2">No</label>
                    </div>
                    @if ($errors->has('usuarios'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('usuarios') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="label-control" for="">Información Financiera registrada <span class="required">*</span></label>
                <div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('financiera', "Si", null, ['id'=>'f1', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="f1">Si</label>
                    </div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('financiera', "No", null, ['id'=>'f2', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="f2">No</label>
                    </div>
                    @if ($errors->has('financiera'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('financiera') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label-control" for="">¿Se necesita Pago? <span class="required">*</span></label>
                <div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('pago', "Si", null, ['id'=>'p1', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="p1">Si</label>
                    </div>
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('pago', "No", null, ['id'=>'p2', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="p2">No</label>
                    </div>
                    @if ($errors->has('pago'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('pago') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $class=($errors->has('quien'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label class="label-control"  for="">¿Quién puede aplicar? <span class="required">*</span></label>
                <?php $class=($errors->has('quien'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::select('quien', $quien, null, ['placeholder' => 'Selecciona','class'=> 'select2 required '.$class]) !!}
                @if ($errors->has('quien'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('quien') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="label-control">Comentarios adicionales</label>
                <?php $class=($errors->has('comentarios'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('comentarios', null, ['class' =>'tinymce '. $class]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
            <label class="label-control">URL de Pago</label>
                <?php $class=($errors->has('pago_iframe'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('pago_iframe', null, ['class' => $class]) !!}
            </div>
        </div>
    </div>
</fieldset>
<h6>Finalizar</h6>
<fieldset class="p-0">
    <h4 class="form-section"><i class="ft-command"></i> Publicar Convocatoria</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="label-control" for="">¿Será visible en la lista de convocatorias del sistema? <span class="required">*</span></label>
                <div>
                    @if(auth()->user()->rol_id=='7931855')
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            {!! Form::radio('activo', "Si", null, ['id'=>'a1', 'class'=>'custom-control-input required']); !!}
                            <label class="custom-control-label" for="a1">Si</label>
                        </div>
                    @endif
                    <div class="d-inline-block custom-control custom-radio mr-1">
                        {!! Form::radio('activo', "No", null, ['id'=>'a2', 'class'=>'custom-control-input required']); !!}
                        <label class="custom-control-label" for="a2">No</label>
                    </div>
                    @if ($errors->has('activo'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('activo') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</fieldset>
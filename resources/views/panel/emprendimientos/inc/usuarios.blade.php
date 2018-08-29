<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Tienes usuarios? <span class="required">*</span></label>
                <?php $class=($errors->has('tiene_usuarios'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('tiene_usuarios', "Si", null, ['id'=>'l1', 'class'=>'tiene_usuarios '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('tiene_usuarios', "No", null, ['id'=>'l2', 'class'=>'tiene_usuarios '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('tiene_usuarios'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('tiene_usuarios') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div id="montos_ventas_usuarios" class="invisible">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Describe 3 características de tus usuarios <span class="required">*</span></label>
                    <?php $class=($errors->has('caracteristicas_usuarios'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::textarea('caracteristicas_usuarios', null, ['class'=>$class, 'rows'=>3]); !!}
                    @if ($errors->has('caracteristicas_usuarios'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('caracteristicas_usuarios') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mb-2 mt-2">
            <div class="col-sm-12">
                <h2>Información de Usuarios</h2>
                <p>Capture la siguiente información para el período solicitado:</p>
            </div>
        </div>
        <!-- Meses de montos -->
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="" class="">¿Cuántos usuarios tienes al momento? </label>
                    <?php $class=($errors->has("usuarios_activos"))?'form-control is-invalid':'form-control'; ?>
                    <div class="input-group">
                        {!! Form::number('usuarios_activos', null, ['class'=>$class, 'value'=>'0']); !!}
                    </div>
                    @if ($errors->has('usuarios_activos'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('usuarios_activos') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="@if(count($meses_usuarios)>1) col-md-6 @else col-md-12 @endif">
                <?php $i = 0;?>
                @foreach($meses_usuarios as $year=>$months)
                    @include('panel.emprendimientos.inc.tabla-usuarios')
                    <?php $i++;?>
                @endforeach
            </div>
        </div>
        <!--/ Meses de montos -->
    </div>
</div>
<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Tienes clientes? <span class="required">*</span></label>
                <?php $class=($errors->has('tiene_clientes'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('tiene_clientes', "Si", null, ['id'=>'l1', 'class'=>'tiene_clientes '.$class]); !!}
                            <label for="l1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('tiene_clientes', "No", null, ['id'=>'l2', 'class'=>'tiene_clientes '.$class]); !!}
                            <label for="l2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('tiene_clientes'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('tiene_clientes') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div id="montos_ventas_clientes" class="invisible">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Describe 3 características de tus clientes <span class="required">*</span></label>
                    <?php $class=($errors->has('caracteristicas_clientes'))?'form-control is-invalid':'form-control'; ?>
                    {!! Form::textarea('caracteristicas_clientes', null, ['class'=>$class, 'rows'=>3]); !!}
                    @if ($errors->has('caracteristicas_clientes'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('caracteristicas_clientes') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mb-2 mt-2">
            <div class="col-sm-12">
                <h2>Información de Clientes</h2>
                <p>Capture la siguiente información para el período solicitado:</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="">¿Cuántos clientes activos tiene tu emprendimiento al momento? * </label>
                    <?php $class=($errors->has("clientes_activos"))?'form-control is-invalid':'form-control'; ?>
                    <div class="input-group">
                        {!! Form::number('clientes_activos', null, ['class'=>$class, 'value'=>'0']); !!}
                    </div>
                    @if ($errors->has('clientes_activos'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('clientes_activos') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Meses de montos -->
        <div class="row">
            <div class="@if(count($meses_clientes)>1) col-md-6 @else col-md-12 @endif">
                <?php $i = 0;?>
                @foreach($meses_clientes as $year=>$months)
                    @include('panel.emprendimientos.inc.tabla-clientes')
                    <?php $i++;?>
                @endforeach
            </div>
        </div>
        <!--/ Meses de montos -->
    </div>
</div>
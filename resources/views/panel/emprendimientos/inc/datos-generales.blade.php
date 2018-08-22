<script type="text/javascript">
    $(document).ready(function () {
        $('.investigacion_desarrollo').on('ifChecked', function(event){
            opt = ($('input[name="investigacion_desarrollo"]:checked').val());
            if(opt=="Si"){
                $('#nivel_tlr').removeClass('invisible');
            }else{
                $('#nivel_tlr').addClass('invisible');
                $('#niveles').val(null).trigger("change");
            }
        });
        @if(old('investigacion_desarrollo'))
            @if(old('investigacion_desarrollo')=="Si")
                $('#nivel_tlr').removeClass('invisible');
            @endif
        @else
            @if(isset($item->investigacion_desarrollo) && $item->investigacion_desarrollo=="Si")
            $('#nivel_tlr').removeClass('invisible');
            @endif
        @endif
    })
</script>
<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Nombre de tu Emprendimiento <span class="required">*</span></label>
                <?php $class=($errors->has('nombre'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('nombre', null, ['class'=>$class]); !!}
                @if ($errors->has('nombre'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('nombre') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Descripción del Emprendimiento <span class="required">*</span><small>(140 caracteres)</small></label>
                <?php $class=($errors->has('descripcion'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('descripcion', null, ['class'=>'textarea-maxlength '.$class, 'rows'=>2, 'maxlength'=>140]); !!}
                @if ($errors->has('descripcion'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('descripcion') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Número de colaboradores <span class="required">*</span></label>
                <?php $class=($errors->has('numero_colaboradores'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::number('numero_colaboradores', null, ['class'=>$class]); !!}
                @if ($errors->has('numero_colaboradores'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('numero_colaboradores') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $class=($errors->has('pais'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">País donde está establecido <span class="required">*</span></label>
                <?php $class=($errors->has('pais'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::select('pais', $paises, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class, 'id'=>'pais']) !!}
                @if ($errors->has('pais'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('pais') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Ciudad <span class="required">*</span></label>
                <?php $class=($errors->has('ciudad'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('ciudad', null, ['class'=>$class]); !!}
                @if ($errors->has('ciudad'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('ciudad') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Industria o Sector de Emprendimiento <small>Selecciona todas las que apliquen</small></label>
                <div class="row skin skin-flat col-sm-12">
                    @foreach($industrias as $item)
                        <div class="radio_input">
                            <fieldset>
                                {!! Form::checkbox('industria_o_sector[]', $item->_key, null, ['id'=>'industria_'.$item->_key, 'class'=>'form-control']); !!}
                                <label for="industria_{{$item->_key}}">{{$item->nombre}}</label>
                            </fieldset>
                        </div>
                    @endforeach
                </div>
                @if ($errors->has('industria_o_sector'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('industria_o_sector') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $class=($errors->has('etapa_emprendimiento'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">¿En qué etapa se encuentra tu Emprendimiento? <span class="required">*</span></label>
                <?php $class=($errors->has('etapa_emprendimiento'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::select('etapa_emprendimiento', $etapas, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class]) !!}
                @if ($errors->has('etapa_emprendimiento'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('etapa_emprendimiento') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $class=($errors->has('mercado_cliente'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">¿A qué mercado/cliente atiende tu Emprendimiento? <span class="required">*</span></label>
                <?php $class=($errors->has('mercado_cliente'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('mercado_cliente', null, ['class'=>$class]) !!}
                @if ($errors->has('mercado_cliente'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mercado_cliente') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Qué problema le soluciona tu Emprendimiento a tu mercado/cliente? <span class="required">*</span></label>
                <?php $class=($errors->has('problema_soluciona'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('problema_soluciona', null, ['class'=>$class, 'rows'=>2]); !!}
                @if ($errors->has('problema_soluciona'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('problema_soluciona') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $class=($errors->has('competencia'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">¿Quién es tu competencia? <span class="required">*</span></label>
                <?php $class=($errors->has('competencia'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('competencia', null, ['class'=>$class]) !!}
                @if ($errors->has('competencia'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('competencia') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Cómo te diferencías de tu competencia? <span class="required">*</span></label>
                <?php $class=($errors->has('diferencia_competencia'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('diferencia_competencia', null, ['class'=>$class, 'rows'=>2]); !!}
                @if ($errors->has('diferencia_competencia'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('diferencia_competencia') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Cuál es el gran diferenciador de tu modelo de negocio? <span class="required">*</span></label>
                <?php $class=($errors->has('diferenciador_modelo_negocio'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::textarea('diferenciador_modelo_negocio', null, ['class'=>$class, 'rows'=>2]); !!}
                @if ($errors->has('diferenciador_modelo_negocio'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('diferenciador_modelo_negocio') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">¿Tienes un prototipo o MVP? <span class="required">*</span></label>
                <?php $class=($errors->has('prototipo_o_mvp'))?'form-control is-invalid':'form-control'; ?>
                <div class="row skin skin-flat">
                    <div class="col-sm-1">
                        <fieldset>
                            {!! Form::radio('prototipo_o_mvp', "Si", null, ['id'=>'pro1', 'class'=>'prototipo_o_mvp '.$class]); !!}
                            <label for="pro1">Si</label>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">
                        <fieldset>
                            {!! Form::radio('prototipo_o_mvp', "No", null, ['id'=>'pro2', 'class'=>'prototipo_o_mvp '.$class]); !!}
                            <label for="pro2">No</label>
                        </fieldset>
                    </div>
                </div>
                @if ($errors->has('prototipo_o_mvp'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('prototipo_o_mvp') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">¿Actualmente, tu Emprendimiento lleva un proceso de investigación y desarrollo basado en ciencia y tecnología? <span class="required">*</span><small>IMPORTANTE: No Apps, se refiere a temas de salud, creación de nuevas tecnologías, etc.</small></label>
            <?php $class=($errors->has('investigacion_desarrollo'))?'form-control is-invalid':'form-control'; ?>
            <div class="row skin skin-flat">
                <div class="col-sm-1">
                    <fieldset>
                        {!! Form::radio('investigacion_desarrollo', "Si", null, ['id'=>'in1', 'class'=>'investigacion_desarrollo '.$class]); !!}
                        <label for="in1">Si</label>
                    </fieldset>
                </div>
                <div class="col-sm-2">
                    <fieldset>
                        {!! Form::radio('investigacion_desarrollo', "No", null, ['id'=>'in2', 'class'=>'investigacion_desarrollo '.$class]); !!}
                        <label for="in2">No</label>
                    </fieldset>
                </div>
            </div>
            @if ($errors->has('investigacion_desarrollo'))
                <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('investigacion_desarrollo') }}</strong></span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Número de socios fundadores en tu emprendimiento <span class="required">*</span></label>
            <?php $class=($errors->has('numero_socios'))?'form-control is-invalid':'form-control'; ?>
            {!! Form::number('numero_socios', null, ['class'=>$class]); !!}
            @if ($errors->has('numero_socios'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('numero_socios') }}</strong></span>
            @endif
        </div>
    </div>
</div>
<div class="row invisible" id="nivel_tlr">
    <div class="col-md-12">
        <?php $class=($errors->has('nivel_tlr'))?'is-invalid':''; ?>
        <div class="form-group {{$class}}">
            <label for="">¿En qué nivel de TLR estas (del 1 al 9)? </label>
            <?php $class=($errors->has('nivel_tlr'))?'form-control is-invalid':'form-control'; ?>
            {!! Form::select('nivel_tlr', $nivel_tlr, null, ['placeholder' => 'Selecciona', 'id'=>'niveles','class'=> 'select2 '.$class]) !!}
            @if ($errors->has('nivel_tlr'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('nivel_tlr') }}</strong></span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Busca tus socios y lígalos a tu Emprendimiento</label>
            <select name="socios[]" class="select2-placeholder-multiple-socios form-control" multiple="multiple">
                @foreach($socios as $k=>$v)
                    <option selected value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php $class=($errors->has('como_te_enteraste'))?'is-invalid':''; ?>
        <div class="form-group {{$class}}">
            <label for="">¿Cómo te enteraste de nosotros? </label>
            <?php $class=($errors->has('como_te_enteraste'))?'form-control is-invalid':'form-control'; ?>
            {!! Form::select('como_te_enteraste', ['Redes sociales'=>'Redes sociales','Universidad'=>'Universidad','Organización'=>'Organización','Recomendación'=>'Recomendación','Otro'=>'Otro'], null, ['placeholder' => 'Selecciona', 'id'=>'niveles','class'=> 'select2 '.$class]) !!}
            @if ($errors->has('como_te_enteraste'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('como_te_enteraste') }}</strong></span>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /*$('.investigacion_desarrollo').on('ifChecked', function(event){
            opt = ($('input[name="investigacion_desarrollo"]:checked').val());
            if(opt=="Si"){
                $('#nivel_tlr').removeClass('invisible');
            }else{
                $('#nivel_tlr').addClass('invisible');
                $('#niveles').val(null).trigger("change");
            }
        });*/

        $('#como_te_enteraste').on('change', function(event){
            opt =  $('#como_te_enteraste').val();
            if(opt!=""){
                $('#cual').removeClass('invisible');
            }else{
                $('#cual').addClass('invisible');
                $('#como_te_enteraste_cual').val('');
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

        @if(old('como_te_enteraste'))
            @if(old('como_te_enteraste')!="")
                $('#cual').removeClass('invisible');
            @endif
        @else
            @if(isset($item->como_te_enteraste) && $item->como_te_enteraste!="")
                $('#cual').removeClass('invisible');
            @endif
        @endif
    })
</script>
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nombre comercial del emprendimiento <span class="required">*</span></label>
                <?php $class=($errors->has('nombre'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.nombre', ['campo'=>'nombre','value'=>($item)?$item->nombre:''])
                @if ($errors->has('nombre'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('nombre') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Fecha de fundación de tu emprendimiento <span class="required">*</span></label>
                <?php $class=($errors->has('fecha_fundacion'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.fecha_fundacion', ['campo'=>'fecha_fundacion','value'=>($item)?$item->fecha_fundacion:''])
                @if ($errors->has('fecha_fundacion'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fundacion') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Descripción del Emprendimiento <span class="required">*</span><small>(140 caracteres)</small></label>
                <?php $class=($errors->has('descripcion'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.descripcion', ['campo'=>'descripcion','value'=>($item)?$item->descripcion:''])
                @if ($errors->has('descripcion'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('descripcion') }}</strong></span>
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
                @include('panel.emprendimientos.campos.pais', ['campo'=>'pais','value'=>($item)?$item->pais:''])
                @if ($errors->has('pais'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('pais') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Ciudad <span class="required">*</span></label>
                <?php $class=($errors->has('ciudad'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.ciudad', ['campo'=>'ciudad','value'=>($item)?$item->ciudad:''])
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
                @include('panel.emprendimientos.campos.industria_o_sector', ['campo'=>'industria_o_sector[]','value'=>($item)?$item->industria_o_sector:'','columns'=>'3'])
                @if ($errors->has('industria_o_sector'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('industria_o_sector') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $class=($errors->has('etapa_emprendimiento'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">¿En qué etapa se encuentra tu Emprendimiento? <span class="required">*</span></label>
                <?php $class=($errors->has('etapa_emprendimiento'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.etapa_emprendimiento', ['campo'=>'etapa_emprendimiento','value'=>($item)?$item->etapa_emprendimiento:''])
                @if ($errors->has('etapa_emprendimiento'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('etapa_emprendimiento') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <?php $class=($errors->has('mercado_cliente'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">¿A qué mercado/cliente atiende tu Emprendimiento? <span class="required">*</span></label>
                <?php $class=($errors->has('mercado_cliente'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.mercado_cliente', ['campo'=>'mercado_cliente','value'=>($item)?$item->mercado_cliente:''])
                @if ($errors->has('mercado_cliente'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mercado_cliente') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Qué problema le soluciona tu Emprendimiento a tu mercado/cliente? <span class="required">*</span></label>
                <?php $class=($errors->has('problema_soluciona'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.problema_soluciona', ['campo'=>'problema_soluciona','value'=>($item)?$item->problema_soluciona:''])
                @if ($errors->has('problema_soluciona'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('problema_soluciona') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <?php $class=($errors->has('competencia'))?'is-invalid':''; ?>
            <div class="form-group {{$class}}">
                <label for="">¿Quién es tu competencia? <span class="required">*</span></label>
                <?php $class=($errors->has('competencia'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.competencia', ['campo'=>'competencia','value'=>($item)?$item->competencia:''])
                @if ($errors->has('competencia'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('competencia') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Cómo te diferencías de tu competencia? <span class="required">*</span></label>
                <?php $class=($errors->has('diferencia_competencia'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.diferencia_competencia', ['campo'=>'diferencia_competencia','value'=>($item)?$item->diferencia_competencia:''])
                @if ($errors->has('diferencia_competencia'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('diferencia_competencia') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Cuál es el gran diferenciador de tu modelo de negocio? <span class="required">*</span></label>
                <?php $class=($errors->has('diferenciador_modelo_negocio'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.diferenciador_modelo_negocio', ['campo'=>'diferenciador_modelo_negocio','value'=>($item)?$item->diferenciador_modelo_negocio:''])
                @if ($errors->has('diferenciador_modelo_negocio'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('diferenciador_modelo_negocio') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">¿Actualmente, tu Emprendimiento lleva un proceso de investigación y desarrollo basado en ciencia y tecnología? <span class="required">*</span><small>IMPORTANTE: No Apps, se refiere a temas de salud, creación de nuevas tecnologías, etc.</small></label>
            <?php $class=($errors->has('investigacion_desarrollo'))?'form-control is-invalid':'form-control'; ?>
            @include('panel.emprendimientos.campos.investigacion_desarrollo', ['campo'=>'investigacion_desarrollo','value'=>($item)?$item->investigacion_desarrollo:''])
            @if ($errors->has('investigacion_desarrollo'))
                <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('investigacion_desarrollo') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Número de socios fundadores en tu emprendimiento <span class="required">*</span></label>
            <?php $class=($errors->has('numero_socios'))?'form-control is-invalid':'form-control'; ?>
            @include('panel.emprendimientos.campos.numero_socios', ['campo'=>'numero_socios','value'=>($item)?$item->numero_socios:''])
            @if ($errors->has('numero_socios'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('numero_socios') }}</strong></span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Busca tus socios y lígalos a tu Emprendimiento</label>
            <select name="socios[]" class="select2-placeholder-multiple-socios form-control" multiple="multiple" autocomplete="off">
                @foreach($socios as $k=>$v)
                    <option selected value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?php $class=($errors->has('como_te_enteraste'))?'is-invalid':''; ?>
        <div class="form-group {{$class}}">
            <label for="">¿Cómo te enteraste de nosotros? </label>
            <?php $class=($errors->has('como_te_enteraste'))?'form-control is-invalid':'form-control'; ?>
            @include('panel.emprendimientos.campos.como_te_enteraste', ['campo'=>'como_te_enteraste','value'=>($item)?$item->como_te_enteraste:''])
            @if ($errors->has('como_te_enteraste'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('como_te_enteraste') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="col-md-6 invisible" id="cual">
        <?php $class=($errors->has('como_te_enteraste_cual'))?'is-invalid':''; ?>
        <div class="form-group {{$class}}">
            <label for="">¿Cuál? <span class="required">*</span></label>
            <?php $class=($errors->has('como_te_enteraste_cual'))?'form-control is-invalid':'form-control'; ?>
            @include('panel.emprendimientos.campos.como_te_enteraste_cual', ['campo'=>'como_te_enteraste_cual','value'=>(isset($item->como_te_enteraste_cual))?$item->como_te_enteraste_cual:''])
            @if ($errors->has('como_te_enteraste_cual'))
                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('como_te_enteraste_cual') }}</strong></span>
            @endif
        </div>
    </div>
</div>
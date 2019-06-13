@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Mis Aplicaciones @endsection
@section('accion') Editar Aplicación @endsection

@section('breadcrumb')
    <h3 class="content-header-title">CONVOCATORIAS</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{action("PanelConvocatorias@Aplicaciones")}}">Mis Aplicaciones</a></li>
                <li class="breadcrumb-item active">Editar Aplicación</li>
            </ol>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/plugins/forms/wizard.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/plugins/pickers/daterange/daterange.css">
@endsection

@section('js')
    <script src="{{url('/')}}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="{{url('/')}}/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="{{url('/')}}/app-assets/js/scripts/forms/aplicar-steps.js"></script>
    @if($aplicacion->aprobado==2 || $aplicacion->aprobado==3)
        <script type="text/javascript">
            $(document).ready(function () {
                $('input, select, textarea').attr('disabled','disabled');
                $('input[type="file"]').css('display','none');
                $('input[type="radio"]:checked').css('display','none');
                $('a[href="#finish"]').css('display','none');
            })
        </script>
    @endif
@endsection

@section('content')

<section id="validation">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{$item->nombre}}</h2>
                    <h4 class="card-title">Completa la siguiente Información:</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    {!! Form::open(['action' => ['PanelConvocatorias@UpdateAplicacion', $aplicacion->_key], 'method'=>'POST', 'class'=>'form steps-validation wizard-notification', 'files' => false]) !!}
                    {!! Form::hidden('emprendimiento_id', $emprendimiento->_key) !!}
                        <!-- Step 1 -->
                        <?php $i = 0; ?>
                        @foreach($item->preguntas as $pregunta)
                            <?php $i++; ?>
                            @if($pregunta->tipo=='categorias')
                                <?php if($i>1) echo '</div></fieldset>'; ?>
                                <h6>{{$pregunta->nombre}}</h6>
                                <?php echo '<fieldset><div class="row">'; ?>
                            @else
                                <?php $class='form-control required'; ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        @if($pregunta->tipo=='usuario')

                                            <label>{{$pregunta->nombre}} <span class="required">*</span></label>
                                            @include('panel.perfiles.campos.'.$pregunta->campo, ['campo'=>'usuario['.$pregunta->campo.']','value'=>$perfil[$pregunta->campo]])

                                        @elseif($pregunta->tipo=='cuenta')

                                            <label>{{$pregunta->nombre}} <span class="required">*</span></label>
                                            <?php $class='form-control'; ?>
                                            @include('panel.perfiles.campos.'.$pregunta->campo, ['campo'=>'cuenta['.$pregunta->campo.']','value'=>$cuenta[$pregunta->campo]])

                                        @elseif($pregunta->tipo=='emprendimiento')

                                            <?php $campo = ($pregunta->campo =='industria_o_sector')?"emprendimiento[industria_o_sector][]":'emprendimiento['.$pregunta->campo.']'; ?>
                                            <label>{{$pregunta->nombre}} <span class="required">*</span></label>
                                            @include('panel.emprendimientos.campos.'.$pregunta->campo, ['campo'=>$campo,'value'=>(isset($emprendimiento_array[$pregunta->campo]))?$emprendimiento_array[$pregunta->campo]:'','columns'=>'5'])

                                        @elseif($pregunta->tipo=='catalogos')

                                            <?php $preg = $preguntas_catalogo[$pregunta->campo]; ?>
                                            <?php $value = (isset($respuestas_aplicacion['catalogos']['p_'.$preg['_key']]))?$respuestas_aplicacion['catalogos']['p_'.$preg['_key']]:'' ?>
                                            <label>{{$preg['pregunta']}} <span class="required">*</span></label>
                                            <?php
                                            switch($preg['tipo']){
                                                case 'text':
                                                    echo '<input type="text" name="catalogos[p_'.$preg['_key'].']" class="'.$class.'" value="'.$value.'"/>';
                                                    break;
                                                case 'textarea':
                                                    echo '<textarea name="catalogos[p_'.$preg['_key'].']" class="'.$class.'"/>'.$value.'</textarea>';
                                                    break;
                                                case 'combo':
                                                    echo '<select name="catalogos[p_'.$preg['_key'].']" class="'.$class.'""/>';
                                                    $respuestas = preg_split('/\n|\r\n?/', $preg['respuestas']);
                                                    foreach ($respuestas as $respuesta){
                                                        $selected = ($value==$respuesta)?' selected ':'';
                                                        echo '<option value="'.$respuesta.'" '.$selected.'>'.$respuesta.'</option>';
                                                    }
                                                    echo '</select>';
                                                    break;
                                                case 'multiple':
                                                    echo '<div class="row">';
                                                    $respuestas = preg_split('/\n|\r\n?/', $preg['respuestas']);
                                                    foreach ($respuestas as $respuesta){
                                                        if(is_array($value)){
                                                            $checked = (in_array($respuesta, $value))?' checked="checked" ':'';
                                                        }else{
                                                            $checked = '';
                                                        }
                                                        echo '<div class="radio_input col-md-6">';
                                                        echo '<label><input name="catalogos[p_'.$preg['_key'].'][]" class="required" type="checkbox" '.$checked.' value="'.$respuesta.'"> '.$respuesta.'</label>';
                                                        echo '</div>';
                                                    }
                                                    echo '</div>';
                                                    break;
                                            }
                                            ?>
                                        @else

                                            <label for="">{{$pregunta->nombre}} <span class="required">*</span></label>
                                            <?php $value = (isset($respuestas_aplicacion['nueva']['n_'.$pregunta->campo]))?$respuestas_aplicacion['nueva']['n_'.$pregunta->campo]:'' ?>
                                            <?php
                                            switch($pregunta->tipo_pregunta){
                                                case 'text':
                                                    echo '<input type="text" name="nueva[n_'.$pregunta->campo.']" class="'.$class.'" value="'.$value.'"/>';
                                                    break;
                                                case 'textarea':
                                                    echo '<textarea name="nueva[n_'.$pregunta->campo.']" class="'.$class.'"/>'.$value.'</textarea>';
                                                    break;
                                                case 'combo':
                                                    echo '<select name="nueva[n_'.$pregunta->campo.']" class="'.$class.'"/>';
                                                    $respuestas = preg_split('/\n|\r\n?/', $pregunta->respuestas);
                                                    foreach ($respuestas as $respuesta){
                                                        $selected = ($value==$respuesta)?' selected ':'';
                                                        echo '<option value="'.$respuesta.'" '.$selected.'>'.$respuesta.'</option>';
                                                    }
                                                    echo '</select>';
                                                    break;
                                                case 'multiple':
                                                    echo '<div class="row">';
                                                    $respuestas = preg_split('/\n|\r\n?/', $pregunta->respuestas);
                                                    foreach ($respuestas as $respuesta){
                                                        if(is_array($value)){
                                                            $checked = (in_array($respuesta, $value))?' checked="checked" ':'';
                                                        }else{
                                                            $checked = '';
                                                        }
                                                        echo '<div class="radio_input col-md-6">';
                                                        echo '<label><input name="nueva[n_'.$pregunta->campo.'][]" class="required" type="checkbox" '.$checked.' value="'.$respuesta.'"> '.$respuesta.'</label>';
                                                        echo '</div>';
                                                    }
                                                    echo '</div>';
                                                    break;
                                            }
                                            ?>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <?php echo '</div></fieldset>'; ?>
                    {!! Form::close() !!}
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
@endsection

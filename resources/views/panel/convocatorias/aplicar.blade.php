@extends('layouts.panel')

@section('titulo') Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Aplicar @endsection

@section('breadcrumb')
    <h3 class="content-header-title">CONVOCATORIAS</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action("PanelController@Index")}}">Inicio</a></li>
                <li class="breadcrumb-item active">Convocatorias</li>
                <li class="breadcrumb-item active">{{$item->nombre}}</li>
                <li class="breadcrumb-item active">Aplicar</li>
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
@endsection

@section('content')

    @if($verificar!=true)
        @if($puede_aplicar == false)
            <section class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6 pt-4 offset-3">
                                <div class="bs-callout-warning callout-border-left callout-bordered mb-2 p-1">
                                    <strong>Lo sentimos</strong>
                                    <p>No puedes aplicar a esta solicitud con tu emprendimiento.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 text-center">
                                <a href="{{action('PanelConvocatorias@Ver',$item->_key)}}" class="btn btn-lg btn-primary mt-2"><i class="fa fa-arrow-left"></i> Regresar a la convocatoria</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section id="validation">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Completa la siguiente Información</h4>
                            </div>
                            <div class="card-content">
                            <div class="card-body">
                                {!! Form::open(['action' => ['PanelConvocatorias@Aplicacion', $item->_key], 'method'=>'POST', 'class'=>'form steps-validation wizard-notification', 'files' => false]) !!}
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
                                                        <label>{{$preg['pregunta']}} <span class="required">*</span></label>
                                                        <?php
                                                        switch($preg['tipo']){
                                                            case 'text':
                                                                echo '<input type="text" name="catalogos[p_'.$preg['_key'].']" class="'.$class.'"/>';
                                                                break;
                                                            case 'textarea':
                                                                echo '<textarea name="catalogos[p_'.$preg['_key'].']" class="'.$class.'"/></textarea>';
                                                                break;
                                                            case 'combo':
                                                                echo '<select name="catalogos[p_'.$preg['_key'].']" class="'.$class.'""/>';
                                                                $respuestas = preg_split('/\n|\r\n?/', $preg['respuestas']);
                                                                foreach ($respuestas as $respuesta){
                                                                    echo '<option value="'.$respuesta.'">'.$respuesta.'</option>';
                                                                }
                                                                echo '</select>';
                                                                break;
                                                            case 'multiple':
                                                                echo '<div class="row">';
                                                                $respuestas = preg_split('/\n|\r\n?/', $preg['respuestas']);
                                                                foreach ($respuestas as $respuesta){
                                                                    echo '<div class="radio_input col-md-6">';
                                                                    echo '<label><input name="catalogos[p_'.$preg['_key'].'][]" class="required" type="checkbox" value="'.$respuesta.'"> '.$respuesta.'</label>';
                                                                    echo '</div>';
                                                                }
                                                                echo '</div>';
                                                                break;
                                                        }
                                                        ?>
                                                    @else

                                                        <label for="">{{$pregunta->nombre}} <span class="required">*</span></label>
                                                        <?php
                                                        switch($pregunta->tipo_pregunta){
                                                            case 'text':
                                                                echo '<input type="text" name="nueva[n_'.$pregunta->campo.']" class="'.$class.'"/>';
                                                                break;
                                                            case 'textarea':
                                                                echo '<textarea name="nueva[n_'.$pregunta->campo.']" class="'.$class.'"/></textarea>';
                                                                break;
                                                            case 'combo':
                                                                echo '<select name="nueva[n_'.$pregunta->campo.']" class="'.$class.'"/>';
                                                                $respuestas = preg_split('/\n|\r\n?/', $pregunta->respuestas);
                                                                foreach ($respuestas as $respuesta){
                                                                    echo '<option value="'.$respuesta.'">'.$respuesta.'</option>';
                                                                }
                                                                echo '</select>';
                                                                break;
                                                            case 'multiple':
                                                                echo '<div class="row">';
                                                                $respuestas = preg_split('/\n|\r\n?/', $pregunta->respuestas);
                                                                foreach ($respuestas as $respuesta){
                                                                    echo '<div class="radio_input col-md-6">';
                                                                    echo '<label><input name="nueva[n_'.$pregunta->campo.'][]" class="required" type="checkbox" value="'.$respuesta.'"> '.$respuesta.'</label>';
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
        @endif
    @else
        <section class="row justify-content-md-center">
            <div class="col-md-6 col-sm-12">
                <div class="bs-callout-danger callout-border-left callout-bordered mb-2 p-1">
                    <strong>No puedes aplicar de nuevo</strong>
                    <p>Ya tienes una aplicación de <b>{{$emprendimiento->nombre}}</b> a esta convocatoria, solo puedes aplicar una vez tu emprendimiento en la misma convocatoria.</p>
                </div>
            </div>
        </section>
    @endif
@endsection

@extends('layouts.panel')

@section('titulo') Perfil @endsection
@section('seccion') Perfil @endsection
@section('accion') Estudios @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            <?php $clase_otra = 'invisible';?>
            @if($item)
                @if(isset($item->universidad))
                    @if($item->universidad==1)
                        <?php $clase_otra = '';?>
                    @endif
                @endif
            @endif
            @if(old('universidad')=='1')
                <?php $clase_otra = '';?>
            @endif

            $('#universidad').on('select2:select',function (e) {
                var data = e.params.data;
                if(data.id=='3961308'){
                    $('#campus_tec').css('visibility','visible').css('height','auto');
                    $('#otra').addClass('invisible');
                    $('#universidad_otra').val('');
                }else{
                    if(data.id=='1'){
                        $('#otra').removeClass('invisible');
                    }else{
                        $('#campus_tec').css('visibility','hidden').css('height','0');
                        $('#otra').addClass('invisible');
                    }
                    $('#universidad_otra').val('');
                    $('#camous').val('');
                    $('#matricula').val('');
                }
            })
        });
    </script>
@endsection

@section('breadcrumb')
    <h3 class="content-header-title">PERFIL</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action('PanelController@Index')}}">Inicio</a></li>
                <li class="breadcrumb-item">Estudios</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <style>
        #campus_tec{
            visibility: hidden;
            height: 0;
        }
    </style>

<section id="basic-form-layouts">
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">

                        <div class="icons-tab-steps wizard-circle wizard clearfix" role="application" id="steps-uid-0">
                            <div class="steps clearfix">
                                <ul role="tablist">
                                    <li role="tab" class="first done" aria-disabled="false" aria-selected="false">
                                        <a href="{{action('PanelPerfiles@Index')}}" id="steps-uid-0-t-0" href="#steps-uid-0-h-0" aria-controls="steps-uid-0-p-0"><span class="step"><i class="step-icon icon-note"></i></span> 1. Datos Personales</a>
                                    </li>
                                    <li role="tab" class="last current" aria-disabled="false" aria-selected="true">
                                        <a id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1"><span class="current-info audible">current step: </span><span class="step"><i class="step-icon icon-graduation"></i></span> 2. Estudios</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {!! Form::model($item, ['action' => 'PanelPerfiles@SaveEstudios', 'method' => 'post', 'files'=>'false']) !!}
                        @if(isset($item->_key))
                            <input name="id" type="hidden" value="{{$item->_key}}">
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">¿Te encuentras actualmente cursando tu carrera profesional? <span class="required">*</span></label>
                                        <?php $class=($errors->has('actualmente_cursando_carrera'))?'form-control is-invalid':'form-control'; ?>
                                        <div class="row skin skin-flat">
                                            <div class="col-sm-1">
                                                <fieldset>
                                                    {!! Form::radio('actualmente_cursando_carrera', "Si", null, ['id'=>'s1', 'class'=>$class]); !!}
                                                    <label for="s1">Si</label>
                                                </fieldset>
                                            </div>
                                            <div class="col-sm-1">
                                                <fieldset>
                                                    {!! Form::radio('actualmente_cursando_carrera', "No", null, ['id'=>'s2', 'class'=>$class]); !!}
                                                    <label for="s2">No</label>
                                                </fieldset>
                                            </div>
                                        </div>
                                        @if ($errors->has('actualmente_cursando_carrera'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('actualmente_cursando_carrera') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $class=($errors->has('universidad'))?'is-invalid':''; ?>
                                    <div class="form-group {{$class}}">
                                        <label for="">Universidad donde cursaste tus estudios o estás actualmente estudiando <span class="required">*</span></label>
                                        {!! Form::select('universidad', $universidades+['1'=>'Otra Universidad'], null, ['placeholder' => 'Selecciona','class'=> 'select2 form-control '.$class, 'id'=>'universidad']); !!}
                                        @if ($errors->has('universidad'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('universidad') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{$clase_otra}}" id="otra">
                                        <label for="">Otra <span class="required">*</span></label>
                                        <?php $class=($errors->has('universidad_otra'))?'form-control is-invalid':'form-control'; ?>
                                        {!! Form::text('universidad_otra', null, ['class'=>$class, 'id'=>'universidad_otra']); !!}
                                        @if ($errors->has('universidad_otra'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('universidad_otra') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="campus_tec"
                                    @if($errors->has('campus'))
                                        style="visibility: visible;height: auto;"
                                    @else
                                        @if(old('universidad')=='3961308')
                                            style="visibility: visible;height: auto;"
                                        @else
                                            @if(old('universidad')=='' && isset($item))
                                                @if(isset($item->universidad))
                                                    @if($item->universidad=='3961308')
                                                        style="visibility: visible;height: auto;"
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif>
                                <div class="col-md-6">
                                    <?php $class=($errors->has('campus'))?'is-invalid':''; ?>
                                    <div class="form-group {{$class}}">
                                        <label for="">Campus <span class="required">*</span></label>
                                        {!! Form::select('campus', $campus, null, ['placeholder' => 'Selecciona','class'=> 'select2 form-control '.$class]); !!}
                                        @if ($errors->has('campus'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('campus') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Matrícula</label>
                                        <?php $class=($errors->has('matricula'))?'form-control is-invalid':'form-control'; ?>
                                        {!! Form::text('matricula', null, ['class'=>$class]); !!}
                                        @if ($errors->has('matricula'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('matricula') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Fecha en la que te graduaste o te vas a graduar <span class="required">*</span></label>
                                        <?php $class=($errors->has('fecha_graduacion'))?'form-control is-invalid':'form-control'; ?>
                                        {!! Form::date('fecha_graduacion', null, ['class'=>$class]); !!}
                                        @if ($errors->has('fecha_graduacion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_graduacion') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right">
                            <a href="{{action('PanelPerfiles@Index')}}" class="btn btn-warning mr-1">
                                <i class="fa fa-chevron-left"></i> Regresar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Guardar Datos
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('layouts.panel')

@section('titulo') Perfil @endsection
@section('seccion') Perfil @endsection
@section('accion') Estudios @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            <?php $clase_tec = 'invisible';?>
            @if($item)
                @if(isset($item->actualmente_cursando_carrera))
                    @if($item->actualmente_cursando_carrera=='Preparatoria en el Tec' || $item->actualmente_cursando_carrera=='Licenciatura en el Tec' || $item->actualmente_cursando_carrera=='Posgrado en el Tec')
                        <?php $clase_tec = '';?>
                    @endif
                @endif
            @endif
            @if(old('actualmente_cursando_carrera')=='Preparatoria en el Tec' || old('actualmente_cursando_carrera')=='Licenciatura en el Tec' || old('actualmente_cursando_carrera')=='Posgrado en el Tec')
                <?php $clase_tec = '';?>
            @endif

            $('#estudiando').on('select2:select',function (e) {
                var data = e.params.data;
                if(data.id=='Preparatoria en el Tec' || data.id=='Licenciatura en el Tec' || data.id=='Posgrado en el Tec'){
                    $('#campus_tec').removeClass('invisible');
                }else{
                    $('#campus_tec').addClass('invisible');
                    $('#campus').val('').change();
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
                                        <label for="">¿Estás estudiando? <span class="required">*</span></label>
                                        <?php $class=($errors->has('actualmente_cursando_carrera'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.actualmente_cursando_carrera', ['campo'=>'actualmente_cursando_carrera','value'=>(isset($item->actualmente_cursando_carrera))?$item->actualmente_cursando_carrera:''])
                                        @if ($errors->has('actualmente_cursando_carrera'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('actualmente_cursando_carrera') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row {{$clase_tec}}" id="campus_tec">
                                <div class="col-md-6">
                                    <?php $class=($errors->has('campus'))?'is-invalid':''; ?>
                                    <div class="form-group {{$class}}">
                                        <label for="">Si estudiaste o estudias en el Tecnológico de Monterrey, selecciona un campus <span class="required">*</span></label>
                                        @include('panel.perfiles.campos.campus', ['campo'=>'campus','value'=>(isset($item->campus))?$item->campus:''])
                                        @if ($errors->has('campus'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('campus') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Matricula (solo para estudiantes del Tec) <span class="required">*</span></label>
                                        <?php $class=($errors->has('matricula'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.matricula', ['campo'=>'matricula','value'=>(isset($item->matricula))?$item->matricula:''])
                                        @if ($errors->has('matricula'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('matricula') }} El formato válido es A+8 dígitos ejemplo: A00123456 </strong>
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
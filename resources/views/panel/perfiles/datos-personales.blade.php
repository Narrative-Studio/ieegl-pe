@extends('layouts.panel')

@section('titulo') Perfil @endsection
@section('seccion') Perfil @endsection
@section('accion') Datos Personales @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            @if($item)
                @if(isset($item->estado))
                    @if($item->pais==121)
                        $('#estado_otro').css('display','none');
                        $('#estado').css('display','block');
                    @endif
                @endif
                @if(isset($item->estado_otro))
                    @if($item->estado_otro!='')
                        $('#estado').css('display','none');
                        $('#estado_otro').css('display','block');
                    @endif
                @else
                    $('#estado').css('display','block');
                    $('#estado_otro').css('display','none');
                @endif
            @else
                @if(old('pais')!='')
                    @if(old('pais')!='121')
                        $('#estado').css('display','none');
                        $('#estado_otro').css('display','block');
                    @else
                        $('#estado').css('display','block');
                        $('#estado_otro').css('display','none');
                    @endif
                @else
                    $('#estado_otro').css('display','none');
                @endif
            @endif
            $('#pais').on('select2:select',function (e) {
                var data = e.params.data;
                if(data.id=='121'){
                    $('#estado_otro').css('display','none');
                    $('#estado_otro').val('');
                    $('#estado').css('display','block');
                }else{
                    $('#estado_otro').css('display','block');
                    $('#estado').css('display','none');
                    $('#estado').val('');
                }
            })
        })
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {
            $("#imageUpload").change(function() {
                readURL(this);
            });
        });
    </script>
@endsection

@section('breadcrumb')
    <h3 class="content-header-title">PERFIL</h3>
    <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{action('PanelController@Index')}}">Inicio</a></li>
                <li class="breadcrumb-item">Datos Personales</li>
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
                                    <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
                                        <a id="steps-uid-0-t-0" href="#steps-uid-0-h-0" aria-controls="steps-uid-0-p-0"><span class="current-info audible">current step: </span><span class="step"><i class="step-icon icon-note"></i></span> 1. Datos Personales</a>
                                    </li>
                                    <li role="tab" class="disabled last" aria-disabled="false" aria-selected="false" disabled="">
                                        <a href="{{action('PanelPerfiles@Estudios')}}" style="cursor: pointer;" id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1"><span class="step"><i class="step-icon icon-graduation"></i></span> 2. Estudios</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {!! Form::model($item, ['action' => 'PanelPerfiles@SaveDatosPersonales', 'method' => 'post', 'files'=>'true']) !!}
                        @if(isset($item->_key))
                            <input name="id" type="hidden" value="{{$item->_key}}">
                        @endif
                        <div class="form-body">
                            <div class="row justify-content-md-center">
                                <div class="col-md-3">
                                    <div class="container">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="foto" id="imageUpload" accept=".jpg, .jpeg" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                @if(file_exists(public_path('/users_pics/user_'. auth()->user()->_key .'.jpg')))
                                                    <div id="imagePreview" style="background-image: url({{url('/users_pics/user_'. auth()->user()->_key .'.jpg')}});"></div>
                                                @else
                                                    <div id="imagePreview" style="background-image: url({{url("/")}}/app-assets/images/avatar.jpg);"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Fecha de Nacimiento <span class="required">*</span></label>
                                        <?php $class=($errors->has('fecha_nacimiento'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.fecha_nacimiento', ['campo'=>'fecha_nacimiento','value'=>($item)?$item->fecha_nacimiento:''])
                                        @if ($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Sexo <span class="required">*</span></label>
                                        <?php $class=($errors->has('sexo'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.sexo', ['campo'=>'sexo','value'=>($item)?$item->sexo:''])
                                        @if ($errors->has('sexo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('sexo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">¿A qué te dedicas? <span class="required">*</span><small>.</small></label>
                                        <?php $class=($errors->has('a_que_se_dedica'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.a_que_se_dedica', ['campo'=>'a_que_se_dedica','value'=>($item)?$item->a_que_se_dedica:''])
                                        @if ($errors->has('a_que_se_dedica'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('a_que_se_dedica') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Perfil Linkedin <small>Por favor inserta el URL a tu perfil público de linkedin, ejemplo: https://www.linkedin.com/in/username/</small></label>
                                        <?php $class=($errors->has('linkedin'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.linkedin', ['campo'=>'linkedin','value'=>($item)?$item->linkedin:''])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $class=($errors->has('pais'))?'is-invalid':''; ?>
                                    <div class="form-group {{$class}}">
                                        <label for="">País de residencia <span class="required">*</span></label>
                                        <?php $class=($errors->has('pais'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.pais', ['campo'=>'pais','value'=>(!isset($item->pais))?121:$item->pais])
                                        @if ($errors->has('pais'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pais') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <?php $class=($errors->has('estado'))?'is-invalid':''; ?>
                                    <div class="form-group {{$class}}">
                                        <label for="">Estado/Región <span class="required">*</span></label>
                                        <?php $class=($errors->has('estado'))?'form-control is-invalid':'form-control'; ?>
                                        <div id="estado">
                                            @include('panel.perfiles.campos.estado', ['campo'=>'estado','value'=>($item)?$item->estado:''])
                                        </div>
                                        <?php $class=($errors->has('estado_otro'))?'form-control is-invalid':'form-control'; ?>
                                        {!! Form::text('estado_otro', null, ['class'=>$class, 'id'=>'estado_otro']) !!}
                                        @if ($errors->has('estado'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('estado') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('estado_otro'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('estado_otro') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Ciudad <span class="required">*</span></label>
                                        <?php $class=($errors->has('ciudad'))?'form-control is-invalid':'form-control'; ?>
                                        @include('panel.perfiles.campos.ciudad', ['campo'=>'ciudad','value'=>($item)?$item->ciudad:''])
                                        @if ($errors->has('ciudad'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ciudad') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Biografía corta.  <span class="required">*</span><small>Cuéntanos un poco de tu perfil profesional y emprendedor. (140 caracteres)</small></label>
                                    <?php $class=($errors->has('biografia'))?'form-control is-invalid':'form-control'; ?>
                                    @include('panel.perfiles.campos.biografia', ['campo'=>'biografia','value'=>($item)?$item->biografia:''])
                                    @if ($errors->has('biografia'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('biografia') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right">
                            <!--<a href="" class="btn btn-warning mr-1">
                                <i class="ft-x"></i> Cancelar
                            </a>-->
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
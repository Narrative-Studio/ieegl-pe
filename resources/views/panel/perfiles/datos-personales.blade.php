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
                @if(old('pais')!='121')
                    $('#estado').css('display','none');
                    $('#estado_otro').css('display','block');
                @else
                    $('#estado').css('display','block');
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

@section('content')
        <div class="content-wrapper">
            @include('layouts.breadcrum')
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                            <li class="nav-item">
                                                <a class="nav-link active">Datos Personales</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{action('PanelPerfiles@Estudios')}}">Estudios</a>
                                            </li>
                                        </ul>
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
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Biografía corta.  <span class="required">*</span><small>Cuéntanos un poco de tu perfil profesional y emprendedor. (140 caracteres)</small></label>
                                                        <?php $class=($errors->has('biografia'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::textarea('biografia', null, ['class'=>'textarea-maxlength '.$class, 'rows'=>2, 'maxlength'=>140]); !!}
                                                        @if ($errors->has('biografia'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('biografia') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Sexo <span class="required">*</span></label>
                                                        <?php $class=($errors->has('sexo'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::select('sexo', ['Hombre' => 'Hombre', 'Mujer' => 'Mujer', 'No deseo especificar'=>'No deseo especificar'], null, ['placeholder' => 'Selecciona','class'=>$class]); !!}
                                                        @if ($errors->has('sexo'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('sexo') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Fecha de Nacimiento <span class="required">*</span></label>
                                                        <?php $class=($errors->has('fecha_nacimiento'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::date('fecha_nacimiento', null, ['class'=>$class]); !!}
                                                        @if ($errors->has('fecha_nacimiento'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">A que te dedicas <span class="required">*</span><small>.</small></label>
                                                        <?php $class=($errors->has('a_que_se_dedica'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::select('a_que_se_dedica', ['Empleado' => 'Empleado', 'Empleado con Negocio Propio' => 'Empleado con Negocio Propio', 'Estudiante'=>'Estudiante','Estudiante con Negocio Propio'=>'Estudiante con Negocio Propio', 'Negocio Propio'=>'Negocio Propio'], null, ['placeholder' => 'Selecciona','class'=>$class]); !!}
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
                                                        {!! Form::text('linkedin', null, ['class'=>$class, 'placeholder'=>'https://www.linkedin.com/in/']); !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?php $class=($errors->has('pais'))?'is-invalid':''; ?>
                                                    <div class="form-group {{$class}}">
                                                        <label for="">País de residencia <span class="required">*</span></label>
                                                        <?php $class=($errors->has('pais'))?'form-control is-invalid':'form-control'; ?>
                                                        {!! Form::select('pais', $paises, (!isset($item->pais))?121:$item->pais, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class, 'id'=>'pais']) !!}
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
                                                            {!! Form::select('estado', $estados, null, ['placeholder' => 'Selecciona','class'=>'select2 '.$class]) !!}
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
                                                        {!! Form::text('ciudad', null, ['class'=>$class]); !!}
                                                        @if ($errors->has('ciudad'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('ciudad') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
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
                <!-- // Basic form layout section end -->
            </div>
        </div>
@endsection
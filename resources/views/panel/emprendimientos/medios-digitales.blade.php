@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Medio Digitales @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
        })
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
                                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified mb-3">
                                        <?php $e_active = 'medios';?>
                                        @include('panel.emprendimientos.inc.nav')
                                    </ul>
                                    {!! Form::model($item, ['action' => 'PanelEmprendimientos@SaveMediosDigitales', 'method' => 'post', 'files'=>'true']) !!}
                                    @if(isset($item->_key))
                                        <input name="id" type="hidden" value="{{$item->_key}}">
                                    @endif
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Sitio Web de tu Emprendimiento <span class="required">*</span><small>Ej. www.misitio.com</small></label>
                                                    <?php $class=($errors->has('sitio_web'))?'form-control is-invalid':'form-control'; ?>
                                                    {!! Form::text('sitio_web', null, ['class'=>$class, 'aria-describedby'=>'sitio_des']) !!}
                                                    @if ($errors->has('sitio_web'))
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('sitio_web') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Red social mas utilizada por tu Emprendimiento <span class="required">*</span><small>Incluye el nombre de usuario o nickname (Ej. www.facebook.com/usuario)</small></label>
                                                    <?php $class=($errors->has('red_social'))?'form-control is-invalid':'form-control'; ?>
                                                    {!! Form::text('red_social', null, ['class'=>$class, 'aria-describedby'=>'sitio_red']) !!}
                                                    @if ($errors->has('red_social'))
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('red_social') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Video de tu Emprendimiento <span class="required">*</span><small>Sube un video a youtube con tu pitch y copia el URL aquí.</small></label>
                                                    <?php $class=($errors->has('video'))?'form-control is-invalid':'form-control'; ?>
                                                    {!! Form::text('video', null, ['class'=>$class, 'aria-describedby'=>'sitio_video']) !!}
                                                    @if ($errors->has('video'))
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('video') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" class="btn btn-warning mr-1">
                                            <i class="ft-arrow-left"></i> Anterior
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Guardar y Continuar
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
@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Datos Generales @endsection

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
                                        @if(isset($item->_key))
                                            <?php $e_active = 'generales';?>
                                            @include('panel.emprendimientos.inc.nav')
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link active">Datos Generales</a>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Medios Digitales</span>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Ventas</span>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Clientes/Usuarios</span>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Inversión</span>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Información Financiera</span>
                                            </li>
                                        @endif
                                    </ul>
                                    {!! Form::model($item,['action' => 'PanelEmprendimientos@SaveDatosGenerales', 'method' => 'put', 'files'=>'true']) !!}
                                    @if(isset($item->_key))
                                        <input name="id" type="hidden" value="{{$item->_key}}">
                                    @endif
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
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Logo de tu Emprendimiento en alta definición <small>(opcional)</small></label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            @if(isset($item->_key))
                                                                @if(file_exists(public_path('/emprendimientos_pics/logo_'.$item->_key.'.jpg')))
                                                                    <img src="{{url('/emprendimientos_pics/logo_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="120" height="120" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
                                                                @else
                                                                    <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type='file' name="logo" id="" accept=".jpg, .jpeg" />
                                                            @if ($errors->has('logo'))
                                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('logo') }}</strong></span>
                                                            @endif
                                                        </div>
                                                    </div>
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
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Adjunta imagen de la Cédula de Identificación Fiscal de tu Startup <small>(si aplica)</small></label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            @if(isset($item->_key))
                                                                @if(file_exists(public_path('/emprendimientos_pics/cedula_'.$item->_key.'.jpg')))
                                                                    <img src="{{url('/emprendimientos_pics/cedula_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="120" height="120" border="0" alt=""  class="rounded img-fluid" data-action="zoom"  />
                                                                @else
                                                                    <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type='file' name="cedula_identificacion" id="" accept=".jpg, .jpeg" />
                                                            @if ($errors->has('cedula_identificacion'))
                                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('cedula_identificacion') }}</strong></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Fecha de fundación <span class="required">*</span></label>
                                                    <?php $class=($errors->has('fecha_fundacion'))?'form-control is-invalid':'form-control'; ?>
                                                    {!! Form::date('fecha_fundacion', null, ['class'=>$class]); !!}
                                                    @if ($errors->has('fecha_fundacion'))
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_fundacion') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">¿Tienes una patente o IP? <span class="required">*</span></label>
                                                <?php $class=($errors->has('patente_ip'))?'form-control is-invalid':'form-control'; ?>
                                                <div class="row skin skin-flat">
                                                    <div class="col-sm-1">
                                                        <fieldset>
                                                            {!! Form::radio('patente_ip', "Si", null, ['id'=>'pat1', 'class'=>$class]); !!}
                                                            <label for="pat1">Si</label>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <fieldset>
                                                            {!! Form::radio('patente_ip', "No", null, ['id'=>'pat2', 'class'=>$class]); !!}
                                                            <label for="pat2">No</label>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                @if ($errors->has('patente_ip'))
                                                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('patente_ip') }}</strong></span>
                                                @endif
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
                                                            {!! Form::radio('investigacion_desarrollo', "Si", null, ['id'=>'in1', 'class'=>$class]); !!}
                                                            <label for="in1">Si</label>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <fieldset>
                                                            {!! Form::radio('investigacion_desarrollo', "No", null, ['id'=>'in2', 'class'=>$class]); !!}
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
                                            <?php $class=($errors->has('nivel_tlr'))?'is-invalid':''; ?>
                                            <div class="form-group {{$class}}">
                                                <label for="">¿En qué nivel de TLR estas (del 1 al 9)? <span class="required">*</span></label>
                                                <?php $class=($errors->has('nivel_tlr'))?'form-control is-invalid':'form-control'; ?>
                                                {!! Form::select('nivel_tlr', $nivel_tlr, null, ['placeholder' => 'Selecciona','class'=> 'select2 '.$class]) !!}
                                                @if ($errors->has('nivel_tlr'))
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('nivel_tlr') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Número de socios de tu emprendimiento <span class="required">*</span></label>
                                                <?php $class=($errors->has('numero_socios'))?'form-control is-invalid':'form-control'; ?>
                                                {!! Form::number('numero_socios', null, ['class'=>$class]); !!}
                                                @if ($errors->has('numero_socios'))
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('numero_socios') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">¿Alguno de tus socios ha tenido un "exit" o ha venido de una empresa? <span class="required">*</span></label>
                                                <?php $class=($errors->has('socio_exit_empresa'))?'form-control is-invalid':'form-control'; ?>
                                                <div class="row skin skin-flat">
                                                    <div class="col-sm-1">
                                                        <fieldset>
                                                            {!! Form::radio('socio_exit_empresa', "Si", null, ['id'=>'socio1', 'class'=>$class]); !!}
                                                            <label for="socio1">Si</label>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <fieldset>
                                                            {!! Form::radio('socio_exit_empresa', "No", null, ['id'=>'socio2', 'class'=>$class]); !!}
                                                            <label for="socio2">No</label>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                @if ($errors->has('socio_exit_empresa'))
                                                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('socio_exit_empresa') }}</strong></span>
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
                                    <div class="form-actions right">
                                        <!--<a href="" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> Cancelar
                                        </a>-->
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
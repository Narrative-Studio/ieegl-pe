@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Usuarios @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tiene_usuarios').on('ifChecked', function(event){
                opt = ($('input[name="tiene_usuarios"]:checked').val());
                if(opt=="Si"){
                    $('#montos_ventas').removeClass('invisible');
                    $("#montos_ventas input").attr('value', '0');
                    $("#montos_ventas input").attr('required', 'required');
                }else{
                    $('#montos_ventas').addClass('invisible');
                    $("#montos_ventas input").removeAttr('value');
                    $("#montos_ventas input").removeAttr('required');
                }
            });

            @if(old('tiene_usuarios'))
                @if(old('tiene_usuarios')=="Si")
                    $('#montos_ventas').removeClass('invisible');
                @else
                    $("#montos_ventas input").removeAttr('required');
                @endif
            @else
                @if(isset($item->tiene_usuarios) &&  $item->tiene_usuarios=="Si")
                    $('#montos_ventas').removeClass('invisible');
                @else
                    $("#montos_ventas input").removeAttr('required');
                @endif
            @endif
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
                                        <?php $e_active = 'usuarios';?>
                                        @include('panel.emprendimientos.inc.nav')
                                    </ul>
                                    {!! Form::model($item, ['action' => 'PanelEmprendimientos@SaveUsuarios', 'method' => 'post', 'files'=>'true']) !!}
                                    @if(isset($item->_key))
                                        <input name="id" type="hidden" value="{{$item->_key}}">
                                    @endif
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">¿Tienes usuarios? <span class="required">*</span></label>
                                                    <?php $class=($errors->has('tiene_usuarios'))?'form-control is-invalid':'form-control'; ?>
                                                    <div class="row skin skin-flat">
                                                        <div class="col-sm-1">
                                                            <fieldset>
                                                                {!! Form::radio('tiene_usuarios', "Si", null, ['id'=>'l1', 'class'=>'tiene_usuarios '.$class]); !!}
                                                                <label for="l1">Si</label>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <fieldset>
                                                                {!! Form::radio('tiene_usuarios', "No", null, ['id'=>'l2', 'class'=>'tiene_usuarios '.$class]); !!}
                                                                <label for="l2">No</label>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('tiene_usuarios'))
                                                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('tiene_usuarios') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div id="montos_ventas" class="invisible">
                                                <div class="row mb-2 mt-2">
                                                    <div class="col-sm-12">
                                                        <h2>Información de Usuarios</h2>
                                                        <p>Capture la siguiente información para el período solicitado:</p>
                                                    </div>
                                                </div>
                                                <!-- Meses de montos -->
                                                <div class="row">
                                                    <div class="@if(count($meses)>1) col-md-6 @else col-md-12 @endif">
                                                        <?php $i = 0;?>
                                                        @foreach($meses as $year=>$months)
                                                            @include('panel.emprendimientos.inc.tabla-usuarios')
                                                            @if(count($meses)<2)
                                                                <div class="row">
                                                                    <div class="@if(count($meses)>1) col-md-8 @else col-md-4 @endif">
                                                                        <div class="form-group">
                                                                            <label for="" class="">Número de Usuarios activos al momento </label>
                                                                            <?php $class=($errors->has("usuarios_activos"))?'form-control is-invalid':'form-control'; ?>
                                                                            <div class="input-group">
                                                                                {!! Form::number('usuarios_activos', null, ['class'=>$class, 'value'=>'0']); !!}
                                                                            </div>
                                                                            @if ($errors->has('usuarios_activos'))
                                                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('usuarios_activos') }}</strong></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <?php $i++;?>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <!--/ Meses de montos -->
                                            </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="{{action('PanelEmprendimientos@Clientes',['id'=>$item->_key])}}" class="btn btn-warning mr-1">
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
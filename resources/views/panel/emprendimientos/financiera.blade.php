@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Información Financiera @endsection

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
                                        <?php $e_active = 'financiera';?>
                                        @include('panel.emprendimientos.inc.nav')
                                    </ul>
                                    {!! Form::model($item, ['action' => 'PanelEmprendimientos@SaveFinanciera', 'method' => 'post', 'files'=>'false']) !!}
                                    @if(isset($item->_key))
                                        <input name="id" type="hidden" value="{{$item->_key}}">
                                    @endif
                                    <div class="form-body">

                                                <div class="row mb-2 mt-2">
                                                    <div class="col-sm-12">
                                                        <h2>Información Financiera</h2>
                                                        <p>Capture la siguiente información para el período solicitado:</p>
                                                    </div>
                                                </div>
                                                <!-- Meses de montos -->
                                                <div class="row">
                                                    <div class="@if(count($meses)>1) col-md-6 @else col-md-12 @endif">
                                                        <h4>Gastos que tuvo tu emprendimiento en:</h4>
                                                        <?php $i = 0;?>
                                                        @foreach($meses as $year=>$months)
                                                            @include('panel.emprendimientos.inc.tabla-montos')
                                                            @if(count($meses)<2)
                                                                <div class="row">
                                                                    <div class="@if(count($meses)>1) col-md-8 @else col-md-4 @endif">
                                                                        <div class="form-group">
                                                                            <label for="" class="">¿Cuánto fue el gasto total de tu emprendimiento el año pasado? <span class="required">*</span><small>(Si aplica)</small></label>
                                                                            <?php $class=($errors->has("gasto_total"))?'form-control is-invalid':'form-control'; ?>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">$</span>
                                                                                </div>
                                                                                {!! Form::text('gasto_total', null, ['class'=>'money '.$class, 'required' =>'required', 'value'=>'0']); !!}
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">USD</span>
                                                                                </div>
                                                                            </div>
                                                                            @if ($errors->has('gasto_total'))
                                                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('gasto_total') }}</strong></span>
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">¿Haz realizado una valoracion formal de tu emprendimiento? <span class="required">*</span></label>
                                                        <?php $class=($errors->has('valoracion_emprendimiento'))?'form-control is-invalid':'form-control'; ?>
                                                        <div class="row skin skin-flat">
                                                            <div class="col-sm-1">
                                                                <fieldset>
                                                                    {!! Form::radio('valoracion_emprendimiento', "Si", null, ['id'=>'l1', 'class'=>'valoracion_emprendimiento '.$class]); !!}
                                                                    <label for="l1">Si</label>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <fieldset>
                                                                    {!! Form::radio('valoracion_emprendimiento', "No", null, ['id'=>'l2', 'class'=>'valoracion_emprendimiento '.$class]); !!}
                                                                    <label for="l2">No</label>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('valoracion_emprendimiento'))
                                                            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('valoracion_emprendimiento') }}</strong></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        <div id="montos_ventas">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="" class="">¿Cuánto es el monto de la última valoración relizada? (USD) </label>
                                                        <?php $class=($errors->has("monto_valoracion"))?'form-control is-invalid':'form-control'; ?>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            {!! Form::text('monto_valoracion', null, ['class'=>'money '.$class, 'value'=>'0']); !!}
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">USD</span>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('monto_valoracion'))
                                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('monto_valoracion') }}</strong></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="{{action('PanelEmprendimientos@Inversion',['id'=>$item->_key])}}" class="btn btn-warning mr-1">
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
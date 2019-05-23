@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Datos Generales @endsection

@section('js')
    @if(isset($item->_key)) @if($item->userKey!=auth()->user()->_key) @include('panel.emprendimientos.inc.cancelar-inputs') @endif @endif
@endsection

@section('content')
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @if(isset($item->_key))
                                        <?php $e_active = 1;?>
                                        @include('panel.emprendimientos.inc.nav')
                                    @else
                                        <div class="icons-tab-steps wizard-circle wizard clearfix" role="application" id="steps-uid-0">
                                            <div class="steps clearfix">
                                                <ul role="tablist">
                                                    <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
                                                        <a href="#" id="steps-uid-0-t-0" href="#steps-uid-0-h-0" aria-controls="steps-uid-0-p-0"><span class="step"><i class="step-icon icon-book-open"></i></span> 1. Datos Generales</a>
                                                    </li>
                                                    <li role="tab" class="disabled" aria-disabled="true">
                                                        <a href="#" id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1"><span class="step"><i class="step-icon icon-globe"></i></span> 2. Medios Digitales</a>
                                                    </li>
                                                    <li role="tab" class="disabled" aria-disabled="true">
                                                        <a href="#" id="steps-uid-0-t-2" href="#steps-uid-0-h-2" aria-controls="steps-uid-0-p-2"><span class="step"><i class="step-icon icon-target"></i></span> 3. Mercado</a>
                                                    </li>
                                                    <li role="tab" class="disabled" aria-disabled="true">
                                                        <a href="#" id="steps-uid-0-t-3" href="#steps-uid-0-h-3" aria-controls="steps-uid-0-p-3"><span class="step"><i class="step-icon icon-pie-chart"></i></span> 4. Inversión</a>
                                                    </li>
                                                    <li role="tab" class="disabled last" aria-disabled="true">
                                                        <a href="#" id="steps-uid-0-t-4" href="#steps-uid-0-h-4" aria-controls="steps-uid-0-p-4"><span class="step"><i class="step-icon icon-calculator"></i></span> 5. Información Financiera</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    {!! Form::model($item,['action' => 'PanelEmprendimientos@SaveDatosGenerales', 'method' => 'put', 'files'=>'true']) !!}
                                        @if(isset($item->_key))
                                            <input name="id" type="hidden" value="{{$item->_key}}">
                                        @endif
                                        @include('panel.emprendimientos.inc.datos-generales')
                                        <div class="form-actions right">
                                            @if(isset($item->_key))
                                                @if($item->userKey==auth()->user()->_key)
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar y Continuar</button>
                                                @else
                                                    <a href="{{action('PanelEmprendimientos@MediosDigitales',['id'=>$item->_key])}}" class="btn btn-primary">Siguiente <i class="ft-arrow-right"></i></a>
                                                @endif
                                            @else
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar y Continuar</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection
@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Datos Generales @endsection

@section('js')
    @if(isset($item->_key)) @if($item->userKey!=auth()->user()->_key) @include('panel.emprendimientos.inc.cancelar-inputs') @endif @endif
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
                                                <span class="nav-link">Mercado</span>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Información Financiera</span>
                                            </li>
                                            <li class="nav-item">
                                                <span class="nav-link">Inversión</span>
                                            </li>
                                        @endif
                                    </ul>
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
            <!-- // Basic form layout section end -->
        </div>
    </div>
@endsection
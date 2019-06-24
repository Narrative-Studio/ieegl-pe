@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Inversión @endsection

@section('js')
    <script type="text/javascript">
    </script>
    @if($item->userKey!=auth()->user()->_key) @include('panel.emprendimientos.inc.cancelar-inputs') @endif
@endsection

@section('content')
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified mb-3">
                                        <?php $e_active = 4;?>
                                        @include('panel.emprendimientos.inc.nav')
                                    </ul>
                                    {!! Form::model($item, ['action' => 'PanelEmprendimientos@SaveInversion', 'method' => 'post', 'files'=>'false']) !!}
                                        @if(isset($item->_key))
                                            <input name="id" type="hidden" value="{{$item->_key}}">
                                        @endif
                                        @include('panel.emprendimientos.inc.inversion')
                                            <div class="form-actions right">
                                                <a href="{{action('PanelEmprendimientos@Mercado',['id'=>$item->_key])}}" class="btn btn-warning mr-1">
                                                    <i class="ft-arrow-left"></i> Anterior
                                                </a>
                                                @if($item->userKey==auth()->user()->_key)
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-save"></i> Guardar y Continuar
                                                    </button>
                                                @else
                                                    <a href="{{action('PanelEmprendimientos@Financiera',['id'=>$item->_key])}}" class="btn btn-primary">Siguiente <i class="ft-arrow-right"></i></a>
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
@endsection
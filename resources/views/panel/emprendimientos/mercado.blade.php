@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Clientes @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tiene_clientes').on('ifChecked', function(event){
                opt = ($('input[name="tiene_clientes"]:checked').val());
                if(opt=="Si"){
                    $('#montos_ventas_clientes').removeClass('invisible');
                    $("#montos_ventas_clientes input").attr('value', '0');
                    $("#montos_ventas_clientes input").attr('required', 'required');
                }else{
                    $('#montos_ventas_clientes').addClass('invisible');
                    $("#montos_ventas_clientes input").removeAttr('value');
                    $("#montos_ventas_clientes input").removeAttr('required');
                }
            });

            @if(old('tiene_clientes'))
                @if(old('tiene_clientes')=="Si")
                    $('#montos_ventas_clientes').removeClass('invisible');
                @else
                    $("#montos_ventas_clientes input").removeAttr('required');
                @endif
            @else
                @if(isset($item->tiene_clientes) &&  $item->tiene_clientes=="Si")
                    $('#montos_ventas_clientes').removeClass('invisible');
                @else
                    $("#montos_ventas_clientes input").removeAttr('required');
                @endif
            @endif
			$('.tiene_usuarios').on('ifChecked', function(event){
                opt = ($('input[name="tiene_usuarios"]:checked').val());
                if(opt=="Si"){
                    $('#montos_ventas_usuarios').removeClass('invisible');
                    $("#montos_ventas_usuarios input").attr('value', '0');
                    $("#montos_ventas_usuarios input").attr('required', 'required');
                }else{
                    $('#montos_ventas_usuarios').addClass('invisible');
                    $("#montos_ventas_usuarios input").removeAttr('value');
                    $("#montos_ventas_usuarios input").removeAttr('required');
                }
            });

            @if(old('tiene_usuarios'))
                @if(old('tiene_usuarios')=="Si")
                    $('#montos_ventas_usuarios').removeClass('invisible');
                @else
                    $("#montos_ventas_usuarios input").removeAttr('required');
                @endif
            @else
                @if(isset($item->tiene_usuarios) &&  $item->tiene_usuarios=="Si")
                    $('#montos_ventas_usuarios').removeClass('invisible');
                @else
                    $("#montos_ventas_usuarios input").removeAttr('required');
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
                                        <?php $e_active = 'mercado';?>
                                        @include('panel.emprendimientos.inc.nav')
                                    </ul>
                                    {!! Form::model($item, ['action' => 'PanelEmprendimientos@SaveMercado', 'method' => 'post', 'files'=>'false']) !!}
                                    @if(isset($item->_key))
                                        <input name="id" type="hidden" value="{{$item->_key}}">
                                    @endif
                                    @include('panel.emprendimientos.inc.mercado')
                                    <div class="form-actions right">
                                        <a href="{{action('PanelEmprendimientos@MediosDigitales',['id'=>$item->_key])}}" class="btn btn-warning mr-1">
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
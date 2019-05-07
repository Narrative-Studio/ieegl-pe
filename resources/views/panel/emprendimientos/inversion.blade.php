@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Inversión @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.invertido_capital').on('ifChecked', function(event){
                opt = ($('input[name="invertido_capital"]:checked').val());
                if(opt=="Si"){
                    $('#montos_ventas_inversion').removeClass('invisible');
                    $("#montos_ventas_inversion .repetir1 input").attr('required', 'required');
                }else{
                    $('#montos_ventas_inversion').addClass('invisible');
                    $("#montos_ventas_inversion .repetir1 input").removeAttr('required');
                }
            });

            $('.buscando_capital').on('ifChecked', function(event){
                opt = ($('input[name="buscando_capital"]:checked').val());
                if(opt=="Si"){
                    $('#buscar_capital').removeClass('invisible');
                }else{
                    $('#buscar_capital').addClass('invisible');
                }
            });

            $('.recibido_inversion').on('ifChecked', function(event){
                opt = ($('input[name="recibido_inversion"]:checked').val());
                if(opt=="Si"){
                    $('#recibir_inversion').removeClass('invisible');
                }else{
                    $('#recibir_inversion').addClass('invisible');
                }
            });

            @if(old('invertido_capital'))
                @if(old('invertido_capital')=="Si")
                    $('#montos_ventas_inversion').removeClass('invisible');
                @else
                    $("#montos_ventas_inversion .repetir input").removeAttr('required');
                @endif
            @else
                @if(isset($item->invertido_capital) &&  $item->invertido_capital=="Si")
                    $('#montos_ventas_inversion').removeClass('invisible');
                @else
                    $("#montos_ventas_inversion .repetir input").removeAttr('required');
                @endif
            @endif

            @if(old('recibido_inversion'))
                @if(old('recibido_inversion')=="Si")
                    $('#recibir_inversion').removeClass('invisible');
                @endif
            @else
                @if(isset($item->recibido_inversion) &&  $item->recibido_inversion=="Si")
                    $('#recibir_inversion').removeClass('invisible');
                @endif
            @endif

            @if(old('buscando_capital'))
                @if(old('buscando_capital')=="Si")
                    $('#buscar_capital').removeClass('invisible');
                @endif
            @else
                @if(isset($item->buscando_capital) &&  $item->buscando_capital=="Si")
                    $('#buscar_capital').removeClass('invisible');
                @endif
            @endif



            /****** Repeater Socios **********/
            // Custom Show / Hide Configurations
            var $repeater = $('.repeater-default').repeater({
                show: function () {
                    $(this).slideDown();
                    $('.money').inputmask("numeric", mask_obj);
                    $('.integer').inputmask("numeric");
                },
                hide: function(remove) {
                    if (confirm('¿Estás seguro de remover este socio?')) {
                        $(this).slideUp(remove);
                    }
                },
            });

            @if(isset($item->capital))
            $repeater.setList([
            @foreach($item->capital as $cap)
                { 'socio': '{{$cap->socio}}', 'year': '{{$cap->year}}', 'mes':'{{$cap->mes}}','monto':'{{$cap->monto}}'},
            @endforeach
            ]);
            @endif

            /****** Repeater Socios **********/
                // Custom Show / Hide Configurations
            var $repeater = $('.repeater-otros').repeater({
                    show: function () {
                        $(this).slideDown();
                        $('.money').inputmask("numeric", mask_obj);
                        $('.integer').inputmask("numeric");
                    },
                    hide: function(remove) {
                        if (confirm('¿Estás seguro de removerlo?')) {
                            $(this).slideUp(remove);
                        }
                    },
                });

            @if(isset($item->capital_otros))
            $repeater.setList([
                    @foreach($item->capital_otros as $cap)
                    { 'quien': '{{$cap->quien}}', 'year': '{{$cap->year}}', 'mes':'{{$cap->mes}}','monto':'{{$cap->monto}}','terminos':'{{$cap->terminos}}'},
                @endforeach
            ]);
            @endif
        })
    </script>
    @if($item->userKey!=auth()->user()->_key) @include('panel.emprendimientos.inc.cancelar-inputs') @endif
@endsection

@section('content')
    <div class="content-wrapper">
        @include('layouts.breadcrum')
        <div class="">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified mb-3">
                                        <?php $e_active = 'inversion';?>
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
            </section>
            <!-- // Basic form layout section end -->
        </div>
    </div>
@endsection
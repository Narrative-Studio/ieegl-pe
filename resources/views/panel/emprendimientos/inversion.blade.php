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
                    $('#montos_ventas').removeClass('invisible');
                    $("#montos_ventas .repetir1 input").attr('required', 'required');
                }else{
                    $('#montos_ventas').addClass('invisible');
                    $("#montos_ventas .repetir1 input").removeAttr('required');
                }
            });

            $('.inversion_otras').on('ifChecked', function(event){
                opt = ($('input[name="inversion_otras"]:checked').val());
                if(opt=="Si"){
                    $('#montos_otras').removeClass('invisible');
                    $("#montos_otras .repetir input").attr('required', 'required');
                }else{
                    $('#montos_otras').addClass('invisible');
                    $("#montos_otras .repetir input").removeAttr('required');
                }
            });

            @if(old('invertido_capital'))
                @if(old('invertido_capital')=="Si")
                    $('#montos_ventas').removeClass('invisible');
                @else
                    $("#montos_ventas .repetir input").removeAttr('required');
                @endif
            @else
                @if(isset($item->invertido_capital) &&  $item->invertido_capital=="Si")
                    $('#montos_ventas').removeClass('invisible');
                @else
                    $("#montos_ventas .repetir input").removeAttr('required');
                @endif
            @endif

            @if(old('inversion_otras'))
                @if(old('inversion_otras')=="Si")
                    $('#montos_otras').removeClass('invisible');
                @else
                    $("#montos_otras .repetir input").removeAttr('required');
                @endif
            @else
                @if(isset($item->inversion_otras) &&  $item->inversion_otras=="Si")
                    $('#montos_otras').removeClass('invisible');
                @else
                    $("#montos_otras .repetir input").removeAttr('required');
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
                                        <?php $e_active = 'inversion';?>
                                        @include('panel.emprendimientos.inc.nav')
                                    </ul>
                                    {!! Form::model($item, ['action' => 'PanelEmprendimientos@SaveInversion', 'method' => 'post', 'files'=>'false']) !!}
                                    @if(isset($item->_key))
                                        <input name="id" type="hidden" value="{{$item->_key}}">
                                    @endif
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">¿Tú o tus socios fundadores han invertido capital? <span class="required">*</span></label>
                                                    <?php $class=($errors->has('invertido_capital'))?'form-control is-invalid':'form-control'; ?>
                                                    <div class="row skin skin-flat">
                                                        <div class="col-sm-1">
                                                            <fieldset>
                                                                {!! Form::radio('invertido_capital', "Si", null, ['id'=>'l1', 'class'=>'invertido_capital '.$class]); !!}
                                                                <label for="l1">Si</label>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <fieldset>
                                                                {!! Form::radio('invertido_capital', "No", null, ['id'=>'l2', 'class'=>'invertido_capital '.$class]); !!}
                                                                <label for="l2">No</label>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('invertido_capital'))
                                                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('invertido_capital') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div id="montos_ventas" class="invisible">
                                                <div class="row mb-2 mt-2">
                                                    <div class="col-sm-12">
                                                        <h2>Información de Capital</h2>
                                                        <p>¿Cuánto capital ($) han invertido los socios y cuándo?</p>
                                                    </div>
                                                </div>
                                                <!-- Inversion Socios -->
                                                <div class="row repetir1">
                                                    <div class="col-sm-12">
                                                        <div class="repeater-default">
                                                            <div data-repeater-list="capital">
                                                                <div data-repeater-item>
                                                                    <div class="row">
                                                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                                                            <label>Socio <span class="required">*</span></label>
                                                                            <br>
                                                                            {!! Form::text('socio', null, ['class'=>'form-control', 'required' =>'required']); !!}
                                                                        </div>
                                                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                                                            <label>Año <span class="required">*</span></label>
                                                                            <br>
                                                                            {!! Form::text('year', null, ['class'=>'form-control integer', 'required' =>'required']); !!}
                                                                        </div>
                                                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                                                            <label>Mes <span class="required">*</span></label>
                                                                            <br>
                                                                            {!! Form::select('mes', $meses, null, ['class'=>'form-control', 'style'=>'text-transform:capitalize;', 'required' =>'required']); !!}
                                                                        </div>
                                                                        <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3">
                                                                            <label>Monto (USD) <span class="required">*</span></label>
                                                                            <br>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">$</span>
                                                                                </div>
                                                                                {!! Form::text('monto', null, ['class'=>'money form-control', 'required' =>'required']); !!}
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">USD</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                                            <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Remover</button>
                                                                        </div>
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group overflow-hidden">
                                                                <div class="">
                                                                    <button data-repeater-create class="btn btn-primary">
                                                                        <i class="ft-plus"></i> Agregar otro Socio
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/ Inversion Socios -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">¿Haz recibido inversión de otras personas o entidades? (no de los socios) <span class="required">*</span></label>
                                                            <?php $class=($errors->has('inversion_otras'))?'form-control is-invalid':'form-control'; ?>
                                                            <div class="row skin skin-flat">
                                                                <div class="col-sm-1">
                                                                    <fieldset>
                                                                        {!! Form::radio('inversion_otras', "Si", null, ['id'=>'l1', 'class'=>'inversion_otras '.$class]); !!}
                                                                        <label for="l1">Si</label>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <fieldset>
                                                                        {!! Form::radio('inversion_otras', "No", null, ['id'=>'l2', 'class'=>'inversion_otras '.$class]); !!}
                                                                        <label for="l2">No</label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            @if ($errors->has('inversion_otras'))
                                                                <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('inversion_otras') }}</strong></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Inversion Otros -->
                                                <div id="montos_otras" class="invisible">
                                                    <div class="row mb-2 mt-2">
                                                        <div class="col-sm-12">
                                                            <h2>Información de Capital de otras personas o entidades</h2>
                                                            <p>¿Cuánto capital ($) han invertido otras personas o entidades?</p>
                                                        </div>
                                                    </div>

                                                    <div class="row repetir">
                                                        <div class="col-sm-12">
                                                            <div class="repeater-otros">
                                                                <div data-repeater-list="capital_otros">
                                                                    <div data-repeater-item>
                                                                        <div class="row">
                                                                            <div class="form-group mb-1 col-sm-12 col-md-1">
                                                                                <label>Año <span class="required">*</span></label>
                                                                                <br>
                                                                                {!! Form::text('year', null, ['class'=>'form-control integer', 'required' =>'required']); !!}
                                                                            </div>
                                                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                                                <label>Mes <span class="required">*</span></label>
                                                                                <br>
                                                                                {!! Form::select('mes', $meses, null, ['class'=>'form-control', 'style'=>'text-transform:capitalize;', 'required' =>'required']); !!}
                                                                            </div>
                                                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3">
                                                                                <label>Monto (USD) <span class="required">*</span></label>
                                                                                <br>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">$</span>
                                                                                    </div>
                                                                                    {!! Form::text('monto', null, ['class'=>'money form-control', 'required' =>'required']); !!}
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">USD</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                                                <label>¿De quién? <span class="required">*</span></label>
                                                                                <br>
                                                                                {!! Form::text('quien', null, ['class'=>'form-control', 'required' =>'required']); !!}
                                                                            </div>
                                                                            <div class="form-group mb-1 col-sm-12 col-md-2">
                                                                                <label>Términos <span class="required">*</span></label>
                                                                                <br>
                                                                                {!! Form::select('terminos', $terminos, null, ['class'=>'form-control', 'style'=>'text-transform:capitalize;', 'required' =>'required']); !!}
                                                                            </div>
                                                                            <div class="form-group col-sm-12 col-md-1 text-center mt-2">
                                                                                <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Remover</button>
                                                                            </div>
                                                                            <hr>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group overflow-hidden">
                                                                    <div class="">
                                                                        <button data-repeater-create class="btn btn-primary">
                                                                            <i class="ft-plus"></i> Agregar otro
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/ Inversion Otros -->

                                                <div class="row ">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">¿Actualmente estás buscando capital? <span class="required">*</span></label>
                                                            <?php $class=($errors->has('buscando_capital'))?'form-control is-invalid':'form-control'; ?>
                                                            <div class="row skin skin-flat">
                                                                <div class="col-sm-1">
                                                                    <fieldset>
                                                                        {!! Form::radio('buscando_capital', "Si", null, ['id'=>'l1', 'class'=>'buscando_capital '.$class]); !!}
                                                                        <label for="l1">Si</label>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <fieldset>
                                                                        {!! Form::radio('buscando_capital', "No", null, ['id'=>'l2', 'class'=>'buscando_capital '.$class]); !!}
                                                                        <label for="l2">No</label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            @if ($errors->has('buscando_capital'))
                                                                <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('buscando_capital') }}</strong></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">¿Cuánto? (USD)</label>
                                                            <?php $class=($errors->has('capital_cuanto'))?'form-control is-invalid':'form-control'; ?>

                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">$</span>
                                                                </div>
                                                                {!! Form::text('capital_cuanto', null, ['class'=>'money2 form-control']); !!}
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">USD</span>
                                                                </div>
                                                            </div>

                                                            @if ($errors->has('capital_cuanto'))
                                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('capital_cuanto') }}</strong></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">¿Con qué vehículo de inversión buscas capital?</label>
                                                            <div class="row skin skin-flat col-sm-12">
                                                                @foreach($vehiculos as $key=>$val)
                                                                    <div class="radio_input">
                                                                        <fieldset>
                                                                            {!! Form::checkbox('vehiculo_inversion[]', $key, null, ['id'=>'vehiculo_'.$key, 'class'=>'form-control']); !!}
                                                                            <label for="vehiculo_{{$key}}">{{$val}}</label>
                                                                        </fieldset>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @if ($errors->has('vehiculo_inversion'))
                                                                <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('vehiculo_inversion') }}</strong></span>
                                                            @endif
                                                        </div>
                                                    </div>
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
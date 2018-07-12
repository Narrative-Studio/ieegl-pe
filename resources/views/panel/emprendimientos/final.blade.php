@extends('layouts.panel')

@section('titulo') Emprendimiento @endsection
@section('seccion') Emprendimiento @endsection
@section('accion') Confirmación @endsection

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
                                    <div class="form-body">
                                        <div class="text-center">
                                            <i class="icon-check font-large-5 mt-2 success"></i>
                                            <h1 class="mb-4 mt-1">CONFIRMACIÓN</h1>
                                        </div>
                                        <h4 class="mb-1 text-center">¡Gracias {{auth()->user()->nombre}} {{auth()->user()->apellidos}} por registar tu emprendimiento <strong>{{$item->nombre}} </strong>!</h4>
                                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel lacus ac nibh venenatis fermentum. Proin a efficitur tortor, eget tempus dui. Maecenas nec elit eu ipsum imperdiet ultricies. Etiam elementum scelerisque nunc, vel consectetur magna condimentum ac. Donec pretium gravida nibh, id facilisis enim pretium quis. Proin malesuada ultrices libero venenatis pharetra. Quisque in dolor vel massa luctus egestas. Sed accumsan ut tortor a tincidunt. Maecenas laoreet, mauris id mollis molestie, dolor ipsum efficitur magna, vel tempus sem sem non velit.</p>
                                        <hr/>
                                        <div class="form-actions text-center">
                                            <a href="{{action('PanelController@Index')}}" class="btn btn-primary">
                                                <i class="ft-home"></i> Regresar al Dashboard
                                            </a>
                                        </div>
                                    </div>
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
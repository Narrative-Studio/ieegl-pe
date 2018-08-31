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
                                        <p class="mb-4">Ahora puedes aplicar a una de las convocatorias disponibles para impulsar tu proyecto.</p>
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
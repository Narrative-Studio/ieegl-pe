@extends('layouts.panel')

@section('titulo') Perfil @endsection
@section('seccion') Perfil @endsection
@section('accion') Perfil Completo @endsection

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
                                    <div class="form-body text-center">
                                        <div class="text-center">
                                            <i class="icon-check font-large-5 mt-2 success"></i>
                                            <h1 class="mb-4 mt-1">Perfil Completo</h1>
                                        </div>
                                        <h4 class="mb-1">¡Gracias <strong>{{auth()->user()->nombre}} {{auth()->user()->apellidos}}</strong>! por completar tu perfil</h4>
                                        <p class="mb-4">Ahora puedes registrar emprendimientos y aplicar a convocatorias.</p>
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
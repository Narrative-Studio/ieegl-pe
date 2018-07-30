@extends('layouts.app')

@section('content')
<div class="card-body my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery">
    <div class="row">
        <div class="col-md-12">
        <div id="carousel-example-caption" class="carousel slide" id="portada" data-ride="carousel" data-interval="5000">
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-caption" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-caption" data-slide-to="1"></li>
                <li data-target="#carousel-example-caption" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="{{url('/')}}/img/portada.jpg" alt="">
                    <div class="carousel-caption">
                        <h3>First Slide Label</h3>
                        <p>Donut jujubes I love topping I love sweet. Jujubes I
                            love brownie gummi bears I love donut sweet chocolate.
                            Tart chocolate marshmallow.Tart carrot cake muffin.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{url('/')}}/img/portada.jpg" alt="">
                    <div class="carousel-caption">
                        <h3>Second Slide Label</h3>
                        <p>Tart macaroon marzipan I love soufflé apple pie wafer.
                            Chocolate bar jelly caramels jujubes chocolate cake
                            gummies. Cupcake cake I love cake danish carrot cake.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{url('/')}}/img/portada.jpg" alt="">
                    <div class="carousel-caption">
                        <h3>Third Slide Label</h3>
                        <p>Pudding sweet pie gummies. Chocolate bar sweet tiramisu
                            cheesecake chocolate cotton candy pastry muffin. Marshmallow
                            cake powder icing.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel-example-caption" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-caption" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    </div>
    <div class="grid-hover row">
        <div class="col-md-4 col-12 pl-0 pr-0">
            <a href="#">
                <figure class="effect-bubba">
                    <img src="{{url('/')}}/img/que_es.jpg" alt="">
                    <figcaption>
                        <h2>¿Qué es la <span>Plataforma del Emprendedor</span>?</h2>
                        <p>Tus ideas y emprendimientos visibles para todos.</p>
                    </figcaption>
                </figure>
            </a>
        </div>
        <div class="col-md-4 col-12">
            <a href="#">
                <figure class="effect-bubba">
                    <img src="{{url('/')}}/img/numeros.jpg" alt="">
                    <figcaption>
                        <h2>Números</h2>
                        <p>Como crece el segmento emprendedor.</p>
                    </figcaption>
                </figure>
            </a>
        </div>
        <div class="col-md-4 col-12 pl-0 pr-0">
            <figure class="effect-bubba">
                <img src="{{url('/')}}/img/por_que.jpg" alt="">
                <figcaption>
                    <h2>¿Por qué <span>registrarse</span>?</h2>
                    <p>Únete a la plataforma.</p>
                </figcaption>
            </figure>
        </div>
    </div>
</div>
@endsection

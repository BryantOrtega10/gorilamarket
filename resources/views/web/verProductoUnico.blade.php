@extends('layouts.web_con_cat')

@section('title')
    {{ $producto->nombre }}
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('web.index') }}" class="color-azul">Gorila market</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('web.verProductos', ['categoria' => $producto->categoria->categoria_superior]) }}">
                    {{ ucfirst(strtolower($producto->categoria->categoria_superior->nombre)) }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('web.verProductos', ['categoria' => $producto->categoria]) }}">
                    {{ ucfirst(strtolower($producto->categoria->nombre)) }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(strtolower($producto->nombre)) }}
            </li>
        </ol>
    </nav>
    <section class="producto-unico">

        <div class="row">
            <div class="col-auto">
                <div class="swiper-fotos-min-producto-cont">
                    <div class="swiper swiper-min-fotos-producto">
                        <div class="swiper-wrapper">
                            @foreach ($fotos as $foto)
                                <div class="swiper-slide">
                                    <div class="cont-img-producto-unico-min">
                                        <img src="{{ Storage::url('productos/min_' . $foto->ruta) }}"
                                            alt="{{ $producto->nombre }}" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
                <div class="swiper-fotos-producto-cont">
                    <div class="swiper swiper-fotos-producto">
                        <div class="swiper-wrapper">
                            @foreach ($fotos as $foto)
                                <div class="swiper-slide">
                                    <div class="cont-img-producto-unico">
                                        <img src="{{ Storage::url('productos/max_' . $foto->ruta) }}"
                                            alt="{{ $producto->nombre }}" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <h1>{{ $producto->nombre }}</h1>
                <div class="row">
                    @if ($producto->promocion() === null)
                        <div class="col-auto"><b>$
                                {{ number_format($producto->precioClDi(), 0, '.', '.') }}</b>
                        </div>
                    @else
                        <div class="col-auto"><b>$
                                {{ number_format($producto->precioPromo(), 0, '.', '.') }}</b>
                        </div>
                        <div class="col-auto"><s>$
                                {{ number_format($producto->precioClDi(), 0, '.', '.') }}</s>
                        </div>
                        <div class="col-auto">
                            <div class="espacio-promo">
                                <div class="porcentaje-promocion">
                                    {{ $producto->promocion()->porcentaje }} %</div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="cont-unidades-prod">
                    <a href="#" class="menos-unidades-unico"><i class="fa-solid fa-minus"></i></a>
                    <span class="cant-productos-unico">1</span>
                    <a href="#" class="mas-unidades-unico"><i class="fa-solid fa-plus"></i></a>
                    <input type="hidden" id="unidades" value="1" />
                    <input type="hidden" id="precioProd" value="{{$producto->precioPromo()}}" />
                </div><br>
                <a href="{{ route('web.agregarCarrito', ['id' => $producto->idproducto]) }}" class="btn btn-verde btn-agregar-unico">
                    <div class="row">
                        <div class="col-5 text-start">
                            <strong>Agregar</strong>
                        </div>
                        <div class="col-7 text-end">
                            <strong class="valor_u">${{number_format($producto->precioPromo(), 0, ".",".")}}</strong>
                        </div>
                    </div>
                </a>              
            </div>
        </div>
    </section>
    <section class="productos-relacionados">
        <h2>Productos relacionados</h2>
        <div class="productos swiper swiper-producto">
            <div class="swiper-wrapper">
                @foreach ($productosSugeridos as $producto)
                    <div class="swiper-slide">
                        <a href="{{route('web.verProductoUnico', ['producto' => $producto])}}" class="producto">
                            <div class="agregar-carrito"
                                data-url="{{ route('web.agregarCarrito', ['id' => $producto->idproducto]) }}">
                                <div class="icono-carrito">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                            <div class="imagen">
                                @if ($producto->fotoPpal() !== null && Storage::disk('public')->exists('productos/min_' . $producto->fotoPpal()->ruta))
                                    <img src="{{ Storage::url('productos/min_' . $producto->fotoPpal()->ruta) }}"
                                        alt="{{ $producto->nombre }}" loading="lazy" />
                                @else
                                    <img src="{{ asset('img/web/placeholder-producto.png') }}"
                                        loading="lazy" />
                                @endif
                                <div class="lazy-preloader">
                                    <img src="{{ asset('img/web/placeholder-producto.png') }}" />
                                </div>
                            </div>
                            <div class="row">
                                @if ($producto->promocion() === null)
                                    <div class="col"><b>$
                                            {{ number_format($producto->precioClDi(), 0, '.', '.') }}</b>
                                    </div>
                                @else
                                    <div class="col-auto"><b>$
                                            {{ number_format($producto->precioPromo(), 0, '.', '.') }}</b>
                                    </div>
                                    <div class="col"><s>$
                                            {{ number_format($producto->precioClDi(), 0, '.', '.') }}</s>
                                    </div>
                                @endif
                            </div>
                            <strong>{{ $producto->nombre }}</strong><br>
                            <span>{{ $producto->descripcion }}</span><br>

                            @if ($producto->promocion() !== null && intval($producto->promocion()->porcentaje) > 0)
                                <div class="espacio-promo">
                                    <div class="porcentaje-promocion">
                                        {{ $producto->promocion()->porcentaje }} %</div>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection


@section('imports')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@endsection

@section('scripts')
    <script>
        const swiper = new Swiper(".swiper-min-fotos-producto", {
            direction: 'vertical',
            slidesPerView: 4,
            freeMode: true,
            spaceBetween: 10,
            watchSlidesProgress: true,
            scrollbar: {
                el: ".swiper-scrollbar",
                hide: true,
            }
        });
        const swiper_2 = new Swiper(".swiper-fotos-producto", {

            direction: 'vertical',
            thumbs: {
                swiper: swiper,
            },
        });

        const swiper_3 = new Swiper(".swiper-producto", {
            lazy: true,
            lazyPreloaderClass: 'lazy-preloader',
            slidesPerView: 4,
            spaceBetween: 20,
            freemode: true,
            breakpoints: {
                1400: {
                    slidesPerView: 7,
                    spaceBetween: 50
                },
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 50
                }
            }
        });
    </script>
@endsection

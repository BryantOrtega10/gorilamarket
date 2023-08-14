@extends('layouts.web_sin_cat')

@section('title')
    Inicio
@endsection

@section('content')
    <section class="swiper swiper-web-1">
        <div class="swiper-wrapper">
            @forelse ($publicidades_web1 as $publicidad)
                <div class="swiper-slide">
                    <div class="cont-slide-ppal">
                        <a href="{{route('web.verProductoUnico', ['producto' => $publicidad->producto])}}"><img src="{{ Storage::url('imagenes_p/max_' . $publicidad->imagen) }}" /></a>
                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="cont-slide-ppal"><img src="{{ asset('img/web/slider-web-1.png') }}" /></div>
                </div>
                <div class="swiper-slide">
                    <div class="cont-slide-ppal"><img src="{{ asset('img/web/slider-web-1.png') }}" /></div>
                </div>
                <div class="swiper-slide">
                    <div class="cont-slide-ppal"><img src="{{ asset('img/web/slider-web-1.png') }}" /></div>
                </div>
            @endforelse
        </div>
    </section>
    <section class="promociones">
        <div class="container">
            <h2 class="text-center">Últimas promociones</h2>
            @if (sizeof($promociones) > 4)
                <div class="promociones swiper swiper-promo">
                    <div class="swipper-navigation-container">
                        <div class="gorila-button-next"><i class="fa-solid fa-chevron-right"></i></div>
                        <div class="gorila-button-prev"><i class="fa-solid fa-chevron-left"></i></div>
                    </div>
                    <div class="swiper-wrapper">
                        @forelse ($promociones as $producto)
                            <div class="swiper-slide">
                                <a href="{{route('web.verProductoUnico', ['producto' => $producto])}}" class="producto">
                                    <div class="imagen">
                                        @if ($producto->fotoPpal() !== null && Storage::disk('public')->exists('productos/min_' . $producto->fotoPpal()->ruta))
                                        <img src="{{ Storage::url('productos/min_' . $producto->fotoPpal()->ruta) }}"
                                            alt="{{ $producto->nombre }}" loading="lazy" />
                                        @else
                                        <img src="{{ asset('img/web/placeholder-producto.png') }}" loading="lazy" />
                                        @endif
                                        <div class="lazy-preloader">
                                            <img src="{{ asset('img/web/placeholder-producto.png') }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if ($producto->promocion() !== null)
                                            <div class="col"><b>$
                                                    {{ number_format($producto->precioClDi(), 0, '.', '.') }}</b>
                                            </div>
                                        @else
                                            <div class="col"><b>$
                                                    {{ number_format($producto->precioPromo(), 0, '.', '.') }}</b>
                                            </div>
                                            <div class="col"><s>$
                                                    {{ number_format($producto->precioClDi(), 0, '.', '.') }}</s>
                                            </div>
                                        @endif
                                    </div>
                                    <strong>{{ $producto->nombre }}</strong><br>
                                    <span>{{ $producto->descripcion }}</span><br>
                                    <div class="espacio-promo">
                                        @if ($producto->promocion() !== null)
                                            <div class="porcentaje-promocion">{{ $producto->promocion()->porcentaje }} %
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>Lo sentimos, en este momento no tenemos promociones activas</p>
                        @endforelse                        
                    </div>
                </div>
            @else
                <div class="promociones no-promo">
                    @forelse ($promociones as $producto)
                        <div>
                            <a href="{{route('web.verProductoUnico', ['producto' => $producto])}}" class="producto">
                                <div class="imagen">
                                    @if ($producto->fotoPpal() !== null && Storage::disk('public')->exists('productos/min_' . $producto->fotoPpal()->ruta))
                                        <img src="{{ Storage::url('productos/min_' . $producto->fotoPpal()->ruta) }}"
                                            alt="{{ $producto->nombre }}" loading="lazy" />
                                    @else
                                        <img src="{{ asset('img/web/placeholder-producto.png') }}" loading="lazy" />{{$producto->fotoPpal()}}
                                    @endif
                                </div>
                                <div class="row">
                                    @if ($producto->promocion() === null)
                                        <div class="col"><b>$
                                                {{ number_format($producto->precioClDi(), 0, '.', '.') }}</b>
                                        </div>
                                    @else
                                        <div class="col-7"><b>$
                                                {{ number_format($producto->precioPromo(), 0, '.', '.') }}</b>
                                        </div>
                                        <div class="col-5 text-end"><s>$
                                                {{ number_format($producto->precioClDi(), 0, '.', '.') }}</s>
                                        </div>
                                    @endif
                                </div>
                                <strong>{{ $producto->nombre }}</strong><br>
                                <span>{{ $producto->descripcion }}</span><br>
                                <div class="espacio-promo">
                                    @if ($producto->promocion() !== null)
                                        <div class="porcentaje-promocion">{{ $producto->promocion()->porcentaje }} %</div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @empty
                        <p>Lo sentimos, en este momento no tenemos promociones activas</p>
                    @endforelse
                </div>
            @endif

        </div>
    </section>
    <section class="categorias">

        <div class="container">
            <h2 class="text-center">Conoce todo lo que tenemos para tí</h2>
            <div class="fila">
                
                @foreach ($categorias_principales as $categoria)
                    <div class="col-categoria">
                        
                        <a href="{{route('web.verProductos',['categoria' => $categoria])}}" class="categoria-ppal">
                            <div class="cat_cont">
                            <img @if (!empty(trim($categoria->imagen)) && Storage::disk('public')->exists('categorias/max_' . $categoria->imagen)) src="{{ Storage::url('categorias/max_' . $categoria->imagen) }}"
                        @else
                        src="{{ asset('img/web/placeholder-categoria.png') }}" @endif
                                alt="{{ $categoria->nombre }}" />
                            </div>
                            <span>{{ $categoria->nombre }}</span>
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
        const swiper = new Swiper('.swiper-web-1', {
            direction: 'horizontal',
            loop: true
        });
        const swiper_2 = new Swiper(".swiper-promo", {
            lazy: true,
            lazyPreloaderClass: 'lazy-preloader',
            slidesPerView: 4,
            spaceBetween: 50,
            freemode: true,
            navigation: {
                nextEl: ".gorila-button-next",
                prevEl: ".gorila-button-prev",
            },
        });
    </script>
@endsection

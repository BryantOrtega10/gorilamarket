@extends('layouts.web_con_cat')

@section('title')
    Busqueda
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('web.index') }}" class="color-azul">Gorila market</a></li>
            <li class="breadcrumb-item active" aria-current="page">Busqueda: {{ ucfirst(strtolower($query)) }}</li>

        </ol>
    </nav>
    <section class="categoria">
        <article class="sub-categoria">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h2>Busqueda: {{ $query }}</h2>
                </div>

            </div>
            <div class="productos">
                <div class="no-swipe">
                    @forelse ($productos as $producto)
                        <div class="item-no-swipe">
                            <a href="{{ route('web.verProductoUnico', ['producto' => $producto]) }}" class="producto">
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
                                        <img src="{{ asset('img/web/placeholder-producto.png') }}" loading="lazy" />
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
                    @empty
                        <div class="no-hay-productos">
                            <h1>Lo sentimos</h1>
                            <p>No hemos encontrado resultados para "{{ $query }}"</p>
                            <a href="{{ route('web.index') }}" class="btn btn-verde">Regresar</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>



    </section>
@endsection


@section('imports')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@endsection

@section('scripts')
    <script>
        const swiper_2 = new Swiper(".swiper-producto", {
            lazy: true,
            lazyPreloaderClass: 'lazy-preloader',
            slidesPerView: 4,
            spaceBetween: 20,
            freemode: true,
            navigation: {
                nextEl: ".gorila-button-next",
                prevEl: ".gorila-button-prev",
            },
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

@extends('layouts.web_con_cat')

@section('title')
    {{$categoriaSelect->nombre}}
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('web.index') }}" class="color-azul">Gorila market</a></li>
            @if ($subCategoriaSelect !== null)
                <li class="breadcrumb-item">
                    <a
                        href="{{ route('web.verProductos', ['categoria' => $categoriaSelect]) }}">{{ ucfirst(strtolower($categoriaSelect->nombre)) }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(strtolower($subCategoriaSelect->nombre)) }}
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(strtolower($categoriaSelect->nombre)) }}
                </li>
            @endif
        </ol>
    </nav>
    <section class="categoria">
        @if ($subCategoriaSelect !== null)
            @if (sizeof($productos) > 0)
                <article class="sub-categoria">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <h2>{{ $subCategoriaSelect->nombre }}</h2>
                        </div>

                    </div>

                    <div class="productos">
                        <div class="no-swipe">
                            @foreach ($productos as $producto)
                                <div class="item-no-swipe">
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
                </article>
            @endif
        @else
            @foreach ($categoriaSelect->sub_categorias as $subcategoria)
                @if (sizeof($productos[$subcategoria->idcategorias]) > 0)
                    <article class="sub-categoria">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <h2>{{ $subcategoria->nombre }}</h2>
                            </div>

                        </div>

                        <div class="productos swiper swiper-producto">
                            <div class="swipper-navigation-container">
                                <div class="gorila-button-next"><i class="fa-solid fa-chevron-right"></i></div>
                                <div class="gorila-button-prev"><i class="fa-solid fa-chevron-left"></i></div>
                                <div class="ver-mas-superior"><a
                                        href="{{ route('web.verProductos', ['categoria' => $categoriaSelect, 'sub_categoria' => $subcategoria]) }}">Ver
                                        Mas</a></div>
                            </div>
                            <div class="swiper-wrapper">
                                @foreach ($productos[$subcategoria->idcategorias] as $producto)
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
                                <div class="swiper-slide">
                                    <div class="ver-mas-interno">
                                        <a
                                            href="{{ route('web.verProductos', ['categoria' => $categoriaSelect, 'sub_categoria' => $subcategoria]) }}">
                                            <i class="fa-solid fa-arrow-right"></i>
                                            <span>Ver Mas</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif
            @endforeach
        @endif


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

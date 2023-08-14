<aside class="carrito">
    @if (sizeof($carrito) > 0)
    <div class="container-fluid">
        <div class="row">
            <div class="col-10">
                <h3>Tu carrito</h3>
            </div>
            <div class="col-2">
                <div class="cerrar_carrito"></div>
            </div>
        </div>
        <div class="productos-carrito">
            @foreach ($carrito as $producto)
                <div class="producto" data-id="{{$producto->idproducto}}">
                    <div class="row">
                        <div class="col-auto">
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
                            @if ($producto->promocion() !== null && intval($producto->promocion()->porcentaje) > 0)
                                <div class="espacio-promo">
                                    <div class="porcentaje-promocion">
                                        {{ $producto->promocion()->porcentaje }} %</div>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-12">
                                    <strong>{{ $producto->nombre }}</strong><br>
                                    <span>{{ $producto->descripcion }}</span><br>
                                </div>
                            </div>
                            <div class="row py-4">
                                @if ($producto->promocion() === null)
                                    <div class="col"><b class="precio1" data-id="{{$producto->idproducto}}">$
                                            {{ number_format($producto->precioClDi() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</b>
                                            <s class="precio2 d-none" data-id="{{$producto->idproducto}}">$
                                                {{ number_format($producto->precioClDi() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</s>
                                    </div>
                                @else
                                    <div class="col-auto"><b class="precio1" data-id="{{$producto->idproducto}}">$
                                            {{ number_format($producto->precioPromo() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</b>
                                    </div>
                                    <div class="col"><s class="precio2" data-id="{{$producto->idproducto}}">$
                                            {{ number_format($producto->precioClDi() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</s>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{route('web.quitarCarrito',['id' => $producto->idproducto])}}" class="menos-unidades"><i class="fa-solid fa-minus"></i></a>
                                    <span class="cant-productos-carrito" data-id="{{$producto->idproducto}}">{{Session::get('carrito')->productos[$producto->idproducto]}}</span>
                                    <a href="{{route('web.agregarCarrito',['id' => $producto->idproducto])}}" class="mas-unidades"><i class="fa-solid fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if (Auth::check())
            <a href="{{route('web.pagar')}}" class="btn btn-pagar">
                <div class="row">
                    <div class="col-5 text-start">
                        <b>Pagar</b>
                    </div>
                    <div class="col-7 text-end">
                        Subtotal <b class="subtotal">${{number_format(Session::get('carrito')->subtotal ?? 0, 0, ".",".")}}</b>
                    </div>
                </div>
            </a>
        @else
            <p class="aside text-center mb-0 mt-4">Debes iniciar sesión para poder continuar</p>
            <a href="{{route('web.ingresar')}}" class="btn btn-pagar my-0">
                <div class="row">
                    <div class="col-12 text-center">
                        <b>Ingresar</b>
                    </div>
                </div>
            </a>
        @endif
        <div class="text-center">
            <a href="{{route('web.vaciar')}}" class="btn btn-vaciar">
                Vaciar canasta <img src="{{asset('img/web/vaciar.png')}}" />
            </a>
        </div>
    </div>
    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-10">
                <h3>Tu carrito</h3>
            </div>
            <div class="col-2">
                <div class="cerrar_carrito"></div>
            </div>
        </div>
        <div class="carro_vacio">
            <img src="{{asset('img/web/carro_vacio.png')}}" />
            <div class="msg_carro_vacio">Aun no tienes productos en tu carrito. Busca lo que necesites en la tienda y descubre todo lo que tenemos para ti.</div>
        </div>
        <a href="#" class="btn btn-pagar btn-agregar-productos">
            <b>Agregar productos</b>
        </a>
    </div>
    @endif
</aside>
<div class="overlay-carrito"></div>
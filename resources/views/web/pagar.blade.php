@extends('layouts.web_sin_carrito')

@section('title')
    Pagar
@endsection

@section('content')
    <div class="container mi-carrito-completo">
        @if (session('error'))
        <div class="alert alert-danger my-3">
            <strong>{{ session('error') }}</strong>
        </div>
        @endif
        <div class="row">
            <div class="col-12 col-md-6 px-3">
                <h1>Mi Pedido</h1>
                <div class="productos-carrito">
                    @foreach ($carrito as $producto)
                        <div class="producto" data-id="{{ $producto->idproducto }}">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="imagen">
                                        @if ($producto->fotoPpal() !== null && Storage::disk('public')->exists('productos/min_' . $producto->fotoPpal()->ruta))
                                            <img src="{{ Storage::url('productos/min_' . $producto->fotoPpal()->ruta) }}"
                                                alt="{{ $producto->nombre }}" loading="lazy" />
                                        @else
                                            <img src="{{ asset('img/web/placeholder-producto.png') }}" loading="lazy" />
                                        @endif
                                    </div>
                                    @if ($producto->promocion() !== null && intval($producto->promocion()->porcentaje) > 0)
                                        <div class="espacio-promo">
                                            <div class="porcentaje-promocion">
                                                {{ $producto->promocion()->porcentaje }} %</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col py-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <strong>{{ $producto->nombre }}</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <span>{{ $producto->descripcion }}</span><br><br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="{{ route('web.quitarCarrito', ['id' => $producto->idproducto]) }}"
                                                        class="menos-unidades"><i class="fa-solid fa-minus"></i></a>
                                                    <span class="cant-productos-carrito"
                                                        data-id="{{ $producto->idproducto }}">{{ Session::get('carrito')->productos[$producto->idproducto] }}</span>
                                                    <a href="{{ route('web.agregarCarrito', ['id' => $producto->idproducto]) }}"
                                                        class="mas-unidades"><i class="fa-solid fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 text-center">
                                            @if ($producto->promocion() === null)
                                                <div><b class="precio1" data-id="{{ $producto->idproducto }}">$
                                                        {{ number_format($producto->precioClDi() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</b>
                                                    <s class="precio2 d-none" data-id="{{ $producto->idproducto }}">$
                                                        {{ number_format($producto->precioClDi() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</s>
                                                </div>
                                            @else
                                                <div><b class="precio1" data-id="{{ $producto->idproducto }}">$
                                                        {{ number_format($producto->precioPromo() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</b>
                                                </div><br>
                                                <div><s class="precio2" data-id="{{ $producto->idproducto }}">$
                                                        {{ number_format($producto->precioClDi() * Session::get('carrito')->productos[$producto->idproducto], 0, '.', '.') }}</s>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="quitar-producto"
                                        data-url="{{ route('web.quitarTodoCarrito', ['id' => $producto->idproducto]) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="totales">
                    <div class="row">
                        <div class="col text-start">Subtotal</div>
                        <div class="col text-end subtotal">
                            ${{ number_format(Session::get('carrito')->subtotal ?? 0, 0, '.', '.') }}</div>
                    </div>
                    <div class="row domicilio">
                        <div class="col text-start">Costo del domicilio</div>
                        <div class="col text-end costoDomicilio">
                            ${{ number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.') }}</div>
                    </div>
                    <div class="row">
                        <div class="col text-start">Descuento</div>
                        <div class="col text-end descuento">${{ number_format($descuento ?? 0, 0, '.', '.') }}</div>
                    </div>
                    <div class="row">
                        <div class="col text-start">Total</div>
                        <div class="col text-end total">${{ number_format($total ?? 0, 0, '.', '.') }}</div>
                    </div>
                </div>
                <div class="productos-destacados">
                    <h3>Producto sugerido</h3>
                    <div class="cont-productos-destacados">
                        @foreach ($productosDestacados as $producto)
                            <div class="item-no-swipe">
                                <a href="#" class="producto">
                                    <div class="agregar-carrito reload"
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
            </div>
            <div class="col-12 col-md-6 px-3">
                <div class="datos-pago">
                    <form action="{{ route('web.pagar') }}" method="POST">
                        @csrf
                        <div class="item-detalle-pago pago-direccion">
                            <label>Dirección de envío</label>
                            <input type="text" class="form-control" id="direccion_carrito" name="direccion_carrito"
                                placeholder="Escribe tu dirección donde llegara tu pedido" readonly required
                                value="{{ Session::get('direccion')->direccionCompleta ?? '' }}" />
                            @error('direccion_carrito')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" class="form-control" id="direccion_adicional_carrito"
                                name="direccion_adicional_carrito" placeholder="Datos adicionales: Casa, Apartamento..."
                                value="{{ Session::get('direccion')->adicionales ?? '' }}" />
                        </div>
                        <div class="item-detalle-pago pago-cupon">
                            <label>Redimir cupón</label>
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <input type="text" id="cupon-txt" class="form-control my-0"
                                        @if ($successCupon) readonly @endif
                                        placeholder="Registra tu cupón aquí para efectuar el descuento"
                                        value="{{ Session::get('cupon') ?? '' }}" />
                                </div>
                                @if (Session::has('cupon'))
                                    <div class="col-auto">
                                        <a class="btn btn-azul quitar-cupon"
                                            href="{{ route('web.quitarCupon') }}">Quitar</a>
                                    </div>
                                @else
                                    <div class="col-auto">
                                        <a class="btn btn-azul verificar-cupon"
                                            href="{{ route('web.cupon') }}">Verificar</a>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <b
                                        class="@if ($successCupon) text-success @else text-danger @endif respuestaCodigo @if (!Session::has('cupon')) d-none @endif">{{ $respuestaTexto }}</b>
                                </div>
                            </div>
                        </div>
                        <div class="item-detalle-pago pago-fecha-entrega">
                            <label>¿Cuándo quieres recibir tu pedido?</label>
                            <select class="form-select" name="fechaPedido" id="fechaPedido" required>
                                <option value="">Selecciona el día para recibir tu pedido</option>
                                @foreach ($diasPedido as $diaPedido)
                                    <option value="{{ $diaPedido }}">{{ $diaPedido }}</option>
                                @endforeach
                            </select>
                            <select class="form-select" id="horaPedido" name="horaPedido" required>
                                <option value="">Selecciona la hora para recibir tu pedido</option>
                                <option value="horaMan" @if (Session::get('carrito') != null && Session::get('carrito')->horaEntrega == 'horaMan') selected @endif>Mañana</option>
                                <option value="horaTar" @if (Session::get('carrito') != null && Session::get('carrito')->horaEntrega == 'horaTar') selected @endif>Tarde</option>
                                <option value="horaNoc" @if (Session::get('carrito') != null && Session::get('carrito')->horaEntrega == 'horaNoc') selected @endif>Noche</option>
                            </select>
                        </div>
                        <div class="item-detalle-pago pago-metodo-pago">
                            <label>Método de pago</label>
                            <select class="form-select" name="metodo_pago" id="metodo_pago" required>
                                <option value="">Selecciona la manera más fácil de pagar</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="datafono">Datafono</option>
                            </select>
                        </div>
                        <div class="item-detalle-pago pago-metodo-pago">
                            <label>¿No encontraste lo que buscabas?</label>
                            <textarea class="form-control" name="producto_no_encontrado"
                                placeholder="Escribe tu sugerencias de los productos que deberían estar en Gorilla marker "></textarea>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-verde">Realizar pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script></script>
@endsection

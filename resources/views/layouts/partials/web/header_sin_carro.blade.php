<nav class="navbar navbar-gorila">
    <div class="navbar-left">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/web/logo.png') }}" alt="Gorila Market">
        </a>
        <a class="navbar-direccion btn" href="{{route('web.direccion.mostrar')}}">
            <img src="{{ asset('img/web/direccion.png') }}" class="img-direccion">
            @if (Session::has('direccion'))
                {{ Session::get('direccion')->direccionCompleta }}
            @else
                Selecciona una dirección
            @endif
        </a>
    </div>
    <div class="navbar-center">
        <div class="navbar-search">
            <form class="search-form" action="{{route('web.buscarProducto')}}">
                
                <input class="form-control" type="text" placeholder="Huevos, arroz, carne, vino"
                    aria-label="Buscador" name="query">
                <button type="submit" class="btn">
                    <img src="{{ asset('img/web/buscar-azul.png') }}" />
                </button>
            </form>
        </div>
    </div>
    <div class="navbar-right">
        <div class="navbar-buttons">
            <a class="btn btn-icono btn-ingresar btn-ingresar-sin-carro btn-ingresar @guest  @else logout-c @endguest" @guest href="{{route('web.ingresar')}}" @else href="#" @endguest>
                <img src="{{ asset('img/web/ingresar.png') }}">
                @guest
                    <span class="span-ingresar">Ingresar</span>
                @else
                    <span class="span-ingresar">Hola, {{ Auth::user()->name }}</span>
                @endguest
            </a>
            <a href="{{route('web.mostrar')}}" class="btn btn-icono btn-carrito d-none">
                <img src="{{ asset('img/web/carrito.png') }}">
                <span class="cantidad-productos @if (!Session::has('carrito') || Session::get('carrito')->cuentaProductos == 0) d-none @endif">{{Session::get('carrito')->cuentaProductos ?? 0}}</span>
                <span>Carrito</span>
            </a>
        </div>
    </div>
</nav>
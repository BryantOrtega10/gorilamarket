<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bienvenido') | {{ config('app.name', 'Gorila Market') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/web.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <!--Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">

    <!--FavIcon-->
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{ asset('img/favicon.ico') }}">

    <!-- imports adicionales -->
    @yield('imports')


</head>

<body>
    @include('layouts.partials.web.header')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <aside class="col-auto col-md-3 col-xl-2 px-0 pe-4">
                <div class="d-flex flex-column align-items-center min-vh-100">
                    <ul class="menu">
                        @foreach ($categoriasPrincipales as $categoria)
                            <li class="item @if ($categoriaSelect !== null && $categoria->idcategorias == $categoriaSelect->idcategorias) seleccionado @endif"
                                data-open="#submenu{{ $categoria->idcategorias }}">
                                <a href="{{ route('web.verProductos', ['categoria' => $categoria]) }}">
                                    <span>{{ $categoria->nombre }}</span>
                                </a>
                                <ul id="submenu{{ $categoria->idcategorias }}"
                                    class="@if ($categoriaSelect !== null && $categoria->idcategorias == $categoriaSelect->idcategorias) abierto @endif">
                                    @foreach ($categoria->sub_categorias as $sub_categoria)
                                        <li class="w-100">
                                            <a
                                                href="{{ route('web.verProductos', ['categoria' => $categoria, 'sub_categoria' => $sub_categoria]) }}">
                                                {{ $sub_categoria->nombre }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
            <main class="col-auto col-md-9 col-xl-10 py-3 ps-5 borde-main">@yield('content')</main>
        </div>
    </div>
    @include('layouts.partials.web.footer')
    @yield('scripts')
</body>

</html>

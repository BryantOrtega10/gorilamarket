@extends('adminlte::page')

@section('title', 'Agregar administrador')

@section('content_header')
    <h1>Agregar administrador</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('administrador.tabla') }}" class="color-azul">Administrador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar</li>
        </ol>
    </nav>

@stop

@section('content')
    <div class="container-fluid">
        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-verde my-4">
                    <form method="POST" action="{{ route('administrador.agregar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Nombre:</label>
                                        <input id="nombre" type="text"
                                            class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                            value="{{ old('nombre') }}" autocomplete="nombre" autofocus>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="usuario" class="form-label">Usuario:</label>
                                        <input id="usuario" type="text"
                                            class="form-control @error('usuario') is-invalid @enderror" name="usuario"
                                            value="{{ old('usuario') }}" autocomplete="usuario" autofocus>
                                        @error('usuario')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="pass" class="form-label">Contraseña:</label>
                                        <input id="pass" type="password"
                                            class="form-control @error('pass') is-invalid @enderror" name="pass"
                                            value="{{ old('pass') }}" autocomplete="pass" autofocus>
                                        @error('pass')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="rpass" class="form-label">Repita la contraseña:</label>
                                        <input id="rpass" type="password"
                                            class="form-control @error('rpass') is-invalid @enderror" name="rpass"
                                            value="{{ old('rpass') }}" autocomplete="rpass" autofocus>
                                        @error('rpass')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12"><b>Permisos</b></div>
                                <div class="col-12 cont-permisos">
                                    @foreach ($menus as $menu)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$menu->idmenu}}" 
                                            @if (in_array($menu->idmenu,old("permisos",[])))
                                                checked
                                            @endif
                                            id="permisos_{{$menu->idmenu}}" name="permisos[]">
                                            <label class="form-check-label" for="permisos_{{$menu->idmenu}}">
                                                {{$menu->nombre}}
                                            </label>
                                        </div>
                                    @endforeach                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-verde">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')
    <script>
        $('#imagen').on('change', function() {
            const nombre = $(this).val();
            const inp = $(this)[0];
            let textoHtml = '';
            for (let i = 0; i < inp.files.length; ++i) {
                const name = inp.files.item(i).name;
                textoHtml += name + ", ";
            }
            textoHtml = textoHtml.slice(0, textoHtml.length - 2)
            $(this).next('.custom-file-label').html(textoHtml);
        })
    </script>
@stop

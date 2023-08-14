@extends('adminlte::page')

@section('title', 'Modificar promoción')

@section('content_header')
    <h1>Modificar Promoción</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('promocion.tabla') }}" class="color-azul">Promociones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modificar</li>
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
                    <form method="POST" action="{{ route('promocion.modificar',['id' => $promocion->idpromociones]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="fk_producto" class="form-label">Id Producto</label>
                                        <input id="fk_producto" type="text"
                                            class="form-control @error('fk_producto') is-invalid @enderror" name="fk_producto"
                                            value="{{ old('fk_producto',$promocion->fk_producto) }}" autocomplete="fk_producto" autofocus>
                                        @error('fk_producto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="porcentaje" class="form-label">Porcentaje</label>
                                        <input id="porcentaje" type="number" min="1" max="100"
                                            class="form-control @error('porcentaje') is-invalid @enderror" name="porcentaje"
                                            value="{{ old('porcentaje',$promocion->porcentaje) }}" autocomplete="porcentaje" autofocus>
                                        @error('porcentaje')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                        <input id="fecha_inicio" type="date"
                                            class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio"
                                            value="{{ old('fecha_inicio',$promocion->fecha_inicio) }}" autocomplete="fecha_inicio" autofocus>
                                        @error('fecha_inicio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="fecha_fin" class="form-label">Fecha de fin</label>
                                        <input id="fecha_fin" type="date"
                                            class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin"
                                            value="{{ old('fecha_fin',$promocion->fecha_fin) }}" autocomplete="fecha_fin" autofocus>
                                        @error('fecha_fin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-verde">Modificar</button>
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

    </script>
@stop

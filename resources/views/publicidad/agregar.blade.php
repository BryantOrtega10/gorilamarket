@extends('adminlte::page')

@section('title', 'Agregar publicidad')

@section('content_header')
    <h1>Agregar Publicidad</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('publicidad.tabla') }}" class="color-azul">Publicidad</a></li>
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
                    <form method="POST" action="{{ route('publicidad.agregar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <label for="imagen" class="form-label">Imagen</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="imagen" id="imagen" accept="image/*">
                                        <label class="custom-file-label" for="imagen">Selecciona la imagen</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="link" class="form-label">Id Producto</label>
                                        <input id="link" type="text"
                                            class="form-control @error('link') is-invalid @enderror" name="link"
                                            value="{{ old('link') }}" autocomplete="link" autofocus>
                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="tipo" class="form-label">Ubicación</label>
                                        <select id="tipo" class="form-control @error('tipo') is-invalid @enderror"
                                            name="tipo">
                                            <option value="" class="d-none">Seleccione</option>
                                            <option value="1" @if (old('tipo') == '1') selected @endif>WEB - 1 (1440 x 424)</option>
                                            <option value="2" @if (old('tipo') == '2') selected @endif>WEB - 2</option>
                                            <option value="3" @if (old('tipo') == '3') selected @endif>WEB - 3</option>
                                            <option value="4" @if (old('tipo') == '4') selected @endif>APP</option>
                                        </select>
                                        @error('tipo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>  
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

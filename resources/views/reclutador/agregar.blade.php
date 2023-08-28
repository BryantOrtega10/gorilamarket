@extends('adminlte::page')

@section('plugins.JQueryNumberFormat', true)

@section('title', 'Agregar reclutador')

@section('content_header')
    <h1>Agregar reclutador</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('reclutador.tabla') }}" class="color-azul">Reclutadores</a></li>
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
                    <form method="POST" action="{{ route('reclutador.agregar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="cedula" class="form-label">Cedula</label>
                                        <input id="cedula" type="text"
                                            class="form-control @error('cedula') is-invalid @enderror" name="cedula"
                                            value="{{ old('cedula') }}" autocomplete="cedula" autofocus>
                                        @error('cedula')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
                                        <label for="apellido" class="form-label">Apellido:</label>
                                        <input id="apellido" type="text"
                                            class="form-control @error('apellido') is-invalid @enderror" name="apellido"
                                            value="{{ old('apellido') }}" autocomplete="apellido" autofocus>
                                        @error('apellido')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Correo:</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="celular" class="form-label">Celular:</label>
                                        <input id="celular" type="text"
                                            class="form-control @error('celular') is-invalid @enderror" name="celular"
                                            value="{{ old('celular') }}" autocomplete="celular" autofocus>
                                        @error('celular')
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
        });
        $(".number-format").inputmask({
            alias: "currency",
            removeMaskOnSubmit: true
        });
        $("#apFechas").change(function(e) {
            if ($(this).prop("checked")) {
                $("#b-fechas").removeClass("d-none");
            } else {
                $("#b-fechas").addClass("d-none");
            }
        });

        $("#apPrecio").change(function(e) {
            if ($(this).prop("checked")) {
                $("#b-precio").removeClass("d-none");
            } else {
                $("#b-precio").addClass("d-none");
            }
        });

        $("#tipoValor").change(function(e) {
            if ($(this).val() == "1") {
                $("#valor").removeClass("number-format");
                $("#valor").inputmask("remove");
            } else {
                $("#valor").addClass("number-format");
                $("#valor").inputmask({
                    alias: "currency",
                    removeMaskOnSubmit: true
                });
            }
        });
    </script>
@stop

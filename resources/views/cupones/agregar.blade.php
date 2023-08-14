@extends('adminlte::page')

@section('plugins.JQueryNumberFormat', true)

@section('title', 'Agregar cupón')

@section('content_header')
    <h1>Agregar cupón</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cupones.tabla') }}" class="color-azul">Cupones</a></li>
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
                    <form method="POST" action="{{ route('cupones.agregar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="cupon" class="form-label">Cupon</label>
                                        <input id="cupon" type="text"
                                            class="form-control @error('cupon') is-invalid @enderror" name="cupon"
                                            value="{{ old('cupon') }}" autocomplete="cupon" autofocus>
                                        @error('cupon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="no_cupones" class="form-label">Cantidad Disponible:</label>
                                        <input id="no_cupones" type="number" min="1"
                                            class="form-control @error('no_cupones') is-invalid @enderror" name="no_cupones"
                                            value="{{ old('no_cupones') }}" autocomplete="no_cupones" autofocus>
                                        @error('no_cupones')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="valor" class="form-label">Valor:</label>
                                        <input id="valor" type="text"
                                            class="form-control @if (old('tipoValor') != '1') number-format @endif @error('valor') is-invalid @enderror"
                                            name="valor" value="{{ old('valor') }}" autocomplete="valor" autofocus>
                                        @error('valor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="tipoValor" class="form-label">Tipo de valor</label>
                                        <select id="tipoValor" class="form-control @error('tipoValor') is-invalid @enderror"
                                            name="tipoValor">
                                            <option value="" class="d-none">Seleccione</option>
                                            <option value="1" @if (old('tipoValor') == '1') selected @endif>
                                                Porcentaje</option>
                                            <option value="2" @if (old('tipoValor') == '2') selected @endif>Valor
                                            </option>
                                        </select>
                                        @error('tipoValor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-check">
                                    <input class="form-check-input" type="checkbox" @if (old('apFechas') == "1") checked @endif value="1" id="apFechas"
                                        name="apFechas">
                                    <label class="form-check-label" for="apFechas">
                                        Aplica bloqueo por fechas
                                    </label>
                                </div>
                            </div>
                            <div class="row @if (old('apFechas') != "1") d-none @endif" id="b-fechas">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="fecha_inicio" class="form-label">Fecha/Hora inicio</label>
                                        <input id="fecha_inicio" type="datetime-local"
                                            class="form-control @error('fecha_inicio') is-invalid @enderror"
                                            name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                                            autocomplete="fecha_inicio" autofocus>
                                        @error('fecha_inicio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="fecha_fin" class="form-label">Fecha/Hora fin</label>
                                        <input id="fecha_fin" type="datetime-local"
                                            class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin"
                                            value="{{ old('fecha_fin') }}" autocomplete="fecha_fin" autofocus>
                                        @error('fecha_fin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="apPrecio" @if (old('apPrecio') == "1") checked @endif
                                        name="apPrecio">
                                    <label class="form-check-label" for="apPrecio">
                                        Aplica bloqueo por precio
                                    </label>
                                </div>
                            </div>
                            <div class="row @if (old('apPrecio') != "1") d-none @endif" id="b-precio">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="precioMin" class="form-label">Precio Minimo</label>
                                        <input id="precioMin" type="text"
                                            class="form-control number-format @error('precioMin') is-invalid @enderror"
                                            name="precioMin" value="{{ old('precioMin') }}" autocomplete="precioMin"
                                            autofocus>
                                        @error('precioMin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="precioMax" class="form-label">Precio Máximo</label>
                                        <input id="precioMax" type="text"
                                            class="form-control number-format @error('precioMax') is-invalid @enderror"
                                            name="precioMax" value="{{ old('precioMax') }}" autocomplete="precioMax"
                                            autofocus>
                                        @error('precioMax')
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

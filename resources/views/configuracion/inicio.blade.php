@extends('adminlte::page')

@section('title', 'Configuración')

@section('plugins.JQueryNumberFormat', true)


@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Configuración</h1>
        </div>
    </div>
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
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Descuento referido</h3>
                </div>
                <form method="POST" action="{{ route('configuracion.referidos') }}" enctype="multipart/form-data">
                    @csrf                   
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valor" class="form-label">Valor:</label>
                                    <input id="valor" type="text"
                                        class="form-control text-right @if (old('tipo_valor', $porcentajeReferido->tipo_valor) != '1') number-format @endif @error('valor') is-invalid @enderror"
                                        name="valor" value="{{ old('valor', $porcentajeReferido->valor) }}"
                                        autocomplete="valor" autofocus>
                                    @error('valor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tipo_valor" class="form-label">Tipo de valor</label>
                                    <select id="tipo_valor" class="form-control @error('tipo_valor') is-invalid @enderror"
                                        name="tipo_valor">
                                        <option value="" class="d-none">Seleccione</option>
                                        <option value="1" @if (old('tipo_valor', $porcentajeReferido->tipo_valor) == '1') selected @endif>
                                            Porcentaje</option>
                                        <option value="2" @if (old('tipo_valor', $porcentajeReferido->tipo_valor) == '2') selected @endif>Valor
                                        </option>
                                    </select>
                                    @error('tipo_valor')
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
        <div class="col-12 col-md-6">
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Costo domicilio</h3>
                </div>
                <form method="POST" action="{{ route('configuracion.domicilios') }}" enctype="multipart/form-data">
                    @csrf                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valorMan" class="form-label">Valor mañana:</label>
                                    <input id="valorMan" type="text"
                                        class="form-control text-right number-format @error('valorMan') is-invalid @enderror"
                                        name="valorMan" value="{{ old('valorMan', $valoresDomicilio[0]->valor) }}"
                                        autocomplete="valorMan" autofocus>
                                    @error('valorMan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valorTar" class="form-label">Valor tarde:</label>
                                    <input id="valorTar" type="text"
                                        class="form-control text-right number-format @error('valorTar') is-invalid @enderror"
                                        name="valorTar" value="{{ old('valorTar', $valoresDomicilio[1]->valor) }}"
                                        autocomplete="valorTar" autofocus>
                                    @error('valorTar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valorNoc" class="form-label">Valor noche:</label>
                                    <input id="valorNoc" type="text"
                                        class="form-control text-right number-format @error('valorNoc') is-invalid @enderror"
                                        name="valorNoc" value="{{ old('valorNoc', $valoresDomicilio[2]->valor) }}"
                                        autocomplete="valorNoc" autofocus>
                                    @error('valorNoc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valorCup" class="form-label">Valor con cupón:</label>
                                    <input id="valorCup" type="text"
                                        class="form-control text-right number-format @error('valorCup') is-invalid @enderror"
                                        name="valorCup" value="{{ old('valorCup', $valoresDomicilio[3]->valor) }}"
                                        autocomplete="valorCup" autofocus>
                                    @error('valorCup')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valorGratis" class="form-label">Gratis despues de:</label>
                                    <input id="valorGratis" type="text"
                                        class="form-control text-right number-format @error('valorGratis') is-invalid @enderror"
                                        name="valorGratis" value="{{ old('valorGratis', $valoresDomicilio[4]->valor) }}"
                                        autocomplete="valorGratis" autofocus>
                                    @error('valorGratis')
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

@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $(".number-format").inputmask({
            alias: "currency",
            removeMaskOnSubmit: true
        });
        $("#tipo_valor").change(function(e) {
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

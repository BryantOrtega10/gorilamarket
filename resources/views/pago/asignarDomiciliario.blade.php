@extends('adminlte::page')

@section('title', 'Asignar domiciliario')

@section('content_header')
    <h1>Asignar domiciliario al pedido #{{ $pago->idpago }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pago.tabla') }}" class="color-azul">Pedidos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asignar domiciliario</li>
        </ol>
    </nav>


@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-verde">
                <form method="POST" action="{{ route('pago.domiciliario', ['id' => $pago->idpago]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 col-xl-3">
                                <div class="form-group">
                                    <label for="domiciliario" class="form-label">Domiciliario</label>
                                    <select id="domiciliario"
                                        class="form-control @error('domiciliario') is-invalid @enderror"
                                        name="domiciliario">
                                        <option value="">Seleccione uno</option>
                                        @foreach ($domiciliarios as $domiciliario)
                                            <option value="{{ $domiciliario->iddomiciliario }}"
                                                @if (old('domiciliario', $domiciliarioSel->iddomiciliario ?? '') == $domiciliario->iddomiciliario) selected @endif>
                                                {{ $domiciliario->nombre }} {{ $domiciliario->apellido }}</option>
                                        @endforeach
                                    </select>
                                    @error('domiciliario')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-verde">Asignar domiciliario</button>
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

@stop

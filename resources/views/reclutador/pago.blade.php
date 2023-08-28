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
                    <form method="POST" action="{{ route('reclutador.pago',['id' => $id_reclutador]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="valor_pagado" class="form-label">Valor Pagado</label>
                                        <input id="valor_pagado" type="text"
                                            class="form-control number-format @error('valor_pagado') is-invalid @enderror" name="valor_pagado"
                                            value="{{ old('valor_pagado') }}" autocomplete="valor_pagado" autofocus>
                                        @error('valor_pagado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-verde">Agregar Pago</button>
                        </div>
                    </form>
                </div>
                <div class="card card-verde my-4">
                    <div class="card-header">
                        <h3 class="card-title">Historial de pagos</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>Número del pago</th>
                                <th>Valor pagado</th>
                                <th>Fecha pago</th>
                            </thead>
                            <tbody>
                                @foreach ($pagosAnteriores as $pagoAnterior)
                                    <tr>
                                        <td>{{$pagoAnterior->num_pago}}</td>
                                        <td>$ {{number_format($pagoAnterior->valor_pagado,0,".",".")}}</td>
                                        <td>{{$pagoAnterior->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
      
        $(".number-format").inputmask({
            alias: "currency",
            removeMaskOnSubmit: true
        });
    </script>
@stop

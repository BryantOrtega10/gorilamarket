@extends('adminlte::page')

@section('title', 'Pedidos')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('content_header')
    <div class="row">
        <div class="col-12 col-md-6">
            <h1>Pedidos</h1>
        </div>
        <div class="col-12 col-md-6 text-right">
            <a href="{{route('pago.pedidosHoy')}}" class="btn btn-outline-azul">Pedidos de hoy</a>
            <a href="{{route('pago.referidos')}}" class="btn btn-outline-azul">Generar excel referidos</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Buscar Pedido</h3>
                </div>
                <form method="POST" action="{{route('pago.verificarExistencia')}}">
                    <div class="card-body">
                        @csrf
                        <div class="form-group row">
                            <label for="id_pedido" class="col-1 col-form-label">ID Pedido</label>
                            <div class="col-4">
                                <input id="id_pedido" type="text"
                                    class="form-control @error('id_pedido') is-invalid @enderror" name="id_pedido"
                                    value="{{ old('id_pedido') }}" autocomplete="id_pedido" autofocus>
                                @error('id_pedido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-4"><button type="submit" class="btn btn-primary btn-verde">Ver Detalle</button></div>
                        </div>
                    </div>
                    
                </form>
            </div>
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
        @if (session('warning'))
            <div class="alert alert-warning">
                <strong>{{ session('warning') }}</strong>
            </div>
        @endif

    </div>
    <div class="card card-verde">
        <div class="card-header">
            <h3 class="card-title">Pedidos pendientes</h3>
        </div>
        <div class="card-body">
        <table class="table table-striped" id="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Responsable</th>
                <th>Cliente</th>
                <th>Fecha Despacho</th>
                <th>Franja horaria</th>
                <th>Medio de pago</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $pago)
                <tr>
                    <td>{{ $pago->idpago }}</td>
                    <td>{{Auth::user()->name}}</td>
                    <td>{{ $pago->cliente->nombre }} {{ $pago->cliente->apellido }}</td>
                    <td>{{ $pago->fecha_recib }}</td>
                    <td>{{ $pago->hora_cast() }}</td>
                    <td>{{ ucfirst($pago->tipo_pago) }}</td>
                    <td>${{ number_format($pago->valor,0) }}</td>
                    <td>{{ strtoupper($pago->estado) }}</td>
                    <td data-priority="0" style="white-space: nowrap">
                        <a href="{{ route('pago.detalles', ['id' => $pago->idpago]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('pago.c_estado', ['id' => $pago->idpago]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></a>
                        <a href="{{ route('pago.estados', ['id' => $pago->idpago]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Historial de estados"><i class="fas fa-history"></i></a>
                        <a href="{{ route('pago.domiciliario', ['id' => $pago->idpago]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Asignar domiciliario"><i class="fas fa-truck"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
        $('#tabla').DataTable({
            responsive: true,
            order: [
                [0, 'asc']
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json'
            }
        });
        $('#tabla').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $("#formulario_busc").submit(function(e){
            e.preventDefault();
            window.open(`/pedidos/${$("#id_pedido").val()}/detalles`,'_self');

        })
       
    </script>

@stop

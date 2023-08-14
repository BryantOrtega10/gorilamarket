@extends('adminlte::page')

@section('title', 'Clientes')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('content_header')
    <div class="row">
        <div class="col-12 col-md-6">
            <h1>Clientes</h1>
        </div>
        <div class="col-12 col-md-6 text-right">
            <a href="{{route('cliente.reporteClientes')}}" class="btn btn-outline-azul">Reporte Clientes</a>
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
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th># de Pedidos Entregados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->apellido }}</td>
                            <td>{{ $cliente->celular }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->no_pedidos }}</td>
                            <td data-priority="0" style="white-space: nowrap">
                                @if ($cliente->estado == '1')
                                <a href="{{ route('cliente.cambiarEstado', ['id' => $cliente->idcliente]) }}" class="btn btn-verde"
                                    data-toggle="tooltip" data-placement="top" title="Bloquear usuario"><i class="fas fa-lock"></i></a>                                    
                                @else
                                <a href="{{ route('cliente.cambiarEstado', ['id' => $cliente->idcliente]) }}" class="btn btn-verde"
                                    data-toggle="tooltip" data-placement="top" title="Desbloquear usuario"><i class="fas fa-unlock"></i></a>
                                @endif
                                <a href="{{ route('cliente.historial', ['id' => $cliente->idcliente]) }}" class="btn btn-verde"
                                    data-toggle="tooltip" data-placement="top" title="Historial de pedidos"><i class="fas fa-history"></i></a>
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
                [2, 'asc']
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json'
            }
        });
        $('#tabla').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $("body").on("click", ".eliminar", function(e) {
            e.preventDefault();
            const link = $(this).attr("href");
            Swal.fire({
                title: '<b>Eliminar Publicidad</b>',
                type: 'warning',
                text: 'En verdad desea eliminar esta publicidad?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: 'var(--color-verde)'
            }).then((result) => {
                if (result.value) {
                    window.open(link, '_self');
                }
            });
        });
    </script>

@stop

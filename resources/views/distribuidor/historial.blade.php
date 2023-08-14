@extends('adminlte::page')

@section('title', 'Historial de pedidos')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('content_header')
    <h1>Historial de pedidos</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('distribuidor.tabla') }}" class="color-azul">Distribuidores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Historial de pedidos</li>
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

    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Tipo de pago</th>
                        <th>Dirección</th>
                        <th>Valor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $pago->fecha_recib }}</td>
                            <td>{{ $pago->hora_cast() }}</td>
                            <td>{{ ucfirst($pago->tipo_pago) }}</td>
                            <td>{{ $pago->direccion_r->direccionCompleta }}</td>
                            <td>${{ number_format($pago->valor, 0, '.', '.') }}</td>
                            <td data-priority="0" style="white-space: nowrap">
                                <a href="{{ route('distribuidor.verPago', ['idCliente' => $cliente->idcliente, 'idPago' => $pago->idpago]) }}"
                                    class="btn btn-verde" data-toggle="tooltip" data-placement="top" title="Ver detalle"><i
                                        class="fas fa-eye"></i></a>
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

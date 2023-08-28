@extends('adminlte::page')

@section('title', 'Reclutadores')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Reclutadores</h1>
        </div>
        <div class="col-12 col-md-4 text-right">
            <a href="{{ route('reclutador.agregar') }}" class="btn btn-outline-azul">Agregar Reclutador</a>
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
                <th>Valor Pagado</th>
                <th>Saldo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reclutadores as $reclutador)
                <tr>
                    <td>{{ $reclutador->nombre }}</td>
                    <td>{{ $reclutador->apellido }}</td>
                    <td>{{ $reclutador->celular }}</td>
                    <td>{{ $reclutador->email }}</td>
                    <td>$ {{ number_format($reclutador->valor_pagado,0,".",".") }}</td>
                    <td>$ {{ number_format(($reclutador->valor_recaudado - $reclutador->valor_pagado),0,".",".") }}</td>
                    <td data-priority="0" style="white-space: nowrap">
                        <a href="{{ route('reclutador.modificar', ['id' => $reclutador->id_reclutador]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                        @if ($reclutador->estado == 1)
                            <a href="{{ route('reclutador.cambiarEs', ['id' => $reclutador->id_reclutador]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Bloquear"><i class="fas fa-lock"></i></a>    
                        @else
                            <a href="{{ route('reclutador.cambiarEs', ['id' => $reclutador->id_reclutador]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Desbloquear"><i class="fas fa-unlock"></i></a>    
                        @endif
                        <a href="{{ route('reclutador.pago', ['id' => $reclutador->id_reclutador]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Realizar pago"><i class="fas fa-money-bill"></i></a>
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

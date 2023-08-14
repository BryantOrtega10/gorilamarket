@extends('adminlte::page')

@section('title', 'Promociones')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Promociones</h1>
        </div>
        <div class="col-12 col-md-4 text-right">
            <a href="{{ route('promocion.agregar') }}" class="btn btn-outline-azul">Agregar Promoción</a>
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
    <table class="table table-striped" id="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Porcentaje</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promociones as $promocion)
                <tr>
                    <td>{{ $promocion->idpromociones }}</td>
                    <td>{{ $promocion->producto->nombre }}</td>
                    <td>{{ $promocion->porcentaje }}</td>
                    <td>{{ $promocion->fecha_inicio }}</td>
                    <td>{{ $promocion->fecha_fin }}</td>
                    <td data-priority="0" style="white-space: nowrap">
                        <a href="{{ route('promocion.modificar', ['id' => $promocion->idpromociones]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="{{route('promocion.eliminar', ['id' => $promocion->idpromociones])}}" class="btn btn-danger eliminar" data-toggle="tooltip" data-placement="top"
                            title="Eliminar"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
                [1, 'asc']
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json'
            }
        });
        $('#tabla').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $("body").on("click",".eliminar",function(e){
            e.preventDefault();
            const link = $(this).attr("href");
            Swal.fire({
                title: '<b>Eliminar Promoción</b>',
                type: 'warning',
                text: 'En verdad desea eliminar esta promoción?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: 'var(--color-verde)'
            }).then((result) => {
                if (result.value) {
                    window.open(link,'_self');
                }
            });
        });
    </script>

@stop

@extends('adminlte::page')

@section('title', 'Publicidad')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Publicidad</h1>
        </div>
        <div class="col-12 col-md-4 text-right">
            <a href="{{ route('publicidad.agregar') }}" class="btn btn-outline-azul">Agregar Publicidad</a>
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
                <th>Imagen</th>
                <th>Producto</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publicidades as $publicidad)
                <tr>
                    <td>{{ $publicidad->idpublicidad }}</td>
                    <td><img src="{{ Storage::url('imagenes_p/min_' . $publicidad->imagen) }}" /></td>
                    <td>{{ $publicidad->link }}</td>
                    <td>{{ $publicidad->tipo }}</td>
                    <td data-priority="0" style="white-space: nowrap">
                        <a href="{{ route('publicidad.modificar', ['id' => $publicidad->idpublicidad]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="{{route('publicidad.eliminar', ['id' => $publicidad->idpublicidad])}}" class="btn btn-danger eliminar" data-toggle="tooltip" data-placement="top"
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
                [2, 'asc']
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
                    window.open(link,'_self');
                }
            });
        });
    </script>

@stop

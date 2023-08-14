@extends('adminlte::page')

@section('title', 'Productos')

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Productos</h1>
        </div>
        <div class="col-12 col-md-4 text-right">
            <a href="{{ route('producto.masivo') }}" class="btn btn-outline-azul">Cargue Masivo</a>
            <a href="{{ route('producto.agregar') }}" class="btn btn-outline-azul">Agregar Producto</a>
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
                <th>Cod. Barras</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Precio Distribuidor</th>
                <th>Und. Medida</th>
                <th>Estado</th>
                <th>Orden</th>
                <th>Categoria</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->idproducto }}</td>
                    <td>{{ $producto->cd_barras }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 0) }}</td>
                    <td>${{ number_format($producto->precioDist, 0) }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->visible }}</td>
                    <td>{{ $producto->orden }}</td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td data-priority="0" style="white-space: nowrap">
                        <a href="{{ route('producto.modificar', ['id' => $producto->idproducto]) }}" class="btn btn-verde"
                            data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="{{route('producto.fotos', ['id' => $producto->idproducto])}}" class="btn btn-verde" data-toggle="tooltip" data-placement="top"
                            title="Editar Fotos"><i class="fas fa-images"></i></a>
                        <a href="{{route('producto.eliminar', ['id' => $producto->idproducto])}}" class="btn btn-danger eliminar" data-toggle="tooltip" data-placement="top"
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
                title: '<b>Eliminar Producto</b>',
                type: 'warning',
                text: 'En verdad desea eliminar este producto?',
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

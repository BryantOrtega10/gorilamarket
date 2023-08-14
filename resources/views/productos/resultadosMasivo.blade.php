@extends('adminlte::page')

@section('title', 'Agregar producto desde CSV')

@section('plugins.JQueryNumberFormat', true)


@section('content_header')
    <h1>Agregar Producto desde CSV</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('producto.tabla') }}" class="color-azul">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar desde CSV</li>
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
                    <h1>Resultados de la subida</h1>
                    <ol>
                    @forelse ($resultados as $resultado)
                        <li>{{$resultado}}</li>
                    @empty
                        <li>No se encontraron datos</li>
                    @endforelse
                    </ol>
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
        
        $('#archivoCSV').on('change', function() {
            const nombre = $(this).val();
            const inp = $(this)[0];
            let textoHtml = '';
            for (let i = 0; i < inp.files.length; ++i) {
                const name = inp.files.item(i).name;
                textoHtml += name + ", ";
            }
            textoHtml = textoHtml.slice(0, textoHtml.length - 2)
            $(this).next('.custom-file-label').html(textoHtml);
        })
    </script>
@stop

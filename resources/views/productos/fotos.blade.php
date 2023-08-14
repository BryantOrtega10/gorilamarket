@extends('adminlte::page')

@section('title', 'Fotos')

@section('plugins.JQueryUI', true)
@section('plugins.Dropzone', true)

@section('content_header')
    <h1>Fotos</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('producto.tabla') }}" class="color-azul">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Fotos</li>
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
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Arrastra las imagenes para cambiar el orden</h3>
                    </div>
                    <form id="fotos" action="" method="post">
                        @csrf
                        <div class="card-body">
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="seleccionar" id="seleccionar">
                                    <label class="form-check-label" for="seleccionar">Seleccionar Todos</label>
                                </div>
                            </div>
                            <br>
                            <ul id="sortable">
                                @foreach ($fotos as $foto)
                                    <li class="ui-state-default" id="sub_{{ $foto->idfotos }}">
                                        <span class="posicion">{{ $foto->orden }}</span>
                                        <div class="conte_int"><img
                                                src="{{ Storage::url('productos/min_' . $foto->ruta) }}" />
                                        </div>
                                        <div class="ubica">
                                            <input type="checkbox" class="check_ing" name="fotos_select[]"
                                                id="img_check_{{ $foto->idfotos }}" value="{{ $foto->idfotos }}">
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <button type="button" id="eliminar_s" class="btn btn-outline-danger">Eliminar seleccionados</button>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" id="actualizar_o" class="btn btn-verde">Actualizar Orden</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card my-4">
                    <div class="card-header">
                        <h3 class="card-title">Arrastra fotos o has click en la caja para buscar archivos</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('producto.fotos.agregar',['id' => $idproducto])}}" class="dropzone" id="dropzone" method="POST" enctype="multipart/form-data">
                            @csrf
                        </form>
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
            let dropzone_1 = new Dropzone("#dropzone", {
                dictDefaultMessage: "Arrastra imagenes aquí para subirlas",
                acceptedFiles: 'image/*'
            });
            Dropzone.autoDiscover = false;

            dropzone_1.on("success", function(file, response) {
                console.log(file);
                console.log(response);
                if(response.success){
                    $("#sortable").append(`<li class="ui-state-default" id="sub_${response.foto.idfotos}">
                                        <span class="posicion">${response.foto.orden}</span>
                                        <div class="conte_int"><img
                                                src="${response.foto.ruta}" />
                                        </div>
                                        <div class="ubica">
                                            <input type="checkbox" class="check_ing" name="fotos_select[]"
                                                id="img_check_${response.foto.idfotos}" value="${response.foto.idfotos}">
                                        </div>
                                    </li>`);
                }
            });

            $(document).ready(function(e) {
                $("#sortable").sortable({
                    placeholder: "ui-state-highlight"
                });
                $("#sortable").on("sortbeforestop", function(event, ui) {
                    $(".posicion").each(function(index, element) {
                        $(element).html("");
                    });
                    let i = 1;
                    $(".posicion").each(function(index, element) {
                        $(element).html(i);
                        i++;
                    });

                });
                $("#seleccionar").change(function() {
                    if ($(this).is(':checked')) {
                        $(".check_ing").each(function(index, element) {
                            $(element).prop("checked", true);
                        });
                    } else {
                        $(".check_ing").each(function(index, element) {
                            $(element).prop("checked", false);
                        });
                    }
                });
                $("#eliminar_s").click(function(e){
                    e.preventDefault();
                    $("#fotos").prop("action","{{route('producto.fotos.eliminar',['id' => $idproducto])}}")
                    $("#fotos").submit();
                });
                $("#actualizar_o").click(function(e){
                    e.preventDefault();
                    $("#fotos").prop("action","{{route('producto.fotos.actualizar',['id' => $idproducto])}}")
                    const sorted = $("#sortable").sortable( "toArray" );
                    let mensaje = "";
                    sorted.forEach(function(entry) {
                        mensaje=mensaje+'<input type="hidden" value="'+entry.substring(4)+'" name="orden[]" />';
                    });
                    $(this).after(mensaje);
                    $("#fotos").submit();
                });
            });
        </script>
    @stop

@extends('adminlte::page')

@section('title', 'Configuración')

@section('plugins.JQueryUI', true)

@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Orden Despacho</h1>
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
    <div class="row">
        <div class="col-12">
            <div class="card card-verde">
                <form id="despacho" action="" method="post">
                    @csrf
                    <div class="card-body">
                        <ul id="sortable_cats">
                            @foreach ($categorias as $categoria)
                                <li class="ui-state-default" id="sub_{{ $categoria->orden_cat }}">
                                    <div class="row align-items-center">
                                        <div class="col-2 d-flex justify-content-center ">
                                            <span class="posicion_cat">{{ $categoria->orden_cat + 1 }}</span>
                                        </div>
                                        <div class="col-10">
                                            <b>{{ $categoria->categoria_superior->nombre }}</b><br>
                                            {{ $categoria->nombre }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="idcategorias[]" value="{{ $categoria->idcategorias }}" />
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-12 text-right">
                                <button type="button" id="actualizar_o" class="btn btn-verde">Actualizar Orden</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
        $(document).ready(function(e) {
            $("#sortable_cats").sortable({
                placeholder: "ui-state-highlight"
            });
            $("#sortable_cats").on("sortbeforestop", function(event, ui) {
                $(".posicion_cat").each(function(index, element) {
                    $(element).html("");
                });
                let i = 1;
                $(".posicion_cat").each(function(index, element) {
                    $(element).html(i);
                    i++;
                });

            });
            $("#actualizar_o").click(function(e) {
                e.preventDefault();
                $("#despacho").prop("action", "{{ route('despacho.orden') }}")
                const sorted = $("#sortable_cats").sortable("toArray");
                let mensaje = "";
                let cuenta = 0;
                sorted.forEach(function(entry) {
                    mensaje = mensaje + '<input type="hidden" value="' + cuenta +
                        '" name="orden[]" />';
                    cuenta++;
                });
                $(this).after(mensaje);
                $("#despacho").submit();
            });
        });
    </script>

@stop

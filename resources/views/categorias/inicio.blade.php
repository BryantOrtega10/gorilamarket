@extends('adminlte::page')

@section('title', 'Categorias')

@section('plugins.Sweetalert2', true)


@section('content_header')
    <h1>Categorias</h1>
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
            <div class="col-4">
                <ul id="categorias" data-widget="treeview">
                    @foreach ($categorias as $categoria)
                        @if (sizeof($categoria->sub_categorias) > 0)
                            <li class="nav-item">
                                <a href="{{ route('categoria.modificar', ['id' => $categoria->idcategorias]) }}"
                                    class="nav-link modificar-cat"
                                    data-id="{{ $categoria->idcategorias }}">{{ $categoria->nombre }}</a>
                                <ul class="nav-treeview">
                                    @foreach ($categoria->sub_categorias as $sub_categoria)
                                        <li><a href="{{ route('categoria.modificar', ['id' => $sub_categoria->idcategorias]) }}"
                                                class="modificar-cat">{{ $sub_categoria->nombre }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ route('categoria.modificar', ['id' => $categoria->idcategorias]) }}"
                                    class="modificar-cat">
                                    {{ $categoria->nombre }}
                                </a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-2"></div>
            <div class="col-6">
                <div class="card card-verde">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Categoria</h3>
                    </div>
                    <form method="POST" action="{{ route('categoria.agregar') }}">
                        <div class="card-body">
                            @csrf
                            <div class="form-group row ">
                                <label for="nombre" class="col-4 col-form-label">Nombre</label>
                                <div class="col">
                                    <input id="nombre" type="text"
                                        class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                        value="{{ old('nombre') }}" autocomplete="nombre" autofocus>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label for="tipo" class="col-4 col-form-label">Tipo</label>
                                <div class="col">
                                    <select id="tipo" class="form-control @error('tipo') is-invalid @enderror"
                                        name="tipo">
                                        <option value="1" @if (old('tipo') == '1') selected @endif>Categoria
                                            Superior</option>
                                        <option value="2" @if (old('tipo') == '2') selected @endif>Categoria
                                            Inferior</option>
                                    </select>
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @if (old('tipo') != '2') d-none @endif" id="cat_general">
                                <label for="padre_gen" class="col-4 col-form-label">Categoria General</label>
                                <div class="col">
                                    <select id="padre_gen" class="form-control @error('padre_gen') is-invalid @enderror"
                                        name="padre_gen">
                                        <option value="" class="d-none">Seleccione</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->idcategorias }}"
                                                @if (old('padre_gen') == $categoria->idcategorias) selected @endif>{{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('padre_gen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-verde">Agregar</button>
                        </div>
                    </form>
                </div>
                <div id="modificar-categoria">
                    @if (old('m_idcategorias') !== null)
                        @include('categorias.ajax.modificar')
                    @endif
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
        $('ul#categorias').Treeview();
        $(document).ready(function(e) {
            $("#tipo").change(function(e) {
                if ($(this).val() == "2") {
                    $("#cat_general").removeClass("d-none");
                } else {
                    $("#cat_general").addClass("d-none");
                }
            });
            $("body").on("change", "#m_tipo", function(e) {
                if ($(this).val() == "2") {
                    $("#m_cat_general").removeClass("d-none");
                } else {
                    $("#m_cat_general").addClass("d-none");
                }
            });
            $("body").on("click", "#eliminar", function(e) {
                e.preventDefault();
                const link = $(this).prop("href");
                Swal.fire({
                    title: '<b>Eliminar Categoria</b>',
                    type: 'warning',
                    text: 'En verdad desea eliminar esta categoria?',
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

            $(".modificar-cat").click(function(e) {
                e.preventDefault();
                $.ajax({
                        url: $(this).prop("href"),
                        cache: false
                    })
                    .done(function(html) {
                        $("#modificar-categoria").html(html);
                    });
            });
        });
    </script>

@stop

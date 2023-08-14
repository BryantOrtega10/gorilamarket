@extends('adminlte::page')

@section('title', 'Modificar producto')

@section('plugins.JQueryNumberFormat', true)


@section('content_header')
    <h1>Modificar Producto</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('producto.tabla') }}" class="color-azul">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modificar</li>
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
                    <form method="POST" action="{{ route('producto.modificar',['id' => $producto->idproducto]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="cd_barras" class="form-label">Código de barras</label>
                                        <input id="cd_barras" type="text"
                                            class="form-control @error('cd_barras') is-invalid @enderror" name="cd_barras"
                                            value="{{ old('cd_barras',$producto->cd_barras) }}" autocomplete="cd_barras" autofocus>
                                        @error('cd_barras')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input id="nombre" type="text"
                                            class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                            value="{{ old('nombre',$producto->nombre) }}" autocomplete="nombre" autofocus>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="precio" class="form-label">Precio</label>
                                        <input id="precio" type="text"
                                            class="form-control number-format @error('precio') is-invalid @enderror"
                                            name="precio" value="{{ old('precio',$producto->precio) }}" autocomplete="precio" autofocus>
                                        @error('precio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="precioDist" class="form-label">Precio Distribuidor</label>
                                        <input id="precioDist" type="text"
                                            class="form-control number-format @error('precioDist') is-invalid @enderror"
                                            name="precioDist" value="{{ old('precioDist',$producto->precioDist) }}" autocomplete="precioDist" autofocus>
                                        @error('precioDist')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="unidades" class="form-label">Unidades</label>
                                        <input id="unidades" type="number" min="0"
                                            class="form-control @error('unidades') is-invalid @enderror" name="unidades"
                                            value="{{ old('unidades',$producto->unidades) }}" autocomplete="unidades" autofocus>
                                        @error('unidades')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="descripcion" class="form-label">Unidad de Medida</label>
                                        <input id="descripcion" type="text"
                                            class="form-control @error('descripcion') is-invalid @enderror"
                                            name="descripcion" value="{{ old('descripcion',$producto->descripcion) }}" autocomplete="descripcion"
                                            autofocus>
                                        @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="destacado" class="form-label">Producto sugerido?</label>
                                        <select id="destacado" class="form-control @error('destacado') is-invalid @enderror"
                                            name="destacado">
                                            <option value="0" @if (old('destacado',$producto->destacado) == '0') selected @endif>NO
                                            </option>
                                            <option value="1" @if (old('destacado',$producto->destacado) == '1') selected @endif>SI
                                            </option>
                                        </select>
                                        @error('destacado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="cat_sup" class="form-label">Categoria General</label>
                                        <select id="cat_sup" class="form-control @error('cat_sup') is-invalid @enderror"
                                            name="cat_sup">
                                            <option value="" class="d-none">Seleccione</option>
                                            @foreach ($categorias as $categoria)                                            
                                                <option value="{{ $categoria->idcategorias }}"
                                                    @if (old('cat_sup',$producto->categoria->categoria_superior->idcategorias) == $categoria->idcategorias) selected @endif>
                                                    {{ $categoria->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cat_sup')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="fk_categorias" class="form-label">Sub Categoria</label>
                                        <select id="fk_categorias"
                                            class="form-control @error('fk_categorias') is-invalid @enderror" 
                                            @if (sizeof($sub_categorias) == 0)
                                                disabled
                                            @endif
                                            name="fk_categorias">
                                            <option value="" class="d-none">Seleccione</option>
                                            @foreach ($sub_categorias as $sub_categoria)
                                                <option value="{{ $sub_categoria->idcategorias }}"
                                                    @if (old('fk_categorias',$producto->fk_categorias) == $sub_categoria->idcategorias) selected @endif>
                                                    {{ $categoria->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fk_categorias')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="orden" class="form-label">Orden</label>
                                        <input id="orden" type="number" max="999" min="0"
                                            class="form-control @error('orden') is-invalid @enderror" name="orden"
                                            value="{{ old('orden', $producto->orden) }}" autocomplete="orden" autofocus>
                                        @error('orden')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="visible" class="form-label">Estado</label>
                                        <select id="visible" class="form-control @error('visible') is-invalid @enderror"
                                            name="visible">
                                            <option value="1" @if(old('visible', $producto->visible) == "Visible") selected @endif>Visible</option>
                                            <option value="0" @if(old('visible', $producto->visible) == "Oculto") selected @endif >Oculto</option>
                                        </select>
                                        @error('cat_sup')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-verde">Modificar</button>
                        </div>
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
        $("#cat_sup").change(function(e){
            e.preventDefault();
            $("#fk_categorias").html('<option value="" class="d-none">Seleccione</option>');
            $("#fk_categorias").prop("disabled",false);
            $.ajax({
                url: `{{route('categoria.sub-categorias')}}/${$(this).val()}`,
                cache: false
            })
            .done(function(data) {               
                data["sub_categorias"].forEach(element => {                    
                    $("#fk_categorias").append(`<option value="${element["idcategorias"]}">${element["nombre"]}</option>`);
                });
            });
            
        });
        $(".number-format").inputmask({
            alias: "currency",
            removeMaskOnSubmit: true
        });
        $('#fotos').on('change', function() {
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

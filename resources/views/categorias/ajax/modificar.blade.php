<div class="card card-verde my-4">
    <div class="card-header">
        <h3 class="card-title">Modificar Categoria</h3>
    </div>
    <form method="POST" action="{{ route('categoria.modificar', ['id' => $categoria_s->idcategorias]) }}" enctype="multipart/form-data">
        <div class="card-body">
            @csrf
            <input type="hidden" name="m_idcategorias" value="{{ $categoria_s->idcategorias }}" />
            <div class="form-group row ">
                <label for="m_nombre" class="col-4 col-form-label">Nombre</label>
                <div class="col">
                    <input id="m_nombre" type="text" class="form-control @error('m_nombre') is-invalid @enderror"
                        name="m_nombre" value="{{ old('m_nombre', $categoria_s->nombre) }}" autocomplete="m_nombre"
                        autofocus>
                    @error('m_nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row ">
                <label for="m_tipo" class="col-4 col-form-label">Tipo</label>
                <div class="col">
                    <select id="m_tipo" class="form-control @error('m_tipo') is-invalid @enderror" name="m_tipo">
                        <option value="1" @if (old('m_tipo', $categoria_s->tipo) == '1') selected @endif>Categoria Superior
                        </option>
                        <option value="2" @if (old('m_tipo', $categoria_s->tipo) == '2') selected @endif>Categoria Inferior
                        </option>
                    </select>
                    @error('m_tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row @if (old('m_tipo', $categoria_s->tipo) != '2') d-none @endif" id="m_cat_general">
                <label for="m_padre_gen" class="col-4 col-form-label">Categoria General</label>
                <div class="col">
                    <select id="m_padre_gen" class="form-control @error('m_padre_gen') is-invalid @enderror"
                        name="m_padre_gen">
                        <option value="" class="d-none">Seleccione</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->idcategorias }}"
                                @if (old('m_padre_gen', $categoria_s->id_categoria_sup) == $categoria->idcategorias) selected @endif>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    @error('m_padre_gen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <span class="@if (old('m_tipo', $categoria_s->tipo) != '1') d-none @endif">No seleccionar ningun archivo para no modificar el icono</span> 
            <div class="form-group row @if (old('m_tipo', $categoria_s->tipo) != '1') d-none @endif" id="m_foto">
                <label for="m_foto" class="col-4 col-form-label">Icono</label>
                <div class="col">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="m_foto" id="m_foto" accept="image/*">
                        <label class="custom-file-label" for="m_foto">Selecciona la imagen</label>
                    </div>
                    @error('m_foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('categoria.eliminar', ['id' => $categoria_s->idcategorias]) }}" type="button"
                id="eliminar" class="btn btn-azul">Eliminar</a>

                <button type="submit" class="btn btn-verde">Modificar</button>
        </div>
    </form>
</div>

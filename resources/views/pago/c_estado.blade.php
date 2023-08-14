@extends('adminlte::page')

@section('title', 'Cambiar estado')

@section('content_header')
    <h1>Cambiar estado de pedido #{{ $pago->idpago }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pago.tabla') }}" class="color-azul">Pedidos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cambiar estado</li>
        </ol>
    </nav>


@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-verde">
                <form method="POST" action="{{ route('pago.c_estado', ['id' => $pago->idpago]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">                            
                            <div class="col-12 col-md-4 col-xl-3">
                                <div>
                                    <b>Estado Actual:</b><br>
                                    <span>{{$ultimoEstado->estado ?? ""}}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-9 col-xl-9">
                                <div>
                                    <b>Descripción Actual:</b><br>
                                    <span>{{$ultimoEstado->descripcion ?? ""}}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-xl-3">
                                <div class="form-group">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select id="estado" class="form-control @error('estado') is-invalid @enderror"
                                        name="estado">
                                        <option value="RECIBIDO">RECIBIDO</option>
                                        <option value="ALISTAMIENTO">ALISTAMIENTO</option>
                                        <option value="EN CAMINO">EN CAMINO</option>
                                        <option value="ENTREGADO">ENTREGADO</option>
                                        <option value="CANCELADO">CANCELADO</option>                                        
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-xl-3">
                                <div class="form-group">
                                    <label for="tipo_pago" class="form-label">Tipo de pago</label>
                                    <select id="tipo_pago" class="form-control @error('tipo_pago') is-invalid @enderror"
                                        name="tipo_pago">
                                        <option value="efectivo" @if ($pago->tipo_pago == "efectivo") selected @endif>Efectivo</option>
                                        <option value="datafono" @if ($pago->tipo_pago == "datafono") selected @endif>Datafono</option>
                                    </select>
                                    @error('tipo_pago')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descripcion" class="form-label">Descripción:</label>
                                    <textarea name="descripcion" rows="5" id="descripcion" class="form-control"></textarea>
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-verde">Actualizar Estado</button>
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
        $('#imagen').on('change', function() {
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

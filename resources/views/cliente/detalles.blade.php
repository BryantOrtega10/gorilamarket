@extends('adminlte::page')

@section('title', 'Detalle de pedido')

@section('content_header')
    <h1>Detalle de pedido {{$pago->idpago}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cliente.tabla') }}" class="color-azul">Clientes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cliente.historial',['id' => $idCliente]) }}" class="color-azul">Historial</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver Detalle</li>
        </ol>
    
@stop

@section('content')
    <div class="card card-verde">
        <div class="card-body">
            <div class="col-12 col-md-6">
                <a href="{{route('pago.imprimir',['id' => $pago->idpago])}}" target="_blank" class="btn btn-outline-azul">Imprimir</a>
                <a href="{{route('pago.generarXLS',['id' => $pago->idpago])}}" target="_blank" class="btn btn-outline-azul">Generar archivo XLS</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Datos Pedido</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12"><b>Observaciones Domiciliario:</b> {{$pago->ultima_observacion}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><b>Total:</b> <br> ${{number_format($pago->valor + $pago->descuento - $pago->csto_Dom,0,'.','.')}}</div>
                        <div class="col"><b>Domicilio:</b> <br> ${{number_format($pago->csto_Dom,0,'.','.')}}</div>
                        @if ($pago->cd_referido != "")
                            <div class="col"><b>Descuento:</b> <br> ${{number_format($pago->descuento,0,'.','.')}}</div>
                            <div class="col"><b>Valor a pagar:</b> <br> ${{number_format($pago->valor,0,'.','.')}}</div>
                            <div class="col"><b>Código Referido:</b> <br> {{$pago->cd_referido}}</div>
                        @else
                            <div class="col"><b>Valor a pagar:</b> <br> ${{number_format($pago->valor,0,'.','.')}}</div>
                        @endif                        
                        <div class="col"><b>Tipo Pago:</b> <br> {{ucfirst($pago->tipo_pago)}}</div>
                    </div>
                    <div class="row my-4">
                        <div class="col"><b>Fecha Entrega:</b> {{$pago->fecha_recib}}</div>
                        <div class="col"><b>Hora Entrega:</b> {{$pago->hora_cast()}}</div>
                        <div class="col"><b>Dirección:</b> {{$pago->direccion}}</div>
                        <div class="col"><b>Plataforma:</b> {{$pago->plataforma}}</div>
                    </div>
                </div>
            </div>
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"><b>Nombre:</b> {{$pago->cliente->nombre}}</div>
                        <div class="col-4"><b>Apellido:</b> {{$pago->cliente->apellido}}</div>
                    </div>
                    <div class="row">
                        <div class="col-3"><b>Celular:</b> {{$pago->cliente->celular}}</div>
                        <div class="col-4"><b>Email:</b> {{$pago->cliente->email}}</div>
                    </div>                    
                </div>
            </div>
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Productos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tabla">
                        <thead>
                            <tr>
                                <th>Código Barras</th>
                                <th>Nombre</th>
                                <th>Und. Medida</th>
                                <th>Cantidad</th>
                                <th>Precio mostrado</th>
                                <th>Aplicó Promoción?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{$producto->cd_barras}}</td>
                                    <td>{{$producto->nombre}}</td>
                                    <td>{{$producto->descripcion}}</td>
                                    <td>{{$producto->cantidad}}</td>
                                    <td>${{number_format($producto->precioMos,0,'.','.')}}</td>
                                    <td>{{($producto->apPromocion == '1' ? 'SI' : 'NO')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

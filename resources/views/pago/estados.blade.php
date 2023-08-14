@extends('adminlte::page')

@section('title', 'Historial de estados')

@section('content_header')
    <h1>Historial de estados del pedido # {{$pago->idpago}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pago.tabla') }}" class="color-azul">Pedidos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Historial de estados</li>
        </ol>
    </nav>
   
    
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-verde">
                <div class="card-header">
                    <h3 class="card-title">Historial de estados</h3>
                </div>
                <div class="card-body">
                    @forelse ($estados as $estado)
                        <div class="row p-3 row-stripped">
                            <div class="col-10">
                                <b>Estado:</b> {{$estado->estado}}<br>
                                <b>Descripcion:</b> {{$estado->descripcion}}
                            </div>
                            <div class="col-2 text-right">{{substr($estado->fecha_sistema,0,10)}}<br>{{substr($estado->fecha_sistema,11,5)}}</div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-12">
                                No hay cambios de estado registrados
                            </div>                        
                        </div>
                    @endforelse
                    
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
        
    </script>
@stop

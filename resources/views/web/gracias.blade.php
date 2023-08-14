@extends('layouts.web_sin_cat')

@section('title')
    Gracias
@endsection

@section('content')
    <div class="container text-center gracias">
        <div class="row">
            <div class="col-12 py-5">
                <img src="{{asset('img/web/logo_gracias.png')}}" />
            </div>
            <div class="col-12">
                <h2>¡Gracias!</h2>
                <p>Gracias por comprar en Gorilla Market, siempre buscaremos brindarte los mejores precios y el mejor servicio !Esperamos volver a verte pronto!</p>
                <a href="{{route('web.index')}}" class="btn btn-verde">
                    Seguir comprando
                </a>
            </div>
        </div>
    </div>
@endsection

